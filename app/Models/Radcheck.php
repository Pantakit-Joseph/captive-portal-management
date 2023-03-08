<?php

namespace App\Models;

use CodeIgniter\Model;

class Radcheck extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'radcheck';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['value'];

    public function resetPassword($data)
    {
        $check = $this->checkAuth($data['username'], $data['password']);
        if (!$check) {
            return [
                'status' => false,
                'msg' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
            ];
        }

        $set = $this->setPassword($data['username'], $data['new_password']);
        if (!$set) {
            return [
                'status' => false,
                'msg' => 'ไม่สามารถเปลี่ยนรหัสผ่านได้กรุณาลองใหม่อีกครั้ง',
            ];
        }

        return ['status' => true];
    }

    private function setPassword($username, $new_password)
    {
        return $this
            ->where('username', $username)
            ->where('attribute', 'Cleartext-Password')
            ->set(['value' => $new_password])
            ->update();
    }

    private function checkAuth($username, $password)
    {
        return $this
            ->where('username', $username)
            ->where('attribute', 'Cleartext-Password')
            ->where('value', $password)
            ->first();
    }
}
