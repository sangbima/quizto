<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas extends CI_Controller 
{
    function __construct()
    {
       parent::__construct();
       $this->load->database();
	   $this->load->model("user_model");
	   $this->load->model("berkas_model");	   
	   $this->lang->load('basic', $this->config->item('language'));
       $this->load->helper(array('form', 'url', 'file'));
       $this->load->library('form_validation');	   
	   	   
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
	    $this->load->helper('form');
	    $logged_in=$this->session->userdata('logged_in');
	    $data['uid']=$logged_in['uid'];
        $data['title'] = "Upload Dokumen Peserta Ujian";
        $this->load->view('header',$data);
        $this->load->view('berkas',$data);
        $this->load->view('footer',$data);
    }

    public function submit()
    {   
        $logged_in=$this->session->userdata('logged_in');

        $this->form_validation->set_rules('berkas0', 'SKCK', 'callback_file_berkas0_check');
        $this->form_validation->set_rules('berkas1', 'SKBN', 'callback_file_berkas1_check');
        $this->form_validation->set_rules('berkas2', 'SKS', 'callback_file_berkas2_check'); 
        $this->form_validation->set_rules('berkas3', 'BPJS', 'callback_file_berkas3_check');
        
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        
        $this->form_validation->set_message('files_required', 'Dokumen %s wajib diisi.');
        $this->form_validation->set_message('gambar_upload', "File foto/scan %s harus berupa file *.jpg atau *.jpeg");
        $this->form_validation->set_message('ukuran_file', "File maksimal berukuran 200KB");

        if($this->berkas_model->simpan_data($logged_in['registration_no'])) {
            echo "YES";
        } else {
            echo "NO";
        }
    }	
	
		
    public function success()
    {
        $data['title'] = 'Upload Success';
        $this->load->view('header',$data);
        $this->load->view('upload_berkas_success',$data);
        $this->load->view('footer',$data);
    }


    public function file_berkas0_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['berkas0']['name']);
        if(isset($_FILES['berkas0']['name']) && $_FILES['berkas0']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['berkas0']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_berkas0_check', 'SKCK harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_berkas0_check', 'SKCK harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_berkas0_check', 'SKCK harus diunggah');
            return false;
        }
    }

    public function file_berkas1_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['berkas1']['name']);
        if(isset($_FILES['berkas1']['name']) && $_FILES['berkas1']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['berkas1']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_berkas1_check', 'SKBN harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_berkas1_check', 'SKBN harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_berkas1_check', 'SKBN harus diunggah');
            return false;
        }
    }

    public function file_berkas2_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['berkas2']['name']);
        if(isset($_FILES['berkas2']['name']) && $_FILES['berkas2']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['berkas2']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_berkas2_check', 'SKS Nilai harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_berkas2_check', 'SKS Nilai harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_berkas2_check', 'SKS Nilai harus diunggah');
            return false;
        }
    }

    public function file_berkas3_check($str)
    {
        // Berupa image
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['berkas3']['name']);
        if(isset($_FILES['berkas3']['name']) && $_FILES['berkas3']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['berkas3']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_berkas3_check', 'BPJS harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_berkas3_check', 'BPJS harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_berkas3_check', 'BPJS harus diunggah');
            return false;
        }
    }

    public function file_size($field, $files)
    {
        if($files < 200000) {
            return true;
        } else {
            return false;
        }
    }

    public function document_upload($field, $files)
    {
        $ext = pathinfo(basename($files), PATHINFO_EXTENSION);
        
        $ext_allowed = array('doc', 'docx', 'pdf');
        if(in_array(strtolower($ext), $ext_allowed)) {
            return true;
        } else {
            return false;
        }
    }

    public function gambar_upload($field, $files)
    {
        $ext = pathinfo(basename($files), PATHINFO_EXTENSION);
        
        $ext_allowed = array('jpg', 'jpeg');
        if(in_array(strtolower($ext), $ext_allowed)) {
            return true;
        } else {
            return false;
        }
    }
}