<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        return "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'><title>Panel de Administración</title></head><body><h1>Panel de Administración</h1><p>Bienvenido al área administrativa de Estética BV.</p></body></html>";
    }
}
