
<?php
include("conexao.php");

$id = $_GET["id"] ?? null;
$data = $_GET["data"] ?? null;

if ($id && $data) {
    $stmt = $pdo->prepare("DELETE FROM registros_ponto WHERE usuario_id = ? AND data = ?");
    $stmt->execute([$id, $data]);
}

header("Location: admin.php");
exit();
?>
