<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use RuntimeException;

class DropUnusedEmptyTables extends Migration
{
    private const TABLES = [
        'activity_logs',
        'agendas',
        'archive_categories',
        'archives',
        'aspirations',
        'board_members',
        'certificates',
        'contact_messages',
        'divisions',
        'event_attendances',
        'event_registrations',
        'finance_accounts',
        'finance_categories',
        'finance_transactions',
        'incoming_letters',
        'members',
        'organization_documents',
        'outgoing_letters',
        'periods',
        'permissions',
        'post_categories',
        'role_permissions',
        'student_informations',
        'work_programs',
    ];

    public function up()
    {
        foreach (self::TABLES as $table) {
            if ($this->db->tableExists($table) && $this->db->table($table)->countAllResults() > 0) {
                throw new RuntimeException('Tabel tidak kosong, penghapusan dibatalkan: ' . $table);
            }
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        try {
            foreach (self::TABLES as $table) {
                $this->forge->dropTable($table, true);
            }
        } finally {
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        }
    }

    public function down()
    {
        throw new RuntimeException('Penghapusan tabel kosong tidak dapat dibatalkan otomatis; pulihkan skema dari backup.');
    }
}
