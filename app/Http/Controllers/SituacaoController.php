<?php

namespace App\Http\Controllers;

use App\Models\Situacao;
use Illuminate\Http\Request;

class SituacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Situação adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Situação alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Situação removido com sucesso!";

    public function index()
    {
        $situacaos = Situacao::paginate(25);
        return view('ouvidoria.situacao.index', compact('situacaos'));
    }

    public function create()
    {
        return view('ouvidoria.situacao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $situacao = new Situacao([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $situacao->save();
        return redirect('/situacao')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $situacao = Situacao::find($id);
        return view('ouvidoria.situacao.edit', compact('situacao'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $situacao = Situacao::find($id);
        $situacao->descricao = $request->get('descricao');
        $situacao->save();
  
        return redirect('/situacao')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $situacao = Situacao::find($id);
        $situacao->delete();
   
        return redirect('/situacao')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarSituacao(Request $request) {
        $situacao = Situacao::find($request->situacao_id);
        $msg = "Situação ativada com sucesso!<br />&nbsp;";
        $status = true;
        if ($situacao->status == 1) {
            $msg = "Situação desativada com sucesso!<br />&nbsp;";
            $status = false;
        }
        $situacao->status = $status;
        $situacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
