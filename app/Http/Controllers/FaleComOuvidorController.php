<?php

namespace App\Http\Controllers;

use App\Models\TipoSolicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FaleComOuvidorController extends Controller
{
    public function index()
    {
        Session::put('tipo_solicitacao_cod', NULL);
        $tipo_solicitacaos = TipoSolicitacao::where('tipo_solicitacao_status', 1)->get();
        return view('fale-com-ouvidor', compact('tipo_solicitacaos'));
    }
}
