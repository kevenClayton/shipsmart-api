<?php

namespace App\Repositories\Interfaces;

interface ContatoRepositoryInterface
{
    public function obterIndicadores();
    public function obterTodos();
    public function buscarPorCodigo($codigo);
    public function criar(array $data, array|null $enderecos = null);
    public function atualizar($codigo, array $data, array|null $enderecos = null);
    public function apagar($codigo);
}
