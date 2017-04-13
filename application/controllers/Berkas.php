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
       $this->load->helper(array('form', 'url'));
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

        $this->form_validation->set_rules('berkas0', 'SKCK', 'callback_gambar_upload['.$_FILES['berkas0']['name'].']');
        $this->form_validation->set_rules('berkas1', 'SKBN', 'callback_gambar_upload['.$_FILES['berkas1']['name'].']');
        $this->form_validation->set_rules('berkas2', 'SKS', 'callback_gambar_upload['.$_FILES['berkas2']['name'].']'); 
        $this->form_validation->set_rules('berkas3', 'BPJS', 'callback_gambar_upload['.$_FILES['berkas3']['name'].']');
        
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