<?php
include('../PHP/conexao.php');
session_start();

$sql = "SELECT * FROM pet WHERE statusPet = 'disponivel' ORDER BY id_pet DESC";
$result = mysqli_query($conexao, $sql);

if ($result) {
    $pet = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result); // Libera a memória do resultado
} else {
    echo "Erro na consulta: " . mysqli_error($conexao);
    $pet = array(); // Array vazio em caso de erro
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Adote Fácil</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/padrao.css" />
  <link rel="stylesheet" href="../CSS/adote.css" />
  <script src="../JS/adote.js" defer></script>
  <style>
    .search-box {
    margin: 20px auto 35px;
    padding: 12px 18px;
    width: 100%;
    max-width: 480px;

    background: #ffffff;
    border-radius: 12px;

    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: center;

    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
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
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/index.php"><img src="../IMG/Logotipo.jpg" alt="logo_Adote_Fácil" /></a>
                
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                <span></span>
                <span></span>
                <span></span>
                </label>

                <div class="dropdown-content">
                <a href="../index.php">Início</a>
                <a href="sobre.html">Sobre Nós</a>
                <a href="adote.php" id="adote">Adote um pet</a>
                <a href="comoajudar.html">Como ajudar</a>
                <a href="entrar.html">Entrar</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section class="intro-adote">
            <h1>Encontre seu novo melhor amigo</h1>
            <p>Adotar é um gesto de amor. Veja os pets disponíveis e transforme uma vida.</p>
            <form class="search-box" method="GET">
                <input type="text" name="busca" placeholder="Buscar por nome, raça, porte..."
                    value="<?php echo htmlspecialchars($termo ?? ''); ?>">
                <button type="submit">Pesquisar</button>
            </form> 
        </section>
    <?php if (!empty($pet)): ?>
    <div class="vitrine">
        <?php foreach ($pet as $animal): ?>
            <div class="pet-card">
                <div class="pet-imagem">
                    <img src="../IMG/adote/<?= htmlspecialchars($animal['foto'])?>" alt="Imagem do pet" />
                </div>

                <div class="pet-info">
                    <h2>Nome: <?php echo $animal['nome']; ?></h2>
                    <p><strong>Idade:</strong> <?php echo $animal['idade']; ?> anos</p>
                    <p><strong>Gênero:</strong> <?php echo $animal['genero']; ?></p>
                    <p><strong>Situação:</strong> <?php echo $animal['situacao']; ?></p>
                </div>

                <div class="sobre">
                    <p><strong>Peso:</strong> <?= htmlspecialchars($animal['peso']) ?> kg</p>
                    <p><strong>Espécie:</strong> <?= htmlspecialchars($animal['especie']) ?></p>
                    <p><strong>Porte:</strong> <?= htmlspecialchars($animal['porte']) ?></p>
                    <p><strong>Raça:</strong> <?= htmlspecialchars($animal['raca']) ?></p>
                    <p><strong>Sobre:</strong> <?= htmlspecialchars($animal['sobrePet']) ?></p>

                    <a href="entrar.html"><button class="qadot">Quero adotar</button></a>
                </div>

                <button class="saiba">Saber mais</button>
            </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>

        <div class="nenhum-resultado">
            <p>❌ Nenhum pet encontrado para "<strong><?= htmlspecialchars($termo) ?></strong>".</p>
            <a href="adote.php" class="limpar-busca">Limpar busca</a>
        </div>

    <?php endif; ?>
        </div>
            <div class="cadastro-pet-container">
                <a href="cadastropet.php" class="cadastro-pet-btn">Quero cadastrar meu pet</a>
            </div>
    </main>

    <footer>
        <section class="footer">
            <div class="footer-coluna" id="cl1">
                <h2>Peludinhos do bem</h2>
                <p>08989-8989898</p>
                <p>Rua Santa Helena, 21, Parque Alvorada,<br> Imperatriz-MA, CEP 65919-505</p>
                <p>adotefacil@peludinhosdobem.org</p>
            </div>

            <div class="footer-coluna" id="cl2">
                <a href="Paginas/sobre.html"><h2>Conheça a História da Peludinhos do Bem</h2></a>
                
            </div>

            <div class="footer-coluna" id="cl3">
                <h2>Contatos</h2>

                <div class="icons-row">
                    <a href="https://www.instagram.com/">
                    <img src="../IMG/index/insta.png" alt="Instagram">
                    </a>

                    <a href="https://web.whatsapp.com/">
                    <img src="../IMG/index/—Pngtree—whatsapp icon whatsapp logo whatsapp_3584845.png" alt="Whatsapp">
                    </a>
                </div>
            </div>
        </section>

        <div class="footer-rodape">
            <p>Desenvolvido pela Turma-20 Tecnico de Informatica para Internet (Peludinhos do Bem). 2025 &copy;Todos os direitos reservados.</p>
        </div>
    </footer>

</body>
</html>