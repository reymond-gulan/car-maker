<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    /**
     * Cars' Page
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        return view('admin.car-types.index');
    }
}
