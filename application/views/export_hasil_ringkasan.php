<?php
	require_once ('application/third_party/PHPExcel.php');
    require_once ('application/third_party/PHPExcel/Writer/Excel2007.php');
    
	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Kemendikbud");
	$objPHPExcel->getProperties()->setLastModifiedBy("Kemendikbud");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

	$objPHPExcel->setActiveSheetIndex(0);
										
    foreach($header as $key=>$value) {
				$objPHPExcel->getActiveSheet()->SetCellValue($key. '1', $value);				
	}	
	
	foreach($result as $key=>$value) {
		   $c_row=$key+2;
		   $objPHPExcel->getActiveSheet()->SetCellValue('A' . $c_row, $value['fullname']);			   
		   $objPHPExcel->getActiveSheet()->SetCellValue('B' . $c_row, $value['ist1'] ? $value['ist1'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('C' . $c_row, $value['ist2'] ? $value['ist2'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('D' . $c_row, $value['ist3'] ? $value['ist3'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('E' . $c_row, $value['ist4'] ? $value['ist4'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('F' . $c_row, $value['ist5'] ? $value['ist5'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('G' . $c_row, $value['ist6'] ? $value['ist6'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('H' . $c_row, $value['ist7'] ? $value['ist7'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('I' . $c_row, $value['ist8'] ? $value['ist8'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('J' . $c_row, $value['ist9'] ? $value['ist9'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('K' . $c_row, $value['ist10'] ? $value['ist10'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('L' . $c_row, $value['ist11'] ? $value['ist11'] : 0);
		   $objPHPExcel->getActiveSheet()->SetCellValue('M' . $c_row, $value['total']);
	}		
										
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
	$objPHPExcel->getActiveSheet()->getStyle('A1:M1')->getFont()->setBold(true);
	
	$objPHPExcel->getActiveSheet()->setTitle($title);
		
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 				
	ob_start();
	$objWriter->save('php://output');
	$excelOutput = ob_get_clean();

	//$filename = "hasil_ringkasan_" . date('Ymd') . ".xlsx";
		
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo $excelOutput;
				
?>