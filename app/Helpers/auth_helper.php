<?php

if (! function_exists('user_id')) {
    function auth()
    {
        return service('auth');
    }

    function user_id()
    {
        $auth = service('auth');

        return $auth->user['id'] ?? null;
    }

    function user($key = null)
    {
        $auth = service('auth');
        if (isset($key)) {
            return $auth->user[$key] ?? null;
        }

        return $auth->user;
    }

    function user_type()
    {
        return user('user_type');
    }
}
