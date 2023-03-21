<?php

namespace App\Controllers\Portal;

use App\Controllers\BaseController;

class Issue extends BaseController
{
    public function index()
    {
        return view('portal/issue');
    }
}
