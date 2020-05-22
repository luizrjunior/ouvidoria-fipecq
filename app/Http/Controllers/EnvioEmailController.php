<?php

namespace App\Http\Controllers;

use App\Models\Ouvidoria;
use App\Models\SituacaoOuvidoria;
use App\Models\EnvioEmail;

use Illuminate\Http\Request;

use App\Mail\SendMailPesquisaSatisfacao;
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
            $this->enviarEmailsOuvidoria48();
        }

        // ENVIAR EMAIL DE 24 HORAS
        $envioEmail = EnvioEmail::where('tipo_email_id', 2)
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))->get();
        if (count($envioEmail) == 0) {
            $this->enviarEmailsOuvidoria24();
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

    private function enviarEmailsOuvidoria48() 
    {
    }

    private function enviarEmailsOuvidoria24() 
    {
    }

}
