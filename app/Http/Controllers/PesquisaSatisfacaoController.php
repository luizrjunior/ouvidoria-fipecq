<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\PesquisaSatisfacao;
use Illuminate\Http\Request;

class PesquisaSatisfacaoController extends Controller
{

    const MESSAGES_ERRORS = [
        'resposta_3.max' => 'Ops, a Sugestão não precisa ter mais que 1200 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];
    const MESSAGE_ADD_SUCCESS = "Pesquisa de Satisfação registrada com sucesso!";
    const MESSAGE_EXISTS = "Esta Pesquisa de Satisfação já foi respondida!";
    const MESSAGE_OUVIDORIA_NOT_EXISTS = "Ouvidoria não encontrada!";
    const MESSAGE_OUVIDORIA_NOT_FINAL = "Esta Ouvidoria não foi concluída!";

    public function create(int $ouvidoria_id)
    {
        $pesquisaSatisfacao = PesquisaSatisfacao::where('ouvidoria_id', $ouvidoria_id)->get();
        if (count($pesquisaSatisfacao) > 0) {
            return redirect('/home')->with('message', self::MESSAGE_EXISTS);
        }
        $ouvidoria = Ouvidoria::find($ouvidoria_id);
        if ($ouvidoria->id == "") {
            return redirect('/home')->with('message', self::MESSAGE_OUVIDORIA_NOT_EXISTS);
        }
        if ($ouvidoria->id != "") {
            if ($ouvidoria->situacao_id != 3) {
                return redirect('/home')->with('message', self::MESSAGE_OUVIDORIA_NOT_FINAL);
            }
        }
        return view('ouvidoria.pesquisa-satisfacao.create', compact('ouvidoria_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
                'resposta_3' => 'nullable|string|max:1200',
            ], self::MESSAGES_ERRORS);
            
        $pesquisaSatisfacao = new PesquisaSatisfacao([
                'ouvidoria_id' => $request->ouvidoria_id,
                'resposta_1' => $request->resposta_1,
                'resposta_2' => $request->resposta_2,
                'resposta_3'=> $request->resposta_3
            ]);
        $pesquisaSatisfacao->save();

        return redirect('/home')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

}
