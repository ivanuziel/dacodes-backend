<?php

namespace App\Http\Controllers;

use App\Course;
use App\Enrollment;
use App\Http\Requests\EnrollmentRequest;
use App\Lesson;
use Illuminate\Http\Request;

/**
* @OA\Info(title="API DACODES BACKEND", version="1.0")
*
*/
class APIController extends Controller
{
    public function enrollments(EnrollmentRequest $request)
    {
    	Enrollment::firstOrCreate($request->validated());

        return response()->json([
    		'message' => 'Student enrolled'
    	], 200);
    }

    /**
    * @OA\Get(
    *     path="/api/courses",
    *     summary="Listar todos los cursos disponibles para el estudiante",
    *	  security={
    *     {"passport": {}},
    *     },
    *     @OA\Response(
    *         response=200,
    *         description="Collección de cursos"
    *     )
    * )
    */

    public function courses()
    {
    	$userCourses = request()->user()->courses;
    	$listCourses = [];
    	foreach (Course::all() as $course) {
    		$course->enrolled = $userCourses->where('id', $course->id)->count() ? true:false;
    		$listCourses[] = $course;
    	}

        return response()->json([
    		'data' => $listCourses
    	], 200);
    }

    public function showCourse(Request $request, $id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $id)->firstOrFail();
    	$enrollment->course;

        return response()->json([
    		'data' => $enrollment
    	], 200);
    }

    public function showLesson(Request $request, $course_id, $lesson_id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $course_id)->firstOrFail();
    	$lesson = Lesson::where('course_id', $course_id)->where('id', $lesson_id)->firstOrFail();
    	$lesson->questions;
    	$lesson->approved = \DB::table('enrollment_lessons')->where('enrollment_id', $enrollment->id)->where('lesson_id', $lesson->id)->first() ? true : false;

        return response()->json([
    		'data' => $lesson
    	], 200);
    }

    public function saveLesson(Request $request, $course_id, $lesson_id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $course_id)->firstOrFail();
    	$lesson = Lesson::where('course_id', $course_id)->where('id', $lesson_id)->firstOrFail();
    	$lesson->questions;
    	$answers = $request->answers;

    	$points = 0;
    	foreach ($lesson->questions as $question) {
    		$data = $question->data;
    		if($data->type == 'boolean') {
    			if($data->answer == $answers[$question->id])
    				$points += $question->value;
    		} else if($data->type == 'multiple') {
    			if($data->answer_type == 'single' && $data->answer == $answers[$question->id])
    				$points += $question->value;
    			if($data->answer_type == 'multiple' && in_array($answers[$question->id], $data->answer))
    				$points += $question->value;
    			if($data->answer_type == 'all' && !array_diff(array_merge($data->answer, $answers[$question->id]), array_intersect($data->answer, $answers[$question->id])))
    				$points += $question->value;
    		}
    	}
    	if($points >= $lesson->approval_min){
    		\DB::table('enrollment_lessons')->insert(
    			[
    				'approved' => 1,
    				'enrollment_id' => $enrollment->id,
    				'lesson_id' => $lesson->id
    			]
    		);
    		$result = 'approved';
    	}

        return response()->json([
    		'data' => $result
    	], 200);
    }
}
