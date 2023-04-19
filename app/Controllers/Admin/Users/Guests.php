<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Guests extends BaseController
{
    use ResponseTrait;

    private $guestUsersModel;

    public function __construct()
    {
        helper('text');
        $this->guestUsersModel = model('App\Models\Users\GuestUsersModel');
    }

    public function index()
    {
        return view('admin/users/guests');
    }

    public function apiAdd()
    {
        $token = csrf_hash();

        $rules = [
            'numberofusers' => [
                'label' => 'จำนวนผู้ใช้',
                'rules' => 'required|is_natural_no_zero',
            ],
            'prefix' => [
                'label' => 'คำนำหน้าชื่อผู้ใช้',
                'rules' => 'max_length[20]',
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $numberofusers = $this->request->getVar('numberofusers');
        $prefix        = $this->request->getVar('prefix');
        $expires       = $this->request->getVar('expires');

        $users = $this->usersGenerate($numberofusers, $prefix, $expires);
        if (! $users) {
            return $this->fail([
                'token'  => $token,
                'errors' => 'ไม่สามารถสร้างผู้ใช้ได้ กรุณาลองใหม่อีกครั้ง',
            ]);
        }

        return $this->respond([
            'token' => $token,
            'users' => $users,
        ]);
    }

    private function usersGenerate($numberofusers, $prefix, $expires)
    {
        $usernames = $this->usersGenerateUsername($numberofusers, $prefix);
        $passwords = $this->usersGeneratePasswords($numberofusers);

        $users = $this->mapUsernamesPasswords($usernames, $passwords);

        $createUsers = $this->guestUsersModel->createUsers($users);
        if (! $createUsers) {
            return false;
        }

        return $users;
    }

    private function usersGenerateUsername($numberofusers, $prefix, $maxReGenerate = 100)
    {
        $number = (int) $numberofusers;
        if ($number < 1) {
            return [];
        }
        $usernames = [];

        $reGenerateCount = 0;

        while (count($usernames) < $number) {
            $username = random_string('alnum', 6);
            $username = $prefix . $username;
            if ($this->guestUsersModel->isUser($username)) {
                if ($reGenerateCount >= $maxReGenerate) {
                    continue;
                }
            }
            $reGenerateCount = 0;
            $usernames[]     = $username;
        }

        return $usernames;
    }

    private function usersGeneratePasswords($numberofusers)
    {
        $number = (int) $numberofusers;
        if ($number < 1) {
            return [];
        }

        $passwords = [];

        for ($i = 0; $i < $number; $i++) {
            $password    = random_string('alnum', 6);
            $passwords[] = $password;
        }

        return $passwords;
    }

    private function mapUsernamesPasswords($usernames, $passwords)
    {
        return array_map(static function ($username, $password) {
            return [
                'username' => $username,
                'password' => $password,
            ];
        }, $usernames, $passwords);
    }
}
