<?php 

class Model_qrcode extends CI_Model{
    private $table = 'tb_karyawan';

    function getData($column = "*"){
        $this->db->select($column);
        $this->db->where('jabatan !=', 'Admin');
        return $this->db->get($this->table);
    }

    function insertData($data){
        $this->db->insert($this->table, $data);
    }

    function getDataByID($id)
    {
        return $this->db->get_where($this->table, $id);
    }

    function updateData($id, $data)
    {
        $this->db->where($id);
        $this->db->update($this->table, $data);
    }
}