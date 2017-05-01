<?php
Class Hasil_model extends CI_Model
{
    function hasil_resume($limit=0,$full_range=false,$gid=null,$created_by=null,$n_search=null)
    {								
        if($gid != null and $gid !=0) {
            $group_id = ' and d.gid = '. $gid . ' ';
        } else {		
            if ($this->input->post('group')) {
                $group_id = ' and d.gid = '. $this->input->post('group') . ' ';
            } else {			
                $group_id = '';
            }					
        }		
		
        // Tampilkan hanya user sesuai dengan user operator yang membuatnya
        if($created_by != null and $created_by !=0 ) {
            $creator_id = ' and d.created_by = '. $created_by . ' ';
        } else {
            if ($this->input->post('operator')) {
                $creator_id = ' and d.created_by = '.  $this->input->post('operator') . ' ';
            } else {          		         		
                $creator_id = '';
            }	
        }
		
        // Tampilkan hanya user sesuai dengan provinsinya
        
        if ($this->input->post('provinsi')) {
              $provinsi = ' and d.provinsi = \''.  $this->input->post('provinsi') . '\' ';
            } else {          		         		
                $provinsi = '';
        }	
		
        // Tampilkan hanya user sesuai dengan yang di cari       
        if ($this->input->post('n_search')) {
              $n_search = ' and ( d.first_name like \'%'.  $this->input->post('n_search') . '%\' ||  d.last_name like \'%'.  $this->input->post('n_search') . '%\') ';
            } else {          		         		
                $n_search = '';
        }			
        	
				
        
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           //$offset_start= $limit * $this->config->item('number_of_rows');
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }   
    
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,' . 
		           'd.gid as gid,d.created_by as created_by_id,g.group_name as group_name,'  .
				   'concat(cb.first_name,\' \',cb.last_name) as created_by_name, ' .
				   'd.kabupatenkota as kabupatenkota, d.provinsi as provinsi, ';
        
        // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $query_cat = $this->db->get('category');
        $result_cat = $query_cat->result_array();
        
        foreach ($result_cat as $key => $value) {
            $c = $key+1;
            $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        }
        
        $script .= '
                round(sum(a.score_u), 0) as total
                from `answers` a
                left join `qbank` b on b.qid = a.qid
                left join `category` c on c.cid = b.cid
                left join `users` d on d.uid = a.uid
				left join `group` g on g.gid=d.gid
				left join `users` cb on cb.uid = d.created_by
                where d.su != 1 ' . $creator_id . $group_id . $provinsi . $n_search .
                ' group by d.uid
                order by total desc ' . $qoption;

        // echo $script;

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();
        
        // var_dump($result);die();
        return $result;
                
    }    

    function hasil_list($limit=0,$full_range=false,$gid=null, $created_by=null)
    {
        /*		
        if($this->input->post('operator') || $this->input->post('group')){
            $operator=$this->input->post('operator');
            $group=$this->input->post('group');
            $filters = ' d.gid = ' . $group;
        } else {
            $filters = '';
        }
        */
		
        if($gid != null and $gid !=0) {
            $group_id = ' and d.gid = '. $gid . ' ';
        } else {		
            if ($this->input->post('group')) {
		           $group_id = ' and d.gid = '. $this->input->post('group') . ' ';
               } else {			
                   $group_id = '';
	           }					
        }		
		
        // Tampilkan hanya user sesuai dengan user operator yang membuatnya
        if($created_by != null and $created_by !=0 ) {
            $creator_id = ' and d.created_by = '. $created_by . ' ';
        } else {
           if ($this->input->post('operator')) {
		        $creator_id = ' and d.created_by = '.  $this->input->post('operator') . ' ';
              } else {          		         		
                $creator_id = '';
			  }	
        }	

       // Tampilkan hanya user sesuai dengan provinsinya
        
        if ($this->input->post('provinsi')) {
              $provinsi = ' and d.provinsi = \''.  $this->input->post('provinsi') . '\' ';
            } else {          		         		
                $provinsi = '';
        }	
        			
		
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }
                
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,' .
		           'd.gid as gid,d.created_by as created_by_id,g.group_name as group_name,'  .		
				   'concat(cb.first_name,\' \',cb.last_name) as created_by_name,' .
				   'd.kabupatenkota as kabupatenkota, d.provinsi as provinsi,' ;
				   
        
        // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $this->db->where('grup', '1');
        $query_cat = $this->db->get('category');
        $result_cat = $query_cat->result_array();
        
        foreach ($result_cat as $key => $value) {
            $c = $key+1;
            $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        }
        
        $script .= '
                round(sum(a.score_u), 0) as total
                from answers a
                left join qbank b on b.qid = a.qid
                left join category c on c.cid = b.cid
                left join users d on d.uid = a.uid
				left join `group` g on g.gid=d.gid
				left join `users` cb on cb.uid = d.created_by
                where d.su != 1 ' . $creator_id . $group_id . $provinsi .				                
                ' group by d.uid
                order by total desc ' . $qoption;

        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from answers a
        //         left join qbank b on b.qid = a.qid
        //         left join category c on c.cid = b.cid
        //         left join users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result;
    }

    function hasil_detail($uid, $grup=null)
    {
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,';
        
        // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        if(isset($grup)) {
            $this->db->where('grup', $grup);    
        }
        
        $query_cat = $this->db->get('category');
        $result_cat = $query_cat->result_array();
        
        foreach ($result_cat as $key => $value) {
            $c = $key+1;
            $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        }
        
        $script .= '
                round(sum(a.score_u), 0) as total
                from answers a
                left join qbank b on b.qid = a.qid
                left join category c on c.cid = b.cid
                left join users d on d.uid = a.uid
                where d.su != 1 and d.uid = ' . $uid . '
                group by d.uid
                order by total desc';

        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from answers a
        //         left join qbank b on b.qid = a.qid
        //         left join category c on c.cid = b.cid
        //         left join users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->row_array();

        return $result;
    }

    function hasil_tpu_tpa($limit=0,$full_range=false,$gid=null, $created_by=null)
    {
 		
       if($gid != null and $gid !=0) {
            $group_id = ' and d.gid = '. $gid . ' ';
        } else {		
            if ($this->input->post('group')) {
		           $group_id = ' and d.gid = '. $this->input->post('group') . ' ';
               } else {			
                   $group_id = '';
	           }					
        }		
		
        // Tampilkan hanya user sesuai dengan user operator yang membuatnya
        if($created_by != null and $created_by !=0 ) {
            $creator_id = ' and d.created_by = '. $created_by . ' ';
        } else {
           if ($this->input->post('operator')) {
		        $creator_id = ' and d.created_by = '.  $this->input->post('operator') . ' ';
              } else {          		         		
                $creator_id = '';
			  }	
        }		
		
		// Tampilkan hanya user sesuai dengan provinsinya
        
        if ($this->input->post('provinsi')) {
              $provinsi = ' and d.provinsi = \''.  $this->input->post('provinsi') . '\' ';
            } else {          		         		
                $provinsi = '';
        }	
        	
				
        
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }               
        //$offset_start= $limit * $this->config->item('number_of_rows');
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,' .
		           'd.gid as gid,d.created_by as created_by_id,g.group_name as group_name,'  .		
				   'concat(cb.first_name,\' \',cb.last_name) as created_by_name,' .
				   'd.kabupatenkota as kabupatenkota, d.provinsi as provinsi,' ;
        
        // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $this->db->where('grup', '0');
        $query_cat = $this->db->get('category');
        $result_cat = $query_cat->result_array();
        
        foreach ($result_cat as $key => $value) {
            $c = $key+1;
            $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        }
        
        $script .= '
                round(sum(a.score_u), 0) as total
                from answers a
                left join qbank b on b.qid = a.qid
                left join category c on c.cid = b.cid
                left join users d on d.uid = a.uid
                left join `group` g on g.gid=d.gid
				left join `users` cb on cb.uid = d.created_by
                where d.su != 1 ' . $creator_id . $group_id .	$provinsi .							                
                ' group by d.uid
                order by total desc ' . $qoption;
        
        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from answers a
        //         left join qbank b on b.qid = a.qid
        //         left join category c on c.cid = b.cid
        //         left join users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result;
    }

	
	
    function hasil_tpu_tpa_detail($uid)
    {
                
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,';
        
        // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $this->db->where('grup', '0');
        $query_cat = $this->db->get('category');
        $result_cat = $query_cat->result_array();
        
        foreach ($result_cat as $key => $value) {
            $c = $key+1;
            $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        }
        
        $script .= '
                round(sum(a.score_u), 0) as total
                from answers a
                left join qbank b on b.qid = a.qid
                left join category c on c.cid = b.cid
                left join users d on d.uid = a.uid
                where su != 1 and d.uid=' . "'" . $uid . "' " . '
                group by d.uid
                order by total desc';
        
        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result[0];
    }	
	
	
	
	
    function hasil_disc($limit=0,$full_range=false,$gid=null, $created_by=null)
    {
        $this->load->model("norma_model");
        
        if($gid != null and $gid !=0) {
            $group_id = ' and d.gid = '. $gid . ' ';
        } else {		
            if ($this->input->post('group')) {
		           $group_id = ' and d.gid = '. $this->input->post('group') . ' ';
               } else {			
                   $group_id = '';
	           }					
        }		
		
        // Tampilkan hanya user sesuai dengan user operator yang membuatnya
        if($created_by != null and $created_by !=0 ) {
            $creator_id = ' and d.created_by = '. $created_by . ' ';
        } else {
           if ($this->input->post('operator')) {
		        $creator_id = ' and d.created_by = '.  $this->input->post('operator') . ' ';
              } else {          		         		
                $creator_id = '';
			  }	
        }		
				
       // Tampilkan hanya user sesuai dengan provinsinya
        
        if ($this->input->post('provinsi')) {
              $provinsi = ' and d.provinsi = \''.  $this->input->post('provinsi') . '\' ';
            } else {          		         		
                $provinsi = '';
        }	
        	
								
		
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           //$offset_start= $limit * $this->config->item('number_of_rows');
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }           
        
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,' .
		           'd.gid as gid,d.created_by as created_by_id,g.group_name as group_name,'  .		
				   'concat(cb.first_name,\' \',cb.last_name) as created_by_name,' .
                   'd.kabupatenkota as kabupatenkota, d.provinsi as provinsi ' ;				   
        
         // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $this->db->where('grup', '2');
        // $query_cat = $this->db->get('category');
        // $result_cat = $query_cat->result_array();
        
        // foreach ($result_cat as $key => $value) {
        //     $c = $key+1;
        //     $script .= 'round(sum(case when c.cid='.$value['cid'].' then a.score_u else null end), 0) as ist'.$c.',';
        // }
        
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from answers a
        //         left join qbank b on b.qid = a.qid
        //         left join category c on c.cid = b.cid
        //         left join users d on d.uid = a.uid
        //         where su != 1 ' . $creator_id .
        //         ' group by d.uid
        //         order by total desc ' . $qoption;

        $script .= '
                FROM disc_answers a
                LEFT JOIN users d ON a.uid = d.uid
                LEFT JOIN result b ON a.rid = b.rid
                left join `group` g on g.gid=d.gid
				left join `users` cb on cb.uid = d.created_by
                where d.su != 1 ' . $creator_id . $group_id .	$provinsi .			
                'GROUP BY d.uid ' . $qoption;
        
        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from answers a
        //         left join qbank b on b.qid = a.qid
        //         left join category c on c.cid = b.cid
        //         left join users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result;
    }
   
}