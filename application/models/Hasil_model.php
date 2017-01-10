<?php
Class Hasil_model extends CI_Model
{
    function hasil_list($limit,$status='0')
    {
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
                left join quizto.qbank b on b.qid = a.qid
                left join quizto.category c on c.cid = b.cid
                left join quizto.users d on d.uid = a.uid
                where su != 1
                group by d.uid
                order by total desc';

        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from quizto.answers a
        //         left join quizto.qbank b on b.qid = a.qid
        //         left join quizto.category c on c.cid = b.cid
        //         left join quizto.users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->result_array();

        // var_dump($result);die();
        return $result;
    }

    function hasil_detail($uid)
    {
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
                from quizto.answers a
                left join quizto.qbank b on b.qid = a.qid
                left join quizto.category c on c.cid = b.cid
                left join quizto.users d on d.uid = a.uid
                where d.su != 1 and d.uid = ' . $uid . '
                group by d.uid
                order by total desc';

        // Dengan admin
        // $script .= '
        //         round(sum(a.score_u), 0) as total
        //         from quizto.answers a
        //         left join quizto.qbank b on b.qid = a.qid
        //         left join quizto.category c on c.cid = b.cid
        //         left join quizto.users d on d.uid = a.uid
        //         group by d.uid
        //         order by total desc';

        $query =  $query=$this->db->query($script);
        $result = $query->row_array();

        return $result;
    }

    function hasil_norma_ist($uid)
    {
        
    }
}