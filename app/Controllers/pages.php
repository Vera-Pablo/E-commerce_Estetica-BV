<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function about()
    {
        return view('pages/about.php');
    }
    
    public function contact()
    {
        return view('pages/contact');
    }
    
    public function terms()
    {
        return view('pages/terms');
    }
}