<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function(){
	Route::post('register', 'AuthController@register');
	Route::post('login', 'AuthController@login');

	Route::middleware('auth:api')->group(function (){
		Route::get('logout', 'AuthController@logout');
		Route::post('user', function (Request $request) {
			return $request->user();
		});
	});
});

Route::middleware('auth:api')->group(function(){
	Route::prefix('admin')->middleware('professors')->group(function(){
		Route::resource('courses', 'CourseController');
		Route::resource('lessons', 'LessonController');
		Route::resource('questions', 'QuestionController');
	});
	Route::post('enrollments', 'APIController@enrollments');

	Route::get('courses', 'APIController@courses');
	Route::get('courses/{course}', 'APIController@showCourse');
	Route::get('courses/{course}/lessons/{lesson}', 'APIController@showLesson');
	Route::post('courses/{course}/lessons/{lesson}', 'APIController@saveLesson');
});
