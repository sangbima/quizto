<?php
Class Provinsi_model extends CI_Model
{
    public function get()
    {
        $this->db->select('provinsi');
        $this->db->group_by('provinsi');
        $this->db->order_by('provinsi', 'asc');
        $query =  $this->db->get("locations");
        $datas = $query->result_object();

        if($datas) {
            foreach ($datas as $key => $value) {
                $result[$value->provinsi] = $value->provinsi;
            }

            return $result;
        } else {
            return false;
        }
    }
}