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
		   $objPHPExcel->getActiveSheet()->SetCellValue('B' . $c_row, $value['mscale']['value']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('C' . $c_row, $value['lscale']['value']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('D' . $c_row, $value['cscale']['value']);
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