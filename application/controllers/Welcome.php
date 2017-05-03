<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->lang->load('basic', $this->config->item('language'));
        $this->load->helper('fungsidate');
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

    public function index()
    {
        $data['title']='Selamat Datang!!!';
        $this->load->view('header',$data);
        $this->load->view('welcome',$data);
        $this->load->view('footer',$data);
    }
}