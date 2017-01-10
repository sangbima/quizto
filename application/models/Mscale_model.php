<?php
Class Mscale_model extends CI_Model
{
    function question_list() {
        $this->db->order_by('most_scale.id','asc');
        $query=$this->db->get('most_scale');
        return $query->result_array();
    }

    function get_mscale(){
        $query=$this->db->get('most_scale');
        return $query->row_array();
    }
}