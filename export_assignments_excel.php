<?php
ob_start();
require 'vendor/autoload.php';
include 'auth.php';
include 'db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$search = $_GET['search'] ?? '';
$params = [];
$sql = "SELECT * FROM assignments";

if ($search !== '') {
    $sql .= " WHERE assigned_to LIKE ? OR department LIKE ? OR equipment LIKE ?";
    $q = "%$search%";
    $params = [$q, $q, $q];
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Assignments');

$sheet->fromArray([
    'Assignment ID',
    'Assigned To',
    'Equipment',
    'Serial Number',
    'Building',
    'Floor',
    'Department',
    'Assigned Date'
], NULL, 'A1');

$rowNum = 2;
foreach ($assignments as $a) {
    $sheet->fromArray([
        $a['assignment_id'],
        $a['assigned_to'],
        $a['equipment'],
        $a['serial_no'],
        $a['building'],
        $a['floor'],
        $a['department'],
        $a['assigned_date']
    ], NULL, "A{$rowNum}");
    $rowNum++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="assignments_export.xlsx"');
header('Cache-Control: max-age=0');

ob_end_clean();
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
