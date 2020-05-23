<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\PesquisaSatisfacao;
use Illuminate\Http\Request;

class PesquisaSatisfacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'resposta_3.max' => 'Ops, a Sugestão não precisa ter mais que 1200 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Pesquisa de Satisfação registrada com sucesso!";
    const MESSAGE_EXISTS = "Esta Pesquisa de Satisfação já foi respondida!";
    const MESSAGE_OUVIDORIA_NOT_EXISTS = "Ouvidoria não encontrada!";
    const MESSAGE_OUVIDORIA_NOT_FINAL = "Esta Ouvidoria não foi concluída!";

    public function create(int $ouvidoria_id)
    {
        $pesquisaSatisfacao = PesquisaSatisfacao::where('ouvidoria_id', $ouvidoria_id)->get();
        if (count($pesquisaSatisfacao) > 0) {
            return redirect('/home')->with('message', self::MESSAGE_EXISTS);
        }
        $ouvidoria = Ouvidoria::find($ouvidoria_id);
        if ($ouvidoria->id == "") {
            return redirect('/home')->with('message', self::MESSAGE_OUVIDORIA_NOT_EXISTS);
        }
        if ($ouvidoria->id != "") {
            if ($ouvidoria->situacao_id != 3) {
                return redirect('/home')->with('message', self::MESSAGE_OUVIDORIA_NOT_FINAL);
            }
        }
        return view('ouvidoria.pesquisa-satisfacao.create', compact('ouvidoria_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'resposta_3' => 'nullable|string|max:1200',
            ], self::MESSAGES_ERRORS);
            
        $pesquisaSatisfacao = new PesquisaSatisfacao([
                'ouvidoria_id' => $request->ouvidoria_id,
                'resposta_1' => $request->resposta_1,
                'resposta_2' => $request->resposta_2,
                'resposta_3'=> $request->resposta_3
            ]);
        $pesquisaSatisfacao->save();

        return redirect('/home')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function relatorio(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['resposta_1_psq'])) {
            $data['resposta_1_psq'] = "";
        }

        if (empty($data['resposta_2_psq'])) {
            $data['resposta_2_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $pesquisasSatisfacao = $this->getPesquisasSatisfacao($data);

        $respostas_1 = [
            ['id' => '', 'nome' => 'Todos'], 
            ['id' => '1', 'nome' => 'Sim'], 
            ['id' => '2', 'nome' => 'Não'], 
            ['id' => '3', 'nome' => 'Parcialmente Atendida']
        ];
        $respostas_2 = [
            ['id' => '', 'nome' => 'Todos'], 
            ['id' => '1', 'nome' => 'Satisfeito'], 
            ['id' => '2', 'nome' => 'Insatisfeito'], 
            ['id' => '3', 'nome' => 'Totalmente Insatisfeito']
        ];

        // dd($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.pesquisa-satisfacao.relatorio-print', 
                compact('respostas_1', 'respostas_2', 'pesquisasSatisfacao', 'data'));
        }
        return view('ouvidoria.pesquisa-satisfacao.relatorio', 
            compact('respostas_1', 'respostas_2', 'pesquisasSatisfacao', 'data'));
    }

    private function getPesquisasSatisfacao(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return PesquisaSatisfacao::where(function ($query) use ($data) {
            if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
            }
            if (isset($data['data_termino']) && $data['data_termino'] != "") {
                $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
            }
            if (isset($data['resposta_1_psq']) && $data['resposta_1_psq'] != "") {
                $query->where('resposta_1', $data['resposta_1_psq']);
            }
            if (isset($data['resposta_2_psq']) && $data['resposta_2_psq'] != "") {
                $query->where('resposta_2', $data['resposta_2_psq']);
            }
        })->get();
    }

}
