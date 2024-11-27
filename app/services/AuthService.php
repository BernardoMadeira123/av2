<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\TokensInvalidados;
use Carbon\Carbon;

class AuthService
{

    public function logout($token, $expDate)
    {
        // Verifique se o token já foi invalidado para evitar duplicidade
        $tokenExistente = TokensInvalidados::where('token', $token)->first();

        if ($tokenExistente) {
            return 'Este token já foi invalidado';
        }

        $tokenInvalidado = TokensInvalidados::create([
            'token' => $token,
            'data_expiracao' => $expDate,
        ]);

        return 'Token invalidado com sucesso';
    }

    public function generateOtp($email)
    {
        // Gerar um código OTP aleatório de 6 dígitos
        $otp = rand(100000, 999999);

        // Criar e salvar o OTP no banco de dados
        Otp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10), // Expira em 10 minutos
        ]);

        return $otp;
    }
}
