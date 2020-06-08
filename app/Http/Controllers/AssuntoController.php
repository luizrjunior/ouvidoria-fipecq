<?php

namespace App\Http\Controllers;

use App\Models\Setor;
use App\Models\Assunto;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{

    const MESSAGES_ERRORS = [
        'setor_id.required' => 'O Setor precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
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
        $assuntos = Assunto::with('setor')->paginate(25);
        return view('ouvidoria.assunto.index', compact('assuntos'));
    }

    public function create()
    {
        $setores = Setor::orderBy('descricao', 'ASC')->get();
        return view('ouvidoria.assunto.create', compact('setores'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'setor_id'=>'required',
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $assunto = new Assunto([
                'setor_id' => $request->get('setor_id'),
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $assunto->save();
        return redirect('/assunto')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $setores = Setor::orderBy('descricao', 'ASC')->get();
        $assunto = Assunto::find($id);
        return view('ouvidoria.assunto.edit', compact('setores', 'assunto'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'setor_id'=>'required',
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $assunto = Assunto::find($id);
        $assunto->setor_id = $request->get('setor_id');
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
