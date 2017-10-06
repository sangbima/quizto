<?php
Class Kotakabupaten_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get()
    {
        return $this->db->get("kota_kabupaten");
    }

    public function get_kotakabupaten_by_provinsi($provinsi = null)
    {
        $this->db->select('id, provinsi, kotakabupaten');
        if($provinsi != NULL) {
            $this->db->where('provinsi', $provinsi);
            $this->db->where('status', 1);
        }

        $query = $this->db->get('locations');

        $kotakab = array();
        if($query->result()){
            foreach ($query->result() as $value) {
                $kotakab[$value->kotakabupaten] = $value->kotakabupaten;
            }
            return $kotakab;
        } else {
            return false;
        }
    }
}