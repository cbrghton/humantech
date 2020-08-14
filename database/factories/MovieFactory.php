<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Movie;
use Faker\Generator as Faker;

$factory->define(Movie::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'published_at' => $faker->date(),
        'image_path' => \Illuminate\Support\Facades\Storage::putFile('movies', $faker->image()),
    ];
});
