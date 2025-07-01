<?php
require 'vendor/autoload.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle("Equipments");

$sheet->fromArray(['ID', 'Type', 'Name', 'Serial No', 'Barcode No'], NULL, 'A1');

$stmt = $pdo->query("SELECT * FROM equipments");
$rowIndex = 2;
while ($row = $stmt->fetch()) {
    $sheet->fromArray([$row['equipment_id'], $row['equipment_type'], $row['equipment_name'], $row['serial_no'], $row['barcode_no']], NULL, "A{$rowIndex}");
    $rowIndex++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="equipments.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
