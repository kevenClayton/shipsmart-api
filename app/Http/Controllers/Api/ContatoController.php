<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContatoRequest;
use App\Http\Requests\ContatoAtualizarRequest;
use App\Repositories\Interfaces\ContatoRepositoryInterface;
use App\Services\ContatoService;

class ContatoController extends Controller
{
    protected $contato;
    protected $contatoServico;
    public function __construct(ContatoRepositoryInterface $contato, ContatoService $contatoService)
    {

        $this->contato =  $contato;
        $this->contatoServico = $contatoService;
    }

    public function indicadores()
    {
        $indicadores = $this->contato->obterIndicadores();
        return response()->json($indicadores);
    }
    public function listar()
    {
        $contatos = $this->contato->obterTodos();
        return response()->json($contatos);
    }
    public function buscar($codigo)
    {
        $contato = $this->contato->buscarPorCodigo($codigo);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json($contato);
    }
    public function criar(ContatoRequest $request)
    {
        $data = $request->except('enderecos');
        $enderecos = $request->input('enderecos');
        $contato = $this->contato->criar($data, $enderecos);
        $this->contatoServico->enviarNotificacaoContatoCriado($contato);

        return response()->json($contato, status: 200);
    }

    public function atualizar(ContatoAtualizarRequest $request, $codigo)
    {
        $data = $request->except('enderecos');
        $enderecos = $request->input('enderecos');
        $contato = $this->contato->atualizar($codigo, $data, $enderecos);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json($contato);
    }
    public function apagar($codigo)
    {
        $contato = $this->contato->apagar($codigo);
        if (!$contato) {
            return response()->json(['message' => 'Contato não encontrado'], 404);
        }
        return response()->json(['message' => 'Contato apagado com sucesso']);
    }
}
