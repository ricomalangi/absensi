<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('model_scan');
    }
	public function index()
	{
        $data = [
            'jam_absensi' => $this->db->select('jam_masuk_awal, jam_masuk_akhir')->get('tb_absensi')->row() 
        ];
		$this->load->view('login', $data);
	}
    
    public function actionLogin()
    {
        $kode_karyawan = $this->input->post('kode_karyawan');
        $password = $this->input->post('password');
        $cek_karyawan = $this->db->get_where('tb_karyawan', ['kode_id' => "$kode_karyawan"]);

        if($cek_karyawan->num_rows() > 0){
            $hasil = $cek_karyawan->row();
            if(password_verify($password, $hasil->password)){
                // membuat session
                $this->session->set_userdata('id_karyawan', $hasil->id_karyawan);
                $this->session->set_userdata('kode_karyawan', $kode_karyawan);
                $this->session->set_userdata('nama_karyawan', $hasil->nama);
                $this->session->set_userdata('jabatan', $hasil->jabatan);
                $this->session->set_userdata('is_login', TRUE);
                // redirect ke admin
                if($hasil->jabatan == 'Admin'){
                    redirect(base_url('dashboard'));
                } else {
                    redirect(base_url('user_dashboard'));
                }
            }else{
                $this->session->set_flashdata('alert','Password salah !');
                redirect(base_url());
            }
        } else {
            $this->session->set_flashdata('alert','Kode karyawan tidak ditemukan !');
            redirect(base_url());
        }
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function cekId()
    {
        $kode_id_karyawan = $this->input->post('kode_id_karyawan');
        $tgl = date('Y-m-d');
        $jam_msk = date('H:i:s');
		$jam_klr = date('H:i:s');
        $cek_id = $this->model_scan->cek_id($kode_id_karyawan);
        $cek_kehadiran = $this->model_scan->cek_kehadiran($kode_id_karyawan, $tgl);
        
        $get_jam_masuk_akhir = $this->db->select('jam_masuk_akhir')->get('tb_absensi')->row('jam_masuk_akhir');
        $diff = date_diff(date_create($get_jam_masuk_akhir), date_create($jam_msk));
        $selisih_waktu = "telat $diff->h jam $diff->i menit";

        if(!$cek_id){
           $this->session->set_flashdata('alert', ['title' => 'Not found', 'message' => 'qrcode tidak ditemukan', 'icon' => 'error']);
        } elseif($cek_kehadiran && $cek_kehadiran->jam_masuk != '00:00:00' && $cek_kehadiran->jam_keluar == '00:00:00' && $cek_kehadiran->status_absensi == 1) {
            $data = [
                'jam_keluar' => $jam_klr,
                'status_absensi' => 2
            ];
            $this->model_scan->absen_pulang($kode_id_karyawan, $data);
            $this->session->set_flashdata('alert', ['title' => 'Absensi Pulang', 'message' => 'absen pulang berhasil', 'icon' => 'success']);
        } elseif($cek_kehadiran && $cek_kehadiran->jam_masuk != '00:00:00' && $cek_kehadiran->jam_keluar != '00:00:00' && $cek_kehadiran->status_absensi == 2){
            $this->session->set_flashdata('alert', ['title' => 'Absensi', 'message' => 'anda sudah melakukan absensi', 'icon' => 'error']);
        } else {
            $data = [
				'kode_id_karyawan' => $kode_id_karyawan,
				'tanggal' => $tgl,
				'jam_masuk' => $jam_msk,
				'status_kehadiran' => $selisih_waktu,
				'status_absensi' => 1,
            ];
			$this->model_scan->absen_masuk($data);
            $this->session->set_flashdata('alert', ['title' => 'Absensi Masuk', 'message' => 'berhasil absen', 'icon' => 'success']);
        }
        redirect(base_url());
    }
}
