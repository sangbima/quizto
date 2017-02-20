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
        $this->lang->load('basic', $this->config->item('language'));
    }

    public function index()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('first_name', 'Nama Depan', 'required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[register.email]');
        $this->form_validation->set_rules('contact_no', 'Nomor Telepon', 'is_natural|required');
        $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'required');
        $this->form_validation->set_rules('bagian', 'Bagian', 'required');
        $this->form_validation->set_rules('alamat_instansi', 'Alamat Instansi', 'required');
        $this->form_validation->set_rules('thn_mengabdi', 'Tahun Mengabdi', 'numeric|required');
        $this->form_validation->set_rules('pendidikan', 'Tingkat Pendidikan', 'required');
        $this->form_validation->set_rules('institusi_pendidikan', 'Institusi Pendidikan', 'required');
        $this->form_validation->set_rules('fakultas', 'Fakultas/Jurusan', 'required');
        $this->form_validation->set_rules('no_ijazah', 'No. Ijazah', 'required');
        $this->form_validation->set_rules('nilai_ipk', 'IPK/NEM', 'numeric|required');

        $this->form_validation->set_message('required', 'Input %s wajib diisi.');
        $this->form_validation->set_message('min_length', 'Input %s sekurangnya harus berisi %s karakter.');
        $this->form_validation->set_message('valid_email', 'Input %s harus berisi alamat email yang valid');
        $this->form_validation->set_message('is_unique', '%s ini sudah terdaftar');
        $this->form_validation->set_message('matches', 'Input %s tidak sama dengan input password sebelumnya');
        $this->form_validation->set_message('numeric', 'Input %s harus berupa angka');

        $data['title'] = 'Register';
        $this->load->view('header',$data);
        if($this->form_validation->run() == FALSE) {
            $this->load->view('register_new',$data);    
        } else {
            if($this->register_model->insertdata()) {
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
            } else {
                $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
            }
            $this->load->view('register_success',$data);
        }
        // $this->load->view('register_success',$data);
        $this->load->view('footer',$data);
    }

    public function reg()
    {
        redirect('register/success/');
    }

    public function success()
    {
        $this->session->set_flashdata('message', "Registrasi Success");
        $data['title'] = 'Register Success';
        $this->load->view('header',$data);
        $this->load->view('register_success',$data);
        $this->load->view('footer',$data);
    }

    public function test()
    {
        // $to       = 'sangbima.net@gmail.com';
        // $subject  = 'Coba kirim email dari windows';
        // $message  = 'Hi, you just received an email using sendmail!';
        // $headers  = 'From: [cat.kemendikbud]@gmail.com' . "\r\n" .
        //             'MIME-Version: 1.0' . "\r\n" .
        //             'Content-type: text/html; charset=utf-8';
        // if(mail($to, $subject, $message, $headers))
        //     echo "Email sent";
        // else
        //     echo "Email sending failed";  
    }
}