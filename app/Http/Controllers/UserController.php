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
            'email' => ['required', 'email', 'max:255', 'unique:App\Models\User,email'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Les données fournies sont invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::create([
            'firstname' => $request['name'], // la table users n'a pas de colonne name
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
            'token' => $user->createToken($request->input('device_name', 'mobile'))->plainTextToken,
        ]);
    }

    /**
     * @OA\Get(
     *      path="/api/v1/me",
     *      tags={"Auth"},
     *      summary="Récupérer l'utilisateur connecté (token Bearer requis)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Utilisateur récupéré avec succès"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function me(Request $request)
    {
        // On renvoie toujours l'utilisateur du token : plus de `user_id` passé
        // par le client, qui permettait de lire n'importe quel compte.
        return new UserResource($request->user());
    }

    /**
     * @OA\Post(
     *      path="/api/v1/logout",
     *      tags={"Auth"},
     *      summary="Déconnexion : révoque le token courant (token Bearer requis)",
     *      security={{"sanctum":{}}},
     *      @OA\Response(response=200, description="Déconnecté avec succès"),
     *      @OA\Response(response=401, description="Unauthenticated")
     * )
     */
    public function logout(Request $request)
    {
        $token = $request->user()?->currentAccessToken();

        if ($token instanceof PersonalAccessToken) {
            // Client mobile / SPA par token : on révoque le token de cet appareil
            $token->delete();
        } else {
            // Session web (cookie Sanctum) : on ferme la session
            Auth::guard('web')->logout();

            if ($request->hasSession()) {
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }
        }

        return ResponseController::response(true, 'Déconnecté avec succès', []);
    }


}
