<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mscale extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("mscale_model");
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

    public function index($limit='0',$cid='0',$lid='0')
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        // $data['category_list']=$this->qbank_model->category_list();
        // $data['level_list']=$this->qbank_model->level_list();
        
        // $data['limit']=$limit;
        // $data['cid']=$cid;
        // $data['lid']=$lid;
        
        $data['title']=$this->lang->line('mscale');
        // fetching user list
        $data['result']=$this->mscale_model->question_list();
        $this->load->view('header',$data);
        $this->load->view('mscale_list',$data);
        $this->load->view('footer',$data);
    }

}