<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to('/auth/login');
        // return view('welcome_message');
    }
}
