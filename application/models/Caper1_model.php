<?php
Class Caper1_model extends CI_Model
{
    function registerOk($limit=0)
    {
        $this->db->select('id,registration_no,CONCAT(first_name," ",last_name) as fullname,provinsi,kabkota,email,password,status');
        $this->db->where('status', '0');

        if($limit != 0) {
            $this->db->limit($limit);
        }
        
        $query = $this->db->get('caper1');  
        
        return $query->result();
    }

    function record_count()
    {
        return $this->db->count_all("caper1");
    }

    function getListCaper($limit, $start)
    {
        $this->db->from('caper1');
        $this->db->select('id,registration_no,CONCAT(first_name," ",last_name) as fullname,provinsi,kabkota,email,password,status');
        $this->db->order_by('registration_no DESC');
        $this->db->limit($limit, $start);
        
        $query = $this->db->get();
        
        return $query->result();
    }

    function getSingleCaper($caper_id)
    {
        // $this ->db->where('caper1.id', $caper_id);     
        // $query = $this->db->get('caper1');        
        // return $query->row_array();

        $this->db->from('caper1');
        $this->db->select('id,registration_no,CONCAT(first_name," ",last_name) as fullname,provinsi,kabkota,email,password,status');
        $this->db->where('id', $caper_id);
        
        $query = $this->db->get();
        
        return $query->row_array();
    }

    function ubahstatus($caper_id)
    {
        $this->db->where('caper1.id', $caper_id);
        $query = $this->db->get('caper1');        
        $calon = $query->row_array();

        if($calon['status'] == '0') {
            $newstatus = array('status' => '10');
            $this->db->where('caper1.id', $caper_id);
            return $this->db->update('caper1', $newstatus);
        } else {
            $newstatus = array('status' => '0');
            $this->db->where('caper1.id', $caper_id);
            return $this->db->update('caper1', $newstatus);
        }
    }

    function batch_email($caper_id)
    {
        $caper = $this->caper1_model->getSingleCaper($caper_id);
        
        $this->email->clear();
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

        $subject = 'Selamat, Anda Lulus Tahap Admnistrasi';
        $message = 'Kepada Yth. <b>[fullname]</b>,<br/><br/> Selamat, Anda lulus tahap kelengkapan Administrasi sebagai calon dari Penggiat Budaya Kementerian Pendidikan dan Kebudayaan Republik Indonesia. <br/>Selanjutnya, Anda akan mengikuti tes secara Online di halaman <b><a href="http://penggiatbudaya.kemdikbud.go.id/" target="_blank">http://penggiatbudaya.kemdikbud.go.id</a></b> dengan informasi login sebagai berikut: <br/><br/>Username: <b>[registration_no]</b><br/>Password: <b>[password]</b><br/><br/>Untuk itu, <b>ada beberapa hal yang perlu Anda perhatikan ketika ujian secara online nanti</b>, yaitu: <br/><ul><li>Kesempatan ujian Anda hanya <b>SATU KALI</b></li><li>Perhatikan <b>WAKTU</b> ujian untuk masing-masing kelompok soal</li><li>Pastikan <b>KONEKSI INTERNET</b> Anda lancar</li><li><b>JANGAN</b> menekan tombol <b>REFRESH</b> atau tombol <b>F5</b> selama ujian berlangsung</li><li>Jangan <b>KELUAR (LOGOUT)</b> sebelum Anda selesai melaksanakan ujian</li></ul>';
        
        $message = str_replace('[fullname]', $caper['fullname'], $message);
        $message = str_replace('[registration_no]', $caper['registration_no'], $message);
        $message = str_replace('[password]', $caper['password'], $message);

        $toemail = $caper['email'];

        $this->email->to($toemail);
        $this->email->from($fromemail, $fromname);
        $this->email->subject($subject);
        $this->email->message($message);

        if(!$this->email->send()){
            print_r($this->email->print_debugger());
            exit;
        } else {
            if($this->ubahstatus($caper_id)){
                return true;
            } else {
                return false;
            }
        }
    }
}