<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Setor;
use Illuminate\Http\Request;

class SetorController extends Controller
{

    const MESSAGES_ERRORS = [
        'categoria_id.required' => 'A Categoria precisa ser informada. Por favor, '
        . 'você pode verificar isso?',
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Setor / Área adicionada com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Setor / Área alterada com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Setor / Área removida com sucesso!";

    public function index()
    {
        $setores = Setor::with('categoria')->paginate(25);
        return view('ouvidoria.setor.index', compact('setores'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('descricao', 'ASC')->get();
        return view('ouvidoria.setor.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'categoria_id'=>'required',
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $setor = new Setor([
                'categoria_id' => $request->get('categoria_id'),
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $setor->save();
        return redirect('/setor')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $categorias = Categoria::orderBy('descricao', 'ASC')->get();
        $setor = Setor::find($id);
        return view('ouvidoria.setor.edit', compact('categorias', 'setor'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
                'categoria_id'=>'required',
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $setor = Setor::find($id);
        $setor->categoria_id = $request->get('categoria_id');
        $setor->descricao = $request->get('descricao');
        $setor->save();
  
        return redirect('/setor')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $setor = Setor::find($id);
        $setor->delete();
   
        return redirect('/setor')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarSetor(Request $request) {
        $setor = Setor::find($request->setor_id);
        $msg = "Setor / Área ativada com sucesso!<br />&nbsp;";
        $status = true;
        if ($setor->status == 1) {
            $msg = "Setor / Área desativada com sucesso!<br />&nbsp;";
            $status = false;
        }
        $setor->status = $status;
        $setor->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
