<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Lesson;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/admin/lessons",
     *      operationId="get_admin_lesson",
     *      tags={"Admin Lessons"},
     *      summary="Listar lecciones",
     *      security={ {"passport": {}}, },
     *      description="Regresa una lista de lecciones",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\MediaType(
     *           mediaType="application/json",
     *          )
     *      ),
     *  )
    */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lesson::all();
    }

    /**
     * @OA\Post(
     *      path="/api/admin/lessons",
     *      operationId="save_admin_lesson",
     *      tags={"Admin Lessons"},
     *      summary="Alta de lección",
     *      security={ {"passport": {}}, },
     *      description="Guardar una lección",
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *            type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *            type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="course_id",
     *          in="query",
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
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
    {
        Lesson::create($request->validated());

        return response()->json([
            'message' => 'Successfully'
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/admin/lessons/{lesson}",
     *      operationId="show_admin_lesson",
     *      tags={"Admin Lessons"},
     *      summary="Obtener detalle de una lección",
     *      security={ {"passport": {}}, },
     *      description="Regresa un objeto con detalles de la lección",
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
    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        $lesson->course;
        $lesson->questions;
        return $lesson;
    }

    /**
     * @OA\PUT(
     *      path="/api/admin/lessons/{lesson}",
     *      operationId="update_admin_lesson",
     *      tags={"Admin Lessons"},
     *      summary="Actualizar Lección",
     *      security={ {"passport": {}}, },
     *      description="Actualizar valores de la lección",
     *      @OA\Parameter(
     *          name="lesson",
     *          description="ID",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *            type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="description",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *            type="string"
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
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $lesson->update($request->validated());
        
        return response()->json([
            'message' => 'Successfully'
        ], 202);
    }

    /**
     * @OA\Delete(
     *      path="/api/admin/lessons/{lesson}",
     *      operationId="delete_admin_lesson",
     *      tags={"Admin Lessons"},
     *      summary="Eliminar lección",
     *      security={ {"passport": {}}, },
     *      description="Eliminar una lección",
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }
}
