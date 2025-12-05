<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $primaryKey = 'id_post';
    protected $fillable = ['midia_post', 'titulo_post', 'texto_post', 'aprovado_post', 'bioma_id', 'postador_id'];

    public function bioma(): BelongsTo
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }

    public function postador(): BelongsTo
    {
        return $this->belongsTo(Info_Postador::class, 'postador_id', 'id_postador');
    }

    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }
}
