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
    $where = "WHERE username LIKE ? OR phone_number LIKE ? OR email LIKE ? OR department LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q, $q];
}

$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM users $where");
$totalQuery->execute($params);
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM users $where LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $row) {
    echo "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['username']}</td>
        <td>{$row['phone_number']}</td>
        <td>{$row['email']}</td>
        <td>{$row['building']}</td>
        <td>{$row['floor']}</td>
        <td>{$row['department']}</td>
        <td>
            <a href='edit_user.php?id={$row['user_id']}'>Edit</a> |
            <a href='delete_user.php?id={$row['user_id']}'>Delete</a>
        </td>
    </tr>";
}

// Pagination links
echo "<tr><td colspan='8' style='text-align:center;'>";
if ($page > 1) {
    echo "<a href='?tab=users&page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Prev</a> ";
}
if ($page < $pages) {
    echo "<a href='?tab=users&page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Next</a>";
}
echo "</td></tr>";
