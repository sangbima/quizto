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
		   $objSheet->SetCellValue('B' . $c_row, $value['mscale']['value']);
		   $objSheet->SetCellValue('C' . $c_row, $value['lscale']['value']);
		   $objSheet->SetCellValue('D' . $c_row, $value['cscale']['value']);
		   $objSheet->SetCellValue('E' . $c_row, $value['group_name']);		   		   
		   $objSheet->SetCellValue('F' . $c_row, $value['created_by_name']);
		   $objSheet->SetCellValue('G' . $c_row, $value['kabupatenkota']);		   		   
		   $objSheet->SetCellValue('H' . $c_row, $value['provinsi']);		   						   
    		   
	}		
										
    $objSheet->getColumnDimension('A')->setAutoSize(true);	
	$objSheet->getColumnDimension('B')->setAutoSize(true);	
	$objSheet->getColumnDimension('C')->setAutoSize(true);	
    $objSheet->getColumnDimension('D')->setAutoSize(true);	

    $objSheet->getColumnDimension('E')->setAutoSize(true);	
	$objSheet->getColumnDimension('F')->setAutoSize(true);	
	$objSheet->getColumnDimension('G')->setAutoSize(true);	
    $objSheet->getColumnDimension('H')->setAutoSize(true);		
	
	
	$objSheet->getStyle('A1:I1')->getFont()->setBold(true);	
	$objSheet->getStyle('A1:I1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
	
	$objSheet->getStyle('I1')->getFont()->setBold(true);
	
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