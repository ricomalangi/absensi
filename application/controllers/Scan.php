<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scan extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        if($this->session->userdata('id_jabatan') != 1){
            $this->session->set_flashdata('alert','Access Denied !');
            redirect(base_url('user_dashboard'));
        }
        $this->load->model('model_scan');
    }
	public function index()
	{
		$this->load->view('welcome_message');
	}
    
    public function cekId()
    {
        $kode_id_karyawan = $this->input->post('kode_id_karyawan');
        $tgl = date('Y-m-d');
        $jam_msk = date('H:i:s');
		$jam_klr = date('H:i:s');
        $cek_id = $this->model_scan->cek_id($kode_id_karyawan);
        $cek_kehadiran = $this->model_scan->cek_kehadiran($kode_id_karyawan, $tgl);
        
        $jam_kantor = $this->db->select('jam_masuk, jam_pulang, maksimal_kerja')->get('tb_absensi')->row();
        $diff = date_diff(date_create($jam_kantor->jam_masuk), date_create($jam_msk));

        if($jam_msk > $jam_kantor->jam_masuk){
            $selisih_waktu = "terlambat $diff->h jam $diff->i menit";
        } else {
            $selisih_waktu = "tepat waktu";
        }

        $status_kerja = "";
        if($cek_kehadiran->jam_masuk != ''){
            $lama_karyawan_bekerja = date_diff(date_create($cek_kehadiran->jam_masuk), date_create($jam_klr));
            if($lama_karyawan_bekerja->h == $jam_kantor->maksimal_kerja){
                $status_kerja = "kerja $jam_kantor->maksimal_kerja jam ";
            } else if($lama_karyawan_bekerja->h > $jam_kantor->maksimal_kerja){
                $lembur = $lama_karyawan_bekerja->h - $jam_kantor->maksimal_kerja;
                $status_kerja = "lembur $lembur jam";
            } else {
                $status_kerja = "kerja < $jam_kantor->maksimal_kerja jam";
            }
        }

        if(!$cek_id){
           $this->session->set_flashdata('alert', ['title' => 'Not found', 'message' => 'qrcode tidak ditemukan', 'icon' => 'error']);
        } elseif($cek_kehadiran && $cek_kehadiran->jam_masuk != '00:00:00' && $cek_kehadiran->jam_keluar == '00:00:00' && $cek_kehadiran->status_absensi == 1) {
            $data = [
                'jam_keluar' => $jam_klr,
                'status_absensi' => 2,
                'status_kerja' => $status_kerja
            ];
            $this->model_scan->absen_pulang($kode_id_karyawan, $data);
            $this->session->set_flashdata('alert', ['title' => 'Absensi Pulang', 'message' => 'absen pulang berhasil', 'icon' => 'success']);
        } elseif($cek_kehadiran && $cek_kehadiran->jam_masuk != '00:00:00' && $cek_kehadiran->jam_keluar != '00:00:00' && $cek_kehadiran->status_absensi == 2){
            $this->session->set_flashdata('alert', ['title' => 'Absensi', 'message' => 'anda sudah melakukan absensi', 'icon' => 'error']);
        } else {
            $data = [
				'kode_id_karyawan' => $kode_id_karyawan,
				'tanggal' => $tgl,
                'jam_masuk_kantor' => $jam_kantor->jam_masuk,
                'jam_pulang_kantor' => $jam_kantor->jam_pulang,
				'jam_masuk' => $jam_msk,
				'status_kehadiran' => $selisih_waktu,
				'status_absensi' => 1,
            ];
			$this->model_scan->absen_masuk($data);
            $this->session->set_flashdata('alert', ['title' => 'Absensi Masuk', 'message' => 'berhasil absen', 'icon' => 'success']);
        }
        redirect(base_url('absensi'));
    }
}
