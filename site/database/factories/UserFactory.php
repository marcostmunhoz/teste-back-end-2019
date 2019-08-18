<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'     => 'Suporte',
        'email'    => 'suporte@dindigital.com',
        'password' => bcrypt('secret'),
    ];
});
