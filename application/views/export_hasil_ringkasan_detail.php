<?php
	require_once ('application/third_party/PHPExcel.php');
    require_once ('application/third_party/PHPExcel/Writer/Excel2007.php');
    
	$objPHPExcel = new PHPExcel();
	
   $objPHPExcel->getActiveSheet()->setTitle($title);		
	
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
	
	$objSheet->getStyle('A1')->getFont()->setSize(14);		
	$objSheet->getStyle('A1:A5')->getFont()->setBold(true);
    $objSheet->getStyle('A1:C5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	$objSheet->getStyle('A1:O1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
    
	
	
	//-- TPU / TPA
	
	$objSheet->mergeCells('A7:H7');
	
	$objSheet->SetCellValue('A7', 'TPU/TPA');			   
    $objSheet->SetCellValue('A8', 'TPU');
    $objSheet->SetCellValue('A9', 'TPA');
    $objSheet->SetCellValue('B8', $tputpa['ist1'] ? $tputpa['ist1'] : 0);
    $objSheet->SetCellValue('B9', $tputpa['ist2'] ? $tputpa['ist2'] : 0);	

	$objSheet->getStyle('A7')->getFont()->setSize(14);	
	$objSheet->getStyle('A7:B9')->getFont()->setBold(true);
    $objSheet->getStyle('A7:B9')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);	
    $objSheet->getStyle('A7:O7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
				
	//--- IST INTELEGENCY
	$objSheet->mergeCells('A11:H11');
    $objSheet->mergeCells('A12:B13');
    $objSheet->mergeCells('C12:E13');
	$objSheet->mergeCells('F12:G12');
	$objSheet->mergeCells('H12:J13');
	
    $objSheet->SetCellValue('A11', 'IST (INTELLEGENCY)');		
    $objSheet->SetCellValue('A12', 'SUB TEST');	
    $objSheet->SetCellValue('C12', 'ASPECT');
    $objSheet->SetCellValue('F12', 'SCORE');
    $objSheet->SetCellValue('F13', 'RS');
    $objSheet->SetCellValue('I13', 'WS');
    $objSheet->SetCellValue('H12', 'NORMA');
	
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
    $irow=14;
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

	
    $objSheet->getStyle('A11')->getFont()->setSize(14);	
	
	$objSheet->getStyle('A11:J13')->getFont()->setBold(true);
	$objSheet->getStyle('A14:A22')->getFont()->setBold(true);
	$objSheet->getStyle('A23:J23')->getFont()->setBold(true);
	
    $objSheet->getStyle('A12:J13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
    $objSheet->getStyle('A14:A23')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
    $objSheet->getStyle('A11:O11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');	



    // --- DISC PROFILE
	
   	$objSheet->mergeCells('A25:H25');
	$objSheet->mergeCells('A26:B26');

    $objSheet->SetCellValue('A25', 'DISC PROFILE');		
    $objSheet->SetCellValue('A26', '');	
	$objSheet->SetCellValue('C26', 'D');	
	$objSheet->SetCellValue('D26', 'I');	
	$objSheet->SetCellValue('E26', 'S');	
	$objSheet->SetCellValue('F26', 'C');	
	$objSheet->SetCellValue('G26', 'x');		
	$objSheet->SetCellValue('H26', 'SUM');	
	
	$disc_data=array('MOST'=>array('D'=>$disc_m['d'],'I'=>$disc_m['i'],'S'=>$disc_m['s'],'C'=>$disc_m['c'],'X'=>$disc_m['x'],'SUM'=>$disc_m['t']),
	                 'LEAST'=>array('D'=>$disc_l['d'],'I'=>$disc_l['i'],'S'=>$disc_l['s'],'C'=>$disc_l['c'],'X'=>$disc_l['x'],'SUM'=>$disc_l['t']),
	                 'CHANGE'=>array('D'=>$disc_m['d'] - $disc_l['d'],
					                 'I'=>$disc_m['i'] - $disc_l['i'],
									 'S'=>$disc_m['s'] - $disc_l['s'],
									 'C'=>$disc_m['c'] - $disc_l['c'],
									 'X'=>$disc_m['x'] - $disc_l['x'],
									 'SUM'=>'')
					 );
	
	$drow=27;
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

    $objSheet->getStyle('C26:H29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);	
    $objSheet->getStyle('A25:A29')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
	
		
    $objSheet->getStyle('A25')->getFont()->setSize(14);	
	
	$objSheet->getStyle('A25:H26')->getFont()->setBold(true);
	$objSheet->getStyle('A27:B29')->getFont()->setBold(true);
	
	$objSheet->getStyle('A25:O25')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');	

	
 
	
  //---- MOST GRAPH

	
  $objSheet->mergeCells('A31:H31');		
  $objSheet->mergeCells('A32:F44');	
  
  $objSheet->SetCellValue('A31', 'MOST GRAPH');		
  $objSheet->getStyle('A31:H31')->getFont()->setBold(true);
  
  $data_m = array(array('h'=>$mscale['label'][0],
                      'v'=>$mscale['data'][0]),                                   					  
                array('h'=>$mscale['label'][1], 
				      'v'=>$mscale['data'][1]),
				array('h'=>$mscale['label'][2], 
				      'v'=>$mscale['data'][2]),
				array('h'=>$mscale['label'][3], 
				      'v'=>$mscale['data'][3]));
		
  $row = 32;
  foreach($data_m as $point_m) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_m['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_m['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C32' , $mscale['value']);	    
		
  $categories_m = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$A$32:$A$35');
  $values_m = new PHPExcel_Chart_DataSeriesValues('Number', "'" .$DataSheetTitle . "'" .  '!$B$32:$B$35');
  $label_m = new PHPExcel_Chart_DataSeriesValues('String', "'" .$DataSheetTitle . "'" .  '!$C$32:$C$35');

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

  $chart_m->setTopLeftPosition('A32');
  $chart_m->setBottomRightPosition('F44');

  $objSheet->addChart($chart_m);	
  
  
  
  
    //--- MOST NORMA
  
  $objSheet->mergeCells('G32:H34');	
  $objSheet->mergeCells('G35:H37');	 
  $objSheet->mergeCells('G38:H40');	
  $objSheet->mergeCells('G41:H44');	
  
  $objSheet->mergeCells('I32:O34');	
  $objSheet->mergeCells('I35:O37');	
  $objSheet->mergeCells('I38:O40');	
  $objSheet->mergeCells('I41:O44');	
  
  $objSheet->getStyle('G32:O44')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G32:O44')->getAlignment()->setWrapText(true);   
  
  $mhtml = str_replace('<strong>','',$mscale['norma']);
  $mhtml = str_replace('</strong>','',$mhtml);
  $mhtml = str_replace('</p>','',$mhtml);
  $mhtml = str_replace('<p>','|',$mhtml);
  
  $mfetch = explode('|',$mhtml);
  $m_norma = array('tipe'=>$mfetch[2],
                   'kelebihan'=>$mfetch[4],
				   'kekurangan'=>$mfetch[6],
				   'posisi'=>$mfetch[8]);
  
   $objSheet->SetCellValue('G32', $mscale['value']);
   $objSheet->SetCellValue('I32', $m_norma['tipe']);

   $objSheet->SetCellValue('G35', "Kelebihan");
   $objSheet->SetCellValue('I35', $m_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G38', "Kekurangan");
    $objSheet->SetCellValue('I38', $m_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G41', "Posisi yang sesuai");
    $objSheet->SetCellValue('I41', $m_norma['posisi']);  

    $objSheet->getStyle('G32:G44')->getFont()->setBold(true);	
	
	
	
	//---- LEAST GRAPH
	
  $objSheet->mergeCells('A46:H46');		
  $objSheet->mergeCells('A47:F59');	
  
  $objSheet->SetCellValue('A46', 'LEAST GRAPH');		
  $objSheet->getStyle('A46:H46')->getFont()->setBold(true);
  
  $data_l = array(array('h'=>$lscale['label'][0],
                      'v'=>$lscale['data'][0]),                                   					  
                array('h'=>$lscale['label'][1], 
				      'v'=>$lscale['data'][1]),
				array('h'=>$lscale['label'][2], 
				      'v'=>$lscale['data'][2]),
				array('h'=>$lscale['label'][3], 
				      'v'=>$lscale['data'][3]));
		
  $row = 47;
  foreach($data_l as $point_l) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_l['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_l['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C47' , $lscale['value']);	    
		
  $categories_l = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$A$47:$A$50');
  $values_l = new PHPExcel_Chart_DataSeriesValues('Number', "'" .$DataSheetTitle . "'" .  '!$B$47:$B$50');
  $label_l = new PHPExcel_Chart_DataSeriesValues('String', "'" .$DataSheetTitle . "'" .  '!$C$47:$C$50');

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

  $chart_l->setTopLeftPosition('A47');
  $chart_l->setBottomRightPosition('F59');

  $objSheet->addChart($chart_l);


  //--- LEAST NORMA
  
  $objSheet->mergeCells('G47:H49');	
  $objSheet->mergeCells('G50:H52');	 
  $objSheet->mergeCells('G53:H55');	
  $objSheet->mergeCells('G56:H59');	
  
  $objSheet->mergeCells('I47:O49');	
  $objSheet->mergeCells('I50:O52');	
  $objSheet->mergeCells('I53:O55');	
  $objSheet->mergeCells('I56:O59');	
  
  $objSheet->getStyle('G47:O59')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G47:O59')->getAlignment()->setWrapText(true);   
  
  $lhtml = str_replace('<strong>','',$lscale['norma']);
  $lhtml = str_replace('</strong>','',$lhtml);
  $lhtml = str_replace('</p>','',$lhtml);
  $lhtml = str_replace('<p>','|',$lhtml);
  
  $lfetch = explode('|',$lhtml);
  $l_norma = array('tipe'=>$lfetch[2],
                   'kelebihan'=>$lfetch[4],
				   'kekurangan'=>$lfetch[6],
				   'posisi'=>$lfetch[8]);
  
   $objSheet->SetCellValue('G47', $lscale['value']);
   $objSheet->SetCellValue('I47', $l_norma['tipe']);

   $objSheet->SetCellValue('G50', "Kelebihan");
   $objSheet->SetCellValue('I50', $l_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G53', "Kekurangan");
    $objSheet->SetCellValue('I53', $l_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G56', "Posisi yang sesuai");
    $objSheet->SetCellValue('I56', $l_norma['posisi']);  

    $objSheet->getStyle('G47:G59')->getFont()->setBold(true);	
	
	

   //---- CHANGE GRAPH
	
  $objSheet->mergeCells('A61:H61');		
  $objSheet->mergeCells('A62:F74');	
  
  $objSheet->SetCellValue('A61', 'CHANGE GRAPH');		
  $objSheet->getStyle('A61:H61')->getFont()->setBold(true);
  
  $data_c = array(array('h'=>$cscale['label'][0],
                      'v'=>$cscale['data'][0]),                                   					  
                array('h'=>$cscale['label'][1], 
				      'v'=>$cscale['data'][1]),
				array('h'=>$cscale['label'][2], 
				      'v'=>$cscale['data'][2]),
				array('h'=>$cscale['label'][3], 
				      'v'=>$cscale['data'][3]));
		
  $row = 62;
  foreach($data_c as $point_c) {
    //$objSheet->setCellValueByColumnAndRow(24, $row++, $point);
	$objSheetDataGraph->SetCellValue('A' . $row, $point_c['h']);
	    //$objSheet->setCellValueByColumnAndRow(26, $row++, $point);
	$objSheetDataGraph->SetCellValue('B' . $row++, $point_c['v']);	
  }
  
  $objSheetDataGraph->SetCellValue('C62' , $cscale['value']);	    
		
  $categories_c = new PHPExcel_Chart_DataSeriesValues('String', "'" . $DataSheetTitle . "'" .  '!$A$62:$A$65');
  $values_c = new PHPExcel_Chart_DataSeriesValues('Number', "'" .$DataSheetTitle . "'" .  '!$B$62:$B$65');
  $label_c = new PHPExcel_Chart_DataSeriesValues('String', "'" .$DataSheetTitle . "'" .  '!$C$62:$C$65');

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

  $chart_c->setTopLeftPosition('A62');
  $chart_c->setBottomRightPosition('F74');

  $objSheet->addChart($chart_c);


	
  //--- CHANGE NORMA
  
  $objSheet->mergeCells('G62:H64');	
  $objSheet->mergeCells('G65:H67');	 
  $objSheet->mergeCells('G68:H70');	
  $objSheet->mergeCells('G71:H74');	
  
  $objSheet->mergeCells('I62:O64');	
  $objSheet->mergeCells('I65:O67');	
  $objSheet->mergeCells('I68:O70');	
  $objSheet->mergeCells('I71:O74');	
  
  $objSheet->getStyle('G62:O74')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
  $objSheet->getStyle('G62:O74')->getAlignment()->setWrapText(true);   
  
  $chtml = str_replace('<strong>','',$cscale['norma']);
  $chtml = str_replace('</strong>','',$chtml);
  $chtml = str_replace('</p>','',$chtml);
  $chtml = str_replace('<p>','|',$chtml);
  
  $cfetch = explode('|',$chtml);
  $c_norma = array('tipe'=>$cfetch[2],
                   'kelebihan'=>$cfetch[4],
				   'kekurangan'=>$cfetch[6],
				   'posisi'=>$cfetch[8]);
  
   $objSheet->SetCellValue('G64', $cscale['value']);
   $objSheet->SetCellValue('I64', $c_norma['tipe']);

   $objSheet->SetCellValue('G65', "Kelebihan");
   $objSheet->SetCellValue('I65', $c_norma['kelebihan']);  
   
    $objSheet->SetCellValue('G68', "Kekurangan");
    $objSheet->SetCellValue('I68', $c_norma['kekurangan']);  
	
	$objSheet->SetCellValue('G71', "Posisi yang sesuai");
    $objSheet->SetCellValue('I71', $c_norma['posisi']);  

    $objSheet->getStyle('G62:G74')->getFont()->setBold(true);	


	
	$objSheet->getStyle('O1')->getFont()->setBold(true);
	
	
		
		
	//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);   
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');	
    $objWriter->setIncludeCharts(TRUE); 		
	ob_start();
	$objWriter->save('php://output');
	$excelOutput = ob_get_clean();

	//$filename = "hasil_ringkasan_" . date('Ymd') . ".xlsx";

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');	
	header("Content-Disposition: attachment; filename=\"$filename\"");
	header("Content-Type: application/vnd.ms-excel");
	echo $excelOutput;
				
?>