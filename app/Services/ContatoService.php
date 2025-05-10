<?php

namespace App\Services;

use App\Repositories\Interfaces\ContatoRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoCriadoMail;

class ContatoService
{
    protected $contatos;
    public function __construct(ContatoRepositoryInterface $contatos)
    {
        $this->contatos =  $contatos;
    }
    public function enviarNotificacaoContatoCriado($contato)
    {
        Mail::to(env('NOTIFICATION_MAIL'))
            ->queue((new ContatoCriadoMail($contato))->onQueue('back_emails'));
    }
}
