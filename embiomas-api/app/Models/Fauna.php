<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\LogsActivity;

class Fauna extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fauna';
    protected $primaryKey = 'id_fauna';
    protected $fillable = ['nome_fauna', 'nome_cientifico_fauna', 'familia_fauna', 'imagem_fauna', 'descricao_fauna'];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    public function biomas(): BelongsToMany
    {
        return $this->belongsToMany(Bioma::class, 'bioma_fauna', 'fauna_id', 'bioma_id');
    }
}
