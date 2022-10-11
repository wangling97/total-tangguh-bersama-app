<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            "title" => "Dashboard"
        ];

        return view('pages/dashboard/view', $data);
    }
}
