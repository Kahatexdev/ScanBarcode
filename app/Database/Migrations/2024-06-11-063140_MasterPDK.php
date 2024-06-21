<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterPDK extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pdk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_po' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'pdk' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
            ],
            'no_order' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'admin' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);
        $this->forge->addKey('id_pdk', true);
        $this->forge->addForeignKey('id_po', 'master_po', 'id_po', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('master_pdk');
    }

    public function down()
    {
        //
    }
}
