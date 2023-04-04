<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateIssueTables extends Migration
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
            'type_name' => [
                'type'       => 'varchar',
                'constraint' => 30,
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
        $this->forge->createTable('app_issue_types');

        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'firstname' => [
                'type'       => 'varchar',
                'constraint' => 30,
            ],
            'lastname' => [
                'type'       => 'varchar',
                'constraint' => 30,
            ],
            'email' => [
                'type'       => 'varchar',
                'constraint' => 255,
                'null'       => true,
            ],
            'tel' => [
                'type'       => 'int',
                'constraint' => 10,
                'null'       => true,
            ],
            'title' => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null'       => true,
            ],
            'details' => [
                'type' => 'text',
                'null' => true,
            ],
            'type_id' => [
                'type'       => 'int',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'comment' => [
                'type' => 'text',
                'null' => true,
            ],
            'status' => [
                'type'       => 'int',
                'constraint' => 1,
                'default'    => 1,
                'null'       => true,
                'comment'    => '1=เปิดปัญหา, 0=ปิดปัญหา',
            ],
            'closed_by' => [
                'type'       => 'int',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('type_id', 'app_issue_types', 'id', '', 'SET NULL');
        $this->forge->addForeignKey('closed_by', 'app_users', 'id', '', 'NO ACTION');
        $this->forge->createTable('app_issues');

        $this->forge->addField([
            'id' => [
                'type'           => 'int',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'issue_id' => [
                'type'       => 'int',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'file' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('issue_id', 'app_issues', 'id', '', 'CASCADE');
        $this->forge->createTable('app_issue_files');

        $this->db->table('app_issue_types')
            ->insertBatch([
                [
                    'type_name'  => 'ไม่สามารถเข้าสู่ระบบได้',
                    'created_at' => new RawSql('NOW()'),
                    'updated_at' => new RawSql('NOW()'),
                ],
                [
                    'type_name'  => 'ข้อผิดพลาด (เว็บ)',
                    'created_at' => new RawSql('NOW()'),
                    'updated_at' => new RawSql('NOW()'),
                ],
                [
                    'type_name'  => 'ข้อผิดพลาดบนมือถือ (Android)',
                    'created_at' => new RawSql('NOW()'),
                    'updated_at' => new RawSql('NOW()'),
                ],
                [
                    'type_name'  => 'ข้อผิดพลาดบนมือถือ (iOS)',
                    'created_at' => new RawSql('NOW()'),
                    'updated_at' => new RawSql('NOW()'),
                ],
                [
                    'type_name'  => 'ข้อผิดพลาดอื่น',
                    'created_at' => new RawSql('NOW()'),
                    'updated_at' => new RawSql('NOW()'),
                ],

            ]);
    }

    public function down()
    {
        // $this->db->disableForeignKeyChecks();

        $this->forge->dropTable('app_issue_files', true);
        $this->forge->dropTable('app_issues', true);
        $this->forge->dropTable('app_issue_types', true);

        // $this->db->enableForeignKeyChecks();
    }
}
