<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecruitmentPeriodsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 220],
            'description' => ['type' => 'LONGTEXT', 'null' => true],
            'requirements' => ['type' => 'LONGTEXT', 'null' => true],
            'start_date' => ['type' => 'DATE'],
            'end_date' => ['type' => 'DATE'],
            'quota' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'start_date']);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('recruitment_periods', true);
    }

    public function down()
    {
        $this->forge->dropTable('recruitment_periods', true);
    }
}
