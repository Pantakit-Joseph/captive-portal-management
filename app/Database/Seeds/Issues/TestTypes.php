<?php

namespace App\Database\Seeds\Issues;

use CodeIgniter\Database\RawSql;
use CodeIgniter\Database\Seeder;

class TestTypes extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 200; $i++) {
            $data[] = [
                'type_name'  => 'test-' . $i,
                'created_at' => new RawSql('NOW()'),
                'updated_at' => new RawSql('NOW()'),
            ];
        }

        $this->db->table('app_issue_types')->insertBatch($data);
    }
}
