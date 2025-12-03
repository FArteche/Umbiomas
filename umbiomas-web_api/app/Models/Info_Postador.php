<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Info_Postador extends Model
{
    use HasFactory;

    protected $table = 'info_postador';
    protected $primaryKey = 'id_postador';
    protected $fillable = [
        'nome_postador',
        'email_postador',
        'telefone_postador',
        'instituicao_postador',
        'ocupacao_postador',
    ];

    public function post(): HasOne
    {
        return $this->hasOne(Post::class, 'postador_id', 'id_postador');
    }

    public function sugestoes(): HasOne
    {
        return $this->hasOne(Sugestoes::class, 'postador_id', 'id_postador');
    }
}
