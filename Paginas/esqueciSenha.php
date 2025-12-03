<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="../CSS/padrao.css">
    <link rel="stylesheet" href="../CSS/entrar.css">
    
    <style>
        .modal-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,.4);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
        }

        .modal-box {
        background: #fff;
        padding: 20px 30px;
        border-radius: 10px;
        text-align: center;
        max-width: 350px;
        font-family: sans-serif;
        }
        .modal-box h3 {
        color: #222;
        }
        .modal-box button {
        margin-top: 15px;
        padding: 8px 16px;
        border: none;
        background: #1385ff;
        color: #fff;
        cursor: pointer;
        border-radius: 6px;
        }
        .login-container {
            max-height: 410px;
            margin-top: 200px;
        }
        .login-form button.botao {
  background-color: #33414d;
        }
        .login-form input:focus {
  border-color: #355c7d;
        }
        .login-container h1 {
          color: #7b909c;
        }
        .login-container {
          background-color: #eaf9ef;
        }
        .linha-decorativa{
            background-color: #2d3242;
        }
        body {
            background: #368659;
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="index.php"><img src="../IMG/LogoAdote2.png" alt="logo_Adote_Fácil"></a>
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <ul class="dropdown-content">
                    <li class="li-dropdown "><a href="../index.php" class="linkIndex">Início</a></li>
                    <li class="li-dropdown "><a href="sobre.php" class="linkSobre">Sobre Nós</a></li>
                    <li class="li-dropdown "><a href="adote.php" class="linkAdote">Adote um pet</a></li>
                    <li class="li-dropdown "><a href="comoajudar.php" class="linkCajudar active">Como ajudar</a></li>
                    <?php 
                    if (
                        isset($_SESSION['usuario_email'], $_SESSION['usuario_id']) &&
                        $_SESSION['usuario_email'] === "admadote@gmail.com" &&
                        $_SESSION['usuario_id'] == 1   // <-- coloque o ID correto aqui
                    ): ?>
                        <li class="li-dropdown "><a href="../PHP/ADM/Usuario/consulta.php">adm</a></li>
                    <?php endif; ?>


                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class=" li-dropdown "><a href="entrar.php" id="btn-entrar" class="botao-entrar">Entrar</a></li>
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

<div class="login-container">
    <h1>Recuperar Senha</h1>
    <div class="linha-decorativa"></div>

    <form class="login-form" method="POST" id="formRecuperar">
        <label for="email">Digite seu e-mail cadastrado:</label>
        <input type="email" id="email" name="email" required placeholder="Seu e-mail">
        <button class="botao" type="submit">Enviar link de recuperação</button>
    </form>

    <div class="cadastro-link">
        <a href="entrar.php">Voltar</a>
    </div>
</div>

<div id="popup" style="display:none;
position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div style="background:#fff;padding:20px;border-radius:10px;text-align:center;">
        <p id="popupMsg"></p>
        <button onclick="fecharPopup()">Ok</button>
    </div>
</div>

<script>
function abrirPopup(msg){
    document.getElementById("popupMsg").innerText = msg;
    document.getElementById("popup").style.display = "flex";
}

function fecharPopup(){
    document.getElementById("popup").style.display = "none";
}

const form = document.getElementById("formRecuperar");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const dados = new FormData(form);

    const req = await fetch("../PHP/Usuario/enviarEmailSenha.php", {
        method: "POST",
        body: dados
    });

    const resp = await req.text();

    if (resp === "ok") abrirPopup("Um link foi enviado ao seu email 📩");
    else if (resp === "notfound") abrirPopup("Esse e-mail não está cadastrado ❗");
    else abrirPopup("Erro ao enviar o e-mail 😕");
});
</script>
</body>
</html>
