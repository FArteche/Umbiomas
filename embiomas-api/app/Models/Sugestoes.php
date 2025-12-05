<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sugestoes extends Model
{
    protected $table = 'sugestoes';
    protected $primaryKey = 'id_sugestoes';
    protected $fillable = [
        'texto_sugestao',
        'lido_em',
        'postador_id'
    ];

    protected $casts = [
        'lido_em' => 'datetime',
    ];


    public function postador(): BelongsTo
    {
        return $this->belongsTo(Info_Postador::class, 'postador_id', 'id_postador');
    }
}
