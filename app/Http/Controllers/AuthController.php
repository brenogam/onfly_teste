<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //Função para autenticação da Api
    public function auth(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Credenciais inválidas. Verifique o email e a senha.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível gerar o token. Tente novamente.'], 500);
        }

        return response()->json(['mensagem' => 'Autenticação realizada com sucesso!', 'token' => $token]);
    }
}
