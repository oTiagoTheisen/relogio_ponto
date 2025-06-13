<?php
include("conexao.php");

$mensagemErro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $matricula = $_POST["matricula"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);
    $tipo = $_POST["tipo"];

    try {
        // Verificar se matrícula já existe
        $sqlCheck = "SELECT COUNT(*) FROM usuarios WHERE matricula = ?";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$matricula]);
        $existe = $stmtCheck->fetchColumn();

        if ($existe > 0) {
            $mensagemErro = "Essa matrícula já está cadastrada!";
        } else {
            $sql = "INSERT INTO usuarios (nome, matricula, senha, tipo) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $matricula, $senha, $tipo]);
            header("Location: usuarios.php");
            exit();
        }
    } catch (PDOException $e) {
        $mensagemErro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Adicionar Usuário</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #0b1b2a; color: white; font-family: Arial; text-align: center; padding: 50px;">
    <h2>Adicionar Usuário</h2>
	<?php if (!empty($mensagemErro)) : ?>
    <div style="background-color: #ff4d4d; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px; text-align: center;">
        <?php echo $mensagemErro; ?>
    </div>
<?php endif; ?>

    <form method="POST" style="display: inline-block; text-align: left; background: #1c2b3a; padding: 30px; border-radius: 10px;">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Matrícula:</label><br>
        <input type="text" name="matricula" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <label>Tipo:</label><br>
        <select name="tipo" required>
            <option value="funcionario">Funcionário</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit" style="background-color: #dc3545; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Salvar</button>
        <a href="usuarios.php" style="margin-left: 10px; color: #ccc;">Cancelar</a>
    </form>
</body>
</html>
