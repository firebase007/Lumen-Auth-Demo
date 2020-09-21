
<?php // database/factories/UserFactory.php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'uid'                   =>  \Illuminate\Support\Str::random(32),
        'name'                  => $faker->name,
        'email'                 => $faker->email,
        'password'              => \Illuminate\Support\Facades\Hash::make('test-password'),
        'address'               => $faker->address,
    ];
});
