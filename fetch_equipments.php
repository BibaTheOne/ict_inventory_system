<?php
include 'auth.php';
include 'db.php';

$search = $_GET['search'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$perPage = 20;
$offset = ($page - 1) * $perPage;

$params = [];
$where = '';

if ($search !== '') {
    $where = "WHERE equipment_type LIKE ? OR equipment_name LIKE ? OR serial_no LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q];
}

$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM equipments $where");
$totalQuery->execute(array_slice($params, 0, 3));
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM equipments $where LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$equipments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($equipments as $row) {
    echo "<tr>
        <td>{$row['equipment_id']}</td>
        <td>{$row['equipment_type']}</td>
        <td>{$row['equipment_name']}</td>
        <td>{$row['serial_no']}</td>
        <td>{$row['barcode_no']}</td>
        <td>
            <a href='edit_equipment.php?id={$row['equipment_id']}'>Edit</a> |
            <a href='delete_equipment.php?id={$row['equipment_id']}'>Delete</a>
        </td>
    </tr>";
}

// Pagination links
echo "<tr><td colspan='6' style='text-align:center;'>";
if ($page > 1) {
    echo "<a href='?tab=equipments&page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Prev</a> ";
}
if ($page < $pages) {
    echo "<a href='?tab=equipments&page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Next</a>";
}
echo "</td></tr>";
