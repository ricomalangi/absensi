<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        $this->load->model('model_absensi');
    }
	public function index()
	{
        $data['absensi'] = $this->model_absensi->getData()->row();

        $this->load->view('admin/v_header');
		$this->load->view('admin/absensi/v_index', $data);
        $this->load->view('admin/v_footer');
	}

    public function setAbsensi()
    {
        $data['absensi'] = $this->model_absensi->getData()->row();

        $this->load->view('admin/v_header');
		$this->load->view('admin/absensi/v_set_absensi', $data);
        $this->load->view('admin/v_footer');
    }
    
    public function actionUpdate()
    {
        $jam_masuk = $this->input->post('jam_masuk');
        $maksimal_kerja = $this->input->post('maksimal_kerja');
        $jam_pulang = date_add(date_create($jam_masuk), date_interval_create_from_date_string("$maksimal_kerja hours"));
        $jam_pulang = date_format($jam_pulang, "H:i:s");
        $data = [
            'jam_masuk' =>  $jam_masuk,
            'jam_pulang' =>  $jam_pulang,
            'maksimal_kerja' => $maksimal_kerja
        ];

        $this->model_absensi->updateData($data);   

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'sukses update absensi', 'icon' => 'success']);

        redirect(base_url().'absensi/setAbsensi');
    }
}
