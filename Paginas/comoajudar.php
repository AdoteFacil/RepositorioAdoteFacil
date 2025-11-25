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
    <link rel="stylesheet" href="../CSS/padrao.css" />
    <link rel="stylesheet" href="../CSS/comoajudar.css" />
    <script src="../JS/comoajudar.js" defer></script>
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

        <section id="depoimentos" style="max-width: 900px; margin: 50px auto; padding: 0 10px;">
            <h2>O que dizem sobre a Peludinhos do Bem</h2>

            <div class="depoimento-bloco" style="margin-bottom: 40px; text-align: center;">
                <img src="../IMG/comoajudar/depoimento1.jpg" alt="Depoimento Maria" class="depoimento">
                <p><em>"Adotar com a Peludinhos do Bem mudou minha vida e a do Thor. Eles são profissionais, carinhosos e realmente se importam. Nunca imaginei que um simples gesto pudesse transformar tanto. Sou eternamente grata."</em></p>
                <strong>- Maria S.</strong>
            </div>

            <div class="depoimento-bloco" style="margin-bottom: 40px; text-align: center;">
                <img src="../IMG/comoajudar/depoimento2.jpg" alt="Depoimento João" class="depoimento">
                <p><em>"Ter adotado aqui foi uma das melhores decisões que já tomei. Ver a recuperação e o carinho da minha humana me dá uma sensação de propósito que não tem preço."</em></p>
                <strong>- João, o cão.</strong>
            </div>

            <div class="depoimento-bloco" style="margin-bottom: 40px; text-align: center;">
                <img src="../IMG/comoajudar/depoimento3.jpg" alt="Depoimento Ana" class="depoimento">
                <p><em>"Doar um pouco do meu tempo e compartilhar as campanhas nas redes sociais me faz sentir parte de algo maior. É emocionante ver quantas vidas são tocadas por essa ONG."</em></p>
                <strong>- Marcelo M.</strong>
            </div>

            <div class="depoimento-bloco" style="margin-bottom: 40px; text-align: center;">
                <img src="../IMG/comoajudar/depoimento4.jpg" alt="Depoimento Carlos" class="depoimento">
                <p><em>"Conhecer o trabalho da Peludinhos do Bem me inspirou a começar a ajudar mais ativamente. Cada gesto, por menor que seja, faz uma diferença enorme para esses animais."</em></p>
                <strong>- Carlos R.</strong>
            </div>
        </section>

    </main>

    <footer>
    <div class="footer-coluna" id="cl1">
        <h2>Peludinhos do bem</h2>
        <p>08989-8989898</p>
        <p>Rua Santa Helena, 21, Parque Alvorada,<br> Imperatriz-MA, CEP 65919-505</p>
        <p>adotefacil@peludinhosdobem.org</p>
    </div>

    <div class="footer-coluna" id="cl2">
        <a href="sobre.html"></a>
        <h2>Conheça a História da Peludinhos do Bem</h2>
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


    <div class="footer-rodape">
        <p>Desenvolvido pela Turma-20 Tecnico de Informatica para Internet (Peludinhos do Bem). 2025 &copy;Todos os direitos reservados.</p>
    </div>
    
    </footer>

</body>
</html>