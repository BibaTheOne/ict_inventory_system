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
    $searchSql = "WHERE username LIKE ? OR department LIKE ? OR building LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q];
}

if (!$all) {
    $searchSql .= ($searchSql ? " " : "") . "LIMIT ? OFFSET ?";
    $params[] = $perPage;
    $params[] = $offset;
}

$stmt = $pdo->prepare("SELECT * FROM users $searchSql");
$stmt->execute($params);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="users_export.csv"');
$output = fopen('php://output', 'w');
fputcsv($output, ['User ID', 'Username', 'Phone Number', 'Email', 'Building', 'Floor', 'Department']);
foreach ($rows as $row) {
    fputcsv($output, [
        $row['user_id'],
        $row['username'],
        $row['phone_number'],
        $row['email'],
        $row['building'],
        $row['floor'],
        $row['department']
    ]);
}
fclose($output);
exit();
