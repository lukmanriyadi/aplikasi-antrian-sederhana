<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function __invoke()
    {
        return view('landing.demo');
    }
}