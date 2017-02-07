<?php
Class Disc_model extends CI_Model
{

    function disc_list_group_by_no() {
        $this->db->order_by('disc_statement.id','asc');
        $this->db->group_by('disc_statement.no_pernyataan');
        $query=$this->db->get('disc_statement');
        return $query->result_array();
    }

    function disc_list_by_no($no) {
        $this->db->order_by('disc_statement.id','asc');
        $this->db->where('disc_statement.no_pernyataan', $no);
        $query=$this->db->get('disc_statement');
        return $query->result_array();
    }

    function insert_disc(){
        
        for($i=1; $i<=4; $i++) {
            $userdata=array(
                'no_pernyataan'=>$this->input->post('no_pernyataan'),
                'disc_m'=>$this->input->post('disc_m_'.$i),
                'disc_l'=>$this->input->post('disc_l_'.$i),
                'statement'=>$this->input->post('statement_'.$i),
            );
            $this->db->insert('disc_statement',$userdata);
            $quid=$this->db->insert_id();
        }


        // $userdata=array(
        //     'no_pernyataan'=>$this->input->post('no_pernyataan'),
        //     'disc_m'=>$this->input->post('disc_m_1'),
        //     'disc_l'=>$this->input->post('disc_l_1'),
        //     'statement'=>$this->input->post('statement_1'),
        // );

        // $userdata=array(
        //     'no_pernyataan'=>$this->input->post('no_pernyataan'),
        //     'disc_m'=>$this->input->post('disc_m_2'),
        //     'disc_l'=>$this->input->post('disc_l_2'),
        //     'statement'=>$this->input->post('statement_2'),
        // );

        // $userdata=array(
        //     'no_pernyataan'=>$this->input->post('no_pernyataan'),
        //     'disc_m'=>$this->input->post('disc_m_3'),
        //     'disc_l'=>$this->input->post('disc_l_3'),
        //     'statement'=>$this->input->post('statement_3'),
        // );

        // $userdata=array(
        //     'no_pernyataan'=>$this->input->post('no_pernyataan'),
        //     'disc_m'=>$this->input->post('disc_m_4'),
        //     'disc_l'=>$this->input->post('disc_l_4'),
        //     'statement'=>$this->input->post('statement_4'),
        // );

        // $this->db->insert('disc_statement',$userdata);
        // $quid=$this->db->insert_id();
        return $quid;
    }

    function insert_answer()
    {
        $rid=$_POST['rid'];
        $srid=$this->session->userdata('rid');
        $logged_in=$this->session->userdata('logged_in');
        $uid=$logged_in['uid'];
        if($srid != $rid){
            return "Something wrong";
        }
        $query=$this->db->query("select * from result join disc_answers on result.quid=disc_answers.quid where result.rid='$rid' ");

        $quiz=$query->row_array();

        // var_dump(quiz);
        // var_dump($_POST);die();

        return true;
    }
}