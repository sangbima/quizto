<?php
Class Register_model extends CI_Model
{
    function insertdata()
    {
        $userdata = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'registration_no' => $this->generateRegistrationNumber(),
            'password' => $this->input->post('password'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => date('Y-m-d', strtotime($this->input->post('tanggal_lahir'))),
            'email' => $this->input->post('email'),
            'nik' => $this->input->post('nik'),
            'alamat' => $this->input->post('alamat'),
            'desakelurahan' => $this->input->post('desakelurahan'),
            'kecamatan' => $this->input->post('kecamatan'),
            'kabupatenkota' => $this->input->post('kabupatenkota'),
            'provinsi' => $this->input->post('provinsi'),
            'contact_no' => $this->input->post('contact_no'),
            'instansi_name' => $this->input->post('instansi_name'),
            'bagian' => $this->input->post('bagian'),
            'alamat_instansi' => $this->input->post('alamat_instansi'),
            'thn_mengabdi' => $this->input->post('thn_mengabdi'),
            'jabatan' => $this->input->post('jabatan'),
            'jobdesk' => $this->input->post('jobdesk'),
            'pendidikan' => $this->input->post('pendidikan'),
            'institusi_pendidikan' => $this->input->post('institusi_pendidikan'),
            'fakultas' => $this->input->post('fakultas'),
            'no_ijazah' => $this->input->post('no_ijazah'),
            'nilai_ipk' => $this->input->post('nilai_ipk'),
        );
       
	   
        if($this->config->item('protocol')=="smtp"){
            $config = array();
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $this->config->item('smtp_hostname');
            $config['smtp_user'] = $this->config->item('smtp_username');
            $config['smtp_pass'] = $this->config->item('smtp_password');
            $config['smtp_port'] = $this->config->item('smtp_port');
            $config['smtp_timeout'] = $this->config->item('smtp_timeout');
            $config['mailtype'] = $this->config->item('smtp_mailtype');
            $config['starttls']  = $this->config->item('starttls');
            $config['newline']  = $this->config->item('newline');
            
            $this->email->initialize($config);
        }

        $fromemail = $this->config->item('fromemail');
        $fromname = $this->config->item('fromname');
        $subject = $this->config->item('email_subject');
        $message = $this->config->item('email_message');
        
        $message = str_replace('[registration_no]', $userdata['registration_no'], $message);
        $message = str_replace('[password]', $userdata['password'], $message);

        $toemail = $this->input->post('email');

        $this->email->to($toemail);
        $this->email->from($fromemail, $fromname);
        $this->email->subject($subject);
        $this->email->message($message);
		
	    								    
		
        if(!$this->email->send()){
            print_r($this->email->print_debugger());
            exit;
        } else {
			if($this->db->insert('register',$userdata)){    
                $this->save_lampiran($userdata);                            
                return true;
            } else {
                return false;
            }
        }
		
    }

    function generateRegistrationNumber()
    {
        $lastRegNo = $this->getLastInsertRegNo();
        
        $a = substr($lastRegNo, 5, 8);
        $a++;

        $year = date('y');
        $month = date('m');
        $awal = '00000000';
        $inc = $a;
        $genAwal = $awal.$inc;
        
        $nextRegNo = $year.$month.substr($genAwal, strlen($genAwal)-8,8);

        return $nextRegNo;
    }

    function getLastInsertRegNo()
    {
        $query = $this->db->query('SELECT * FROM register ORDER BY id DESC LIMIT 1');
        $lastId = $query->row();
        
        return $lastId == NULL ? 0 : $lastId->registration_no;
    }
			
    function record_count()
    {
        return $this->db->count_all("register");
    }

    function getListCaper($limit, $start)
    {
        $this->db->from('register');
        $this->db->order_by('registration_no DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        /*
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
		    */
        return $query->result();
    }
				
	function getCaperData($caper_id){
		$this -> db -> where('register.id', $caper_id);		
		$query = $this -> db -> get('register'); 		
		return $query->row_array();
	}	
	
	function save_lampiran($userdata) 
    {
		    
		$registration_no=$userdata['registration_no'];
		
        //--- jika directory belum ada maka buat directory;	
        $dirtop="upload/data";			
	    $dirmain=$dirtop . "/" . $registration_no ;			
		$dirname=$dirmain . "/lampiran";
		$dirthumb=$dirmain . "/thumbnail" ;

        if (!is_dir($dirtop)) {			  
           mkdir($dirtop, 0777,true);						   
	    }			
        if (!is_dir($dirmain)) {			  
           mkdir($dirmain, 0777,true);						   
	    }
        if (!is_dir($dirname)) {			  
           mkdir($dirname, 0777,true);						   
	    }			
        if (!is_dir($dirthumb)) {			  
           mkdir($dirthumb, 0777,true);						   
	    }			
		
		//$lname=array('Foto','Ijazah','Transkrip Nilai','KTP','SKCK','SKBN','SKS');
		// $lname=array('foto','ijazah','transkrip_nilai','ktp','skck','skbn','sks','bpjs','riwayat_hidup');
        $lname=array('foto','ijazah','transkrip_nilai','ktp','surat_pernyataan','surat_lamaran','riwayat_hidup');
		for ($xi=0;$xi<count($lname);++$xi) {
            $vname='lampiran' . $xi;	
            if(isset($_FILES[$vname])){			
		       //$targets = $dirname . '/'.  $registration_no . '_' . $lname[$xi] .  '_' . basename($_FILES[$vname]['name']);	
               //$thumbfile= $dirthumb . '/'.   $registration_no . '_' . $lname[$xi] .  '_' . basename($_FILES[$vname]['name']);
               $ext = pathinfo(basename($_FILES[$vname]['name']), PATHINFO_EXTENSION);

                if($ext == 'doc' || $ext == 'docx' || $ext == 'pdf') {
                    $targets = $dirname . '/'.  $registration_no . '_' . $lname[$xi] .  '.'.$ext;
                    move_uploaded_file($_FILES[$vname]['tmp_name'], $targets);
                } else {
                    $targets = $dirname . '/'.  $registration_no . '_' . $lname[$xi] .  '.'.$ext; 
                    $thumbfile= $dirthumb . '/'.   $registration_no . '_' . $lname[$xi] .  '.'.$ext;
                    move_uploaded_file($_FILES[$vname]['tmp_name'], $targets);
                    // $this->make_thumbnail($targets,$thumbfile);
                }			   
            } 
		}		
	    $this->make_dokumen_excel($userdata);			
        $this->zip_lampiran($registration_no);					
	}	
	
	
	function zip_lampiran($registration_no) 
    {
		$dirmain="upload/data/" . $registration_no ;			
		$dirname=$dirmain . "/lampiran";
		$dirthumb=$dirmain . "/thumbnail" ;				
				 
        // Get real path for our folder
        $rootPath = realpath($dirmain);
        $subPath = realpath($dirname);

        $zipfile=$registration_no . "_lampiran.zip";

        // Initialize archive object		 
        $zip = new ZipArchive();
        $zip->open($dirmain .'/' . $zipfile, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        // Create recursive directory iterator
        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($subPath),
            RecursiveIteratorIterator::LEAVES_ONLY 
        );

        foreach ($files as $name => $file) {
            // Skip directories (they would be added automatically)
            if (!$file->isDir())
            {
                // Get real and relative path for current file
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);

                // Add current file to archive
                $zip->addFile($filePath, $relativePath);
            }
        }
	}	
	
	function make_thumbnail($img_name,$thumb_name)
    {	
        $filename = $img_name;		
        	 
        list($width, $height) = getimagesize($filename);
        $newwidth=$width;
        $newheight=$height;

        if ($newwidth > 200) {			  			  
            $newheight = $height * (200/$width);
            $newwidth = 200;
        }

        if ($newheight > 200) {			  			  
            $newwidth = $newwidth * (200/$newheight);
            $newheight = 200;
        } 		  
        
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = imagecreatefromjpeg($filename);
         
        imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        	
        imagejpeg($thumb,$thumb_name);
	}
	
	

	function make_dokumen_excel($userdata) 
    {
		
		  $registration_no=$userdata['registration_no'];
          $dirmain="upload/data/" . $registration_no ;			
		  $dirname=$dirmain . "/lampiran";		
		
		  $xlsxfile=$registration_no . "_lampiran.xlsx";
		
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
	      		 		  
		  $mpd=array('SD' => 'Sekolah Dasar','SMP' => 'Sekolah Menengah Pertama','SMA' => 'Sekolah Menengah Atas','DIPLOMA' => 'Diploma', 'S1' => 'Sarjana','S2' => 'Megister');

		  $mlabel=array(
		               array('Informasi Umum','Nama Lengkap','Tempat Lahir','Tanggal Lahir','Email Address','Alamat', 'Desa/Kelurahan', 'Kecamatan', 'Kabupaten/Kota', 'Provinsi', 'No Telepon'),
		               array('Pekerjaan Terakhir','Nama Instansi','Bagian','Alamat Instansi','Jabatan','Masa Kerja','Deskripsi Pekerjaan'),
				       array('Informasi Pendidikan','Tingkat Pendidikan','Institusi Pendidikan','Fakultas/Jurusan','No. Ijazah','Nilai IPK'));
				
          $mhtml =	$userdata['jobdesk'];			
          $mhtml = str_replace('</strong>','',$mhtml);
          $mhtml = str_replace('</p>','',$mhtml);
          $mhtml = str_replace('<p>','',$mhtml);					   
				   		   		   
		  $mvalue=array(
		          array('Informasi Umum,', $userdata['first_name'] . " " . $userdata['last_name'],$userdata['tempat_lahir'],$userdata['tanggal_lahir'],$userdata['email'],$userdata['alamat'], $userdata['desakelurahan'], $userdata['kecamatan'], $userdata['kabupatenkota'], $userdata['provinsi'], $userdata['contact_no'] ),
                  array('Pekerjaan Terakhir', $userdata['instansi_name'],$userdata['bagian'],$userdata['alamat_instansi'],$userdata['jabatan'],$userdata['thn_mengabdi'],$mhtml),
                  array('Informasi Pendidikan', $mpd[$userdata['pendidikan']] . '(' . $userdata['pendidikan']. ')',$userdata['institusi_pendidikan'],$userdata['fakultas'],$userdata['no_ijazah'],$userdata['nilai_ipk'])); 				  
						 		  
          $cr=1;		  
		  for ($xi=0;$xi<3;++$xi) {			  
		      $not_title=false; 
			  $pr=$cr;			 			  
			  $range='A' . ($cr+1) . ':F'. ($cr+1);			  
			  $objSheet->getStyle($range)->getFont()->setSize(14);	
			  $objSheet->getStyle($range)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');
              foreach($mlabel[$xi] as $lkey=>$lvalue) {				  
			    	$objSheet->SetCellValue("A" . ++$cr, $lvalue);														 
	          }				  
			  $cr=$pr;              			  
              foreach($mvalue[$xi] as $vkey=>$vvalue) {				
			       ++$cr;
                   if($not_title) {			  
					 $objSheet->SetCellValue("B" . $cr, $vvalue);									
				   }			
                   $not_title=true;   				   
	          }				  			  
			 ++$cr ;          
	      }					
								      									
          $objSheet->getColumnDimension('A')->setAutoSize(true);	
	      $objSheet->getStyle('A1:A'.$cr)->getFont()->setBold(true);
		  $objSheet->getStyle('A1:B'.$cr)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);		
		  		  
	      $objSheet->setTitle("Data Calon Peserta");
		
	      $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 					      
	      $objWriter->save($dirname . "/" .$xlsxfile);
	      						
	}	
	
    function getLimitCaper($page="1")
    {
		if ($page==0) {
			$page=1;
		}	
		$mlimit=$this->config->item("number_of_rows");
		$moffset=($page-1) * $mlimit;
		
		$this->db->limit($mlimit, $moffset);
		$query = $this->db->get('register');
		return $query->result_array();
	}	
	
	function getAllCaper() 
    {
        $this->db->from('register');
        $this->db->order_by('registration_no', 'DESC');
        $query = $this->db->get();
        return $query->result_array();		
	}	

    function xlsx_capers($page=0,$mode="full")
    {
        require_once ('application/third_party/PHPExcel.php');
        require_once ('application/third_party/PHPExcel/Writer/Excel2007.php');

        if ($mode=="full") {
            $capers=$this->getAllCaper();
        } else {
            $capers=$this->getLimitCaper($page);   
        }	  

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Kemendikbud");
        $objPHPExcel->getProperties()->setLastModifiedBy("Kemendikbud");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);
        $objSheet=$objPHPExcel->getActiveSheet();

        $mheaders=array(
            "A1"=>"EMAIL","B1"=>"NO. REGISTRASI","C1"=>"PASSWORD","D1"=>"NAMA DEPAN", "E1"=>"NAMA BELAKANG", "F1" =>"Alamat", "G1"=>"Desa/Kelurahan", "H1"=>"Kecamatan", "I1"=>"Kabupaten/Kota", "J1"=>"Provinsi", "K1"=>"NO. TELP", "L1"=>"TGL. EXPIRE",
            "M1"=>"PENDIDIKAN","N1"=>"INST. PENDIDIKAN", "O1"=>"FAKULTAS-JURUSAN","P1"=>"NO. IJAZAH","Q1"=>"IPK-NEM","R1"=>"NAMA INST. KERJA",
            "S1"=>"BAGIAN","T1"=>"ALAMAT","U1"=>"JABATAN","V1"=>"MASA KERJA","W1"=>"DESKRIPSI","X1"=>"NIK"
        );
        foreach($mheaders as $key => $value) {
            $objSheet->SetCellValue($key, $value);			  
        }	  
		  
        $xr=1;
        $date_awal = date('d-m-Y');
        $expire_date = date('d-m-Y', strtotime('+6 month', strtotime($date_awal)));
        foreach($capers as $ckey => $cvalue) {
            ++$xr;
            $objSheet->SetCellValue("A" . $xr, $cvalue['email']);
            $objSheet->SetCellValue("B" . $xr, $cvalue['registration_no']);
            $objSheet->SetCellValue("C" . $xr, $cvalue['password']);
            $objSheet->SetCellValue("D" . $xr, $cvalue['first_name']);			   
            $objSheet->SetCellValue("E" . $xr, $cvalue['last_name']);
            $objSheet->SetCellValue("F" . $xr, $cvalue['alamat']);
            $objSheet->SetCellValue("G" . $xr, $cvalue['desakelurahan']);
            $objSheet->SetCellValue("H" . $xr, $cvalue['kecamatan']);
            $objSheet->SetCellValue("I" . $xr, $cvalue['kabupatenkota']);
            $objSheet->SetCellValue("J" . $xr, $cvalue['provinsi']);
            $objSheet->SetCellValue("K" . $xr, $cvalue['contact_no']);
            $objSheet->SetCellValue("L" . $xr, $expire_date);
            $objSheet->SetCellValue("M" . $xr, $cvalue['pendidikan']);
            $objSheet->SetCellValue("N" . $xr, $cvalue['institusi_pendidikan']);
            $objSheet->SetCellValue("O" . $xr, $cvalue['fakultas']);
            $objSheet->SetCellValue("P" . $xr, $cvalue['no_ijazah']);
            $objSheet->SetCellValue("Q" . $xr, $cvalue['nilai_ipk']);
            $objSheet->SetCellValue("R" . $xr, $cvalue['instansi_name']);
            $objSheet->SetCellValue("S" . $xr, $cvalue['bagian']);
            $objSheet->SetCellValue("T" . $xr, $cvalue['alamat_instansi']);
            $objSheet->SetCellValue("U" . $xr, $cvalue['jabatan']);
            $objSheet->SetCellValue("V" . $xr, $cvalue['thn_mengabdi']);
            $objSheet->SetCellValue("W" . $xr, strip_tags($cvalue['jobdesk']));
            $objSheet->SetCellValue("X" . $xr, $cvalue['nik']);
        }	  
        		  		  		   		   
        $objSheet->getColumnDimension('A')->setAutoSize(true);	
        $objSheet->getColumnDimension('B')->setAutoSize(true);	
        $objSheet->getColumnDimension('C')->setAutoSize(true);	
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);  
        $objSheet->getColumnDimension('F')->setAutoSize(true); 
        $objSheet->getColumnDimension('G')->setAutoSize(true);
        $objSheet->getColumnDimension('H')->setAutoSize(true);
        $objSheet->getColumnDimension('I')->setAutoSize(true);
        $objSheet->getColumnDimension('J')->setAutoSize(true);
        $objSheet->getColumnDimension('K')->setAutoSize(true);
        $objSheet->getColumnDimension('L')->setAutoSize(true);
        $objSheet->getColumnDimension('M')->setAutoSize(true);
        $objSheet->getColumnDimension('N')->setAutoSize(true);
        $objSheet->getColumnDimension('O')->setAutoSize(true);
        $objSheet->getColumnDimension('P')->setAutoSize(true);
        $objSheet->getColumnDimension('Q')->setAutoSize(true);
        $objSheet->getColumnDimension('R')->setAutoSize(true);
        $objSheet->getColumnDimension('S')->setAutoSize(true);
        $objSheet->getColumnDimension('T')->setAutoSize(true);
        $objSheet->getColumnDimension('U')->setAutoSize(true);
        $objSheet->getColumnDimension('V')->setAutoSize(true);
        $objSheet->getColumnDimension('W')->setAutoSize(true);
        $objSheet->getColumnDimension('X')->setAutoSize(true);

        $objSheet->getStyle('A1:X1')->getFont()->setSize(14);	
        $objSheet->getStyle('A1:X1')->getFont()->setBold(true);
        $objSheet->getStyle('A1:X1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');		  

        $objSheet->getStyle('A1:X'.$xr)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);				  			 

        $objSheet->setTitle("Daftar Calon Peserta");

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 					       
        ob_start();
        $objWriter->save('php://output');
        $excelOutput = ob_get_clean();

        return $excelOutput;

    }	
	
	function gen_data($pUsers)
    {		
        $userdata = array(
            'first_name' => $pUsers['first_name'],
            'last_name' => $pUsers['last_name'],
            'registration_no' => $this->generateRegistrationNumber(),
            'password' => $pUsers['password'],
            'tempat_lahir' => "jakarta",
            'tanggal_lahir' => date('Y-m-d', strtotime('01-01-2000')),
            'email' => $pUsers['email'],
            'contact_no' => $pUsers['contact_no'],
            'instansi_name' => "Solusi Media Semesta",
            'bagian' => "IT Master",
            'alamat_instansi' => "Mampang Prapatan",
            'thn_mengabdi' => "5",
            'jabatan' => "Karyawan",
            'jobdesk' => "Mengerjakan semua yang perlu dilakukan",
            'pendidikan' => "S1",
            'institusi_pendidikan' => "SATNET UNIVERSITY",
            'fakultas' => "TEKNIK",
            'no_ijazah' => "0001234",
            'nilai_ipk' => "3.8"
        );
	
		$this->db->insert('register',$userdata);
    }		
	
}