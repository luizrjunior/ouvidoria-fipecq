<?php

namespace App\Http\Controllers;

use App\Mail\SendMailOuvidoria;
use App\Models\Beneficiario;
use App\Models\Institutora;
use App\Models\TipoSolicitacao;
use App\Models\SolicitacaoOuvidoria;
use App\Models\TipoSolicitante;
use App\Models\Solicitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use stdClass;

class SolicitacaoOuvidoriaController extends Controller
{
    const MESSAGES_ERRORS = [
        'tipo_solicitacao_id.required' => 'O Tipo de Solicitação precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'tipo_solicitante_id.required' => 'O Tipo de Solicitante - Você é precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'cpf.required' => 'O CPF precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'cpf.cpf' => 'O CPF precisa ser válido. Por favor, '
        . 'você pode verificar isso?',

        'nome.required' => 'O Nome precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'institutora_id.required' => 'A Institutora/Empresa precisa ser informado. Por favor, '
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

        'mensagem.required' => 'A Mensagem precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
    ];

    const MESSAGE_ADD_SUCCESS = "A sua demanda foi recebida com sucesso. Em breve você será contatado.
    <br />O número do protocolo da sua demanda é: ";

    const MESSAGE_UPDATE_SUCCESS = "Solicitação de Ouvidoria alterado com sucesso!";

    const MESSAGE_DESTROY_SUCCESS = "Solicitação de Ouvidoria removido com sucesso!";

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

