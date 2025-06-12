
<?php
session_start();
require_once 'conexao.php';

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$filtro_usuario = $_GET['usuario'] ?? '';
$data_inicio = $_GET['data_inicio'] ?? '';
$data_fim = $_GET['data_fim'] ?? '';

$query = "SELECT r.usuario_id, u.nome, r.data, GROUP_CONCAT(r.hora ORDER BY r.hora SEPARATOR ' - ') AS horarios
          FROM registros_ponto r
          JOIN usuarios u ON r.usuario_id = u.id
          WHERE 1";

$params = [];

if ($filtro_usuario) {
    $query .= " AND u.nome LIKE ?";
    $params[] = "%$filtro_usuario%";
}
if ($data_inicio && $data_fim) {
    $query .= " AND r.data BETWEEN ? AND ?";
    $params[] = $data_inicio;
    $params[] = $data_fim;
}

$query .= " GROUP BY r.usuario_id, r.data ORDER BY r.data DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$registros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração - Zart</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-color: #0b1b2a; color: white; font-family: Arial; text-align: center;">
    <div style="max-width: 900px; margin: auto; padding: 30px;">
        <h2 style="margin-bottom: 30px;">Registros de Ponto</h2>
        <form method="GET" style="margin-bottom: 20px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap;">
            <input type="text" name="usuario" placeholder="Filtrar por nome" value="<?= htmlspecialchars($filtro_usuario) ?>" style="padding: 8px; border-radius: 5px; border: none;">
            <input type="date" name="data_inicio" value="<?= $data_inicio ?>" style="padding: 8px; border-radius: 5px; border: none;">
            <input type="date" name="data_fim" value="<?= $data_fim ?>" style="padding: 8px; border-radius: 5px; border: none;">
            <button type="submit" style="background-color: #dc3545; color: white; padding: 8px 16px; border: none; border-radius: 5px;">Filtrar</button>
            <a href="exportar.php" style="text-decoration: none;">
                <button type="button" style="background-color: #0d6efd; color: white; padding: 8px 16px; border: none; border-radius: 5px;">Exportar CSV</button>
            </a>
        </form>

        <div style="background-color: #1c2b3a; padding: 20px; border-radius: 12px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #dc3545; color: white;">
                        <th style="padding: 10px;">Nome</th>
                        <th>Data</th>
                        <th>Horários</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($registros as $registro): ?>
                        <tr style="background-color: white; color: black; text-align: center;">
                            <td><?= htmlspecialchars($registro['nome']) ?></td>
                            <td><?= $registro['data'] ?></td>
                            <td><?= $registro['horarios'] ?></td>
                            <td>
                                <a href="editar_horario.php?id=<?= $registro['usuario_id'] ?>&data=<?= $registro['data'] ?>">
                                    <button style="background-color: #0d6efd; color: white; border: none; padding: 5px 10px; border-radius: 5px;">Editar</button>
                                </a>
                                <a href="excluir_horario.php?id=<?= $registro['usuario_id'] ?>&data=<?= $registro['data'] ?>" onclick="return confirm('Tem certeza que deseja excluir os horários desse dia?');">
                                    <button style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 5px;">Excluir</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <br>
        
    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
        <a href="index.php" style="color: #ccc;">← Voltar</a>
        <a href="logout.php" style="color: #ccc;">Sair</a>
    </div>
    
    </div>
</body>
</html>
