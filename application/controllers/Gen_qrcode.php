<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;

class Gen_qrcode extends CI_Controller {
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
        $this->load->model('model_qrcode');
    }
	public function index()
	{
        $data['karyawan'] = $this->model_qrcode->getData('nama, id_karyawan')->result();

        $this->load->view('admin/v_header');
		$this->load->view('admin/qrcode/v_index', $data);
        $this->load->view('admin/v_footer');
	}
    public function generate()
    {
        $id_karyawan = $this->input->post('id');

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
                'nama' => $result->nama,
                'jabatan' => $result->nama_jabatan,
                'kode_id' => $result->kode_id,
                'qrcode' => $qrcode_result->getDataUri()
            ];
            $this->load->view('admin/qrcode/v_result', $data);
        } else {
            $data = ['not_found' => 'Data Tidak Ditemukan !!'];
            $this->load->view('admin/qrcode/v_result', $data);
        }
    }

}
