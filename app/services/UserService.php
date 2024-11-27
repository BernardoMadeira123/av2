<?php

namespace App\Services;

use App\Mail\ForgotPasswordEmail;
use App\Mail\OtpEmail;
use App\Models\Otp;
use App\Models\User;
use App\Utils\CustomEncryption;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\Validator;


class UserService
{

    private CustomEncryption $customEncryption;
    private AuthService $authService;

    public function __construct(CustomEncryption $customEncryption, AuthService $authService)
    {
        $this->customEncryption = $customEncryption;
        $this->authService = $authService;
    }

    public function getAllUsers()
    {
        return User::paginate(10);
    }

    public function getUserById($id)
    {
        $usuario = User::findOrFail($id);
        return $usuario;
    }

    public function createUser(array $data)
    {
        $this->validateUserData($data);

        $data['senha'] = $this->customEncryption->encrypt($data['senha']);
        $user = User::create($data);

        $this->sendOtpMail($user->email);

        return $user;
    }

    public function updateUser($id, array $data)
    {
        $usuario = User::findOrFail($id);

        $this->validateUserData($data, $id);

        if (isset($data['senha'])) {
            $data['senha'] = Hash::make($data['senha']);
        }

        $usuario->update($data);
        return $usuario;
    }

    public function deleteUser($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();
    }

    private function validateUserData(array $data, $id = null)
    {
        $rules = [
            'nome' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:usuarios,email' . ($id ? ",$id" : ''),
            'senha' => 'sometimes|required|string|min:6',
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    private function sendOtpMail($email)
    {
        try {
            $otp = $this->authService->generateOtp($email);
            Mail::to('bernardompsbrito@gmail.com')->send(new OtpEmail($otp));
            return $otp;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function verifyOtp($email, $otp)
    {
        // Buscar o OTP gerado para o e-mail fornecido
        $otpRecord = Otp::where('email', $email)
            // ->where('otp', $otp)
            ->first();

        // Verifica se o OTP foi encontrado
        if (!$otpRecord) {
            return false;
        }

        // Verifica se o OTP expirou
        if (Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return false;
        }

        return true;
    }

    public function sendResetPasswordLink($email)
    {

        $user = User::where('email', $email)->first();

        // Se o usuário não existir
        if (!$user) {
            return [
                'success' => false,
                'message' => 'USER_NOT_FOUND'
            ];
        }

        // Gerar o token de recuperação
        $token = Str::random(60);

        // Enviar o e-mail com o token
        Mail::to($user->email)->send(new ForgotPasswordEmail($token, 'bernardompsbrito@gmail.com'));

        return [
            'success' => true,
            'message' => 'Email enviado com sucess!'
        ];
    }

    public function  resetPassword($email, $token, $newPassword)
    {

        $user = User::where('email', $email)->first();

        // Se o usuário não existir
        if (!$user) {
            return [
                'success' => false,
                'message' => 'USER_NOT_FOUND'
            ];
        }

        //TODO: Verificar se o token é valido
        $user->password = $this->customEncryption->encrypt($newPassword);

        return [
            'success' => true,
            'message' => 'Senha alterada com sucesso!'
        ];
    }
}
