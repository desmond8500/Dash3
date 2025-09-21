<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KonvaController extends Controller
{
    public function index(){
        return view('_konva.demo');
    }
}
