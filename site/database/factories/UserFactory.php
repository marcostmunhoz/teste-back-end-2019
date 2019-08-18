<?php

use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
        'name'     => 'Suporte',
        'email'    => 'suporte@dindigital.com',
        'password' => bcrypt('secret'),
    ];
});
