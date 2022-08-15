<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Presensi extends CI_Controller {

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
            'karyawan' => $this->model_presensi->getData('tk.kode_id, tk.nama, tj.nama_jabatan', $get_bulan, $get_tahun),
            'bulan_sekarang' => $bulan,
            'tahun_sekarang' => $get_tahun
        ];

      
        
        $this->load->view('admin/v_header');
		$this->load->view('admin/presensi/v_index', $data);
        $this->load->view('admin/v_footer');
	}

    public function add()
    {
        $data = [
            'karyawan' => $this->model_presensi->getData('tk.kode_id, tk.nama, tj.nama_jabatan')
        ];
        $this->load->view('admin/v_header');
        $this->load->view('admin/presensi/v_add', $data);
        $this->load->view('admin/v_footer');
    }

    public function actionAdd()
    {
        $kode_karyawan = $this->input->post('kode_id_karyawan');
        $tanggal = $this->input->post('tanggal');
        $jam_masuk = $this->input->post('jam_masuk');
        $jam_keluar = $this->input->post('jam_keluar');

        $jam_kantor = $this->db->select('jam_masuk, jam_pulang, maksimal_kerja')->get('tb_absensi')->row();
        $diff = date_diff(date_create($jam_kantor->jam_masuk), date_create($jam_masuk));

        if($jam_masuk > $jam_kantor->jam_masuk){
            $selisih_waktu = "terlambat $diff->h jam $diff->i menit";
        } else {
            $selisih_waktu = "tepat waktu";
        }

        $lama_karyawan_bekerja = date_diff(date_create($jam_masuk), date_create($jam_keluar));
        if($lama_karyawan_bekerja->h == $jam_kantor->maksimal_kerja){
            $status_kerja = "kerja $jam_kantor->maksimal_kerja jam ";
        } else if($lama_karyawan_bekerja->h > $jam_kantor->maksimal_kerja){
            $lembur = $lama_karyawan_bekerja->h - $jam_kantor->maksimal_kerja;
            $status_kerja = "lembur $lembur jam";
        } else {
            $status_kerja = "kerja < $jam_kantor->maksimal_kerja jam";
        }


        $data = [
            'kode_id_karyawan' => $kode_karyawan,
            'tanggal' => $tanggal,
            'jam_masuk_kantor' => $jam_kantor->jam_masuk,
            'jam_pulang_kantor' => $jam_kantor->jam_pulang,
            'jam_masuk' => $jam_masuk,
            'jam_keluar' => $jam_keluar,
            'status_kerja' => $status_kerja,
            'status_kehadiran' => $selisih_waktu,
            'status_absensi' => 2
        ];
        $this->model_presensi->insertData($data);

        $this->session->set_flashdata('alert', ['title' => 'Success', 'message' => 'sukses melakukan absensi', 'icon' => 'success']);

        redirect(base_url().'presensi');
    }

    public function detail($kode_karyawan)
    {
        $data['presensi'] = $this->model_presensi->getAbsensiWhere($kode_karyawan)->result();
        $this->load->view('admin/v_header');
        $this->load->view('admin/presensi/v_detail', $data);
        $this->load->view('admin/v_footer');
    }


    public function excel()
    {
        $data =  $this->model_presensi->getAbsensi();

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'No')
                    ->setCellValue('B1', 'Kode Karyawan')
                    ->setCellValue('C1', 'Nama Karyawan')
                    ->setCellValue('D1', 'Jabatan')
                    ->setCellValue('E1', 'Tanggal')
                    ->setCellValue('F1', 'Jam Masuk Kantor')
                    ->setCellValue('G1', 'Jam Pulang Kantor')
                    ->setCellValue('H1', 'Jam Masuk')
                    ->setCellValue('I1', 'Jam Keluar')
                    ->setCellValue('J1', 'Status Kehadiran')
                    ->setCellValue('K1', 'Status Kerja');
        
        $kolom = 2;
        $nomor = 1;

        // echo '<pre>';print_r($data);echo '</pre>';die();

        foreach($data as $karyawan){
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A' . $kolom, $nomor)
            ->setCellValue('B' . $kolom, $karyawan->kode_id_karyawan)
            ->setCellValue('C' . $kolom, $karyawan->nama)
            ->setCellValue('D' . $kolom, $karyawan->nama_jabatan)
            ->setCellValue('E' . $kolom, $karyawan->tanggal)
            ->setCellValue('F' . $kolom, $karyawan->jam_masuk_kantor)
            ->setCellValue('G' . $kolom, $karyawan->jam_pulang_kantor)
            ->setCellValue('H' . $kolom, $karyawan->jam_masuk)
            ->setCellValue('I' . $kolom, $karyawan->jam_keluar)
            ->setCellValue('J' . $kolom, $karyawan->status_kehadiran)
            ->setCellValue('K' . $kolom, $karyawan->status_kerja);
            $kolom++;
            $nomor++;
        }

        $writer = new Xlsx($spreadsheet);
        
        $date = date('d-m-Y');

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Absensi"'.$date.'".xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
            
        

    //   echo '<pre>'; print_r($data); echo '</pre>';die;
    }

}
