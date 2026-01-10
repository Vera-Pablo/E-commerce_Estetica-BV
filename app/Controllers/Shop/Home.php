<?php

namespace App\Controllers\Shop;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index(): string
    {
        return view('pages/home');
    }
}
