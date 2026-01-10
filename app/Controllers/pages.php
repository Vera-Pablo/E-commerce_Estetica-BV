<?php

namespace App\Controllers;
use App\Controllers\BaseController;

class Pages extends BaseController{
    public function about(){
        return view('pages/about');
    }
    
    public function marketing(){
        return view('pages/marketing');
    }
    
    public function contacts(){
        return view('pages/contacts');
    }
    
    public function policy(){
        return view('pages/policy');
    }

    public function catalog(){
        return view('shop/catalog');
    }

    public function services(){
        return view('booking/services');
    }
}