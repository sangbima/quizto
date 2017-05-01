<?php
Class Reset_model extends CI_Model
{

    function reset($confirm) {

        if($confirm == 'OK') {
            $this->db->truncate('result');
            $this->db->truncate('answers');
            $this->db->truncate('disc_answers');
            $this->db->where('uid !=', '1');
            $this->db->delete('users');
            $this->db->query('ALTER TABLE `users` auto_increment = 2');
            $this->db->where('gid !=', '1');
            $this->db->delete('group');
            $this->db->query('ALTER TABLE `group` auto_increment = 2');
            return true;
        } else {
            return false;
        }
    }
}