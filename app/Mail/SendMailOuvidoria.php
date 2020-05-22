<?php

namespace App\Mail;

use App\Models\Ouvidoria;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailOuvidoria extends Mailable
{
    use Queueable, SerializesModels;

    public $ouvidoria;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ouvidoria $ouvidoria)
    {
        $this->ouvidoria = $ouvidoria;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('faleconosco@fipecqvida.org.br', 'FIPECq Vida')
            ->subject('Ouvidoria FIPECq Vida – Solicitação Registrada')
            ->view('emails.email_ouvidoria_solicitacao')
            ->with([
                'protocolo' => $this->ouvidoria->protocolo
            ]);
    }
    
}
