<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Owner;

$factory->define(Owner::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => bcrypt('123456'), // password
        'api_token'  => bin2hex(openssl_random_pseudo_bytes(30)),
        'remember_token' => Str::random(10),
    ];
});
