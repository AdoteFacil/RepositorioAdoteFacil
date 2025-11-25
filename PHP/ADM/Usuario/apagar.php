<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

if (!isset($_GET['id'])) {
    die("ID não informado.");
}

$id = intval($_GET['id']);

// Buscar a foto do usuário
$sqlFoto = "SELECT foto FROM cliente WHERE id_cliente = $id LIMIT 1";
$resultFoto = mysqli_query($conexao, $sqlFoto);

if (mysqli_num_rows($resultFoto) === 0) {
    die("Usuário não encontrado.");
}

$dados = mysqli_fetch_assoc($resultFoto);
$foto = $dados['foto'];

// Deletar usuário do banco
$sqlDelete = "DELETE FROM cliente WHERE id_cliente = $id";

if (mysqli_query($conexao, $sqlDelete)) {

    // Se existir uma foto, apagar da pasta
    if (!empty($foto) && file_exists("../../../IMG/usuario/" . $foto)) {
        unlink("../../../IMG/usuario/" . $foto);
    }

    header("Location: consulta.php?msg=apagado");
    exit();
} else {
    echo "Erro ao apagar: " . mysqli_error($conexao);
}
?>
