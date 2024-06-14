<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PackingController extends BaseController
{
    public function index()
    {
        return view('Packing/halamanUtama');
    }
}
