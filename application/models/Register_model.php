<?php
Class Register_model extends CI_Model
{
    function insertdata()
    {
        $userdata = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'registration_no' => $this->generateRegistrationNumber(),
            'password' => $this->input->post('password'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => date('Y-m-d', strtotime($this->input->post('tanggal_lahir'))),
            'email' => $this->input->post('email'),
            'contact_no' => $this->input->post('contact_no'),
            'instansi_name' => $this->input->post('instansi_name'),
            'bagian' => $this->input->post('bagian'),
            'alamat_instansi' => $this->input->post('alamat_instansi'),
            'thn_mengabdi' => $this->input->post('thn_mengabdi'),
            'jabatan' => $this->input->post('jabatan'),
            'jobdesk' => $this->input->post('jobdesk'),
            'pendidikan' => $this->input->post('pendidikan'),
            'institusi_pendidikan' => $this->input->post('institusi_pendidikan'),
            'fakultas' => $this->input->post('fakultas'),
            'no_ijazah' => $this->input->post('no_ijazah'),
            'nilai_ipk' => $this->input->post('nilai_ipk'),
        );

        if($this->config->item('protocol')=="smtp"){
            $config = array();
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

        $fromemail = $this->config->item('fromemail');
        $fromname = $this->config->item('fromname');
        $subject = $this->config->item('email_subject');
        $message = $this->config->item('email_message');
        
        $message = str_replace('[registration_no]', $userdata['registration_no'], $message);
        $message = str_replace('[password]', $userdata['password'], $message);

        $toemail = $this->input->post('email');

        $this->email->to($toemail);
        $this->email->from($fromemail, $fromname);
        $this->email->subject($subject);
        $this->email->message($message);
        if(!$this->email->send()){
            print_r($this->email->print_debugger());
            exit;
        } else {
            if($this->db->insert('register',$userdata)){
                return true;
            } else {
                return false;
            }
        }
    }

    function generateRegistrationNumber()
    {
        $lastRegNo = $this->getLastInsertRegNo();
        
        $a = substr($lastRegNo, 5, 8);
        $a++;

        $year = date('y');
        $month = date('m');
        $awal = '00000000';
        $inc = $a;
        $genAwal = $awal.$inc;
        
        $nextRegNo = $year.$month.substr($genAwal, strlen($genAwal)-8,8);

        return $nextRegNo;
    }

    function getLastInsertRegNo()
    {
        $query = $this->db->query('SELECT * FROM register ORDER BY id DESC LIMIT 1');
        $lastId = $query->row();
        
        return $lastId == NULL ? 0 : $lastId->registration_no;
    }

    function record_count()
    {
        return $this->db->count_all("register");
    }

    function getListCaper($limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get('register');
        
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
}