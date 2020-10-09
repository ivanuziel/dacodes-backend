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
			'answer_type' => 'single',
			'answer' => $faker->boolean
		];
	} else if($type == 2){
		$data = [
			'type' => 'multiple',
			'answer_type' => 'single',
			'answer' => rand(0,3),
			'options' => [
				'Option 1',
				'Option 2',
				'Option 3',
				'Option 4',
			]
		];
	} else if($type == 3){
		$data = [
			'type' => 'multiple',
			'answer_type' => 'multiple',
			'answer' => [rand(0,3), rand(0,3)],
			'options' => [
				'Option 1',
				'Option 2',
				'Option 3',
				'Option 4',
			]
		];
	} else if($type == 4){
		$data = [
			'type' => 'multiple',
			'answer_type' => 'all',
			'answer' => [rand(0,3), rand(0,3)],
			'options' => [
				'Option 1',
				'Option 2',
				'Option 3',
				'Option 4',
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