<?php

namespace App\Models\Issues;

use CodeIgniter\Model;

class IssuesModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'app_issues';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'firstname',
        'lastname',
        'email',
        'tel',
        'title',
        'details',
        'type_id',
        'comment',
        'status',
        'closed_by',
        'deleted_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'firstname' => 'max_length[30]',
        'lastname'  => 'max_length[30]',
        'email'     => 'valid_email|max_length[255]',
        'tel'       => 'is_natural|max_length[10]',
        'title'     => 'max_length[50]',
        'details'   => 'max_length[16383]',
        'comment'   => 'max_length[16383]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    public function getAllPaginate($filter, ...$args)
    {
        $this->allJoin();
        $this->allFilter($filter);

        $issues = $this->paginate(...$args);
        if (empty($issues)) {
            return [];
        }

        $issue_ids = array_column($issues, 'id');
        $files     = $this->getFilesIn($issue_ids);

        return $this->mergeIssuesFiles($issues, $files);
    }

    private function allJoin()
    {
        $select = [
            'app_issues.*',
            'app_issue_types.type_name',
            'user_closed.username AS closed_username',
        ];
        $selectSQL = implode(', ', $select);
        $this->select($selectSQL);
        $this->join('app_issue_types', 'app_issue_types.id = app_issues.type_id', 'left');
        $this->join('app_users AS user_closed', 'user_closed.id = app_issues.closed_by', 'left');
    }

    private function allFilter($filter)
    {
        $this->allSearch($filter['search']);

        if ($filter['status'] === 'close') {
            $this->where('app_issues.status', 0);
        } else {
            $this->where('app_issues.status', 1);
        }
    }

    private function allSearch($search)
    {
        if (empty($search)) {
            return;
        }

        $this->groupStart();
        $this->orLike('app_issues.id', $search);
        $this->orLike('app_issues.firstname', $search);
        $this->orLike('app_issues.lastname', $search);
        $this->orLike('app_issues.email', $search);
        $this->orLike('app_issues.tel', $search);
        $this->orLike('app_issues.title', $search);
        $this->orLike('app_issue_types.type_name', $search);
        $this->orLike('user_closed.username', $search);
        $this->groupEnd();
    }

    private function getFilesIn($issue_ids)
    {
        if (empty($issue_ids)) {
            return [];
        }

        $issueFilesModel = model('App\Models\Issues\IssueFilesModel');

        return $issueFilesModel->whereIn('issue_id', $issue_ids)->findAll();
    }

    private function mergeIssuesFiles($issues, $files)
    {
        $files_arr = [];

        foreach ($files as $file) {
            $issue_id               = $file['issue_id'];
            $files_arr[$issue_id][] = $file['file'];
        }

        foreach ($issues as $key => $issue) {
            $issue_id              = $issue['id'];
            $issues[$key]['files'] = $files_arr[$issue_id] ?? [];
        }

        return $issues;
    }
}
