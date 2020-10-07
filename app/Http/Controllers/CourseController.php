<?php

namespace App\Http\Controllers;

use App\Course;
use App\Http\Requests\CourseRequest;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/admin/courses",
     *      operationId="get_admin_course",
     *      tags={"Admin Courses"},
     *      summary="Listar cursos",
     *      security={ {"passport": {}}, },
     *      description="Regresa una lista de cursos",
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
        return Course::all();
    }

    /**
     * @OA\Post(
     *      path="/api/admin/courses",
     *      operationId="save_admin_course",
     *      tags={"Admin Courses"},
     *      summary="Alta de Curso",
     *      security={ {"passport": {}}, },
     *      description="Guardar un curso",
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        Course::create($request->validated());

        return response()->json([
            'message' => 'Successfully'
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/admin/courses/{course}",
     *      operationId="show_admin_course",
     *      tags={"Admin Courses"},
     *      summary="Obtener detalle de un curso",
     *      security={ {"passport": {}}, },
     *      description="Regresa un objeto con detalles del curso",
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        $course->lessons;
        return $course;
    }

    /**
     * @OA\PUT(
     *      path="/api/admin/courses/{course}",
     *      operationId="update_admin_course",
     *      tags={"Admin Courses"},
     *      summary="Actualizar Curso",
     *      security={ {"passport": {}}, },
     *      description="Actualizar valores de curso",
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseRequest $request, Course $course)
    {
        $course->update($request->validated());
        
        return response()->json([
            'message' => 'Successfully'
        ], 202);
    }

    /**
     * @OA\Delete(
     *      path="/api/admin/courses/{course}",
     *      operationId="delete_admin_course",
     *      tags={"Admin Courses"},
     *      summary="Eliminar Curso",
     *      security={ {"passport": {}}, },
     *      description="Eliminar un curso",
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }
}
