<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class AuthController extends Controller
{
    /**
     * Retorna um token de acordo com as credenciais (email e senha).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request([ 'email', 'password' ]);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([ 'message' => 'Usuário ou senha inválida.' ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Retorna o usuário autenticado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        try {
            $user = auth()->user();
            return response()->json([ 'data' => $user ]);
        } catch (Exception $ex) {
            return response()->json([ 'message' => 'Acesso não autorizado.' ], 403);
        }
    }

    /**
     * Desloga o usuário logado.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return response()->json([ 'message' => 'Usuário deslogado com sucesso' ]);
        } catch (Exception $ex) {
            return response()->json([ 'message' => 'Acesso não autorizado.' ], 403);
        }
    }

    /**
     * Atualiza o token, caso esteja dentro do tempo limite estabelecido nas configurações (5 mins).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(auth()->refresh());
        } catch (Exception $ex) {
            return response()->json([ 'message' => 'Acesso não autorizado.' ], 403);
        }
    }

    /**
     * Retorna um array contendo o token e o tempo para expiração (em segundos).
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'expires_in_seconds' => auth()->factory()->getTTL() * 60
        ]);
    }
}
