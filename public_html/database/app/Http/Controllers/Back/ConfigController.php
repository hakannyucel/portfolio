<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ConfigController extends Controller
{
    public function index(){
        return view('Back.pages.config.index');
    }
}
