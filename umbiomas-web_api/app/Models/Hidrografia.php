<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\LogsActivity;

class Hidrografia extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'hidrografia';
    protected $primaryKey = 'id_hidrografia';
    protected $fillable = ['nome_hidrografia', 'descricao_hidrografia', 'tipo_hidrografia', 'imagem_hidrografia', 'bioma_id'];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function bioma(): BelongsTo
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }
}
