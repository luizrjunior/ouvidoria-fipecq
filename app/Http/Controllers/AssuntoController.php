<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Assunto adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Assunto alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Assunto removido com sucesso!";

    public function index()
    {
        $assuntos = Assunto::paginate(25);
        return view('ouvidoria.assunto.index', compact('assuntos'));
    }

    public function create()
    {
        return view('ouvidoria.assunto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $assunto = new Assunto([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $assunto->save();
        return redirect('/assunto')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $assunto = Assunto::find($id);
        return view('ouvidoria.assunto.edit', compact('assunto'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $assunto = Assunto::find($id);
        $assunto->descricao = $request->get('descricao');
        $assunto->save();
  
        return redirect('/assunto')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $assunto = Assunto::find($id);
        $assunto->delete();
   
        return redirect('/assunto')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarAssunto(Request $request) {
        $assunto = Assunto::find($request->assunto_id);
        $msg = "Assunto ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($assunto->status == 1) {
            $msg = "Assunto desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $assunto->status = $status;
        $assunto->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
