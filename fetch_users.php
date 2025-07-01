<?php
include 'db.php';
$stmt = $pdo->query("SELECT * FROM users ORDER BY user_id DESC");

foreach ($stmt as $row) {
    echo "<tr>";
    echo "<td>{$row['user_id']}</td>";
    echo "<td>{$row['username']}</td>";
    echo "<td>{$row['phone_number']}</td>";
    echo "<td>{$row['email']}</td>";
    echo "<td>{$row['building']}</td>";
    echo "<td>{$row['floor']}</td>";
    echo "<td>{$row['department']}</td>";
    echo "<td>
        <form action='delete_user.php' method='POST' onsubmit='return confirm(\"Are you sure?\");'>
            <input type='hidden' name='user_id' value='{$row['user_id']}' />
            <button type='submit'>Delete</button>
        </form>
    </td>";
    echo "</tr>";
}
