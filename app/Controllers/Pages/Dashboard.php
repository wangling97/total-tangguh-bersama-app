<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return view('pages/dashboard/view');
    }
}
