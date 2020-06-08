<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{

    const MESSAGES_ERRORS = [
        'descricao.required' => 'A Descrição precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'descricao.max' => 'Ops, a Descrição não precisa ter mais que 100 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Categoria adicionada com sucesso!";
    const MESSAGE_UPDATE_SUCCESS = "Categoria alterada com sucesso!";
    const MESSAGE_DESTROY_SUCCESS = "Categoria removida com sucesso!";

    public function index()
    {
        $categorias = Categoria::paginate(25);
        return view('ouvidoria.categoria.index', compact('categorias'));
    }

    public function create()
    {
        return view('ouvidoria.categoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
                'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
            
        $categoria = new Categoria([
                'descricao' => $request->get('descricao'),
                'status'=> true
            ]);
        $categoria->save();
        return redirect('/categoria')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function edit(int $id)
    {
        $categoria = Categoria::find($id);
        return view('ouvidoria.categoria.edit', compact('categoria'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'descricao'=>'required|string|max:100'
            ], self::MESSAGES_ERRORS);
  
        $categoria = Categoria::find($id);
        $categoria->descricao = $request->get('descricao');
        $categoria->save();
  
        return redirect('/categoria')->with('success', self::MESSAGE_UPDATE_SUCCESS);
    }

    public function destroy(int $id)
    {
        $categoria = Categoria::find($id);
        $categoria->delete();
   
        return redirect('/categoria')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function ativarDesativarCategoria(Request $request) {
        $categoria = Categoria::find($request->categoria_id);
        $msg = "Categoria ativado com sucesso!<br />&nbsp;";
        $status = true;
        if ($categoria->status == 1) {
            $msg = "Categoria desativado com sucesso!<br />&nbsp;";
            $status = false;
        }
        $categoria->status = $status;
        $categoria->save();

        $dados = array();
        $dados['textoMsg'] = $msg;

        return response()->json($dados, 200);
    }

}
