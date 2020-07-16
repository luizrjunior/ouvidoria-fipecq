<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\Beneficiario;
use App\Models\TipoOuvidoria;
use App\Models\TipoSolicitante;

use App\Models\CanalAtendimento;

use App\Models\Categoria;
use App\Models\Setor;
use App\Models\Assunto;
use App\Models\Classificacao;
use App\Models\Institutora;
use App\Models\SubClassificacao;

use Illuminate\Http\Request;

class RelatorioController extends Controller
{

    private function preparaCamposPesquisa(Request $request)
    {
        $data = $request->except('_token');
        $timestamp = strtotime("-15 days");
        if (empty($data['data_inicio'])) {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y', $timestamp))->format('d/m/Y');
        }
        if (empty($data['data_termino'])) {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', date('d/m/Y'))->format('d/m/Y');
        }

        return $data;
    }

    /**
     * RELATORIO TIPO DE OUVIDORIA
     *
     * @param Request $request
     * @return void
     */
    public function relatorioTipoOuvidoria(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

        $ouvidorias = $this->getOuvidoriasPorTipoSolicitacao($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-tipo-solicitacao-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-tipo-solicitacao', 
            compact('ouvidorias', 'data'));
    }

    private function getOuvidoriasPorTipoSolicitacao(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('tp_ouvidoria_id')->get();
    }


