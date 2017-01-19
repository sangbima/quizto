<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("hasil_model");
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
            
        $data['limit']=$limit;
        $data['cid']=$cid;
        $data['lid']=$lid;
        
        $data['title']=$this->lang->line('resultlist');
        // fetching user list
        $data['result']=$this->hasil_model->hasil_resume($limit,$cid,$lid);
        $this->load->view('header',$data);
        $this->load->view('hasil_list',$data);
        $this->load->view('footer',$data);
    }

    public function detail($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Peserta";
        // fetching user list
        $data['user']=$this->user_model->get_user($uid);
        $data['tputpa'] = 'TPU TPA';
        $data['result'] = $this->hasil_model->hasil_detail($uid, '1');
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);

        $this->load->view('header',$data);
        $this->load->view('hasil_detail',$data);
        $this->load->view('footer',$data);
    }

    public function detailist($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Peserta";
        // fetching user list
        $data['user']=$this->user_model->get_user($uid);
        $data['result'] = $this->hasil_model->hasil_detail($uid);
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);

        $this->load->view('header',$data);
        $this->load->view('hasil_detail_ist',$data);
        $this->load->view('footer',$data);
    }

    public function tpa()
    {
        $this->load->view('header');
        $this->load->view('hasil_tpa');
        $this->load->view('footer');
    }

    public function tpu_tpa($limit='0',$cid='0',$lid='0')
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['cid']=$cid;
        $data['lid']=$lid;
        
        $data['title']=$this->lang->line('resultlist');
        // fetching user list
        $data['result']=$this->hasil_model->hasil_tpu_tpa($limit,$cid,$lid);
        $this->load->view('header', $data);
        $this->load->view('hasil_tpu_tpa', $data);
        $this->load->view('footer', $data);
    }

    
    public function ist($limit='0',$cid='0',$lid='0')
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['cid']=$cid;
        $data['lid']=$lid;
        
        $data['title']=$this->lang->line('resultlist');
        // fetching user list
        $data['result']=$this->hasil_model->hasil_list($limit,$cid,$lid);
        $this->load->view('header',$data);
        $this->load->view('hasil_ist',$data);
        $this->load->view('footer',$data);
    }

    public function export_hasil($limit='0',$cid='0',$lid='0')
    {    

        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['cid']=$cid;
        $data['lid']=$lid;  
        $data['title']='Hasil IST';
        $data['header']=array('A'=>'Fullname',
                              'B'=>'WA',
                              'C'=>'SE',
                              'D'=>'AN',
                              'E'=>'GE',
                              'F'=>'RA',                              
                              'G'=>'ZR',
                              'H'=>'FA',
                              'I'=>'WU',
                              'J'=>'ME',
                              'K'=>'TOTAL'
                              );
         $data['result']=$this->hasil_model->hasil_list($limit,$cid,$lid);                            
         $this->load->view('export_hasil_ist',$data);
    }


    // public function hasilist()
    // {
    //     $this->load->view('header',$data);
    //     $this->load->view('hasil_ist',$data);
    //     $this->load->view('footer',$data);
    // }

    public function disc($limit='0',$cid='0',$lid='0')
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['cid']=$cid;
        $data['lid']=$lid;
        
        $data['title']=$this->lang->line('resultlist');
        // fetching user list
        $data['result']=$this->hasil_model->hasil_disc($limit,$cid,$lid);
        $this->load->view('header', $data);
        $this->load->view('hasil_disc', $data);
        $this->load->view('footer', $data);
    }

    public function detaildisc($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Peserta";
        // fetching user list
        $data['user']=$this->user_model->get_user($uid);
        $data['result'] = $this->hasil_model->hasil_detail($uid);
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);

        $this->load->view('header',$data);
        $this->load->view('hasil_detail_disc',$data);
        $this->load->view('footer',$data);
    }

}