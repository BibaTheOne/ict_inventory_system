<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM users");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
?>
