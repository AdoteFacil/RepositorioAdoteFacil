<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

$sql = "SELECT * FROM cliente ORDER BY id_cliente DESC";
$result = mysqli_query($conexao, $sql);

if ($result) {
    $cliente = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); // Libera a memória do resultado
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
    $cliente = array(); // Array vazio em caso de erro
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../../CSS/consulta.css">
  <link rel="stylesheet" href="../../../CSS/padrao.css">
  <script src="../../../JS/deleteAdm.js" defer></script>
  <script src="../../../JS/padrao.js" defer></script>
  <title>Consulta de Usuários</title>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../../../index.php"><img src="../../../IMG/LogoTransparente.png" alt="logo_Adote_Fácil"></a>
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <ul class="dropdown-content">
                    <li class="li-dropdown linkIndex"><a href="../../../index.php" class="active">Início</a></li>
                    <li class="li-dropdown linkSobre"><a href="../../../Paginas/sobre.php">Sobre Nós</a></li>
                    <li class="li-dropdown linkAdote"><a href="../../../Paginas/adote.php">Adote um pet</a></li>
                    <li class="li-dropdown linkCajudar"><a href="../../../Paginas/comoajudar.php">Como ajudar</a></li>
                    <?php 
                    if (
                        isset($_SESSION['usuario_email'], $_SESSION['usuario_id']) &&
                        $_SESSION['usuario_email'] === "admadote@gmail.com" &&
                        $_SESSION['usuario_id'] == 1   // <-- coloque o ID correto aqui
                    ): ?>
                        <li class="li-dropdown "><a href="../../../PHP/ADM/Usuario/consulta.php">adm</a></li>
                    <?php endif; ?>


                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <li class=" li-dropdown "><a href="../../../Paginas/entrar.php" id="btn-entrar" class="botao-entrar">Entrar</a></li>
                    <?php else: ?>
                        <div class="usuario-box" id="userMenu">
                            <img src="../../../IMG/usuario/<?php echo $_SESSION['usuario_foto']; ?>" 
                                class="foto-perfil" alt="Foto">

                            <div class="dropdown-user">
                                <span class="nome-dropdown">
                                    <?php echo explode(" ", $_SESSION['usuario_nome'])[0]; ?>
                                </span>

                                <a href="../../../PHP/Usuario/perfil.php" class="link-perfil">Perfil</a>
                                <a href="../../../PHP/Usuario/logout.php" class="link-perfil">Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>
  <div class="container">
    <h1>Usuários Cadastrados</h1>

    <!-- Tabela de usuários -->
    <table id="userTable">
      <thead>
        <tr>
          <th>ID</th>
          <th>Imagem Perfil</th>
          <th>Nome</th>
          <th>CPF</th>
          <th>Data de Nascimento</th>
          <th>E-mail</th>
          <th>Telefone</th>
          <th>Whatsapp</th>
          <th>Estado</th>
          <th>Cidade</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($cliente) > 0): ?>
            <?php foreach ($cliente as $pessoa): ?>
                <tr>
                    <td><?= $pessoa['id_cliente'] ?></td>
                    <td><img src="../../../IMG/usuario/<?= htmlspecialchars($pessoa['foto']) ?>" width="60"></td>
                    <td><?= htmlspecialchars($pessoa['nome']) ?></td>
                    <td><?= htmlspecialchars($pessoa['cpf']) ?></td>
                    <td><?= htmlspecialchars($pessoa['data_nasc']) ?></td>
                    <td><?= htmlspecialchars($pessoa['email']) ?></td>
                    <td><?= htmlspecialchars($pessoa['telefone']) ?></td>
                    <td><?= htmlspecialchars($pessoa['whatsapp']) ?></td>
                    <td><?= htmlspecialchars($pessoa['estado']) ?></td>
                    <td><?= htmlspecialchars($pessoa['cidade']) ?></td>
                    <td class="acoes">
                      <div class="acoes">
                        <a href="editar.php?id=<?php echo $pessoa['id_cliente']; ?>">✏ Editar</a>
                        <a href="apagar.php?id=<?= $pessoa['id_cliente'] ?>" class="btn-delete">🗑 Apagar</a>
                      </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="10">Nenhum usuário cadastrado.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

    <!-- Botão de voltar -->
    <div class="back-button">
      <a href="../../../index.php">Voltar</a>
      <a href="../Pet/consulta.php">Consultar Pet</a>
    </div>
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
            <a href="Paginas/sobre.php"><h2>Conheça a História da Peludinhos do Bem</h2></a>
            
        </div>

        <div class="footer-coluna" id="cl3">
            <h2>Contatos</h2>

            <div class="icons-row">
                <a href="https://www.instagram.com/">
                <img src="../../../IMG/index/insta.png" alt="Instagram">
                </a>

                <a href="https://web.whatsapp.com/">
                <img src="../../../IMG/index/—Pngtree—whatsapp icon whatsapp logo whatsapp_3584845.png" alt="Whatsapp">
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
