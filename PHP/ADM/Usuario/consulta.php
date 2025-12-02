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

// PESQUISA DE CLIENTE
$resultados = [];
$termo = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['busca'])) {
    $termo = trim($_GET['busca']);

    $sql = "SELECT * FROM cliente
            WHERE nome LIKE ?
            OR email LIKE ?
            OR cidade LIKE ?
            OR telefone LIKE ?
            OR whatsapp LIKE ?
            ORDER BY id_cliente DESC";

    $stmt = mysqli_prepare($conexao, $sql);
    $like = "%" . $termo . "%";

    mysqli_stmt_bind_param($stmt, "sssss", $like, $like, $like, $like, $like);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $resultados = mysqli_fetch_all($resultado, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);

    // substitui o array principal para a tabela
    $cliente = $resultados;
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
  <div class="container">
    <div class="back-button">
        <a href="../../../index.php" style="margin-right: -128px;">⬅ Voltar</a>
        <a href="../Pet/consulta.php">Consultar Pets</a>
    
        <h1>Usuários Cadastrados</h1>
        <form class="search-box" method="GET">
            <input type="text" name="busca" placeholder="Buscar por nome"
                value="<?php echo htmlspecialchars($termo ?? ''); ?>">
            <button type="submit">Pesquisar</button>
        </form> 
    </div>


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
    <div class="subir">
      <a href="#container">⭡ Subir</a>
    </div>
  </div>
</body>
</html>
