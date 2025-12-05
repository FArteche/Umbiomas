<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\LogsActivity;

class Clima extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'clima';
    protected $primaryKey = 'id_clima';
    protected $fillable = [
        'nome_clima',
        'imagem_clima',
        'descricao_clima'
    ];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function biomas(): BelongsToMany
    {
        return $this->belongsToMany(Bioma::class, 'bioma_clima', 'clima_id', 'bioma_id');
    }
}
