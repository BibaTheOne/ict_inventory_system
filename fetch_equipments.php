<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM equipments");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
?>
