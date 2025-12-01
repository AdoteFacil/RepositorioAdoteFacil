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
    </style>
</head>
<body>

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
