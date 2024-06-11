<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
            ],
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['packing', 'aksesoris'],
                'default' => 'packing',
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
