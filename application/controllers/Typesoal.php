<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Typesoal extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("typesoal_model");
        $this->load->model("user_model");
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
        
        $data['title']=$this->lang->line('typesoal');
        // fetching quiz list
        $no = 2;
        $data['result']=$this->typesoal_model->typesoal_list();
        // $data['disc'] = $this->disc_model->disc_list_by_no($no);
        $this->load->view('header',$data);
        $this->load->view('typesoal_list',$data);
        $this->load->view('footer',$data);
    }

    public function add_new()
    {
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']=$this->lang->line('add_new').' '.$this->lang->line('typesoal');
        $this->load->view('header',$data);
        $this->load->view('add_type_soal',$data);
        $this->load->view('footer',$data);
    }

    public function insert_disc()
    {
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('statement_1', 'statement_1', 'required');
        $this->form_validation->set_rules('statement_2', 'statement_2', 'required');
        $this->form_validation->set_rules('statement_3', 'statement_3', 'required');
        $this->form_validation->set_rules('statement_4', 'statement_4', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
            redirect('disc/add_new/');
        }
        else
        {
            $quid=$this->disc_model->insert_disc();
           
            redirect('disc/index');
        }
    }

}