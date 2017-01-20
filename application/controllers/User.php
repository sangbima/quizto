<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model("user_model");
		$this->load->model("quiz_model");
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

	public function index($limit='0')
	{
		$this->load->helper('form');
		$logged_in=$this->session->userdata('logged_in');
		 
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
			
		$data['limit']=$limit;
		$data['title']=$this->lang->line('userlist');

		// $data['quiz'] = $this->quiz_model->quiz_list($xlimit=0);
		
		// fetching user list
		$data['result']=$this->user_model->user_list($limit);

		// var_dump($data['result']);

		$data['group_list']=$this->user_model->group_list();          		
		
		$this->load->view('header',$data);
		$this->load->view('user_list',$data);
		$this->load->view('footer',$data);
	}
	
	public function new_user()
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
			
		$data['title']=$this->lang->line('add_new').' '.$this->lang->line('user');
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$this->load->view('header',$data);
		$this->load->view('new_user',$data);
		$this->load->view('footer',$data);
	}
	
	public function insert_user()
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
			redirect('user/new_user/');
        }
        else
		{
			if($this->user_model->insert_user()){
		        $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
			}else{
			    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
			}
			redirect('user/new_user/');
		}
	}

	public function remove_user($uid)
	{

		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
		if($uid=='1'){
			exit($this->lang->line('permission_denied'));
		}
		
		if($this->user_model->remove_user($uid)){
            $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
		}else{
		    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
		}
		redirect('user');
	}

	public function reset($uid)
	{

		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
		if($uid=='1'){
			exit($this->lang->line('permission_denied'));
		}
		
		if(($this->user_model->reset($uid, 'answers')) && ($this->user_model->reset($uid, 'disc_answers')) && ($this->user_model->reset($uid, 'result'))){
            $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('reset_successfully')." </div>");
		}else{
		    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_reset')." </div>");
		}
		redirect('user');
	}

	// public function reset_quiz($quid, $uid)
	// {
	// 	$logged_in=$this->session->userdata('logged_in');
	// 	if($logged_in['su']!='1'){
	// 		exit($this->lang->line('permission_denied'));
	// 	}
	// 	if($uid=='1'){
	// 		exit($this->lang->line('permission_denied'));
	// 	}

	// 	if($this->user_model->reset_quiz($quid, $uid)) {
	// 		$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('reset_successfully')." </div>");
	// 	}else{
	// 	    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_reset')." </div>");
	// 	}

	// 	redirect('user');
	// }

	public function edit_user($uid)
	{
		
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
	 		$uid=$logged_in['uid'];
		}
			
		$data['uid']=$uid;
	 	$data['title']=$this->lang->line('edit').' '.$this->lang->line('user');
		// fetching user
		$data['result']=$this->user_model->get_user($uid);
		$this->load->model("payment_model");
		$data['payment_history']=$this->payment_model->get_payment_history($uid);
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
	 	$this->load->view('header',$data);
		if($logged_in['su']=='1'){
			$this->load->view('edit_user',$data);
		}else{
			$this->load->view('myaccount',$data);
		}
		$this->load->view('footer',$data);
	}

	public function update_user($uid)
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			$uid=$logged_in['uid'];
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Email', 'required');
       	if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('message', "<div class='alert alert-danger'>".validation_errors()." </div>");
			redirect('user/edit_user/'.$uid);
        }
        else
        {
			if($this->user_model->update_user($uid)){
                $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>");
			}else{
			    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>");
			}
			redirect('user/edit_user/'.$uid);
        }
	}
		
	public function group_list()
	{
		// fetching group list
		$data['group_list']=$this->user_model->group_list();
		$data['title']=$this->lang->line('group_list');
		$this->load->view('header',$data);
		$this->load->view('group_list',$data);
		$this->load->view('footer',$data);
	}

	public function insert_group()
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}

		if($this->user_model->insert_group()){
            $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_added_successfully')." </div>");
		}else{
     		$this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_add_data')." </div>");
		}
		redirect('user/group_list/');	
	}
	
	public function update_group($gid)
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		}
		if($this->user_model->update_group($gid)){
            echo "<div class='alert alert-success'>".$this->lang->line('data_updated_successfully')." </div>";
		}else{
			echo "<div class='alert alert-danger'>".$this->lang->line('error_to_update_data')." </div>";
		}	
	}
	
	
	function get_expiry($gid)
	{
		echo $this->user_model->get_expiry($gid);
	}
	
	public function remove_group($gid)
	{
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!='1'){
			exit($this->lang->line('permission_denied'));
		} 
			
		if($this->user_model->remove_group($gid)){
            $this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('removed_successfully')." </div>");
		}else{
		    $this->session->set_flashdata('message', "<div class='alert alert-danger'>".$this->lang->line('error_to_remove')." </div>");
		}
		redirect('user/group_list');
                     
			
	}

	function logout()
	{
		$this->session->unset_userdata('logged_in');		
		redirect('login');
	}

	/* Import User With Excell file*/
	function import()
	{	
		$logged_in=$this->session->userdata('logged_in');
		if($logged_in['su']!="1"){
			exit('Permission denied');
			return;
		}	

   		$this->load->helper('xlsimport/php-excel-reader/excel_reader2');
   		$this->load->helper('xlsimport/spreadsheetreader.php');

		if(isset($_FILES['xlsfile'])){
			$targets = 'xls/';
			$targets = $targets . basename( $_FILES['xlsfile']['name']);
			$docadd=($_FILES['xlsfile']['name']);
			if(move_uploaded_file($_FILES['xlsfile']['tmp_name'], $targets)){
				$Filepath = $targets;
				$allxlsdata = array();
				date_default_timezone_set('UTC');

				$StartMem = memory_get_usage();
				//echo '---------------------------------'.PHP_EOL;
				//echo 'Starting memory: '.$StartMem.PHP_EOL;
				//echo '---------------------------------'.PHP_EOL;

				try
				{
					$Spreadsheet = new SpreadsheetReader($Filepath);
					$BaseMem = memory_get_usage();

					$Sheets = $Spreadsheet -> Sheets();

					//echo '---------------------------------'.PHP_EOL;
					//echo 'Spreadsheets:'.PHP_EOL;
					//print_r($Sheets);
					//echo '---------------------------------'.PHP_EOL;
					//echo '---------------------------------'.PHP_EOL;

					foreach ($Sheets as $Index => $Name)
					{
						//echo '---------------------------------'.PHP_EOL;
						//echo '*** Sheet '.$Name.' ***'.PHP_EOL;
						//echo '---------------------------------'.PHP_EOL;

						$Time = microtime(true);

						$Spreadsheet -> ChangeSheet($Index);

						foreach ($Spreadsheet as $Key => $Row)
						{
							//echo $Key.': ';
							if ($Row)
							{
								//print_r($Row);
								$allxlsdata[] = $Row;
							}
							else
							{
								var_dump($Row);
							}
							$CurrentMem = memory_get_usage();
		
							//echo 'Memory: '.($CurrentMem - $BaseMem).' current, '.$CurrentMem.' base'.PHP_EOL;
							//echo '---------------------------------'.PHP_EOL;
		
							if ($Key && ($Key % 500 == 0))
							{
								//echo '---------------------------------'.PHP_EOL;
								//echo 'Time: '.(microtime(true) - $Time);
								//echo '---------------------------------'.PHP_EOL;
							}
						}
		
					//	echo PHP_EOL.'---------------------------------'.PHP_EOL;
						//echo 'Time: '.(microtime(true) - $Time);
						//echo PHP_EOL;

						//echo '---------------------------------'.PHP_EOL;
						//echo '*** End of sheet '.$Name.' ***'.PHP_EOL;
						//echo '---------------------------------'.PHP_EOL;
					}
		
				}
				catch (Exception $E)
				{
					echo $E -> getMessage();
				}

				$this->user_model->import_user($allxlsdata);   
				
				$this->session->set_flashdata('message', "<div class='alert alert-success'>".$this->lang->line('data_imported_successfully')." </div>");
  		        redirect('user');		
			}			
		}
		else{
			echo "Error: " . $_FILES["file"]["error"];
		}	

	}
}
