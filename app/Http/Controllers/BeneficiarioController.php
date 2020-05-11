<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{

    public function index()
    {
        $beneficiarios = Beneficiario::paginate(25);
        return $beneficiarios;
    }

}
