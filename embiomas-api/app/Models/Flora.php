<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\LogsActivity;

class Flora extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'flora';
    protected $primaryKey = 'id_flora';
    protected $fillable = ['nome_flora', 'nome_cientifico_flora', 'familia_flora', 'imagem_flora', 'descricao_flora'];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function biomas(): BelongsToMany
    {
        return $this->belongsToMany(Bioma::class, 'bioma_flora', 'flora_id', 'flora_id');
    }
}
