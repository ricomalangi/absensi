<?php 

class Model_jabatan extends CI_Model{
    private $table = 'tb_jabatan';

    function getData()
    {
        return $this->db->get($this->table);
    }
    function getDataWhere($id)
    {
        $this->db->where('id_jabatan', $id);
        return $this->db->get($this->table);
    }
    function insertData($data){
        $this->db->insert($this->table, $data);
    }

    function updateData($id, $data)
    {
        $this->db->where($id);
        $this->db->update($this->table, $data);
    }
    function deleteData($id){
        $this->db->where($id);
        $this->db->delete($this->table);
    }
}