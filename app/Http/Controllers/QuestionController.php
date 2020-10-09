<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Item;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/admin/questions",
     *      operationId="get_admin_question",
     *      tags={"Admin Questions"},
     *      summary="Listar Preguntas",
     *      security={ {"passport": {}}, },
     *      description="Regresa una lista de preguntas",
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
        return Item::question()->get();
    }

    /**
     * @OA\Post(
     *      path="/api/admin/questions",
     *      operationId="save_admin_question",
     *      tags={"Admin Questions"},
     *      summary="Alta de una pregunta",
     *      security={ {"passport": {}}, },
     *      description="Guardar una pregunta",
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
     *          name="value",
     *          in="query",
     *          required=false,
     *          description="Puntos al responder correctamente",
     *          @OA\Schema(
     *            type="int"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="lesson_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *            type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data",
     *          in="query",
     *          required=true,
     *          description="Json con las opciones de la pregunta (type: multiple,boolean, answer: clave o valor)",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="type", type="string", enum={"multiple", "boolean"}),
     *              @OA\Property(property="answer_type", type="string", enum={"single", "multiple", "all"}),
     *              @OA\Property(property="answer", type="string", example=0),
     *              @OA\Property(property="options", type="string", example={"opcion1","opcion2","opcion3"}),
     *          )
     *      ),
     *      @OA\Parameter(
     *         name="type",
     *         in="query",
     *         required=true,
     *         @OA\Schema(
     *              type="string",
     *              enum={"question", "supplement"}
     *         )
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
    public function store(QuestionRequest $request)
    {
        Item::create($request->validated() + ['type'=>'question']);

        return response()->json([
            'message' => 'Successfully'
        ], 201);
    }

    /**
     * @OA\Get(
     *      path="/api/admin/questions/{id}",
     *      operationId="show_admin_question",
     *      tags={"Admin Questions"},
     *      summary="Obtener detalle de una pregunta",
     *      security={ {"passport": {}}, },
     *      description="Regresa un objeto con detalles de una pregunta",
     *      @OA\Parameter(
     *          name="id",
     *          description="question",
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
    public function show($id)
    {
        return Item::findOrFail($id);
    }

    /**
     * @OA\Put(
     *      path="/api/admin/questions/{id}",
     *      operationId="update_admin_question",
     *      tags={"Admin Questions"},
     *      summary="Actualizar una pregunta",
     *      security={ {"passport": {}}, },
     *      description="Actualizar una pregunta",
     *      @OA\Parameter(
     *          name="id",
     *          description="question",
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
     *      @OA\Parameter(
     *          name="value",
     *          in="query",
     *          required=false,
     *          description="Puntos al responder correctamente",
     *          @OA\Schema(
     *            type="int"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="data",
     *          in="query",
     *          required=true,
     *          description="Json con las opciones de la pregunta (type: multiple,boolean, answer: clave o valor)",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="type", type="string", enum={"boolean", "multiple"}),
     *              @OA\Property(property="answer_type", type="string", enum={"single", "multiple", "all"}),
     *              @OA\Property(property="answer", type="string", example=false)
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
    public function update(QuestionRequest $request, $id)
    {
        $item = Item::where('id', $id)->where('type','question')->firstOrFail();
        $item->update($request->validated());

        return response()->json([
            'message' => 'Successfully'
        ], 202);
    }

    /**
     * @OA\Delete(
     *      path="/api/admin/questions/{question}",
     *      operationId="delete_admin_question",
     *      tags={"Admin Questions"},
     *      summary="Eliminar pregunta",
     *      security={ {"passport": {}}, },
     *      description="Eliminar una pregunta",
     *      @OA\Parameter(
     *          name="question",
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
    public function destroy($id)
    {
        $item = Item::where('id',$id)->where('type','question')->firstOrFail();
        $item->delete();

        return response()->json([
            'message' => 'Successfully'
        ], 200);
    }
}
