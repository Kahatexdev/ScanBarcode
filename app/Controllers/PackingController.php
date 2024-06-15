<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PackingController extends BaseController
{
    protected $filters;
    public function __construct()
    {
        if ($this->filters = ['role' => ['packing', session()->get('role')]] !== session()->get('role')) {
            return redirect()->to(base_url('/'));
        }
    }
    public function index()
    {
        return view('Packing/halamanUtama');
    }
}
