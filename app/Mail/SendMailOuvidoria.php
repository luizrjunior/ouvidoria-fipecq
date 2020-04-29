<?php

namespace App\Mail;

use App\Models\SolicitacaoOuvidoria;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailOuvidoria extends Mailable
{
    use Queueable, SerializesModels;

    public $solicitacaoOuvidoria;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(SolicitacaoOuvidoria $solicitacaoOuvidoria)
    {
        $this->solicitacaoOuvidoria = $solicitacaoOuvidoria;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('faleconosco@fipecqvida.org.br', 'FIPECq Vida')
            ->view('emails.email_ouvidoria_solicitacao')
            ->with([
                'protocolo' => $this->solicitacaoOuvidoria->solicitacao_ouvidoria_protocolo
            ]);
    }
}
