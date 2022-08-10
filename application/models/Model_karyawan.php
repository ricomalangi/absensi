<?php 

class Model_karyawan extends CI_Model{
    private $table = 'tb_karyawan';

    function getData($column = "*"){
        $this->db->select($column);

        return $this->db->get($this->table);
    }

    function getDataWhere($kode_id){
        $this->db->where('kode_id', $kode_id);
        return $this->db->get($this->table);
    }

    function insertData($data){
        $this->db->insert($this->table, $data);
    }
    
    function getMax(){
        return $this->db->select('max(id_karyawan) as kode')->from('tb_karyawan')->get()->row();
    }

    function editData($id)
    {
        return $this->db->get_where($this->table, $id);
    }

    function updateData($id, $data)
    {
        $this->db->where($id);
        $this->db->update($this->table, $data);
    }

    function updateDataKaryawan($kode_karyawan, $data)
    {
        $this->db->where('kode_id',$kode_karyawan);
        $this->db->update($this->table, $data);
    }

    function deleteData($id)
    {
        $this->db->where($id);
        $this->db->delete($this->table);
    }
}