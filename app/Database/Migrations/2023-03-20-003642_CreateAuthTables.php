<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Migration;

class CreateAuthTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true
            ],
            'username' => [
                'type'       => 'varchar',
                'constraint' => 30
            ],
            'password' => [
                'type'       => 'varchar',
                'constraint' => 255
            ],
            'user_type' => [
                'type'       => 'varchar',
                'constraint' => 30
            ],
            'status' => [
                'type'       => 'int',
                'constraint' => 1,
                'default'    => 0,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true
            ],
            'updated_at'     => [
                'type' => 'datetime',
                'null' => true
            ],
            'deleted_at'     => [
                'type' => 'datetime',
                'null' => true
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('app_users');

        $this->db->table('app_users')
            ->insert([
                'username' => 'admin',
                'password' => password_hash('Admin_123456', PASSWORD_DEFAULT),
                'user_type' => 'admin',
                'status' => 1,
                'created_at' => new RawSql('NOW()')
            ]);
    }

    public function down()
    {
        // $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('app_users', true);

        // $this->db->enableForeignKeyChecks();
    }
}
