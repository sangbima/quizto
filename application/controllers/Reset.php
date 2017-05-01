<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("reset_model");
        $this->lang->load('basic', $this->config->item('language'));
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
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }

        $data['title'] = 'RESET ALL';

        $this->load->view('header',$data);
        $this->load->view('reset',$data);
        $this->load->view('footer',$data);
    }

    public function confirm()
    {

        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        
        if($this->reset_model->reset('OK')){
            $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
        }else{
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
        }
        redirect('reset');
    }
}