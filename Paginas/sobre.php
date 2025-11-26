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
  <link rel="stylesheet" href="../CSS/sobreNos.css" />
  <script src="../JS/sobre.js" defer></script>
  <script src="../JS/padrao.js" defer></script>
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

    <div class="container">
        
        <h1>Quem somos</h1>
        <p>Adote Fácil é uma ONG que nasceu do amor pelos animais e do desejo de fazer a diferença na vida de cães e gatos abandonados. Atuamos com responsabilidade, carinho e dedicação para resgatar, cuidar e encaminhar animais para lares cheios de amor.
        </p>
        <H2>Nossa Missão</H2>
        <p>Promover a adoção responsável e transformar a realidade de animais em situação de rua ou maus-tratos, garantindo a eles saúde, segurança e uma nova chance de serem felizes.</p>
        <h2>O que fazemos</h2>
        <p>Resgatamos animais abandonados ou em risco, oferecendo acolhimento, cuidados veterinários, alimentação e muito carinho. Após o tratamento, buscamos lares responsáveis através de feiras e campanhas de adoção.

        Também realizamos ações de conscientização sobre guarda responsável e incentivamos a castração como forma de controle populacional.</p>

        <h2>Como Você Pode Ajudar</h2>

        <p>Você pode fazer parte dessa missão de várias formas: adotando um pet, sendo voluntário, fazendo doações ou divulgando nosso trabalho. Toda ajuda conta — e cada gesto salva uma vida!</p>

        <h2>Oque doar</h2>

        <ul>
            <li>Dinheiro</li>
            <li>Ração</li>
            <li>Brinquedos</li>
            <li>Outros itens para pets</li>
        </ul>

       <h2> Por que Existimos</h2>

        <p>Porque acreditamos que todo animal merece respeito, amor e uma família. Enquanto houver um animal sofrendo nas ruas, estaremos aqui para acolher, cuidar e lutar por ele.</p>

        

    </div>
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