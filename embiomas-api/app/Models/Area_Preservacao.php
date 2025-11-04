<?php

namespace App\Models;

use App\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area_Preservacao extends Model
{

    use HasFactory, LogsActivity;

    protected $table = 'area_preservacao';
    protected $primaryKey = 'id_ap';
    protected $fillable = [
        'nome_ap',
        'descricao_ap',
        'bioma_id',
        'tipoap_id',
        'imagem_ap',
        'area_geografica'
    ];

    protected $casts = [
        'area_geografica' => 'array',
    ];

    public function bioma()
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }
    public function tipoap()
    {
        return $this->belongsTo(Tipo_Area_Preservacao::class, 'tipoap_id', 'id_tipoap');
    }

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }
}
