<?php

namespace App\Http\Controllers;

use App\Models\TipoSolicitacao;
use Illuminate\Http\Request;

class TipoSolicitacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'tipo_solicitacao_nome.required' => 'O Nome precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'tipo_solicitacao_nome.max' => 'Ops, o Nome não precisa ter mais que 50 caracteres. '
        . 'Por favor, você pode verificar isso?',

        'tipo_solicitacao_descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'tipo_solicitacao_descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',

        'tipo_solicitacao_icone.required' => 'O Ícone precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'tipo_solicitacao_icone.max' => 'Ops, o Ícone não precisa ter mais que 50 caracteres. '
        . 'você pode verificar isso?',

        'tipo_solicitacao_icone.required' => 'A Cor (Bootstrap) precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'tipo_solicitacao_icone.max' => 'Ops, o Cor (Bootstrap) não precisa ter mais que 50 caracteres. '
        . 'você pode verificar isso?',

        'tipo_solicitacao_sla.required' => 'O SLA precisa ser informado. Por favor, '
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
                'tipo_solicitacao_nome'=>'required|string|max:50',
                'tipo_solicitacao_descricao'=>'required|string|max:100',
                'tipo_solicitacao_icone'=>'required|string|max:50',
                'tipo_solicitacao_cor'=>'required|string|max:50',
                'tipo_solicitacao_sla'=>'required'
            ], self::MESSAGES_ERRORS);
            
        $tipo_solicitacao = new TipoSolicitacao([
                'tipo_solicitacao_nome' => $request->get('tipo_solicitacao_nome'),
                'tipo_solicitacao_descricao' => $request->get('tipo_solicitacao_descricao'),
                'tipo_solicitacao_icone' => $request->get('tipo_solicitacao_icone'),
                'tipo_solicitacao_cor' => $request->get('tipo_solicitacao_cor'),
                'tipo_solicitacao_sla' => $request->get('tipo_solicitacao_sla'),
                'tipo_solicitacao_status'=> true
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
                'tipo_solicitacao_nome'=>'required|string|max:50',
                'tipo_solicitacao_descricao'=>'required|string|max:100',
                'tipo_solicitacao_icone'=>'required|string|max:50',
                'tipo_solicitacao_cor'=>'required|string|max:50',
                'tipo_solicitacao_sla'=>'required',
            ], self::MESSAGES_ERRORS);
  
        $tipo_solicitacao = TipoSolicitacao::find($id);
        $tipo_solicitacao->tipo_solicitacao_nome = $request->get('tipo_solicitacao_nome');
        $tipo_solicitacao->tipo_solicitacao_descricao = $request->get('tipo_solicitacao_descricao');
        $tipo_solicitacao->tipo_solicitacao_icone = $request->get('tipo_solicitacao_icone');
        $tipo_solicitacao->tipo_solicitacao_cor = $request->get('tipo_solicitacao_cor');
        $tipo_solicitacao->tipo_solicitacao_sla = $request->get('tipo_solicitacao_sla');
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
        $tipo_solicitacao = TipoSolicitacao::find($request->tipo_solicitacao_cod);
        $msg = "Tipo de Solicitação ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($tipo_solicitacao->tipo_solicitacao_status == 1) {
            $msg = "Tipo de Solicitação desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $tipo_solicitacao->tipo_solicitacao_status = $status;
        $tipo_solicitacao->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
