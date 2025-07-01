<?php
include 'db.php';

$type = $_GET['type'] ?? '';
$status = $_GET['status'] ?? '';

$query = "
    SELECT 
        e.equipment_id, 
        e.equipment_type, 
        e.equipment_name, 
        e.serial_no, 
        e.barcode_no,
        u.username,
        a.return_status
    FROM equipments e
    LEFT JOIN assignments a 
        ON e.equipment_id = a.equipment_id 
        AND a.assignment_id = (
            SELECT MAX(assignment_id) 
            FROM assignments 
            WHERE equipment_id = e.equipment_id
        )
    LEFT JOIN users u ON a.user_id = u.user_id
    WHERE 1 = 1
";

$params = [];

if ($type !== '') {
    $query .= " AND e.equipment_type = ?";
    $params[] = $type;
}

if ($status === 'Issued') {
    $query .= " AND a.return_status = 'Not Returned'";
} elseif ($status === 'Returned') {
    $query .= " AND a.return_status = 'Returned'";
}

$query .= " ORDER BY e.equipment_id DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $assignedTo = $row['username'] ?? 'Unassigned';
    $statusText = $row['return_status'] === 'Not Returned' ? 'Issued' : 'Returned';
    $statusClass = $statusText === 'Issued' ? 'not-returned' : 'returned';

    echo "<tr>";
    echo "<td>{$row['equipment_id']}</td>";
    echo "<td>{$row['equipment_type']}</td>";
    echo "<td>{$row['equipment_name']}</td>";
    echo "<td>{$row['serial_no']}</td>";
    echo "<td>{$row['barcode_no']}</td>";
    echo "<td>{$assignedTo}</td>";
    echo "<td><span class='status-badge {$statusClass}'>{$statusText}</span></td>";
    echo "<td>
            <a href='edit_equipment.php?id={$row['equipment_id']}'>Edit</a> | 
            <a href='delete_equipment.php?id={$row['equipment_id']}' onclick='return confirm(\"Are you sure?\")'>Delete</a>
          </td>";
    echo "</tr>";
}
