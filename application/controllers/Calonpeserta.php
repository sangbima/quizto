<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calonpeserta extends CI_Controller 
{
    function __construct()
    {
       parent::__construct();
       $this->load->database();
       $this->load->model("register_model");
       $this->lang->load('basic', $this->config->item('language'));
       $this->load->library('pagination');
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
        $config["per_page"] = 25;
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

        $data['title'] = "Daftar Calon Peserta Ujian";
        $this->load->view('header',$data);
        $this->load->view('calon_peserta',$data);
        $this->load->view('footer',$data);
    }
}