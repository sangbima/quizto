<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends CI_Controller 
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model("hasil_model");
        $this->load->model("user_model");
		    $this->load->model("provinsi_model");
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

    public function index($limit='0',$gid_filter='0',$oid_filter='0',$prov_filter='',$nsr_filter='')
    {
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
          if ($this->input->post('group')) { 
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
        $data['result']=$this->hasil_model->hasil_resume($limit,false,$gid_filter,$oid_filter);
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
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Peserta";
        // fetching user list
        $data['user']=$this->user_model->get_user($uid);
        $data['tputpa'] = $this->hasil_model->hasil_tpu_tpa_detail($uid);
        $data['result'] = $this->hasil_model->hasil_detail($uid);
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
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
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

    public function tpu_tpa($limit='0',$gid_filter='0',$oid_filter='0',$prov_filter='',$nsr_filter='')
    {
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
		
		if($nsr_filter != null and $nsr_filter !='') {
           $data['search']['n_search']=$nsr_filter;		        		
        } else {	   
          if ($this->input->post('n_search')) { 
               $data['search']['n_search']=$this->input->post('n_search');		 
          } else {
            $data['search']['n_search']='';		 
          } 		
		}		
			
        if($prov_filter != null and $prov_filter !='') {
           $data['search']['provinsi']=$prov_filter;		        		
        } else {	   
          if ($this->input->post('group')) { 
               $data['search']['provinsi']=$this->input->post('provinsi');		 
          } else {
            $data['search']['provinsi']='';		 
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
        $data['result']=$this->hasil_model->hasil_tpu_tpa($limit,false,$gid_filter,$oid_filter);
        $this->load->view('header', $data);
        $this->load->view('hasil_tpu_tpa', $data);
        $this->load->view('footer', $data);
    }

    
    public function ist($limit='0',$gid_filter='0',$oid_filter='0',$prov_filter='',$nsr_filter='')
    {
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
          if ($this->input->post('group')) { 
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
        $data['result']=$this->hasil_model->hasil_list($limit,false,$gid_filter,$oid_filter);
        $this->load->view('header',$data);
        $this->load->view('hasil_ist',$data);
        $this->load->view('footer',$data);
    }
    

    public function download($qtype='ist',$limit='0',$full=false,$gid=null,$created_by=null) 
    {       			  
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }

        if ( $qtype=='tpu_tpa' ) {  
            $this->export_hasil_tpu_tpa($limit,$full,$gid,$created_by);
        }               
        
        if ( $qtype=='ist' ) {  
            $this->export_hasil_ist($limit,$full,$gid,$created_by);
        }       
		
        if ( $qtype=='ist_detail' ) {  
            $this->export_hasil_ist_detail($limit,$full);
        }       		
        
        if ( $qtype=='disc' ) {  
            $this->export_hasil_disc($limit,$full,$gid,$created_by);
        }

        if ( $qtype=='disc_detail' ) {  
            $this->export_hasil_disc_detail($limit,$full);
        }		
				
        if ($qtype=='default') {
            $this->export_hasil_ringkasan($limit,$full,$gid,$created_by);
        }  
        if ($qtype=='default_detail') {
            $this->export_hasil_ringkasan_detail($limit,$full);			
        }			
		
        if ($qtype=='test_chart') {
            $this->test_export_chart($limit,$full);			
        }					
        
    }   
    
    public function export_hasil_ringkasan($limit='0',$full=false,$gid=null,$created_by=null)
    {         	
        $logged_in=$this->session->userdata('logged_in');
		
        if ($logged_in['su'] != 1) {
            $created_by = $logged_in['uid'];
        }
        
        $data['limit']=$limit;
        $data['title']='Hasil Ringkasan';
        $data['header']=array('A'=>'NO. REGISTRASI',
                              'B'=>'FULLNAME',
                              'C'=>'TPU',
                              'D'=>'TPA',                             
                              'E'=>'SE',
                              'F'=>'WA',
                              'G'=>'AN',
                              'H'=>'GE',
                              'I'=>'RA',                              
                              'J'=>'ZR',
                              'K'=>'FA',
                              'L'=>'WU',
                              'M'=>'ME',
                              'N'=>'TOTAL',
                              'O'=>'GROUP',							  
							  'P'=>'CREATED BY',
							  'Q'=>'KABUPATEN/KOTA',
							  'R'=>'PROVINSI'							  
							  );        
        
         $data['result']=$this->hasil_model->hasil_resume($limit,$full,$gid,$created_by);
		 		 
         if ( $full) {
            $data['filename'] = "hasil_ringkasan_full_" . date('Ymdhi') . ".xlsx";         
         } else {
            $data['filename'] = "hasil_ringkasan_"  . $limit. " _". date('Ymdhi') . ".xlsx";       
         }   
         $this->load->view('export_hasil_ringkasan',$data);      
		 
    }

    public function export_hasil_tpu_tpa($limit='0',$full=false,$gid=null,$created_by=null)
    {
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if ($logged_in['su'] == 1) {
            $created_by = null;
        } else {
            $created_by = $logged_in['uid'];
        }
        
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
            
        $data['limit']=$limit;        
        $data['title']="Hasil TPU TPA";
        $data['header']=array('A'=>'FULLNAME',
                              'B'=>'TPU',
                              'C'=>'TPA',
                              'D'=>'TOTAL',
                              'E'=>'GROUP',							  
							  'F'=>'CREATED BY',
							  'G'=>'KABUPATEN/KOTA',
							  'H'=>'PROVINSI'	
                              );        
        $data['result']=$this->hasil_model->hasil_tpu_tpa($limit,$full,$gid,$created_by);
        if ( $full) {
            $data['filename'] = "hasil_tpu_tpa_full_" . date('Ymd') . ".xlsx";       
         } else {
            $data['filename'] = "hasil_tpu_tpa_"  . $limit. " _". date('Ymd') . ".xlsx";         
        }       
        $this->load->view('export_hasil_tpu_tpa', $data);
     
    }
    
    public function export_hasil_ist($limit='0',$full=false,$gid=null,$created_by=null)
    {    

        $logged_in=$this->session->userdata('logged_in');
        if ($logged_in['su'] == 1) {
            $created_by = null;
        } else {
            $created_by = $logged_in['uid'];
        }
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
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
                              'K'=>'TOTAL',
                              'L'=>'GROUP',							  
							  'M'=>'CREATED BY',
							  'N'=>'KABUPATEN/KOTA',
							  'O'=>'PROVINSI'							  
                              );
         $data['result']=$this->hasil_model->hasil_list($limit,$full,$gid,$created_by); 
         if ( $full) {
            $data['filename'] = "hasil_ist_full_" . date('Ymd') . ".xlsx";       
         } else {
            $data['filename'] = "hasil_ist_"  . $limit. " _". date('Ymd') . ".xlsx";         
         }                      
         $this->load->view('export_hasil_ist',$data);
    }

     public function export_hasil_disc($limit,$full=false,$gid=null,$created_by=null) 
     {
        $logged_in=$this->session->userdata('logged_in');
        if ($logged_in['su'] == 1) {
            $created_by = null;
        } else {
            $created_by = $logged_in['uid'];
        }
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
  
        $data['limit']=$limit;
        $data['title']="Hasil DISC";        
        $data['result']=$this->hasil_model->hasil_disc($limit,$full,$gid,$created_by);
        $data['header']=array('A'=>'FULLNAME',
                              'B'=>'MOST',
                              'C'=>'LEAST',
                              'D'=>'CHANGE',
                              'E'=>'GROUP',							  
							  'F'=>'CREATED BY',
							  'N'=>'KABUPATEN/KOTA',
							  'O'=>'PROVINSI'							  
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

    public function disc($limit='0',$gid_filter='0',$oid_filter='0',$prov_filter='',$nsr_filter='')
    {
        $this->load->model("norma_model");      
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
        $data['result']=$this->hasil_model->hasil_disc($limit,false,$gid_filter,$oid_filter);

        // var_dump($data['result']);

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
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
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
    
    
    
	
	public function export_hasil_ringkasan_detail($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Ringkasan Hasil Peserta";        
        $data['user']=$this->user_model->get_user($uid);
        $data['user']['fullname']=$data['user']['first_name'] . ' ' . $data['user']['last_name'];		        
		$data['tputpa'] = $this->hasil_model->hasil_tpu_tpa_detail($uid);
        $data['result'] = $this->hasil_model->hasil_detail($uid, '1');
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);
        $data['filename'] = $uid . "-" .$data['user']['fullname'] ." - hasil_ringkasan-". date('Ymd') . ".xlsx"; 
        $this->load->view('export_hasil_ringkasan_detail',$data);
    }
	

	public function export_hasil_ist_detail($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Hasil IST Peserta";        
        $data['user']=$this->user_model->get_user($uid);
        $data['user']['fullname']=$data['user']['first_name'] . ' ' . $data['user']['last_name'];		
        $data['tputpa'] = 'TPU TPA';
        $data['result'] = $this->hasil_model->hasil_detail($uid, '1');
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);
        $data['filename'] = $uid . "-" .$data['user']['fullname'] ." - hasil_ist-". date('Ymd') . ".xlsx"; 
        $this->load->view('export_hasil_ist_detail',$data);
    }	
	
	public function export_hasil_disc_detail($uid)
    {
        $this->load->model("user_model");
        $this->load->model("norma_model");
        $this->load->helper('form');
        $logged_in=$this->session->userdata('logged_in');
        if($logged_in['su']!='1' && $logged_in['su']!='2'){
            exit($this->lang->line('permission_denied'));
        }
        
        $data['title']="Detail Hasil DISC Peserta";        
        $data['user']=$this->user_model->get_user($uid);
        $data['user']['fullname']=$data['user']['first_name'] . ' ' . $data['user']['last_name'];		
        $data['tputpa'] = 'TPU TPA';
        $data['result'] = $this->hasil_model->hasil_detail($uid, '1');
        $data['disc_m'] = $this->norma_model->hasil_disc_m($uid);
        $data['disc_l'] = $this->norma_model->hasil_disc_l($uid);
        $data['mscale'] = $this->norma_model->data_scale_m($uid);
        $data['lscale'] = $this->norma_model->data_scale_l($uid);
        $data['cscale'] = $this->norma_model->data_scale_c($uid);
        $data['filename'] = $uid . "-" .$data['user']['fullname'] ." - hasil_disc-". date('Ymd') . ".xlsx"; 
        $this->load->view('export_hasil_disc_detail',$data);
    }		
	

}