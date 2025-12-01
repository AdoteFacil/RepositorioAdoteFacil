 <?php
session_start();
require '../PHP/conexao.php';

if (!isset($_GET['token'])) {
    die("Token inválido");
}

$token = $_GET['token'];

// valida token
$sql = "SELECT id_cliente, token_expira FROM cliente WHERE token_redefinir = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    die("Token inválido.");
}

$user = $res->fetch_assoc();

// verifica validade
if (strtotime($user['token_expira']) < time()) {
    die("Token expirado. Solicite outro.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Redefinir Senha</title>
    <link rel="stylesheet" href="../CSS/padrao.css">
    <link rel="stylesheet" href="../CSS/entrar.css">
    <script src="../JS/cadastrar.js" defer></script>
    <style>
        .popup {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .popup-content {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            width: 350px;
            animation: fadein .3s ease;
        }

        .popup-content h2 {
            margin-bottom: 20px;
        }

        .popup-content button {
            padding: 10px 15px;
            background: #1E90FF;
            border: none;
            color: #fff;
            border-radius: 6px;
            cursor: pointer;
        }

        @keyframes fadein {
            from { opacity: 0; transform: scale(.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="login-container">
    <h1>Nova Senha</h1>
    <div class="linha-decorativa"></div>

    <form class="login-form" action="../PHP/Usuario/redefinirSenha.php" method="POST" onsubmit="return validar()">
        <input type="hidden" name="token" value="<?= $token ?>">

        <label for="senha">Nova Senha:</label>
        <input type="password" name="senha" id="senha" required>
        
        <label for="Csenha">Confirmar Senha:</label>
        <input type="password" name="Csenha" id="Csenha" required>

        <button class="botao" type="submit">Alterar Senha</button>
    </form>
</div>
</body>
</html>
