<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KoperasiController extends Controller
{
    public function index() {
        return view('admin.koperasi.index');

    }
}
