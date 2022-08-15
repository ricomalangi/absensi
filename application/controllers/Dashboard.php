<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
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
    }
	public function index()
	{   
        $id_karyawan = $this->session->userdata('id_karyawan');
        $query_get_jabatan = "SELECT tj.nama_jabatan FROM tb_karyawan tk INNER JOIN tb_jabatan tj ON tj.id_jabatan = tk.id_jabatan WHERE tk.id_karyawan = $id_karyawan";

        $data['jabatan'] = $this->db->query($query_get_jabatan)->row('nama_jabatan');
    
        $this->load->view('admin/v_header');
		$this->load->view('admin/v_dashboard', $data);
        $this->load->view('admin/v_footer');
	}
}
