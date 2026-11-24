<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMembersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'division_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'position' => ['type' => 'VARCHAR', 'constraint' => 150],
            'photo' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'period' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'sort_order' => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'default' => 0],
            'is_active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey(['division_id', 'sort_order']);
        $this->forge->addForeignKey('division_id', 'divisions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('members', true);
    }

    public function down()
    {
        $this->forge->dropTable('members', true);
    }
}
