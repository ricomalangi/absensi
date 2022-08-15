<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_presensi extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
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
            'karyawan' => $this->model_presensi->getDataWhere('tk.kode_id, tk.nama, tj.nama_jabatan', $this->session->userdata('kode_karyawan') ,$get_bulan, $get_tahun),
            'bulan_sekarang' => $bulan,
            'tahun_sekarang' => $get_tahun
        ];
        
        $this->load->view('user/v_header');
		$this->load->view('user/presensi/v_index', $data);
        $this->load->view('user/v_footer');
	}

    public function detail()
    {
        $data['presensi'] = $this->model_presensi->getAbsensiWhere($this->session->userdata('kode_karyawan'))->result();
        $this->load->view('user/v_header');
        $this->load->view('user/presensi/v_detail', $data);
        $this->load->view('user/v_footer');
    }
}
