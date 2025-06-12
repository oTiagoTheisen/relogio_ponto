
<?php
include("conexao.php");

date_default_timezone_set("America/Sao_Paulo");

$id = $_GET["id"] ?? null;
$data = $_GET["data"] ?? null;

if (!$id || !$data) {
    die("Parâmetros inválidos.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $horarios = $_POST["horarios"];
    $stmt = $pdo->prepare("DELETE FROM registros_ponto WHERE usuario_id = ? AND data = ?");
    $stmt->execute([$id, $data]);

    foreach ($horarios as $hora) {
        if (trim($hora) != "") {
            $stmt = $pdo->prepare("INSERT INTO registros_ponto (usuario_id, data, hora) VALUES (?, ?, ?)");
            $stmt->execute([$id, $data, $hora]);
        }
    }

    header("Location: admin.php");
    exit();
}

$stmt = $pdo->prepare("SELECT hora FROM registros_ponto WHERE usuario_id = ? AND data = ? ORDER BY hora ASC");
$stmt->execute([$id, $data]);
$horarios = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Horários</title>
</head>
<body style="background-color: #0b1b2a; color: white; font-family: Arial; text-align: center; padding: 50px;">
    <h2>Editar Horários - <?= $data ?></h2>
    <form method="POST" style="display: inline-block; background-color: #1c2b3a; padding: 30px; border-radius: 10px; text-align: left;">
        <?php foreach ($horarios as $index => $hora): ?>
            <label>Horário <?= $index + 1 ?>:</label><br>
            <input type="time" name="horarios[]" value="<?= $hora ?>" required style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: none;"><br>
        <?php endforeach; ?>

        <!-- Campo para adicionar novo horário -->
        <label>Novo Horário (opcional):</label><br>
        <input type="time" name="horarios[]" style="width: 100%; padding: 8px; margin-bottom: 15px; border-radius: 5px; border: none;"><br>

        <button type="submit" style="background-color: #0d6efd; color: white; padding: 10px 20px; border: none; border-radius: 5px;">Salvar</button>
        <a href="admin.php" style="margin-left: 15px; color: #ccc;">Cancelar</a>
    </form>
</body>
</html>
