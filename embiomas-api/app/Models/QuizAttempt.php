<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class QuizAttempt extends Model
{
    protected $table = 'quiz_attempts';

    protected $fillable = [
        'bioma_id',
        'postador_id',
        'score'
    ];

    public function postador()
    {
        return $this->belongsTo(Info_Postador::class, 'postador_id', 'id_postador');
    }

    public function bioma()
    {
        return $this->belongsTo(Bioma::class, 'bioma_id', 'id_bioma');
    }
}
