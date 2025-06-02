<?php
require_once 'conexao.php';

header("Content-Type: text/csv");
header("Content-Disposition: attachment;filename=registros_ponto.csv");

$output = fopen("php://output", "w");
fputcsv($output, ["Nome", "Data", "Hora"]);

$query = "SELECT r.*, u.nome FROM registros_ponto r JOIN usuarios u ON r.usuario_id = u.id ORDER BY r.data DESC, r.hora DESC";
$stmt = $pdo->query($query);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($output, [$row["nome"], $row["data"], $row["hora"]]);
}
fclose($output);
exit;
