<?php

namespace App\Http\Controllers;

use App\Models\TipoSolicitacao;
use Illuminate\Http\Request;

class TipoSolicitacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'nome.required' => 'O Nome precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'nome.max' => 'Ops, o Nome não precisa ter mais que 50 caracteres. '
        . 'Por favor, você pode verificar isso?',

        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',

        'icone.required' => 'O Ícone precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'icone.max' => 'Ops, o Ícone não precisa ter mais que 50 caracteres. '
        . 'você pode verificar isso?',

        'icone.required' => 'A Cor (Bootstrap) precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'icone.max' => 'Ops, o Cor (Bootstrap) não precisa ter mais que 50 caracteres. '
        . 'você pode verificar isso?',

        'sla.required' => 'O SLA precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Tipo de Solicitação adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Tipo de Solicitação alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Tipo de Solicitação removido com sucesso!";

    public function index()
    {
        $tipo_solicitacaos = TipoSolicitacao::paginate(25);
        return view('ouvidoria.tipo-solicitacao.index', compact('tipo_solicitacaos'));
    }

    public function create()
    {
        return view('ouvidoria.tipo-solicitacao.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'nome'=>'required|string|max:50',
                'descricao'=>'required|string|max:100',
                'icone'=>'required|string|max:50',
                'cor'=>'required|string|max:50',
                'sla'=>'required'
            ], self::MESSAGES_ERRORS);
            
        $tipo_solicitacao = new TipoSolicitacao([
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
                'icone' => $request->get('icone'),
                'cor' => $request->get('cor'),
                'sla' => $request->get('sla'),
                'status'=> true
            ]);
        $tipo_solicitacao->save();
        return redirect('/tipo-solicitacao')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $tipo_solicitacao = TipoSolicitacao::find($id);
        return view('ouvidoria.tipo-solicitacao.edit', compact('tipo_solicitacao'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'nome'=>'required|string|max:50',
                'descricao'=>'required|string|max:100',
                'icone'=>'required|string|max:50',
                'cor'=>'required|string|max:50',
                'sla'=>'required',
            ], self::MESSAGES_ERRORS);
  
        $tipo_solicitacao = TipoSolicitacao::find($id);
        $tipo_solicitacao->nome = $request->get('nome');
        $tipo_solicitacao->descricao = $request->get('descricao');
        $tipo_solicitacao->icone = $request->get('icone');
        $tipo_solicitacao->cor = $request->get('cor');
        $tipo_solicitacao->sla = $request->get('sla');
        $tipo_solicitacao->save();
  
        return redirect('/tipo-solicitacao')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $tipo_solicitacao = TipoSolicitacao::find($id);
        $tipo_solicitacao->delete();
   
        return redirect('/tipo-solicitacao')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarTipoSolicitacao(Request $request) {
        $tipo_solicitacao = TipoSolicitacao::find($request->tipo_solicitacao_id);
        $msg = "Tipo de Solicitação ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($tipo_solicitacao->status == 1) {
            $msg = "Tipo de Solicitação desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $tipo_solicitacao->status = $status;
        $tipo_solicitacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
