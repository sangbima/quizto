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

    public function getkabkota($prov=null)
    {
        $this->db->select('kotakabupaten');
        $this->db->order_by('kotakabupaten', 'asc');
        if($prov != null) {
            $this->db->where('provinsi', $prov);
        }
        $query =  $this->db->get("locations");
        $datas = $query->result_object();

        if($datas) {
            foreach ($datas as $key => $value) {
                $result[$value->kotakabupaten] = $value->kotakabupaten;
            }

            return $result;
        } else {
            return false;
        }
    }
}