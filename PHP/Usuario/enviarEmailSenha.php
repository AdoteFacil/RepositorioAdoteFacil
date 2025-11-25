<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../conexao.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../Paginas/esqueciSenha.php');
    exit;
}

$email = $_POST['email'];

// verifica se email existe
$sql = "SELECT id_cliente FROM cliente WHERE email = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo "E-mail não encontrado.";
    exit;
}

$user = $res->fetch_assoc();
$id = $user['id_cliente'];

// cria token
$token = bin2hex(random_bytes(50));
$expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

// salva token no BD
$sqlUp = "UPDATE cliente SET token_redefinir=?, token_expira=? WHERE id_cliente=?";
$stmtUp = $conexao->prepare($sqlUp);
$stmtUp->bind_param("ssi", $token, $expira, $id);
$stmtUp->execute();

// link de redefinição
// monta url base automaticamente
$protocolo = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// pega apenas o diretório raiz do seu projeto
$root = dirname($_SERVER['REQUEST_URI']);
$root = str_replace('/PHP/Usuario', '', $root); // sobe até a raiz

$base = "$protocolo://$host$root";

// link final
$link = $base . "/Paginas/redefinirSenha.php?token=" . $token;

// ENVIO DE EMAIL
$mail = new PHPMailer(true);


try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'isaacenzo126@gmail.com';
    $mail->Password = 'kiadehssirthwpgh'; // senha de app SEM espaços

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // CORREÇÃO AQUI
    $mail->setFrom('isaacenzo126@gmail.com', 'Adote Fácil');

    $mail->addAddress($email);

    $mail->isHTML(true);
    $mail->Subject = 'Adote Fácil Recuperação de Senha';
    $mail->Body = "
        <h2>Recuperação de senha</h2>
        <p>Para redefinir sua senha, clique no link abaixo:</p>
        <a href='$link'>$link</a>
    ";

    $mail->send();
    echo "Um link de recuperação foi enviado ao seu e-mail.";

} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
