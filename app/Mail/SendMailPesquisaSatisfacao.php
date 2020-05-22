<?php

namespace App\Mail;

use App\Models\Ouvidoria;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailPesquisaSatisfacao extends Mailable
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
            ->subject('Ouvidoria FIPECq Vida – Pesquisa de satisfação')
            ->view('emails.email_pesquisa_satisfacao')
            ->with([
                'ouvidoria_id' => $this->ouvidoria->id
            ]);
    }
}
