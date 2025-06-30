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
    $where = "WHERE equipment_id LIKE ? OR user_id LIKE ?";
    $q = "%$search%";
    $params = [$q, $q];
}

$totalQuery = $pdo->prepare("SELECT COUNT(*) FROM assignments $where");
$totalQuery->execute(array_slice($params, 0, 2));
$total = $totalQuery->fetchColumn();
$pages = ceil($total / $perPage);

$stmt = $pdo->prepare("SELECT * FROM assignments $where LIMIT $perPage OFFSET $offset");
$stmt->execute($params);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($assignments as $row) {
    echo "<tr>
        <td>{$row['assignment_id']}</td>
        <td>{$row['equipment_id']}</td>
        <td>{$row['user_id']}</td>
        <td>{$row['date_issued']}</td>
        <td>{$row['return_status']}</td>
        <td>{$row['return_date']}</td>
        <td>
            <form method='POST' action='edit_assignment.php'>
                <input type='hidden' name='assignment_id' value='{$row['assignment_id']}'>
                <input type='date' name='return_date'>
                <select name='return_status'>
                    <option value='Not Returned'>Not Returned</option>
                    <option value='Returned'>Returned</option>
                </select>
                <button type='submit'>Update</button>
            </form>
            <a href='delete_assignment.php?id={$row['assignment_id']}'>Delete</a>
        </td>
    </tr>";
}

// Pagination
echo "<tr><td colspan='7' style='text-align:center;'>";
if ($page > 1) {
    echo "<a href='?tab=assignments&page=" . ($page - 1) . "&search=" . urlencode($search) . "'>Prev</a> ";
}
if ($page < $pages) {
    echo "<a href='?tab=assignments&page=" . ($page + 1) . "&search=" . urlencode($search) . "'>Next</a>";
}
echo "</td></tr>";
