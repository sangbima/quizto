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
            'pendidikan' => $this->input->post('pendidikan'),
            'institusi_pendidikan' => $this->input->post('institusi_pendidikan'),
            'fakultas' => $this->input->post('fakultas'),
            'no_ijazah' => $this->input->post('no_ijazah'),
            'nilai_ipk' => $this->input->post('nilai_ipk'),
        );

        if($this->db->insert('register',$userdata)){
            if($this->config->item('verify_email')){
                
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
                
                $fromemail = $this->config->item('fromemail');
                $fromname = $this->config->item('fromname');
                $subject = $this->config->item('email_subject');
                $message = $this->config->item('email_message');
                
                $message = str_replace('[registration_no]', $this->generateRegistrationNumber(), $message);
                $message = str_replace('[password]', $this->input->post('password'), $message);
                
            
                $toemail = $this->input->post('email');
                 
                $headers  = 'From: [cat.kemendikbud]@gmail.com' . "\r\n" .
                            'MIME-Version: 1.0' . "\r\n" .
                            'Content-type: text/html; charset=utf-8';
                if(!mail($toemail, $subject, $message, $headers)) {
                    print_r($this->email->print_debugger());
                    exit;
                }
            }
            return true;
        }else{
            return false;
        }


        // if($this->db->insert('register',$userdata)){
        //     return true;
        // }else{
        //     return false;
        // }
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
        
        return $lastId->registration_no == '' || $lastId->registration_no == NULL ? 0 : $lastId->registration_no;
    }
}