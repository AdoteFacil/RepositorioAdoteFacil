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

//PESQUISA PET
$resultados = [];
$termo = '';

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['busca'])) {
    $termo = trim($_GET['busca']);

    $sql = "SELECT * FROM pet 
        WHERE statusPet = 'disponivel' 
        AND (porte LIKE ? 
        OR raca LIKE ?
        OR nome LIKE ?
        OR especie LIKE ?)";

    $stmt = mysqli_prepare($conexao, $sql);
    $like = "%" . $termo . "%";
    mysqli_stmt_bind_param($stmt, "ssss", $like, $like, $like, $like);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    $resultados = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    $pet = $resultados;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../padrao.css">
  <link rel="stylesheet" href="../consulta.css">
  <script src="../../../JS/deleteAdm.js" defer></script>
  <title>Consulta de PETs</title>
  <style>
    .subir {
    width: 100%;
    display: flex;
    justify-content: center; 
    align-items: center; 
    gap: 15px; 
    margin-bottom: 20px;
    }

    .subir a {
        text-decoration: none;
        background: #5669FF;
        color: white;
        padding: 8px 16px; 
        border-radius: 8px;
        font-weight: 600;
        transition: .2s;
        white-space: nowrap; 
    }

    .subir a:hover {
        background: #3543d1;
    }
    
    .back-button {
    width: 100%;
    height: 38px;
    display: flex;
    justify-content: space-between; 
    
    gap: 15px; 
    margin-bottom: 20px;
    }

    .back-button a {
        text-decoration: none;
        background: #5669FF;
        color: white;
        padding: 8px 16px; 
        border-radius: 8px;
        font-weight: 600;
        transition: .2s;
        white-space: nowrap; 
    }

    .back-button a:hover {
        background: #3543d1;
    }

    .search-box {
    width: 300px;
    max-width: 480px;
    background: #ffffff;
    border-radius: 12px;
    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: center;
    box-shadow: 0 0px 15px rgba(0,0,0,0.08);
    }

    .search-box input {
    flex: 1;
    padding: 10px 14px;
    border: 1px solid #d3d3d3;
    border-radius: 10px;
    font-size: 15px;
    outline: none;
    }

    .search-box input:focus {
    border-color: #5669FF;
    box-shadow: 0 0 0 2px rgba(86,105,255,0.2);
    }

    .search-box button {
    background: #5669FF;
    color: white;
    padding: 10px 18px;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: .2s;
    }

    .search-box button:hover {
    background: #3543d1;
    }
  </style>
</head>

<body>
  <div class="container" id="container">
    <div class="back-button">
        <a href="../../../index.php" style="margin-right: -145px;">⬅ Voltar</a>
        <a href="../Usuario/consulta.php">Consultar Humano</a>
    
        <h1>PETs Cadastrados</h1>
        <form class="search-box" method="GET">
            <input type="text" name="busca" placeholder="Buscar por nome"
                value="<?php echo htmlspecialchars($termo ?? ''); ?>">
            <button type="submit">Pesquisar</button>
        </form> 
    </div>
     <br>
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
      <tbody>
        <?php 
            // Decide se mostra todos ou só os pesquisados
            $lista = (!empty($termo)) ? $resultados : $pets;
        ?>

        <?php if (count($lista) > 0): ?>
            <?php foreach ($lista as $pet): ?>

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

    <div class="subir">
      <a href="#container">⭡ Subir</a>
    </div>

  </div>
</body>
</html>
