<?php

namespace App\Http\Controllers;

use App\Course;
use App\Enrollment;
use App\Http\Requests\CheckAnswersRequest;
use App\Http\Requests\EnrollmentRequest;
use App\Lesson;
use Illuminate\Http\Request;

/**
* @OA\Info(title="API DACODES BACKEND", version="1.0")
*
*/
class APIController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/enrollments",
     *      operationId="get_enrollments",
     *      tags={"API"},
     *      summary="Registar inscripción de alumno al curso",
     *      security={ {"passport": {}}, },
     *      description="Registar inscripción de alumno al curso",
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="course_id",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
    */
    public function enrollments(EnrollmentRequest $request)
    {
    	Enrollment::firstOrCreate($request->validated());

        return response()->json([
    		'message' => 'Student enrolled'
    	], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/courses",
     *      operationId="get_courses",
     *      tags={"API"},
     *      summary="Listar cursos",
     *      security={ {"passport": {}}, },
     *      description="Lista de cursos disponible para el alumno con indicador si está inscrito o no",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
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

    /**
     * @OA\Get(
     *      path="/api/courses/{course}",
     *      operationId="show_course",
     *      tags={"API"},
     *      summary="Obtener detalle de un curso inscrito",
     *      security={ {"passport": {}}, },
     *      description="Obtener detalle de un curso previamente inscrito, con indicador de aprobación por curso y lección",
     *      @OA\Parameter(
     *          name="course",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
    */
    public function showCourse(Request $request, $id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $id)->firstOrFail();
    	$enrollment->course;

        return response()->json([
    		'data' => $enrollment
    	], 200);
    }

    /**
     * @OA\Get(
     *      path="/api/courses/{course}/lessons/{lesson}",
     *      operationId="show_lesson",
     *      tags={"API"},
     *      summary="Obtener detalle de una lección inscrita",
     *      security={ {"passport": {}}, },
     *      description="Obtener detalle de una lección previamente inscrito",
     *      @OA\Parameter(
     *          name="course",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="lesson",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
    */
    public function showLesson(Request $request, $course_id, $lesson_id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $course_id)->firstOrFail();
    	$lesson = Lesson::where('course_id', $course_id)->where('id', $lesson_id)->firstOrFail();
    	$lesson->questions;
    	$lesson->approved = \DB::table('enrollment_lessons')->where('enrollment_id', $enrollment->id)->where('lesson_id', $lesson->id)->first() ? true : false;

        return response()->json($lesson, 200);
    }

    /**
     * @OA\Post(
     *      path="/api/courses/{course}/lessons/{lesson}",
     *      operationId="save_answers",
     *      tags={"API"},
     *      summary="Enviar las respuestas a cada pregunta de la lección",
     *      security={ {"passport": {}}, },
     *      description="Enviar las respuestas a cada pregunta de la lección",
     *      @OA\Parameter(
     *          name="course",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="lesson",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          explode=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="answers",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
                        property="answers",
                        type="array",
                        @OA\Items(type="object"),
                        example={{"question_id":"answer_value"},{"question_id":{"":{"answer_value","answer_value"}}},}
                    ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation, {approval}",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
    */
    public function saveLesson(CheckAnswersRequest $request, $course_id, $lesson_id)
    {
    	$enrollment = Enrollment::where('user_id', $request->user()->id)->where('course_id', $course_id)->firstOrFail();
    	$lesson = Lesson::where('course_id', $course_id)->where('id', $lesson_id)->firstOrFail();
    	$lesson->questions;
    	$answers = $request->answers;

        $result = 'fail';
        $code = 0;

    	$points = 0;
    	foreach ($lesson->questions as $question) {
    		$data = $question->data;
    		if($data->type == 'boolean') {
    			if($data->answer == filter_var($answers[$question->id],FILTER_VALIDATE_BOOLEAN))
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
            $code = 1;
    	}

        return response()->json([
    		'data' => $result,
            'code' => $code
    	], 200);
    }
}
