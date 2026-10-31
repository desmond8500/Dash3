<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\PersonalAccessToken;

class UserController extends Controller
{
    /**
     * @OA\Post(
     *      path="/api/v1/register",
     *      tags={"Auth",},
     *      summary="S'inscrire",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="name", type="string", example="name1"),
     *                  @OA\Property(property="email", type="string", example="name1@mail.com", format="email"),
     *                  @OA\Property(property="password", type="string", format="password", example="passer1234"),
     *                  required={"name"}
     *             ),
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateur créé avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'unique:App\Models\User,email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        $data = array(
            'user' => new UserResource($user) ,
            'token' => $user->createToken($request->input('device_name', 'mobile'))->plainTextToken,
        );

        return ResponseController::response(true, 'Inscription réussie', $data);
    }

    /**
     * @OA\Post(
     *      path="/api/v1/login",
     *      tags={"Auth",},
     *      summary="Connexion",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="email", type="string", example="name1@mail.com", format="email"),
     *                  @OA\Property(property="password", type="string", format="password", example="passer1234"),
     *                  required={"email", "password"}
     *             ),
     *         )
     *      ),
     *      @OA\Response(response=200, description="Utilisateur récupéré avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('email', $request['email'])->first();

        if (! $user || ! Hash::check($request['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        return response()->json([
            'user' => new UserResource($user),
            'token' => $user->createToken($data['device_name'] ?? 'mobile')->plainTextToken,
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      tags={"Auth"},
     *      summary="Deconnexion",
     *
     *      @OA\RequestBody(
     *          required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                  @OA\Property(property="user_id", type="int", example="1"),
     *                  required={"user_id"}
     *             )
     *         )
     *      ),
     *      @OA\Response(response=200, description="Déconnecté avec succès"),
     *      @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::find($request['user_id']);
        $token = $user?->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            // Ionic : on révoque uniquement le token de cet appareil
            $token->delete();
        } else {
            // Web : on ferme la session
            Auth::guard('web')->logout();

            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        }

        return ResponseController::response(true, 'Déconnecté avec succès', []);

    }


}
