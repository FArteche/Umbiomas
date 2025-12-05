<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\LogsActivity;

class Bioma extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'biomas';
    protected $primaryKey = 'id_bioma';
    protected $fillable = [
        'nome_bioma',
        'descricao_bioma',
        'imagem_bioma',
        'populacao_bioma',
        'area_geografica'
    ];

    protected $casts = [
        'area_geografica' => 'array',
    ];

    //RELACIONAMENTO PARA O HISTÓRICO DE ALTERAÇÕES (MORPH MANY)
    public function historico()
    {
        return $this->morphMany(Hist_Alteracao_Bioma::class, 'loggable');
    }

    //RELACIONAMENTOS 1 - N

    //Um bioma possui muitos relevos
    public function relevo(): HasMany
    {
        return $this->hasMany(Relevo::class, 'bioma_id', 'id_bioma');
    }
    //Um bioma possui muitas hidrografias
    public function hidrografia(): HasMany
    {
        return $this->hasMany(Hidrografia::class, 'bioma_id', 'id_bioma');
    }
    //Um bioma possui muitas caracteristicas_se
    public function caracteristica_se(): HasMany
    {
        return $this->hasMany(Caracteristica_SE::class, 'bioma_id', 'id_bioma');
    }
    //Um bioma possui vários posts
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'bioma_id', 'id_bioma');
    }
    public function pendingPosts()
    {
        return $this->hasMany(Post::class, 'bioma_id', 'id_bioma')->whereNull('aprovado_post');
    }
    //Um bioma possui varias areas_preservacao
    public function area_preservacao(): HasMany
    {
        return $this->hasMany(Area_Preservacao::class, 'bioma_id', 'id_bioma');
    }
    //Um bioma possui muitos registros de alteração
    public function hist_alteracao_bioma(): HasMany
    {
        return $this->hasMany(Hist_Alteracao_Bioma::class, 'bioma_id', 'id_bioma');
    }

    //RELACIONAMENTOS N - N

    //Um Bioma tem muitas Faunas
    public function fauna(): BelongsToMany
    {
        return $this->belongsToMany(Fauna::class, 'bioma_fauna', 'bioma_id', 'fauna_id');
    }
    //Um Bioma tem muitas Floras
    public function flora(): BelongsToMany
    {
        return $this->belongsToMany(Flora::class, 'bioma_flora', 'bioma_id', 'flora_id');
    }
    //Um bioma tem muitos climas
    public function clima(): BelongsToMany
    {
        return $this->belongsToMany(Clima::class, 'bioma_clima', 'bioma_id', 'clima_id');
    }
}
