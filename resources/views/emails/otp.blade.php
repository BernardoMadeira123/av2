<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Código de Verificação</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #333;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background-color: #f9f9f9;
    }

    .otp {
      font-size: 30px;
      font-weight: bold;
      color: #2c3e50;
      text-align: center;
    }

    h2 {
      color: #333;
      font-size: 24px;
    }

    p {
      font-size: 16px;
      color: #555;
    }

    .footer {
      font-size: 12px;
      color: #7f8c8d;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Seu Código de Verificação</h2>
    <p>Olá,</p>
    <p>Seu código de verificação (OTP) é:</p>
    <div class="otp">
      {{ $otp }}
    </div>
    <p>Este código é válido por 10 minutos. Não compartilhe esse código com ninguém.</p>
    <p class="footer">Se você não solicitou este código, por favor, ignore este e-mail.</p>
  </div>
</body>

</html>