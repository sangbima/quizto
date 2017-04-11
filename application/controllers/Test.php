<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        if($this->session->userdata('logged_in')){
            redirect('dashboard');
        }

        $this->load->database();
        $this->load->model("register_model");
        $this->load->model("provinsi_model");
        $this->load->model("kotakabupaten_model");
        $this->load->library('email');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->lang->load('basic', $this->config->item('language'));
    }

    public function index()
    {
        $data['title'] = 'Test Upload';
        
        $this->load->view('header',$data);
        $this->load->view('test_page',$data);    
        $this->load->view('footer',$data);
    }

    public function submit()
    {
        // $this->form_validation->set_rules('nilai_ipk', 'IPK', 'required');
        $this->form_validation->set_rules('lampiran4', 'Surat Pernyataan', 'callback_document_upload['.$_FILES['lampiran4']['name'].']'); 
        // $this->form_validation->set_rules('lampiran5', 'Daftar Riwayat Hidup', 'callback_files_required['.$_FILES['lampiran5']['name'].']|callback_document_upload['.$_FILES['lampiran5']['name'].']');
        // $this->form_validation->set_rules('lampiran6', 'Surat Lamaran', 'callback_files_required['.$_FILES['lampiran6']['name'].']|callback_document_upload['.$_FILES['lampiran6']['name'].']');

        
        $this->form_validation->set_message('files_required', 'Dokumen %s wajib diisi.');
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('document_upload', "File dokumen harus berupa file *.doc, *.docx atau *.pdf");
        $this->form_validation->set_message('gambar_upload', "File foto/scan dokumen harus berupa file *.jpg atau *.jpeg");
        $this->form_validation->set_message('ukuran_file', "File maksimal berukuran 200KB");

        // var_dump($_FILES['lampiran4']['size']);die();

        // $lampiran4=$_FILES['lampiran4']['name'];
        // var_dump($lampiran4);die();

        if($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo $errors;
        } else {
            echo 'success';
        }
        
    }

    public function files_required($field, $files)
    {
        if(!empty($files)) {
            return true;
        } else {
            return false;
        }
    }

    public function document_upload($field, $files)
    {
        $ext = pathinfo(basename($files), PATHINFO_EXTENSION);
        
        $ext_allowed = array('doc', 'docx', 'pdf');
        if(in_array($ext, $ext_allowed)) {
            return true;
        } else {
            return false;
        }
    }

    public function gambar_upload($field, $files)
    {
        $ext = pathinfo(basename($files), PATHINFO_EXTENSION);
        
        $ext_allowed = array('jpg', 'jpeg');
        if(in_array($ext, $ext_allowed)) {
            return true;
        } else {
            return false;
        }
    }

    public function ukuran_file($field, $files)
    {
        $size = $_FILES['lampiran4']['size'];
        var_dump($size);die();
        if($size > 204800) {
            return true;
        } else {
            return false;
        }
    }
}