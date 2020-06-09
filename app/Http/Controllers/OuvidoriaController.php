<?php

namespace App\Http\Controllers;

use App\Mail\SendMailOuvidoria;
use App\Mail\SendMailOuvidoriaConcluida;

use App\Models\Institutora;
use App\Models\Beneficiario;
use App\Models\PlanoBeneficiario;

use App\Models\Situacao;
use App\Models\Ouvidoria;
use App\Models\Solicitante;
use App\Models\TipoOuvidoria;
use App\Models\TipoSolicitante;
use App\Models\SituacaoOuvidoria;

use App\Models\CanalAtendimento;

use App\Models\Categoria;
use App\Models\Setor;
use App\Models\Assunto;
use App\Models\Classificacao;
use App\Models\SubClassificacao;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OuvidoriaController extends Controller
{
    const MESSAGES_ERRORS = [
        'tipo_ouvidoria_id.required' => 'O Tipo de Solicitação precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'tipo_solicitante_id.required' => 'O campo Você é precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'cpf.required' => 'O CPF precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'cpf.cpf' => 'O CPF precisa ser válido. Por favor, '
        . 'você pode verificar isso?',
        'cpf.unique' => 'Ops, CPF informado já está em uso. '
            . 'Por favor, você pode verificar isso?',

        'nome.required' => 'O Nome precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'uf.required' => 'O Estado precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'cidade.required' => 'A Cidade precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'email.required' => 'O E-mail precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'email.email' => 'Ops, E-mail precisa ser um endereço de e-mail válido. Por favor, '
        . 'você pode verificar isso?',

        'celular.required' => 'O Celular precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'mensagem.required' => 'A Mensagem precisa ser informada. Por favor, '
        . 'você pode verificar isso?',
        'mensagem.max' => 'Ops, a Mensagem não precisa ter mais que 1200 caracteres. '
        . 'Por favor, você pode verificar isso?',

        'situacao_id.required' => 'A Situação precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'comentario.required' => 'O Comentário precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'comentario.max' => 'Ops, o Comentário não precisa ter mais que 1200 caracteres. '
        . 'Por favor, você pode verificar isso?',
    ];

    const MESSAGE_ADD_SUCCESS_EMAIL = "A sua demanda foi recebida com sucesso. Em breve você será contatado.
    <br />O número do protocolo da sua demanda é: ";

    const MESSAGE_ADD_SUCCESS = "A sua demanda foi recebida com sucesso.
    <br />O número do protocolo da sua demanda é: ";

    const MESSAGE_ADD_SUCCESS_CONCLUIDA = "Demanda concluída com sucesso.
    <br />O número do protocolo da demanda é: ";

    const MESSAGE_UPDATE_SUCCESS = "A demanda foi alterada com sucesso!";

    const MESSAGE_DESTROY_SUCCESS = "A demanda foi removida com sucesso!";

    const UFS = [
        ["sigla" => "AC", "descricao" => "ACRE"],
        ["sigla" => "AL", "descricao" => "ALAGOAS"],
        ["sigla" => "AP", "descricao" => "AMAPÁ"],
        ["sigla" => "AM", "descricao" => "AMAZONAS"],
        ["sigla" => "BA", "descricao" => "BAHIA"],
        ["sigla" => "CE", "descricao" => "CEARÁ"],
        ["sigla" => "DF", "descricao" => "DISTRITO FEDERAL"],
        ["sigla" => "ES", "descricao" => "ESPÍRITO SANTO"],
        ["sigla" => "GO", "descricao" => "GOIÁS"],
        ["sigla" => "MA", "descricao" => "MARANHÃO"],
        ["sigla" => "MG", "descricao" => "MINAS GERAIS"],
        ["sigla" => "MT", "descricao" => "MATO GROSSO"],
        ["sigla" => "MS", "descricao" => "MATO GROSSO DO SUL"],
        ["sigla" => "PA", "descricao" => "PARÁ"],
        ["sigla" => "PB", "descricao" => "PARAÍBA"],
        ["sigla" => "PR", "descricao" => "PARANÁ"],
        ["sigla" => "PE", "descricao" => "PERNAMBUCO"],
        ["sigla" => "PI", "descricao" => "PIAUÍ"],
        ["sigla" => "RJ", "descricao" => "RIO DE JANEIRO"],
        ["sigla" => "RN", "descricao" => "RIO GRANDE DO NORTE"],
        ["sigla" => "RS", "descricao" => "RIO GRANDE DO SUL"],
        ["sigla" => "RO", "descricao" => "RONDÔNIA"],
        ["sigla" => "RR", "descricao" => "RORAIMA"],
        ["sigla" => "SC", "descricao" => "SANTA CATARINA"],
        ["sigla" => "SP", "descricao" => "SÃO PAULO"],
        ["sigla" => "SE", "descricao" => "SERGIPE"],
        ["sigla" => "TO", "descricao" => "TOCANTINS"]
    ];

    public function index()
    {
        $data = array();
        if (empty($data['protocolo_psq'])) {
            $data['protocolo_psq'] = "";
        }

        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['tipo_ouvidoria_id_psq'])) {
            $data['tipo_ouvidoria_id_psq'] = "";
        }

        if (empty($data['tipo_solicitante_id_psq'])) {
            $data['tipo_solicitante_id_psq'] = "";
        }

        if (empty($data['categoria_id_psq'])) {
            $data['categoria_id_psq'] = "";
        }

        if (empty($data['setor_id_psq'])) {
            $data['setor_id_psq'] = "";
        }

        if (empty($data['assunto_id_psq'])) {
            $data['assunto_id_psq'] = "";
        }

        if (empty($data['classificacao_id_psq'])) {
            $data['classificacao_id_psq'] = "";
        }

        if (empty($data['sub_classificacao_id_psq'])) {
            $data['sub_classificacao_id_psq'] = "";
        }

        if (empty($data['situacao_id_psq'])) {
            $data['situacao_id_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $timestamp = strtotime("-15 days");
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y', $timestamp))->format('d/m/Y');
        }

        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $ouvidorias = $this->getOuvidorias($data);

        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
        $situacoes = Situacao::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();
        $setores = array();
        $assuntos = array();
        $classificacoes = array();
        $subClassificacoes = array();

        return view('ouvidoria.ouvidoria.index', compact('tiposOuvidorias', 'tiposSolicitantes', 'situacoes', 
            'categorias', 'setores', 'assuntos', 'classificacoes', 'subClassificacoes', 'ouvidorias', 'data'));
    }

    public function search(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['protocolo_psq'])) {
            $data['protocolo_psq'] = "";
        }

        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['tipo_ouvidoria_id_psq'])) {
            $data['tipo_ouvidoria_id_psq'] = "";
        }

        if (empty($data['tipo_solicitante_id_psq'])) {
            $data['tipo_solicitante_id_psq'] = "";
        }

        if (empty($data['categoria_id_psq'])) {
            $data['categoria_id_psq'] = "";
        }

        if (empty($data['setor_id_psq'])) {
            $data['setor_id_psq'] = "";
        }

        if (empty($data['assunto_id_psq'])) {
            $data['assunto_id_psq'] = "";
        }

        if (empty($data['classificacao_id_psq'])) {
            $data['classificacao_id_psq'] = "";
        }

        if (empty($data['sub_classificacao_id_psq'])) {
            $data['sub_classificacao_id_psq'] = "";
        }

        if (empty($data['situacao_id_psq'])) {
            $data['situacao_id_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $timestamp = strtotime("-15 days");
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y', $timestamp))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $ouvidorias = $this->getOuvidorias($data);

        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
        $situacoes = Situacao::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();

        $setores = array();
        if ($data['categoria_id_psq'] != "") {
            $setores = Setor::where('categoria_id', $data['categoria_id_psq'])
                ->where('status', 1)->get();
        }

        $assuntos = array();
        if ($data['setor_id_psq'] != "") {
            $assuntos = Assunto::where('setor_id', $data['setor_id_psq'])
                ->where('status', 1)->get();
        }

        $classificacoes = array();
        if ($data['assunto_id_psq'] != "") {
            $classificacoes = Classificacao::where('assunto_id', $data['assunto_id_psq'])
                ->where('status', 1)->get();
        }

        $subClassificacoes = array();
        if ($data['classificacao_id_psq'] != "") {
            $subClassificacoes = SubClassificacao::where('classificacao_id', $data['classificacao_id_psq'])
                ->where('status', 1)->get();
        }

        return view('ouvidoria.ouvidoria.index', compact('tiposOuvidorias', 'tiposSolicitantes', 'situacoes', 
            'categorias', 'setores', 'assuntos', 'classificacoes', 'subClassificacoes', 'ouvidorias', 'data'));
    }

    private function getOuvidorias(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }
        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::select('fv_ouv_ouvidoria.id',
                'fv_ouv_ouvidoria.protocolo as protocolo',
                'fv_ouv_tp_ouvidoria.nome as noTipoOuvidoria',
                'fv_ouv_tipo_solicitante.descricao as dsTipoSolicitante',
                'fv_ouv_solicitante.nome as noSolicitante',
                'fv_ouv_situacao.nome as noSituacao',
                'fv_ouv_situacao.cor as noSituacaoCor',
                'fv_ouv_ouvidoria.created_at as dtCriacao')
            ->join('fv_ouv_tp_ouvidoria', 'fv_ouv_ouvidoria.tp_ouvidoria_id', '=', 'fv_ouv_tp_ouvidoria.id')
            ->join('fv_ouv_tipo_solicitante', 'fv_ouv_ouvidoria.tipo_solicitante_id', '=', 'fv_ouv_tipo_solicitante.id')
            ->join('fv_ouv_situacao', 'fv_ouv_ouvidoria.situacao_id', '=', 'fv_ouv_situacao.id')
            ->leftJoin('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', '=', 'fv_ouv_solicitante.id')
            ->where(function ($query) use ($data) {
                if ($data['protocolo_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.protocolo', '=', $data['protocolo_psq']);
                }
                if ($data['cpf_psq'] != "") {
                    $query->where('fv_ouv_solicitante.cpf', '=', $data['cpf_psq']);
                }
                if ($data['nome_psq'] != "") {
                    $query->where('fv_ouv_solicitante.nome', 'LIKE', "%" . $data['nome_psq'] . "%");
                }
                if ($data['tipo_ouvidoria_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.tp_ouvidoria_id', $data['tipo_ouvidoria_id_psq']);
                }
                if ($data['tipo_solicitante_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.tipo_solicitante_id', $data['tipo_solicitante_id_psq']);
                }
                if ($data['data_inicio'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if ($data['data_termino'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
                if ($data['situacao_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.situacao_id', $data['situacao_id_psq']);
                }
                if ($data['categoria_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.categoria_id', $data['categoria_id_psq']);
                }
                if ($data['setor_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.setor_id', $data['setor_id_psq']);
                }
                if ($data['assunto_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.assunto_id', $data['assunto_id_psq']);
                }
                if ($data['classificacao_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.classificacao_id', $data['classificacao_id_psq']);
                }
                if ($data['sub_classificacao_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.sub_classificacao_id', $data['sub_classificacao_id_psq']);
                }
            })->orderBy('fv_ouv_ouvidoria.created_at', 'DESC')->paginate($data['totalPage']);
            // })->toSql();
    }

    public function create(Request $request)
    {   
        $tipo_ouvidoria_id = $request->tipo_ouvidoria_id;
        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;

        return view('ouvidoria.ouvidoria.create', compact(
            'tipo_ouvidoria_id', 'tiposOuvidorias', 'tiposSolicitantes', 'institutoras', 'ufs'));
    }

    public function store(Request $request)
    {
        if ($request->anonima != "A") {
            $request->validate([
                'tipo_ouvidoria_id'=>'required',
                'tipo_solicitante_id' => 'required',
                'cpf' => 'required|cpf|unique:fv_ouv_solicitante,cpf,' . $request->solicitante_id,
                'nome' => 'required|max:120',
                'uf' => 'required',
                'cidade' => 'required|max:120',
                'email' => 'required|max:120',
                'celular' => 'required|max:15',
                'mensagem'=>'required|max:1200',
            ], self::MESSAGES_ERRORS);

            if ($request->solicitante_id == "") {
                $solicitante = new Solicitante([
                    'cpf' => $request->cpf,
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'telefone' => $request->telefone,
                    'celular' => $request->celular,
                    'uf' => $request->uf,
                    'cidade' => $request->cidade,
                    'institutora_id' => $request->institutora_id,
                    'tipo_solicitante_id' => $request->tipo_solicitante_id,
                ]);
                $solicitante->save();
                $request->solicitante_id = $solicitante->id;
            } else {
                $solicitante = Solicitante::find($request->solicitante_id);
                $solicitante->cpf = $request->cpf;
                $solicitante->nome = $request->nome;
                $solicitante->email = $request->email;
                $solicitante->telefone = $request->telefone;
                $solicitante->celular = $request->celular;
                $solicitante->uf = $request->uf;
                $solicitante->cidade = $request->cidade;
                $solicitante->institutora_id = $request->institutora_id;
                $solicitante->tipo_solicitante_id = $request->tipo_solicitante_id;
                $solicitante->save();
            }
        }

        $request->validate([
            'tipo_ouvidoria_id'=>'required',
            'tipo_solicitante_id'=>'required',
            'mensagem'=>'required|max:1200',
        ], self::MESSAGES_ERRORS);

        $protocolo = Ouvidoria::get();
        $numero = count($protocolo)+1;
        $protocolo = $numero . date('dmY');

        $ouvidoria = new Ouvidoria([
            'protocolo' => $protocolo,
            'mensagem' => $request->mensagem,
            'tp_ouvidoria_id' => $request->tipo_ouvidoria_id,
            'tipo_solicitante_id' => $request->tipo_solicitante_id,
            'solicitante_id' => $request->solicitante_id,
            'situacao_id' => 1,
        ]);
        $ouvidoria->save();

        $situacaoOuvidoria = new SituacaoOuvidoria([
            'comentario' => 'Solicitação de ouvidoria registrada em ' . date('d/m/Y H:i'),
            'ouvidoria_id' => $ouvidoria->id,
            'situacao_id' => 1
        ]);
        $situacaoOuvidoria->save();

        $this->anexarArquivo($ouvidoria, $request);

        $msg = self::MESSAGE_ADD_SUCCESS;
        if ($request->email != "") {
            $this->enviarEmailOuvidoria($request->email, $ouvidoria);
            $msg = self::MESSAGE_ADD_SUCCESS_EMAIL;
        }
        
        return redirect('/fale-com-ouvidor')
            ->with('success', $msg . " " . str_pad($protocolo, 14, 0, STR_PAD_LEFT));
    }

    private function anexarArquivo($ouvidoria, $request)
    {
        $nameFile = null;
        if ($request->hasFile('anexo') && $request->file('anexo')->isValid()) {
            $nameFile = date('YmdHis') . $request->anexo->getClientOriginalName();
            $upload = $request->anexo->storeAs('anexos', $nameFile);
            if (!$upload) {
                return redirect()->back()->with('error', 'Falha ao fazer upload')->withInput();
            }
            $ouvidoria->anexo = $nameFile;
            $ouvidoria->save();
        }
    }

    private function enviarEmailOuvidoria($para, $ouvidoria)
    {
        Mail::to($para)->send(new SendMailOuvidoria($ouvidoria));
    }

    public function acompanhar(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['tipo_ouvidoria_id_psq'])) {
            $data['tipo_ouvidoria_id_psq'] = "";
        }

        if (empty($data['tipo_solicitante_id_psq'])) {
            $data['tipo_solicitante_id_psq'] = "";
        }

        if (empty($data['categoria_id_psq'])) {
            $data['categoria_id_psq'] = "";
        }

        if (empty($data['setor_id_psq'])) {
            $data['setor_id_psq'] = "";
        }

        if (empty($data['assunto_id_psq'])) {
            $data['assunto_id_psq'] = "";
        }

        if (empty($data['classificacao_id_psq'])) {
            $data['classificacao_id_psq'] = "";
        }

        if (empty($data['sub_classificacao_id_psq'])) {
            $data['sub_classificacao_id_psq'] = "";
        }

        if (empty($data['situacao_id_psq'])) {
            $data['situacao_id_psq'] = "";
        }

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = "";
        }

        if (empty($data['data_termino'])) {
            $data['data_termino'] = "";
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $ouvidorias = $this->getOuvidorias($data);

        if (count($ouvidorias) == 0) {
            return redirect('/home')
                ->with('message', 'Nenhum registro encontrado!');
        }
        if (count($ouvidorias) == 1) {
            $ouvidoria = Ouvidoria::find($ouvidorias[0]->id);
            if ($ouvidoria->solicitante_id != "") {
                $data['protocolo_psq'] = "";
                $data['cpf_psq'] = $ouvidoria->solicitante->cpf;
            }
        }
        if (count($ouvidorias) > 1) {
            $ouvidoria = Ouvidoria::find($ouvidorias[0]->id);
            if ($ouvidoria->solicitante_id != "") {
                $data['protocolo_psq'] = "";
                $data['cpf_psq'] = $ouvidoria->solicitante->cpf;
            }
            $ouvidoria = null;
        }
        $ouvidorias = $this->getOuvidorias($data);
        $tiposOuvidorias = TipoOuvidoria::get();
        $situacoes = Situacao::get();

        return view('ouvidoria.ouvidoria.acompanhar', 
            compact('ouvidorias', 'tiposOuvidorias', 'ouvidoria', 'situacoes'));
    }

    public function edit(int $ouvidoria_id)
    {
        $ouvidoria = Ouvidoria::find($ouvidoria_id);
        $tiposOuvidorias = TipoOuvidoria::get();
        $canaisAtendimentos = CanalAtendimento::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();
        $setores = array();
        if ($ouvidoria->categoria_id != "") {
            $setores = Setor::where('categoria_id', $ouvidoria->categoria_id)
                ->where('status', 1)->get();
        }

        $assuntos = array();
        if ($ouvidoria->setor_id != "") {
            $assuntos = Assunto::where('setor_id', $ouvidoria->setor_id)
                ->where('status', 1)->get();
        }

        $classificacoes = array();
        if ($ouvidoria->assunto_id != "") {
            $classificacoes = Classificacao::where('assunto_id', $ouvidoria->assunto_id)
                ->where('status', 1)->get();
        }

        $subClassificacoes = array();
        if ($ouvidoria->classificacao_id != "") {
            $subClassificacoes = SubClassificacao::where('classificacao_id', $ouvidoria->classificacao_id)
                ->where('status', 1)->get();
        }

        $situacoes = Situacao::where('status', 1)->get();
        $situacoesOuvidoria = SituacaoOuvidoria::where('ouvidoria_id', $ouvidoria->id)->orderBy('id', 'DESC')->get();
        $situacaoOuvidoria = $situacoesOuvidoria[0];

        return view('ouvidoria.ouvidoria.edit', compact('tiposOuvidorias', 'ouvidoria', 'canaisAtendimentos', 
            'categorias', 'setores', 'assuntos', 'classificacoes', 'subClassificacoes', 'situacaoOuvidoria', 'situacoes'));
    }

    public function editCombo(Request $request)
    {
        $ouvidoria = Ouvidoria::find($request->ouvidoria_id);
        $ouvidoria->canal_atendimento_id = $request->canal_atendimento_id;
        $ouvidoria->observacao = $request->observacao;
        $ouvidoria->categoria_id = $request->categoria_id;
        $ouvidoria->setor_id = $request->setor_id;
        $ouvidoria->assunto_id = $request->assunto_id;
        $ouvidoria->classificacao_id = $request->classificacao_id;
        $ouvidoria->sub_classificacao_id = $request->sub_classificacao_id;

        $tiposOuvidorias = TipoOuvidoria::get();
        $canaisAtendimentos = CanalAtendimento::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();

        $data = $request->except('_token');
        $setores = array();
        if ($data['categoria_id'] != "") {
            $setores = Setor::where('categoria_id', $data['categoria_id'])
                ->where('status', 1)->get();
        }

        $assuntos = array();
        if ($data['setor_id'] != "") {
            $assuntos = Assunto::where('setor_id', $data['setor_id'])
                ->where('status', 1)->get();
        }

        $classificacoes = array();
        if ($data['assunto_id'] != "") {
            $classificacoes = Classificacao::where('assunto_id', $data['assunto_id'])
                ->where('status', 1)->get();
        }

        $subClassificacoes = array();
        if ($data['classificacao_id'] != "") {
            $subClassificacoes = SubClassificacao::where('classificacao_id', $data['classificacao_id'])
                ->where('status', 1)->get();
        }

        $situacoes = Situacao::where('status', 1)->get();
        $situacoesOuvidoria = SituacaoOuvidoria::where('ouvidoria_id', $ouvidoria->id)->orderBy('id', 'DESC')->get();
        $situacaoOuvidoria = $situacoesOuvidoria[0];

        return view('ouvidoria.ouvidoria.edit', compact('tiposOuvidorias', 'ouvidoria', 'canaisAtendimentos', 
            'categorias', 'setores', 'assuntos', 'classificacoes', 'subClassificacoes', 'situacaoOuvidoria', 'situacoes'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'observacao' => 'nullable|max:600',
        ], self::MESSAGES_ERRORS);

        if ($request->situacao_id != "") {
            $request->validate([
                'comentario' => 'required|max:600',
            ], self::MESSAGES_ERRORS);
        }
        
        $ouvidoria = Ouvidoria::find($request->ouvidoria_id);
        $ouvidoria->canal_atendimento_id = $request->canal_atendimento_id;
        $ouvidoria->tp_ouvidoria_id = $request->tipo_ouvidoria_id;
        $ouvidoria->observacao = $request->observacao;
        $ouvidoria->categoria_id = $request->categoria_id;
        $ouvidoria->setor_id = $request->setor_id;
        $ouvidoria->assunto_id = $request->assunto_id;
        $ouvidoria->classificacao_id = $request->classificacao_id;
        $ouvidoria->sub_classificacao_id = $request->sub_classificacao_id;
        if ($request->situacao_id != "") {
            $ouvidoria->situacao_id = $request->situacao_id;
        }
        $ouvidoria->save();
        
        $msg = self::MESSAGE_UPDATE_SUCCESS;
        if ($request->situacao_id != "") {
            $situacaoOuvidoria = new SituacaoOuvidoria([
                'ouvidoria_id' => $request->ouvidoria_id,
                'situacao_id' => $request->situacao_id,
                'comentario' => $request->comentario,
            ]);
            $situacaoOuvidoria->save();

            if ($request->situacao_id == 3) {
                $msg = self::MESSAGE_ADD_SUCCESS_CONCLUIDA;
                if ($ouvidoria->solicitante->email != "") {
                    $para = $ouvidoria->solicitante->email;
                    $this->enviarEmailOuvidoriaConcluida($para);
                }
            }
        }

        return redirect('/ouvidoria')->with('success', $msg);
    }

    private function enviarEmailOuvidoriaConcluida($para)
    {
        Mail::to($para)->send(new SendMailOuvidoriaConcluida());
    }

    public function createAdmin(Request $request)
    {   
        $tipo_ouvidoria_id = $request->tipo_ouvidoria_id;
        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;
        $canaisAtendimentos = CanalAtendimento::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();
        $setores = array();
        $assuntos = array();
        $classificacoes = array();
        $subClassificacoes = array();

        $situacoes = Situacao::where('status', 1)->get();

        return view('ouvidoria.ouvidoria.create-admin', compact( 'tipo_ouvidoria_id', 'tiposOuvidorias', 
            'tiposSolicitantes', 'institutoras', 'ufs', 'canaisAtendimentos', 'categorias', 'setores', 'assuntos', 
            'classificacoes', 'subClassificacoes', 'situacoes', 'request'));
    }

    public function createCombo(Request $request)
    {   
        $tipo_ouvidoria_id = $request->tipo_ouvidoria_id;
        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;
        $canaisAtendimentos = CanalAtendimento::where('status', 1)->get();

        $categorias = Categoria::where('status', 1)->get();

        $data = $request->except('_token');
        $setores = array();
        if ($data['categoria_id'] != "") {
            $setores = Setor::where('categoria_id', $data['categoria_id'])
                ->where('status', 1)->get();
        }

        $assuntos = array();
        if ($data['setor_id'] != "") {
            $assuntos = Assunto::where('setor_id', $data['setor_id'])
                ->where('status', 1)->get();
        }

        $classificacoes = array();
        if ($data['assunto_id'] != "") {
            $classificacoes = Classificacao::where('assunto_id', $data['assunto_id'])
                ->where('status', 1)->get();
        }

        $subClassificacoes = array();
        if ($data['classificacao_id'] != "") {
            $subClassificacoes = SubClassificacao::where('classificacao_id', $data['classificacao_id'])
                ->where('status', 1)->get();
        }

        $situacoes = Situacao::where('status', 1)->get();

        return view('ouvidoria.ouvidoria.create-admin', compact( 'tipo_ouvidoria_id', 'tiposOuvidorias', 
            'tiposSolicitantes', 'institutoras', 'ufs', 'canaisAtendimentos', 'categorias', 'setores', 'assuntos', 
            'classificacoes', 'subClassificacoes', 'situacoes', 'request'));
    }

    public function storeAdmin(Request $request)
    {
        if ($request->anonima != "A") {
            $request->validate([
                'tipo_solicitante_id' => 'required',
                'cpf' => 'required|cpf|unique:fv_ouv_solicitante,cpf,' . $request->solicitante_id,
                'nome' => 'required|max:120',
                'uf' => 'required',
                'cidade' => 'required|max:120',
                'email' => 'required|max:120',
                'celular' => 'required|max:15',
                'mensagem' => 'required|max:1200',
                'situacao_id' => 'required',
                'comentario' => 'required|max:1200',
            ], self::MESSAGES_ERRORS);

            if ($request->solicitante_id == "") {
                $solicitante = new Solicitante([
                    'cpf' => $request->cpf,
                    'nome' => $request->nome,
                    'email' => $request->email,
                    'telefone' => $request->telefone,
                    'celular' => $request->celular,
                    'uf' => $request->uf,
                    'cidade' => $request->cidade,
                    'institutora_id' => $request->institutora_id,
                    'tipo_solicitante_id' => $request->tipo_solicitante_id,
                ]);
                $solicitante->save();
                $request->solicitante_id = $solicitante->id;
            } else {
                $solicitante = Solicitante::find($request->solicitante_id);
                $solicitante->cpf = $request->cpf;
                $solicitante->nome = $request->nome;
                $solicitante->email = $request->email;
                $solicitante->telefone = $request->telefone;
                $solicitante->celular = $request->celular;
                $solicitante->uf = $request->uf;
                $solicitante->cidade = $request->cidade;
                $solicitante->institutora_id = $request->institutora_id;
                $solicitante->tipo_solicitante_id = $request->tipo_solicitante_id;
                $solicitante->save();
            }
        }

        $request->validate([
            'tipo_solicitante_id' => 'required',
            'observacao' => 'nullable|max:600',
            'mensagem' => 'required|max:1200',
            'situacao_id' => 'required',
            'comentario' => 'required|max:1200',
        ], self::MESSAGES_ERRORS);

        $protocolo = Ouvidoria::get();
        $numero = count($protocolo)+1;
        $protocolo = $numero . date('dmY');

        $ouvidoria = new Ouvidoria([
            'protocolo' => $protocolo,
            'tp_ouvidoria_id' => $request->tipo_ouvidoria_id,
            'canal_atendimento_id' => $request->canal_atendimento_id,
            'observacao' => $request->observacao,
            'mensagem' => $request->mensagem,
            'categoria_id' => $request->categoria_id,
            'setor_id' => $request->setor_id,
            'assunto_id' => $request->assunto_id,
            'classificacao_id' => $request->classificacao_id,
            'sub_classificacao_id' => $request->sub_classificacao_id,
            'situacao_id' => $request->situacao_id,
            'tipo_solicitante_id' => $request->tipo_solicitante_id,
            'solicitante_id' => $request->solicitante_id
        ]);
        $ouvidoria->save();

        $this->anexarArquivo($ouvidoria, $request);

        $protocolo = $ouvidoria->protocolo;

        if ($request->situacao_id != "") {
            $situacaoOuvidoria = new SituacaoOuvidoria([
                'ouvidoria_id' => $ouvidoria->id,
                'situacao_id' => $request->situacao_id,
                'comentario' => $request->comentario,
            ]);
            $situacaoOuvidoria->save();

            $msg = self::MESSAGE_ADD_SUCCESS;
            if ($request->situacao_id == 1) {
                if ($request->email != "") {
                    $msg = self::MESSAGE_ADD_SUCCESS_EMAIL;
                    $this->enviarEmailOuvidoria($request->email, $ouvidoria);
                }
            }
            if ($request->situacao_id == 3) {
                $msg = self::MESSAGE_ADD_SUCCESS_CONCLUIDA;
                if ($request->email != "") {
                    $this->enviarEmailOuvidoriaConcluida($request->email);
                }
            }
        }

        return redirect('/ouvidoria')
            ->with('success', $msg . " " . str_pad($protocolo, 14, 0, STR_PAD_LEFT));
    }

    public function carregarSolicitantePorCPF(Request $request)
    {
        $solicitante = null;
        $solicitante_request = Solicitante::where('cpf', $request->cpf)->get();
        //Localizar na Tabela de Beneficiarios
        if (count($solicitante_request) == 0) {
            $cpf = $this->limpaCPF_CNPJ($request->cpf);
            $benef = Beneficiario::select(
                    'cad_benef.matricula', 
                    'cad_benef.nome', 
                    'cad_benef.cic',
                    'cad_benef.email',
                    'cad_benef.fone_res',
                    'cad_benef.fone_cel',
                    'cad_cidade.nome as nocidade',
                    'cad_cidade.estado'
                )
                ->join('plano.cad_cidade', 'cad_benef.cidade', '=', 'plano.cad_cidade.cidade')
                ->where('cad_benef.cic', $cpf)->get();

            if (count($benef) > 0) {
                $planoBenef = PlanoBeneficiario::where('matricula', $benef[0]->matricula)
                    ->orderBy('data_contrato', 'DESC')->get();

                $solicitante = new Solicitante();
                $solicitante->nome = $benef[0]->nome;
                $solicitante->cpf = $this->formatCnpjCpf($benef[0]->cic);
                $solicitante->email = $benef[0]->email;
                $solicitante->telefone = $benef[0]->fone_res;
                $solicitante->celular = $benef[0]->fone_cel;
                $solicitante->uf = $benef[0]->estado;
                $solicitante->cidade = $benef[0]->nocidade;
                $solicitante->institutora_id = $planoBenef[0]->empresa;
            }
        }
        if (count($solicitante_request) > 0) {
            $solicitante = $solicitante_request[0];
        }
        return response()->json($solicitante, 200);
    }

    private function limpaCPF_CNPJ($valor)
    {
        $valor = trim($valor);
        $valor = str_replace(".", "", $valor);
        $valor = str_replace(",", "", $valor);
        $valor = str_replace("-", "", $valor);
        $valor = str_replace("/", "", $valor);
        return $valor;
    }

    private function formatCnpjCpf($value)
    {
        $cnpj_cpf = preg_replace("/\D/", '', $value);
        if (strlen($cnpj_cpf) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } 

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    public function feriados($ano = null)
    {
        if ($ano === null) {
            $ano = intval(date('Y'));
        }
        //Atravéz de uma função do PHP verifica a data da páscoa 
        // (Para saber mais pesquise sobre como é calculado o dia da pascoa)
        $pascoa = easter_date($ano);
        //PEGA O dia da pascoa do mes sem zero a esquerda
        $dia_pascoa = date('j', $pascoa);
        //PEGA o mes da pascoa sem zero a esquerda
        $mes_pascoa = date('n', $pascoa);
        //PEGA o ano da pascoa com quatro digitos
        $ano_pascoa = date('Y', $pascoa);
        //ARRAY com os FERIADOS SETADOS
        $feriados = array(
            //INICIO FERIADOS FIXOS NO CALENDÁRIO
            mktime(0, 0, 0, 1,  1,   $ano), // Confraternização Universal - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 4,  21,  $ano), // Tiradentes - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 5,  1,   $ano), // Dia do Trabalhador - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 9,  7,   $ano), // Dia da Independência - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 10,  12, $ano), // N. S. Aparecida - Lei nº 6802, de 30/06/80
            mktime(0, 0, 0, 11,  2,  $ano), // Todos os santos - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 11, 15,  $ano), // Proclamação da republica - Lei nº 662, de 06/04/49
            mktime(0, 0, 0, 12, 25,  $ano), // Natal - Lei nº 662, de 06/04/49
            // INICIO FERIADOS BASEADOS NA PÁSCOA
            // Para considerar 2 dias de carnaval descomente a linha abaixo
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 48,  $ano_pascoa),//2ºferia Carnaval
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 47,  $ano_pascoa),//3ºferia Carnaval	
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa - 2 ,  $ano_pascoa),//6ºfeira Santa  
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa     ,  $ano_pascoa),//Pascoa
            mktime(0, 0, 0, $mes_pascoa, $dia_pascoa + 60,  $ano_pascoa),//Corpus Cirist
        );
        sort($feriados);
        
        return $feriados;
    }

    public function dias_uteis($mes,$ano,$datafinal,$datainicial)
    {
        $uteis = 0;
        // Obtém o número de dias no mês através de uma função nativa do php e atribui a variavel dias_no_mes
        $dias_no_mes = $num = cal_days_in_month(CAL_GREGORIAN, $mes, $ano);

        // FAZ um for que passa dia a dia ate acabar o mes recebendo a variavel dias_no_mes como limite do FOR
        for ($dia = 1; $dia <= $dias_no_mes; $dia++) {

            // TRANSFORMA em TIMESTAMP a data dada pelo FOR
            $timestamp = mktime(0, 0, 0, $mes, $dia, $ano);

            // RETORNA numero de acordo com o dia da semana sendo
            // 1-segunda, 2-terça, 3-quarta, 4-quinta, 5-sexta, 6-sabado, 0-domingo
            $semana = date("w", $timestamp);

            // VERIFICA se a DATA em questão é >= a data inicial e <= a data  final
            if (strtotime($ano."-".$mes."-".$dia) <= strtotime($datafinal) && strtotime($ano."-".$mes."-".$dia) >= strtotime($datainicial)) {
                // VERIFICA se não é umsabado ou domingo para adicionar 1 ao contador de dias uteis
                if ($semana < 6 && $semana > 0 ) $uteis++;
            }

        }
        // RETORNA os dias da semana (daias uteis sem considerar feriados)
        return $uteis;
    }

    public function corre_anos($anoinicial, $anofinal, $mesinicial, $mesfinal, $datainicial, $datafinal)
    {
        // CONTADOR DE FERIADOS QUE CAEM EM DIAS UTEIS
        $feriados_em_dias_uteis = 0;
        //PARA CADA ANO do ano inicial ao ano final chama a função calcula feriados
        for ($ano = $anoinicial; $ano <= $anofinal ; $ano++) {
            $i = 0;
            foreach($this->feriados($ano) as $a) {
                $util['$i'] = date("Y-m-d",$a);
                date("w", strtotime($util['$i']));
                // VERIFICA se o FERIADO CAI EM DIA DE SEMANA atarves da função nativa do php que
                // RETORNA numero de acordo com o dia da semana sendo
                // 1-segunda, 2-terça, 3-quarta, 4-quinta, 5-sexta, 6-sabado, 0-domingo
                if(date("w", strtotime($util['$i'])) != 0 && date("w", strtotime($util['$i'])) != 6 && strtotime($util['$i']) <= strtotime($datafinal) && strtotime($util['$i']) >= strtotime($datainicial) ) {
                    //CASO seja dia de semana soma mais um ao contador
                    $feriados_em_dias_uteis++;
                }
                $i++;
            }
        }
      
        // Invocando a função Dias Uteis
        $total_dias_uteis = 0;
      
        //Anda de anao em ano Do ano Inicial ao Final
        for ($ano = $anoinicial; $ano <= $anofinal  ; $ano ++) {
            /*Chama a Função dias uteis para cada mes começando do MES INICIAL DADO PELO USUARIO VOLTANDO AO MES 1
            ao FIMDE CADA ANO*/
            for ($mesinicial ; $mesinicial < 13 ; $mesinicial++) {
                $total_dias_uteis = $total_dias_uteis + $this->dias_uteis($mesinicial, $ano, $datafinal, $datainicial);
            }
            //RETORNA CONTADOR DE MES AO MES 1 quando este chega ao "13"
            if ($mesinicial == 13) {
                $mesinicial = 1;
            }
        }
      
        //EXIBE OS DIAS UTEIS subitraidos dos OS FERIADOS	QUE CAEM EM DIAS DE SEMANA
        return $total_dias_uteis-$feriados_em_dias_uteis; //O AJAX PEGA COMO PADRÃO ESTE ECO
    }

    
}

