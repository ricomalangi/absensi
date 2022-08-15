<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        if($this->session->userdata('id_jabatan') != 1){
            $this->session->set_flashdata('alert','Access Denied !');
            redirect(base_url('user_dashboard'));
        }
        $this->load->model('model_karyawan');
    }
	public function index()
	{
        $kode_karyawan = $this->session->userdata('kode_karyawan');
        $data['karyawan'] = $this->model_karyawan->getDataWhere($kode_karyawan)->row();
        
        $this->load->view('admin/v_header');
		$this->load->view('admin/profile/v_index', $data);
        $this->load->view('admin/v_footer');
	}

    public function update()
	{
        $kode_karyawan = $this->session->userdata('kode_karyawan');
        $data['nama'] = $this->input->post('nama');

        if($this->input->post('password')){
            $data['password'] =  password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->model_karyawan->updateDataKaryawan($kode_karyawan, $data);

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Edit Karyawan', 'icon' => 'success']);
       
        redirect(base_url()."profile");
	}
}
