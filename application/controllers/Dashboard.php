<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        if($this->session->userdata('jabatan') != 'Admin'){
            $this->session->set_flashdata('alert','Access Denied !');
            redirect(base_url('user_dashboard'));
        }
    }
	public function index()
	{
        $this->load->view('admin/v_header');
		$this->load->view('admin/v_dashboard');
        $this->load->view('admin/v_footer');
	}
}
