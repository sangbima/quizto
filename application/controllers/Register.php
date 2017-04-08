<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller 
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
        $data['title'] = 'Register';
        $data['provinsi'] = $this->provinsi_model->get();
        // var_dump($data['provinsi']);die();
        $this->load->view('header',$data);
        $this->load->view('register_new',$data);    
        $this->load->view('footer',$data);
    }

    public function submit()
    {
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[register.email]');
        $this->form_validation->set_rules('nik', 'NIK', 'is_natural|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('desakelurahan', 'Desa/Kelurahan', 'required');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required');
        $this->form_validation->set_rules('kabupatenkota', 'Kabupaten/Kota', 'required');
        $this->form_validation->set_rules('provinsi', 'Provinsi', 'required');
        $this->form_validation->set_rules('contact_no', 'Nomor Telepon', 'is_natural|required');
        $this->form_validation->set_rules('pendidikan', 'Tingkat Pendidikan', 'required');
        $this->form_validation->set_rules('institusi_pendidikan', 'Institusi Pendidikan', 'required');
        $this->form_validation->set_rules('fakultas', 'Fakultas/Jurusan', 'required');
        $this->form_validation->set_rules('no_ijazah', 'No. Ijazah', 'required');
        $this->form_validation->set_rules('nilai_ipk', 'IPK/NEM', 'numeric|required');
        $this->form_validation->set_rules('jobdesk', 'Deskripsi Pekerjaan', 'trim');
        $this->form_validation->set_rules('thn_mengabdi', 'Masa Kerja', 'numeric');
        
        if (empty($_FILES['lampiran0']['name'])){
            $this->form_validation->set_rules('lampiran0', 'Pas Foto', 'required');
        }
        if (empty($_FILES['lampiran1']['name'])){
            $this->form_validation->set_rules('lampiran1', 'Ijazah', 'required');
        }
        if (empty($_FILES['lampiran2']['name'])){
            $this->form_validation->set_rules('lampiran2', 'Transkrip Nilai', 'required'); 
        }
        if (empty($_FILES['lampiran3']['name'])){
            $this->form_validation->set_rules('lampiran3', 'KTP', 'required');
        }
        if (empty($_FILES['lampiran4']['name'])){
            $this->form_validation->set_rules('lampiran4', 'Surat Pernyataan', 'required'); 
        }
        if (empty($_FILES['lampiran5']['name'])){
            $this->form_validation->set_rules('lampiran5', 'Daftar Riwayat Hidup', 'required');
        }
        if (empty($_FILES['lampiran6']['name'])){
            $this->form_validation->set_rules('lampiran6', 'Surat Lamaran', 'required');
        }
        
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('min_length', 'Input %s sekurangnya harus berisi %s karakter.');
        $this->form_validation->set_message('valid_email', 'Input %s harus berisi alamat email yang valid');
        $this->form_validation->set_message('is_unique', '%s ini sudah terdaftar');
        $this->form_validation->set_message('matches', 'Input %s tidak sama dengan input password sebelumnya');
        $this->form_validation->set_message('numeric', 'Input %s harus berupa angka');

        if($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            echo $errors;
        } else {
            if($this->register_model->insertdata()) {
                echo "YES";
            } else {
                echo "NO";
            }
        }
    }

    public function file_size($str)
    {

    }

    public function file_type($str)
    {
        
    }

    public function reg()
    {
        redirect('register/success');
    }

    public function success()
    {
        $data['title'] = 'Register Success';
        $this->load->view('header',$data);
        $this->load->view('register_success',$data);
        $this->load->view('footer',$data);
    }

    public function getkotabyprovinsi($provinsi)
    {
        header('Content-Type: application/x-json; charset=utf-8');
        echo(json_encode($this->kotakabupaten_model->get_kotakabupaten_by_provinsi(urldecode($provinsi))));
    }

    public function test()
    {
        // $this->load->library('email');

        // if($this->config->item('protocol')=="smtp"){
        //     $config = array();
        //     $config['protocol'] = 'smtp';
        //     $config['smtp_host'] = $this->config->item('smtp_hostname');
        //     $config['smtp_user'] = $this->config->item('smtp_username');
        //     $config['smtp_pass'] = $this->config->item('smtp_password');
        //     $config['smtp_port'] = $this->config->item('smtp_port');
        //     $config['smtp_timeout'] = $this->config->item('smtp_timeout');
        //     $config['mailtype'] = $this->config->item('smtp_mailtype');
        //     $config['starttls']  = $this->config->item('starttls');
        //     $config['newline']  = $this->config->item('newline');
            
        //     $this->email->initialize($config);
        // }
        
        // $fromemail = $this->config->item('fromemail');
        // $fromname = $this->config->item('fromname');
        // $subject = $this->config->item('email_subject');
        // $message = $this->config->item('email_message');
        
        // $message = str_replace('[registration_no]', $this->register_model->generateRegistrationNumber(), $message);
        // $message = str_replace('[password]', 'inipassword', $message);

        // $toemail = 'sangbima.net@gmail.com';

        // $this->email->to($toemail);
        // $this->email->from($fromemail, $fromname);
        // $this->email->subject($subject);
        // $this->email->message($message);
        // if(!$this->email->send()){
        //     print_r($this->email->print_debugger());
        //     exit;
        // }  
    }
}