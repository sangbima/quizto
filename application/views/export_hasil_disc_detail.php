<?php
	require_once ('application/third_party/PHPExcel.php');
    require_once ('application/third_party/PHPExcel/Writer/Excel2007.php');
    
	$objPHPExcel = new PHPExcel();

	$objPHPExcel->getProperties()->setCreator("Kemendikbud");
	$objPHPExcel->getProperties()->setLastModifiedBy("Kemendikbud");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");
	
   		
	$DataSheetTitle	= 'DATA GRAPH';
	$objPHPExcel->createSheet(0);	
	$objPHPExcel->setActiveSheetIndex(1);
	$objSheetDataGraph=$objPHPExcel->getActiveSheet();
    $objSheetDataGraph->setTitle($DataSheetTitle);
	
				
	$objPHPExcel->setActiveSheetIndex(0);
	$objSheet=$objPHPExcel->getActiveSheet();
	//$title="Ringkasan Hasil";
	$objSheet->setTitle($title);		
	
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

													
    //$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);	
	//$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);	
	$objSheet->getStyle('A1:A5')->getFont()->setBold(true);
    $objSheet->getStyle('A1:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
    $objSheet->getStyle('A1')->getFont()->setSize(14);	
	$objSheet->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');	



    // --- DISC PROFILE
	
   	$objSheet->mergeCells('A7:H7');
	$objSheet->mergeCells('A8:B8');

    $objSheet->SetCellValue('A7', 'DISC PROFILE');		
    $objSheet->SetCellValue('A8', '');	
	$objSheet->SetCellValue('C8', 'D');	
	$objSheet->SetCellValue('D8', 'I');	
	$objSheet->SetCellValue('E8', 'S');	
	$objSheet->SetCellValue('F8', 'C');	
	$objSheet->SetCellValue('G8', 'x');		
	$objSheet->SetCellValue('H8', 'SUM');	
	
	$disc_data=array('MOST'=>array('D'=>$disc_m['d'],'I'=>$disc_m['i'],'S'=>$disc_m['s'],'C'=>$disc_m['c'],'X'=>$disc_m['x'],'SUM'=>$disc_m['t']),
	                 'LEAST'=>array('D'=>$disc_l['d'],'I'=>$disc_l['i'],'S'=>$disc_l['s'],'C'=>$disc_l['c'],'X'=>$disc_l['x'],'SUM'=>$disc_l['t']),
	                 'CHANGE'=>array('D'=>$disc_m['d'] - $disc_l['d'],
					                 'I'=>$disc_m['i'] - $disc_l['i'],
									 'S'=>$disc_m['s'] - $disc_l['s'],
									 'C'=>$disc_m['c'] - $disc_l['c'],
									 'X'=>$disc_m['x'] - $disc_l['x'],
									 'SUM'=>'')
					 );
	
	$drow=9;
	foreach($disc_data as $dkey=>$dval) {
         $objSheet->mergeCells('A' . $drow . ':' . 'B' . $drow);				
	     $objSheet->SetCellValue('A' . $drow, $dkey);
	     $objSheet->SetCellValue('C' . $drow, $dval['D']);		
	     $objSheet->SetCellValue('D' . $drow, $dval['I']);		
	     $objSheet->SetCellValue('E' . $drow, $dval['S']);		
	     $objSheet->SetCellValue('F' . $drow, $dval['C']);		
	     $objSheet->SetCellValue('G' . $drow, $dval['X']);		
	     $objSheet->SetCellValue('H' . $drow, $dval['SUM']);
       ++$drow;		 
	} 	

    $objSheet->getStyle('C8:H11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
    $objSheet->getStyle('A7:A11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
	
	$objSheet->getStyle('A7:H7')->getFont()->setBold(true);
	$objSheet->getStyle('A9:B11')->getFont()->setBold(true);

    $objSheet->getStyle('A7')->getFont()->setSize(14);	
	$objSheet->getStyle('A7:O7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
	
	
	
    //---- MOST GRAPH

	
  $objSheet->mergeCells('A13:H13');		
  $objSheet->mergeCells('A14:F26');	
  
  $objSheet->SetCellValue('A13', 'MOST GRAPH');		
  $objSheet->getStyle('A13:H13')->getFont()->setBold(true);
  
  $data_m = array(array('h'=>$mscale['label'][0],
                      'v'=>$mscale['data'][0]),                                   					  
                array('h'=>$mscale['label'][1], 
				      'v'=>$mscale['data'][1]),
				array('h'=>$mscale['label'][2], 
				      'v'=>$mscale['data'][2]),
				array('h'=>$mscale['label'][3], 
				      'v'=>$mscale['data'][3]));
		
  $row = 14;
  foreach($data_m as $point_m) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_m['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_m['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C14' , $mscale['value']);	    
		
  $categories_m = new PHPExcel_Chart_DataSeriesValues('String', "'"  . $DataSheetTitle . "'" .  '!$A$14:$A$17');
  $values_m = new PHPExcel_Chart_DataSeriesValues('Number', "'"  . $DataSheetTitle . "'" . '!$B$14:$B$17');
  $label_m = new PHPExcel_Chart_DataSeriesValues('String', "'"  . $DataSheetTitle . "'" . '!$C$14:$C$17');

  $series_m = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_LINECHART,       // plotType
    PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
    array(0),                                       // plotOrder
    array($label_m),                                  // plotLabel
    array($categories_m),                             // plotCategory
    array($values_m)                                  // plotValues
  );
  $series_m->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);

  $layout_m = new PHPExcel_Chart_Layout();
  $plotarea_m = new PHPExcel_Chart_PlotArea($layout_m, array($series_m));
  $xTitle_m = new PHPExcel_Chart_Title('xAxisLabel');
  $yTitle_m = new PHPExcel_Chart_Title('yAxisLabel');
  //$xTitle_m = new PHPExcel_Chart_Title('');
  //$yTitle_m = new PHPExcel_Chart_Title('');
  $legend_m = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOP, NULL, false);

  //$chart_m = new PHPExcel_Chart('most_graph', null, $legend_m, $plotarea_m, true,0,$xTitle_m,$yTitle_m);
  $chart_m = new PHPExcel_Chart('most_graph', null, $legend_m, $plotarea_m, true,0,NULL,NULL);

  $chart_m->setTopLeftPosition('A14');
  $chart_m->setBottomRightPosition('F26');

  $objSheet->addChart($chart_m);	


  //--- MOST NORMA
  
  $objSheet->mergeCells('G14:H16');	
  $objSheet->mergeCells('G17:H19');	 
  $objSheet->mergeCells('G20:H22');	
  $objSheet->mergeCells('G23:H26');	
  
  $objSheet->mergeCells('I14:O16');	
  $objSheet->mergeCells('I17:O19');	
  $objSheet->mergeCells('I20:O22');	
  $objSheet->mergeCells('I23:O26');	
  
  $objSheet->getStyle('G14:O26')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G14:O26')->getAlignment()->setWrapText(true);   
  
  $mhtml = str_replace('<strong>','',$mscale['norma']);
  $mhtml = str_replace('</strong>','',$mhtml);
  $mhtml = str_replace('</p>','',$mhtml);
  $mhtml = str_replace('<p>','|',$mhtml);
  
  $mfetch = explode('|',$mhtml);
  $m_norma = array('tipe'=>$mfetch[2],
                   'kelebihan'=>$mfetch[4],
				   'kekurangan'=>$mfetch[6],
				   'posisi'=>$mfetch[8]);
  
   $objSheet->SetCellValue('G14', $mscale['value']);
   $objSheet->SetCellValue('I14', $m_norma['tipe']);

   $objSheet->SetCellValue('G17', "Kelebihan");
   $objSheet->SetCellValue('I17', $m_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G20', "Kekurangan");
    $objSheet->SetCellValue('I20', $m_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G23', "Posisi yang sesuai");
    $objSheet->SetCellValue('I23', $m_norma['posisi']);  

    $objSheet->getStyle('G14:G26')->getFont()->setBold(true);	
	
	


   //---- LEAST GRAPH
	
  $objSheet->mergeCells('A28:H28');		
  $objSheet->mergeCells('A29:F41');	
  
  $objSheet->SetCellValue('A28', 'LEAST GRAPH');		
  $objSheet->getStyle('A28:H28')->getFont()->setBold(true);
  
  $data_l = array(array('h'=>$lscale['label'][0],
                      'v'=>$lscale['data'][0]),                                   					  
                array('h'=>$lscale['label'][1], 
				      'v'=>$lscale['data'][1]),
				array('h'=>$lscale['label'][2], 
				      'v'=>$lscale['data'][2]),
				array('h'=>$lscale['label'][3], 
				      'v'=>$lscale['data'][3]));
		
  $row = 29;
  foreach($data_l as $point_l) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_l['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_l['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C29' , $lscale['value']);	    
		
  $categories_l = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$A$29:$A$32');
  $values_l = new PHPExcel_Chart_DataSeriesValues('Number', "'" .$DataSheetTitle . "'" .  '!$B$29:$B$32');
  $label_l = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$C$29:$C$32');

  $series_l = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_LINECHART,       // plotType
    PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
    array(0),                                       // plotOrder
    array($label_l),                                  // plotLabel
    array($categories_l),                             // plotCategory
    array($values_l)                                  // plotValues
  );
  $series_l->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);

  $layout_l = new PHPExcel_Chart_Layout();
  $plotarea_l = new PHPExcel_Chart_PlotArea($layout_l, array($series_l));
  $xTitle_l = new PHPExcel_Chart_Title('xAxisLabel');
  $yTitle_l = new PHPExcel_Chart_Title('yAxisLabel');
  //$xTitle_l = new PHPExcel_Chart_Title('');
  //$yTitle_l = new PHPExcel_Chart_Title('');
  $legend_l = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOP, NULL, false);

  //$chart_l = new PHPExcel_Chart('most_graph', null, $legend_l, $plotarea_l, true,0,$xTitle_l,$yTitle_l);
  $chart_l = new PHPExcel_Chart('most_graph', null, $legend_l, $plotarea_l, true,0,NULL,NULL);

  $chart_l->setTopLeftPosition('A29');
  $chart_l->setBottomRightPosition('F41');

  $objSheet->addChart($chart_l);


  //--- LEAST NORMA
  
  $objSheet->mergeCells('G29:H31');	
  $objSheet->mergeCells('G32:H34');	 
  $objSheet->mergeCells('G35:H37');	
  $objSheet->mergeCells('G38:H41');	
  
  $objSheet->mergeCells('I29:O31');	
  $objSheet->mergeCells('I32:O34');	
  $objSheet->mergeCells('I35:O37');	
  $objSheet->mergeCells('I38:O41');	
  
  $objSheet->getStyle('G29:O41')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G29:O41')->getAlignment()->setWrapText(true);   
  
  $lhtml = str_replace('<strong>','',$lscale['norma']);
  $lhtml = str_replace('</strong>','',$lhtml);
  $lhtml = str_replace('</p>','',$lhtml);
  $lhtml = str_replace('<p>','|',$lhtml);
  
  $lfetch = explode('|',$lhtml);
  $l_norma = array('tipe'=>$lfetch[2],
                   'kelebihan'=>$lfetch[4],
				   'kekurangan'=>$lfetch[6],
				   'posisi'=>$lfetch[8]);
  
   $objSheet->SetCellValue('G29', $lscale['value']);
   $objSheet->SetCellValue('I29', $l_norma['tipe']);

   $objSheet->SetCellValue('G32', "Kelebihan");
   $objSheet->SetCellValue('I32', $l_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G35', "Kekurangan");
    $objSheet->SetCellValue('I35', $l_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G38', "Posisi yang sesuai");
    $objSheet->SetCellValue('I38', $l_norma['posisi']);  

    $objSheet->getStyle('G29:G41')->getFont()->setBold(true);	

	
	
	

   //---- CHANGE GRAPH
	
  $objSheet->mergeCells('A43:H43');		
  $objSheet->mergeCells('A44:F56');	
  
  $objSheet->SetCellValue('A43', 'CHANGE GRAPH');		
  $objSheet->getStyle('A43:H43')->getFont()->setBold(true);
  
  $data_c = array(array('h'=>$cscale['label'][0],
                      'v'=>$cscale['data'][0]),                                   					  
                array('h'=>$cscale['label'][1], 
				      'v'=>$cscale['data'][1]),
				array('h'=>$cscale['label'][2], 
				      'v'=>$cscale['data'][2]),
				array('h'=>$cscale['label'][3], 
				      'v'=>$cscale['data'][3]));
		
  $row = 44;
  foreach($data_c as $point_c) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_c['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_c['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C44' , $cscale['value']);	    
		
  $categories_c = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$A$44:$A$47');
  $values_c = new PHPExcel_Chart_DataSeriesValues('Number', "'" .$DataSheetTitle . "'" .  '!$B$44:$B$47');
  $label_c = new PHPExcel_Chart_DataSeriesValues('String', "'" .$DataSheetTitle . "'" .  '!$C$44:$C$47');

  $series_c = new PHPExcel_Chart_DataSeries(
    PHPExcel_Chart_DataSeries::TYPE_LINECHART,       // plotType
    PHPExcel_Chart_DataSeries::GROUPING_CLUSTERED,  // plotGrouping
    array(0),                                       // plotOrder
    array($label_c),                                  // plotLabel
    array($categories_c),                             // plotCategory
    array($values_c)                                  // plotValues
  );
  $series_c->setPlotDirection(PHPExcel_Chart_DataSeries::DIRECTION_VERTICAL);

  $layout_c = new PHPExcel_Chart_Layout();
  $plotarea_c = new PHPExcel_Chart_PlotArea($layout_c, array($series_c));
  $xTitle_c = new PHPExcel_Chart_Title('xAxisLabel');
  $yTitle_c = new PHPExcel_Chart_Title('yAxisLabel');
  //$xTitle_c = new PHPExcel_Chart_Title('');
  //$yTitle_c = new PHPExcel_Chart_Title('');
  $legend_c = new PHPExcel_Chart_Legend(PHPExcel_Chart_Legend::POSITION_TOP, NULL, false);

  //$chart_c = new PHPExcel_Chart('most_graph', null, $legend_c, $plotarea_c, true,0,$xTitle_c,$yTitle_c);
  $chart_c = new PHPExcel_Chart('most_graph', null, $legend_c, $plotarea_c, true,0,NULL,NULL);

  $chart_c->setTopLeftPosition('A44');
  $chart_c->setBottomRightPosition('F56');

  $objSheet->addChart($chart_c);


  //--- CHANGE NORMA
  
  $objSheet->mergeCells('G44:H46');	
  $objSheet->mergeCells('G47:H49');	 
  $objSheet->mergeCells('G50:H52');	
  $objSheet->mergeCells('G53:H56');	
  
  $objSheet->mergeCells('I44:O46');	
  $objSheet->mergeCells('I47:O49');	
  $objSheet->mergeCells('I50:O52');	
  $objSheet->mergeCells('I53:O56');	
  
  $objSheet->getStyle('G44:O56')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G44:O56')->getAlignment()->setWrapText(true);   
  
  $chtml = str_replace('<strong>','',$cscale['norma']);
  $chtml = str_replace('</strong>','',$chtml);
  $chtml = str_replace('</p>','',$chtml);
  $chtml = str_replace('<p>','|',$chtml);
  
  $cfetch = explode('|',$chtml);
  $c_norma = array('tipe'=>$cfetch[2],
                   'kelebihan'=>$cfetch[4],
				   'kekurangan'=>$cfetch[6],
				   'posisi'=>$cfetch[8]);
  
   $objSheet->SetCellValue('G44', $cscale['value']);
   $objSheet->SetCellValue('I44', $c_norma['tipe']);

   $objSheet->SetCellValue('G47', "Kelebihan");
   $objSheet->SetCellValue('I47', $c_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G50', "Kekurangan");
    $objSheet->SetCellValue('I50', $c_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G53', "Posisi yang sesuai");
    $objSheet->SetCellValue('I53', $c_norma['posisi']);  

    $objSheet->getStyle('G44:G56')->getFont()->setBold(true);

    $objSheet->getStyle('O1')->getFont()->setBold(true);		
	
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');	
    $objWriter->setIncludeCharts(TRUE); 	
	ob_start();
	$objWriter->save('php://output');
	$excelOutput = ob_get_clean();
	
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo $excelOutput;
	
    //var_dump($mscale);	
?>