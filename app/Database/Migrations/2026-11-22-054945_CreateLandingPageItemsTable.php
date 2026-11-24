<?php

namespace App\Database\Migrations;

use App\Libraries\LandingPageContent;
use CodeIgniter\Database\Migration;

class CreateLandingPageItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'section_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'item_data' => [
                'type' => 'TEXT',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['section_key', 'sort_order']);
        $this->forge->createTable('landing_page_items', true);

        $legacySettings = [];
        if ($this->db->tableExists('settings')) {
            $settings = $this->db->table('settings')
                ->select('setting_key, setting_value')
                ->where('setting_group', LandingPageContent::SETTING_GROUP)
                ->get()
                ->getResultArray();

            foreach ($settings as $setting) {
                $legacySettings[$setting['setting_key']] = $setting['setting_value'];
            }
        }

        foreach (LandingPageContent::itemDefinitions() as $section => $_definition) {
            $legacyValue = $legacySettings[$section] ?? null;
            $items = LandingPageContent::defaultItemRows($section, $legacyValue);
            $records = [];

            foreach ($items as $index => $item) {
                $records[] = [
                    'section_key' => $section,
                    'item_data'  => json_encode($item, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                    'sort_order' => $index + 1,
                ];
            }

            if ($records !== []) {
                $this->db->table('landing_page_items')->insertBatch($records);
            }
        }
    }

    public function down()
    {
        $this->forge->dropTable('landing_page_items', true);
    }
}
