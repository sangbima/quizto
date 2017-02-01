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
	$objSheet=$objPHPExcel->getActiveSheet();
	
    foreach($header as $key=>$value) {
				$objSheet->SetCellValue($key. '1', $value);				
	}	
	
	foreach($result as $key=>$value) {
		   $c_row=$key+2;
		   $objSheet->SetCellValue('A' . $c_row, $value['fullname']);			   
		   $objSheet->SetCellValue('B' . $c_row, $value['ist1'] ? $value['ist1'] : 0);
		   $objSheet->SetCellValue('C' . $c_row, $value['ist2'] ? $value['ist2'] : 0);
		   $objSheet->SetCellValue('D' . $c_row, $value['ist3'] ? $value['ist3'] : 0);
		   $objSheet->SetCellValue('E' . $c_row, $value['ist4'] ? $value['ist4'] : 0);
		   $objSheet->SetCellValue('F' . $c_row, $value['ist5'] ? $value['ist5'] : 0);
		   $objSheet->SetCellValue('G' . $c_row, $value['ist6'] ? $value['ist6'] : 0);
		   $objSheet->SetCellValue('H' . $c_row, $value['ist7'] ? $value['ist7'] : 0);
		   $objSheet->SetCellValue('I' . $c_row, $value['ist8'] ? $value['ist8'] : 0);
		   $objSheet->SetCellValue('J' . $c_row, $value['ist9'] ? $value['ist9'] : 0);
		   $objSheet->SetCellValue('K' . $c_row, $value['total']);
	}		
										
    $objSheet->getColumnDimension('A')->setAutoSize(true);	
	$objSheet->getStyle('A1:K1')->getFont()->setBold(true);
	
	$objSheet->getStyle('A1:K1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
	
	$objSheet->getStyle('O1')->getFont()->setBold(true);
	
	$objSheet->setTitle($title);
		
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 				
	ob_start();
	$objWriter->save('php://output');
	$excelOutput = ob_get_clean();

	//$filename = "hasil_ist_" . date('Ymd') . ".xlsx";

	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo $excelOutput;
				
?>