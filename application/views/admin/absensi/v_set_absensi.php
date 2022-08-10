<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Setting Jam Absensi
        </div>
        <div class="card-body">
            <form action="<?= base_url('absensi/actionUpdate') ?>" method="POST">
                <div class="form-group">
                    <label for="jam_masuk">Jam masuk</label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="time" class="form-control" name="jam_masuk_awal" id="jam_masuk" value="<?= $absensi->jam_masuk_awal ?>">
                        </div>
                        <div class="col-md-2 text-center">
                            <p>sampai</p>
                        </div>
                        <div class="col-md-5">
                            <input type="time" class="form-control" name="jam_masuk_akhir" id="jam_masuk" value="<?= $absensi->jam_masuk_akhir ?>">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary" name="add"><i class="fa fa-save"></i> simpan</button>
            </form>
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