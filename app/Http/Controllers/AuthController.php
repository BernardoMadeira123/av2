<?php

namespace App\Http\Controllers;

use App\Models\Otp;
use App\Models\TokensInvalidados;
use App\Models\User;
use App\Services\AuthService;
use App\Services\JwtService;
use App\Utils\CustomEncryption;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected JwtService $jwtService;
    protected AuthService $authService;
    protected CustomEncryption $customEncryption;

    public function __construct(JwtService $jwtService, CustomEncryption $customEncryption, AuthService $authService)
    {
        $this->jwtService = $jwtService;
        $this->customEncryption = $customEncryption;
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$this->customEncryption->verify($request->senha, $user->senha)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        $token = $this->jwtService->createToken($user);

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        try {

            $token = $request->bearerToken();
            $decodedToken = $this->jwtService->validateToken($token);

            if (!$decodedToken) {
                return response()->json([
                    'error' =>  'INVALID_TOKEN',
                    'message' => 'Ocorreu um erro ao realizar ação!'
                ], 400);
            }

            $expDate = date('Y-m-d H:i:s', $decodedToken->exp);

            $response = $this->authService->logout($token, $expDate);

            return response()->json(['data' => $response], 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Ocorreu um erro ao realizar ação!'
            ], 500);
        }
    }

    public function validateToken(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $tokenExistente = TokensInvalidados::where('token', $token)->first();

        if($tokenExistente){
            return response()->json(['error' => 'Token inválido ou expirado'], 401);
        }

        $decoded = $this->jwtService->validateToken($token);

        if (!$decoded) {
            return response()->json(['error' => 'Token inválido ou expirado'], 401);
        }

        $user = User::find($decoded->sub);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        return response()->json(['message' => 'Token válido', 'user' => $user]);
    }

    public function refresh(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $authorizationHeader);

        $decoded = $this->jwtService->validateToken($token);

        $tokenExistente = TokensInvalidados::where('token', $token)->first();

        if($tokenExistente){
            return response()->json(['error' => 'Token inválido ou expirado'], 401);
        }

        if (!$decoded) {
            return response()->json(['error' => 'Token inválido ou expirado'], 401);
        }

        $user = User::find($decoded->sub);

        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $newToken = $this->jwtService->createToken($user);

        return response()->json(['message' => 'Token atualizado com sucesso', 'token' => $newToken]);
    }

}
