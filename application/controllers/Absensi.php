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
        $jam_masuk_awal = $this->input->post('jam_masuk_awal');
        $jam_masuk_akhir = $this->input->post('jam_masuk_akhir');
        $jam_pulang_awal = $this->input->post('jam_pulang_awal');
        $jam_pulang_akhir = $this->input->post('jam_pulang_akhir');

        $data = [
            'jam_masuk_awal' =>  $jam_masuk_awal,
            'jam_masuk_akhir' =>  $jam_masuk_akhir,
            'jam_pulang_awal' =>  $jam_pulang_awal,
            'jam_pulang_akhir' =>  $jam_pulang_akhir,
        ];

        $this->model_absensi->updateData($data);   

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'sukses update absensi', 'icon' => 'success']);

        redirect(base_url().'absensi/setAbsensi');
    }


}
