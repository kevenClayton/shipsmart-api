<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';
    protected $primaryKey = 'codigo';
    protected $guarded = [];
    protected $appends = [];

    public function enderecos()
    {
        return $this->hasMany(ContatoEndereco::class, 'codigo_contato', 'codigo');
    }
    public function getTelefoneAttribute($value)
    {
        if (strlen($value) === 11) {
            // Aplica a máscara com o nono dígito
            return preg_replace('/(\d{2})(\d{1})(\d{4})(\d{4})/', '($1) $2 $3-$4', $value);
        } else {
            // Aplica a máscara sem o nono dígito
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $value);
        }
    }
    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = preg_replace('/[^0-9]/', '', $value);
    }
}
