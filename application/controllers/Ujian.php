<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ujian extends CI_Controller 
{
    function __construct()
    {
       parent::__construct();
       $this->load->database();
       $this->load->model("ujian_model");
       $this->load->model("quiz_model");
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
    
      // $data['limit']=$limit;
      $data['title']='Daftar Ujian CAT';
      // fetching quiz list
      $data['result'] = $this->ujian_model->ujian_list();   

      $data['result_all'] = $this->ujian_model->ujian_list_all();   
    
      //$data['reach_max'] = $this->ujian_model->is_reach_max($logged_in['uid']);
    $data['uid']=$logged_in['uid'];
      $data['masih_ada_kesempatan'] = false;
      foreach ($data['result'] as $key => $value) {
        $data['quid'][$key] = $value['quid'];   
    
    $ma = $this->ujian_model->count_result($value['quid'],$data['uid']);    
            
    if ( $ma < $data['result'][$key]['maximum_attempts']  ) {
               $data['masih_ada_kesempatan'] = true;      
    }       
        $key++;
      }
    
      foreach ($data['result_all'] as $key => $value) {
        $data['quid_all'][$key] = $value['quid'];
        $key++;
      }   
      $this->session->set_userdata('quid', $data['quid']);
      $this->session->set_userdata('quid_all', $data['quid_all']);

      // var_dump($data['quid']);
      
      $this->load->view('header',$data);
      $this->load->view('ujian_list',$data);
      $this->load->view('footer',$data);
    }

    // START UJIAN TPU

    public function tpu()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
      $quid = $this->session->userdata('quid');
      $quid_all = $this->session->userdata('quid_all');   
      if ( $this->ujian_model->is_quiz_enabled(0) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[0] )) 
    {         
          $data['title'] = 'TEST TPU (TEST PENGETAHUAN UMUM)';
          // $data['quiz']=$this->ujian_model->get_quiz($quid[0]);
          $data['quiz']=$this->ujian_model->get_quiz($quid_all[0]);
      
          $this->load->view('header',$data);
          $this->load->view('ujian_tpu',$data);
          $this->load->view('footer',$data);
    } else {
       redirect('ujian/tpa'); 
    }   
    }

    public function validate_ujian_tpu($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/tpu_attempt/'.$rid);
    }

    function tpu_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);

      // get number of questions
      // $data['questions'] = $this->ujian_model->ujian_list();
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);

      // Get number of question
      $data['quizgroup'] = $this->ujian_model->get_quiz($data['quiz']['quid']);

      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_tpu_attempt',$data);
      $this->load->view('footer',$data);
        
    }

    function submit_quiz_tpu()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/tpa');
    }

    // END UJIAN TPU

    // START UJIAN TPA

    public function tpa()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
      $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');     
    
      if ( $this->ujian_model->is_quiz_enabled(1) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[1]) ) {         

          $data['title'] = 'TEST TPA (TEST PENGETAHUAN AKADEMIK)';
          // $data['quiz']=$this->ujian_model->get_quiz($quid[0]);
          $data['quiz']=$this->ujian_model->get_quiz($quid_all[1]);
      
          $this->load->view('header',$data);
          $this->load->view('ujian_tpa',$data);
          $this->load->view('footer',$data);
    } else {
      redirect('ujian/se');
    }   
    }

    public function validate_ujian_tpa($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/tpa_attempt/'.$rid);
    }

    function tpa_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);

      // get number of questions
      // $data['questions'] = $this->ujian_model->ujian_list();
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);

      // Get number of question
      $data['quizgroup'] = $this->ujian_model->get_quiz($data['quiz']['quid']);

      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_tpa_attempt',$data);
      $this->load->view('footer',$data);
        
    }

    function submit_quiz_tpa()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/se');
    }

    // END UJIAN TPA

    public function validate_ujian_se($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/se_attempt/'.$rid);
    }

    public function validate_ujian_wa($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);
      // var_dump($data['quiz']);die();

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }


      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);

      // var_dump($data['quiz']['end_date']);die();

      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
    
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      var_dump($rid);
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/wa_attempt/'.$rid);
    }

    public function validate_ujian_an($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/an_attempt/'.$rid);
    }

    public function validate_ujian_ge($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/ge_attempt/'.$rid);
    }

    public function validate_ujian_ra($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/ra_attempt/'.$rid);
    }

    public function validate_ujian_zr($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/zr_attempt/'.$rid);
    }

    public function validate_ujian_fa($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/fa_attempt/'.$rid);
    }

    public function validate_ujian_wu($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/wu_attempt/'.$rid);
    }

    public function validate_ujian_me($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/me_attempt/'.$rid);
    }

    /* START Validate DISC */
    public function validate_ujian_disc($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      // Cek apakah waktu start/end valid
      // validate start end date/time
      if($data['quiz']['start_date'] > time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_not_available')." </div>");
        redirect('ujian/index/'.$quid);
      }
      // validate start end date/time
      if($data['quiz']['end_date'] < time()){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$quid);
      }

      // validate maximum attempts
      $maximum_attempt=$this->ujian_model->count_result($quid,$uid);
      if($data['quiz']['maximum_attempts'] <= $maximum_attempt){
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('reached_maximum_attempt')." </div>");
        redirect('ujian/index/'.$quid);
      }
      
      // // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      // var_dump($rid);die();
      
      $this->session->set_userdata('rid', $rid);
      // $this->session->set_userdata('quid', $quid);
      
      redirect('ujian/disc_attempt/'.$rid);
    }
    /* END Validate DISC */

    public function validate_quiz($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $uid=$logged_in['uid'];
       
      // if this quiz already opened by user then resume it
      $open_result=$this->ujian_model->open_result($quid,$uid);
      if($open_result != '0'){
        $this->session->set_userdata('rid', $open_result);
        redirect('ujian/attempt/'.$open_result); 
      }
      $data['quiz']=$this->ujian_model->get_quiz($quid);
      
      // insert result row and get rid (result id)
      $rid=$this->ujian_model->insert_result($quid,$uid);
      
      $this->session->set_userdata('rid', $rid);
      redirect('ujian/attempt/'.$rid);
    }

    public function ujian_detail($quid=null) 
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_01',$data);
      $this->load->view('footer',$data);
      
    }

    public function se()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
    $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');
      if ( $this->ujian_model->is_quiz_enabled(2) and   ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[2]) ) {      
    
           $data['title'] = 'IST';
           $data['quiz']=$this->ujian_model->get_quiz($quid_all[2]);
 
           $this->load->view('header',$data);
           $this->load->view('ujian_ist_01',$data);
           $this->load->view('footer',$data);
    } else {
       redirect('ujian/wa');  
      }     
    }

    // public function se_attempt()
    // {
    //   $quid = $this->session->userdata('quid');
    //   $logged_in=$this->session->userdata('logged_in');
    //   $gid=$logged_in['gid'];

    //   $data['title'] = 'IST';
    //   $data['quiz']=$this->ujian_model->get_quiz($quid[0]);

    //   // remaining time in seconds 
    //   $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
    //   // get questions
    //   $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
    //   // get options

    //   $this->load->view('header',$data);
    //   $this->load->view('ujian_ist_01_attempt',$data);
    //   $this->load->view('footer',$data);
    // }

    function se_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);

      // get number of questions
      // $data['questions'] = $this->ujian_model->ujian_list();
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);

      // Get number of question
      $data['quizgroup'] = $this->ujian_model->get_quiz($data['quiz']['quid']);

      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_01_attempt',$data);
      $this->load->view('footer',$data);
        
    }

    public function wa()
    {
     $logged_in=$this->session->userdata('logged_in');
     $gid=$logged_in['gid'];    
     $quid = $this->session->userdata('quid');
     $quid_all = $this->session->userdata('quid_all');      
     if ( $this->ujian_model->is_quiz_enabled(3) and   ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[3])) {          
          $data['title'] = 'IST';
          $data['quiz']=$this->ujian_model->get_quiz($quid_all[3]);

          $this->load->view('header',$data);
          $this->load->view('ujian_ist_02',$data);
          $this->load->view('footer',$data);
   } else {
      redirect('ujian/an');
     }       
    }

    public function wa_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // var_dump($srid);die();
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_02_attempt',$data);
      $this->load->view('footer',$data);
    }

    public function an()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
      $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');     
      if ( $this->ujian_model->is_quiz_enabled(4) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[4])) {      

          $data['title'] = 'IST';
          $data['quiz']=$this->ujian_model->get_quiz($quid_all[4]);

          $this->load->view('header',$data);
          $this->load->view('ujian_ist_03',$data);
          $this->load->view('footer',$data);
    } else {
      redirect('ujian/ge');
      }     
    }

    public function an_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_03_attempt',$data);
      $this->load->view('footer',$data);

    }

    public function ge()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
      $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all'); 
    
    if ( $this->ujian_model->is_quiz_enabled(5) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[5])) {    

          $data['title'] = 'IST';
          $data['quiz']=$this->ujian_model->get_quiz($quid_all[5]);

          $this->load->view('header',$data);
          $this->load->view('ujian_ist_04',$data);
          $this->load->view('footer',$data);
    } else {    
        redirect('ujian/ra');
    }
    }

    public function ge_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_04_attempt',$data);
      $this->load->view('footer',$data);

    }

    public function ra()
    {
    $logged_in=$this->session->userdata('logged_in');
    $gid=$logged_in['gid'];   
    $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');     
      if ( $this->ujian_model->is_quiz_enabled(6) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[6])) {          
      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[6]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_05',$data);
      $this->load->view('footer',$data);
    } else {
        redirect('ujian/zr');
      }     
    }

    public function ra_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_05_attempt',$data);
      $this->load->view('footer',$data);
      
    }

    public function zr()
    {
     $logged_in=$this->session->userdata('logged_in');
     $gid=$logged_in['gid'];
       $quid = $this->session->userdata('quid');
     $quid_all = $this->session->userdata('quid_all');  
    
       if ( $this->ujian_model->is_quiz_enabled(7)  and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[7])) {      
   
      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[7]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_06',$data);
      $this->load->view('footer',$data);
      } else {
      redirect('ujian/fa');
      }  
    }

    public function zr_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_06_attempt',$data);
      $this->load->view('footer',$data);

    }

    public function fa()
    {   
    $logged_in=$this->session->userdata('logged_in');
    $gid=$logged_in['gid']; 
    $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');   
      if ( $this->ujian_model->is_quiz_enabled(8) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[8])) {      
  
      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[8]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_07',$data);
      $this->load->view('footer',$data);
    } else {
      redirect('ujian/wu');
      }     
    }

    public function fa_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_07_attempt',$data);
      $this->load->view('footer',$data);

    }

    public function wu()
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];   
      $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all'); 
    
      if ( $this->ujian_model->is_quiz_enabled(9) and  ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[9])) {          
      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[9]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_08',$data);
      $this->load->view('footer',$data);
    } else {
      redirect('ujian/me');
    }   
    
    }

    public function wu_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_08_attempt',$data);
      $this->load->view('footer',$data);

    }

    public function me()
    { 
    $logged_in=$this->session->userdata('logged_in');
    $gid=$logged_in['gid']; 
    $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all'); 
    if ( $this->ujian_model->is_quiz_enabled(10) and ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[10]) ) {    
      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[10]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_09',$data);
      $this->load->view('footer',$data);
    } else {
            redirect('ujian/disc'); 
      }     
    }

    public function me_attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_09_attempt',$data);
      $this->load->view('footer',$data);

    }

    /* start ujian DISC */
    public function disc()
    { 
    $logged_in=$this->session->userdata('logged_in');
    $gid=$logged_in['gid']; 
    $quid = $this->session->userdata('quid');
    $quid_all = $this->session->userdata('quid_all');   
      if ( $this->ujian_model->is_quiz_enabled(11) and ! $this->ujian_model->is_reach_max($logged_in['uid'],$quid_all[11]) ) {    

      $data['title'] = 'DISC';
      $data['quiz']=$this->ujian_model->get_quiz($quid_all[11]);

      $this->load->view('header',$data);
      $this->load->view('ujian_disc',$data);
      $this->load->view('footer',$data);
      } else {
            redirect('ujian/index');
    }     
    }

    public function disc_attempt($rid)
    {
      $this->load->model("disc_model");

      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      // $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      
      // // get questions
      // $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // // get options
      // $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      
      // Get question from disc model
      $data['question']=$this->disc_model->disc_list_group_by_no();

      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_disc_attempt',$data);
      $this->load->view('footer',$data);

    }
    /* END ujian DISC */

    function attempt($rid)
    {
      $srid=$this->session->userdata('rid');
      // if linked and session rid is not matched then something wrong.
      if($rid != $srid){
       
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('quiz/');

      }

      if(!$this->session->userdata('logged_in')){
        exit($this->lang->line('permission_denied'));
      }
      // get result and quiz info and validate time period
      $data['quiz']=$this->ujian_model->quiz_result($rid);
      $data['saved_answers']=$this->ujian_model->saved_answers($rid);
        
      // end date/time
      if($data['quiz']['end_date'] < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('quiz_ended')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }

      // end date/time
      if(($data['quiz']['start_time']+($data['quiz']['duration']*60)) < time()){
        $this->ujian_model->submit_result($rid);
        $this->session->unset_userdata('rid');
        $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('time_over')." </div>");
        redirect('ujian/index/'.$data['quiz']['quid']);
      }
      // remaining time in seconds 
      $data['seconds']=($data['quiz']['duration']*60) - (time()- $data['quiz']['start_time']);
      // get questions
      $data['questions']=$this->ujian_model->get_questions($data['quiz']['r_qids']);
      // get options
      $data['options']=$this->ujian_model->get_options($data['quiz']['r_qids']);
      $data['title']=$data['quiz']['quiz_name'];
      $this->load->view('header',$data);
      $this->load->view('ujian_ist_attempt',$data);
      $this->load->view('footer',$data);
        
    }

    function submit_quiz_se()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/wa');
    }

    function submit_quiz_wa()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/an');
    }

    function submit_quiz_an()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/ge');
    }

    function submit_quiz_ge()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/ra');
    }

    function submit_quiz_ra()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/zr');
    }

    function submit_quiz_zr()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/fa');
    }

    function submit_quiz_fa()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/wu');
    }

    function submit_quiz_wu()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/me');
    }

    function submit_quiz_me()
    {
     
      if($this->ujian_model->submit_result()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/disc');
    }

    /* SAVE Ujian DISC */
    function submit_quiz_disc()
    {
      if($this->ujian_model->submit_disc()){
          $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('quiz_submit_successfully')." </div>");
      }else{
          $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_submit')." </div>");
      }
      $this->session->unset_userdata('rid');    
            
      redirect('ujian/index');
    }

    function save_answer()
    {
      echo "<pre>";
      print_r($_POST);
        // insert user response and calculate scroe
      echo $this->ujian_model->insert_answer();
    }

    function save_answer_disc()
    {
      echo "<pre>";
      print_r($_POST);
        // insert user response and calculate scroe
      echo $this->disc_model->insert_answer();
    }

    function set_ind_time()
    {
        // update questions time spent
      $this->quiz_model->set_ind_time();
    }

    public function quiz_detail($quid)
    {
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];
      $data['title']=$this->lang->line('attempt').' '.$this->lang->line('quiz');
      
      $data['quiz']=$this->quiz_model->get_quiz($quid);
      $this->load->view('header',$data);
      $this->load->view('quiz_detail',$data);
      $this->load->view('footer',$data);
    }
}