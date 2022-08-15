<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Setting Jam Absensi
        </div>
        <div class="card-body">
            <form action="<?= base_url('absensi/actionUpdate') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_masuk">Jam masuk</label>
                            <input type="time" class="form-control" name="jam_masuk" id="jam_masuk" value="<?= $absensi->jam_masuk ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_pulang">Jam Pulang</label>
                            <input type="time" class="form-control" id="jam_pulang" value="<?= $absensi->jam_pulang ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_pulang">Lama bekerja</label>
                            <div class="input-group mb-2 mr-sm-2">
                                <input type="number" name="maksimal_kerja" class="form-control" id="jam_pulang" value="<?= $absensi->maksimal_kerja ?>">
                                <div class="input-group-prepend">
                                <div class="input-group-text">Jam</div>
                                </div>
                            </div>
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

<script>

</script>