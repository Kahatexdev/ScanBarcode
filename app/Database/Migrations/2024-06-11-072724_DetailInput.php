<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailInput extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_input' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'id_data' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'barcode_cek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id_input', true);
        $this->forge->addForeignKey('id_data', 'master_input', 'id_data');
        $this->forge->createTable('detail_input');
    }

    public function down()
    {
        //
    }
}
