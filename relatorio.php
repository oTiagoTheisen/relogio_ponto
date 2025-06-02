<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'relogio_ponto');
if ($conn->connect_error) { die("Falhou: " . $conn->connect_error); }

$sql = "SELECT u.nome, r.data, r.hora FROM registros_ponto r JOIN usuarios u ON r.usuario_id = u.id ORDER BY r.data DESC, r.hora DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Relatório</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1 class="logo">Relatório de Pontos</h1>
    <table>
        <tr>
            <th>Funcionário</th>
            <th>Data</th>
            <th>Hora</th>
        </tr>
        <?php if ($result->num_rows > 0): while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['nome'] ?></td>
            <td><?= $row['data'] ?></td>
            <td><?= $row['hora'] ?></td>
        </tr>
        <?php endwhile; else: ?>
        <tr><td colspan="3">Nenhum registro encontrado.</td></tr>
        <?php endif; ?>
    </table>
    <a href="ponto.php">Voltar</a>
</div>
</body>
</html>
