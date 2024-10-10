<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(title="API Gestion Financière", version="1.0")
 */
class UserController extends Controller
{

 /**
     * @OA\Post(
     *     path="/api/register",
     *     summary="Enregistrer un nouvel utilisateur",
     *     tags={"Utilisateur"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email","password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="User created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     )
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'User created successfully']);
    }

     /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Connexion d'un utilisateur",
     *     tags={"Utilisateur"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Connexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="1|abc123def456ghi789")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Identifiant faux'],
            ]);
        }

        $token = $user->createToken('auth-token')->plainTextToken;
        $id = $user->id;

        return response()->json(['token' => $token, 'id' => $id]);
    }

     /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Déconnexion d'un utilisateur",
     *     tags={"Utilisateur"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Déconnexion")
     *         )
     *     )
     * )
     */
    public function logout()
    {

        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnexion']);
    }
}
