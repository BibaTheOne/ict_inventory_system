<?php
include 'db.php';

$stmt = $pdo->query("
    SELECT a.assignment_id, a.equipment_id, a.user_id, a.date_issued, a.return_status, a.return_date,
           u.username, e.equipment_name
    FROM assignments a
    JOIN users u ON a.user_id = u.user_id
    JOIN equipments e ON a.equipment_id = e.equipment_id
    ORDER BY a.assignment_id DESC
");

foreach ($stmt as $row) {
    echo "<tr>";
    echo "<td>{$row['assignment_id']}</td>";
    echo "<td>{$row['equipment_id']}<br><small>{$row['equipment_name']}</small></td>";
    echo "<td>{$row['user_id']}<br><small>{$row['username']}</small></td>";
    echo "<td>{$row['date_issued']}</td>";
    echo "<td>{$row['return_status']}</td>";
    echo "<td>" . ($row['return_date'] ?? 'N/A') . "</td>";
    echo "<td>
        <button onclick=\"editAssignmentModal(
            {$row['assignment_id']}, 
            '{$row['return_status']}', 
            '{$row['return_date']}', 
            '')\">Edit</button>
    </td>";
    echo "</tr>";
}
