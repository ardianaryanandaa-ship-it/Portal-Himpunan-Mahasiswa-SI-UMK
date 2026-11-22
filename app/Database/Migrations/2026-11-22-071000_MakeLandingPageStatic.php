<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class MakeLandingPageStatic extends Migration
{
    private const TABLES = [
        'achievements',
        'events',
        'faqs',
        'galleries',
        'posts',
        'landing_page_about_cards',
        'landing_page_about_settings',
        'landing_page_achievements_settings',
        'landing_page_bph',
        'landing_page_departments',
        'landing_page_event_examples',
        'landing_page_events_settings',
        'landing_page_faq_settings',
        'landing_page_footer_settings',
        'landing_page_gallery_settings',
        'landing_page_hero_highlights',
        'landing_page_hero_settings',
        'landing_page_hero_typed_texts',
        'landing_page_missions',
        'landing_page_news_settings',
        'landing_page_organization_settings',
        'landing_page_program_items',
        'landing_page_programs_settings',
        'landing_page_testimonial_items',
        'landing_page_testimonials_settings',
        'landing_page_vision_settings',
        'settings',
    ];

    public function up()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        try {
            foreach (self::TABLES as $table) {
                if ($this->db->tableExists($table)) {
                    $this->forge->dropTable($table);
                }
            }
        } finally {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        }

        foreach (self::TABLES as $table) {
            if ($this->db->tableExists($table)) {
                throw new RuntimeException('Tabel konten landing page gagal dihapus: ' . $table);
            }
        }
    }

    public function down()
    {
        throw new RuntimeException('Penghapusan data konten landing page bersifat permanen; pulihkan database dari backup untuk membatalkannya.');
    }
}
