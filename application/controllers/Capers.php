<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Capers extends CI_Controller 
{
    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->model("caper1_model");
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'email', 'pagination'));
        $this->lang->load('basic', $this->config->item('language'));

        if(!$this->session->userdata('logged_in')){
            redirect('login');
        }
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['base_url'] != base_url()){
            $this->session->unset_userdata('logged_in');        
            redirect('login');
        }
    }

    // public function caper1()
    // {
        
    // }

    public function sendemail()
    {
        $this->form_validation->set_rules('jml_email', 'Jumlah Email', 'required');
        $this->form_validation->set_message('required', 'Input %s wajib diisi.');

        $limit = $this->input->post('jml_email');

        if(!empty($limit)) {
            $register_data = $this->caper1_model->registerOk($limit);

            foreach ($register_data as $key => $value) {

                if($this->caper1_model->batch_email($value->id)) {
                    $data['email'][] = $value->fullname.' dengan email ' . $value->email;
                } else {
                    $data['email'][] = '';
                }
            }
        }


        $data['title'] = 'Kirim email ke Peserta';

        $config = array();
        $config["base_url"] = base_url() . "tools/sendemail";
        $total_row = $this->caper1_model->record_count();
        $config["total_rows"] = $total_row;
        $config["per_page"] = $this->config->item("number_of_rows");
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
        $data['result'] = $this->caper1_model->getListCaper($config["per_page"], $offset);
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;', $str_links);
        $data['page'] = $page==0? 1:$page;

        $this->load->view('header',$data);
        $this->load->view('tools_blastemail',$data);    
        $this->load->view('footer',$data);

    }

    public function sendsingleemail()
    {
        $caper_id = $this->input->post('caper_id');

        if($this->caper1_model->batch_email($caper_id)) {
            echo "success";
        } else {
            echo "error";
        }
    }
}