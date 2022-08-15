<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller {
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
        $this->load->model('model_jabatan');
    }
	public function index()
	{
        $data['jabatan'] = $this->model_jabatan->getData()->result();
        $this->load->view('admin/v_header');
		$this->load->view('admin/jabatan/v_index', $data);
        $this->load->view('admin/v_footer');
	}
    public function add()
    {
        $this->load->view('admin/v_header');
		$this->load->view('admin/jabatan/v_add');
        $this->load->view('admin/v_footer');
    }
    public function actionAdd()
    {
        $data['nama_jabatan'] = $this->input->post('jabatan');

        $this->model_jabatan->insertData($data);   

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Menambahkan Jabatan', 'icon' => 'success']);

        redirect(base_url().'jabatan');
    }

    public function edit($id)
    {
        $data['jabatan'] = $this->model_jabatan->getDataWhere($id)->row();
        $this->load->view('admin/v_header');
		$this->load->view('admin/jabatan/v_edit',$data);
        $this->load->view('admin/v_footer');
    }
    public function actionEdit($id)
    {
        $id_jabatan = ['id_jabatan' => $id];
        $data['nama_jabatan'] = $this->input->post('jabatan');

        $this->model_jabatan->updateData($id_jabatan,$data);   

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Update Jabatan', 'icon' => 'success']);

        redirect(base_url().'jabatan');
    }



    public function deleteJabatan($id)
    {
        $id_jabatan = ['id_jabatan' => $id];
        if($id == 1){
            $this->session->set_flashdata('alert', ['title' => 'Error', 'message' => 'Tidak dapat menghapus jabatan admin', 'icon' => 'error']);
            redirect(base_url()."jabatan");
        } else {
            $this->model_jabatan->deleteData($id_jabatan);
            $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'Berhasil Hapus jabatan', 'icon' => 'success']);
    
            redirect(base_url()."jabatan");
        }
    }
}
