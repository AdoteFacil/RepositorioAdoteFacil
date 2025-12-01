<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../CSS/padrao.css">
    <link rel="stylesheet" href="../CSS/entrar.css">
</head>
<body>

<div class="login-container">
    <h1>Recuperar Senha</h1>
    <div class="linha-decorativa"></div>

    <form class="login-form" action="../PHP/Usuario/enviarEmailSenha.php" method="POST">
        <label for="email">Digite seu e-mail cadastrado:</label>
        <input type="email" id="email" name="email" required placeholder="Seu e-mail">
        <button class="botao" type="submit">Enviar link de recuperação</button>
    </form>

    <div class="cadastro-link">
        <a href="entrar.php">Voltar</a>
    </div>
</div>

</body>
</html>
