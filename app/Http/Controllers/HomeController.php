<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

    public function index()
    {
        Session::put('perfil', "anonimo");
        return view('home');
    }

    public function admin()
    {
        Session::put('perfil', "admin");
        return view('home');
    }

}
