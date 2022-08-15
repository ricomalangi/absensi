<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

class User_dashboard extends CI_Controller {
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('is_login') == FALSE){
            $this->session->set_flashdata('alert','Anda Belum login, silahkan login terlebih dahulu !');
            redirect(base_url('login'));
        }
        $this->load->model('model_qrcode');
    }

	public function index()
	{
        $id_karyawan =  $this->session->userdata('id_karyawan');

        $karyawan = $this->model_qrcode->getDataById($id_karyawan);

        if($karyawan->num_rows() > 0){
            $result = $karyawan->row();
            
            $writer = new PngWriter();
            $nama_qr = $result->kode_id;

            $qrcode = QrCode::create($nama_qr)
            ->setEncoding(new Encoding('UTF-8'))
            ->setSize(300);
            $qrcode_result = $writer->write($qrcode);
            $upload_file = "\uploads\\$nama_qr.png";
            $qrcode_result->saveToFile(FCPATH . $upload_file);
            $data = [
                'qrcode' => $qrcode_result->getDataUri()
            ];
        } else {
            $data = ['not_found' => 'Data Tidak Ditemukan !!'];
        }
        $this->load->view('user/v_header');
		$this->load->view('user/v_dashboard', $data);
        $this->load->view('user/v_footer');
	}

}
