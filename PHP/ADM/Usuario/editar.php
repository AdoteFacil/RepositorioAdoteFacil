<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

if (!isset($_GET['id'])) {
    die("ID do cliente não informado.");
}

$id = intval($_GET['id']);

// Buscar dados do cliente
$sql = "SELECT * FROM cliente WHERE id_cliente = $id LIMIT 1";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Cliente não encontrado.");
}

$cliente = mysqli_fetch_assoc($result);

// Atualizar dados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nasc = $_POST['data_nasc'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $whatsapp = $_POST['whatsapp'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];

    // Verifica se enviou nova foto
    if (!empty($_FILES['foto']['name'])) {

        $imagem = $_FILES['foto']['name'];
        $destino = "../../../IMG/usuario/" . $imagem;

        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);

        $sqlUpdate = "UPDATE cliente SET 
                        nome='$nome', 
                        cpf='$cpf',
                        data_nasc='$data_nasc',
                        email='$email', 
                        telefone='$telefone',
                        whatsapp='$whatsapp',
                        estado='$estado',
                        cidade='$cidade',
                        foto='$imagem'
                      WHERE id_cliente=$id";
    } else {
        $sqlUpdate = "UPDATE cliente SET 
                        nome='$nome', 
                        cpf='$cpf',
                        data_nasc='$data_nasc',
                        email='$email', 
                        telefone='$telefone',
                        whatsapp='$whatsapp',
                        estado='$estado',
                        cidade='$cidade'
                      WHERE id_cliente=$id";
    }

    if (mysqli_query($conexao, $sqlUpdate)) {
        header("Location: consulta.php?msg=editado");
        exit();
    } else {
        echo "Erro ao atualizar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Usuário</title>
<link rel="stylesheet" href="../../../css/consultaedit.css">
<link rel="stylesheet" href="../../../CSS/padrao.css">
<script src="../../../JS/padrao.js" defer></script>
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
    <h1>Editar Usuário</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        
        <label>Nome</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required>

        <label>CPF</label>
        <input type="text" name="cpf" value="<?= htmlspecialchars($cliente['cpf']) ?>" required>

        <label>Data de Nascimento</label>
        <input type="date" name="data_nasc" value="<?= htmlspecialchars($cliente['data_nasc']) ?>" required>

        <label>E-mail</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>

        <label>Telefone</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>">

        <label>Whatsapp</label>
        <input type="text" name="whatsapp" value="<?= htmlspecialchars($cliente['whatsapp']) ?>">

        <label>Estado</label>
        <input type="text" name="estado" value="<?= htmlspecialchars($cliente['estado']) ?>">

        <label>Cidade</label>
        <input type="text" name="cidade" value="<?= htmlspecialchars($cliente['cidade']) ?>">

        <div class="form-img">
            <label>Foto Atual:</label><br>
            <img src="../../../IMG/usuario/<?= htmlspecialchars($cliente['foto']) ?>" class="preview-foto" width="120"><br><br>
        </div>

        <label>Mudar Foto:</label>
        <input type="file" name="foto">

        <div class="links">
            <button type="submit">Salvar Alterações</button>
            <br><br>
            <a href="consulta.php" class="btn-voltar">Voltar</a>
        </div>
    </form>

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
        <p>Desenvolvido pela Turma - 20.8.2025 Tecnico de Informatica para Internet (Peludinhos do Bem). 2025 &copy;Todos os direitos reservados.</p>
    </div>
</footer>   
</body>
</html>
