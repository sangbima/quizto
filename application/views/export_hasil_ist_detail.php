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
	
    $objSheet->mergeCells('A1:H1');
	
	$objSheet->mergeCells('A2:B2');							
	$objSheet->mergeCells('A3:B3');							
	$objSheet->mergeCells('A4:B4');							
	$objSheet->mergeCells('A5:B5');								
	
    $objSheet->mergeCells('C2:H2');									
    $objSheet->mergeCells('C3:H3');
    $objSheet->mergeCells('C4:H4');
    $objSheet->mergeCells('C5:H5');	
	
    /* Bagian Detail Peserta */   	
    $objSheet->SetCellValue('A1', 'DETAIL PESERTA');			   
    $objSheet->SetCellValue('A2', 'No. Peserta');
    $objSheet->SetCellValue('A3', 'Fullname');
    $objSheet->SetCellValue('A4', 'Email');	
    $objSheet->SetCellValue('A5', 'Telephone');
 
    $objSheet->SetCellValue('C2', $user['registration_no']);
    $objSheet->SetCellValue('C3', $user['first_name'] . ' ' . $user['last_name']);
    $objSheet->SetCellValue('C4', $user['email']);	
	$objSheet->SetCellValue('C5', $user['contact_no']);	

													
    //$objSheet->getColumnDimension('A')->setAutoSize(true);	
	//$objSheet->getColumnDimension('B')->setAutoSize(true);	
	
	
	
	$objSheet->getStyle('A1:A5')->getFont()->setBold(true);
    $objSheet->getStyle('A1:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$objSheet->getStyle('A1')->getFont()->setSize(14);	
	$objSheet->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
	
	
		
	//--- IST INTELEGENCY
	$objSheet->mergeCells('A7:H7');
    $objSheet->mergeCells('A8:B9');
    $objSheet->mergeCells('C8:E9');
	$objSheet->mergeCells('F8:G8');
	$objSheet->mergeCells('H8:J9');
	
    $objSheet->SetCellValue('A7', 'IST (INTELLEGENCY)');		
    $objSheet->SetCellValue('A8', 'SUB TEST');	
    $objSheet->SetCellValue('C8', 'ASPECT');
    $objSheet->SetCellValue('F8', 'SCORE');
    $objSheet->SetCellValue('F9', 'RS');
    $objSheet->SetCellValue('I9', 'WS');
    $objSheet->SetCellValue('H8', 'NORMA');
	
	$ist1=$this->norma_model->norma_convert('ist1', $result['ist1']);
	$ist2=$this->norma_model->norma_convert('ist2', $result['ist2']);
	$ist3=$this->norma_model->norma_convert('ist3', $result['ist3']);
	$ist4=$this->norma_model->norma_convert('ist4', $result['ist4']);
	$ist5=$this->norma_model->norma_convert('ist5', $result['ist5']);
	$ist6=$this->norma_model->norma_convert('ist6', $result['ist6']);
	$ist7=$this->norma_model->norma_convert('ist7', $result['ist7']);
	$ist8=$this->norma_model->norma_convert('ist8', $result['ist8']);
	$ist9=$this->norma_model->norma_convert('ist9', $result['ist9']);

    $ist_data=array('SE'=>array('aspect'=>'Decision Making','RS'=> $result['ist1'],'WS'=>$ist1['ws'],'norma'=> $this->norma_model->norma_flag($ist1['flag'])),
	              'WE'=>array('aspect'=>'Verbal Reasoning','RS'=> $result['ist2'],'WS'=>$ist2['ws'],'norma'=> $this->norma_model->norma_flag($ist2['flag'])),
                  'AN'=>array('aspect'=>'Creativity','RS'=> $result['ist3'],'WS'=>$ist3['ws'],'norma'=> $this->norma_model->norma_flag($ist3['flag'])),    
				  'GE'=>array('aspect'=>'Abstract Reasoning','RS'=> $result['ist4'],'WS'=>$ist4['ws'],'norma'=> $this->norma_model->norma_flag($ist4['flag'])),
				  'RA'=>array('aspect'=>'Numerical Reasoning','RS'=> $result['ist5'],'WS'=>$ist5['ws'],'norma'=> $this->norma_model->norma_flag($ist5['flag'])),
				  'ZR'=>array('aspect'=>'Analogical Thinking','RS'=> $result['ist6'],'WS'=>$ist6['ws'],'norma'=> $this->norma_model->norma_flag($ist6['flag'])),
				  'FA'=>array('aspect'=>'Synthetical Thinking','RS'=> $result['ist7'],'WS'=>$ist7['ws'],'norma'=> $this->norma_model->norma_flag($ist7['flag'])),
				  'WU'=>array('aspect'=>'Analithical Thinking','RS'=> $result['ist8'],'WS'=>$ist8['ws'],'norma'=> $this->norma_model->norma_flag($ist8['flag'])),
				  'ME'=>array('aspect'=>'Memorial Reasoning','RS'=> $result['ist9'],'WS'=>$ist8['ws'],'norma'=> $this->norma_model->norma_flag($ist9['flag'])),				  
				  'JUMLAH'=>array('aspect'=>'IQ',
				                  'RS'=>$result['total'],
				                  'WS'=>$this->norma_model->norma_iq_score($result['total']),
								  'norma'=>$this->norma_model->norma_iq($result['total']))
                  );

    $irow=10;
    foreach($ist_data as $ikey=>$ival) {
       $objSheet->mergeCells('A' . $irow . ':' . 'B' . $irow);		
	   $objSheet->mergeCells('C' . $irow . ':' . 'E' . $irow);	
	   $objSheet->mergeCells('H' . $irow . ':' . 'J' . $irow);		   
	   
	   $objSheet->SetCellValue('A' . $irow, $ikey);
	   $objSheet->SetCellValue('C' . $irow, $ival['aspect']);
	   $objSheet->SetCellValue('F' . $irow, $ival['RS']);
	   $objSheet->SetCellValue('G' . $irow, $ival['WS']);
	   $objSheet->SetCellValue('H' . $irow, $ival['norma']);	   	   
	   ++$irow;
	}	
								  				
	$objSheet->getStyle('A7:J9')->getFont()->setBold(true);
	$objSheet->getStyle('A10:A18')->getFont()->setBold(true);
	$objSheet->getStyle('A19:J19')->getFont()->setBold(true);
	
    $objSheet->getStyle('A8:J9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
    $objSheet->getStyle('A10:A19')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	

	$objSheet->getStyle('A7')->getFont()->setSize(14);	
	$objSheet->getStyle('A7:O7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');


	$objSheet->getStyle('O1')->getFont()->setBold(true);
	
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