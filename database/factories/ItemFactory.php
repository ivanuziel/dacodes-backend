<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {

	$type = rand(1,4);
	$data = [];
	if($type == 1){
		$data = [
			'type' => 'boolean',
			'answer-type' => 'single',
			'answer' => $faker->boolean
		];
	} else if($type == 2){
		$data = [
			'type' => 'multiple',
			'answer-type' => 'single',
			'answer' => rand(0,3),
			'options' => [
				'Opción 1',
				'Opción 2',
				'Opción 3',
				'Opción 4',
			]
		];
	} else if($type == 3){
		$data = [
			'type' => 'multiple',
			'answer-type' => 'multiple',
			'answer' => [rand(0,3), rand(0,3)],
			'options' => [
				'Opción 1',
				'Opción 2',
				'Opción 3',
				'Opción 4',
			]
		];
	} else if($type == 4){
		$data = [
			'type' => 'multiple',
			'answer-type' => 'all',
			'answer' => [rand(0,3), rand(0,3)],
			'options' => [
				'Opción 1',
				'Opción 2',
				'Opción 3',
				'Opción 4',
			]
		];
	}

    return [
    	'title' => $faker->words(rand(8,15), true),
        'description' => $faker->text,
		'type' => 'question',
		'data' => json_encode($data),
		'value' => rand(1,5)
    ];
});