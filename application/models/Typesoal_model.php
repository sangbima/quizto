<?php
Class Typesoal_model extends CI_Model
{
    function typesoal_list() {
        $this->db->order_by('tipe_soal.id','asc');
        $query=$this->db->get('tipe_soal');
        return $query->result_array();
    }

    function get_typesoal(){
        $query=$this->db->get('tipe_soal');
        return $query->row_array();
    }
}