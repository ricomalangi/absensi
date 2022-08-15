<?php

use PhpOffice\PhpSpreadsheet\Calculation\Information\Value;

class Model_presensi extends CI_Model{
    private $table = 'tb_presensi';

    function getData($column = "*", $month = null, $year = null){
        if($month == null || $year == null){
            $month = date('n');
            $year = date('Y');
        }
        $this->db->select($column);
        $this->db->from('tb_karyawan tk');
        $this->db->join('tb_jabatan tj', 'tk.id_jabatan = tj.id_jabatan');
        $data = $this->db->get()->result_array();


        foreach($data as $key => $value){
            $hadir = [];
            $keterangan = [];
            $kode_id = $data[$key]['kode_id'];
            
            $sql = "SELECT tanggal, id_presensi, status_kehadiran, DAY(tanggal) AS tgl FROM tb_presensi WHERE kode_id_karyawan='$kode_id' AND month(tanggal) = $month AND year(tanggal) = $year";

            $kehadiran = $this->db->query($sql)->result_array();
            
           
            foreach($kehadiran as $h => $value){
                array_push($hadir, $kehadiran[$h]['tgl']);
            }
            foreach($kehadiran as $k => $value){
                array_push($keterangan, $kehadiran[$k]['status_kehadiran']);
            }
            $data[$key]['tgl_hadir'] = $hadir;
            $data[$key]['status_kehadiran'] = $keterangan;
        }
        //echo '<pre>';print_r($data);echo '</pre>';die();
        return $data;
    }

    function getDataWhere($column = "*", $kode_id_karyawan ,$month = null, $year = null){
        if($month == null || $year == null){
            $month = date('n');
            $year = date('Y');
        }
        $this->db->select($column);
        $this->db->from('tb_karyawan tk');
        $this->db->join('tb_jabatan tj', 'tk.id_jabatan = tj.id_jabatan')->where('kode_id', $kode_id_karyawan);
        $data = $this->db->get()->result_array();

        foreach($data as $key => $value){
            $hadir = [];
            $keterangan = [];
            $kode_id = $data[$key]['kode_id'];
            
            $sql = "SELECT tanggal, id_presensi, status_kehadiran, DAY(tanggal) AS tgl FROM tb_presensi WHERE kode_id_karyawan='$kode_id' AND month(tanggal) = $month AND year(tanggal) = $year";

            $kehadiran = $this->db->query($sql)->result_array();
            
            foreach($kehadiran as $h => $value){
                array_push($hadir, $kehadiran[$h]['tgl']);
            }
            foreach($kehadiran as $k => $value){
                array_push($keterangan, $kehadiran[$k]['status_kehadiran']);
            }
            $data[$key]['status_kehadiran'] = $keterangan;
            $data[$key]['tgl_hadir'] = $hadir;
        }
        return $data;
    }
    
    function insertData($data){
        $this->db->insert($this->table, $data);
    }

    function getAbsensi()
    {
        $sql = $this->db->query("SELECT tp.*, tk.nama, tj.nama_jabatan FROM tb_presensi tp INNER JOIN tb_karyawan tk ON tk.kode_id = tp.kode_id_karyawan INNER JOIN tb_jabatan tj ON tj.id_jabatan = tk.id_jabatan ORDER BY tk.nama ASC, tp.tanggal ASC");

        $hasil = $sql->result();

        return $hasil;
    }

    function getAbsensiWhere($kode_karyawan)
    {
        $sql = $this->db->query("SELECT tp.status_kerja, tp.jam_masuk_kantor, tp.jam_pulang_kantor, tp.tanggal, tp.jam_masuk, tp.jam_keluar, tp.status_kehadiran FROM tb_presensi tp INNER JOIN tb_karyawan tk ON tk.kode_id = tp.kode_id_karyawan  WHERE tp.kode_id_karyawan = '$kode_karyawan' ORDER BY tanggal ASC");

        return $sql;

    }
}