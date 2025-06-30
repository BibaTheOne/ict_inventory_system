<?php
include 'auth.php';
include 'db.php';

$search = $_GET['search'] ?? '';
$all = isset($_GET['all']);
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$searchSql = '';
$params = [];

if ($search !== '') {
    $searchSql = "WHERE equipment_type LIKE ? OR equipment_name LIKE ? OR serial_no LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q];
}

if (!$all) {
    $searchSql .= ($searchSql ? " " : "") . "LIMIT ? OFFSET ?";
    $params[] = $perPage;
    $params[] = $offset;
}

$stmt = $pdo->prepare("SELECT * FROM equipments $searchSql");
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="equipments_export.csv"');
$output = fopen('php://output', 'w');
fputcsv($output, ['Equipment ID', 'Type', 'Name', 'Serial No', 'Barcode No']);
foreach ($rows as $row) {
    fputcsv($output, [
        $row['equipment_id'],
        $row['equipment_type'],
        $row['equipment_name'],
        $row['serial_no'],
        $row['barcode_no']
    ]);
}
fclose($output);
exit();
