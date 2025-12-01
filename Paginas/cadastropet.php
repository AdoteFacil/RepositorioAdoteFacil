<?php
session_start();
include ('../PHP/conexao.php');

$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM cliente WHERE id_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('location: entrar.html');
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adote Fácil - Cadastro de Pet</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="../CSS/padrao.css">
  <link rel="stylesheet" href="../CSS/cadastropet.css">
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
                <a href="adote.php" id="adote">Adote um pet</a>
                <a href="comoajudar.php">Como ajudar</a>
                <?php 
                if (
                    isset($_SESSION['usuario_email'], $_SESSION['usuario_id']) &&
                    $_SESSION['usuario_email'] === "admadote@gmail.com" &&
                    $_SESSION['usuario_id'] == 2   // <-- coloque o ID correto aqui
                ): ?>
                    <a href="../PHP/ADM/Usuario/consulta.php">adm</a>
                <?php endif; ?>

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
    <div class="boxpet">
      <form action="../PHP/PETs/cadastrarPET.php" method="post" enctype="multipart/form-data">
        <fieldset>
          <legend><b>Cadastre seu Pet</b></legend>

          <div class="inputBox">
            <label for="nome" class="labelinput">Nome do Animal</label>
            <input type="text" name="nome" id="nome" class="inputUser" maxlength="15" required />
          </div>

          <div class="inputBox">
            <label for="genero" class="labelinput">Informe o gênero do seu animal</label>
            <select name="genero" id="genero" required>
              <option value="">Selecione o gênero</option>
              <option value="Macho">Macho</option>
              <option value="Fêmea">Fêmea</option>
            </select>
          </div>

            <div id="duo">
            <div class="inputBox">
            <label for="peso">Peso (Kg)</label>
            <input type="number" name="peso" id="peso" class="inputUser" step="0.1" min="0"/>
            </div>
            
            <div class="inputBox">
            <label for="idade">Idade (Anos)</label>
            <input type="number" name="idade" id="idade" class="inputUser" min="0"/>
            </div>
            </div>
          
            <div id="duo">
          <div class="inputBox">
            <label for="especie" class="labelinput">Espécie</label>
            <input type="text" name="especie" id="especie" class="inputUser" required />
          </div>
          
          <div class="inputBox">
            <label for="raca" class="labelinput">Raça</label>
            <input type="text" name="raca" id="raca" class="inputUser" required />
          </div>
          </div>
          
          <div id="duo">
          <div class="inputBox">
            <label for="porte" class="labelinput">Porte</label>
            <select name="porte" id="porte">
              <option value="Pequeno">Pequeno</option>
              <option value="Médio">Médio</option>
              <option value="Grande">Grande</option>
            </select>
          </div>

          <div class="inputBox">
            <label for="situacao" class="labelinput">Situação</label>
            <select name="situacao" id="situacao">
              <option value="Nenhum">Nenhum</option>
              <option value="Vacinado">Vacinado</option>
              <option value="Vacinado e Castrado">Vacinado e Castrado</option>
              <option value="Castrado">Castrado</option>
            </select>
          </div>
          </div>

          <div class="inputBox">
            <label for="sobre" class="labelinput">Sobre o Pet</label>
            <textarea name="sobre" id="sobre" class="inputUser" maxlength="144" rows="4" placeholder="Conte um pouco sobre seu pet..."></textarea>
          </div>

          <div class="inputBox">
            <label for="imagem" class="labelinput">Insira uma foto do Animal</label>
            <input type="file" name="foto" id="foto" class="inputUser" accept="image/*" required>
          </div>

          <p>
            Ao clicar no botão você estará automaticamente concordando com os nossos
            <a href="#">Termo de Uso e Política de Privacidade</a> do site Adote Fácil
          </p>

          <button type="submit">Salvar</button>
        </fieldset>
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