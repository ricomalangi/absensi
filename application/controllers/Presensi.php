<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Presensi extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        if($this->session->userdata('jabatan') != 'Admin'){
            $this->session->set_flashdata('alert','Access Denied !');
            redirect(base_url('user_dashboard'));
        }
        $this->load->model('model_presensi');
    }

	public function index()
	{
        $get_bulan = date('n');
        $get_tahun = date('Y');
        if($this->input->get('bulan') || $this->input->get('tahun')){
            $get_bulan = $this->input->get('bulan');
            $get_tahun = $this->input->get('tahun');
        } 
        $bulan = date('M');
        switch($bulan){
            case 'Jan':
                $bulan = 'Januari';
                break;
            case 'Feb':
                $bulan = 'Februari';
                break;
            case 'Mar':
                $bulan = 'Maret';
                break;
            case 'Apr':
                $bulan = 'April';
                break;
            case 'May':
                $bulan = 'Mei';
                break;
            case 'Jun':
                $bulan = 'Juni';
                break;
            case 'Jul':
                $bulan = 'Juli';
                break;
            case 'Aug':
                $bulan = 'Agustus';
                break;
            case 'Sept':
                $bulan = 'September';
                break;
            case 'Oct':
                $bulan = 'Oktober';
                break;
            case 'Nov':
                $bulan = 'November';
                break;
            case 'Dec':
                $bulan = 'Desember';
                break;
            default:
                $bulan = 'invalid month';
        }
        $data = [
            'karyawan' => $this->model_presensi->getData('kode_id, nama, jabatan', $get_bulan, $get_tahun),
            'bulan_sekarang' => $bulan,
            'tahun_sekarang' => $get_tahun
        ];

        // echo '<pre>';print_r($data);echo '</pre>';die();
        
        $this->load->view('admin/v_header');
		$this->load->view('admin/presensi/v_index', $data);
        $this->load->view('admin/v_footer');
	}

    public function add()
    {
        $data = [
            'karyawan' => $this->model_presensi->getData('kode_id, nama')->result()
        ];
        $this->load->view('admin/v_header');
        $this->load->view('admin/presensi/v_add', $data);
        $this->load->view('admin/v_footer');
    }

    public function actionAdd()
    {
        $kode_karyawan = $this->input->post('kode_id_karyawan');
        $tanggal = $this->input->post('tanggal');
        $jam_masuk = $this->input->post('jam_masuk');
        $jam_keluar = $this->input->post('jam_keluar');
        $data = [
            'kode_id_karyawan' => $kode_karyawan,
            'tanggal' => $tanggal,
            'jam_masuk' => $jam_masuk,
            'jam_keluar' => $jam_keluar,
            'status_kehadiran' => 'absen manual',
            'status_absensi' => 2
        ];
        $this->model_presensi->insertData($data);

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'sukses melakukan absensi', 'icon' => 'success']);

        redirect(base_url().'presensi');
    }

}
