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

        $subject = 'Selamat, Anda berhasil LOLOS Seleksi Administrasi Tahap I Program Penggiat Budaya tahun 2017';
        // $message = 'Kepada Yth. <b>[fullname]</b>,<br/><br/> Selamat, Anda lulus tahap kelengkapan Administrasi sebagai calon dari Penggiat Budaya Kementerian Pendidikan dan Kebudayaan Republik Indonesia. <br/>Selanjutnya, Anda akan mengikuti tes secara Online di halaman <b><a href="http://penggiatbudaya.kemdikbud.go.id/" target="_blank">http://penggiatbudaya.kemdikbud.go.id</a></b> dengan informasi login sebagai berikut: <br/><br/>Username: <b>[registration_no]</b><br/>Password: <b>[password]</b><br/><br/>Untuk itu, <b>ada beberapa hal yang perlu Anda perhatikan ketika ujian secara online nanti</b>, yaitu: <br/><ul><li>Kesempatan ujian Anda hanya <b>SATU KALI</b></li><li>Perhatikan <b>WAKTU</b> ujian untuk masing-masing kelompok soal</li><li>Pastikan <b>KONEKSI INTERNET</b> Anda lancar</li><li><b>JANGAN</b> menekan tombol <b>REFRESH</b> atau tombol <b>F5</b> selama ujian berlangsung</li><li>Jangan <b>KELUAR (LOGOUT)</b> sebelum Anda selesai melaksanakan ujian</li></ul>';

        $message = '<b>SELAMAT!</b> Anda berhasil <b>LOLOS Seleksi Administrasi Tahap I</b> Program Penggiat Budaya tahun 2017, selanjutnya Anda dapat mengikuti seleksi Pengetahuan Umum dan Psikotes, yang dilaksanakan secara online melalui laman: <a href="http://penggiatbudaya.kemdikbud.go.id">http://penggiatbudaya.kemdikbud.go.id</a>, dengan menggunakan:<br/><br/>';

        $message .= 'Nomor Peserta: <b>[registration_no]</b><br/>Password: <b>[password]</b><br/><br/>';
        $message .= 'Tes Pengetahuan Kemampuan Umum dan Psikotes akan dilaksanakan pada:<br/><br/>';
        $message .= 'Hari/Tanggal: <b>Jum\'at/28 April 2017</b><br/>Waktu Pelaksanaan: <b>07.00 - 14.00 WIB<sup style="color=red;">*</sup></b><br/>Durasi Pengerjaan: <b>3 x 60 menit</b><br/><br/>';

        $message .= '<i>[<sup style="color=red;">*</sup>ketentuan waktu pelaksanaan]</i><br/>';
        $message .= '<i>Batas awal memulai ujian adalah pukul 07.00 WIB (sehingga batas mengerjakan tes maksimal pukul 09.59 WIB)</i><br/>';
        $message .= '<i>Batas akhir memulai ujian adalah pukul 14.00 WIB (sehingga batas mengerjakan tes maksimal pukul 16.59 WIB)</i><br/><br/>';
        $message .= 'Sebelum tes dilakukan, pastikan Anda memenuhi hal berikut :';
        $message .= '<ol type="1"><li>Pastikan Anda menggunakan koneksi internet</li><li>Pastikan <i>Browser</i> yang digunakan adalah <i>Google Chrome/Mozilla Firefox</i> versi terbaru</li></ol>';
        $message .= 'Untuk lebih jelasnya, silahkan membaca dan memahami petunjuk tata cara penggunaan Tes Online Penggiat Budaya.<br/><br/>';
        $message .= 'Jika dinyatakan lolos dari tahapan Tes <i>Online</i> ini, Anda akan menerima pengumuman lolos seleksi dari kami melalui laman <a href="http://kebudayaan.kemdikbud.go.id">http://kebudayaan.kemdikbud.go.id</a> dan email yang berisi informasi untuk melengkapi berkas tahap dua. Hasil seleksi merupakan kewenangan dari Tim Seleksi dan tidak dapat diganggu gugat. <br/><br/>';
        $message .= 'Demikian disampaikan, terima kasih.<br/><br/>';
        $message .= 'Jakarta, 25 April 2017<br/>';
        $message .= 'Panitia Seleksi<br/><br/><br/>';
        $message .= '<b>Catatan:</b>';
        $message .= '<ul><li>Silahkan Download Tata Cara Penggunaan Tes Online Penggiat Budaya di <a href="https://goo.gl/3OEOsK">https://goo.gl/3OEOsK</a></li><li>Kesempatan ujian Anda hanya <b>SATU KALI</b></li><li>Perhatikan <b>WAKTU</b> ujian untuk masing-masing kelompok soal</li><li>Pastikan <b>KONEKSI INTERNET</b> Anda lancar</li><li><b>JANGAN</b> menekan tombol <b>REFRESH</b> atau tombol <b>F5</b> selama ujian berlangsung</li><li>Jangan <b>KELUAR (LOGOUT)</b> sebelum Anda selesai melaksanakan ujian</li><li>Jika Anda mengalami masalah pada saat pengerjaan Tes Online, dapat menghubungi nomor berikut : <ul><li>0813 9523 2871</li><li>0858 8695 2608</li><li>0877 8650 9579</li></ul></li><li>Kami tidak bertanggung jawab apabila terjadi kegagalan tes karena permasalahan koneksi internet dan virus pada perangkat Anda</li><li>Kami tidak menerima/meminta imbalan, serta pemberian hadiah dalam bentuk apapun selama proses penerimaan Penggiat  Budaya 2017.</li></ul>';
        
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