<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEventRegistrationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'event_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'nim' => ['type' => 'VARCHAR', 'constraint' => 30],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30],
            'study_program' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'registered'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['event_id', 'nim']);
        $this->forge->addKey(['event_id', 'status']);
        $this->forge->addForeignKey('event_id', 'events', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('event_registrations', true);
    }

    public function down()
    {
        $this->forge->dropTable('event_registrations', true);
    }
}
