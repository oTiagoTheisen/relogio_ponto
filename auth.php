<?php
session_start();
require_once 'conexao.php';

$matricula = $_POST['usuario'] ?? '';
$senha = $_POST['senha'] ?? '';

if ($matricula && $senha) {
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE matricula = ?");
    $stmt->execute([$matricula]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['tipo'] = $usuario['tipo'];
        header("Location: ponto.php");
        exit;
    } else {
        echo "<script>alert('Usuário ou senha inválidos'); window.location.href = 'login.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Preencha todos os campos'); window.location.href = 'login.php';</script>";
    exit;
}
?>