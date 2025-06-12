<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['logado']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT * FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários</title>
    <style>
        body {
            background: linear-gradient(to bottom right, #0D1B2A, #1B263B);
            color: white;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
        }
        .container {
            max-width: 950px;
            margin: auto;
            background: #1B263B;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.5);
        }
        h2 {
            color: #E63946;
            text-align: center;
            margin-bottom: 20px;
        }
        a.voltar {
            color: #A8DADC;
            text-decoration: none;
            display: block;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background: #E63946;
            color: white;
            padding: 10px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        tr:nth-child(even) {
            background: #f3f3f3;
        }
        tr:hover {
            background: #eee;
        }
        .btn-acao {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            margin: 0 5px;
        }
        .editar {
            background-color: #457b9d;
            color: white;
        }
        .editar:hover {
            background-color: #35648d;
        }
        .excluir {
            background-color: #E63946;
            color: white;
        }
        .excluir:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Usuários</h2>

<a href="criar_usuario.php" style="text-decoration:none;">
    <button style="margin-bottom: 20px; background-color: #dc3545; border: none; color: white; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
        + Adicionar Usuário
    </button>
</a>

    <a href="ponto.php" class="voltar">← Voltar</a>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Tipo</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td><?= htmlspecialchars($u['matricula']) ?></td>
            <td><?= htmlspecialchars($u['tipo']) ?></td>
            <td>
                <a href="editar_usuario.php?id=<?= $u['id'] ?>" class="btn-acao editar">Editar</a>
                <?php if ($_SESSION['usuario_id'] != $u['id']): ?>
                    <a href="controllers/deletar_usuario.php?id=<?= $u['id'] ?>" class="btn-acao excluir" onclick="return confirm('Excluir este usuário?')">Excluir</a>
                <?php else: ?>
                    <span style="color:gray; font-size: 0.9em;">(Você)</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
