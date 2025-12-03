<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\LogsActivity;

class Tipo_Area_Preservacao extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tipo_area_preservacao';
    protected $primaryKey = 'id_tipoap';
    protected $fillable = [
        'nome_tipoap',
    ];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function Area_Preservacao(): HasMany
    {
        return $this->hasMany(Area_Preservacao::class, 'tipoap_id', 'id_tipoap');
    }
}
