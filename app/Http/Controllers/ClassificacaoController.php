<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use Illuminate\Http\Request;

class ClassificacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Classificação adicionada com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Classificação alterada com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Classificação removida com sucesso!";

    public function index()
    {
        $classificacaos = Classificacao::paginate(25);
        return view('ouvidoria.classificacao.index', compact('classificacaos'));
    }

    public function create()
    {
        return view('ouvidoria.classificacao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $classificacao = new Classificacao([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $classificacao->save();
        return redirect('/classificacao')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $classificacao = Classificacao::find($id);
        return view('ouvidoria.classificacao.edit', compact('classificacao'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $classificacao = Classificacao::find($id);
        $classificacao->descricao = $request->get('descricao');
        $classificacao->save();
  
        return redirect('/classificacao')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $classificacao = Classificacao::find($id);
        $classificacao->delete();
   
        return redirect('/classificacao')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarClassificacao(Request $request) {
        $classificacao = Classificacao::find($request->classificacao_id);
        $msg = "Classificação ativada com sucesso!<br />&nbsp;";
        $status = true;
        if ($classificacao->status == 1) {
            $msg = "Classificação desativada com sucesso!<br />&nbsp;";
            $status = false;
        }
        $classificacao->status = $status;
        $classificacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
