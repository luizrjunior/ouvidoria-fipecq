<?php

namespace App\Http\Controllers;

use App\Models\Beneficiario;
use App\Models\PlanoBeneficiario;

use Illuminate\Http\Request;

class BeneficiarioController extends Controller
{

    public function index()
    {
        $cpf = '88260429187';
        $benef = Beneficiario::select(
                'cad_benef.matricula', 
                'cad_benef.nome', 
                'cad_benef.cic',
                'cad_benef.email',
                'cad_cidade.nome as nocidade',
                'cad_cidade.estado'
            )
            ->join('plano.cad_cidade', 'cad_benef.cidade', '=', 'plano.cad_cidade.cidade')
            ->where('cad_benef.cic', $cpf)->get();

        $planoBenef = PlanoBeneficiario::select('empresa')->where('matricula', $benef[0]->matricula)
            ->orderBy('data_contrato', 'DESC')->get();

        return var_dump($benef[0], $planoBenef[0]);
    }

}
