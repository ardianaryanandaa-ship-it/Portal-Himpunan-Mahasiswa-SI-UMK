<?php

namespace App\Database\Migrations;

use App\Libraries\LandingPageContent;
use CodeIgniter\Database\Migration;
use RuntimeException;

class CreateDedicatedLandingPageTables extends Migration
{
    public function up()
    {
        if (! $this->db->tableExists('landing_page_items')) {
            throw new RuntimeException('Tabel landing_page_items tidak ditemukan; pemindahan dibatalkan.');
        }

        $groups = LandingPageContent::fieldGroups();
        $items = LandingPageContent::editableItemDefinitions();

        foreach ($groups as $section => $group) {
            $this->createSettingsTable(LandingPageContent::sectionTable($section), $group['fields']);
        }

        foreach ($items as $definition) {
            $this->createItemsTable($definition['table'], $definition['fields']);
        }

        $settings = [];
        if ($this->db->tableExists('settings')) {
            foreach (
                $this->db->table('settings')
                    ->select('setting_key, setting_value')
                    ->where('setting_group', LandingPageContent::SETTING_GROUP)
                    ->get()
                    ->getResultArray() as $setting
            ) {
                $settings[$setting['setting_key']] = $setting['setting_value'];
            }
        }

        $legacyItems = $this->db->table('landing_page_items')
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();
        $itemsBySection = [];
        foreach ($legacyItems as $item) {
            if (! isset($items[$item['section_key']])) {
                throw new RuntimeException('Data landing page tidak memiliki tabel tujuan: ' . $item['section_key']);
            }
            $itemsBySection[$item['section_key']][] = $item;
        }

        foreach ($groups as $section => $_group) {
            $table = LandingPageContent::sectionTable($section);
            if ($this->db->table($table)->countAllResults() > 0) {
                throw new RuntimeException('Tabel tujuan sudah berisi data; pemindahan dibatalkan: ' . $table);
            }
        }
        foreach ($items as $section => $definition) {
            if ($this->db->table($definition['table'])->countAllResults() > 0) {
                throw new RuntimeException('Tabel tujuan sudah berisi data; pemindahan dibatalkan: ' . $definition['table']);
            }
        }

        $defaults = LandingPageContent::defaults();
        $now = date('Y-m-d H:i:s');
        $this->db->transBegin();

        try {
            foreach ($groups as $section => $group) {
                $record = [];
                foreach (array_keys($group['fields']) as $fieldKey) {
                    $record[$fieldKey] = (string) ($settings[$fieldKey] ?? $defaults[$fieldKey]);
                }
                $record['created_at'] = $now;
                $record['updated_at'] = $now;

                $this->db->table(LandingPageContent::sectionTable($section))->insert($record);
            }

            foreach ($items as $section => $definition) {
                $records = [];
                foreach ($itemsBySection[$section] ?? [] as $item) {
                    $data = json_decode($item['item_data'], true, 512, JSON_THROW_ON_ERROR);
                    if (! is_array($data)) {
                        throw new RuntimeException('Data landing page harus berupa objek: ' . $section);
                    }

                    $record = [];
                    foreach (array_keys($definition['fields']) as $fieldKey) {
                        if (! array_key_exists($fieldKey, $data)) {
                            throw new RuntimeException('Kolom item landing page tidak ditemukan: ' . $fieldKey);
                        }
                        $record[$fieldKey] = (string) $data[$fieldKey];
                    }
                    $record['sort_order'] = (int) $item['sort_order'];
                    $record['created_at'] = $item['created_at'];
                    $record['updated_at'] = $item['updated_at'];
                    $records[] = $record;
                }

                if ($records !== []) {
                    $this->db->table($definition['table'])->insertBatch($records);
                }
            }

            if ($this->db->tableExists('settings')) {
                $this->db->table('settings')
                    ->where('setting_group', LandingPageContent::SETTING_GROUP)
                    ->delete();
            }

            if (! $this->db->transStatus()) {
                throw new RuntimeException('Gagal memindahkan data landing page ke tabel khusus.');
            }
            $this->db->transCommit();
        } catch (\Throwable $exception) {
            $this->db->transRollback();
            throw $exception;
        }

        $this->forge->dropTable('landing_page_items', true);
    }

    public function down()
    {
        if ($this->db->tableExists('landing_page_items')) {
            throw new RuntimeException('Tabel landing_page_items sudah ada; pemulihan otomatis dibatalkan.');
        }

        $this->createLegacyItemsTable();
        $now = date('Y-m-d H:i:s');

        foreach (LandingPageContent::fieldGroups() as $section => $group) {
            $table = LandingPageContent::sectionTable($section);
            $record = $this->db->table($table)->orderBy('id', 'ASC')->get(1)->getRowArray();
            if ($record === null) {
                continue;
            }

            foreach ($group['fields'] as $fieldKey => $field) {
                $this->db->table('settings')->insert([
                    'setting_key' => $fieldKey,
                    'setting_value' => $record[$fieldKey],
                    'setting_group' => LandingPageContent::SETTING_GROUP,
                    'description' => $field['label'],
                    'updated_at' => $record['updated_at'] ?? $now,
                ]);
            }
        }

        foreach (LandingPageContent::editableItemDefinitions() as $section => $definition) {
            $items = $this->db->table($definition['table'])
                ->orderBy('sort_order', 'ASC')
                ->orderBy('id', 'ASC')
                ->get()
                ->getResultArray();

            foreach ($items as $item) {
                $data = [];
                foreach (array_keys($definition['fields']) as $fieldKey) {
                    $data[$fieldKey] = $item[$fieldKey];
                }
                $this->db->table('landing_page_items')->insert([
                    'section_key' => $section,
                    'item_data' => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                    'sort_order' => $item['sort_order'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ]);
            }
        }

        foreach (LandingPageContent::editableItemDefinitions() as $definition) {
            $this->forge->dropTable($definition['table'], true);
        }
        foreach (LandingPageContent::fieldGroups() as $section => $_group) {
            $this->forge->dropTable(LandingPageContent::sectionTable($section), true);
        }
    }

    private function createSettingsTable(string $table, array $fields): void
    {
        $this->forge->addField($this->baseFields());
        foreach ($fields as $fieldKey => $field) {
            $this->forge->addField([$fieldKey => $this->columnFor($field)]);
        }
        $this->forge->addField($this->timestampFields());
        $this->forge->addKey('id', true);
        $this->forge->createTable($table, true);
    }

    private function createItemsTable(string $table, array $fields): void
    {
        $this->forge->addField($this->baseFields());
        foreach ($fields as $fieldKey => $field) {
            $this->forge->addField([$fieldKey => $this->columnFor($field)]);
        }
        $this->forge->addField([
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ],
        ]);
        $this->forge->addField($this->timestampFields());
        $this->forge->addKey('id', true);
        $this->forge->addKey(['sort_order', 'id']);
        $this->forge->createTable($table, true);
    }

    private function createLegacyItemsTable(): void
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'section_key' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'item_data' => ['type' => 'TEXT'],
            'sort_order' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['section_key', 'sort_order']);
        $this->forge->createTable('landing_page_items', true);
    }

    private function baseFields(): array
    {
        return [
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],
        ];
    }

    private function timestampFields(): array
    {
        return [
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ];
    }

    private function columnFor(array $field): array
    {
        if ($field['type'] === 'number') {
            return [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => true,
                'default' => 0,
            ];
        }

        if ($field['type'] === 'textarea') {
            return ['type' => 'TEXT'];
        }

        return [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ];
    }
}
