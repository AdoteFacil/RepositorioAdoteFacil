<?php
session_start();
require '../conexao.php';


if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../Paginas/entrar.php');
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

$sql = "SELECT * FROM cliente WHERE id_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Usuário não encontrado.");
}

$usuario = $result->fetch_assoc();

// Busca os pets do usuário
$sqlPets = "SELECT * FROM pet WHERE id_cliente = ?";
$stmtPets = $conexao->prepare($sqlPets);
$stmtPets->bind_param("i", $id_usuario);
$stmtPets->execute();
$resultPets = $stmtPets->get_result();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../JS/delete.js" defer></script>
    <link rel="stylesheet" href="../../CSS/perfil.css">
    <link rel="stylesheet" href="../../CSS/padrao.css">
    <script src="../../JS/padrao.js" defer></script>
    <title>Perfil</title>
    <style>
        /* --- CONTAINER PRINCIPAL (A GRADE) --- */
.pets-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 15px;
    padding: 15px;
    width: 100%;
}

.pets-container h2 {
    grid-column: 1 / -1;
    color: #444;
    font-size: 1.4rem;
    margin-bottom: 10px;
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 8px;
}

/* --- ESTILO DO CARD --- */
.pet-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    display: flex;
    flex-direction: column;
}

/* Efeito ao passar o mouse */
.pet-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* --- IMAGEM DO PET --- */
.pet-img {
    width: 100%;
    height: 160px; 
    object-fit: cover;
    border-bottom: 1px solid #eee;
}

/* --- TEXTOS (Nome, Raça, Status) --- */
.pet-card h3 {
    margin: 10px 10px 4px;
    color: #333;
    font-size: 1.1rem;
}

.pet-card p {
    margin: 3px 10px;
    color: #666;
    font-size: 0.9rem;
    line-height: 1.3;
}

/* Destaque para o texto do Status */
.pet-card p strong {
    color: #333;
}

/* --- FORMULÁRIOS E BOTÕES --- */
.pet-card form {
    padding: 0 10px 8px; 
    display: flex;
    gap: 8px; 
    margin-top: auto;
}

/* Select (Menu suspenso) */
.pet-card select {
    flex: 1; 
    padding: 6px; 
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
    font-size: 0.85rem; 
    cursor: pointer;
}

/* Botões Gerais */
.pet-card button {
    padding: 7px 10px; 
    border: none;
    border-radius: 4px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    font-size: 0.85rem; 
    color: white;
}

/* Botão de Atualizar (Primeiro form) */
.pet-card form:first-of-type button {
    background-color: #007bff;
}

.pet-card form:first-of-type button:hover {
    background-color: #0056b3;
}

/* Botão de Deletar (Segundo form) */
.pet-card form:last-of-type {
    padding-bottom: 10px; 
}

.pet-card form:last-of-type button {
    background-color: #fff;
    color: #dc3545; 
    border: 1px solid #dc3545;
    width: 100%; 
}

.pet-card form:last-of-type button:hover {
    background-color: #dc3545;
    color: white;
}

