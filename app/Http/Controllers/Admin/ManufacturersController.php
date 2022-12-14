<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManufacturersController extends Controller
{
    /**
     * Manufacturers' Page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('admin.manufacturers.index');
    }
}
