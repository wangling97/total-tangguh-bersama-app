<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Libraries\ExternalConnection;

class Auth extends BaseController
{
    public function login()
    {
        $data = [
            "title" => "Login"
        ];

        return view("pages/auth/login", $data);
    }
}