/* Mensagem de "Nenhum pet" */
.pets-container > p {
    grid-column: 1 / -1;
    text-align: center;
    color: #777;
    font-style: italic;
    margin-top: 15px;
}
    </style>
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="../../index.php"><img src="../../IMG/Logotipo.jpg" alt="logo_Adote_Fácil"></a>
            </div>
            <div class="dropdown">
                <input type="checkbox" id="burger-menu">
                <label class="burger" for="burger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <div class="dropdown-content">
                    <a href="../../index.php">Início</a>
                    <a href="../../Paginas/sobre.php">Sobre Nós</a>
                    <a href="../../Paginas/adote.php">Adote um pet</a>
                    <a href="../../Paginas/comoajudar.php">Como ajudar</a>

                    <?php if (!isset($_SESSION['usuario_id'])): ?>
                        <a href="Paginas/entrar.php" id="btn-entrar" class="botao-entrar">Entrar</a>
                    <?php else: ?>
                        <div class="usuario-box" id="userMenu">
                            <img src="../../IMG/usuario/<?php echo $_SESSION['usuario_foto']; ?>" 
                                class="foto-perfil" alt="Foto">

                            <div class="dropdown-user">
                                <span class="nome-dropdown">
                                    <?php echo explode(" ", $_SESSION['usuario_nome'])[0]; ?>
                                </span>

                                <a href="../../PHP/Usuario/perfil.php">Perfil</a>
                                <a href="../../PHP/Usuario/logout.php">Sair</a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
            <h1>Perfil do Usuário</h1>

        <div class="">
            <img src="../../IMG/usuario/<?= htmlspecialchars($usuario['foto']) ?>" alt="Foto do perfil" class="fotoPerfil">
        </div>
        <div class="info">
            <strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']) ?>
        </div>
        <div class="info">
            <strong>CPF:</strong> <?= htmlspecialchars($usuario['cpf']) ?>
        </div>
        
        <div class="info">
            <strong>Data de Nascimento:</strong> <?= htmlspecialchars($usuario['data_nasc']) ?>
        </div>
        
        <div class="info">
            <strong>E-mail:</strong> <?= htmlspecialchars($usuario['email']) ?>
        </div>
        <div class="numeros">
            <div class="info tel">
            <strong>Telefone:</strong> <?= htmlspecialchars($usuario['telefone']) ?>
            </div>
            <div class="info zap">
                <strong>WhatsApp:</strong> <?= htmlspecialchars($usuario['whatsapp']) ?>
            </div>
        </div>
        
        <div class="locais">
            <div class="info estado">
                <strong>Estado:</strong> <?= htmlspecialchars($usuario['estado']) ?>
            </div>
            <div class="info cidade">
                <strong>Cidade:</strong> <?= htmlspecialchars($usuario['cidade']) ?>
            </div>
        </div>
        
        <div id="registrar">
            <a href="../../Paginas/entrar.php" class="btn btn-primary">Sair</a>
            <a href="editar.php" class="btn btn-primary">Editar</a>
            <form action="delete.php" method="POST" onsubmit="return confirm('Tem certeza que deseja deletar sua conta?');">
                <button type="submit">Deletar</button>
            </form>
        </div>
    </div>

    

    <div class="pets-container">
        <h2>Meus Pets Cadastrados</h2>
        <?php if ($resultPets->num_rows > 0): ?>
            <?php while ($pet = $resultPets->fetch_assoc()): ?>
                <div class="pet-card">
                    <img src="../../IMG<?= htmlspecialchars($pet['foto']) ?>" class="pet-img">
 
                    <h3><?= htmlspecialchars($pet['nome']) ?></h3>
                    <p><strong>Raça:</strong> <?= htmlspecialchars($pet['raca']) ?></p>
                    <p><strong>Idade:</strong> <?= htmlspecialchars($pet['idade']) ?></p>
                    <p><strong>Status:</strong> 
                        <?= $pet['statusPet'] === 'adotado' ? '🐾 Adotado' : '🟢 Disponível' ?>
                    </p>

                    <!-- Form para alterar o status -->
                    <form action="../PETs/alterarStatus.php" method="POST">
                        <input type="hidden" name="id_pet" value="<?= $pet['id_pet'] ?>">

                        <select name="status">
                            <option value="disponivel" <?= $pet['statusPet']=='disponivel'?'selected':'' ?>>
                                Disponível
                            </option>
                            <option value="adotado" <?= $pet['statusPet']=='adotado'?'selected':'' ?>>
                                Adotado
                            </option>
                        </select>
                        
                        <button type="submit">Atualizar</button>
                    </form>
                    <form action="../PETs/deletePet.php" method="POST"
                        onsubmit="return confirm('Tem certeza que deseja deletar seu pet?');">
                        <input type="hidden" name="id_pet" value="<?= $pet['id_pet'] ?>">
                        <button type="submit">Deletar</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>Nenhum pet cadastrado ainda.</p>
        <?php endif; ?>
    </div>

    <footer>
        <section class="footer">
            <div class="footer-coluna" id="cl1">
                <h2>Peludinhos do bem</h2>
                <p>08989-8989898</p>
                <p>Rua Santa Helena, 21, Parque Alvorada,<br> Imperatriz-MA, CEP 65919-505</p>
                <p>adotefacil@peludinhosdobem.org</p>
            </div>

            <div class="footer-coluna" id="cl2">
                <a href="../../Paginas/sobre.php"><h2>Conheça a História da Peludinhos do Bem</h2></a>
                
            </div>

            <div class="footer-coluna" id="cl3">
                <h2>Contatos</h2>

                <div class="icons-row">
                    <a href="https://www.instagram.com/">
                    <img src="../../IMG/index/insta.png" alt="Instagram">
                    </a>

                    <a href="https://web.whatsapp.com/">
                    <img src="../../IMG/index/—Pngtree—whatsapp icon whatsapp logo whatsapp_3584845.png" alt="Whatsapp">
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