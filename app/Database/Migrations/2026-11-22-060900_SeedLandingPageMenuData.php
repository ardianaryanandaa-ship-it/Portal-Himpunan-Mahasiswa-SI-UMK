<?php

namespace App\Database\Migrations;

use App\Libraries\LandingPageContent;
use CodeIgniter\Database\Migration;
use DateTimeImmutable;
use RuntimeException;
use Throwable;

class SeedLandingPageMenuData extends Migration
{
    public function up()
    {
        foreach (['landing_page_items', 'posts', 'faqs', 'galleries', 'gallery_items'] as $table) {
            if (! $this->db->tableExists($table)) {
                throw new RuntimeException('Tabel yang diperlukan tidak ditemukan: ' . $table);
            }
        }

        $this->db->transBegin();

        try {
            if ($this->rowCount('posts') === 0) {
                $this->seedNews();
            }

            if ($this->rowCount('faqs') === 0) {
                $this->seedFaqs();
            }

            if ($this->rowCount('galleries') === 0 && $this->rowCount('gallery_items') === 0) {
                $this->seedGallery();
            }

            $this->db->table('landing_page_items')
                ->whereIn('section_key', ['news_fallback_rows', 'faq_fallback_rows', 'gallery_fallback_rows'])
                ->delete();

            if (! $this->db->transStatus()) {
                throw new RuntimeException('Gagal memindahkan data landing page ke tabel menu.');
            }

            $this->db->transCommit();
        } catch (Throwable $exception) {
            $this->db->transRollback();
            throw $exception;
        }
    }

    public function down()
    {
        foreach (['news_fallback_rows', 'faq_fallback_rows', 'gallery_fallback_rows'] as $section) {
            if ($this->rowCount('landing_page_items', $section) > 0) {
                continue;
            }

            $items = LandingPageContent::defaultItemRows($section);
            foreach ($items as $index => $item) {
                $this->db->table('landing_page_items')->insert([
                    'section_key' => $section,
                    'item_data' => json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }

    private function seedNews(): void
    {
        foreach ($this->itemsFor('news_fallback_rows') as $item) {
            $data = $item['data'];
            $publishedAt = DateTimeImmutable::createFromFormat('!d M Y', $data['date']);
            $dateErrors = DateTimeImmutable::getLastErrors();
            if (
                $publishedAt === false
                || (is_array($dateErrors) && ($dateErrors['warning_count'] > 0 || $dateErrors['error_count'] > 0))
            ) {
                throw new RuntimeException('Tanggal berita landing page tidak valid: ' . $data['date']);
            }

            $slug = strtolower(trim((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $data['title']), '-'));
            $this->db->table('posts')->insert([
                'title' => $data['title'],
                'slug' => $slug,
                'excerpt' => $data['description'],
                'content' => $data['description'],
                'thumbnail' => $data['image_path'],
                'status' => 'published',
                'published_at' => $publishedAt->format('Y-m-d H:i:s'),
                'created_at' => $publishedAt->format('Y-m-d H:i:s'),
            ]);
        }
    }

    private function seedFaqs(): void
    {
        foreach ($this->itemsFor('faq_fallback_rows') as $index => $item) {
            $this->db->table('faqs')->insert([
                'category' => 'Umum',
                'question' => $item['data']['question'],
                'answer' => $item['data']['answer'],
                'sort_order' => $index + 1,
                'is_active' => 1,
            ]);
        }
    }

    private function seedGallery(): void
    {
        $categories = [];
        foreach ($this->itemsFor('gallery_fallback_rows') as $item) {
            $data = $item['data'];
            $categories[$data['category']][] = $data['image_path'];
        }

        foreach ($categories as $category => $paths) {
            $slug = strtolower(trim((string) preg_replace('/[^a-zA-Z0-9]+/', '-', $category), '-'));
            $this->db->table('galleries')->insert([
                'title' => $category,
                'slug' => $slug,
                'description' => 'Dokumentasi kegiatan HIMA SI: ' . $category,
                'cover_image' => $paths[0],
                'is_published' => 1,
            ]);
            $galleryId = $this->db->insertID();

            foreach ($paths as $index => $path) {
                $this->db->table('gallery_items')->insert([
                    'gallery_id' => $galleryId,
                    'media_type' => 'image',
                    'file_path' => $path,
                    'caption' => $category,
                    'sort_order' => $index + 1,
                ]);
            }
        }
    }

    private function itemsFor(string $section): array
    {
        $storedItems = $this->db->table('landing_page_items')
            ->where('section_key', $section)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        if ($storedItems === []) {
            $defaults = LandingPageContent::defaultItemRows($section);

            return array_map(
                static fn (array $data, int $index): array => ['data' => $data, 'sort_order' => $index + 1],
                $defaults,
                array_keys($defaults)
            );
        }

        $items = [];
        foreach ($storedItems as $item) {
            $data = json_decode($item['item_data'], true, 512, JSON_THROW_ON_ERROR);
            if (! is_array($data)) {
                throw new RuntimeException('Data landing page harus berupa objek JSON: ' . $section);
            }

            $items[] = [
                'data' => $data,
                'sort_order' => (int) $item['sort_order'],
            ];
        }

        return $items;
    }

    private function rowCount(string $table, ?string $section = null): int
    {
        $builder = $this->db->table($table);
        if ($section !== null) {
            $builder->where('section_key', $section);
        }

        return $builder->countAllResults();
    }
}
