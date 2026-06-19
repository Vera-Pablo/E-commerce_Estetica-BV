<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController{
    protected $userModel;

    public function __construct(){
        $this->userModel = new UserModel();
    }

    // function getUsers
    public function getUsers(){
        $users = $this->userModel->findAll();
        $data = [
            'users' => $users
        ];
        return view('admin/users/users.php', $data);
    }
}