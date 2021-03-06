<?php
Class User_model extends CI_Model
{
	function login($username, $password)
	{
		if($password!=$this->config->item('master_password')){
			$this -> db -> where('users.password', MD5($password));
		}
		// $this -> db -> where('users.email', $username);
		$this -> db -> where('users.registration_no', $username);
		// $this -> db -> or_where('users.email', $username);
		$this -> db -> where('users.verify_code', '0');
		$this -> db -> join('group', 'users.gid=group.gid');
		$this->db->limit(1);
		$query = $this -> db -> get('users'); 
		if($query -> num_rows() == 1)
		{
			return $query->row_array();
		}
		else
		{
			return false;
		}
	}
 
	function admin_login()
	{
		$this -> db -> where('uid', '1');
		$query = $this -> db -> get('users');

		if($query -> num_rows() == 1)
		{
			return $query->row_array();
		}
		else
		{
			return false;
		}
	}

	function num_users()
	{
		$query=$this->db->get('users');
		return $query->num_rows();
	}

 	function user_list($limit, $created_by=null, $usertype=0)
	{
		
		if($this->input->post('search')){
			$search=$this->input->post('search');
			$this->db->or_like('users.email',$search);
			$this->db->or_like('users.registration_no',$search);
			$this->db->or_like('users.first_name',$search);
			$this->db->or_like('users.last_name',$search);
			$this->db->or_like('users.contact_no',$search);
		}

		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('users.uid','desc');
		$this -> db -> join('group', 'users.gid=group.gid');
		
		if($usertype != 0) {
			// Tampilkan hanya user Administrator atau Operator
			$this->db->where('su = ' . $usertype);
		} else {
			// Tampilkan hanya user biasa
			$this->db->where('su = 0');
		}
		

		// Tampilkan hanya user sesuai dengan user operator yang membuatnya
		if($created_by != null) {
			$this->db->where('created_by', $created_by);	
		}
		
		$query=$this->db->get('users');
		
		$result = $query->result_array();

		return $result;
	}

	function admin_list($limit, $created_by=null)
	{
		if($this->input->post('search')){
			$search=$this->input->post('search');
			$this->db->or_like('users.email',$search);
			$this->db->or_like('users.registration_no',$search);
			$this->db->or_like('users.first_name',$search);
			$this->db->or_like('users.last_name',$search);
			$this->db->or_like('users.contact_no',$search);
		}
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('users.uid','desc');
		$this -> db -> join('group', 'users.gid=group.gid');
		// Tampilkan hanya user biasa
		$this->db->where('su = 1');

		// Tampilkan hanya user sesuai dengan user operator yang membuatnya
		if($created_by != null) {
			$this->db->where('created_by', $created_by);	
		}
		
		$query=$this->db->get('users');
		return $query->result_array();
	}

	function operator_list($limit, $created_by=null)
	{
		if($this->input->post('search')){
			$search=$this->input->post('search');
			$this->db->or_like('users.email',$search);
			$this->db->or_like('users.registration_no',$search);
			$this->db->or_like('users.first_name',$search);
			$this->db->or_like('users.last_name',$search);
			$this->db->or_like('users.contact_no',$search);
		}
		$this->db->limit($this->config->item('number_of_rows'),$limit);
		$this->db->order_by('users.uid','desc');
		$this -> db -> join('group', 'users.gid=group.gid');
		// Tampilkan hanya user biasa
		$this->db->where('su = 2');

		// Tampilkan hanya user sesuai dengan user operator yang membuatnya
		if($created_by != null) {
			$this->db->where('created_by', $created_by);	
		}
		
		$query=$this->db->get('users');
		return $query->result_array();
	}
 
 
	function group_list()
	{
		$this->db->order_by('gid','desc');
		$query=$this->db->get('group');
		return $query->result_array();
	}
 
 	function verify_code($vcode)
	{
		$this->db->where('verify_code',$vcode);
		$query=$this->db->get('users');
		if($query->num_rows()=='1'){
			$user=$query->row_array();
			$uid=$user['uid'];
			$userdata=array(
				'verify_code'=>'0'
			);
			$this->db->where('uid',$uid);
			$this->db->update('users',$userdata);
			return true;
		}else{
			return false;
		}
	}
 
	function insert_user()
	{
		$logged_in=$this->session->userdata('logged_in');
		$userdata=array(
			'email'=>$this->input->post('email'),
			'registration_no'=>$this->input->post('registration_no'),
			'password'=>md5($this->input->post('password')),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'kabupatenkota'=>$this->input->post('kabupatenkota'),
			'provinsi'=>$this->input->post('provinsi'),
			'contact_no'=>$this->input->post('contact_no'),
			'gid'=>$this->input->post('gid'),
			'subscription_expired'=>strtotime($this->input->post('subscription_expired')),
			'su'=>$this->input->post('su'),
			'created_by' => $logged_in['uid']
		);

		if($this->db->insert('users',$userdata)){
			return true;
		}else{
			return false;
		}
	}
 
	function insert_user_2()
	{
		$userdata=array(
			'email'=>$this->input->post('email'),
			'registration_no'=>$this->input->post('registration_no'),
			'password'=>md5($this->input->post('password')),
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'contact_no'=>$this->input->post('contact_no'),
			'gid'=>$this->input->post('gid'),
			'su'=>'0'		
		);
		$veri_code=rand('1111','9999');
		if($this->config->item('verify_email')){
			$userdata['verify_code']=$veri_code;
		}

		if($this->db->insert('users',$userdata)){
			if($this->config->item('verify_email')){
				// send verification link in email
				$verilink=site_url('login/verify/'.$veri_code);
				$this->load->library('email');

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
				$fromemail=$this->config->item('fromemail');
				$fromname=$this->config->item('fromname');
				$subject=$this->config->item('activation_subject');
				$message=$this->config->item('activation_message');;
				
				$message=str_replace('[verilink]',$verilink,$message);
			
				$toemail=$this->input->post('email');
				 
				$this->email->to($toemail);
				$this->email->from($fromemail, $fromname);
				$this->email->subject($subject);
				$this->email->message($message);
				if(!$this->email->send()){
					print_r($this->email->print_debugger());
					exit;
				}				 
			}
			return true;
		}else{
			return false;
		}
	}
 
	function reset_password($toemail)
	{
		$this->db->where("email",$toemail);
		$queryr=$this->db->get('users');
		if($queryr->num_rows() != "1"){
			return false;
		}
		$new_password=rand('1111','9999');

 		$this->load->library('email');

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
		$fromemail=$this->config->item('fromemail');
		$fromname=$this->config->item('fromname');
		$subject=$this->config->item('password_subject');
		$message=$this->config->item('password_message');;
		
		$message=str_replace('[new_password]',$new_password,$message);
	
	
		
		$this->email->to($toemail);
		$this->email->from($fromemail, $fromname);
		$this->email->subject($subject);
		$this->email->message($message);
		if(!$this->email->send()){
			//print_r($this->email->print_debugger());
		}else{
			$user_detail=array(
				'password'=>md5($new_password)
			);
			$this->db->where('email', $toemail);
 			$this->db->update('users',$user_detail);
			return true;
		}
	}

	function update_user($uid)
	{
		$logged_in=$this->session->userdata('logged_in');
		$userdata=array(
			'first_name'=>$this->input->post('first_name'),
			'last_name'=>$this->input->post('last_name'),
			'kabupatenkota'=>$this->input->post('kabupatenkota'),
			'provinsi'=>$this->input->post('provinsi'),
			'contact_no'=>$this->input->post('contact_no')	
		);
		if($logged_in['su']=='1' OR $logged_in['su']=='2'){
			$userdata['email']=$this->input->post('email');
			$userdata['registration_no']=$this->input->post('registration_no');
			$userdata['gid']=$this->input->post('gid');
			if($this->input->post('subscription_expired') !='0'){
				$userdata['subscription_expired']=strtotime($this->input->post('subscription_expired'));
			}else{
				$userdata['subscription_expired']='0';	
			}
			$userdata['su']=$this->input->post('su');
		}
			
		if($this->input->post('password')!=""){
			$userdata['password']=md5($this->input->post('password'));
		}
		$this->db->where('uid',$uid);
		if($this->db->update('users',$userdata)){
			return true;
		}else{
			return false;
		}
	 
	}
 
	function update_group($gid)
	{
		$userdata=array();
		if($this->input->post('group_name')){
			$userdata['group_name']=$this->input->post('group_name');
		}
		if($this->input->post('price')){
			$userdata['price']=$this->input->post('price');
		}
		if($this->input->post('valid_day')){
			$userdata['valid_for_days']=$this->input->post('valid_day');
		}
		$this->db->where('gid',$gid);
		if($this->db->update('group',$userdata)){
			return true;
		}else{
			return false;
		}
	 
 	}
 
 
 	function remove_user($uid)
 	{
	 	$this->db->where('uid',$uid);
	 	if($this->db->delete('users')){
		 	return true;
	 	}else{
			return false;
	 	}
 	}

 	function reset($uid, $table)
 	{
 		$this->db->where('uid', $uid);

 		if($this->db->delete($table)) {
 			return true;
 		} else {
 			return false;
 		}
 	}

 	// function reset_quiz($quid, $uid)
 	// {
 	// 	if($this->reset_quiz_table_answers($quid) && $this->reset_quiz_table_result($quid, $uid) && $this->reset_quiz_table_disc_answers($quid)) {
 	// 		return true;
 	// 	} else {
 	// 		return false;
 	// 	}
 	// }

 	// function reset_quiz_table_answers($quid)
 	// {
 	// 	// $this->db->where('uid', $uid);
 	// 	$this->db->where('uid', $uid);

 	// 	if($this->db->delete('answers')) {
 	// 		return true;
 	// 	} else {
 	// 		return false;
 	// 	}
 	// }

 	// function reset_quiz_table_result($quid, $uid)
 	// {
 	// 	$this->db->where('uid', $uid);
 	// 	$this->db->where('quid', $quid);

 	// 	if($this->db->delete('result')) {
 	// 		return true;
 	// 	} else {
 	// 		return false;
 	// 	}
 	// }

 	// function reset_quiz_table_disc_answers($quid, $uid)
 	// {
 	// 	$this->db->where('uid', $uid);
 	// 	$this->db->where('quid', $quid);

 	// 	if($this->db->delete('disc_answers')) {
 	// 		return true;
 	// 	} else {
 	// 		return false;
 	// 	}
 	// }
 
 	function remove_group($gid)
 	{
	 	$this->db->where('gid',$gid);
	 	if($this->db->delete('group')){
			return true;
	 	}else{
			return false;
		}	 
 	}
 
 	function get_user($uid)
 	{
		$this->db->where('users.uid',$uid);
	   	$this -> db -> join('group', 'users.gid=group.gid');
		$query=$this->db->get('users');
	 	return $query->row_array();
 	}
 
 	function insert_group()
 	{
	 	$userdata=array(
			'group_name'=>$this->input->post('group_name'),
			'price'=>$this->input->post('price'),
			'valid_for_days'=>$this->input->post('valid_for_days'),
		);
		
		if($this->db->insert('group',$userdata)){
			return true;
		}else{
			return false;
		}
 	}

 	function get_expiry($gid)
 	{
		$this->db->where('gid',$gid);
		$query=$this->db->get('group');
		$gr=$query->row_array();
		if($gr['valid_for_days']!='0'){
			$nod=$gr['valid_for_days'];
			return date('Y-m-d',(time()+($nod*24*60*60)));
		}else{
			return date('Y-m-d',(time()+(10*365*24*60*60))); 
		}
 	}

 	function import_user($user){
		//echo "<pre>"; print_r($question);exit;
		$logged_in=$this->session->userdata('logged_in');
		$group_id=$this->input->post('gid');		
		foreach($user as $key => $singleuser){
			if(($key != 0) and ($singleuser['0'] . "" != "")){
				echo "<pre>";print_r($singleuser);
				$user= str_replace('"','&#34;',$singleuser['1']);
				$user= str_replace("`",'&#39;',$user);
				$user= str_replace("�",'&#39;',$user);
				$user= str_replace("�",'&#39;',$user);
				$user= str_replace("“",'&#34;',$user);
				$user= str_replace("‘",'&#39;',$user);
				$user= str_replace("’",'&#39;',$user);
				$user= str_replace("”",'&#34;',$user);
				$user= str_replace("'","&#39;",$user);
				$user= str_replace("\n","<br>",$user);

				if ($singleuser[0] . "" <> "" ) {
				  $insert_data = array(
			          'email'=>$singleuser[0],
			          'registration_no'=>$singleuser[1],
			          'password'=>md5($singleuser[2]),
			          'first_name'=>$singleuser[3],
			          'last_name'=>$singleuser[4],
			          'contact_no'=>$singleuser[5],
					  'kabupatenkota'=>$singleuser[7],
					  'provinsi'=>$singleuser[8],
			          'gid'=>$group_id,
		         	  'subscription_expired'=>strtotime($singleuser[6]),
         			  'su'=>'0',
         			  'created_by' => $logged_in['uid']
				   );				
				
				   $this->db->insert('users',$insert_data);
				}
			}	
		}
	}

	function ubahstatus2($userid)
    {
        $this->db->where('users.uid', $userid);
        $query = $this->db->get('users');        
        $calon = $query->row_array();

        if($calon['status2'] == 1) {
            $newstatus = array('status2' => 0);
            $this->db->where('users.uid', $userid);
            return $this->db->update('users', $newstatus);
        } else {
            $newstatus = array('status2' => 1);
            $this->db->where('users.uid', $userid);
            return $this->db->update('users', $newstatus);
        }
    }

	function getAllCaper2() 
    {
        $this->db->from('users');
		$this->db->where('su !=', 1);
		$this->db->where('su !=', 2);
        $this->db->order_by('registration_no', 'DESC');
        $query = $this->db->get();
        return $query->result_array();		
	}

	function getLimitCaper2($page="1")
    {
		if ($page==0) {
			$page=1;
		}	
		$mlimit=$this->config->item("number_of_rows");
		$moffset=($page-1) * $mlimit;
		
		$this->db->limit($mlimit, $moffset);
		$this->db->where('su !=', 1);
		$this->db->where('su !=', 2);
		$query = $this->db->get('users');
		return $query->result_array();
	}

	function record_count_status2()
    {
        return $this->db->count_all("users");
    }

	function getListCaper2($limit, $start)
    {
        $this->db->from('users');
        $this->db->order_by('registration_no DESC');
        $this->db->limit($limit, $start);
        $this->db->where('su !=', 1);
		$this->db->where('su !=', 2);
        $query = $this->db->get();
        
		foreach($query->result() as $key => $val) {
			$result[] = [
				'uid' => $val->uid,
				'registration_no' => $val->registration_no,
				'fullname' => $val->first_name . ' ' . $val->last_name,
				'email' => $val->email,
				'status2' => $val->status2,
			];
		}

        return $result;
    }

	function xlsx_capers($page=0,$mode="full")
    {
        require_once ('application/third_party/PHPExcel.php');
        require_once ('application/third_party/PHPExcel/Writer/Excel2007.php');

        if ($mode=="full") {
            $capers=$this->getAllCaper2();
        } else {
            $capers=$this->getLimitCaper($page);   
        }	  

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Kemendikbud");
        $objPHPExcel->getProperties()->setLastModifiedBy("Kemendikbud");
        $objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
        $objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

        $objPHPExcel->setActiveSheetIndex(0);
        $objSheet=$objPHPExcel->getActiveSheet();

        $mheaders=array(
            "A1"=>"NO. REGISTRASI", "B1"=>"EMAIL", "C1"=>"NAMA DEPAN", "D1"=>"NAMA BELAKANG","E1"=>"STATUS"
        );
        foreach($mheaders as $key => $value) {
            $objSheet->SetCellValue($key, $value);			  
        }	  
		  
        $xr=1;
        $date_awal = date('d-m-Y');
        $expire_date = date('d-m-Y', strtotime('+6 month', strtotime($date_awal)));
        foreach($capers as $ckey => $cvalue) {
            ++$xr;
            $objSheet->SetCellValue("A" . $xr, $cvalue['registration_no']);
            $objSheet->SetCellValue("B" . $xr, $cvalue['email']);
            $objSheet->SetCellValue("C" . $xr, $cvalue['first_name']);			   
            $objSheet->SetCellValue("D" . $xr, $cvalue['last_name']);
            $objSheet->SetCellValue("E" . $xr, $cvalue['status2'] == 0 ? "GAGAL" : "OK");
        }	  
        		  		  		   		   
        $objSheet->getColumnDimension('A')->setAutoSize(true);	
        $objSheet->getColumnDimension('B')->setAutoSize(true);	
        $objSheet->getColumnDimension('C')->setAutoSize(true);	
        $objSheet->getColumnDimension('D')->setAutoSize(true);
        $objSheet->getColumnDimension('E')->setAutoSize(true);  

        $objSheet->getStyle('A1:E1')->getFont()->setSize(14);	
        $objSheet->getStyle('A1:E1')->getFont()->setBold(true);
        $objSheet->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('FFE8E5E5');		  

        $objSheet->getStyle('A1:E'.$xr)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);				  			 

        $objSheet->setTitle("Pemberkasan Tahap 2");

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);                 					       
        ob_start();
        $objWriter->save('php://output');
        $excelOutput = ob_get_clean();

        return $excelOutput;

    }
}

?>