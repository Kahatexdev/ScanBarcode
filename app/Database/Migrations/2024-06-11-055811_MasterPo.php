<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterPo extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_po' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'po' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
            ],
            'buyer' => [
                'type' => 'VARCHAR',
                'constraint' => 12,
            ],
        ]);
        $this->forge->addKey('id_po', true);
        $this->forge->createTable('master_po');
    }

    public function down()
    {
        //
    }
}
