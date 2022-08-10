<?php 

class Model_presensi extends CI_Model{
    private $table = 'tb_presensi';

    function getData($column = "*", $month = null, $year = null){
        if($month == null || $year == null){
            $month = date('n');
            $year = date('Y');
        }
        $this->db->select($column);
        $data = $this->db->get('tb_karyawan')->result_array();


        foreach($data as $key => $value){
            $hadir = [];
            $kode_id = $data[$key]['kode_id'];
            
            $sql = "SELECT tanggal, id_presensi, DAY(tanggal) AS tgl FROM tb_presensi WHERE kode_id_karyawan='$kode_id' AND month(tanggal) = $month AND year(tanggal) = $year";

            $kehadiran = $this->db->query($sql)->result_array();
            
           
            foreach($kehadiran as $h => $value){
                array_push($hadir, $kehadiran[$h]['tgl']);
            }
            $data[$key]['tgl_hadir'] = $hadir;
        }
        // $data['hadir'] = $hadir;

        // echo '<pre>';print_r($data);echo '</pre>';die();

        return $data;
        
    }

    function getDataWhere($column = "*", $kode_id_karyawan ,$month = null, $year = null){
        if($month == null || $year == null){
            $month = date('n');
            $year = date('Y');
        }
        $this->db->select($column)->where('kode_id', $kode_id_karyawan);
        $data = $this->db->get('tb_karyawan')->result_array();


        foreach($data as $key => $value){
            $hadir = [];
            $kode_id = $data[$key]['kode_id'];
            
            $sql = "SELECT tanggal, id_presensi, DAY(tanggal) AS tgl FROM tb_presensi WHERE kode_id_karyawan='$kode_id' AND month(tanggal) = $month AND year(tanggal) = $year";

            $kehadiran = $this->db->query($sql)->result_array();
            
           
            foreach($kehadiran as $h => $value){
                array_push($hadir, $kehadiran[$h]['tgl']);
            }
            $data[$key]['tgl_hadir'] = $hadir;
        }

        return $data;
    }
    
    function insertData($data){
        $this->db->insert($this->table, $data);
    }

    function getAbsensi()
    {
        $sql = $this->db->query("SELECT kode_id_karyawan, nama, jabatan, tanggal, jam_masuk, jam_keluar, status_kehadiran FROM tb_presensi INNER JOIN tb_karyawan ON kode_id = kode_id_karyawan ORDER BY tanggal ASC");

        $hasil = $sql->result();

        return $hasil;
    }

}