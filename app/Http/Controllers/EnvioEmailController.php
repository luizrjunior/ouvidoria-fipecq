<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\SituacaoOuvidoria;
use App\Models\EnvioEmail;

use Illuminate\Http\Request;

use App\Mail\SendMailPesquisaSatisfacao;
use App\Mail\SendMailOuvidoria48;
use App\Mail\SendMailOuvidoria24;
use Illuminate\Support\Facades\Mail;

class EnvioEmailController extends Controller
{

    public function index()
    {
        // ENVIAR EMAIL DE PESQUISA DE SATISFAÇÃO
        $envioEmail = EnvioEmail::where('tipo_email_id', 1)
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        if (count($envioEmail) == 0) {
            $this->enviarEmailsPesquisaSatisfacao();
        }

        // ENVIAR EMAIL DE 48 HORAS
        $envioEmail = EnvioEmail::where('tipo_email_id', 2)
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        if (count($envioEmail) == 0) {
            $this->enviarEmailsOuvidoriaNaoConcluida(8, 2);
        }

        // ENVIAR EMAIL DE 24 HORAS
        $envioEmail = EnvioEmail::where('tipo_email_id', 3)
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        if (count($envioEmail) == 0) {
            $this->enviarEmailsOuvidoriaNaoConcluida(9, 3);
        }

        return 'E-mails do Sistema de Ouvidoria FIPECq Vida enviados com sucesso!';
    }

    private function enviarEmailsPesquisaSatisfacao() 
    {
        $data = array();

        $timestamp = strtotime("-1 days");
        $data['data_inicio'] = date('Y-m-d', $timestamp);

        $timestamp = strtotime("-7 days");
        $data['data_termino'] = date('Y-m-d', $timestamp);

        // Procurar todas as situações igual a 3 e entre um 01 atrás até 07 dias antes
        $situacoesOuvidorias = SituacaoOuvidoria::where('situacao_id', 3)
            ->where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '<=', $data['data_inicio'] . ' 23:59:59');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '>=', $data['data_termino'] . ' 00:00:00');
                }
            })->get();

        if (count($situacoesOuvidorias) > 0) {
            foreach ($situacoesOuvidorias as $situacaoOuvidoria) {
                $ouvidoria_id =  $situacaoOuvidoria->ouvidoria_id;
                $envioEmailOuvidoria = EnvioEmail::where('ouvidoria_id', $ouvidoria_id)
                    ->where('tipo_email_id', 1)->get();
                if (count($envioEmailOuvidoria) == 0) {
                    $ouvidoria = Ouvidoria::find($ouvidoria_id);
                    if ($ouvidoria->solicitante->email != "") {
                        Mail::to($ouvidoria->solicitante->email)
                        ->send(new SendMailPesquisaSatisfacao($ouvidoria));
                        $envioEmail = new EnvioEmail();
                        $envioEmail->tipo_email_id = 1;
                        $envioEmail->ouvidoria_id = $ouvidoria->id;
                        $envioEmail->save();
                    }
                }
            }
        }
    }

    private function enviarEmailsOuvidoriaNaoConcluida($dias, $tipo_email_id) 
    {
        $data = array();
        $data['data_inicio'] = date('Y-m-d');

        $timestamp = strtotime("-14 days");
        $data['data_termino'] = date('Y-m-d', $timestamp);

        $ouvidorias = Ouvidoria::where('situacao_id', '<>', 3)
            ->where(function ($query) use ($data) {
                if (isset($data['data_inicio']) && $data['data_inicio'] != "") {
                    $query->where('created_at', '<=', $data['data_inicio'] . ' 23:59:59');
                }
                if (isset($data['data_termino']) && $data['data_termino'] != "") {
                    $query->where('created_at', '>=', $data['data_termino'] . ' 00:00:00');
                }
            })->get();

        if (count($ouvidorias) > 0) {
            foreach ($ouvidorias as $ouvidoria) {
                $ouvidoriaController = new \App\Http\Controllers\OuvidoriaController();

                $parte_data1 = explode("-", date('Y-m-d', strtotime($ouvidoria->created_at)));
                $anoinicial = $parte_data1['0'];
                $mesinicial = $parte_data1['1'];
                $diainicial = $parte_data1['2'];
                //Concatena em um Novo Formato de DATA
                $datainicial = $anoinicial."-".$mesinicial."-".$diainicial;

                $parte_data2 = explode("-", date('Y-m-d'));
                $anofinal = $parte_data2['0'];
                $mesfinal = $parte_data2['1'];
                $diafinal = $parte_data2['2'];
                //Concatena em um Novo Formato de DATA
                $datafinal = $anofinal."-".$mesfinal."-".$diafinal;

                $diasUteis = $ouvidoriaController->corre_anos($anoinicial, $anofinal, $mesinicial, $mesfinal, $datainicial, $datafinal);
                if ($diasUteis == $dias) {
                    $envioEmailOuvidoria = EnvioEmail::where('ouvidoria_id', $ouvidoria->id)
                        ->where('tipo_email_id', $tipo_email_id)->get();
                    if (count($envioEmailOuvidoria) == 0) {
                        if ($tipo_email_id == 2) {
                            Mail::to("ouvidoria@fipecqvida.org.br")
                            ->send(new SendMailOuvidoria48($ouvidoria));
                        }
                        if ($tipo_email_id == 3) {
                            Mail::to("ouvidoria@fipecqvida.org.br")
                            ->send(new SendMailOuvidoria24($ouvidoria));
                        }
                        $envioEmail = new EnvioEmail();
                        $envioEmail->tipo_email_id = $tipo_email_id;
                        $envioEmail->ouvidoria_id = $ouvidoria->id;
                        $envioEmail->save();
                    }
                }
            }
        }
    }

}
