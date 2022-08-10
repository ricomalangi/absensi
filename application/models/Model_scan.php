<?php

class Model_scan extends Ci_Model
{
    public function cek_id($kode_id_karyawan)
    {
        $query_str = $this->db->where('kode_id', $kode_id_karyawan)->get('tb_karyawan');
        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }

    public function absen_masuk($data)
    {
        return $this->db->insert('tb_presensi', $data);
    }

    public function cek_kehadiran($kode_id_karyawan, $tgl)
    {
        $query_str = $this->db->where('kode_id_karyawan', $kode_id_karyawan)->where('tanggal', $tgl)->get('tb_presensi');
        if ($query_str->num_rows() > 0) {
            return $query_str->row();
        } else {
            return false;
        }
    }

    public function absen_pulang($kode_id_karyawan, $data)
    {
        $tgl = date('Y-m-d');
        return $this->db->where('kode_id_karyawan', $kode_id_karyawan)
            ->where('tanggal', $tgl)
            ->update('tb_presensi', $data);
    }
}
