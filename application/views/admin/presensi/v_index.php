<?php
if($this->input->get('bulan')){
    $bulan = $this->input->get('bulan');
    switch($bulan){
        case '1':
            $bulan = 'Januari';
            break;
        case '2':
            $bulan = 'Februari';
            break;
        case '3':
            $bulan = 'Maret';
            break;
        case '4':
            $bulan = 'April';
            break;
        case '5':
            $bulan = 'Mei';
            break;
        case '6':
            $bulan = 'Juni';
            break;
        case '7':
            $bulan = 'Juli';
            break;
        case '8':
            $bulan = 'Agustus';
            break;
        case '9':
            $bulan = 'September';
            break;
        case '10':
            $bulan = 'Oktober';
            break;
        case '11':
            $bulan = 'November';
            break;
        case '12':
            $bulan = 'Desember';
            break;
        default:
            $bulan = 'invalid month';
    }
}
?>
<div class="container-fluid">
    <h5>
        <div class="alert alert-primary" role="alert">
            Data Presensi Bulan <b><?= (isset($bulan) ? $bulan : $bulan_sekarang) ?> <?= $tahun_sekarang ?></b>
        </div>
    </h5>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url('presensi/add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i>Absen Manual</a>
            <a href="<?= base_url('presensi/excel')?>" class="btn btn-sm btn-success"><i class="far fa-file-excel mr-2"></i>Rekap Absen Excel</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="<?= base_url() ?>presensi" method="GET" class="mb-4 form-inline d-flex justify-content-end">
                    <div class="form-group ">
                        <select name="bulan" class="form-control">
                            <option selected value="<?= date('n') ?>">--pilih bulan--</option>
                            <option value="1">Januari</option>
                            <option value="2">Februari</option>
                            <option value="3">Maret</option>
                            <option value="4">April</option>
                            <option value="5">Mei</option>
                            <option value="6">Juni</option>
                            <option value="7">Juli</option>
                            <option value="8">Agustus</option>
                            <option value="9">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="number" name="tahun" class="form-control ml-2" min="1900" max="2099" step="1" value=<?= ($tahun_sekarang ?? date('Y')) ?> />
                    </div>
                    <button type="submit" class="btn btn-primary mx-sm-3">filter bulan</button>
                </form>
                <table class="table table-bordered table-sm table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th rowspan="2" style="text-align: center;">Nama Karyawan</th>
                            <th rowspan="2" data-orderable="false">jabatan</th>
                            <th colspan="<?= date('t') ?>" style="text-align: center;" data-orderable="false">Tanggal</th>
                            <th rowspan="2" data-orderable="false" style="text-align: center;">Total Kehadiran</th>
                            <th rowspan="2" data-orderable="false">Detail</th>
                        </tr>
                        <tr>
                            <?php for ($i=1; $i <= date('t') ; $i++): ?>
                            <th style="text-align:center;" data-orderable="false"><?= $i ?></th>
                            <?php endfor ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($karyawan as $data): 
                        if($data['nama_jabatan'] == 'admin'){continue;}
                    ?>
                        <tr>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['nama_jabatan'] ?></td>
                            
                            <?php 
                            for($j = 1; $j <= date('t'); $j++){
                                if(in_array($j,$data['tgl_hadir'])){
                                    $key = array_search($j, $data['tgl_hadir']);
                                    $kehadiran = $data['status_kehadiran'][$key];
                                    if(strstr($kehadiran, "terlambat")){
                                        $badge = 'danger';
                                    } else {
                                        $badge = 'success';
                                    }

                                    echo "<td style='text-align:center'><i class='fas fa-check' style='color:green'></i>
                                    <span class='badge badge-pill badge-$badge'>$kehadiran</span>
                                    </td>";
                                } else {
                                    echo "<td>-</td>";
                                }
                            }
                            ?>
                            <td style="text-align: center;"><?= count($data['tgl_hadir']) ?></td>
                            <td><a href="<?= base_url() ?>presensi/detail/<?= $data['kode_id'] ?>" class="btn btn-sm btn-success">detail</td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php if($this->session->flashdata('alert') == TRUE):
    $result = $this->session->flashdata('alert');
?>
<script>
    Swal.fire({title: '<?= $result['title'] ?>',text: '<?= $result['message'] ?>',icon: '<?= $result['icon'] ?>',confirmButtonText: 'OK'})
</script>
<?php endif ?>
