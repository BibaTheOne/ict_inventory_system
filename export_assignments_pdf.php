<?php
require 'vendor/autoload.php';

use Dompdf\Dompdf;

include 'db.php';

$stmt = $pdo->query("
    SELECT a.*, u.username, e.equipment_name
    FROM assignments a
    JOIN users u ON a.user_id = u.user_id
    JOIN equipments e ON a.equipment_id = e.equipment_id
");

$html = "<h2>Assignment List</h2><table border='1' cellpadding='5'><thead><tr>
<th>ID</th><th>Equipment</th><th>User</th><th>Issued</th><th>Status</th><th>Return Date</th></tr></thead><tbody>";

foreach ($stmt as $row) {
    $html .= "<tr>
        <td>{$row['assignment_id']}</td>
        <td>{$row['equipment_name']}</td>
        <td>{$row['username']}</td>
        <td>{$row['date_issued']}</td>
        <td>{$row['return_status']}</td>
        <td>" . ($row['return_date'] ?? '—') . "</td>
    </tr>";
}
$html .= "</tbody></table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream("assignments.pdf");
