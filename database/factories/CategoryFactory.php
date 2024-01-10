<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        //category name is defined as a random faker word. 
        //ucwords() function capitalizes the word
        "name" => ucwords($faker->word)
    ];
});
