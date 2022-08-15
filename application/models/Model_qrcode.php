<?php 

class Model_qrcode extends CI_Model{
    private $table = 'tb_karyawan';

    function getData($column = "*"){
        $this->db->select($column);
        $this->db->where('id_jabatan !=', 1);
        return $this->db->get($this->table);
    }

    function insertData($data){
        $this->db->insert($this->table, $data);
    }

    function getDataByID($id)
    {
        $data = $this->db->query("SELECT tk.nama, tk.kode_id, tj.nama_jabatan FROM tb_karyawan tk INNER JOIN tb_jabatan tj ON tk.id_jabatan = tj.id_jabatan WHERE tk.id_karyawan = $id");
        return $data;
    }

    function updateData($id, $data)
    {
        $this->db->where($id);
        $this->db->update($this->table, $data);
    }
}