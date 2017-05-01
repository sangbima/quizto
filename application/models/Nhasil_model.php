<?php 

Class Nhasil_model extends CI_Model
{
   function category($uid) {	   	   
		 $script = "select distinct u.uid, concat(u.first_name,' ',u.last_name) as fullname,c.cid,c.category_name from answers a " .  
                   "left join users u on u.uid=a.uid ".
                   "left join result r on r.rid=a.rid " .
                   "left join qcl qc on qc.quid=r.quid " .
                   "left join category c on c.cid=qc.cid " .  
                   "where a.uid='" . $uid . "' order by c.cid asc";  
				   
		 $query =  $query=$this->db->query($script);
         $result = $query->result_array();
		 		 		 		 				
		return $result;
       
   }
   
   
   function list_by_time($uid,$cid) {
	     $script = "select distinct u.uid,concat(u.first_name,' ',u.last_name) as fullname, c.cid,c.category_name, r.start_time,r.individual_time " . 		           
		           " from answers a " .
                   "left join users u on u.uid=a.uid " .
                   "left join result r on r.rid=a.rid " . 
                   "left join qcl qc on qc.quid=r.quid " .
                   "left join category c on c.cid=qc.cid " .
                   "left join qbank q on q.qid=a.qid "	.			   
                   "where a.uid='" . $uid . "' and c.cid='" . $cid . "'"; 
         $query =  $query=$this->db->query($script);
		 
         $result = $query->result_array();	   
		 return $result;
	   
   }   
   
   function quiz_by_time($uid,$cid,$start_time){
	     $script = "select distinct u.uid,concat(u.first_name,' ',u.last_name) as fullname, c.cid,c.category_name,r.start_time,r.individual_time,a.qid,q.question,a.score_u " . 		           
		           " from answers a " .
                   "left join users u on u.uid=a.uid " .
                   "left join result r on r.rid=a.rid " . 
                   "left join qcl qc on qc.quid=r.quid " .
                   "left join category c on c.cid=qc.cid " .
                   "left join qbank q on q.qid=a.qid "	.			   
                   "where a.uid='" . $uid . "' and c.cid='" . $cid . "' and r.start_time='" . $start_time. "'" ; 
         $query =  $query=$this->db->query($script);
         $result = $query->result_array();
		
        $i_times = explode(',',$result[0]['individual_time']);
		$q_pointer=0;
		$total_result=count($result);
        foreach($i_times as $key =>$times_value) {	
            		
			  if ($times_value>0 and $q_pointer<$total_result) {				
				$x_hasil=array("uid"=>$result[$q_pointer]['uid'],
				               "fullname"=>$result[$q_pointer]['fullname'],
				               "cid"=>$result[$q_pointer]['cid'],
						       "category_name"=>$result[$q_pointer]['category_name'],
						       "start_time"=>$result[$q_pointer]['start_time'],
							   "individual_time"=>$result[$q_pointer]['individual_time'],
							   "qid"=>$result[$q_pointer]['qid'],
							   "question"=>$result[$q_pointer]['question'],
							   "score_u"=>$result[$q_pointer]['score_u'],
                               "status"=>"ok");									 
				++$q_pointer;
		 	   } else {
				$x_hasil=array("uid"=>$result[0]['uid'],
				               "fullname"=>$result[0]['fullname'],
				               "cid"=>$result[0]['cid'],
				               "category_name"=>$result[0]['category_name'],
			                   "start_time"=>$result[0]['start_time'],
							   "individual_time"=>$result[0]['individual_time'],
				               "qid"=>"",
				               "question"=>"",
				               "score_u"=>0,
				               "status"=>"error");
               }				
			   $r_hasil[$key]=$x_hasil;
				
				
		}	
		      		
		return $r_hasil;				   
   }   
   
   
   function quiz($uid,$cid){
	     $script = "select distinct u.uid,concat(u.first_name,' ',u.last_name) as fullname, c.cid,c.category_name,a.qid,q.question " . 		           
		           " from answers a " .
                   "left join users u on u.uid=a.uid " .
                   "left join result r on r.rid=a.rid " . 
                   "left join qcl qc on qc.quid=r.quid " .
                   "left join category c on c.cid=qc.cid " .
                   "left join qbank q on q.qid=a.qid "	.			   
                   "where a.uid='" . $uid . "' and c.cid='" . $cid . "'"; 
         $query =  $query=$this->db->query($script);
         $result = $query->result_array();
		 		 		 		 		 				
		return $result;				   
   }   
   
   
   
   
   
   function answer($uid,$cid,$qid){
	     $script = "select u.uid,concat(u.first_name,' ',u.last_name) as fullname, c.cid,c.category_name,a.qid,a.aid,a.score_u,r.rid, r.start_time,r.individual_time " . 		           
		           " from answers a " .
                   "left join users u on u.uid=a.uid " .
                   "left join result r on r.rid=a.rid " . 
                   "left join qcl qc on qc.quid=r.quid " .
                   "left join category c on c.cid=qc.cid " .
                   "left join qbank q on q.qid=a.qid "	.	  				   
                   "where a.uid='" . $uid . "' and c.cid='" . $cid . "' and a.qid='" . $qid . "'"; 
         $query =  $query=$this->db->query($script);
         $result = $query->result_array();
		 		 		 		 													
		return $result;				   
   }      
   
   

}

?>
