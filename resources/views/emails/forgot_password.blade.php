<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recuperação de Senha</title>
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

    h2 {
      color: #333;
      font-size: 24px;
    }

    p {
      font-size: 16px;
      color: #555;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #3498db;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .btn:hover {
      background-color: #2980b9;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Recuperação de Senha</h2>
    <p>Olá,</p>
    <p>Recebemos uma solicitação para redefinir sua senha. Caso não tenha feito essa solicitação, ignore este e-mail.</p>
    <p>Para redefinir sua senha, clique no link abaixo:</p>

    <a href="{{ url('reset-password/' . $token . '?email=' . $email) }}" class="btn">Redefinir Senha</a>

    <p>Este link será válido por 30 minutos. Caso o link expire, você poderá solicitar um novo.</p>
  </div>
</body>

</html>