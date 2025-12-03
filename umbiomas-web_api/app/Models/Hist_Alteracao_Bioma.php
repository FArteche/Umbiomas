<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hist_Alteracao_Bioma extends Model
{
    use HasFactory;

    protected $table = 'hist_alteracao_bioma';
    protected $primaryKey = 'id_hist';
    protected $fillable = [
        'user_id',
        'loggable_id',
        'loggable_type',
        'nome_objeto',
        'tipo_alteracao',
        'detalhes_alteracao'
    ];

    public function loggable()
    {
        return $this->morphTo();
    }

    /*    public function bioma(): BelongsTo
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }
*/

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
