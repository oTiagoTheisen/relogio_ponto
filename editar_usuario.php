<?php
include("conexao.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $tipo = $_POST["tipo"];

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, matricula = ?, tipo = ? WHERE id = ?");
    $stmt->execute([$nome, $matricula, $tipo, $id]);

    header("Location: usuarios.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Usuário</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #0b1b2a; color: white; font-family: Arial; text-align: center; padding: 50px;">
    <h2>Editar Usuário</h2>

    <form method="POST" style="display: inline-block; text-align: left; background: #1c2b3a; padding: 30px; border-radius: 10px;">
        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">

        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $usuario['nome']; ?>" required><br><br>

        <label>Matrícula:</label><br>
        <input type="text" name="matricula" value="<?php echo $usuario['matricula']; ?>" required><br><br>

        <label>Tipo:</label><br>
        <select name="tipo" required>
            <option value="funcionario" <?php if ($usuario['tipo'] == 'funcionario') echo 'selected'; ?>>Funcionário</option>
            <option value="admin" <?php if ($usuario['tipo'] == 'admin') echo 'selected'; ?>>Admin</option>
        </select><br><br>

        <button type="submit" style="background-color: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Salvar</button>
        <a href="usuarios.php" style="margin-left: 10px; color: #ccc;">Cancelar</a>
    </form>
</body>
</html>
