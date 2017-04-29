<?php
class Tools extends CI_Controller {

    public function message()
    {
        $this->load->database();

        $script = 'SELECT * FROM users';

        $query = $this->db->query($script);

        var_dump($query->row_array());
        foreach ($query->result() as $row)
        {
            echo $row->uid . ',';
        }
    }
}