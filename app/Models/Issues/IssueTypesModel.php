<?php

namespace App\Models\Issues;

use CodeIgniter\Model;

class IssueTypesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'app_issue_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'type_name',
        'deleted_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    public function filter($filter)
    {
        if (! empty($filter['search'])) {
            $this->search($filter['search']);
        }

        if (isset($filter['status']) && $filter['status'] === 'trashed') {
            $this->onlyDeleted();
        }

        return $this;
    }

    public function search($search)
    {
        $search = trim($search);
        $this->groupStart();
        $this->orLike('id', $search);
        $this->orLike('type_name', $search);
        $this->orLike('created_at', $search);
        $this->orLike('updated_at', $search);
        $this->orLike('deleted_at', $search);
        $this->groupEnd();
    }
}
