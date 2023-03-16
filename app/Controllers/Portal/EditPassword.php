<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class EditPassword extends BaseController
{
    public function index()
    {
        return view('portal/edit_password');
    }

    public function action() 
    {
        // log_message('info','test1234');
        $radcheckModel = model('App\Models\Radcheck');

        $rules = [
            'username' => [
                'label' => 'ชื่อผู้ใช้',
                'rules' => 'required'
            ],
            'password'             => [
                'label' => 'รหัสผ่าน',
                'rules' => 'required'
            ],
            'new_password'             => [
                'label' => 'รหัสผ่านใหม่',
                'rules' => 'required|min_length[8]'
            ],
            'new_password_confirm'             => [
                'label' => 'ยืนยันรหัสผ่านใหม่',
                'rules' => 'required|matches[new_password]'
            ]
        ];

        if ($this->validate($rules)) {
            $result = $radcheckModel->editPassword($this->request->getPost());
            if ($result['status']) {
                return redirect()->to('/potal/edit-password/success');
            }

            return view('portal/edit_password', [
                'error' => $result['msg']
            ]);
        }

        return view('portal/edit_password');
    }

    public function success() {
        return view('portal/edit_password_success');
    }
}
