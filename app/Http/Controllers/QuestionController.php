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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        dd($request->all());
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
    public function show($id)
    {
        return Item::findOrFail($id);
    }

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
