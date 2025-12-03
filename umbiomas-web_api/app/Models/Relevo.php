<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\LogsActivity;

class Relevo extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'relevo';
    protected $primaryKey = 'id_relevo';
    protected $fillable = ['nome_relevo', 'descricao_relevo', 'tipo_relevo', 'imagem_relevo', 'bioma_id'];

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
