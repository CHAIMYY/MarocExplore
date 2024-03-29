<?php

namespace App\Http\Controllers;

/**
 
* @OA\OpenApi(
* @OA\Info(
* title="User API",
* version="1.0.0",
* description="API for managing users",
* @OA\Contact(
* email="houas.chaimaa@gmail.com"
* ),
* @OA\License(
* name="HOUAS Chaimaa",
* url="https://opensource.org/licenses/MIT"
* )
* )
* )
*/

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

   
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','logout']]);
    }

    /**
 * Register a new user.
 *
 * @OA\Post(
 *     path="/api/register",
 *     summary="Register a new user",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User registration details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "email", "password"},
 *                 @OA\Property(
 *                     property="name",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User registered successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="User created successfully"
 *             ),
 *             @OA\Property(
 *                 property="user",
 *                 type="object",
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     description="Name of the registered user"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     description="Email of the registered user"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="authorisation",
 *                 type="object",
 *                 @OA\Property(
 *                     property="token",
 *                     type="string",
 *                     description="Access token for the registered user"
 *                 ),
 *                 @OA\Property(
 *                     property="type",
 *                     type="string",
 *                     example="bearer",
 *                     description="Type of token"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Validation error",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="The given data was invalid."
 *             ),
 *             @OA\Property(
 *                 property="errors",
 *                 type="object",
 *                 description="Validation errors",
 *                 example={
 *                     "email": {"The email field is required."},
 *                     "password": {"The password field is required."},
 *                     "name": {"The name field is required."}
 *                 }
 *             )
 *         )
 *     )
 * )
 */

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::guard('api')->login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }



/**
 * Authenticate user.
 *
 * @OA\Post(
 *     path="/api/login",
 *     summary="Authenticate user",
 *     tags={"Authentication"},
 *     @OA\RequestBody(
 *         required=true,
 *         description="User login details",
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"email", "password"},
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email"
 *                 ),
 *                 @OA\Property(
 *                     property="password",
 *                     type="string"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="User authenticated successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="user",
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                     description="ID of the authenticated user"
 *                 ),
 *                 @OA\Property(
 *                     property="name",
 *                     type="string",
 *                     description="Name of the authenticated user"
 *                 ),
 *                 @OA\Property(
 *                     property="email",
 *                     type="string",
 *                     format="email",
 *                     description="Email of the authenticated user"
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="authorisation",
 *                 type="object",
 *                 @OA\Property(
 *                     property="token",
 *                     type="string",
 *                     description="Access token for the authenticated user"
 *                 ),
 *                 @OA\Property(
 *                     property="type",
 *                     type="string",
 *                     example="bearer",
 *                     description="Type of token"
 *                 )
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="Unauthorized",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="error"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Unauthorized"
 *             )
 *         )
 *     )
 * )
 */


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);

    }


    /**
 * Logout user.
 *
 * @OA\Post(
 *     path="/api/logout",
 *     summary="Logout user",
 *     tags={"Authentication"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="User logged out successfully",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                 property="status",
 *                 type="string",
 *                 example="success"
 *             ),
 *             @OA\Property(
 *                 property="message",
 *                 type="string",
 *                 example="Successfully logged out"
 *             )
 *         )
 *     )
 * )
 */
    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

}
