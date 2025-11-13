<?php

namespace Tests\Unit;

use App\Models\QuizAttempt;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

it('pertence a um bioma', function () {
    $attempt = new QuizAttempt();
    expect($attempt->bioma())->toBeInstanceOf(BelongsTo::class);
});