    /**
     * RELATORIO DE FAIXA ETARIA
     *
     * @param Request $request
     * @return void
     */
    public function relatorioFaixaEtaria(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

        $faixasEtarias = $this->getOuvidoriasPorFaixaEtaria($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-faixa-etaria-print', 
                compact('faixasEtarias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-faixa-etaria', 
            compact('faixasEtarias', 'data'));
    }

    private function getOuvidoriasPorFaixaEtaria(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        $ouvidorias = Ouvidoria::where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('tp_ouvidoria_id')->get();

        $faixaEtaria24_28 = 0;
        $faixaEtaria29_33 = 0;
        $faixaEtaria34_38 = 0;
        $faixaEtaria39_43 = 0;
        $faixaEtaria44_48 = 0;
        $faixaEtaria49_53 = 0;
        $faixaEtaria54_58 = 0;
        $faixaEtaria59 = 0;
        
        foreach ($ouvidorias as $ouvidoria) {
            if ($ouvidoria->solicitante_id != "") {
                $cpf = $this->limpaCPF_CNPJ($ouvidoria->solicitante->cpf);
                $benef = Beneficiario::select(
                        'cad_benef.nascimento'
                    )->where('cad_benef.cic', $cpf)->get();
    
                if (count($benef) > 0) {
                    $dataNascimento = $benef[0]->nascimento;
                    $date = new \DateTime($dataNascimento);
                    $interval = $date->diff(new \DateTime( date('Y-m-d')));
                    $idade = (int) $interval->format('%Y');
                    if ($idade >= 24 && $idade <= 28) {
                        $faixaEtaria24_28++;
                    }
                    if ($idade >= 29 && $idade <= 33) {
                        $faixaEtaria29_33++;
                    }
                    if ($idade >= 34 && $idade <= 38) {
                        $faixaEtaria34_38++;
                    }
                    if ($idade >= 39 && $idade <= 43) {
                        $faixaEtaria39_43++;
                    }
                    if ($idade >= 44 && $idade <= 48) {
                        $faixaEtaria44_48++;
                    }
                    if ($idade >= 49 && $idade <= 53) {
                        $faixaEtaria49_53++;
                    }
                    if ($idade >= 54 && $idade <= 58) {
                        $faixaEtaria54_58++;
                    }
                    if ($idade >= 59) {
                        $faixaEtaria59++;
                    }
                }
            }
        }

        $faixasEtarias = array();
        $faixasEtarias[0]['nome'] = "24 - 28 Anos";
        $faixasEtarias[0]['qtde'] = $faixaEtaria24_28;

        $faixasEtarias[1]['nome'] = "29 - 33 Anos";
        $faixasEtarias[1]['qtde'] = $faixaEtaria29_33;

        $faixasEtarias[2]['nome'] = "34 - 38 Anos";
        $faixasEtarias[2]['qtde'] = $faixaEtaria34_38;

        $faixasEtarias[3]['nome'] = "39 - 43 Anos";
        $faixasEtarias[3]['qtde'] = $faixaEtaria39_43;

        $faixasEtarias[4]['nome'] = "44 - 48 Anos";
        $faixasEtarias[4]['qtde'] = $faixaEtaria44_48;

        $faixasEtarias[5]['nome'] = "49 - 53 Anos";
        $faixasEtarias[5]['qtde'] = $faixaEtaria49_53;

        $faixasEtarias[6]['nome'] = "54 - 58 Anos";
        $faixasEtarias[6]['qtde'] = $faixaEtaria54_58;

        $faixasEtarias[7]['nome'] = "De 59 Anos ou mais";
        $faixasEtarias[7]['qtde'] = $faixaEtaria59;

        return $faixasEtarias;
    }


    /**
     * RELATORIO TEMPO DE ESPERA POR TIPO DE OUVIDORIA
     *
     * @param Request $request
     * @return void
     */
    public function relatorioTempoEspera(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

        $ouvidorias = $this->getOuvidoriasTempoEspera($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-tempo-espera-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-tempo-espera', 
            compact('ouvidorias', 'data'));
    }

    private function getOuvidoriasTempoEspera(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->where('situacao_id', 3)->orderBy('tp_ouvidoria_id')->get();
    }


    /**
     * RELATORIO INSITUTORA
     *
     * @param Request $request
     * @return void
     */
    public function relatorioInstitutora(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

        $ouvidorias = $this->getOuvidoriasPorInstitutora($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-institutora-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-institutora', 
            compact('ouvidorias', 'data'));
    }

    private function getOuvidoriasPorInstitutora(Array $data = null)
    {
        if ($data['data_inicio'] != "") {
            $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        }

        if ($data['data_termino'] != "") {
            $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');
        }

        return Ouvidoria::select(
                'cad_empresa.nome as noempresa',
                'fv_ouv_solicitante.institutora_id as idinstitutora'
            )
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->join('plano.cad_empresa', 'fv_ouv_solicitante.institutora_id', 'cad_empresa.empresa')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
            })->orderBy('cad_empresa.nome')->get();
    }


    /**
     * RELATORIOS
     *
     * @param Request $request
     * @return void
     */
    public function relatorios(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

        if (empty($data['tipo_ouvidoria_id_psq'])) {
            $data['tipo_ouvidoria_id_psq'] = array();
            $arrTiposOuvidorias = array();
        } else {
            $arrTiposOuvidorias = $this->getTiposOuvidoriasRelatorios($data);
        }

        if (empty($data['checkTodosTipoOuvidoria'])) {
            $data['checkTodosTipoOuvidoria'] = "";
        }

        if (empty($data['institutora_id_psq'])) {
            $data['institutora_id_psq'] = array();
            $arrInstituidoras = array();
        } else {
            $arrInstituidoras = $this->getInstituidorasRelatorios($data);
        }

        if (empty($data['checkTodosInstituidoras'])) {
            $data['checkTodosInstituidoras'] = "";
        }

        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $institutoras = Institutora::orderBy('nome')->get();

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-relatorios-print', 
                compact('arrTiposOuvidorias', 'arrInstituidoras', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-relatorios', 
            compact('tiposOuvidorias', 'arrTiposOuvidorias', 'institutoras', 'arrInstituidoras', 'data'));
    }

    private function getTiposOuvidoriasRelatorios(Array $data = null)
    {
        $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');

        return Ouvidoria::select(
                'fv_ouv_tp_ouvidoria.id as idtipoouvidoria',
                'fv_ouv_tp_ouvidoria.nome as notipoouvidoria'
            )
            ->join('fv_ouv_tp_ouvidoria', 'fv_ouv_ouvidoria.tp_ouvidoria_id', 'fv_ouv_tp_ouvidoria.id')
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($data) {
                $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                $query->whereIn('fv_ouv_ouvidoria.tp_ouvidoria_id', $data['tipo_ouvidoria_id_psq']);
            })->orderBy('fv_ouv_ouvidoria.tp_ouvidoria_id')->get();
    }

    private function getInstituidorasRelatorios(Array $data = null)
    {
        $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');

        return Ouvidoria::select(
                'cad_empresa.empresa as idempresa',
                'cad_empresa.nome as noempresa'
            )
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->join('plano.cad_empresa', 'fv_ouv_solicitante.institutora_id', 'cad_empresa.empresa')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($data) {
                $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                $query->whereIn('fv_ouv_solicitante.institutora_id', $data['institutora_id_psq']);
            })->orderBy('cad_empresa.nome')->get();
    }

    public function pegarTipoOuvidoriaPorInstituidora(int $tp_ouvidoria_id, int $institutora_id, Array $data = null)
    {
        $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');

        return count(Ouvidoria::join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->join('plano.cad_empresa', 'fv_ouv_solicitante.institutora_id', 'cad_empresa.empresa')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($tp_ouvidoria_id, $institutora_id, $data) {
                $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                $query->where('fv_ouv_ouvidoria.tp_ouvidoria_id', $tp_ouvidoria_id);
                $query->where('fv_ouv_solicitante.institutora_id', $institutora_id);
            })->orderBy('fv_ouv_ouvidoria.tp_ouvidoria_id')->get());
    }


    /**
     * RELATORIO PERSONALIZADO
     *
     * @param Request $request
     * @return void
     */
    public function relatorioPersonalizado(Request $request)
    {
        $data = $this->preparaCamposPesquisa($request);

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

        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->get();
        $tiposSolicitantes = TipoSolicitante::where('status', 1)->get();
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

        $ouvidorias = $this->getOuvidoriasPersonalizado($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-personalizado-print', 
                compact('ouvidorias', 'data'));
        }
        return view('ouvidoria.relatorios.relatorio-personalizado', compact('tiposOuvidorias', 'tiposSolicitantes', 
            'categorias', 'setores', 'assuntos', 'classificacoes', 'subClassificacoes', 'ouvidorias', 'data'));
    }

    private function getOuvidoriasPersonalizado(Array $data = null)
    {
        $data['data_inicio'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio'])->format('Y-m-d');
        $data['data_termino'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino'])->format('Y-m-d');

        return Ouvidoria::select(
                'cad_empresa.nome as noempresa',
                'fv_ouv_solicitante.institutora_id as idinstitutora'
            )
            ->join('fv_ouv_solicitante', 'fv_ouv_ouvidoria.solicitante_id', 'fv_ouv_solicitante.id')
            ->join('plano.cad_empresa', 'fv_ouv_solicitante.institutora_id', 'cad_empresa.empresa')
            ->whereNotNull('fv_ouv_solicitante.institutora_id')
            ->where(function ($query) use ($data) {
                if ($data['data_inicio'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '>=', $data['data_inicio'] . ' 00:00:00');
                }
                if ($data['data_termino'] != "") {
                    $query->where('fv_ouv_ouvidoria.created_at', '<=', $data['data_termino'] . ' 23:59:59');
                }
                if ($data['tipo_ouvidoria_id_psq'] != "") {
                    $query->where('fv_ouv_ouvidoria.tp_ouvidoria_id', $data['tipo_ouvidoria_id_psq']);
                }
                if ($data['tipo_solicitante_id_psq'] != "") {
                    $query->where('fv_ouv_solicitante.tipo_solicitante_id', $data['tipo_solicitante_id_psq']);
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
            })->orderBy('cad_empresa.nome')->get();
    }


    /**
     * RELATORIO TIPO DE OUVIDORIA
     *
     * @param Request $request
     * @return void
     */
    public function relatorioComparativo(Request $request)
    {
        $data = $request->except('_token');
        if (empty($data['data_inicio_1'])) {
            $data['data_inicio_1'] = "01/01/" . (date('Y') - 1);
        }
        if (empty($data['data_termino_1'])) {
            $data['data_termino_1'] = "31/12/" . (date('Y') - 1);
        }

        if (empty($data['data_inicio_2'])) {
            $data['data_inicio_2'] = "01/01/" . date('Y');
        }
        if (empty($data['data_termino_2'])) {
            $data['data_termino_2'] = "31/12/" . date('Y');
        }

        $canaisAtendimentos = CanalAtendimento::where('status', 1)->orderBy('id')->get();
        $tiposOuvidorias = TipoOuvidoria::where('status', 1)->orderBy('id')->get();

        $ouvidoriasAnoInicioCA = $this->getOuvidoriasAnoInicioCA($data);
        $ouvidoriasAnoTerminoCA = $this->getOuvidoriasAnoTerminoCA($data);

        $ouvidoriasAnoInicioTS = $this->getOuvidoriasAnoInicioTS($data);
        $ouvidoriasAnoTerminoTS = $this->getOuvidoriasAnoTerminoTS($data);

        if (!empty($data['print'])) {
            return view('ouvidoria.relatorios.relatorio-comparativo-print', compact('canaisAtendimentos', 'tiposOuvidorias', 'data',
            'ouvidoriasAnoInicioCA', 'ouvidoriasAnoTerminoCA', 'ouvidoriasAnoInicioTS', 'ouvidoriasAnoTerminoTS'));
        }
        return view('ouvidoria.relatorios.relatorio-comparativo', compact('canaisAtendimentos', 'tiposOuvidorias', 'data',
            'ouvidoriasAnoInicioCA', 'ouvidoriasAnoTerminoCA', 'ouvidoriasAnoInicioTS', 'ouvidoriasAnoTerminoTS'));
    }

    private function getOuvidoriasAnoInicioCA(Array $data = null)
    {
        $data['data_inicio_1'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_1'])->format('Y-m-d');
        $data['data_termino_1'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_1'])->format('Y-m-d');

        return Ouvidoria::where(function ($query) use ($data) {
                $query->whereNotNull('canal_atendimento_id');
                $query->where('created_at', '>=', $data['data_inicio_1'] . ' 00:00:00');
                $query->where('created_at', '<=', $data['data_termino_1'] . ' 23:59:59');
            })->orderBy('canal_atendimento_id')->get();
    }

    private function getOuvidoriasAnoTerminoCA(Array $data = null)
    {
        $data['data_inicio_2'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_2'])->format('Y-m-d');
        $data['data_termino_2'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_2'])->format('Y-m-d');

        return Ouvidoria::where(function ($query) use ($data) {
                $query->whereNotNull('canal_atendimento_id');
                $query->where('created_at', '>=', $data['data_inicio_2'] . ' 00:00:00');
                $query->where('created_at', '<=', $data['data_termino_2'] . ' 23:59:59');
            })->orderBy('canal_atendimento_id')->get();
    }

    private function getOuvidoriasAnoInicioTS(Array $data = null)
    {
        $data['data_inicio_1'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_1'])->format('Y-m-d');
        $data['data_termino_1'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_1'])->format('Y-m-d');

        return Ouvidoria::where(function ($query) use ($data) {
                $query->where('created_at', '>=', $data['data_inicio_1'] . ' 00:00:00');
                $query->where('created_at', '<=', $data['data_termino_1'] . ' 23:59:59');
            })->orderBy('tp_ouvidoria_id')->get();
    }

    private function getOuvidoriasAnoTerminoTS(Array $data = null)
    {
        $data['data_inicio_2'] = \DateTime::createFromFormat('d/m/Y', $data['data_inicio_2'])->format('Y-m-d');
        $data['data_termino_2'] = \DateTime::createFromFormat('d/m/Y', $data['data_termino_2'])->format('Y-m-d');

        return Ouvidoria::where(function ($query) use ($data) {
                $query->where('created_at', '>=', $data['data_inicio_2'] . ' 00:00:00');
                $query->where('created_at', '<=', $data['data_termino_2'] . ' 23:59:59');
            })->orderBy('tp_ouvidoria_id')->get();
    }

    public function obterPercentual($percentage, $of)
    {
        $percent = $percentage / $of;
        return  number_format( $percent * 100, 2 ) . '%';;
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


}

