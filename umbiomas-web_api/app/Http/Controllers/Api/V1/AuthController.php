<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Administrador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(['login' => 'required', 'senha' => 'required']);

        $admin = Administrador::where('login', $request->login)->first();

        if (! $admin || !Hash::check($request->senha, $admin->senha)) {
            throw ValidationException::withMessages([
                'login' => ['As Credenciais fornecidas estão incorretas.']
            ]);
        }

        $token = $admin->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
