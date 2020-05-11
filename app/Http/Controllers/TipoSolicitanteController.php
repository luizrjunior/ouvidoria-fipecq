<?php

namespace App\Http\Controllers;

use App\Models\TipoSolicitante;
use Illuminate\Http\Request;

class TipoSolicitanteController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Tipo de Solicitante adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Tipo de Solicitante alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Tipo de Solicitante removido com sucesso!";

    public function index()
    {
        $tipo_solicitantes = TipoSolicitante::paginate(25);
        return view('ouvidoria.tipo-solicitante.index', compact('tipo_solicitantes'));
    }

    public function create()
    {
        return view('ouvidoria.tipo-solicitante.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $tipo_solicitante = new TipoSolicitante([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $tipo_solicitante->save();
        return redirect('/tipo-solicitante')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $tipo_solicitante = TipoSolicitante::find($id);
        return view('ouvidoria.tipo-solicitante.edit', compact('tipo_solicitante'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $tipo_solicitante = TipoSolicitante::find($id);
        $tipo_solicitante->descricao = $request->get('descricao');
        $tipo_solicitante->save();
  
        return redirect('/tipo-solicitante')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $tipo_solicitante = TipoSolicitante::find($id);
        $tipo_solicitante->delete();
   
        return redirect('/tipo-solicitante')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarTipoSolicitante(Request $request) {
        $tipo_solicitante = TipoSolicitante::find($request->tipo_solicitante_id);
        $msg = "Tipo de Solicitante ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($tipo_solicitante->status == 1) {
            $msg = "Tipo de Solicitante desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $tipo_solicitante->status = $status;
        $tipo_solicitante->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
