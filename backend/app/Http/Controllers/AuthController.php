<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Login do usuário
     */
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $token = $user->createToken('auth-token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Login realizado com sucesso!'
        ]);
    }

    /**
     * Logout do usuário
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout realizado com sucesso!'
        ]);
    }

    /**
     * Obter usuário autenticado
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    /**
     * Registrar novo usuário
     */
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth-token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Usuário registrado com sucesso!'
        ], 201);
    }

    /**
     * Refresh token
     */
    public function refresh(Request $request)
    {
        $user = $request->user();
        $user->token()->revoke();
        
        $token = $user->createToken('auth-token')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $request->user()->token()->accessToken,
            'message' => 'Token renovado com sucesso!'
        ]);
    }
}
