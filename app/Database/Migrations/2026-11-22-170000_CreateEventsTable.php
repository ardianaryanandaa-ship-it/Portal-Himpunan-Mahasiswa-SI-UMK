<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 200],
            'slug' => ['type' => 'VARCHAR', 'constraint' => 220],
            'description' => ['type' => 'LONGTEXT', 'null' => true],
            'poster' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'location' => ['type' => 'VARCHAR', 'constraint' => 200],
            'start_at' => ['type' => 'DATETIME'],
            'end_at' => ['type' => 'DATETIME', 'null' => true],
            'registration_deadline' => ['type' => 'DATETIME', 'null' => true],
            'quota' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'draft'],
            'created_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('slug');
        $this->forge->addKey(['status', 'start_at']);
        $this->forge->addForeignKey('created_by', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('events', true);
    }

    public function down()
    {
        $this->forge->dropTable('events', true);
    }
}
