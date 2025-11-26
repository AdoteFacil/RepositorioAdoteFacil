<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

$sql = "SELECT * FROM pet ORDER BY id_pet DESC";
$result = mysqli_query($conexao, $sql);

if ($result) {
    $pet = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); // Libera a memória do resultado
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
    $pet = array(); // Array vazio em caso de erro
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styleconsulta.css">
  <link rel="stylesheet" href="style.css">
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
          <th>Gênero</th>
          <th>Peso</th>
          <th>Idade</th>
          <th>Espécie</th>
          <th>Porte</th>
          <th>Raça</th>
          <th>Situação</th>
          <th>Sobre</th>
          <th>Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($pet) > 0): ?>
            <?php foreach ($pet as $animal): ?>
                <tr>
                    <td><?= $animal['id_pet'] ?></td>
                    <td><img src="../../../IMG/adote/<?= htmlspecialchars($animal['foto']) ?>" width="60"></td>
                    <td><?= htmlspecialchars($animal['nome']) ?></td>
                    <td><?= htmlspecialchars($animal['genero']) ?></td>
                    <td><?= htmlspecialchars($animal['peso']) ?></td>
                    <td><?= htmlspecialchars($animal['idade']) ?></td>
                    <td><?= htmlspecialchars($animal['especie']) ?></td>
                    <td><?= htmlspecialchars($animal['porte']) ?></td>
                    <td><?= htmlspecialchars($animal['raca']) ?></td>
                    <td><?= htmlspecialchars($animal['situacao']) ?></td>
                    <td><?= htmlspecialchars($animal['sobrePet']) ?></td>
                    <td><a href="editar.php?id=<?php echo $animal['id_pet']; ?>">Editar</a> |
                    <a href="#" class="btn-delete" data-id="<?= $animal['id_pet'] ?>">Apagar</a></td>
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
      <a href="../Usuario/consulta.php">Consultar Humano</a>
    </div>
  </div>
</body>
</html>
