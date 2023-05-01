<?php

namespace App\Libraries;

class Auth
{
    public $user;
    public $isLogin = false;
    private $userModel;

    public function __construct()
    {
        $this->userModel = model('Auth/UserModel');
    }

    public function login($username, $password)
    {
        $user = $this->userModel->getByUsername($username);
        if (!isset($user)) {
            return [
                'success' => false,
                'reason'  => 'ไม่พบบัญชีผู้ใช้',
            ];
        }

        $passwordValid = password_verify($password, $user['password']);
        if ($passwordValid === false) {
            return [
                'success' => false,
                'reason'  => 'รหัสผ่านไม่ถูกต้อง',
            ];
        }

        $statusValid = $this->checkStatus($user['status']);
        if ($statusValid['success'] === false) {
            return $statusValid;
        }

        $this->user = $user;
        session()->set('user_id', $user['id']);
        $this->isLogin = true;

        return [
            'success' => true,
            'reason'  => null,
        ];
    }

    public function checkLogin($user_types = null)
    {
        $user_id = session()->get('user_id');
        if (!isset($user_id)) {
            return false;
        }

        $user       = $this->userModel->find($user_id);
        $this->user = $user;
        if (!isset($user)) {
            return false;
        }

        $statusValid = $this->checkStatus($user['status']);
        if ($statusValid['success'] === false) {
            return false;
        }

        if ($user_types !== null) {
            if (!in_array($user['user_type'], $user_types, true)) {
                return false;
            }
        }

        $this->isLogin = true;

        return true;
    }

    public function logout()
    {
        session()->destroy();
    }

    public function getUserTypeName($user_type)
    {
        switch ($user_type) {
            case 'admin':
                return 'ผู้ดูแลระบบ';
                break;

            default:
                return $user_type;
                break;
        }
    }

    private function checkStatus($status)
    {
        if ($status !== '1') {
            $message = null;

            switch ($status) {
                case '-1':
                    $message = 'บัญชีถูกระงับการใช้งาน';
                    break;

                default:
                    $message = 'บัญชีไม่สามารถใช้งานได้';
                    break;
            }

            return [
                'success' => false,
                'reason'  => $message,
            ];
        }

        return [
            'success' => true,
            'reason'  => null,
        ];
    }
}
