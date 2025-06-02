<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado'])) {
    header("Location: login.php");
    exit;
}

$filtro_usuario = $_GET['usuario'] ?? '';
$filtro_data = $_GET['data'] ?? '';

$query = "SELECT r.*, u.nome FROM registros_ponto r JOIN usuarios u ON r.usuario_id = u.id WHERE 1";
$params = [];

if ($filtro_usuario) {
    $query .= " AND u.nome LIKE ?";
    $params[] = "%$filtro_usuario%";
}
if ($filtro_data) {
    $query .= " AND r.data = ?";
    $params[] = $filtro_data;
}

$query .= " ORDER BY r.data DESC, r.hora DESC";
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$registros = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Administração - Zart</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #0D1B2A, #1B263B);
            color: #fff;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1100px;
            margin: auto;
            background: #1B263B;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        h2 {
            color: #E63946;
            margin-bottom: 20px;
            text-align: center;
        }
        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }
        input[type="text"],
        input[type="date"] {
            padding: 10px;
            border-radius: 8px;
            border: none;
            width: 200px;
        }
        .btn, .export-btn {
            padding: 10px 20px;
            background-color: #E63946;
            border: none;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }
        .export-btn {
            background-color: #457b9d;
        }
        .btn:hover,
        .export-btn:hover {
            opacity: 0.9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            color: #000;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 15px;
            text-align: center;
        }
        th {
            background-color: #E63946;
            color: #fff;
            position: sticky;
            top: 0;
        }
        tr:nth-child(even) {
            background-color: #f3f3f3;
        }
        tr:hover {
            background-color: #ddd;
        }
        .logout-link {
            display: block;
            text-align: right;
            margin-bottom: 10px;
            color: #A8DADC;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout-link">Sair</a>
        <h2>Registros de Ponto</h2>
        <form method="get">
            <input type="text" name="usuario" placeholder="Filtrar por nome" value="<?= htmlspecialchars($filtro_usuario) ?>">
            <input type="date" name="data" value="<?= htmlspecialchars($filtro_data) ?>">
            <button type="submit" class="btn">Filtrar</button>
            <a href="exportar.php" class="export-btn">Exportar CSV</a>
        </form>
        <table>
            <tr>
                <th>Nome</th>
                <th>Data</th>
                <th>Hora</th>
            </tr>
            <?php foreach ($registros as $registro): ?>
            <tr>
                <td><?= htmlspecialchars($registro['nome']) ?></td>
                <td><?= htmlspecialchars($registro['data']) ?></td>
                <td><?= htmlspecialchars($registro['hora']) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
