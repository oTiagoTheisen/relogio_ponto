<?php
session_start();
require_once '../conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id || $id == $_SESSION['usuario_id']) {
    echo "Não é possível excluir este usuário.";
    exit;
}

$stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->execute([$id]);

header("Location: ../usuarios.php");
exit;
