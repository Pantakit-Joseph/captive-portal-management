<?php

namespace App\Controllers\Admin\Issues;

use App\Controllers\BaseController;
use App\Models\Issues\IssuesModel;
use CodeIgniter\API\ResponseTrait;

class Issues extends BaseController
{
    use ResponseTrait;

    private $issuesModel;

    public function __construct()
    {
        $this->issuesModel = model(IssuesModel::class);
    }

    public function index()
    {
        $filter = [
            'per_page' => (int) $this->request->getGet('per_page') ?: 10,
            'search'   => trim((string) $this->request->getGet('search')),
            'status'   => $this->request->getGet('status') ?? 'open',
        ];

        return view('admin/issues/issues', [
            'issues' => $this->issuesModel->getAllPaginate($filter, $filter['per_page']),
            'pager'  => $this->issuesModel->pager,
            'filter' => $filter,
        ]);
    }

    public function apiClose($id)
    {
        $token = csrf_hash();
        if (! $id) {
            return $this->fail([
                'token' => $token,
            ]);
        }

        $update = $this->issuesModel->update($id, [
            'status'    => '0',
            'closed_by' => user_id(),
        ]);

        if (! $update) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->issuesModel->errors(),
            ]);
        }

        return $this->respond([
            'token' => $token,
        ], 200);
    }

    public function apiOpen($id)
    {
        $token = csrf_hash();
        if (! $id) {
            return $this->fail([
                'token' => $token,
            ]);
        }

        $update = $this->issuesModel->update($id, [
            'status'    => '1',
            'closed_by' => null,
        ]);

        if (! $update) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->issuesModel->errors(),
            ]);
        }

        return $this->respond([
            'token' => $token,
        ], 200);
    }
}
