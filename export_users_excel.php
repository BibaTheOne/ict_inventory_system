<?php
require 'vendor/autoload.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Users");

$sheet->fromArray(['ID', 'Username', 'Phone', 'Email', 'Building', 'Floor', 'Department'], NULL, 'A1');

$stmt = $pdo->query("SELECT * FROM users");
$rowIndex = 2;
while ($row = $stmt->fetch()) {
    $sheet->fromArray([$row['user_id'], $row['username'], $row['phone_number'], $row['email'], $row['building'], $row['floor'], $row['department']], NULL, "A{$rowIndex}");
    $rowIndex++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="users.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
