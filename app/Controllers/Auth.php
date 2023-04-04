<?php

namespace App\Controllers;

class Auth extends BaseController
{
    private $auth;

    public function __construct()
    {
        $this->auth = service('auth');
    }

    public function login()
    {
        return view('auth/login.php');
    }

    public function loginAction()
    {
        $rules = [
            'username' => [
                'label' => 'ชื่อผู้ใช้',
                'rules' => 'required',
            ],
            'password' => [
                'label' => 'รหัสผ่าน',
                'rules' => 'required',
            ],
        ];

        if ($this->validate($rules)) {
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $login    = $this->auth->login($username, $password);

            if ($login['success']) {
                return $this->redirect(user('user_type'));
            }
        }

        return view('auth/login.php', [
            'error' => $login['reason'] ?? null,
        ]);
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect('auth/login');
    }

    private function redirect($user_type)
    {
        switch ($user_type) {
            case 'admin':
                return redirect()->to('admin/home');
                break;

            default:
                return redirect()->to('auth/login')->with('error', 'เปลี่ยนเส้นทางไม่ถูกต้อง');
                break;
        }
    }
}
