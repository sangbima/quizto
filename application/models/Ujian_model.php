<?php
Class Ujian_model extends CI_Model
{
	
    function ujian_list_all()
    {
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']=='0'){
            $gid=$logged_in['gid'];
		    $where="FIND_IN_SET('".$gid."', gids)";              			        
            $this->db->where($where);
        }
        
        // $this->db->limit($this->config->item('number_of_rows'),$limit);
        $this->db->order_by('quid','asc');
        $query=$this->db->get('quiz');
        return $query->result_array();
    }	
	
    function ujian_list()
    {
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']=='0'){
            $gid=$logged_in['gid'];
		    $where="FIND_IN_SET('".$gid."', gids)";              
			$where .= " and status='1'";            
            $this->db->where($where);
        }
        
        // $this->db->limit($this->config->item('number_of_rows'),$limit);
        $this->db->order_by('quid','asc');
        $query=$this->db->get('quiz');
        return $query->result_array();
    }

    function get_quiz($quid){
        $this->db->where('quid',$quid);
        $this->db->where('status','1');		
        $query=$this->db->get('quiz');
        return $query->row_array();
    }

    function get_questions($qids){
        if($qids == ''){
            $qids=0; 
        }else{
            $qids=$qids;
        }
        /*
        if($cid!='0'){
        $this->db->where('qbank.cid',$cid);
        }
        if($lid!='0'){
        $this->db->where('qbank.lid',$lid);
        }
        */

        $query=$this->db->query("select * from qbank join category on category.cid=qbank.cid join level on level.lid=qbank.lid 
            where qbank.qid in ($qids) order by FIELD(qbank.qid,$qids) 
        ");
        return $query->result_array();
    }
 
    function get_options($qids){
        $query=$this->db->query("select * from options where qid in ($qids) order by FIELD(options.qid,$qids)");
        return $query->result_array();
    }

    function insert_result($quid,$uid){
        // get quiz info
        $this->db->where('quid',$quid);
        $query=$this->db->get('quiz');
        $quiz=$query->row_array();

        if($quiz['question_selection']=='0'){
            // get questions    
            $noq=$quiz['noq'];  
            $qids=explode(',',$quiz['qids']);
            $categories=array();
            $category_range=array();

            $i=0;
            $wqids=implode(',',$qids);
            $noq=array();
            $query=$this->db->query("select * from qbank join category on category.cid=qbank.cid where qid in ($wqids) ORDER BY FIELD(qid,$wqids)  ");  
            $questions=$query->result_array();
            foreach($questions as $qk => $question){
                if(!in_array($question['category_name'],$categories)){
                    $categories[]=$question['category_name'];
                    $noq[$i]+=1;
                }else{
                    $i+=1;
                    $noq[$i]+=1;    
                }
            }

            $categories=array();
            $category_range=array();

            $i=-1;
            foreach($questions as $qk => $question){
                if(!in_array($question['category_name'],$categories)){
                    $categories[]=$question['category_name'];
                    $i+=1;  
                    $category_range[]=$noq[$i];
                } 
            }
        }else{
            // randomaly select qids
            $this->db->where('quid',$quid);
            $query=$this->db->get('qcl');
            $qcl=$query->result_array();
            $qids=array();
            $categories=array();
            $category_range=array();

            foreach($qcl as $k => $val){
                $cid=$val['cid'];
                $lid=$val['lid'];
                $noq=$val['noq'];

                $i=0;
                $query=$this->db->query("select * from qbank join category on category.cid=qbank.cid where qbank.cid='$cid' and lid='$lid' ORDER BY RAND() limit $noq ");   
                $questions=$query->result_array();
                foreach($questions as $qk => $question){
                    $qids[]=$question['qid'];
                    if(!in_array($question['category_name'],$categories)){
                        $categories[]=$question['category_name'];
                        $category_range[]=$i+$noq;
                    }
                }
            }
        }
        $zeros=array();
        foreach($qids as $qidval){
            $zeros[]=0;
        }

        $userdata=array(
            'quid'=>$quid,
            'uid'=>$uid,
            'r_qids'=>implode(',',$qids),
            'categories'=>implode(',',$categories),
            'category_range'=>implode(',',$category_range),
            'start_time'=>time(),
            'individual_time'=>implode(',',$zeros),
            'score_individual'=>implode(',',$zeros),
            'attempted_ip'=>$_SERVER['REMOTE_ADDR'] 
        );

        if($this->session->userdata('photoname')){
            $photoname=$this->session->userdata('photoname');
            $userdata['photo']=$photoname;
        }
        $this->db->insert('result',$userdata);
        $rid=$this->db->insert_id();
        return $rid;
    }

    function open_result($quid,$uid){
        $result_open=$this->lang->line('open');
        $query=$this->db->query("select * from result  where result.result_status='$result_open' "); 
        if($query->num_rows() >= '1'){
            $result=$query->row_array();
            return $result['rid'];      
        }else{
            return '0';
        }
    }

    function quiz_result($rid){  
        $query=$this->db->query("select * from result join quiz on result.quid=quiz.quid where result.rid='$rid' "); 
        return $query->row_array(); 
    }

    function saved_answers($rid){
        $query=$this->db->query("select * from answers  where answers.rid='$rid' "); 
        return $query->result_array(); 
    }

    function submit_disc() {
        $logged_in=$this->session->userdata('logged_in');
        $quid=$this->session->userdata('quid');
        $email=$logged_in['email'];
        $rid=$this->session->userdata('rid');
        $query=$this->db->query("select * from result join disc_answers on result.quid=disc_answers.quid where result.rid='$rid' "); 
        $quiz=$query->row_array(); 

        $score_ind=explode(',',$quiz['score_individual']);
        $r_qids=explode(',',$quiz['r_qids']);
        $qids_perf=array();
        $marks=0;
        $correct_score=$quiz['correct_score'];
        $incorrect_score=$quiz['incorrect_score'];
        $total_time=array_sum(explode(',',$quiz['individual_time']));
        $manual_valuation=0;
        foreach($score_ind as $mk => $score){
            $qids_perf[$r_qids[$mk]]=$score;
            if($score == 1){
                $marks+=$correct_score;
            }
            if($score == 2){
                $marks+=$incorrect_score;
            }
            if($score == 3){
                $manual_valuation=1;
            }
        }
        // $percentage_obtained=($marks/$quiz['noq'])*100;
        $percentage_obtained=0;
        if($percentage_obtained >= $quiz['pass_percentage']){
            $qr=$this->lang->line('pass');
        }else{
            $qr=$this->lang->line('fail');
        }
        $userdata=array(
            'total_time'=>$total_time,
            'end_time'=>time(),
            'score_obtained'=>$marks,
            'percentage_obtained'=>$percentage_obtained,
            'manual_valuation'=>$manual_valuation
        );
        if($manual_valuation == 1){
            $userdata['result_status']=$this->lang->line('pending');
        }else{
            $userdata['result_status']=$qr;
        }
        $this->db->where('rid',$rid);
        $this->db->update('result',$userdata);

        // rid = 174
        // noq = 24
        // most0 = 1
        // least0 = 4
        // no_pernyataan =1
        // $disc=array(
        //     'D'=>'1',
        //     'I'=>'2',
        //     'S'=>'3',
        //     'C'=>'4',
        //     '*'=>'5',
        // );
        // ...
        // quid    qid uid most    least   rid
        // $userdata=array(
        //     'quid' => $quid,
        //     'qid'=>$no_pernyataan,
        //     'uid'=>$uid,
        //     'most'=>$most,
        //     'least'=>$least,
        //     'rid'=>$rid,
        // );
        // $this->db->insert('disc_answers',$userdata);
        $mosts = $_POST['most'];
        $leasts = $_POST['least'];
        $statements = $_POST['no_pernyataan'];

        $disc = array(
            1 => 'D',
            2 => 'I',
            3 => 'S',
            4 => 'C',
            5 => '*',
        );

        foreach ($mosts as $key => $most) {
            $userdata = array(
                'quid' => $quid[9],
                'qid' => $statements[$key],
                'uid' => $logged_in['uid'],
                'most' => $disc[$most],
                'least' => $disc[$leasts[$key]],
                'rid' => $rid
            );

            $this->db->insert('disc_answers',$userdata);
        }

        // for($n=0; $n<25; $n++) {
        //     $userdata = array(
        //         'quid' => $quid,
        //         'qid'=>$no_pernyataan,
        //         'uid'=>$uid,
        //         'most'=>$most,
        //         'least'=>$least,
        //         'rid'=>$rid,
        //     );
        // }

        return true;
    }

    function submit_result(){
        $logged_in=$this->session->userdata('logged_in');
        $email=$logged_in['email'];
        $rid=$this->session->userdata('rid');
        $query=$this->db->query("select * from result join quiz on result.quid=quiz.quid where result.rid='$rid' "); 
        $quiz=$query->row_array(); 
        $score_ind=explode(',',$quiz['score_individual']);
        $r_qids=explode(',',$quiz['r_qids']);
        $qids_perf=array();
        $marks=0;
        $correct_score=$quiz['correct_score'];
        $incorrect_score=$quiz['incorrect_score'];
        $total_time=array_sum(explode(',',$quiz['individual_time']));
        $manual_valuation=0;
        foreach($score_ind as $mk => $score){
            $qids_perf[$r_qids[$mk]]=$score;
            if($score == 1){
                $marks+=$correct_score;
            }
            if($score == 2){
                $marks+=$incorrect_score;
            }
            if($score == 3){
                $manual_valuation=1;
            }
        }
        $percentage_obtained=($marks/$quiz['noq'])*100;
        if($percentage_obtained >= $quiz['pass_percentage']){
            $qr=$this->lang->line('pass');
        }else{
            $qr=$this->lang->line('fail');
        }
        $userdata=array(
            'total_time'=>$total_time,
            'end_time'=>time(),
            'score_obtained'=>$marks,
            'percentage_obtained'=>$percentage_obtained,
            'manual_valuation'=>$manual_valuation
        );
        if($manual_valuation == 1){
            $userdata['result_status']=$this->lang->line('pending');
        }else{
            $userdata['result_status']=$qr;
        }
        $this->db->where('rid',$rid);
        $this->db->update('result',$userdata);
 
        foreach($qids_perf as $qp => $qpval){
            $crin="";
            if($qpval=='0'){
                $crin=", no_time_unattempted=(no_time_unattempted +1) "; 
            }else if($qpval=='1'){
                $crin=", no_time_corrected=(no_time_corrected +1)";      
            }else if($qpval=='2'){
                $crin=", no_time_incorrected=(no_time_incorrected +1)";      
            }
            $query_qp="update qbank set no_time_served=(no_time_served +1)  $crin  where qid='$qp'  ";
            $this->db->query($query_qp);
        }
 
        if($this->config->item('allow_result_email')){
            $this->load->library('email');
            $query = $this -> db -> query("select result.*,users.*,quiz.* from result, users, quiz where users.uid=result.uid and quiz.quid=result.quid and result.rid='$rid'");
            $qrr=$query->row_array();
            if($this->config->item('protocol')=="smtp"){
                $config['protocol'] = 'smtp';
                $config['smtp_host'] = $this->config->item('smtp_hostname');
                $config['smtp_user'] = $this->config->item('smtp_username');
                $config['smtp_pass'] = $this->config->item('smtp_password');
                $config['smtp_port'] = $this->config->item('smtp_port');
                $config['smtp_timeout'] = $this->config->item('smtp_timeout');
                $config['mailtype'] = $this->config->item('smtp_mailtype');
                $config['starttls']  = $this->config->item('starttls');
                $config['newline']  = $this->config->item('newline');

                $this->email->initialize($config);
            }
            $toemail=$qrr['email'];
            $fromemail=$this->config->item('fromemail');
            $fromname=$this->config->item('fromname');
            $subject=$this->config->item('result_subject');
            $message=$this->config->item('result_message');
        
            $subject=str_replace('[email]',$qrr['email'],$subject);
            $subject=str_replace('[first_name]',$qrr['first_name'],$subject);
            $subject=str_replace('[last_name]',$qrr['last_name'],$subject);
            $subject=str_replace('[quiz_name]',$qrr['quiz_name'],$subject);
            $subject=str_replace('[score_obtained]',$qrr['score_obtained'],$subject);
            $subject=str_replace('[percentage_obtained]',$qrr['percentage_obtained'],$subject);
            $subject=str_replace('[current_date]',date('Y-m-d H:i:s',time()),$subject);
            $subject=str_replace('[result_status]',$qrr['result_status'],$subject);
        
            $message=str_replace('[email]',$qrr['email'],$message);
            $message=str_replace('[first_name]',$qrr['first_name'],$message);
            $message=str_replace('[last_name]',$qrr['last_name'],$message);
            $message=str_replace('[quiz_name]',$qrr['quiz_name'],$message);
            $message=str_replace('[score_obtained]',$qrr['score_obtained'],$message);
            $message=str_replace('[percentage_obtained]',$qrr['percentage_obtained'],$message);
            $message=str_replace('[current_date]',date('Y-m-d H:i:s',time()),$message);
            $message=str_replace('[result_status]',$qrr['result_status'],$message);
        
            $this->email->to($toemail);
            $this->email->from($fromemail, $fromname);
            $this->email->subject($subject);
            $this->email->message($message);
            if(!$this->email->send()){
                //print_r($this->email->print_debugger());
            }
        }

        return true;
    }

    function insert_answer(){
        $rid=$_POST['rid'];
        $srid=$this->session->userdata('rid');
        $logged_in=$this->session->userdata('logged_in');
        $uid=$logged_in['uid'];
        if($srid != $rid){
            return "Something wrong";
        }
        $query=$this->db->query("select * from result join quiz on result.quid=quiz.quid where result.rid='$rid' "); 
        $quiz=$query->row_array(); 
        $correct_score=$quiz['correct_score'];
        $incorrect_score=$quiz['incorrect_score'];
        $qids=explode(',',$quiz['r_qids']);
        $vqids=$quiz['r_qids'];
        $correct_incorrect=explode(',',$quiz['score_individual']);

        // remove existing answers
        $this->db->where('rid',$rid);
        $this->db->delete('answers');
    
        foreach($_POST['answer'] as $ak => $answer){
            // DISC question
            // if($_POST['question_type'][$ak] == '6'){
            //     $qid=$qids[$ak];
            //     // $query=$this->db->query(" select * from options where qid='$qid' ");
            //     // $options_data=$query->result_array();
            //     // $options=array();
            //     // foreach($options_data as $ok => $option){
            //     //  $options[$option['oid']]=$option['score'];
            //     // }

            //     var_dump($answer);
            //     // $attempted=0;
            //     // $marks=0;
            //     // foreach($answer as $sk => $ansval){
            //     //  if($options[$ansval] <= 0 ){
            //     //      $marks+=-1; 
            //     //  }else{
            //     //      $marks+=$options[$ansval];
            //     //  }
            //     //  $userdata=array(
            //     //      'rid'=>$rid,
            //     //      'qid'=>$qid,
            //     //      'uid'=>$uid,
            //     //      'q_option'=>$ansval,
            //     //      'score_u'=>$options[$ansval]
            //     //  );
            //     //  $this->db->insert('answers',$userdata);
            //     //  $attempted=1;   
            //     // }
            // }

            // multiple choice single answer
            if($_POST['question_type'][$ak] == '1' || $_POST['question_type'][$ak] == '2'){
                 
                $qid=$qids[$ak];
                $query=$this->db->query(" select * from options where qid='$qid' ");
                $options_data=$query->result_array();
                $options=array();
                foreach($options_data as $ok => $option){
                    $options[$option['oid']]=$option['score'];
                }
                $attempted=0;
                $marks=0;
                foreach($answer as $sk => $ansval){
                    if($options[$ansval] <= 0 ){
                        $marks+=-1; 
                    }else{
                        $marks+=$options[$ansval];
                    }
                    $userdata=array(
                        'rid'=>$rid,
                        'qid'=>$qid,
                        'uid'=>$uid,
                        'q_option'=>$ansval,
                        'score_u'=>$options[$ansval]
                    );
                    $this->db->insert('answers',$userdata);
                    $attempted=1;   
                }
                if($attempted==1){
                    if($marks >= '0.99' ){
                        $correct_incorrect[$ak]=1;  
                    }else{
                        $correct_incorrect[$ak]=2;                          
                    }
                }else{
                    $correct_incorrect[$ak]=0;
                }
            }

            // short answer
            if($_POST['question_type'][$ak] == '3'){
                 
                $qid=$qids[$ak];
                $query=$this->db->query(" select * from options where qid='$qid' ");
                $options_data[$ak]=$query->row_array();
                $options_data[$ak] = explode(',',strtoupper($options_data[$ak]['q_option']));
                
                $n__1[$ak] = array();
                $n__2[$ak] = array();
                foreach($options_data[$ak] as $key => $value) {
                    if(strpos($value, '1__') === 0) {
                        $n__1[$ak][$key] = ltrim($value, substr($value, 0, 3));
                    }
                    if(strpos($value, '2__') === 0) {
                        $n__2[$ak][$key] = ltrim($value, substr($value, 0, 3));
                    }
                }

                // var_dump($n__1);
                // var_dump($n__2);
                // var_dump($options_data[$ak]);

                $attempted=0;
                $marks=0;

                foreach($answer as $k => $ansval) {
                    if($ansval != '') {
                        $ans_ex[$ak] = explode(',', strtoupper($ansval));

                        foreach($n__1[$ak] as $k => $v) {
                            if(in_array($v, $ans_ex[$ak])) {
                                $marks_1[$ak][] = 1;
                            } else {
                                $marks_1[$ak][] = 0;
                            }
                        }
                        foreach($n__2[$ak] as $k => $v) {
                            if(in_array($v, $ans_ex[$ak])) {
                                $marks_2[$ak][] = 1;
                            } else {
                                $marks_2[$ak][] = 0;
                            }
                        }

                        if(in_array(1, $marks_1[$ak]) or in_array(1, $marks_2[$ak])) {
                            if(in_array(1, $marks_1[$ak])) {
                                $marks = 1;
                            } else {
                                $marks = 2;
                            }
                        } else {
                            $marks = 0;
                        }
                    }

                    // Insert into databases
                    $attempted=1;
                    $userdata=array(
                        'rid'=>$rid,
                        'qid'=>$qid,
                        'uid'=>$uid,
                        'q_option'=>$ansval,
                        'score_u'=>$marks
                    );
                    $this->db->insert('answers',$userdata);
                }
                

                // Original
                // $qid=$qids[$ak];
                // $query=$this->db->query(" select * from options where qid='$qid' ");
                // $options_data=$query->row_array();
                // $options_data=explode(',',$options_data['q_option']);
                // $noptions=array();
                // foreach($options_data as $op){
                //  $noptions[]=strtoupper(trim($op));
                // }

                // $attempted=0;
                // $marks=0;
                // foreach($answer as $sk => $ansval){
                //  if($ansval != ''){
                //      if(in_array(strtoupper(trim($ansval)),$noptions)){
                //          $marks=1;   
                //      }else{
                //          $marks=0;
                //      }
                //      $attempted=1;
                //      $userdata=array(
                //          'rid'=>$rid,
                //          'qid'=>$qid,
                //          'uid'=>$uid,
                //          'q_option'=>$ansval,
                //          'score_u'=>$marks
                //      );
                //      $this->db->insert('answers',$userdata);
                //  }
                // }
                if($attempted==1){
                    if($marks==1){
                        $correct_incorrect[$ak]=1;  
                    }else{
                        $correct_incorrect[$ak]=2;                          
                    }
                }else{
                    $correct_incorrect[$ak]=0;
                }
            }
         
            // long answer
            if($_POST['question_type'][$ak] == '4'){
                $attempted=0;
                $marks=0;
                $qid=$qids[$ak];
                foreach($answer as $sk => $ansval){
                    if($ansval != ''){
                        $userdata=array(
                            'rid'=>$rid,
                            'qid'=>$qid,
                            'uid'=>$uid,
                            'q_option'=>$ansval,
                            'score_u'=>0
                        );
                        $this->db->insert('answers',$userdata);
                        $attempted=1;
                    }
                }
                if($attempted==1){
                    $correct_incorrect[$ak]=3;                          
                }else{
                    $correct_incorrect[$ak]=0;
                }
            }
         
            // match
            if($_POST['question_type'][$ak] == '5'){
                $qid=$qids[$ak];
                $query=$this->db->query(" select * from options where qid='$qid' ");
                $options_data=$query->result_array();
                $noptions=array();
                foreach($options_data as $op => $option){
                    $noptions[]=$option['q_option'].'___'.$option['q_option_match'];                
                }
                $marks=0;
                $attempted=0;
                foreach($answer as $sk => $ansval){
                    if($ansval != '0'){
                        $mc=0;
                        if(in_array($ansval,$noptions)){
                            $marks+=1/count($options_data);
                            $mc=1/count($options_data);
                        }else{
                            $marks+=0;
                            $mc=0;
                        }
                        $userdata=array(
                            'rid'=>$rid,
                            'qid'=>$qid,
                            'uid'=>$uid,
                            'q_option'=>$ansval,
                            'score_u'=>$mc
                        );
                        $this->db->insert('answers',$userdata);
                        $attempted=1;
                    }
                }
                if($attempted==1){
                    if($marks==1){
                        $correct_incorrect[$ak]=1;  
                    }else{
                        $correct_incorrect[$ak]=2;                          
                    }
                }else{
                    $correct_incorrect[$ak]=0;
                }
            }
        }

        
     
        $userdata=array(
            'score_individual'=>implode(',',$correct_incorrect),
            'individual_time'=>$_POST['individual_time'],
        );
        $this->db->where('rid',$rid);
        $this->db->update('result',$userdata);

        return true;
    }

    function count_result($quid,$uid){
        $this->db->where('quid',$quid);
        $this->db->where('uid',$uid);
        $query=$this->db->get('result');
        return $query->num_rows();
    }

    function is_reach_max($uid) {
        $cq=$this->db->query("select distinct cid from category");
        $cq_rows=$cq->num_rows();
        
        $sq=$this->db->query("select distinct rid from result where uid='$uid'"); 
        $rs_rows=$sq->row_array();      
        
        if ( $rs_rows >= $cq_rows ) 
            return true;
        else 
            return false;               
    }
	
	function is_quiz_enabled($priority=0) {
		$logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']=='0'){
            $gid=$logged_in['gid'];
		    $where="FIND_IN_SET('".$gid."', gids)";              
            $this->db->where($where);
        }
        
        // $this->db->limit($this->config->item('number_of_rows'),$limit);
        $this->db->order_by('quid','asc');
        $query=$this->db->get('quiz');
		$hasil=$query->result_array();
		
		if ( $hasil[$priority]['status']=="1") {
			$quiz_enabled=true;
		} else {
            $quiz_enabled=false;  
		} 				
		return $quiz_enabled;
	}	
	
}