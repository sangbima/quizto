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
        $data['result']=$this->hasil_model->hasil_resume($limit,false);
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
        $data['result']=$this->hasil_model->hasil_tpu_tpa($limit,false);
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
        $data['result']=$this->hasil_model->hasil_list($limit,false);
        $this->load->view('header',$data);
        $this->load->view('hasil_ist',$data);
        $this->load->view('footer',$data);
    }
    

    public function download($qtype='ist',$limit='0',$full=false) 
    {       
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }

        if ( $qtype=='tpu_tpa' ) {  
            $this->export_hasil_tpu_tpa($limit,$full);
        }               
        
        if ( $qtype=='ist' ) {  
            $this->export_hasil_ist($limit,$full);
        }       
        
        if ( $qtype=='disc' ) {  
            $this->export_hasil_disc($limit,$full);
        }
                
        if ($qtype=='default') {
            $this->export_hasil_ringkasan($limit,$full);
        }       
        
    }   
    
    public function export_hasil_ringkasan($limit='0',$full=false)
    {
        $data['limit']=$limit;
        $data['title']='Hasil Ringkasan';
        $data['header']=array('A'=>'FULLNAME',
                              'B'=>'TPU',
                              'C'=>'TPA',                             
                              'D'=>'WA',
                              'E'=>'SE',
                              'F'=>'AN',
                              'G'=>'GE',
                              'H'=>'RA',                              
                              'I'=>'ZR',
                              'J'=>'FA',
                              'K'=>'WU',
                              'L'=>'ME',
                              'M'=>'TOTAL'
                              );        
        
         $data['result']=$this->hasil_model->hasil_resume($limit,$full);
         if ( $full) {
            $data['filename'] = "hasil_ringkasan_full_" . date('Ymd') . ".xlsx";         
         } else {
            $data['filename'] = "hasil_ringkasan_"  . $limit. " _". date('Ymd') . ".xlsx";       
         }   
         $this->load->view('export_hasil_ringkasan',$data);      
    }

    public function export_hasil_tpu_tpa($limit='0',$full=false)
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;        
        $data['title']=$this->lang->line('resultlist');
        $data['header']=array('A'=>'FULLNAME',
                              'B'=>'TPU',
                              'C'=>'TPA',
                              'D'=>'TOTAL'
                              );        
        $data['result']=$this->hasil_model->hasil_tpu_tpa($limit,$full);
        if ( $full) {
            $data['filename'] = "hasil_tpu_tpa_full_" . date('Ymd') . ".xlsx";       
         } else {
            $data['filename'] = "hasil_tpu_tpa_"  . $limit. " _". date('Ymd') . ".xlsx";         
        }       
        $this->load->view('export_hasil_tpu_tpa', $data);
     
    }
    
    public function export_hasil_ist($limit='0',$full=false)
    {    

        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['title']='Hasil IST';
        $data['header']=array('A'=>'FULLNAME',
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
         $data['result']=$this->hasil_model->hasil_list($limit,$full); 
         if ( $full) {
            $data['filename'] = "hasil_ist_full_" . date('Ymd') . ".xlsx";       
         } else {
            $data['filename'] = "hasil_ist_"  . $limit. " _". date('Ymd') . ".xlsx";         
         }                      
         $this->load->view('export_hasil_ist',$data);
    }

     public function export_hasil_disc($limit,$full=false) 
     {
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;
        $data['title']=$this->lang->line('resultlist');        
        $data['result']=$this->hasil_model->hasil_disc($limit,$full);
        $data['header']=array('A'=>'FULLNAME',
                              'B'=>'MOST',
                              'C'=>'LEAST',
                              'D'=>'CHANGE'
                              );
        foreach($data['result'] as $mkey=>$mval) {
            $data['result'][$mkey]['mscale']=$this->norma_model->data_scale_m($data['result'][$mkey]['uid']);                                       
            $data['result'][$mkey]['lscale']=$this->norma_model->data_scale_l($data['result'][$mkey]['uid']);
            $data['result'][$mkey]['cscale']=$this->norma_model->data_scale_c($data['result'][$mkey]['uid']);                                                   
        }        
        
        if ( $full) {
            $data['filename'] = "hasil_disc_full_" . date('Ymd') . ".xlsx";      
         } else {
            $data['filename'] = "hasil_disc_"  . $limit. " _". date('Ymd') . ".xlsx";        
        }                       
        $this->load->view('export_hasil_disc',$data);       
     }
     
    // public function hasilist()
    // {
    //     $this->load->view('header',$data);
    //     $this->load->view('hasil_ist',$data);
    //     $this->load->view('footer',$data);
    // }

    public function disc($limit='0',$cid='0',$lid='0')
    {
        $this->load->model("norma_model");      
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

        foreach($data['result'] as $mkey=>$mval) {
            $data['result'][$mkey]['mscale']=$this->norma_model->data_scale_m($data['result'][$mkey]['uid']);                                       
            $data['result'][$mkey]['lscale']=$this->norma_model->data_scale_l($data['result'][$mkey]['uid']);
            $data['result'][$mkey]['cscale']=$this->norma_model->data_scale_c($data['result'][$mkey]['uid']);                                                   
        }           
        
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