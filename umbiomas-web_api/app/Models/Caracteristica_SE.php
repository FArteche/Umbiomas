<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\LogsActivity;

class Caracteristica_SE extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'caracteristica_se';
    protected $primaryKey = 'id_cse';
    protected $fillable = [
        'nome_cse',
        'descricao_cse',
        'bioma_id',
        'imagem_cse',
        'tipocse_id'
    ];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function bioma(): BelongsTo
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }

    public function tipocse(): BelongsTo
    {
        return $this->belongsTo(Tipo_CSE::class, 'tipocse_id', 'id_tipocse');
    }
}
