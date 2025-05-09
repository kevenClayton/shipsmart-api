<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Http\Requests\ContatoAtualizarRequest;
use App\Repositories\Interfaces\ContatoRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContatoCriadoMail;

class ContatoController extends Controller
{
    protected $contatos;
    public function __construct(ContatoRepositoryInterface $contatos)
    {

        $this->contatos =  $contatos;
    }

    public function indicadores()
    {
        $indicadores = $this->contatos->obterIndicadores();
        return response()->json($indicadores);
    }
    public function listar()
    {
        $contatos = $this->contatos->obterTodos();
        return response()->json($contatos);
    }
    public function buscar($codigo)
    {
        $contato = $this->contatos->buscarPorCodigo($codigo);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json($contato);
    }
    public function criar(ContatoRequest $request)
    {
        $data = $request->except('enderecos');
        $enderecos = $request->input('enderecos');
        $contato = $this->contatos->criar($data, $enderecos);

        Mail::to(env('NOTIFICATION_MAIL'))
            ->queue((new ContatoCriadoMail($contato))->onQueue('back_emails'));

        return response()->json($contato, status: 200);
    }

    public function atualizar(ContatoAtualizarRequest $request, $codigo)
    {
        $data = $request->except('enderecos');
        $enderecos = $request->input('enderecos');
        $contato = $this->contatos->atualizar($codigo, $data, $enderecos);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json($contato);
    }
    public function apagar($codigo)
    {
        $contato = $this->contatos->apagar($codigo);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json(['message' => 'Contato apagado com sucesso']);
    }
}
