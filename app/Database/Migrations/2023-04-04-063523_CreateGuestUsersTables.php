<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGuestUsersTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'varchar',
                'constraint' => 64,
            ],
            'description' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
            ],
            'expire_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('app_guest_users');
    }

    public function down()
    {
        $this->forge->dropTable('app_guest_users', true);
    }
}
