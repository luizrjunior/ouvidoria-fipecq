<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{

    public function relatorioTipoOuvidoria(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $ouvidorias = $this->getOuvidoriasPorTipoSolicitacao($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-tipo-solicitacao-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-tipo-solicitacao', 
            compact('ouvidorias', 'data'));
    }

    private function getOuvidoriasPorTipoSolicitacao(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::where(function ($query) use ($data) {
            if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
            }
            if (isset($data['data_termino']) && $data['data_termino'] != "") {
                $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
            }
        })->orderBy('tp_ouvidoria_id')->get();
    }

    public function obterPercentual($percentage, $of)
    {
        $percent = $percentage / $of;
        return  number_format( $percent * 100, 2 ) . '%';;
    }    

}

