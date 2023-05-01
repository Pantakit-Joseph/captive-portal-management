<?php

namespace App\Controllers\Admin\Issues;

use App\Controllers\BaseController;
use App\Models\Issues\IssueTypesModel;
use CodeIgniter\API\ResponseTrait;

class Types extends BaseController
{
    use ResponseTrait;

    private $issueTypesModel;

    public function __construct()
    {
        $this->issueTypesModel = model(IssueTypesModel::class);
    }

    public function index()
    {
        $filter = [
            'per_page' => (int) $this->request->getGet('per_page') ?: 10,
            'search'   => trim((string) $this->request->getGet('search')),
            'status'   => $this->request->getGet('status') ?? 'published',
        ];

        return view(
            'admin/issues/types',
            [
                // 'types' => $this->issueTypesModel->paginate($perPage),
                'types'  => $this->issueTypesModel->filter($filter)->paginate($filter['per_page']),
                'pager'  => $this->issueTypesModel->pager,
                'filter' => $filter,
            ]
        );
    }

    public function apiAdd()
    {
        $token = csrf_hash();

        $rules = [
            'type_name' => [
                'label' => 'ประเภทปัญหา',
                'rules' => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $type_name = $this->request->getVar('type_name');
        $update    = $this->issueTypesModel->insert([
            'type_name' => $type_name,
        ]);
        if (! $update) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->issueTypesModel->errors(),
            ]);
        }

        return $this->respondCreated([
            'token' => $token,
        ]);
    }

    public function apiEdit($id)
    {
        $rules = [
            'id' => [
                'label' => 'รหัส',
                'rules' => 'required|is_natural',
            ],
            'type_name' => [
                'label' => 'ประเภทปัญหา',
                'rules' => 'required',
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->fail([
                'token'  => csrf_hash(),
                'errors' => $this->validator->getErrors(),
            ]);
        }
        $type_name = $this->request->getVar('type_name');
        $update    = $this->issueTypesModel->update($id, [
            'type_name' => $type_name,
        ]);
        if (! $update) {
            return $this->fail([
                'token'  => csrf_hash(),
                'errors' => $this->issueTypesModel->errors(),
            ]);
        }

        return $this->respond([
            'token' => csrf_hash(),
        ], 200);
    }

    public function apiPurgeDelete($id)
    {
        return $this->apiDelete($id, true);
    }

    public function apiDelete($id, $purge = false)
    {
        $token = csrf_hash();
        if (! $this->issueTypesModel->delete($id, $purge)) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->issueTypesModel->errors(),
            ]);
        }

        return $this->respondDeleted([
            'token' => $token,
        ]);
    }

    public function apiPurgeRestore($id)
    {
        $token = csrf_hash();
        if (! $this->issueTypesModel->update($id, ['deleted_at' => null])) {
            return $this->fail([
                'token'  => $token,
                'errors' => $this->issueTypesModel->errors(),
            ]);
        }

        return $this->respondDeleted([
            'token' => $token,
        ]);
    }
}
