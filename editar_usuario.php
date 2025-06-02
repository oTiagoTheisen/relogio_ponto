<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Usuário inválido.";
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    echo "Usuário não encontrado.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
</head>
<body style="background:#1B263B; color:white; font-family:sans-serif; padding:30px;">
    <h2>Editar Usuário</h2>
    <form action="controllers/salvar_usuario.php" method="POST">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        <p><input type="text" name="nome" value="<?= $usuario['nome'] ?>" required></p>
        <p><input type="text" name="matricula" value="<?= $usuario['matricula'] ?>" readonly></p>
        <p>
            <select name="tipo">
                <option value="funcionario" <?= $usuario['tipo'] === 'funcionario' ? 'selected' : '' ?>>Funcionário</option>
                <option value="admin" <?= $usuario['tipo'] === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>
        </p>
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
