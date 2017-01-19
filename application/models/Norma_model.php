<?php
Class Norma_model extends CI_Model
{
    function norma_ist_list()
    {
        return true;
    }

    function norma_convert($ist, $score_ist)
    {
        switch ($ist) {
            case 'ist2':
                $ist_type = 'WA';
                break;
            case 'ist3':
                $ist_type = 'AN';
                break;
            case 'ist4':
                $ist_type = 'GE';
                break;
            case 'ist5':
                $ist_type = 'RA';
                break;
            case 'ist6':
                $ist_type = 'ZR';
                break;
            case 'ist7':
                $ist_type = 'FA';
                break;
            case 'ist8':
                $ist_type = 'WU';
                break;
            case 'ist9':
                $ist_type = 'ME';
                break;
            default:
                $ist_type = 'SE';
                break;
        }

        $this->db->where('score_ist.type',$ist_type);
        $this->db->where('score_ist.rs',$score_ist);
        $query = $this->db->get('score_ist');
        
        return $query->row_array();
    }

    function norma_flag($flag)
    {
        /*
         * ST = SANGAT TINGGI
         * T  = TINGGI
         * S  = SEDANG
         * R  = RENDAH
         * SR = SANGAT RENDAH
        */
        switch ($flag) {
            case 'ST':
                $ist_flag = 'SANGAT TINGGI';
                break;
            case 'T':
                $ist_flag = 'TINGGI';
                break;
            case 'S':
                $ist_flag = 'SEDANG';
                break;
            case 'R':
                $ist_flag = 'RENDAH';
                break;
            default:
                $ist_flag = 'SANGAT RENDAH';
                break;
        }

        return $ist_flag;
    }

    function norma_iq_score($ws_score)
    {
        $this->db->where('score_iq.min_ws <=', $ws_score);
        $this->db->where('score_iq.max_ws >=', $ws_score);
        $query = $this->db->get('score_iq');

        $result = $query->row_array();

        return $result['iq'];
    }

    function norma_iq($ws_score)
    {
        /*
        119 - Keatas    Very Superior (+)
        105 - 118       Superior
        100 - 104       Rata - rata atas
         95 -  99       Rata - rata
         81 -  94       Rata - rata bawah
         80 -  ke bawah Dibawah rata-rata
        */

        $iq_score = $this->norma_iq_score($ws_score);
        switch ($iq_score) {
            case $iq_score >= 119:
                $ist_norma_iq = 'VERY SUPERIOR';
                break;
            case $iq_score <= 118 && $iq_score >= 105:
                $ist_norma_iq = 'SUPERIOR';
                break;
            case $iq_score <= 104 && $iq_score >= 100:
                $ist_norma_iq = 'RATA-RATA ATAS';
                break;
            case $iq_score <= 99 && $iq_score >= 95:
                $ist_norma_iq = 'RATA-RATA';
                break;
            case $iq_score <= 94 && $iq_score >= 81:
                $ist_norma_iq = 'RATA-RATA BAWAH';
                break;
            case $iq_score <= 80:
                $ist_norma_iq = 'DI BAWAH RATA-RATA';
                break;
            default:
                $ist_norma_iq = 'UNDEFINE';
                break;
        }

        return $ist_norma_iq;
    }

    function hasil_disc_m($uid)
    {
        $q_n_most = 'SELECT
            COUNT(CASE WHEN disc_answers.most = \'D\' THEN disc_answers.most ELSE null END) as d,
            COUNT(CASE WHEN disc_answers.most = \'I\' THEN disc_answers.most ELSE null END) as i,
            COUNT(CASE WHEN disc_answers.most = \'S\' THEN disc_answers.most ELSE null END) as s,
            COUNT(CASE WHEN disc_answers.most = \'C\' THEN disc_answers.most ELSE null END) as c,
            COUNT(CASE WHEN disc_answers.most = \'*\' THEN disc_answers.most ELSE null END) as x,
            COUNT(CASE WHEN disc_answers.most = \'D\' THEN disc_answers.most ELSE null END)+
            COUNT(CASE WHEN disc_answers.most = \'I\' THEN disc_answers.most ELSE null END)+
            COUNT(CASE WHEN disc_answers.most = \'S\' THEN disc_answers.most ELSE null END)+
            COUNT(CASE WHEN disc_answers.most = \'C\' THEN disc_answers.most ELSE null END)+
            COUNT(CASE WHEN disc_answers.most = \'*\' THEN disc_answers.most ELSE null END)
            as t
            FROM disc_answers where uid='.$uid;
        
        $query_m =  $this->db->query($q_n_most);

        $result_m = $query_m->row_array();

        return $result_m;
    }

    function hasil_disc_l($uid)
    {
        $q_n_least = 'SELECT
            COUNT(CASE WHEN disc_answers.least = \'D\' THEN disc_answers.most ELSE null END) as d,
            COUNT(CASE WHEN disc_answers.least = \'I\' THEN disc_answers.most ELSE null END) as i,
            COUNT(CASE WHEN disc_answers.least = \'S\' THEN disc_answers.most ELSE null END) as s,
            COUNT(CASE WHEN disc_answers.least = \'C\' THEN disc_answers.most ELSE null END) as c,
            COUNT(CASE WHEN disc_answers.least = \'*\' THEN disc_answers.most ELSE null END) as x,
            COUNT(CASE WHEN disc_answers.least = \'D\' THEN disc_answers.least ELSE null END)+
            COUNT(CASE WHEN disc_answers.least = \'I\' THEN disc_answers.least ELSE null END)+
            COUNT(CASE WHEN disc_answers.least = \'S\' THEN disc_answers.least ELSE null END)+
            COUNT(CASE WHEN disc_answers.least = \'C\' THEN disc_answers.least ELSE null END)+
            COUNT(CASE WHEN disc_answers.least = \'*\' THEN disc_answers.least ELSE null END)
            as t
            FROM disc_answers where uid='.$uid;

        $query_l =  $this->db->query($q_n_least);

        $result_l = $query_l->row_array();

        return $result_l;
    }

    function data_scale_m($uid)
    {
        $disc = array('D','I','S','C');
        $d_m = $this->hasil_disc_m($uid);
        unset($d_m['x'],$d_m['t']);

        $k=0;
        foreach ($d_m as $kd => $vd) {
            $r[$k] = $this->db->query('SELECT scale FROM most_scale where value_'.$kd .'= '.$vd.' order by scale desc')->row_array();
            $rc['data'][$k] = $r[$k]['scale'];
            $rc['label'][$k] = $vd . '(' .$disc[$k].')';
            $k++;
        }
        
        $value = $this->profile_disc($rc['data']);

        $profile = explode('-', $value['value']);
        $norma = $this->norma_disc($profile[0]);

        $result = array_merge($rc, $value, $norma);

        return $result;
    }
    
    function data_scale_l($uid)
    {
        $disc = array('D','I','S','C');
        $d_l = $this->hasil_disc_l($uid);
        unset($d_l['x'],$d_l['t']);

        $k=0;
        foreach ($d_l as $kd => $vd) {
            $r[$k] = $this->db->query('SELECT scale FROM least_scale where value_'.$kd .'= '.$vd.' order by scale desc')->row_array();
            $rc['data'][$k] = $r[$k]['scale'];
            $rc['label'][$k] = $vd . '(' .$disc[$k].')';
            $k++;
        }

        $value = $this->profile_disc($rc['data']);

        $profile = explode('-', $value['value']);
        $norma = $this->norma_disc($profile[0]);

        $result = array_merge($rc, $value, $norma); // Cek disini, kenapa ada error di server

        return $result;
    }

    function data_scale_c($uid)
    {
        $disc = array('D','I','S','C');
        $d_m = $this->hasil_disc_m($uid);
        $d_l = $this->hasil_disc_l($uid);
        unset($d_m['x'],$d_m['t'],$d_l['x'],$d_l['t']);

        $dc = array();
        foreach ($d_m as $key => $value) {
            $dc[$key] = $value - $d_l[$key];
        }

        $k=0;
        foreach ($dc as $kd => $vd) {
            $r[$k] = $this->db->query('SELECT scale FROM change_scale where value_'.$kd .'= '.$vd.' order by scale desc')->row_array();
            $rc['data'][$k] = $r[$k]['scale'];
            $rc['label'][$k] = $vd . '(' .$disc[$k].')';
            $k++;
        }

        $value = $this->profile_disc($rc['data']);

        $profile = explode('-', $value['value']);
        $norma = $this->norma_disc($profile[0]);

        $result = array_merge($rc, $value, $norma); // Cek disini, kenapa ada error di server

        return $result;
    }

    function profile_disc($data)
    {
        $disc = array('D','I','S','C');

        arsort($data);

        $trigger = false;
        foreach($data as $key => $v) {

            $vm[$key] = $disc[$key];

            if($v >= 0 || $trigger) {
                $vd[$key] = $disc[$key];
            } else {
                $vd[$key] = '/' . $disc[$key];
                $trigger = true;
            }
            
        }

        $string = implode('', $vm) . ' - ' . implode('', $vd);

        $value = array('value' => $string);

        return $value;
    }

    function norma_disc($profile)
    {
        $result = $this->db->query('SELECT norma FROM disc_norma where type = \''.trim($profile).'\'')->row_array();

        return $result;
    }
}