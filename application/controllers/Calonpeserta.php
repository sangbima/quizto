<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calonpeserta extends CI_Controller 
{
    function __construct()
    {
       parent::__construct();
       $this->load->database();
       $this->load->model("register_model");
       $this->load->model("user_model");
       $this->load->helper(array('url', 'file', 'directory'));
       $this->lang->load('basic', $this->config->item('language'));
       // $this->load->library('pagination');
       $this->load->library(array('zip', 'pagination'));
        // redirect if not loggedin
        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['base_url'] != base_url()){
            $this->session->unset_userdata('logged_in');        
            redirect('login');
        }
    }

    public function index($limit=0)
    {
        $config = array();
        $config["base_url"] = base_url() . "calonpeserta/index";
        $total_row = $this->register_model->record_count();
        $config["total_rows"] = $total_row;
        $config["per_page"] = $this->config->item("number_of_rows");
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        // $config["num_links"] = $total_row;
        $config["next_link"] = 'Next';
        $config["prev_link"] = 'Previous';

        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
        $config['cur_tag_open'] = '<li class="active"><span><b>';
        $config['cur_tag_close'] = '</b></span></li>';

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];

        $data['limit']=$config["per_page"];		
        $data['result'] = $this->register_model->getListCaper($config["per_page"], $offset);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['page'] = $page==0? 1:$page;	    
      	
        $data['title'] = "Daftar Calon Peserta Ujian";
        $this->load->view('header',$data);
        $this->load->view('calon_peserta',$data);
        $this->load->view('footer',$data);
    }

    public function status()
    {
        $userid = $this->input->post('caper_id');
        if($this->register_model->ubahstatus($userid)) {
            echo "success";
        } else {
            echo "error";
        }
    }

	public function detail($caper_id)
    {		
        $data['title'] = "Profile Calon Peserta Ujian";
		$data['caper'] = $this->register_model->getCaperData($caper_id);
        $this->load->view('header',$data);
		if ($data['caper']['id'] == null || $data['caper']['id'] == "" ) {
		   redirect('calonpeserta');
		} else {	
           $this->load->view('calon_peserta_detail',$data);
		}
        $this->load->view('footer',$data);			
	}
		
	public function download($dtype="thumb",$value="",$extra="") 
    {
        if ($dtype == "thumb") { 
            $this->download_image($extra,$value,"thumb");    
        }  		

        if ($dtype == "full") { 
            $this->download_image($extra,$value,"full");    
        } 

        if ($dtype == "zip") { 
            $this->download_zip_detail($extra,$value);    
        }
        if ($dtype == "zipall"){          
            $this->download_zip_all();
        }
        if (($dtype == "xlsx") &&  ($value=="allcapers") ){			 
            $this->download_xlsx_capers(0,"full");
        }	 

        if (($dtype == "xlsx") &&  ($value=="capers") ){			 
            $this->download_xlsx_capers($extra,"limited");
        }

        if (($dtype == "xlsx") &&  ($value=="allcapers2") ){			 
            $this->download_xlsx_capers2(0,"full");
        }

        if (($dtype == "xlsx") &&  ($value=="capers2") ){			 
            $this->download_xlsx_capers2($extra,"limited");
        }

        if (($dtype == "xlsx") &&  ($value=="statprov") ){             
            $this->download_xlsx_statprov();
        }	 		 

        if (($dtype == "xlsx") &&  ($value=="statkab") ){             
            $this->download_xlsx_statkab();
        }
	}	
	
	public function download_image($registration_no="",$lampiran_name="",$type="thumb")
    {	
	    if ($type=="thumb") {
		    $dirname="upload/data/" . $registration_no ."/thumbnail";
		} else {
			$dirname="upload/data/" . $registration_no . "/lampiran";
        }

        $maps = directory_map('./upload/data/'.$registration_no.'/lampiran/');

        $nama_file = $registration_no ."_" . strtolower($lampiran_name);

        $file_names = preg_grep('/'.$nama_file.'/', $maps);

        foreach ($file_names as $key => $value) {
            $file_name = $value;
        }
        
        $file_path=realpath($dirname);
        // $file_name=$registration_no ."_" . strtolower($lampiran_name) . ".jpg"; 				 				 
        $myfile=$file_path . "/" . $file_name;
        		 		 
        header('Content-Type: image/jpeg');
        header('Content-Disposition: inline; filename="' . $file_name .'"');			 		 

        if (file_exists($myfile)) {
            header("Content-Length: " . filesize($myfile))	;	 
            readfile($myfile);
        } else {			 
            $canvas = imagecreatetruecolor(100, 150);
            $pink = imagecolorallocate($canvas, 255, 105, 180);
            $white = imagecolorallocate($canvas, 255, 255, 255);
            $green = imagecolorallocate($canvas, 132, 135, 28); 
            $grey = imagecolorallocate($canvas, 128, 128, 128);
            $black = imagecolorallocate($canvas, 0, 0, 0);
            $font = 'arialn.ttf';		
         
            imagestring ( $canvas , 3 , 25 , 25 , "Not Found" , $grey );
            imagestring ( $canvas , 3 , 30 , 30 , "Not Found" , $black );
            //imagettftext($canvas, 20, 0, 25,  25, $grey,$font, 12);     
            //imagettftext($canvas, 20, 0, 30,  30, $black,$font , 12);			 

            imagejpeg($canvas);
            imagedestroy($canvas);
        }
        exit;
	}
	
	public function download_zip_all()
    {
        $namafile = date('Ymd').'_lampiran_semua_peserta.zip';
        $path="upload/data/";
        
        $this->zip->read_dir($path, FALSE);

        $this->zip->download($namafile);
    }

    public function download_zip_detail($registration_no="",$type="detail")
    {
        $dirmain="upload/data/" . $registration_no ;			
        $dirname=$dirmain . "/lampiran";
        $dirthumb=$dirmain . "/thumbnail" ;	


        $file_path=realpath($dirmain);
        $file_zip=  $registration_no . "_lampiran.zip";

        $myfile = $file_path . "/" .$file_zip;           
        header("Content-Type: application/zip");
        header("Content-Disposition: attachment; filename=$file_zip");
        header("Content-Length: " . filesize($myfile));

        readfile($myfile);
        exit;		  		  
	}		
		
    public function download_xlsx_capers($page=0,$mode="full")
    {
		if ($mode=="full") {
		    $filename="daftar_semua_calon_peserta_" . date('Ymd') . ".xlsx";
		} else {
		    $filename="daftar_sebagian_calon_peserta_" . date('Ymd') . ".xlsx";
        }			
		
		$excel_data=$this->register_model->xlsx_capers($page,$mode);
	    header("Content-Disposition: attachment; filename=\"$filename\"");
	    header("Content-Type: application/vnd.ms-excel");		
		echo $excel_data;		
		exit;				
	}

    public function download_xlsx_capers2($page=0,$mode="full")
    {
		if ($mode=="full") {
		    $filename="daftar_semua_calon_peserta_tahap2" . date('Ymd') . ".xlsx";
		} else {
		    $filename="daftar_sebagian_calon_peserta_tahap2" . date('Ymd') . ".xlsx";
        }			
		
		$excel_data=$this->user_model->xlsx_capers($page,$mode);
	    header("Content-Disposition: attachment; filename=\"$filename\"");
	    header("Content-Type: application/vnd.ms-excel");		
		echo $excel_data;		
		exit;				
	}

    public function download_xlsx_statprov()
    {
        
        $filename="daftar_sebaran_peserta_provinsi_" . date('Ymd') . ".xlsx";
        
        $excel_data=$this->register_model->xlsx_statprov();
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");       
        echo $excel_data;       
        exit;               
    }

    public function download_xlsx_statkab()
    {
        
        $filename="daftar_sebaran_kabupatenkota_" . date('Ymd') . ".xlsx";
        
        $excel_data=$this->register_model->xlsx_statkab();
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Content-Type: application/vnd.ms-excel");       
        echo $excel_data;       
        exit;               
    }

    public function statprov()
    {
        $config = array();
        $config["base_url"] = base_url() . "calonpeserta/statprov";
        $total_row = $this->register_model->num_record_statprov();
        $config["total_rows"] = $total_row;
        $config["per_page"] = $this->config->item("number_of_rows");
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        // $config["num_links"] = $total_row;
        $config["next_link"] = 'Next';
        $config["prev_link"] = 'Previous';

        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
        $config['cur_tag_open'] = '<li class="active"><span><b>';
        $config['cur_tag_close'] = '</b></span></li>';

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];

        $data['limit']=$config["per_page"];     
        
        $data['statprov'] = $this->register_model->getStatProv($config["per_page"], $offset);

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['page'] = $page==0? 1:$page;

        $data['title'] = "Sebaran Peserta Berdasarkan Provinsi";
        $this->load->view('header',$data);
        $this->load->view('calon_peserta_statprov',$data);
        $this->load->view('footer',$data);
    }

    public function statkab()
    {
        $config = array();
        $config["base_url"] = base_url() . "calonpeserta/statkab";
        $total_row = $this->register_model->num_record_statkab();
        $config["total_rows"] = $total_row;
        $config["per_page"] = $this->config->item("number_of_rows");
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        // $config["num_links"] = $total_row;
        $config["next_link"] = 'Next';
        $config["prev_link"] = 'Previous';

        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
        $config['cur_tag_open'] = '<li class="active"><span><b>';
        $config['cur_tag_close'] = '</b></span></li>';

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];

        $data['limit']=$config["per_page"];     
        
        $data['statprov'] = $this->register_model->getStatKab($config["per_page"], $offset);

        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['page'] = $page==0? 1:$page;

        $data['title'] = "Sebaran Peserta Berdasarkan Provinsi";
        $this->load->view('header',$data);
        $this->load->view('calon_peserta_statkab',$data);
        $this->load->view('footer',$data);
    }

    public function caper2()
    {
        $config = array();
        $config["base_url"] = base_url() . "calonpeserta/index";
        $total_row = $this->user_model->record_count_status2();
        $config["total_rows"] = $total_row;
        $config["per_page"] = $this->config->item("number_of_rows");
        $config["uri_segment"] = 3;
        $config["use_page_numbers"] = TRUE;
        // $config["num_links"] = $total_row;
        $config["next_link"] = 'Next';
        $config["prev_link"] = 'Previous';

        $config['first_tag_open'] = $config['last_tag_open'] = $config['next_tag_open'] = $config['prev_tag_open'] = $config['num_tag_open'] = '<li>';
        $config['first_tag_close'] = $config['last_tag_close'] = $config['next_tag_close'] = $config['prev_tag_close'] = $config['num_tag_close'] = '</li>';
         
        $config['cur_tag_open'] = '<li class="active"><span><b>';
        $config['cur_tag_close'] = '</b></span></li>';

        $this->pagination->initialize($config);
        
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $offset = $page == 0 ? 0 : ($page - 1) * $config["per_page"];

        $data['limit']=$config["per_page"];		
        $data['result'] = $this->user_model->getListCaper2($config["per_page"], $offset);
        
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['page'] = $page==0? 1:$page;
        
        $data['title'] = "Daftar Peserta Pemberkasan Tahap 2";
        
        $this->load->view('header',$data);
        $this->load->view('calon_peserta2',$data);
        $this->load->view('footer',$data);
    }

    public function status2()
    {
        $userid = $this->input->post('caper_id');
        if($this->user_model->ubahstatus2($userid)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}