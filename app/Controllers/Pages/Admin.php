<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Admin extends BaseController 
{
    public function index()
    {
        $data = [
            "title" => "Data Admin"
        ];

        return view('pages/admin/list', $data);
    }
}
