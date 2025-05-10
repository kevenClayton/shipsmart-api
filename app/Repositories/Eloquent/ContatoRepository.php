<?php

namespace App\Repositories\Eloquent;

use App\Models\Contato;
use App\Repositories\Interfaces\ContatoRepositoryInterface;

class ContatoRepository implements ContatoRepositoryInterface
{
    public function obterIndicadores()
    {
        return [
            'total_contatos' => Contato::count(),
            'total_com_enderecos' => Contato::with('enderecos')->get()->sum(function ($contato) {
                return $contato->enderecos->count();
            }),
            'total_com_telefone'=> Contato::whereNotNull('telefone')->count(),
        ];
    }
    public function obterTodos()
    {
        return Contato::with('enderecos')->get();
    }
    public function buscarPorCodigo($codigo){
        return Contato::with('enderecos')->find($codigo);
    }
    public function criar(array $data, array|null $enderecos = null){
        $contato = Contato::create($data);
        if (!empty($enderecos)) {
            foreach ($enderecos as $endereco) {
                $contato->enderecos()->create($endereco);
            }
        }
        return $contato;
    }
    public function atualizar($codigo, array $data, array|null $enderecos = null){
        $contato = Contato::find($codigo);
        if (!$contato) {
            return null;
        }
        $contato->update($data);
        if (!empty($enderecos)) {
            foreach ($enderecos as $endereco) {
                if (isset($endereco['codigo'])) {
                    $contato->enderecos()
                        ->updateOrCreate(
                            ['codigo' => $endereco['codigo']],
                            $endereco
                        );
                } else {
                    $contato->enderecos()->create($endereco);
                }
            }
        }
        return $contato;
    }
    public function apagar($codigo){
        $contato = Contato::find($codigo);
        if (!$contato) {
            return null;
        }
        $contato->enderecos()->delete();
        $contato->delete();
        return true;
    }
}