    public function index(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['tipo_solicitacao_id_psq'])) {
            $data['tipo_solicitacao_id_psq'] = "";
        }

        if (empty($data['tipo_solicitante_id_psq'])) {
            $data['tipo_solicitante_id_psq'] = "";
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

        return SolicitacaoOuvidoria::select('fv_ouv_solicitacao_ouvidoria.id',
                'fv_ouv_solicitacao_ouvidoria.protocolo as protocolo',
                'fv_ouv_tipo_solicitacao.nome as noTipoSolicitacao',
                'fv_ouv_tipo_solicitante.descricao as dsTipoSolicitante',
                'fv_ouv_solicitante.nome as noSolicitante',
                'fv_ouv_solicitacao_ouvidoria.created_at as dtCriacao')
            ->join('fv_ouv_tipo_solicitacao', 'fv_ouv_solicitacao_ouvidoria.tipo_solicitacao_id', '=', 'fv_ouv_tipo_solicitacao.id')
            ->join('fv_ouv_solicitante', 'fv_ouv_solicitacao_ouvidoria.solicitante_id', '=', 'fv_ouv_solicitante.id')
            ->join('fv_ouv_tipo_solicitante', 'fv_ouv_solicitante.tipo_solicitante_id', '=', 'fv_ouv_tipo_solicitante.id')
            ->where(function ($query) use ($data) {
                if (isset($data['protocolo_psq']) && $data['protocolo_psq'] != "") {
                    $query->where('fv_ouv_solicitacao_ouvidoria.protocolo', '=', $data['protocolo_psq']);
                }
                if (isset($data['cpf_psq']) && $data['cpf_psq'] != "") {
                    $query->where('fv_ouv_solicitante.cpf', '=', $data['cpf_psq']);
                }
                if (isset($data['nome_psq']) && $data['nome_psq'] != "") {
                    $query->where('fv_ouv_solicitante.nome', 'LIKE', "%" . $data['nome_psq'] . "%");
                }
                if (isset($data['tipo_solicitacao_id_psq']) && $data['tipo_solicitacao_id_psq'] != "") {
                    $query->where('fv_ouv_solicitacao_ouvidoria.tipo_solicitacao_id', $data['tipo_solicitacao_id_psq']);
                }
                if (isset($data['tipo_solicitante_id_psq']) && $data['tipo_solicitante_id_psq'] != "") {
                    $query->where('fv_ouv_solicitante.tipo_solicitante_id', $data['tipo_solicitante_id_psq']);
                }
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('fv_ouv_solicitacao_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('fv_ouv_solicitacao_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('fv_ouv_solicitacao_ouvidoria.created_at')->paginate($data['totalPage']);
            // })->toSql();
    }

    public function create(Request $request)
    {   
        $tipo_solicitacao_id = $request->tipo_solicitacao_id;
        $tipo_solicitacaos = TipoSolicitacao::get();
        $tipo_solicitantes = TipoSolicitante::get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;

        return view('ouvidoria.solicitacao-ouvidoria.create', compact(
            'tipo_solicitacao_id', 'tipo_solicitacaos', 'tipo_solicitantes', 'institutoras', 'ufs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_solicitacao_id'=>'required',
            'tipo_solicitante_id'=>'required',
            'cpf'=>'required|cpf|unique:fv_ouv_solicitante,cpf,' . $request->solicitante_id,
            'nome'=>'required|max:120',
            'institutora_id'=>'required',
            'uf'=>'required',
            'cidade'=>'required|max:120',
            'email'=>'required|max:120',
            'celular'=>'required|max:15',
            'mensagem'=>'required|max:255',
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
        }
        $solicitante->save();

        $protocolo = SolicitacaoOuvidoria::get();
        $numero = count($protocolo)+1;
        $protocolo = $numero . date('dmY');

        $anexo = $this->anexarArquivo($request);
        
        $solicitacao_ouvidoria = new SolicitacaoOuvidoria([
            'protocolo' => $protocolo,
            'mensagem' => trim($request->mensagem),
            'anexo' => $anexo,
            'tipo_solicitacao_id' => $request->tipo_solicitacao_id,
            'solicitante_id' => $solicitante->id
        ]);
        $solicitacao_ouvidoria->save();

        $this->enviarEmailSolicitacaoOuvidoria($solicitante->email, $solicitacao_ouvidoria);

        $protocolo = $solicitacao_ouvidoria->protocolo;

        return redirect('/fale-com-ouvidor')
            ->with('success', self::MESSAGE_ADD_SUCCESS . " " . str_pad($protocolo, 14, 0, STR_PAD_LEFT));
    }

    private function anexarArquivo($request)
    {
        $nameFile = null;
        if ($request->hasFile('anexo') && $request->file('anexo')->isValid()) {
            $nameFile = date('YmdHis') . $request->anexo->getClientOriginalName();
            $upload = $request->anexo->storeAs('anexos', $nameFile);
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
        if (empty($data['cpf_psq'])) {
            $data['cpf_psq'] = "";
        }

        if (empty($data['nome_psq'])) {
            $data['nome_psq'] = "";
        }

        if (empty($data['tipo_solicitacao_id_psq'])) {
            $data['tipo_solicitacao_id_psq'] = "";
        }

        if (empty($data['tipo_solicitante_id_psq'])) {
            $data['tipo_solicitante_id_psq'] = "";
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
            return redirect()->back()->with('error', 'Nenhum registro encontrado!')->withInput();
        }
        if (count($solicitacao_ouvidorias) == 1) {
            $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_ouvidorias[0]->id);
            $data['protocolo_psq'] = "";
            $data['cpf_psq'] = $solicitacao_ouvidoria->solicitante->cpf;
        }
        if (count($solicitacao_ouvidorias) > 1) {
            $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_ouvidorias[0]->id);
            $data['protocolo_psq'] = "";
            $data['cpf_psq'] = $solicitacao_ouvidoria->solicitante->cpf;
            $solicitacao_ouvidoria = null;
        }
        $solicitacao_ouvidorias = $this->getSolicitacaoOuvidorias($data);
        $tipo_solicitacaos = TipoSolicitacao::get();

        return view('ouvidoria.solicitacao-ouvidoria.acompanhar', 
            compact('solicitacao_ouvidorias', 'tipo_solicitacaos', 'solicitacao_ouvidoria'));

    }

    public function edit(int $solicitacao_id)
    {
        $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_id);
        $ufs = self::UFS;

        return view('ouvidoria.solicitacao-ouvidoria.edit', compact('solicitacao_ouvidoria', 'ufs'));
    }

    public function update(Request $request, int $solicitacao_id)
    {
        $solicitacao_ouvidoria_edit = SolicitacaoOuvidoria::find($solicitacao_id);

        $request->validate([
            'cpf'=>'required|cpf|unique:solicitante,cpf,' . $solicitacao_ouvidoria_edit->id,
            'nome'=>'required|max:120',
            'institutora_id'=>'required',
            'uf_sigla'=>'required',
            'cidade'=>'required|max:120',
            'email'=>'required|max:120',
            'telefone'=>'required|max:15',
            'celular'=>'required|max:15',
            'mensagem'=>'required|max:255'
        ], self::MESSAGES_ERRORS);

        unset($solicitacao_ouvidoria_edit);
        
        $solicitacao_ouvidoria = SolicitacaoOuvidoria::find($solicitacao_id);
        $solicitacao_ouvidoria->protocolo = $request->get('protocolo');
        $solicitacao_ouvidoria->mensagem = $request->get('mensagem');
        $solicitacao_ouvidoria->anexo = $request->get('anexo');
        $solicitacao_ouvidoria->tipo_solicitacao_id = $request->get('tipo_solicitacao_id');
        $solicitacao_ouvidoria->solicitante_id = $request->get('solicitante_id');
        $solicitacao_ouvidoria->tipo_prestador_id = $request->get('tipo_prestador_id');
        $solicitacao_ouvidoria->sub_classificacao_id = $request->get('sub_classificacao_id');
        $solicitacao_ouvidoria->assunto_id = $request->get('assunto_id');
        $solicitacao_ouvidoria->canal_atendimento_id = $request->get('canal_atendimento_id');
        $solicitacao_ouvidoria->save();
        
        $solicitante = Solicitante::find($solicitacao_ouvidoria->id);
        $solicitante->cpf = $request->get('cpf');
        $solicitante->nome = $request->get('nome');
        $solicitante->email = $request->get('email');
        $solicitante->telefone = $request->get('telefone');
        $solicitante->celular = $request->get('celular');
        $solicitante->uf = $request->get('uf');
        $solicitante->cidade = $request->get('cidade');
        $solicitante->institutora_id = $request->get('institutora_id');
        $solicitante->tipo_solicitante_id = $request->get('tipo_solicitante_id');
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
        $solicitante_request = Solicitante::where('cpf', $request->cpf)->get();
        //Localizar na Tabela de Beneficiarios
        if (count($solicitante_request) == 0) {
            $benef = Beneficiario::where('cic', $this->limpaCPF_CNPJ($request->cpf))->get();

            $solicitante_request = new stdClass();
            $solicitante_request->nome = $benef->nome;
            $solicitante_request->cpf = $this->formatCnpjCpf($benef->cic);
            $solicitante_request->tipo_solicitante_id = "";
            $solicitante_request->institutora_id = "";
            $solicitante_request->uf = "";
            $solicitante_request->cidade = "";
            $solicitante_request->email = $benef->email;
            $solicitante_request->telefone = "";
            $solicitante_request->celular = "";

            $solicitante = $solicitante_request;
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

}
