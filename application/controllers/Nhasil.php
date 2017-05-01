<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NHasil extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("hasil_model");
        $this->load->model("user_model");
  		  $this->load->model("provinsi_model");
  		  $this->load->model("nhasil_model");		
		
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
	
	function index($limit='0',$gid_filter='0',$oid_filter='0',$prov_filter='',$nsr_filter='') {
		date_default_timezone_set("Asia/Jakarta");
		
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        
        if ($logged_in['su'] == 1) {
            $created_by = null;
        } else {
            $oid_filter = $logged_in['uid'];
        }
        
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
		
        if($oid_filter != null and $oid_filter !=0) {
          $data['search']['created_by']=$oid_filter;		        		
        } else {
		      if ($this->input->post('operator')) { 
            $data['search']['created_by']=$this->input->post('operator');		 
          } else {			
            $data['search']['created_by']=0;		 
          }
        }
	   
        if($gid_filter != null and $gid_filter !=0) {
           $data['search']['gid']=$gid_filter;		        		
        } else {	   
          if ($this->input->post('group')) { 
               $data['search']['gid']=$this->input->post('group');		 
          } else {
            $data['search']['gid']=0;		 
          } 		
        }
		
        if($prov_filter != null and $prov_filter !='') {
           $data['search']['provinsi']=$prov_filter;		        		
        } else {	   
          if ($this->input->post('provinsi')) { 
               $data['search']['provinsi']=$this->input->post('provinsi');		 
          } else {
            $data['search']['provinsi']='';		 
          } 		
        }		
		
		if($nsr_filter != null and $nsr_filter !='') {
           $data['search']['n_search']=$nsr_filter;		        		
        } else {	   
          if ($this->input->post('n_search')) { 
               $data['search']['n_search']=$this->input->post('n_search');		 
          } else {
            $data['search']['n_search']='';		 
          } 		
		}
        $data['limit']=$limit;
        //$data['cid']=$cid;
        //$data['lid']=$lid;
        
        $data['title']=$this->lang->line('resultlist');
        // fetching user list
        $data['operators'] = $this->user_model->user_list(0, null, 2);
        $data['groups'] = $this->user_model->group_list();
		$data['provinsi']=$this->provinsi_model->get();
        // var_dump($data['operator']);
        $data['result']=$this->hasil_model->hasil_resume($limit,false,$gid_filter,$oid_filter,$nsr_filter);
        $this->load->view('header',$data);
        $this->load->view('nhasil',$data);
        $this->load->view('footer',$data);		
		
	}	
	
	function index_x(){
		
      $this->load->view('header',$data);
      $this->load->view('nhasil',$data);
      $this->load->view('footer',$data);		
		
	}
	
	 
    function answer($uid=0) {
		
     if($uid != null and $uid !=0) {
           $data['search']['uid']=$uid;		        		
        } else {	   
          if ($this->input->post('uid')) { 
               $data['search']['uid']=$this->input->post('uid');		 
          } else {
            $data['search']['uid']=0;		 
          } 		
        }	  	
	  $data["list"]=$this->nhasil_model->category($uid);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
      $this->load->view('nhasil_answer_category',$data);
      $this->load->view('footer',$data);	
	}	
	
	function quiz($uid=0,$cid=0) {
		
	  $data["list"]=$this->nhasil_model->quiz($uid,$cid);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
      $this->load->view('nhasil_answer_quiz',$data);
      $this->load->view('footer',$data);
	}	
	
    function quiz_all($uid=0,$cid=0,$qid=0) {
		
	  $data["list"]=$this->nhasil_model->answer($uid,$cid,$qid);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
      $this->load->view('nhasil_answer_all',$data);
      $this->load->view('footer',$data);
	}	


	function quiz_list_by_time($uid=0,$cid=0){
	  $data["list"]=$this->nhasil_model->list_by_time($uid,$cid);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
      $this->load->view('nhasil_answer_quiz_by_time',$data);	  
      $this->load->view('footer',$data);		
	}		
	
	function answer_list_by_time($uid=0,$cid=0){
	  $data["list"]=$this->nhasil_model->list_by_time($uid,$cid);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
      $this->load->view('nhasil_answer_quiz_by_time',$data);	  
      $this->load->view('footer',$data);		
	}			
	
	function quiz_answer_all_by_time($uid=0,$cid=0,$start_time=0) {
		
	  $data["list"]=$this->nhasil_model->quiz_by_time($uid,$cid,$start_time);
	  $data["title"]="N Hasil";
	  $this->load->view('header',$data);
	  //var_dump($data["list"]);
      $this->load->view('nhasil_answer_all_by_time',$data);
      $this->load->view('footer',$data);
	}	
	
	
	
}
?>	