<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include('../../conexao.php');

$sql = "SELECT * FROM pet ORDER BY id_pet DESC";
$result = mysqli_query($conexao, $sql);

if ($result) {
    $pets = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
    $pets = array();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../padrao.css">
  <script src="../../../JS/deleteAdm.js" defer></script>
  <title>Consulta de PETs</title>
</head>

<body>
  <div class="container">
    <h1>PETs Cadastrados</h1>

    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Foto</th>
          <th>Nome</th>
          <th>Gênero</th>
          <th>Peso</th>
          <th>Idade</th>
          <th>Espécie</th>
          <th>Porte</th>
          <th>Raça</th>
          <th>Status</th>
          <th>Sobre</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
      <?php if (count($pets) > 0): ?>
          <?php foreach ($pets as $pet): ?>
              <tr>
                  <td><?= $pet['id_pet'] ?></td>

                  <td>
                      <img src="../../../IMG/adote/<?= htmlspecialchars($pet['foto']) ?>" width="70">
                  </td>

                  <td><?= htmlspecialchars($pet['nome']) ?></td>
                  <td><?= htmlspecialchars($pet['genero']) ?></td>
                  <td><?= htmlspecialchars($pet['peso']) ?> kg</td>
                  <td><?= htmlspecialchars($pet['idade']) ?></td>
                  <td><?= htmlspecialchars($pet['especie']) ?></td>
                  <td><?= htmlspecialchars($pet['porte']) ?></td>
                  <td><?= htmlspecialchars($pet['raca']) ?></td>

                  <td>
                      <?= $pet['situacao'] == 'adotado' ? '🐾 Adotado' : '🟢 Disponível' ?>
                  </td>

                  <td style="max-width: 200px;">
                      <?= htmlspecialchars($pet['sobrePet']) ?>
                  </td>

                  <!-- AÇÕES 2x2 -->
                  <td class="acoes">

                      <!-- Linha 1 -->
                      <div class="acoes-linha">
                          <a href="editar.php?id=<?= $pet['id_pet'] ?>" class="botao btn-editar">✏ Editar</a>

                          <a href="apagar.php?id_pet=<?= $pet['id_pet'] ?>" 
                            class="botao btn-apagar btn-delete">🗑 Apagar</a>
                      </div>

                      <!-- Linha 2 -->
                      <div class="acoes-linha">
                          <form action="alterarStatus.php" method="POST">
                              <input type="hidden" name="id_pet" value="<?= $pet['id_pet'] ?>">

                              <select name="status" class="select-status">
                                  <option value="disponivel" <?= $pet['situacao']=='disponivel'?'selected':'' ?>>
                                      🟢 Disponível
                                  </option>
                                  <option value="adotado" <?= $pet['situacao']=='adotado'?'selected':'' ?>>
                                      🐾 Adotado
                                  </option>
                              </select>

                              <button type="submit" class="botao btn-salvar">💾 Salvar</button>
                          </form>
                      </div>

                  </td>

              </tr>
          <?php endforeach; ?>
      <?php else: ?>
          <tr><td colspan="13">Nenhum pet cadastrado.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>

    <div class="back-button">
      <a href="../../../index.php">Voltar</a>
      <a href="../Usuario/consulta.php">Consultar Humano</a>
    </div>

  </div>
</body>
</html>
