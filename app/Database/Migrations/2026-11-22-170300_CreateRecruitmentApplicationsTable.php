<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRecruitmentApplicationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'period_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'nim' => ['type' => 'VARCHAR', 'constraint' => 30],
            'email' => ['type' => 'VARCHAR', 'constraint' => 150],
            'phone' => ['type' => 'VARCHAR', 'constraint' => 30],
            'study_program' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'motivation' => ['type' => 'TEXT', 'null' => true],
            'cv' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'VARCHAR', 'constraint' => 20, 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['period_id', 'nim']);
        $this->forge->addKey(['period_id', 'status']);
        $this->forge->addForeignKey('period_id', 'recruitment_periods', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('recruitment_applications', true);
    }

    public function down()
    {
        $this->forge->dropTable('recruitment_applications', true);
    }
}
