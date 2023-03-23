<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class IssuesNew extends BaseController
{
    public function index()
    {
        return view('portal/issues_new');
    }
}
