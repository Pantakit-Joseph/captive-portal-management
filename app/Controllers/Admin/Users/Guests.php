<?php

namespace App\Controllers\Admin\Users;

use App\Controllers\BaseController;
use App\Models\Auth\Radcheck;
use App\Models\Users\GuestUsersModel;
use CodeIgniter\API\ResponseTrait;

class Guests extends BaseController
{
    use ResponseTrait;

    private $guestUsersModel;
    private $radcheckModel;

    public function __construct()
    {
        helper('text');
        $this->guestUsersModel = model(GuestUsersModel::class);
        $this->radcheckModel   = model(Radcheck::class);
    }

    public function index()
    {
        $filter = [
            'per_page' => (int) $this->request->getGet('per_page') ?: 10,
            'search'   => trim((string) $this->request->getGet('search')),
            'status'   => $this->request->getGet('status') ?? 'published',
        ];

        return view(
            'admin/users/guests',
            [
                'guestUsers' => $this->guestUsersModel->filter($filter)->paginate($filter['per_page']),
                'pager'      => $this->guestUsersModel->pager,
                'filter'     => $filter,
            ]
        );
    }

    public function apiDelete($username)
    {
        $token        = csrf_hash();
        $responseFail = function () use ($token) {
            return $this->fail([
                'token'  => $token,
                'errors' => 'ไม่สามารถลบผู้ใช้ได้ กรุณาลองใหม่อีกครั้ง',
            ]);
        };

        $deleteFromRadcheck = $this->radcheckModel->where('username', $username)->delete();
        if (!$deleteFromRadcheck) {
            return $responseFail;
        }

        $deleteFromGuestUsers = $this->guestUsersModel->where('username', $username)->delete();
        if (!$deleteFromGuestUsers) {
            return $responseFail;
        }

        return $this->respondDeleted([
            'token' => $token,
        ]);
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
            'expire' => [
                'label' => 'วันหมดอายุ',
                'rules' => 'permit_empty|valid_date',
            ],
            'description' => [
                'label' => 'คำอธิบาย',
                'rules' => 'permit_empty|max_length[255]',
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $numberofusers = $this->request->getVar('numberofusers');
        $prefix        = $this->request->getVar('prefix');
        $expire        = $this->request->getVar('expire');
        $description   = $this->request->getVar('description');

        $users = $this->usersGenerate($numberofusers, $prefix, $expire, $description);
        if (!$users) {
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

    private function usersGenerate($numberofusers, $prefix, $expire, $description)
    {
        $usernames = $this->usersGenerateUsername($numberofusers, $prefix);
        $passwords = $this->usersGeneratePasswords($numberofusers);

        $users = $this->mapUsernamesPasswords($usernames, $passwords, $expire, $description);

        $createUsers = $this->guestUsersModel->createUsers($users);
        if (!$createUsers) {
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

    private function mapUsernamesPasswords($usernames, $passwords, $expire, $description)
    {
        return array_map(static function ($username, $password) use ($expire, $description) {
            return [
                'username'    => $username,
                'password'    => $password,
                'expire'      => $expire,
                'description' => $description,
            ];
        }, $usernames, $passwords);
    }
}
