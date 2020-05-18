<?php

namespace App\Http\Controllers;

use App\Models\TipoOuvidoria;
use Illuminate\Http\Request;

class TipoOuvidoriaController extends Controller
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
    const MESSAGE_ADD_SUCCESS = "Tipo de Ouvidoria adicionado com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Tipo de Ouvidoria alterado com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Tipo de Ouvidoria removido com sucesso!";

    public function index()
    {
        $tiposOuvidorias = TipoOuvidoria::paginate(25);
        return view('ouvidoria.tipo-ouvidoria.index', compact('tiposOuvidorias'));
    }

    public function create()
    {
        return view('ouvidoria.tipo-ouvidoria.create');
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
            
        $tipoOuvidoria = new TipoOuvidoria([
                'nome' => $request->get('nome'),
                'descricao' => $request->get('descricao'),
                'icone' => $request->get('icone'),
                'cor' => $request->get('cor'),
                'sla' => $request->get('sla'),
                'status'=> true
            ]);
        $tipoOuvidoria->save();
        return redirect('/tipo-ouvidoria')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $tipoOuvidoria = TipoOuvidoria::find($id);
        return view('ouvidoria.tipo-ouvidoria.edit', compact('tipoOuvidoria'));
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
  
        $tipoOuvidoria = TipoOuvidoria::find($id);
        $tipoOuvidoria->nome = $request->get('nome');
        $tipoOuvidoria->descricao = $request->get('descricao');
        $tipoOuvidoria->icone = $request->get('icone');
        $tipoOuvidoria->cor = $request->get('cor');
        $tipoOuvidoria->sla = $request->get('sla');
        $tipoOuvidoria->save();
  
        return redirect('/tipo-ouvidoria')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $tipoOuvidoria = TipoOuvidoria::find($id);
        $tipoOuvidoria->delete();
   
        return redirect('/tipo-ouvidoria')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarTipoOuvidoria(Request $request) {
        $tipoOuvidoria = TipoOuvidoria::find($request->tipo_ouvidoria_id);
        $msg = "Tipo de Ouvidoria ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($tipoOuvidoria->status == 1) {
            $msg = "Tipo de Ouvidoria desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $tipoOuvidoria->status = $status;
        $tipoOuvidoria->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
