<?php

use Faker\Generator as Faker;

$factory->define(App\Marca::class, function (Faker $faker) {
    return [
        'descricao' => $faker->text($maxNbChars = 60)
    ];
});
