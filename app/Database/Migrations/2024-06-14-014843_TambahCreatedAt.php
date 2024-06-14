<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TambahCreatedAt extends Migration
{
    public function up()
    {
        $this->forge->addColumn('master_po', [
            'created_at' => [
                'type' => 'DATETIME',
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
