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
		   $objSheet->SetCellValue('A' . $c_row, $value['registration_no']);
		   $objSheet->SetCellValue('B' . $c_row, $value['fullname']);			   
		   $objSheet->SetCellValue('C' . $c_row, $value['ist1'] ? $value['ist1'] : 0);
		   $objSheet->SetCellValue('D' . $c_row, $value['ist2'] ? $value['ist2'] : 0);
		   $objSheet->SetCellValue('E' . $c_row, $value['ist3'] ? $value['ist3'] : 0);
		   $objSheet->SetCellValue('F' . $c_row, $value['ist4'] ? $value['ist4'] : 0);
		   $objSheet->SetCellValue('G' . $c_row, $value['ist5'] ? $value['ist5'] : 0);
		   $objSheet->SetCellValue('H' . $c_row, $value['ist6'] ? $value['ist6'] : 0);
		   $objSheet->SetCellValue('I' . $c_row, $value['ist7'] ? $value['ist7'] : 0);
		   $objSheet->SetCellValue('J' . $c_row, $value['ist8'] ? $value['ist8'] : 0);
		   $objSheet->SetCellValue('K' . $c_row, $value['ist9'] ? $value['ist9'] : 0);
		   $objSheet->SetCellValue('L' . $c_row, $value['ist10'] ? $value['ist10'] : 0);
		   $objSheet->SetCellValue('M' . $c_row, $value['ist11'] ? $value['ist11'] : 0);
		   $objSheet->SetCellValue('N' . $c_row, $value['total']);
		   $objSheet->SetCellValue('O' . $c_row, $value['group_name']);		   		   
		   $objSheet->SetCellValue('P' . $c_row, $value['created_by_name']);
		   $objSheet->SetCellValue('Q' . $c_row, $value['kabupatenkota']);
		   $objSheet->SetCellValue('R' . $c_row, $value['provinsi']);		   
		   
	}		
										
    $objSheet->getColumnDimension('A')->setAutoSize(true);	
	$objSheet->getColumnDimension('N')->setAutoSize(true);
	$objSheet->getColumnDimension('O')->setAutoSize(true);
	$objSheet->getColumnDimension('P')->setAutoSize(true);
	$objSheet->getColumnDimension('R')->setAutoSize(true);
	$objSheet->getStyle('A1:R1')->getFont()->setBold(true);
		
	$objSheet->getStyle('A1:R1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
	
	$objSheet->getStyle('R1')->getFont()->setBold(true);
	
	$objSheet->setTitle($title);
		
	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 				
	ob_start();
	$objWriter->save('php://output');
	$excelOutput = ob_get_clean();

	//$filename = "hasil_ringkasan_" . date('Ymd') . ".xlsx";
		
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo $excelOutput;
				
?>