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
    <link rel="icon" href="../IMG/icones/favicon.png" type="image/x-icon">
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
<header> 
            <nav class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../IMG/LogoTransparente.png" alt="logo_Adote_Fácil"></a>
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <ul class="dropdown-content">
                    <li class="li-dropdown linkIndex"><a href="../index.php">Início</a></li>
                    <li class="li-dropdown linkSobre"><a href="sobre.php">Sobre Nós</a></li>
                    <li class="li-dropdown linkAdote"><a href="adote.php">Adote um pet</a></li>
                    <li class="li-dropdown linkCajudar"><a href="comoajudar.php">Como ajudar</a></li>
                    <?php 
                    if (
                        isset($_SESSION['usuario_email'], $_SESSION['usuario_id']) &&
                        $_SESSION['usuario_email'] === "admadote@gmail.com" &&
                        $_SESSION['usuario_id'] == 1   // <-- coloque o ID correto aqui
                    ): ?>
                        <li class="li-dropdown "><a href="../PHP/ADM/Usuario/consulta.php">adm</a></li>
                    <?php endif; ?>


                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class=" li-dropdown "><a href="entrar.php" id="btn-entrar" class="botao-entrar active">Entrar</a></li>
                    <?php else: ?>
                        <div class="usuario-box" id="userMenu">
                            <img src="../IMG/usuario/<?php echo $_SESSION['usuario_foto']; ?>" 
                                class="foto-perfil" alt="Foto">

                            <div class="dropdown-user">
                                <span class="nome-dropdown">
                                    <?php echo explode(" ", $_SESSION['usuario_nome'])[0]; ?>
                                </span>

                                <a href="../PHP/Usuario/perfil.php">Perfil</a>
                                <a href="../PHP/Usuario/logout.php">Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
</header>
<main>
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
</main>

    <footer>
        <section class="footer">
            <div class="footer-coluna" id="cl1">
                <h2>Peludinhos do bem</h2>
                <p>08989-8989898</p>
                <p>Rua Santa Helena, 21, Parque Alvorada,<br> Imperatriz-MA, CEP 65919-505</p>
                <p>adotefacil@peludinhosdobem.org</p>
            </div>

            <div class="footer-coluna" id="cl2">
                <a href="sobre.php"><h2>Conheça a História da Peludinhos do Bem</h2></a>
                
            </div>

            <div class="footer-coluna" id="cl3">
                <h2>Contatos</h2>

                <div class="icons-row">
                    <a href="https://www.instagram.com/">
                    <img src="../IMG/index/insta.png" alt="Instagram">
                    </a>

                    <a href="https://web.whatsapp.com/">
                    <img src="../IMG/index/—Pngtree—whatsapp icon whatsapp logo whatsapp_3584845.png" alt="Whatsapp">
                    </a>
                </div>
            </div>
        </section>

        <div class="footer-rodape">
            <p>Desenvolvido pela Turma-20 Tecnico de Informatica para Internet (Peludinhos do Bem). 2025 &copy;Todos os direitos reservados.</p>
        </div>
    </footer>
</body>
</html>
