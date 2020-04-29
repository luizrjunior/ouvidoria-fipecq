<?php

namespace App\Http\Controllers;

use App\Models\Classificacao;
use App\Models\SubClassificacao;
use Illuminate\Http\Request;

class SubClassificacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'classificacao_cod.required' => 'A Classificação precisa ser informada. Por favor, '
        . 'você pode verificar isso?',
        'sub_classificacao_descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'sub_classificacao_descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "SubClassificação adicionada com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "SubClassificação alterada com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "SubClassificação removida com sucesso!";

    public function index()
    {
        $sub_classificacaos = SubClassificacao::with('classificacao')->paginate(25);
        return view('ouvidoria.sub-classificacao.index', compact('sub_classificacaos'));
    }

    public function create()
    {
        $classificacaos = Classificacao::orderBy('classificacao_descricao', 'ASC')->get();
        return view('ouvidoria.sub-classificacao.create', compact('classificacaos'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'classificacao_cod'=>'required',
                'sub_classificacao_descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $sub_classificacao = new SubClassificacao([
                'classificacao_cod' => $request->get('classificacao_cod'),
                'sub_classificacao_descricao' => $request->get('sub_classificacao_descricao'),
                'sub_classificacao_status'=> true
            ]);
        $sub_classificacao->save();
        return redirect('/sub-classificacao')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $classificacaos = Classificacao::orderBy('classificacao_descricao', 'ASC')->get();
        $sub_classificacao = SubClassificacao::find($id);
        return view('ouvidoria.sub-classificacao.edit', compact('classificacaos', 'sub_classificacao'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'classificacao_cod'=>'required',
                'sub_classificacao_descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $sub_classificacao = SubClassificacao::find($id);
        $sub_classificacao->classificacao_cod = $request->get('classificacao_cod');
        $sub_classificacao->sub_classificacao_descricao = $request->get('sub_classificacao_descricao');
        $sub_classificacao->save();
  
        return redirect('/sub-classificacao')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $sub_classificacao = SubClassificacao::find($id);
        $sub_classificacao->delete();
   
        return redirect('/sub-classificacao')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarSubClassificacao(Request $request) {
        $sub_classificacao = SubClassificacao::find($request->sub_classificacao_cod);
        $msg = "SubClassificação ativada com sucesso!<br />&nbsp;";
        $status = true;
        if ($sub_classificacao->sub_classificacao_status == 1) {
            $msg = "SubClassificação desativada com sucesso!<br />&nbsp;";
            $status = false;
        }
        $sub_classificacao->sub_classificacao_status = $status;
        $sub_classificacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
