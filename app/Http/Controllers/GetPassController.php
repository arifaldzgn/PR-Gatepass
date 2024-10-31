<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GetPassController extends Controller
{
    //
    public function index()
    {
        return view('gatepass');
    }
}
