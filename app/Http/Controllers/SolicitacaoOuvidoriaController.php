<?php

namespace App\Http\Controllers;

use App\Mail\SendMailOuvidoria;
use App\Models\Institutora;
use App\Models\TipoSolicitacao;
use App\Models\SolicitacaoOuvidoria;
use App\Models\TipoSolicitante;
use App\Models\Solicitante;
use App\Models\UF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SolicitacaoOuvidoriaController extends Controller
{
    const MESSAGES_ERRORS = [
        'tipo_solicitacao_cod.required' => 'O Tipo de Solicitação precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'tipo_solicitante_cod.required' => 'O Tipo de Solicitante - Você é precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_cpf.required' => 'O CPF precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'solicitante_cpf.cpf' => 'O CPF precisa ser válido. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_nome.required' => 'O Nome precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'institutora_cod.required' => 'A Institutora/Empresa precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_uf.required' => 'O Estado precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_cidade.required' => 'A Cidade precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_email.required' => 'O E-mail precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'solicitante_email.email' => 'Ops, E-mail precisa ser um endereço de e-mail válido. Por favor, '
        . 'você pode verificar isso?',

        'solicitante_celular.required' => 'O Celular precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'solicitacao_ouvidoria_mensagem.required' => 'A Mensagem precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
    ];

    const MESSAGE_ADD_SUCCESS = "A sua demanda foi recebida com sucesso. Em breve você será contatado.
    <br />O número do protocolo da sua demanda é: ";

    const MESSAGE_UPDATE_SUCCESS = "Solicitação de Ouvidoria alterado com sucesso!";

    const MESSAGE_DESTROY_SUCCESS = "Solicitação de Ouvidoria removido com sucesso!";

    const UFS = [
        ["uf_sigla" => "AC", "uf_descricao" => "ACRE"],
        ["uf_sigla" => "AL", "uf_descricao" => "ALAGOAS"],
        ["uf_sigla" => "AP", "uf_descricao" => "AMAPÁ"],
        ["uf_sigla" => "AM", "uf_descricao" => "AMAZONAS"],
        ["uf_sigla" => "BA", "uf_descricao" => "BAHIA"],
        ["uf_sigla" => "CE", "uf_descricao" => "CEARÁ"],
        ["uf_sigla" => "DF", "uf_descricao" => "DISTRITO FEDERAL"],
        ["uf_sigla" => "ES", "uf_descricao" => "ESPÍRITO SANTO"],
        ["uf_sigla" => "GO", "uf_descricao" => "GOIÁS"],
        ["uf_sigla" => "MA", "uf_descricao" => "MARANHÃO"],
        ["uf_sigla" => "MG", "uf_descricao" => "MINAS GERAIS"],
        ["uf_sigla" => "MT", "uf_descricao" => "MATO GROSSO"],
        ["uf_sigla" => "MS", "uf_descricao" => "MATO GROSSO DO SUL"],
        ["uf_sigla" => "PA", "uf_descricao" => "PARÁ"],
        ["uf_sigla" => "PB", "uf_descricao" => "PARAÍBA"],
        ["uf_sigla" => "PR", "uf_descricao" => "PARANÁ"],
        ["uf_sigla" => "PE", "uf_descricao" => "PERNAMBUCO"],
        ["uf_sigla" => "PI", "uf_descricao" => "PIAUÍ"],
        ["uf_sigla" => "RJ", "uf_descricao" => "RIO DE JANEIRO"],
        ["uf_sigla" => "RN", "uf_descricao" => "RIO GRANDE DO NORTE"],
        ["uf_sigla" => "RS", "uf_descricao" => "RIO GRANDE DO SUL"],
        ["uf_sigla" => "RO", "uf_descricao" => "RONDÔNIA"],
        ["uf_sigla" => "RR", "uf_descricao" => "RORAIMA"],
        ["uf_sigla" => "SC", "uf_descricao" => "SANTA CATARINA"],
        ["uf_sigla" => "SP", "uf_descricao" => "SÃO PAULO"],
        ["uf_sigla" => "SE", "uf_descricao" => "SERGIPE"],
        ["uf_sigla" => "TO", "uf_descricao" => "TOCANTINS"]
    ];

    public function index(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['solicitante_cpf_psq'])) {
            $data['solicitante_cpf_psq'] = "";
        }

        if (empty($data['solicitante_nome_psq'])) {
            $data['solicitante_nome_psq'] = "";
        }

        if (empty($data['tipo_solicitacao_cod_psq'])) {
            $data['tipo_solicitacao_cod_psq'] = "";
        }

        if (empty($data['tipo_solicitante_cod_psq'])) {
            $data['tipo_solicitante_cod_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $solicitacao_ouvidorias = $this->getSolicitacaoOuvidorias($data);

        $tipo_solicitacaos = TipoSolicitacao::get();
        $tipo_solicitantes = TipoSolicitante::get();

        return view('ouvidoria.solicitacao-ouvidoria.index', 
            compact('tipo_solicitacaos', 'tipo_solicitantes', 'solicitacao_ouvidorias', 'data'));
    }

    private function getSolicitacaoOuvidorias(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }
        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return SolicitacaoOuvidoria::select('solicitacao_ouvidoria.solicitacao_ouvidoria_cod',
                'solicitacao_ouvidoria.solicitacao_ouvidoria_protocolo as protocolo',
                'tipo_solicitacao.tipo_solicitacao_nome as noTipoSolicitacao',
                'tipo_solicitante.tipo_solicitante_descricao as dsTipoSolicitante',
                'solicitante.solicitante_nome as noSolicitante',
                'solicitacao_ouvidoria.created_at as dtCriacao')
            ->join('tipo_solicitacao', 'solicitacao_ouvidoria.tipo_solicitacao_cod', '=', 'tipo_solicitacao.tipo_solicitacao_cod')
            ->join('solicitante', 'solicitacao_ouvidoria.solicitante_cod', '=', 'solicitante.solicitante_cod')
            ->join('tipo_solicitante', 'solicitante.tipo_solicitante_cod', '=', 'tipo_solicitante.tipo_solicitante_cod')
            ->where(function ($query) use ($data) {
                if (isset($data['solicitacao_ouvidoria_protocolo_psq']) && $data['solicitacao_ouvidoria_protocolo_psq'] != "") {
                    $query->where('solicitacao_ouvidoria.solicitacao_ouvidoria_protocolo', '=', $data['solicitacao_ouvidoria_protocolo_psq']);
                }
                if (isset($data['solicitante_cpf_psq']) && $data['solicitante_cpf_psq'] != "") {
                    $query->where('solicitante.solicitante_cpf', '=', $data['solicitante_cpf_psq']);
                }
                if (isset($data['solicitante_nome_psq']) && $data['solicitante_nome_psq'] != "") {
                    $query->where('solicitante.solicitante_nome', 'LIKE', "%" . $data['solicitante_nome_psq'] . "%");
                }
                if (isset($data['tipo_solicitacao_cod_psq']) && $data['tipo_solicitacao_cod_psq'] != "") {
                    $query->where('solicitacao_ouvidoria.tipo_solicitacao_cod', $data['tipo_solicitacao_cod_psq']);
                }
                if (isset($data['tipo_solicitante_cod_psq']) && $data['tipo_solicitante_cod_psq'] != "") {
                    $query->where('solicitante.tipo_solicitante_cod', $data['tipo_solicitante_cod_psq']);
                }
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('solicitacao_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('solicitacao_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('solicitacao_ouvidoria.created_at')->paginate($data['totalPage']);
            // })->toSql();
    }

    public function create(Request $request)
    {   
        $tipo_solicitacao_cod = $request->tipo_solicitacao_cod;
        $tipo_solicitacaos = TipoSolicitacao::get();
        $tipo_solicitantes = TipoSolicitante::get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;

        return view('ouvidoria.solicitacao-ouvidoria.create', compact(
            'tipo_solicitacao_cod', 'tipo_solicitacaos', 'tipo_solicitantes', 'institutoras', 'ufs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_solicitacao_cod'=>'required',
            'tipo_solicitante_cod'=>'required',
            'solicitante_cpf'=>'required|cpf',
            'solicitante_nome'=>'required|max:120',
            'institutora_cod'=>'required',
            'solicitante_uf'=>'required',
            'solicitante_cidade'=>'required|max:120',
            'solicitante_email'=>'required|max:120',
            'solicitante_celular'=>'required|max:15',
            'solicitacao_ouvidoria_mensagem'=>'required|max:255',
        ], self::MESSAGES_ERRORS);

        if ($request->solicitante_cod == "") {
            $solicitante = new Solicitante([
                'solicitante_cpf' => $request->solicitante_cpf,
                'solicitante_nome' => $request->solicitante_nome,
                'solicitante_email' => $request->solicitante_email,
                'solicitante_telefone' => $request->solicitante_telefone,
                'solicitante_celular' => $request->solicitante_celular,
                'solicitante_uf' => $request->solicitante_uf,
                'solicitante_cidade' => $request->solicitante_cidade,
                'institutora_cod' => $request->institutora_cod,
                'tipo_solicitante_cod' => $request->tipo_solicitante_cod,
            ]);
        } else {
            $solicitante = Solicitante::find($request->solicitante_cod);
            $solicitante->solicitante_cpf = $request->solicitante_cpf;
            $solicitante->solicitante_nome = $request->solicitante_nome;
            $solicitante->solicitante_email = $request->solicitante_email;
            $solicitante->solicitante_telefone = $request->solicitante_telefone;
            $solicitante->solicitante_celular = $request->solicitante_celular;
            $solicitante->solicitante_uf = $request->solicitante_uf;
            $solicitante->solicitante_cidade = $request->solicitante_cidade;
            $solicitante->institutora_cod = $request->institutora_cod;
            $solicitante->tipo_solicitante_cod = $request->tipo_solicitante_cod;
        }
        $solicitante->save();

        $solicitacao_ouvidoria_protocolo = SolicitacaoOuvidoria::get();
        $numero = count($solicitacao_ouvidoria_protocolo)+1;
        $protocolo = $numero . date('dmY');

        $solicitacao_ouvidoria_anexo = $this->anexarArquivo($request);
        
        $solicitacao_ouvidoria = new SolicitacaoOuvidoria([
            'solicitacao_ouvidoria_protocolo' => $protocolo,
            'solicitacao_ouvidoria_mensagem' => trim($request->solicitacao_ouvidoria_mensagem),
            'solicitacao_ouvidoria_anexo' => $solicitacao_ouvidoria_anexo,
            'tipo_solicitacao_cod' => $request->tipo_solicitacao_cod,
            'solicitante_cod' => $solicitante->solicitante_cod
        ]);
        $solicitacao_ouvidoria->save();

        $this->enviarEmailSolicitacaoOuvidoria($solicitante->solicitante_email, $solicitacao_ouvidoria);

        $protocolo = $solicitacao_ouvidoria->solicitacao_ouvidoria_protocolo;

        return redirect('/fale-com-ouvidor')
            ->with('success', self::MESSAGE_ADD_SUCCESS . " " . str_pad($protocolo, 14, 0, STR_PAD_LEFT));
    }

    private function anexarArquivo($request)
    {
        $nameFile = null;
        if ($request->hasFile('solicitacao_ouvidoria_anexo') && $request->file('solicitacao_ouvidoria_anexo')->isValid()) {
            $nameFile = $request->solicitacao_ouvidoria_anexo->getClientOriginalName();
            $upload = $request->solicitacao_ouvidoria_anexo->storeAs('anexos', $nameFile);
            if (!$upload) {
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }
        }

        return $nameFile;
    }

    private function enviarEmailSolicitacaoOuvidoria($para, $solicitacao_ouvidoria)
    {
        Mail::to($para)->send(new SendMailOuvidoria($solicitacao_ouvidoria));
    }

    public function acompanharSolicitacao(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['solicitante_cpf_psq'])) {
            $data['solicitante_cpf_psq'] = "";
        }

        if (empty($data['solicitante_nome_psq'])) {
            $data['solicitante_nome_psq'] = "";
        }

        if (empty($data['tipo_solicitacao_cod_psq'])) {
            $data['tipo_solicitacao_cod_psq'] = "";
        }

        if (empty($data['tipo_solicitante_cod_psq'])) {
            $data['tipo_solicitante_cod_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = "";
        }

        if (empty($data['data_termino'])) {
            $data['data_termino'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $solicitacao_ouvidorias = $this->getSolicitacaoOuvidorias($data);

        if (count($solicitacao_ouvidorias) == 0) {
            return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
        }
        if (count($solicitacao_ouvidorias) == 1) {
            $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_ouvidorias[0]->solicitacao_ouvidoria_cod);
            $data['solicitacao_ouvidoria_protocolo_psq'] = "";
            $data['solicitante_cpf_psq'] = $solicitacao_ouvidoria->solicitante->solicitante_cpf;
        }
        if (count($solicitacao_ouvidorias) > 1) {
            $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_ouvidorias[0]->solicitacao_ouvidoria_cod);
            $data['solicitacao_ouvidoria_protocolo_psq'] = "";
            $data['solicitante_cpf_psq'] = $solicitacao_ouvidoria->solicitante->solicitante_cpf;
            $solicitacao_ouvidoria = null;
        }
        $solicitacao_ouvidorias = $this->getSolicitacaoOuvidorias($data);
        $tipo_solicitacaos = TipoSolicitacao::get();
        $tipo_solicitantes = TipoSolicitante::get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;

        return view('ouvidoria.solicitacao-ouvidoria.acompanhar', 
            compact('solicitacao_ouvidorias', 'tipo_solicitacaos', 'tipo_solicitantes', 'institutoras', 'solicitacao_ouvidoria', 'ufs'));

    }

    public function edit(int $solicitacao_cod)
    {
        $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_cod);
        $ufs = self::UFS;

        return view('ouvidoria.solicitacao-ouvidoria.edit', compact('solicitacao_ouvidoria', 'ufs'));
    }

    public function update(Request $request, int $solicitacao_cod)
    {
        $solicitacao_ouvidoria_edit = SolicitacaoOuvidoria::find($solicitacao_cod);

        $request->validate([
            'solicitante_cpf'=>'required|cpf|unique:solicitante,solicitante_cpf,' . $solicitacao_ouvidoria_edit->solicitante_cod,
            'solicitante_nome'=>'required|max:120',
            'institutora_cod'=>'required',
            'uf_sigla'=>'required',
            'solicitante_cidade'=>'required|max:120',
            'solicitante_email'=>'required|max:120',
            'solicitante_telefone'=>'required|max:15',
            'solicitante_celular'=>'required|max:15',
            'solicitacao_ouvidoria_mensagem'=>'required|max:255'
        ], self::MESSAGES_ERRORS);

        unset($solicitacao_ouvidoria_edit);
        
        $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_cod);
        $solicitacao_ouvidoria->solicitacao_ouvidoria_protocolo = $request->get('solicitacao_ouvidoria_protocolo');
        $solicitacao_ouvidoria->solicitacao_ouvidoria_mensagem = $request->get('solicitacao_ouvidoria_mensagem');
        $solicitacao_ouvidoria->solicitacao_ouvidoria_anexo = $request->get('solicitacao_ouvidoria_anexo');
        $solicitacao_ouvidoria->tipo_solicitacao_cod = $request->get('tipo_solicitacao_cod');
        $solicitacao_ouvidoria->solicitante_cod = $request->get('solicitante_cod');
        $solicitacao_ouvidoria->tipo_prestador_cod = $request->get('tipo_prestador_cod');
        $solicitacao_ouvidoria->sub_classificacao_cod = $request->get('sub_classificacao_cod');
        $solicitacao_ouvidoria->assunto_cod = $request->get('assunto_cod');
        $solicitacao_ouvidoria->canal_atendimento_cod = $request->get('canal_atendimento_cod');
        $solicitacao_ouvidoria->save();
        
        $solicitante = Solicitante::find($solicitacao_ouvidoria->solicitante_cod);
        $solicitante->solicitante_cpf = $request->get('solicitante_cpf');
        $solicitante->solicitante_nome = $request->get('solicitante_nome');
        $solicitante->solicitante_email = $request->get('solicitante_email');
        $solicitante->solicitante_telefone = $request->get('solicitante_telefone');
        $solicitante->solicitante_celular = $request->get('solicitante_celular');
        $solicitante->solicitante_uf = $request->get('solicitante_uf');
        $solicitante->solicitante_cidade = $request->get('solicitante_cidade');
        $solicitante->institutora_cod = $request->get('institutora_cod');
        $solicitante->tipo_solicitante_cod = $request->get('tipo_solicitante_cod');
        $solicitante->save();

        return redirect('/solicitacao-ouvidoria/create')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function destroy(int $id)
    {
        $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($id);
        $solicitacao_ouvidoria->delete();
   
        return redirect('/solicitacao-ouvidoria/create')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function carregarSolicitantePorCPF(Request $request)
    {
        $solicitante = null;
        $solicitante_request = Solicitante::where('solicitante_cpf', $request->solicitante_cpf)->get();
        if (count($solicitante_request) > 0) {
            $solicitante = $solicitante_request[0];
        }
        return response()->json($solicitante, 200);
    }
}
