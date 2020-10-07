<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/auth/register",
     *   tags={"Auth"},
     *   summary="Register",
     *   operationId="register",
     *
     *  @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string",
     *           enum={"student", "professor"}
     *      )
     *   ),
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/
    public function register(UserRegisterRequest $request)
    {
        $params = $request->validated();
        $params['password'] = bcrypt($params['password']);
        User::create($params);

        return response()->json([
            'message' => 'Successfully'
        ], 201);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="remember_me",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="boolean"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function login(Request $request)
    {
        if (!Auth::attempt(request(['email', 'password'])))
            return response()->json(['message' => 'Unauthorized'], 401);

        $user = $request->user();
        $tokenResult = $user->createToken('Access Token');

        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);

        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ])->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @OA\GET(
     ** path="/api/auth/logout",
     *   tags={"Auth"},
     *   summary="Logout",
     *   operationId="logout",
     *   security={ {"passport": {}} },
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *)
     **/
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully'
        ]);
    }

}
