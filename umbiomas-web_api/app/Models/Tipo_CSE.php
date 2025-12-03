<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Testing\Fluent\Concerns\Has;
use App\LogsActivity;

class Tipo_CSE extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tipo_cse';
    protected $primaryKey = 'id_tipocse';
    protected $fillable = ['nome_tipocse'];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function caracteristica_se(): HasMany
    {
        return $this->hasMany(Caracteristica_SE::class, 'tipocse_id', 'id_tipocse');
    }
}
