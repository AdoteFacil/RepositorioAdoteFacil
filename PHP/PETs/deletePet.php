<?php
session_start();
require '../conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Sessão expirada! Faça login novamente.'); window.location.href='../../Paginas/entrar.html';</script>";
    exit;
}

$id_cliente = intval($_SESSION['usuario_id']);

// Verifica se o id_pet veio do formulário
if (!isset($_POST['id_pet'])) {
    echo "<script>alert('Pet não encontrado.'); window.location.href='../Usuario/perfil.php';</script>";
    exit;
}

$id_pet = intval($_POST['id_pet']);

// 1️⃣ Buscar o pet para confirmar que pertence ao usuário e pegar a foto
$sql = "SELECT foto FROM pet WHERE id_pet = ? AND id_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("ii", $id_pet, $id_cliente);
$stmt->execute();
$result = $stmt->get_result();

// Nenhum pet encontrado ou não pertence ao usuário
if ($result->num_rows === 0) {
    echo "<script>alert('Pet não encontrado ou não pertence ao seu usuário.'); window.location.href='../Usuario/perfil.php';</script>";
    exit;
}

$pet = $result->fetch_assoc();
$caminhoFoto = $pet['foto'];  // Caminho completo salvo no banco (ex: ../../IMG/adote/xxxx.jpg)


// 2️⃣ Apaga a foto física (se existir)
if (!empty($caminhoFoto) && file_exists($caminhoFoto)) {
    unlink($caminhoFoto);
}


// 3️⃣ Apagar histórico do pet (evita erro por FK)
$sqlHist = "DELETE FROM historico WHERE id_pet = ?";
$stmtHist = $conexao->prepare($sqlHist);
$stmtHist->bind_param("i", $id_pet);
$stmtHist->execute();


// 4️⃣ Apagar o pet da tabela
$sqlDelete = "DELETE FROM pet WHERE id_pet = ? AND id_cliente = ?";
$stmtDelete = $conexao->prepare($sqlDelete);
$stmtDelete->bind_param("ii", $id_pet, $id_cliente);

if ($stmtDelete->execute()) {
    echo "<script>
            alert('Pet deletado com sucesso!');
            window.location.href='../Usuario/perfil.php';
          </script>";
} else {
    echo "<script>
            alert('Erro ao deletar o pet.');
            window.location.href='../Usuario/perfil.php';
          </script>";
}

exit;
?>
