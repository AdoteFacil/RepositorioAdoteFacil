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
<link rel="stylesheet" href="../editarPadrao.css">
</head>
<body>
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

        <label>Foto Atual:</label><br>
        <img src="../../../IMG/usuario/<?= htmlspecialchars($cliente['foto']) ?>" width="120"><br><br>

        <label>Mudar Foto:</label>
        <input type="file" name="foto">

        <button type="submit">Salvar Alterações</button>
        <br><br>
        <a href="consulta.php" class="btn-voltar">Voltar</a>
    </form>
</div>
</body>
</html>
