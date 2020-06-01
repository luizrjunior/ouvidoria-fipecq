<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\Beneficiario;
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


    public function relatorioFaixaEtaria(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $faixasEtarias = $this->getOuvidoriasPorFaixaEtaria($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-faixa-etaria-print', 
                compact('faixasEtarias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-faixa-etaria', 
            compact('faixasEtarias', 'data'));
    }

    private function getOuvidoriasPorFaixaEtaria(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        $ouvidorias = Ouvidoria::where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('tp_ouvidoria_id')->get();

        $faixaEtaria24_28 = 0;
        $faixaEtaria29_33 = 0;
        $faixaEtaria34_38 = 0;
        $faixaEtaria39_43 = 0;
        $faixaEtaria44_48 = 0;
        $faixaEtaria49_53 = 0;
        $faixaEtaria54_58 = 0;
        $faixaEtaria59 = 0;
        foreach ($ouvidorias as $ouvidoria) {
            $cpf = $this->limpaCPF_CNPJ($ouvidoria->solicitante->cpf);
            $benef = Beneficiario::select(
                    'cad_benef.nascimento'
                )->where('cad_benef.cic', $cpf)->get();

            if (count($benef) > 0) {
                $dataNascimento = $benef[0]->nascimento;
                $date = new \DateTime($dataNascimento);
                $interval = $date->diff(new \DateTime( date('Y-m-d')));
                $idade = (int) $interval->format('%Y');
                if ($idade >= 24 && $idade <= 28) {
                    $faixaEtaria24_28++;
                }
                if ($idade >= 29 && $idade <= 33) {
                    $faixaEtaria29_33++;
                }
                if ($idade >= 34 && $idade <= 38) {
                    $faixaEtaria34_38++;
                }
                if ($idade >= 39 && $idade <= 43) {
                    $faixaEtaria39_43++;
                }
                if ($idade >= 44 && $idade <= 48) {
                    $faixaEtaria44_48++;
                }
                if ($idade >= 49 && $idade <= 53) {
                    $faixaEtaria49_53++;
                }
                if ($idade >= 54 && $idade <= 58) {
                    $faixaEtaria54_58++;
                }
                if ($idade >= 59) {
                    $faixaEtaria59++;
                }
            }
        }

        $faixasEtarias = array();
        $faixasEtarias[0]['nome'] = "24 - 28 Anos";
        $faixasEtarias[0]['qtde'] = $faixaEtaria24_28;

        $faixasEtarias[1]['nome'] = "29 - 33 Anos";
        $faixasEtarias[1]['qtde'] = $faixaEtaria29_33;

        $faixasEtarias[2]['nome'] = "34 - 38 Anos";
        $faixasEtarias[2]['qtde'] = $faixaEtaria34_38;

        $faixasEtarias[3]['nome'] = "39 - 43 Anos";
        $faixasEtarias[3]['qtde'] = $faixaEtaria39_43;

        $faixasEtarias[4]['nome'] = "44 - 48 Anos";
        $faixasEtarias[4]['qtde'] = $faixaEtaria44_48;

        $faixasEtarias[5]['nome'] = "49 - 53 Anos";
        $faixasEtarias[5]['qtde'] = $faixaEtaria49_53;

        $faixasEtarias[6]['nome'] = "54 - 58 Anos";
        $faixasEtarias[6]['qtde'] = $faixaEtaria54_58;

        $faixasEtarias[7]['nome'] = "De 59 Anos ou mais";
        $faixasEtarias[7]['qtde'] = $faixaEtaria59;

        return $faixasEtarias;
    }


    public function relatorioInstitutora(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $ouvidorias = $this->getOuvidoriasPorInstitutora($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-institutora-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-institutora', 
            compact('ouvidorias', 'data'));
    }

    private function getOuvidoriasPorInstitutora(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::select(
                'cad_empresa.nome as noempresa',
                'fv_ouv_solicitante.institutora_id as idinstitutora'
            )
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->join('plano.cad_empresa', 'fv_ouv_solicitante.institutora_id', 'cad_empresa.empresa')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('cad_empresa.nome')->get();
    }


    public function obterPercentual($percentage, $of)
    {
        $percent = $percentage / $of;
        return  number_format( $percent * 100, 2 ) . '%';;
    }

    private function limpaCPF_CNPJ($valor)
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }

    private function calcularIdade($date){
        $time = strtotime($date);
        if($time === false){
          return '';
        }
     
        $year_diff = '';
        $date = date('Y-m-d', $time);
        list($year,$month,$day) = explode('-',$date);
        $year_diff = date('Y') - $year;
        $month_diff = date('m') - $month;
        $day_diff = date('d') - $day;
        if ($day_diff < 0 || $month_diff < 0) {
            $year_diff--;
        }
     
        return $year_diff;
    }
    

}

