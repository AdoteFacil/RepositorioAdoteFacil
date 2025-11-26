<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

if (!isset($_GET['id'])) {
    die("ID do pet não informado.");
}

$id = intval($_GET['id']);

// Buscar dados do pet
$sql = "SELECT * FROM pet WHERE id_pet = $id LIMIT 1";
$result = mysqli_query($conexao, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Pet não encontrado.");
}

$pet = mysqli_fetch_assoc($result);

// Atualizar dados ao enviar o formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nome = $_POST['nome'];
    $genero = $_POST['genero'];
    $peso = $_POST['peso'];
    $idade = $_POST['idade'];
    $especie = $_POST['especie'];
    $porte = $_POST['porte'];
    $raca = $_POST['raca'];
    $situacao = $_POST['situacao'];
    $sobre = $_POST['sobrePet'];

    // Verifica se enviou nova foto
    if (!empty($_FILES['foto']['name'])) {

        $imagem = $_FILES['foto']['name'];
        $destino = "../../../IMG/adote/" . $imagem;

        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);

        // Atualizar incluindo foto
        $sqlUpdate = "UPDATE pet SET 
                        nome='$nome',
                        genero='$genero',
                        peso='$peso',
                        idade='$idade',
                        especie='$especie',
                        porte='$porte',
                        raca='$raca',
                        situacao='$situacao',
                        sobrePet='$sobre',
                        foto='$imagem'
                      WHERE id_pet=$id";
    } else {

        // Atualizar sem mexer na foto
        $sqlUpdate = "UPDATE pet SET 
                        nome='$nome',
                        genero='$genero',
                        peso='$peso',
                        idade='$idade',
                        especie='$especie',
                        porte='$porte',
                        raca='$raca',
                        situacao='$situacao',
                        sobrePet='$sobre'
                      WHERE id_pet=$id";
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
<title>Editar Pet</title>
<link rel="stylesheet" href="../editarPadrao.css">
</head>
<body>
<div class="container">
    <h1>Editar Pet</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        
        <label>Nome do Pet</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($pet['nome']) ?>" required>

        <label>Gênero</label>
        <input type="text" name="genero" value="<?= htmlspecialchars($pet['genero']) ?>" required>

        <label>Peso</label>
        <input type="text" name="peso" value="<?= htmlspecialchars($pet['peso']) ?>">

        <label>Idade</label>
        <input type="text" name="idade" value="<?= htmlspecialchars($pet['idade']) ?>">

        <label>Espécie</label>
        <input type="text" name="especie" value="<?= htmlspecialchars($pet['especie']) ?>">

        <label>Porte</label>
        <input type="text" name="porte" value="<?= htmlspecialchars($pet['porte']) ?>">

        <label>Raça</label>
        <input type="text" name="raca" value="<?= htmlspecialchars($pet['raca']) ?>">

        <label>Situação</label>
        <input type="text" name="situacao" value="<?= htmlspecialchars($pet['situacao']) ?>">

        <label>Sobre</label>
        <textarea name="sobrePet" rows="5"><?= htmlspecialchars($pet['sobrePet']) ?></textarea>

        <label>Foto Atual:</label><br>
        <img src="../../../IMG/adote/<?= htmlspecialchars($pet['foto']) ?>" width="150"><br><br>

        <label>Mudar Foto:</label>
        <input type="file" name="foto">

        <button type="submit">Salvar Alterações</button>
        <br><br>
        <a href="consulta.php" class="btn-voltar">Voltar</a>
    </form>
</div>
</body>
</html>
