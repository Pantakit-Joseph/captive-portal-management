<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;
use App\Models\Issues\issueFilesModel;
use App\Models\Issues\IssuesModel;
use App\Models\Issues\IssueTypesModel;

class IssuesNew extends BaseController
{
    public function index()
    {
        // return phpinfo();
        return view('portal/issues_new', [
            'data' => $this->getDataPage(),
        ]);
    }

    public function action()
    {
        $issuesModel     = model(IssuesModel::class);
        $issueFilesModel = model(issueFilesModel::class);

        if (! $this->actionValidate()) {
            return view('portal/issues_new', [
                'data' => $this->getDataPage(),
            ]);
        }

        $data = $this->actionGetData();
        if (! $issuesModel->insert($data)) {
            return view('portal/issues_new', [
                'error' => $issuesModel->errors(),
                'data'  => $this->getDataPage(),
            ]);
        }

        $issue_id   = $issuesModel->getInsertID();
        $files_data = $this->actionUploadFiles($issue_id);
        if (! empty($files_data)) {
            if (! $issueFilesModel->insertBatch($files_data)) {
                return view('portal/issues_new', [
                    'error' => $issueFilesModel->errors(),
                    'data'  => $this->getDataPage(),
                ]);
            }
        }

        return view('portal/issues_new', [
            'data'    => $this->getDataPage(),
            'success' => 'บันทึกข้อมูลสำเร็จเรียบร้อย',
        ]);
    }

    private function getDataPage()
    {
        $IssueTypesModel = model(IssueTypesModel::class);

        return (object) [
            'types' => $IssueTypesModel->findAll(),
        ];
    }

    private function actionValidate()
    {
        $rules = [
            'firstname' => [
                'label' => 'ชื่อ',
                'rules' => 'required|max_length[30]',
            ],
            'lastname' => [
                'label' => 'นามสกุล',
                'rules' => 'required|max_length[30]',
            ],
            'email' => [
                'label' => 'อีเมล',
                'rules' => 'required|valid_email|max_length[255]',
            ],
            'tel' => [
                'label' => 'เบอร์โทร',
                'rules' => 'required|is_natural|max_length[10]',
            ],
            'title' => [
                'label' => 'หัวข้อ',
                'rules' => 'required|max_length[50]',
            ],
            'details' => [
                'label' => 'รายละเอียด',
                'rules' => 'required|max_length[16383]',
            ],
            'type' => [
                'label' => 'ประเภทของปัญหา',
                'rules' => 'required',
            ],
            'file' => [
                'label' => 'ไฟล์',
                // 'rules' => 'uploaded[file]|max_size[file,7168]'
                'rules' => 'max_size[file,7168]',
            ],
        ];

        return (bool) ($this->validate($rules));
    }

    private function actionGetData()
    {
        return [
            'firstname' => $this->request->getPost('firstname'),
            'lastname'  => $this->request->getPost('lastname'),
            'email'     => $this->request->getPost('email'),
            'tel'       => $this->request->getPost('tel'),
            'title'     => $this->request->getPost('title'),
            'details'   => $this->request->getPost('details'),
            'type_id'   => $this->request->getPost('type'),
        ];
    }

    private function actionUploadFiles($issue_id)
    {
        $data = [];
        if (! $files = $this->request->getFiles()) {
            return;
        }

        foreach ($files['file'] as $img) {
            if ($img->isValid() && ! $img->hasMoved()) {
                $folderName = rtrim(date('Ymd'), '/') . '/';
                $folderPath = FCPATH . 'storage/' . $folderName;
                $fileName   = $img->getRandomName();
                $path       = $img->move($folderPath, $fileName);
                $data[]     = [
                    'issue_id' => $issue_id,
                    'file'     => 'storage/' . $folderName . $fileName,
                ];
            }
        }

        return $data;
    }
}
