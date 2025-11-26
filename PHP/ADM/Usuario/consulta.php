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
  <link rel="stylesheet" href="../padrao.css">
  <script src="../../../JS/deleteAdm.js" defer></script>
  <title>Consulta de Usuários</title>
</head>
<body>
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
</body>
</html>
