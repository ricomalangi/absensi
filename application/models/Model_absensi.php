<?php 

class Model_absensi extends CI_Model{
    private $table = 'tb_absensi';

    function getData()
    {
        return $this->db->get($this->table);
    }

    function updateData($data)
    {
        $this->db->update($this->table, $data);
    }
}