<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require "../conexao.php";

// Se não estiver logado
if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Sessão expirada. Faça login novamente.'); window.location.href='entrar.html';</script>";
    exit;
}

$id_usuario = $_SESSION['usuario_id'];

// ---------------------- //
// PROCESSAR O FORMULÁRIO //
// ---------------------- //
// PROCESSAR O FORMULÁRIO
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Sanitização e Coalescência (Garante que a variável existe)
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $dataNasc = $_POST['dataNascimento'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $whatsapp = $_POST['whats'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $senha = trim($_POST['senha'] ?? '');

    // Inicialização para montagem dinâmica do SQL
    $campos_para_atualizar = [
        "nome = ?",
        "cpf = ?",
        "data_nasc = ?",
        "email = ?", 
        "telefone = ?", 
        "whatsapp = ?", 
        "estado = ?", 
        "cidade = ?"
    ];
    $tipos = "ssssssss"; // Tipos iniciais para os 8 campos de string
    $parametros = [
        $nome, $cpf, $dataNasc, $email, $telefone, $whatsapp, $estado, $cidade
    ];

    // 1. Lógica da Senha (Opcional)
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $campos_para_atualizar[] = "senha = ?";
        $tipos .= "s";
        $parametros[] = $senhaHash;
    }

    // 2. Lógica da Foto (Opcional)
    $novoNomeFoto = null;
    if (!empty($_FILES['foto']['name'])) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $novoNomeFoto = uniqid() . "." . $ext;
        
        // Move o arquivo para o destino
        move_uploaded_file($_FILES['foto']['tmp_name'], "../../IMG/usuario/" . $novoNomeFoto);

        $campos_para_atualizar[] = "foto = ?";
        $tipos .= "s";
        $parametros[] = $novoNomeFoto;
    }

    // Monta a query final
    $sql = "UPDATE cliente SET " . implode(", ", $campos_para_atualizar) . " WHERE id_cliente = ?";
    
    // Adiciona o tipo e o parâmetro do ID do usuário no final
    $tipos .= "i";
    $parametros[] = $id_usuario;

    // Prepara e executa o statement
    $stmt = $conexao->prepare($sql);
    
    if (!$stmt) {
        // Se houver um erro de sintaxe no SQL, ele será exibido aqui.
        die("Erro na preparação do SQL: " . $conexao->error);
    }

    // Chama o bind_param dinamicamente (necessário quando o número de parâmetros muda)
    // O array_merge junta a string de tipos com o array de valores
    call_user_func_array([$stmt, 'bind_param'], array_merge([$tipos], $parametros));

    $stmt->execute();

    // Redirecionamento de Sucesso
    // Se o usuário alterou a foto, precisamos atualizar a sessão
    if (!empty($novoNomeFoto)) {
        $_SESSION['usuario_foto'] = $novoNomeFoto;
    }

    echo "<script>alert('Perfil atualizado com sucesso!'); window.location.href='editar.php';</script>";
    exit;
}

// --------------------------- //
// BUSCA OS DADOS DO USUÁRIO   //
// --------------------------- //
$sql = "SELECT * FROM cliente WHERE id_cliente = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$res = $stmt->get_result();
$usuario = $res->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../../css/padrao.css">
    <link rel="stylesheet" href="../../css/perfil.css">
    <script src="../../JS/padrao.js" defer></script>
    <script src="../../JS/cadastrar.js" defer></script>
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
                    <a href="../../Paginas/entrar.html" id="btn-entrar" class="botao-entrar">Entrar</a>
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
    <h1>Editar Perfil</h1>

    <img src="../../IMG/usuario/<?= htmlspecialchars($usuario['foto']) ?>" 
         class="fotoPerfil" alt="Foto do perfil">

    <form method="POST" enctype="multipart/form-data" class="formEditar">

        <div class="info">
            <label>Nome Completo:</label>
            <input class="input-info" type="text" name="nome" 
                   value="<?= htmlspecialchars($usuario['nome']) ?>" >
        </div>

        <div class="info">
            <label>CPF:</label>
            <input class="input-info" type="text" name="cpf" 
                   value="<?= htmlspecialchars($usuario['cpf']) ?>" >
        </div>
        
        <div class="info">
            <label>Data de Nascimento:</label>
            <input class="input-info" type="date" name="dataNascimento" 
                   value="<?= htmlspecialchars($usuario['data_nasc']) ?>">
        </div>
        
        <div class="info">
            <label>E-mail:</label>
            <input class="input-info" type="email" name="email" 
                   value="<?= htmlspecialchars($usuario['email']) ?>">
        </div>

        <div class="numeros">
            <div class="info tel">
                <label>Telefone:</label> <br>
                <input class="input-info" type="tel" name="telefone" 
                    value="<?= htmlspecialchars($usuario['telefone']) ?>">
            </div>

            <div class="info zap">
                <label>WhatsApp:</label> <br>
                <input class="input-info" type="tel" name="whats" 
                    value="<?= htmlspecialchars($usuario['whatsapp']) ?>">
            </div>
        </div>

        <div class="locais">
            <div class="info estado">
                <label>Estado:</label> <br>
                <select name="estado" id="estado" class="input-info" onchange="carregarCidades()">
                    <option value="">Selecione</option>
                    <?php
                        $estados = [
                            'AC'=>'Acre', 'AL'=>'Alagoas', 'AP'=>'Amapá', 'AM'=>'Amazonas', 'BA'=>'Bahia', 
                            'CE'=>'Ceará', 'DF'=>'Distrito Federal', 'ES'=>'Espírito Santo', 'GO'=>'Goiás', 
                            'MA'=>'Maranhão', 'MT'=>'Mato Grosso', 'MS'=>'Mato Grosso do Sul', 'MG'=>'Minas Gerais', 
                            'PA'=>'Pará', 'PB'=>'Paraíba', 'PR'=>'Paraná', 'PE'=>'Pernambuco', 'PI'=>'Piauí', 
                            'RJ'=>'Rio de Janeiro', 'RN'=>'Rio Grande do Norte', 'RS'=>'Rio Grande do Sul', 
                            'RO'=>'Rondônia', 'RR'=>'Roraima', 'SC'=>'Santa Catarina', 'SP'=>'São Paulo', 
                            'SE'=>'Sergipe', 'TO'=>'Tocantins'
                        ];
                        
                        foreach ($estados as $sigla => $nome) {
                            // Verifica se é o estado do usuário para marcar como selecionado
                            $selected = ($usuario['estado'] == $sigla) ? 'selected' : '';
                            echo "<option value='$sigla' $selected>$nome</option>";
                        }
                    ?>
                </select>
            </div>

            <div class="info cidade">
                <label>Cidade:</label> <br>
                <select name="cidade" id="cidade" class="input-info" disabled required>
                    <option value="">Selecione um estado...</option>
                </select>
            </div>
        </div>

        <div class="info">
            <label>Nova Senha (opcional):</label>
            <input class="input-info" type="password" name="senha" 
                   placeholder="Deixe vazio para manter a atual">
        </div>

        <div class="info">
            <label>Nova Foto (opcional):</label>
            <input class="input-info" type="file" name="foto">
        </div>

        <div id="registrar">
            <a href="perfil.php" class="btn btn-primary">⭠ Voltar</a>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
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
                <a href="Paginas/sobre.html"><h2>Conheça a História da Peludinhos do Bem</h2></a>
                
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