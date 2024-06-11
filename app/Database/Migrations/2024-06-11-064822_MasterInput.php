<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MasterInput extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_data' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_pdk' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'barcode_real' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);
        $this->forge->addKey('id_data', true);
        $this->forge->addForeignKey('id_data', 'master_pdk', 'id_data');
        $this->forge->createTable('master_input');
    }

    public function down()
    {
        //
    }
}
