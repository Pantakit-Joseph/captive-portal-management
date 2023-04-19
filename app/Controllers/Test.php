<?php

namespace App\Controllers;

/**
 * @internal
 */
final class Test extends BaseController
{
    public function index()
    {
        helper('text');
        $prefix = '';
        $number = 10;
        $names  = [];

        for ($i = 0; $i < $number; $i++) {
            $name = uniqid(true);
            $name = base_convert($name, 16, 36);

            $names[] = $prefix . $name;
        }
        echo '<pre>';
        var_dump($names);

        $names2 = [];

        for ($i = 0; $i < $number; $i++) {
            $name = random_string('alnum', 6);

            $names2[] = $prefix . $name;
        }
        var_dump($names2);
    }

    public function app()
    {
        return view('test/app');
    }
}
