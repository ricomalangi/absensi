<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Informasi karyawan</h6>
                </div>
                <div class="card-body">
                    <p>Nama karyawan: <?= $this->session->userdata('nama_karyawan') ?></p>
                    <p>Kode karyawan: <?= $this->session->userdata('kode_karyawan') ?></p>
                    <p>Jabatan: <?= $this->session->userdata('jabatan') ?></p>
                </div>
              </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Qrcode Anda</h6>
                </div>
                <div class="card-body text-center">
                   <img src="<?= $qrcode ?>" style="width: 27%;">
                </div>
              </div>
        </div>
    </div>

</div>
<?php if($this->session->flashdata('alert') == TRUE):?>
    <script>
        Swal.fire({title: 'ERROR',text: '<?= $this->session->flashdata('alert') ?>',icon: 'error',confirmButtonText: 'OK'})
    </script>
<?php endif ?>
<!-- /.container-fluid -->

