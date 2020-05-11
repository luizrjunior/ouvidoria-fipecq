<?php

namespace App\Http\Controllers;

use App\Models\TipoPrestador;
use Illuminate\Http\Request;

class TipoPrestadorController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Tipo de Prestador adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Tipo de Prestador alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Tipo de Prestador removido com sucesso!";

    public function index()
    {
        $tipo_prestadors = TipoPrestador::paginate(25);
        return view('ouvidoria.tipo-prestador.index', compact('tipo_prestadors'));
    }

    public function create()
    {
        return view('ouvidoria.tipo-prestador.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $tipo_prestador = new TipoPrestador([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $tipo_prestador->save();
        return redirect('/tipo-prestador')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $tipo_prestador = TipoPrestador::find($id);
        return view('ouvidoria.tipo-prestador.edit', compact('tipo_prestador'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $tipo_prestador = TipoPrestador::find($id);
        $tipo_prestador->descricao = $request->get('descricao');
        $tipo_prestador->save();
  
        return redirect('/tipo-prestador')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $tipo_prestador = TipoPrestador::find($id);
        $tipo_prestador->delete();
   
        return redirect('/tipo-prestador')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarTipoPrestador(Request $request) {
        $tipo_prestador = TipoPrestador::find($request->tipo_prestador_id);
        $msg = "Tipo de Prestador ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($tipo_prestador->status == 1) {
            $msg = "Tipo de Prestador desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $tipo_prestador->status = $status;
        $tipo_prestador->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
