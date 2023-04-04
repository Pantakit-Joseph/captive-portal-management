<?php

namespace App\Controllers;

/**
 * @internal
 */
final class Test extends BaseController
{
    public function index()
    {
    }

    public function app()
    {
        return view('test/app');
    }
}
