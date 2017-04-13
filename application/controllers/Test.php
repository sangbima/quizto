<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        // if($this->session->userdata('logged_in')){
        //     redirect('dashboard');
        // }

        // $this->load->database();
        // $this->load->model("register_model");
        // $this->load->model("provinsi_model");
        // $this->load->model("kotakabupaten_model");
        // $this->load->library('email');
        $this->load->helper(array('form', 'url', 'file'));
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
        $this->form_validation->set_rules('lampiran4', 'Surat Pernyataan', 'callback_file_lampiran4_check'); 
        $this->form_validation->set_rules('lampiran5', 'Daftar Riwayat Hidup', 'callback_file_lampiran5_check');
        $this->form_validation->set_rules('lampiran6', 'Surat Lamaran', 'callback_file_lampiran6_check');

        
        $this->form_validation->set_message('files_required', 'Dokumen %s wajib diisi.');
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('document_upload', "File dokumen harus berupa file *.doc, *.docx atau *.pdf");
        $this->form_validation->set_message('gambar_upload', "File foto/scan dokumen harus berupa file *.jpg atau *.jpeg");
        $this->form_validation->set_message('file_size', "File maksimal berukuran 200KB");

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

    public function file_lampiran4_check($str)
    {
        $allowed_mime_type_arr = array('image/jpeg');
        $mime = get_mime_by_extension($_FILES['lampiran4']['name']);
        if(isset($_FILES['lampiran4']['name']) && $_FILES['lampiran4']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran4']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran4_check', 'Berkas Surat Pernyataan harus berukuran maksimal 200KB');
                    return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran4_check', 'Berkas Surat Pernyataan harus berupa file .jpg atau .jpeg');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran4_check', 'Berkas Surat Pernyataan harus diunggah');
            return false;
        }
    }

    public function file_lampiran5_check($str)
    {
        $allowed_mime_type_arr = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $mime = get_mime_by_extension($_FILES['lampiran5']['name']);
        if(isset($_FILES['lampiran5']['name']) && $_FILES['lampiran5']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran5']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berukuran maksimal 200KB');
                return false;
                }
            } else {
                $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus berupa file .doc, .docx atau .pdf');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran5_check', 'Daftar Riwayat Hidup harus diunggah');
            return false;
        }
    }

    public function file_lampiran6_check($str)
    {
        $allowed_mime_type_arr = array('application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        $mime = get_mime_by_extension($_FILES['lampiran5']['name']);
        if(isset($_FILES['lampiran6']['name']) && $_FILES['lampiran5']['name'] != '') {
            if(in_array($mime, $allowed_mime_type_arr)) {
                if($_FILES['lampiran5']['size'] < 204800) {
                    return true;
                } else {
                    $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berupa file .doc, .docx atau .pdf');
                }
            } else {
                $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus berukuran maksimal 200KB');
                return false;
            }
        } else {
            $this->form_validation->set_message('file_lampiran6_check', 'Surat Lamaran harus diunggah');
            return false;
        }
    }

    public function file_lampiran4_size()
    {
        $size = $_FILES['lampiran4']['size'];
        if($size < 204800 && $size > 46080) {
            return true;
        } else {
            $this->form_validation->set_message('file_lampiran4_size', 'Berkas Surat Pernyataan tidak boleh melebihi 200KB');
            return false;
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

    public function validate_before_upload($field, $files)
    {
        if($files < 204800) {
            return true;
        } else {
            return false;
        }
    }
}