<?php
// Executar uma única vez para cadastrar um usuário com senha segura
require_once 'conexao.php';

$nome = 'Administrador';
$matricula = 'admin';
$senha = '1234';
$senha_hash = password_hash($senha, PASSWORD_BCRYPT);

$stmt = $pdo->prepare("INSERT INTO usuarios (nome, matricula, senha) VALUES (?, ?, ?)");
$stmt->execute([$nome, $matricula, $senha_hash]);

echo "Usuário criado com sucesso!";
?>