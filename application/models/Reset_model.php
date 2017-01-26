<?php
Class Reset_model extends CI_Model
{

    function reset() {
        // Hapus user kecuali admin (su)
        // Hapus data di tabel answers, disc_answers, dan result, kembalikan nilai inrementnya

        $query = $this->db->query('YOUR QUERY HERE');
        
        return true;
    }
}