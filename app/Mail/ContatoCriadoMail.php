<?php
namespace App\Mail;

use App\Models\Contato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContatoCriadoMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Contato $contato) {}

    public function build()
    {
        return $this->subject('Novo contato cadastrado')
                    ->view('emails.contato_criado');
    }
}
