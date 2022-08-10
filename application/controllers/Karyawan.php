<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {
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
        $this->load->model('model_karyawan');
    }

	public function index()
	{
        $data['karyawan'] = $this->model_karyawan->getData()->result();
        

        $this->load->view('admin/v_header');
		$this->load->view('admin/karyawan/v_index', $data);
        $this->load->view('admin/v_footer');
	}
    public function add()
    { 
        $this->load->view('admin/v_header');
		$this->load->view('admin/karyawan/v_add');
        $this->load->view('admin/v_footer');
    }
    public function actionAdd()
    {
        $nama = $this->input->post('nama');
        $jabatan = $this->input->post('jabatan');
        $kode_anggota = substr($jabatan, 0, 1);
        $maxId = $this->model_karyawan->getMax();
        $kode_id = $kode_anggota . date('ym') . $maxId->kode;
        $data = [
            'nama' => $nama,
            'jabatan' => $jabatan,
            'kode_id' => $kode_id,
            'password' => password_hash('12345678', PASSWORD_DEFAULT)
        ];

        $this->model_karyawan->insertData($data);   

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Menambahkan Karyawan', 'icon' => 'success']);

        redirect(base_url().'karyawan');
    }
    public function editKaryawan($id)
    {
        $id_karyawan = ['id_karyawan' => $id];
        $data['karyawan'] = $this->model_karyawan->editData($id_karyawan)->row();
        $this->load->view('admin/v_header');
		$this->load->view('admin/karyawan/v_edit', $data);
        $this->load->view('admin/v_footer');
    }

    public function actionEdit($id)
    {  
        $id_karyawan = ['id_karyawan' => $id];
        $data = [
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan')
        ];

        if($this->input->post('password')){
            $data['password'] =  password_hash($this->input->post('password'), PASSWORD_DEFAULT);
        }

        $this->model_karyawan->updateData($id_karyawan, $data);

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Edit Karyawan', 'icon' => 'success']);
       
        redirect(base_url()."karyawan/editKaryawan/$id");
    }

    public function deleteKaryawan($id)
    {
        $id_karyawan = ['id_karyawan' => $id];
        $this->model_karyawan->deleteData($id_karyawan);

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Hapus Karyawan', 'icon' => 'success']);

        redirect(base_url()."karyawan");
    }
}
