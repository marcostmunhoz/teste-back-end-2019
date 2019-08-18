<?php

use App\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'     => 'Suporte',
        'email'    => 'suporte@dindigital.com',
        'password' => bcrypt('secret'),
    ];
});
