<?php
require_once '../conexao.php';

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'] ?? '';
$matricula = $_POST['matricula'] ?? '';
$senha = $_POST['senha'] ?? '';
$tipo = $_POST['tipo'] ?? 'funcionario';

if ($id) {
    // Atualiza
    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, tipo = ? WHERE id = ?");
    $stmt->execute([$nome, $tipo, $id]);
} else {
    // Novo usuário
    if (!$nome || !$matricula || !$senha || !$tipo) {
        echo "Preencha todos os campos.";
        exit;
    }
    $senha_hash = password_hash($senha, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, matricula, senha, tipo) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $matricula, $senha_hash, $tipo]);
}
header("Location: ../usuarios.php");
exit;
