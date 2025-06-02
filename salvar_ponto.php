<?php
session_start();
require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo "Sessão expirada. Faça login novamente.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_SESSION["usuario_id"];
    $data = date("Y-m-d");
    $hora = date("H:i:s");

    try {
        $stmt = $pdo->prepare("INSERT INTO registros_ponto (usuario_id, data, hora) VALUES (?, ?, ?)");
        $stmt->execute([$usuario_id, $data, $hora]);
        echo "Ponto registrado com sucesso!";
    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erro ao salvar ponto: " . $e->getMessage();
    }
} else {
    http_response_code(405);
    echo "Método não permitido.";
}
?>