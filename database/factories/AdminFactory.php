<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Admin::class, function (Faker $faker) {
    return [
        //
        'username'=>$faker->userName,
        'truename'=>$faker->name,
        'password'=>'123456',
        'email'=>$faker->email,
        'phone'=>$faker->phoneNumber,
        'sex'=>['先生','女士'][rand(0,1)],
        'last_ip'=>'123.4.5.6'
    ];
});
