<?php
include 'db.php';

$stmt = $pdo->query("
    SELECT h.*, u.username, e.equipment_name
    FROM equipment_history h
    JOIN users u ON h.user_id = u.user_id
    JOIN equipments e ON h.equipment_id = e.equipment_id
    ORDER BY h.timestamp DESC
");
?>

<table border="1">
    <thead>
        <tr>
            <th>Equipment</th>
            <th>User</th>
            <th>Date Issued</th>
            <th>Return Date</th>
            <th>Condition</th>
            <th>Action</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $stmt->fetch()): ?>
            <tr>
                <td><?= htmlspecialchars($row['equipment_name']) ?></td>
                <td><?= htmlspecialchars($row['username']) ?></td>
                <td><?= $row['date_issued'] ?></td>
                <td><?= $row['return_date'] ?? '—' ?></td>
                <td><?= htmlspecialchars($row['return_condition'] ?? '—') ?></td>
                <td><?= $row['action'] ?></td>
                <td><?= $row['timestamp'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>