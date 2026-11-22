<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWorkProgramsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'division_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 200],
            'description' => ['type' => 'TEXT', 'null' => true],
            'target_date' => ['type' => 'DATE', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'planned'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['status', 'target_date']);
        $this->forge->addForeignKey('division_id', 'divisions', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('work_programs', true);
    }

    public function down()
    {
        $this->forge->dropTable('work_programs', true);
    }
}
