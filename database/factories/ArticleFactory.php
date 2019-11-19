<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'cid'=>mt_rand(2,5),
        'title'=>$faker->sentence(),
        'desn'=>$faker->sentence(),
        'pic'=>'/uploads/articles/GjjaRRe72LcELlA6npPBsFzuGW3wQ0cCiA2EPD2V.jpeg',
        'body'=>$faker->text()
    ];
});
