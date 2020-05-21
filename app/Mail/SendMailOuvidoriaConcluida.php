<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailOuvidoriaConcluida extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('faleconosco@fipecqvida.org.br', 'FIPECq Vida')
            ->subject('Conclusão da Solicitação de Ouvidoria - FIPECq Vida')
            ->view('emails.email_ouvidoria_concluida');
    }
}
