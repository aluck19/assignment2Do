<?php
require_once ("../../includes/initialize.php");
?>
<?php
require_once ("../../includes/PHPExcel.php");
?>
<?php

$objPHPExcel = new PHPExcel();

$query = "SELECT * FROM users";

$result = mysql_query($query) or die(mysql_error());

$objPHPExcel -> getProperties() -> setCreator("Donor tracking System") -> setLastModifiedBy("DTS") -> setTitle("All members") -> setSubject("Office 2007 XLSX Test Document") -> setDescription("All Members, generated using PHP classes.") -> setKeywords("office 2007 openxml php") -> setCategory("Test result file");

// Set the active Excel worksheet to sheet 0
$objPHPExcel -> setActiveSheetIndex(0);
// Initialise the Excel row number
$rowCount = 1;

$customTitle = array('Username', 'First Name', 'Last Name', 'Role', 'Email Address');

$objPHPExcel -> getActiveSheet() -> SetCellValue('A' . $rowCount, $customTitle[0]);
$objPHPExcel -> getActiveSheet() -> SetCellValue('B' . $rowCount, $customTitle[1]);
$objPHPExcel -> getActiveSheet() -> SetCellValue('C' . $rowCount, $customTitle[2]);
$objPHPExcel -> getActiveSheet() -> SetCellValue('D' . $rowCount, $customTitle[3]);
$objPHPExcel -> getActiveSheet() -> SetCellValue('E' . $rowCount, $customTitle[4]);

$objPHPExcel -> getActiveSheet() -> getStyle("A1") -> getFont() -> setBold(true);
$objPHPExcel -> getActiveSheet() -> getStyle("B1") -> getFont() -> setBold(true);
$objPHPExcel -> getActiveSheet() -> getStyle("C1") -> getFont() -> setBold(true);
$objPHPExcel -> getActiveSheet() -> getStyle("D1") -> getFont() -> setBold(true);
$objPHPExcel -> getActiveSheet() -> getStyle("E1") -> getFont() -> setBold(true);
$rowCount++;

while ($row = mysql_fetch_array($result)) {
	$objPHPExcel -> getActiveSheet() -> setTitle('Report');
	$objPHPExcel -> getActiveSheet() -> SetCellValue('A' . $rowCount, $row['username']);
	$objPHPExcel -> getActiveSheet() -> SetCellValue('B' . $rowCount, $row['first_name']);
	$objPHPExcel -> getActiveSheet() -> SetCellValue('C' . $rowCount, $row['last_name']);
	$objPHPExcel -> getActiveSheet() -> SetCellValue('D' . $rowCount, $row['role']);
	$objPHPExcel -> getActiveSheet() -> SetCellValue('E' . $rowCount, $row['email_id']);
	$rowCount++;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
$objWriter -> save('php://output');
?>
