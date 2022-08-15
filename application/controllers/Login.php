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
            'jam_absensi' => $this->db->select('jam_masuk')->get('tb_absensi')->row() 
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
                $this->session->set_userdata('id_jabatan', $hasil->id_jabatan);
                $this->session->set_userdata('is_login', TRUE);
                // redirect ke admin
                if($hasil->id_jabatan == 1){
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
        redirect(base_url());
    }

    public function test()
    {
        $jam_kantor = $this->db->select('jam_masuk, jam_pulang, maksimal_kerja')->get('tb_absensi')->row();
      
        $lama_karyawan_bekerja = date_diff(date_create('10:00:00'), date_create('22:00:00'));

        if($lama_karyawan_bekerja->h == $jam_kantor->maksimal_kerja){
            echo "kerja 8 jam ";
        } else if($lama_karyawan_bekerja->h > $jam_kantor->maksimal_kerja){
            $lembur = $lama_karyawan_bekerja->h - $jam_kantor->maksimal_kerja;
            
            echo "lembur $lembur jam";
        } else {
            echo "kerja < $jam_kantor->maksimal_kerja jam";
        }
        echo "<br>";
        
        echo "<br>";
        print_r($jam_kantor->jam_pulang);
    }
}

