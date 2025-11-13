<?php

namespace Tests\Unit;

use App\Models\Bioma;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

// Não precisa mais do uses() aqui, pois está no Pest.php

it('tem muitos posts', function () {
    $bioma = new Bioma();
    expect($bioma->posts())->toBeInstanceOf(HasMany::class);
});

it('pertence a muitas faunas', function () {
    $bioma = new Bioma();
    expect($bioma->fauna())->toBeInstanceOf(BelongsToMany::class);
});

it('pertence a muitos climas', function () {
    $bioma = new Bioma();
    expect($bioma->clima())->toBeInstanceOf(BelongsToMany::class);
});
