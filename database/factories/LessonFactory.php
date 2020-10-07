<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Course;
use App\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'description' => $faker->text,
        'approval_min' => rand(1, 20),
        'course_id' => Course::inRandomOrder()->first()
    ];
});
