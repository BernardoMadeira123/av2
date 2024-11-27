<?php

namespace App\Http\Controllers;

use App\Mail\OtpEmail;
use App\Services\AuthService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json($this->userService->getAllUsers(), 200);
    }

    public function show($id)
    {
        try {
            $usuario = $this->userService->getUserById($id);
            return response()->json($usuario, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'senha' => 'required|min:8|confirmed',
            ]);

            // Se a validação passar, cria o usuário
            $usuario = $this->userService->createUser($validatedData);

            return response()->json($usuario, 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'errors' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $usuario = $this->userService->updateUser($id, $request->all());
            return response()->json($usuario, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            $this->userService->deleteUser($id);
            return response()->json(['message' => 'Usuário deletado com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function verify(Request $request)
    {

        $response = $this->userService->verifyOtp($request->email, $request->otp);

        if ($response) {
            // $this->userService->validateUser($emai); TODO: confirmar
            return response()->json(['message' => 'Usuário validado com sucesso'], 200);
        } else {
            return response()->json(['message' => 'OTP inválido']);
        }
    }

    public function forgotPassword(Request $request)
    {

        $response = $this->userService->sendResetPasswordLink($request->email);

        if ($response['success']) {
            return response()->json(['message' => $response['message']], 200);
        } else {
            return response()->json(['message' => $response['message']], 500);
        }
    }

    public function resetPassword(Request $req)
    {
        $response = $this->userService->resetPassword($req->email, $req->token, $req->nova_senha);
        if ($response['success']) {
            return response()->json(['message' => $response['message']], 200);
        } else {
            return response()->json(['message' => $response['message']], 500);
        }
    }
}
