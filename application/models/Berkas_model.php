<?php
Class Berkas_model extends CI_Model
{
	function simpan_data($uid)
    {
		$this->db->where('users.registration_no',$uid);
		$this->db->limit(1);
		$query = $this -> db -> get('users');
		
		
		if($query -> num_rows() == 1)
		{
			$data_users=$query->row_array();
			$this->save_berkas($data_users['registration_no']);			
			return true;
		}
		else
		{			
			return false;
		}		
		
    }

	
	function if_berkas_exist($berkas_name,$no_reg=''){
		$registration_no=$no_reg;
		
        //--- jika directory belum ada maka buat directory;	
        $dirtop="upload/data";			
	    $dirmain=$dirtop . "/" . $registration_no ;			
		$dirname=$dirmain . "/lampiran";
		$dirthumb=$dirmain . "/thumbnail";
		
		$targets0 = $dirname . '/'.  $registration_no . '_' . $berkas_name .  '.JPG';
		$targets1 = strtolower($targets0);
		
        if (file_exists($targets0)||file_exists($targets1)) {
			return false;
        } else {
			return true;
        } 			
	}	
	
	function save_berkas($no_reg) 
    {		    
		// $config['upload_path']          = './uploads/';
  //       $config['allowed_types']        = 'jpg|jpeg';
  //       $config['max_size']             = 200;
  //       $config['file_name']             = 200;
  //       // $config['max_width']            = 1024;
  //       // $config['max_height']           = 768;

  //       $this->load->library('upload', $config);

  //       if (!$this->upload->do_upload('userfile'))
  //       {
  //           $error = array('error' => $this->upload->display_errors());

  //           $this->load->view('upload_form', $error);
  //       }
  //       else
  //       {
  //           $data = array('upload_data' => $this->upload->data());

  //           $this->load->view('upload_success', $data);
  //       }

        $registration_no=$no_reg;
		
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
		
		$lname=array('SKCK','SKSJ','SKSR','SKBN','BPJS','KIS');
		
		for ($xi=0;$xi<count($lname);++$xi) {
            $vname='berkas' . $xi;	
            if(isset($_FILES[$vname])){			
               //$ext = pathinfo(basename($_FILES[$vname]['name']), PATHINFO_EXTENSION);               
			   $ext='.jpg';
               $targets = strtolower($dirname . '/'.  $registration_no . '_' . $lname[$xi] . $ext); 
               $thumbfile= strtolower($dirthumb . '/'.   $registration_no . '_' . $lname[$xi] . $ext);
               move_uploaded_file($_FILES[$vname]['tmp_name'], $targets);
               $this->make_thumbnail($targets,$thumbfile);                			  
            } 
		}		
		
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

        $zipfile=$registration_no . "_berkas.zip";

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
	
}	
?>