<?php

namespace App\Http\Controllers;

use App\Models\TipoOuvidoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaleComOuvidorController extends Controller
{
    public function index()
    {
        Session::put('tipo_ouvidoria_id', NULL);
        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        return view('fale-com-ouvidor', compact('tiposOuvidorias'));
    }
}
