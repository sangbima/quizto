<?php
Class Hasil_model extends CI_Model
{
    function hasil_resume($limit=0,$full_range=false)
    {
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }

        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,';
        
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
                from answers a
                left join qbank b on b.qid = a.qid
                left join category c on c.cid = b.cid
                left join users d on d.uid = a.uid
                where su != 1
                group by d.uid
                order by total desc ' . $qoption;

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result;
    }    

    function hasil_list($limit=0,$full_range=false)
    {
        
        if ( $full_range) {
           $offset_start=0; 
           $qoption="";
        } else {    
           $offset_start= $limit;
           $qoption= " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        }

        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,';
                
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
                where su != 1
                group by d.uid
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

    function hasil_tpu_tpa($limit=0,$status='0')
    {
        
        $offset_start= $limit * $this->config->item('number_of_rows');
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
                where su != 1
                group by d.uid
                order by total desc' . " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        
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

    function hasil_disc($limit=0,$status='0')
    {
        $this->load->model("norma_model");

        $offset_start= $limit * $this->config->item('number_of_rows');
        $script = 'SELECT d.uid,concat(d.first_name,\' \',d.last_name) as fullname,';
        
         // GET CATEGORY ID
        $this->db->order_by('cid','asc');
        $this->db->where('grup', '2');
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
                where su != 1
                group by d.uid
                order by total desc' . " limit " . $this->config->item('number_of_rows') .  " offset " . $offset_start;
        
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

    function hasil_norma_ist($uid)
    {
        
    }
}