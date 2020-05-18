<?php

namespace App\Http\Controllers;

use stdClass;

use App\Mail\SendMailOuvidoria;

use App\Models\Beneficiario;
use App\Models\Institutora;

use App\Models\TipoSolicitante;
use App\Models\Solicitante;
use App\Models\TipoOuvidoria;
use App\Models\Ouvidoria;
use App\Models\Situacao;
use App\Models\SituacaoOuvidoria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OuvidoriaController extends Controller
{
    const MESSAGES_ERRORS = [
        'tipo_ouvidoria_id.required' => 'O Tipo de Solicitação precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'tipo_solicitante_id.required' => 'O Tipo de Solicitante - Você é precisa ser informado. Por favor, '
        . 'você pode verificar isso?',

        'cpf.required' => 'O CPF precisa ser informado. Por favor, '
        . 'você pode verificar isso?',
        'cpf.cpf' => 'O CPF precisa ser válido. Por favor, '
        . 'você pode verificar isso?',
        'cpf.unique' => 'Ops, CPF informado já está em uso. '
            . 'Por favor, você pode verificar isso?',

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
        'mensagem.max' => 'Ops, a Mensagem não precisa ter mais que 255 caracteres. '
        . 'Por favor, você pode verificar isso?',
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

    public function index()
    {
        $data = array();
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

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $ouvidorias = $this->getOuvidorias($data);

        $tiposOuvidorias = TipoOuvidoria::get();
        $tiposSolicitantes = TipoSolicitante::get();

        return view('ouvidoria.ouvidoria.index', 
            compact('tiposOuvidorias', 'tiposSolicitantes', 'ouvidorias', 'data'));
    }

    public function search(Request $request)
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

        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('01/m/Y'))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        $data['totalPage'] = isset($data['totalPage']) ? $data['totalPage'] : 25;

        $ouvidorias = $this->getOuvidorias($data);

        $tiposOuvidorias = TipoOuvidoria::get();
        $tiposSolicitantes = TipoSolicitante::get();

        return view('ouvidoria.ouvidoria.index', 
            compact('tiposOuvidorias', 'tiposSolicitantes', 'ouvidorias', 'data'));
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
                'fv_ouv_ouvidoria.created_at as dtCriacao')
            ->join('fv_ouv_tp_ouvidoria', 'fv_ouv_ouvidoria.tp_ouvidoria_id', '=', 'fv_ouv_tp_ouvidoria.id')
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', '=', 'fv_ouv_solicitante.id')
            ->join('fv_ouv_tipo_solicitante', 'fv_ouv_solicitante.tipo_solicitante_id', '=', 'fv_ouv_tipo_solicitante.id')
            ->where(function ($query) use ($data) {
                if (isset($data['protocolo_psq']) && $data['protocolo_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.protocolo', '=', $data['protocolo_psq']);
                }
                if (isset($data['cpf_psq']) && $data['cpf_psq'] != "") {
                    $query->where('fv_ouv_solicitante.cpf', '=', $data['cpf_psq']);
                }
                if (isset($data['nome_psq']) && $data['nome_psq'] != "") {
                    $query->where('fv_ouv_solicitante.nome', 'LIKE', "%" . $data['nome_psq'] . "%");
                }
                if (isset($data['tipo_ouvidoria_id_psq']) && $data['tipo_ouvidoria_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.tp_ouvidoria_id', $data['tipo_ouvidoria_id_psq']);
                }
                if (isset($data['tipo_solicitante_id_psq']) && $data['tipo_solicitante_id_psq'] != "") {
                    $query->where('fv_ouv_solicitante.tipo_solicitante_id', $data['tipo_solicitante_id_psq']);
                }
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('fv_ouv_ouvidoria.created_at')->paginate($data['totalPage']);
            // })->toSql();
    }

    public function create(Request $request)
    {   
        $tipo_ouvidoria_id = $request->tipo_ouvidoria_id;
        $tiposOuvidorias = TipoOuvidoria::get();
        $tiposSolicitantes = TipoSolicitante::get();
        $institutoras = Institutora::get();
        $ufs = self::UFS;

        return view('ouvidoria.ouvidoria.create', compact(
            'tipo_ouvidoria_id', 'tiposOuvidorias', 'tiposSolicitantes', 'institutoras', 'ufs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_ouvidoria_id'=>'required',
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

        $protocolo = Ouvidoria::get();
        $numero = count($protocolo)+1;
        $protocolo = $numero . date('dmY');

        $ouvidoria = new Ouvidoria([
            'protocolo' => $protocolo,
            'mensagem' => trim($request->mensagem),
            'tp_ouvidoria_id' => $request->tipo_ouvidoria_id,
            'solicitante_id' => $solicitante->id
        ]);
        $ouvidoria->save();

        $this->anexarArquivo($ouvidoria, $request);
        
        $this->enviarEmailOuvidoria($solicitante->email, $ouvidoria);

        $protocolo = $ouvidoria->protocolo;

        $situacaoOuvidoria = new SituacaoOuvidoria([
            'comentario' => 'Nova Ouvidoria registrada em ' . date('d/m/Y H:i:s', strtotime($ouvidoria->created_at)),
            'ouvidoria_id' => $ouvidoria->id,
            'situacao_id' => 1
        ]);
        $situacaoOuvidoria->save();

        return redirect('/fale-com-ouvidor')
            ->with('success', self::MESSAGE_ADD_SUCCESS . " " . str_pad($protocolo, 14, 0, STR_PAD_LEFT));
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
            $data['protocolo_psq'] = "";
            $data['cpf_psq'] = $ouvidoria->solicitante->cpf;

            $situacoesOuvidoria = SituacaoOuvidoria::where('ouvidoria_id', $ouvidoria->id)->orderBy('id', 'DESC')->get();
            $situacaoOuvidoria = $situacoesOuvidoria[0];
        }
        if (count($ouvidorias) > 1) {
            $ouvidoria = Ouvidoria::find($ouvidorias[0]->id);
            $data['protocolo_psq'] = "";
            $data['cpf_psq'] = $ouvidoria->solicitante->cpf;
            $ouvidoria = null;
            $situacaoOuvidoria = null;
        }
        $ouvidorias = $this->getOuvidorias($data);
        $tiposOuvidorias = TipoOuvidoria::get();
        $situacoes = Situacao::get();

        return view('ouvidoria.ouvidoria.acompanhar', 
            compact('ouvidorias', 'tiposOuvidorias', 'ouvidoria', 'situacaoOuvidoria', 'situacoes'));
    }

    public function edit(int $solicitacao_id)
    {
        $ouvidoria = Ouvidoria::find($solicitacao_id);
        $ufs = self::UFS;

        return view('ouvidoria.ouvidoria.edit', compact('ouvidoria', 'ufs'));
    }

    public function update(Request $request, int $solicitacao_id)
    {
        $ouvidoria_edit = Ouvidoria::find($solicitacao_id);

        $request->validate([
            'cpf'=>'required|cpf|unique:solicitante,cpf,' . $ouvidoria_edit->id,
            'nome'=>'required|max:120',
            'institutora_id'=>'required',
            'uf_sigla'=>'required',
            'cidade'=>'required|max:120',
            'email'=>'required|max:120',
            'telefone'=>'required|max:15',
            'celular'=>'required|max:15',
            'mensagem'=>'required|max:255'
        ], self::MESSAGES_ERRORS);

        unset($ouvidoria_edit);
        
        $ouvidoria = Ouvidoria::find($solicitacao_id);
        $ouvidoria->protocolo = $request->get('protocolo');
        $ouvidoria->mensagem = $request->get('mensagem');
        $ouvidoria->anexo = $request->get('anexo');
        $ouvidoria->tipo_ouvidoria_id = $request->get('tipo_ouvidoria_id');
        $ouvidoria->solicitante_id = $request->get('solicitante_id');
        $ouvidoria->tipo_prestador_id = $request->get('tipo_prestador_id');
        $ouvidoria->sub_classificacao_id = $request->get('sub_classificacao_id');
        $ouvidoria->assunto_id = $request->get('assunto_id');
        $ouvidoria->canal_atendimento_id = $request->get('canal_atendimento_id');
        $ouvidoria->save();
        
        $solicitante = Solicitante::find($ouvidoria->id);
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

        return redirect('/ouvidoria/create')->with('success', self::MESSAGE_ADD_SUCCESS);
    }

    public function destroy(int $id)
    {
        $ouvidoria = Ouvidoria::find($id);
        $ouvidoria->delete();
   
        return redirect('/ouvidoria/create')->with('success', self::MESSAGE_DESTROY_SUCCESS);
    }

    public function carregarSolicitantePorCPF(Request $request)
    {
        $solicitante = null;
        $solicitante_request = Solicitante::where('cpf', $request->cpf)->get();
        //Localizar na Tabela de Beneficiarios
        if (count($solicitante_request) == 0) {
            $cpf = $this->limpaCPF_CNPJ($request->cpf);
            $benef = Beneficiario::where('cic', $cpf)->get();
            if (count($benef) > 0) {
                $solicitante = new Solicitante();
                $solicitante->nome = $benef[0]->nome;
                $solicitante->cpf = $this->formatCnpjCpf($benef[0]->cic);
                $solicitante->email = $benef[0]->email;
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

    public function pegarSituacao(int $ouvidoria_id) 
    {
        $situacoesOuvidoria = SituacaoOuvidoria::where('ouvidoria_id', $ouvidoria_id)->orderBy('id', 'DESC')->get();
        return $situacoesOuvidoria[0];
    }
    
}
