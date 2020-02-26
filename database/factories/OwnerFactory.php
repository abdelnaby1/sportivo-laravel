<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Owner;

$factory->define(Owner::class, function (Faker $faker) {

    $name = $faker->name;

    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    $username = $firstName.$lastName;
    $email = $firstName[0].$lastName.'@'.$faker->safeEmailDomain;

    return [
        'firstName'         => $firstName,
        'lastName'          => $lastName,
        'username'          => $username,
        'email'             => $email,
        'email_verified_at' => now(),
        'password'          => bcrypt('123456'), // password
        'api_token'         => bin2hex(openssl_random_pseudo_bytes(30)),
        'confirmed'         =>false,
        'remember_token'    => Str::random(10),
    ];
});
