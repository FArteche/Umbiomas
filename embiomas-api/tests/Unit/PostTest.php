<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

it('pertence a um bioma', function () {
    $post = new Post();
    expect($post->bioma())->toBeInstanceOf(BelongsTo::class);
});

it('pertence a um info_postador', function () {
    $post = new Post();
    expect($post->postador())->toBeInstanceOf(BelongsTo::class);
});
