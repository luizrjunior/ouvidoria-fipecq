<?php

namespace App\Http\Controllers;

use App\Models\Institutora;
use Illuminate\Http\Request;

class InstitutoraController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Institutora adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Institutora alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Institutora removido com sucesso!";

    public function index()
    {
        $institutoras = Institutora::paginate(25);
        return view('ouvidoria.institutora.index', compact('institutoras'));
    }

    public function create()
    {
        return view('ouvidoria.institutora.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $institutora = new Institutora([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $institutora->save();
        return redirect('/institutora')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $institutora = Institutora::find($id);
        return view('ouvidoria.institutora.edit', compact('institutora'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $institutora = Institutora::find($id);
        $institutora->descricao = $request->get('descricao');
        $institutora->save();
  
        return redirect('/institutora')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $institutora = Institutora::find($id);
        $institutora->delete();
   
        return redirect('/institutora')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarInstitutora(Request $request) {
        $institutora = Institutora::find($request->institutora_id);
        $msg = "Institutora ativada com sucesso!<br />&nbsp;";
        $status = true;
        if ($institutora->status == 1) {
            $msg = "Institutora desativada com sucesso!<br />&nbsp;";
            $status = false;
        }
        $institutora->status = $status;
        $institutora->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
