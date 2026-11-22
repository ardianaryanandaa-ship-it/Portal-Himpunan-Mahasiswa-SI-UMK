<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;
use Throwable;

class MergeGalleryItemsIntoGalleries extends Migration
{
    private const MEDIA_FIELDS = [
        'record_type' => [
            'type' => 'VARCHAR',
            'constraint' => 20,
            'default' => 'album',
        ],
        'parent_id' => [
            'type' => 'INT',
            'constraint' => 10,
            'unsigned' => true,
            'null' => true,
        ],
        'media_type' => [
            'type' => 'VARCHAR',
            'constraint' => 20,
            'null' => true,
        ],
        'file_path' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
        ],
        'caption' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
            'null' => true,
        ],
        'sort_order' => [
            'type' => 'INT',
            'constraint' => 10,
            'unsigned' => true,
            'default' => 0,
        ],
    ];

    public function up()
    {
        if (! $this->db->tableExists('galleries') || ! $this->db->tableExists('gallery_items')) {
            throw new RuntimeException('Tabel Galeri yang diperlukan tidak ditemukan; pemindahan dibatalkan.');
        }

        foreach (self::MEDIA_FIELDS as $field => $definition) {
            if (! $this->db->fieldExists($field, 'galleries')) {
                $this->forge->addColumn('galleries', [$field => $definition]);
            }
        }

        $existingMediaCount = $this->db->table('galleries')
            ->where('record_type', 'media')
            ->countAllResults();
        if ($existingMediaCount > 0) {
            throw new RuntimeException('Tabel galleries sudah berisi media; pemindahan dibatalkan untuk menghindari duplikasi.');
        }

        $oldItems = $this->db->table('gallery_items')
            ->orderBy('gallery_id', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
        $albums = [];
        if ($oldItems !== []) {
            $albumIds = array_values(array_unique(array_column($oldItems, 'gallery_id')));
            $albumRows = $this->db->table('galleries')
                ->select('id, is_published')
                ->where('record_type', 'album')
                ->whereIn('id', $albumIds)
                ->get()
                ->getResultArray();

            foreach ($albumRows as $album) {
                $albums[(int) $album['id']] = $album;
            }
        }

        $records = [];
        foreach ($oldItems as $item) {
            $albumId = (int) $item['gallery_id'];
            if (! isset($albums[$albumId])) {
                throw new RuntimeException('Album tujuan media tidak ditemukan: ' . $albumId);
            }

            $records[] = [
                'record_type' => 'media',
                'parent_id' => $albumId,
                'title' => 'Media ' . $item['id'],
                'slug' => 'media-' . $albumId . '-' . $item['id'],
                'description' => null,
                'cover_image' => null,
                'event_date' => null,
                'is_published' => $albums[$albumId]['is_published'],
                'media_type' => $item['media_type'],
                'file_path' => $item['file_path'],
                'caption' => $item['caption'],
                'sort_order' => $item['sort_order'],
                'created_at' => $item['created_at'],
                'updated_at' => null,
                'deleted_at' => null,
            ];
        }

        if ($records !== []) {
            $this->db->transBegin();
            try {
                $this->db->table('galleries')->insertBatch($records);
                if (! $this->db->transStatus()) {
                    throw new RuntimeException('Gagal memindahkan foto dan video ke tabel galleries.');
                }
                $this->db->transCommit();
            } catch (Throwable $exception) {
                $this->db->transRollback();
                throw $exception;
            }
        }

        $this->forge->dropTable('gallery_items', true);
    }

    public function down()
    {
        if ($this->db->tableExists('gallery_items')) {
            throw new RuntimeException('Tabel gallery_items sudah ada; pemulihan otomatis dibatalkan.');
        }

        $this->createGalleryItemsTable();

        $media = $this->db->table('galleries')
            ->where('record_type', 'media')
            ->orderBy('parent_id', 'ASC')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
        $records = [];
        foreach ($media as $item) {
            $records[] = [
                'gallery_id' => $item['parent_id'],
                'media_type' => $item['media_type'],
                'file_path' => $item['file_path'],
                'caption' => $item['caption'],
                'sort_order' => $item['sort_order'],
                'created_at' => $item['created_at'],
            ];
        }

        if ($records !== []) {
            $this->db->table('gallery_items')->insertBatch($records);
        }
        $this->db->table('galleries')->where('record_type', 'media')->delete();
        $this->forge->dropColumn('galleries', array_keys(self::MEDIA_FIELDS));
    }

    private function createGalleryItemsTable(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'gallery_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
            ],
            'media_type' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'default' => 'image',
            ],
            'file_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'caption' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['gallery_id', 'sort_order']);
        $this->forge->createTable('gallery_items', true);
    }
}
