<?php

use App\Course;
use App\Enrollment;
use App\Item;
use App\Lesson;
use App\User;
use Illuminate\Database\Seeder;

class GlobalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Course::class, 8)->create();
		factory(Lesson::class, 24)->create()->each(function ($lesson) {
        	factory(Item::class, rand(1,5))->create([
        		'lesson_id' => $lesson->id
        	]);
		});

        $student = User::firstOrCreate(['email'=>'student@mail.com'], [
            'name' => 'Student',
            'password' => bcrypt('1234567890'),
            'type' => 'student',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $professor = User::firstOrCreate(['email'=>'professor@mail.com'], [
            'name' => 'Professor',
            'password' => bcrypt('1234567890'),
            'type' => 'professor',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $course = Course::inRandomOrder()->first();
        Enrollment::firstOrCreate([
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);
    }
}
