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
      $data['title']='Daftar Ujian IST';
      // fetching quiz list
      $data['result'] = $this->ujian_model->ujian_list();

      foreach ($data['result'] as $key => $value) {
        $data['quid'][$key] = $value['quid'];
        $key++;
      }

      $this->session->set_userdata('quid', $data['quid']);
      
      $this->load->view('header',$data);
      $this->load->view('ujian_list',$data);
      $this->load->view('footer',$data);
    }

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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[0]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_01',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[1]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_02',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[2]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_03',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[3]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_04',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[4]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_05',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[5]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_06',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[6]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_07',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[7]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_08',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'IST';
      $data['quiz']=$this->ujian_model->get_quiz($quid[8]);

      $this->load->view('header',$data);
      $this->load->view('ujian_ist_09',$data);
      $this->load->view('footer',$data);
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
      $quid = $this->session->userdata('quid');
      $logged_in=$this->session->userdata('logged_in');
      $gid=$logged_in['gid'];

      $data['title'] = 'DISC';
      $data['quiz']=$this->ujian_model->get_quiz($quid[9]);

      $this->load->view('header',$data);
      $this->load->view('ujian_disc',$data);
      $this->load->view('footer',$data);
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