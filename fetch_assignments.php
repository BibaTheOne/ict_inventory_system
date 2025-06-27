<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM assignments");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
                    <input type='date' name='return_date' placeholder='Return Date'>
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
?>
