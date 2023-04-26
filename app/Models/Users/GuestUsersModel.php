<?php

namespace App\Models\Users;

use CodeIgniter\Model;

class GuestUsersModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'app_guest_users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'expire_at',
        'description',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function filter($filter)
    {
        $this->select('app_guest_users.*, radcheck.value AS password');
        $this->join(
            'radcheck',
            'radcheck.username=app_guest_users.username AND '
                . "radcheck.attribute = 'Cleartext-Password'",
            'left'
        );
        if (! empty($filter['search'])) {
            $this->search($filter['search']);
        }

        if (isset($filter['status']) && $filter['status'] === 'trashed') {
            $this->onlyDeleted();
        }

        return $this;
    }

    private function search($search)
    {
        $search = trim($search);
        $this->groupStart();
        $this->orLike('app_guest_users.id', $search);
        $this->orLike('app_guest_users.username', $search);
        $this->orLike('radcheck.value', $search);
        $this->orLike('created_at', $search);
        $this->orLike('updated_at', $search);
        $this->orLike('deleted_at', $search);
        $this->groupEnd();
    }

    public function isUser($username)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('app_guest_users')
            ->select('radcheck.username AS radcheck_username, app_guest_users.username as guest_username')
            ->join('radcheck', 'radcheck.username = app_guest_users.username', 'left')
            ->orwhere('radcheck.username', $username)
            ->orwhere('app_guest_users.username', $username);

        $union = $db->table('app_guest_users')
            ->select('radcheck.username AS radcheck_username, app_guest_users.username as guest_username')
            ->join('radcheck', 'radcheck.username = app_guest_users.username', 'right')
            ->orwhere('radcheck.username', $username)
            ->orwhere('app_guest_users.username', $username);

        return ! (empty($builder->union($union)->get()->getRow()));
    }

    public function createUsers($usersData)
    {
        $insertsGuestUsersTable = $this->insertsGuestUsersTable($usersData);
        if (! $insertsGuestUsersTable) {
            return false;
        }

        $insertsRadcheckTable = $this->insertsRadcheckTable($usersData);

        return ! (! $insertsRadcheckTable);
    }

    private function insertsGuestUsersTable($usersData)
    {
        log_message('debug', var_export($usersData, true));
        $data = array_map(static function ($users) {
            return [
                'username'    => $users['username'],
                'expire_at'   => $users['expire'],
                'description' => $users['description'],
            ];
        }, $usersData);

        return $this->insertBatch($data);
    }

    private function insertsRadcheckTable($usersData)
    {
        $radcheckModel = model('App\Models\Radcheck');
        $data          = array_map(static function ($users) {
            return [
                'username'  => $users['username'],
                'attribute' => 'Cleartext-Password',
                'op'        => ':=',
                'value'     => $users['password'],
            ];
        }, $usersData);

        return $radcheckModel->insertBatch($data);
    }
}
