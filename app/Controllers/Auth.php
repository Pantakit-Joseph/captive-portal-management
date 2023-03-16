<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login.php');
    }

    public function loginAction()
    {
        $rules = [
            'username' => [
                'label' => 'ชื่อผู้ใช้',
                'rules' => 'required'
            ],
            'password'             => [
                'label' => 'รหัสผ่าน',
                'rules' => 'required'
            ]
        ];

        if ($this->validate($rules)) {
            log_message('info', 'login validate: true');
        }
    
        return view('auth/login.php');
    }
}
