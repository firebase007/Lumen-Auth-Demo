<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {

    gc_collect_cycles();

    return [
        'name'  => str_replace('.', '', $faker->unique()->name),
        'email'     => $faker->unique()->email,
        'password'  => \Illuminate\Support\Facades\Hash::make('password'),
        'address'       => $faker->sentence(10)
    ];
});
