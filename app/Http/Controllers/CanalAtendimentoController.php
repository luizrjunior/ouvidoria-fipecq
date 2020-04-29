<?php

namespace App\Http\Controllers;

use App\Models\CanalAtendimento;
use Illuminate\Http\Request;

class CanalAtendimentoController extends Controller
{

    const MESSAGES_ERRORS = [
        'canal_atendimento_descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'canal_atendimento_descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Canal de Atendimento adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Canal de Atendimento alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Canal de Atendimento removido com sucesso!";

    public function index()
    {
        $canal_atendimentos = CanalAtendimento::paginate(25);
        return view('ouvidoria.canal-atendimento.index', compact('canal_atendimentos'));
    }

    public function create()
    {
        return view('ouvidoria.canal-atendimento.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'canal_atendimento_descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $canal_atendimento = new CanalAtendimento([
                'canal_atendimento_descricao' => $request->get('canal_atendimento_descricao'),
                'canal_atendimento_status'=> true
            ]);
        $canal_atendimento->save();
        return redirect('/canal-atendimento')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $canal_atendimento = CanalAtendimento::find($id);
        return view('ouvidoria.canal-atendimento.edit', compact('canal_atendimento'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'canal_atendimento_descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $canal_atendimento = CanalAtendimento::find($id);
        $canal_atendimento->canal_atendimento_descricao = $request->get('canal_atendimento_descricao');
        $canal_atendimento->save();
  
        return redirect('/canal-atendimento')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $canal_atendimento = CanalAtendimento::find($id);
        $canal_atendimento->delete();
   
        return redirect('/canal-atendimento')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarCanalAtendimento(Request $request) {
        $canal_atendimento = CanalAtendimento::find($request->canal_atendimento_cod);
        $msg = "Canal de Atendimento ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($canal_atendimento->canal_atendimento_status == 1) {
            $msg = "Canal de Atendimento desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $canal_atendimento->canal_atendimento_status = $status;
        $canal_atendimento->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
