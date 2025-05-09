<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContatoEndereco extends Model
{
    use HasFactory;
    protected $table = 'contatos_enderecos';
    protected $primaryKey = 'codigo';
    protected $guarded = [];
    protected $appends = [];

    public function contato()
    {
        return $this->belongsTo(Contato::class, 'codigo', 'codigo_contato');
    }
    public function getCepAttribute($value): ?string
    {
        $cep = $value ?? null;
        return $cep ? preg_replace('/\D/', '', $cep) : null;
    }
    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = preg_replace('/\D/', '', $value);
    }
}
