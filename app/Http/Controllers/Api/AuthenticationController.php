<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    /**
     * Use This Method To Create Account Users.
     *
     * @OA\Post (
     * path="/api/create-account",
     * summary="Register",
     * description="Create Account",
     * operationId="register",
     * tags={"UnAuthentication"},
     * security={{ "Bearer":{} }},
     * @OA\RequestBody(
     *    @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *      @OA\Schema(
     *           @OA\Property(property="name", type="string", example="User Name"),
     *           @OA\Property(property="password", type="string", example="123456"),
     *           @OA\Property(property="password_confirmation", type="string", example="123456"),
     *      ),
     *    ),
     *    @OA\JsonContent(
     *      @OA\Property(property="name", type="string", example="User Name"),
     *      @OA\Property(property="password", type="string", example="123456"),
     *      @OA\Property(property="password_confirmation", type="string", example="123456"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Created Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="token_type", type="string", example="Bearer"),
     *       @OA\Property(property="access_token", type="string", example="1|IEZCKtmWumSlvrhpn6HiyyWoxpShI3DHd8nAlv6q"),
     *       @OA\Property(property="message", type="string", example="User Created Successfully")
     *    )
     * )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createAccount(Request $request): JsonResponse
    {
        $attr = $request->validate([
            'name' => 'required|string|unique:parents|max:255',
            'password' => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => Hash::make($attr['password']),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User Created Successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * Use This Method To Signin Users.
     *
     * @OA\Post (
     * path="/api/signin",
     * summary="Login",
     * description="Signin Account",
     * operationId="signin",
     * tags={"UnAuthentication"},
     * security={{ "Bearer":{} }},
     * @OA\RequestBody(
     *    @OA\MediaType(mediaType="application/x-www-form-urlencoded",
     *      @OA\Schema(
     *           @OA\Property(property="name", type="string", example="User Name"),
     *           @OA\Property(property="password", type="string", example="123456")
     *      ),
     *    ),
     *    @OA\JsonContent(
     *      @OA\Property(property="name", type="string", example="User Name"),
     *      @OA\Property(property="password", type="string", example="123456")
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="User Login Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="token_type", type="string", example="Bearer"),
     *       @OA\Property(property="access_token", type="string", example="1|IEZCKtmWumSlvrhpn6HiyyWoxpShI3DHd8nAlv6q"),
     *       @OA\Property(property="message", type="string", example="User Login Successfully")
     *    )
     * )
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(Request $request): JsonResponse
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6'
        ]);

        if (!\Auth::attempt($attr)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login details'
            ], 401);
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success' => true,
            'message' => 'User Login Successfully',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    /**
     * use this method to signs out users by removing tokens
     *
     * @OA\Post (
     * path="/api/sign-out",
     * summary="Logout",
     * description="use this method to signs out users by removing tokens",
     * operationId="sign-out",
     * tags={"Authentication"},
     * security={{ "Bearer":{} }},
     * @OA\Response(
     *    response=200,
     *    description="Tokens Revoked",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Tokens Revoked"),
     *    )
     * )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tokens Revoked'
        ]);
    }


    /**
     * use this method to get user's details
     *
     * @OA\Get (
     * path="/api/me",
     * summary="use this method to get user's details",
     * description="use this method to get user's details",
     * operationId="me",
     * tags={"Authentication"},
     * security={{ "Bearer":{} }},
     * @OA\Response(
     *    response=200,
     *    description="Data Loaded Successfully",
     *    @OA\JsonContent(
     *       @OA\Property(property="success", type="boolean", example=true),
     *       @OA\Property(property="message", type="string", example="Data loaded Successfully"),
     *       @OA\Property(property="data", type="object",
     *              @OA\Property(property="id", type="number", example="1"),
     *              @OA\Property(property="name", type="string", example="Partner's Name"),
     *       )
     *    )
     * )
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Data Loaded Successfully',
            'data' => auth()->user()
        ]);
    }
}
