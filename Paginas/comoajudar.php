<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adote Fácil</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/comoajudar.css">
    <link rel="stylesheet" href="../CSS/padrao.css">
    <script src="../JS/padrao.js" defer></script>

<style>
    footer {
    background-color: var(--cinza-claro);
    border-top: 3px solid var(--cinza-medio);
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-around;
    font-family: Arial, sans-serif;
    text-align: left;
    width: 100%;
    gap: 40px;
    color: #333;
    }

    footer h2 {
        color: #4b0082;
        white-space: nowrap;
        margin-right: 70px;
    }

    .footer {
        display: flex;
        width: 1200px;
        height: 150px;
    }

    .footer-coluna {
        flex: 1 1 250px;
        margin: 5px 10px;
    }

    .footer-coluna p,
    .footer-coluna a {
        margin: 2px 0;
    }

    #cl1 {
        width: 400px;
    }

    #cl2 {
        width: 400px;
        margin-left: 10px;
    }

    #cl3 {
        width: 400px;
        margin-left: 150px;
        flex: 1 1 200px;
        display: flex;
        flex-direction: column;
        color: #4b0082;
    }

    #cl1 p {
        font-size: 14px;
    }

    /* --- LINK DISCRETO E ELEGANTE --- */
    #cl2 a {
        font-size: 16px;
        text-decoration: none;
        color: #4b0082;
        font-weight: bold;       /* Negrito para diferenciar do resto */
        border-bottom: 1px solid transparent; /* Linha invisível para não pular */
        padding-bottom: 1px;     /* Afasta um pouquinho a linha do texto */
        transition: all 0.3s ease;
    }

    /* Efeito ao passar o mouse: aparece uma linha fina */
    #cl2 a:hover {
        border-bottom: 1px solid #4b0082;
        opacity: 0.8;            /* Leve transparência */
    }
    /* -------------------------------- */

    .icons-row {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 5px;
    }

    .icons-row img {
        height: 50px;
        width: auto;
    }

    .footer-rodape {
        width: 100%;
        text-align: center;
        padding-top: 10px;
        margin-top: -20px;
        font-size: 13px;
        border-top: 1px solid #ddd;
    }
</style>

</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../index.php"><img src="../IMG/Logotipo.jpg" alt="logo_Adote_Fácil"></a>
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <div class="dropdown-content">
                    <a href="../index.php">Início</a>
                    <a href="sobre.php">Sobre Nós</a>
                    <a href="adote.php">Adote um pet</a>
                    <a href="comoajudar.php">Como ajudar</a>

                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <a href="entrar.html" id="btn-entrar" class="botao-entrar">Entrar</a>
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
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="titulo-ajuda">
            <h1>Como Ajudar</h1>
            <div class="linha-decorativa"></div>
        </section>
        <section id="ajuda">
            <h3>Doando ou divulgando, você salva vidas. Faça parte!</h3>

            <p>
                Todos os dias, animais são abandonados e ignorados. Mas com a sua ajuda, podemos mudar essas histórias. Ao doar, adotar ou divulgar, você oferece uma nova chance para um ser que só precisa de amor.
            </p>

            <h2>Formas de Ajudar</h2>

            <ul>
                <li><strong>Adoção responsável:</strong> Dar um lar a um animal muda o mundo dele para sempre.</li>
                <li><strong>Doações financeiras:</strong> Toda quantia ajuda com ração, vacinas, castração e cuidados veterinários.</li>
                <li><strong>Itens físicos:</strong> Ração, produtos de limpeza, cobertores, brinquedos e medicamentos são bem-vindos.</li>
                <li><strong>Voluntariado:</strong> Ajudar presencialmente ou com tarefas online (redes sociais, fotos, vídeos).</li>
                <li><strong>Divulgação:</strong> Compartilhe nossos pets e campanhas. Um clique pode mudar uma vida.</li>
                <li><strong>Eventos solidários:</strong> Participe de feiras de adoção, rifas e bazares beneficentes.</li>
                <li><strong>Parcerias:</strong> Empresas locais podem apoiar com serviços, produtos ou campanhas.</li>
            </ul>

            <p>
                Não importa a forma — toda ajuda importa. Com um gesto seu, uma vida pode ser transformada.
            </p>

            <section id="call-to-action">
                 <h2>Seja a mudança. Salve uma vida hoje.</h2>
            </section>
        </section>
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
                <a href="Paginas/sobre.html"><h2>Conheça a História da Peludinhos do Bem</h2></a>
                
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