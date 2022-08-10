<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            My profile
        </div>
        <div class="card-body">
            <form action="<?= base_url('user_profile/update') ?>" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kode_karyawan">Kode Karyawan</label>
                            <input type="text" class="form-control" id="kode_karyawan" value="<?= $karyawan->kode_id ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jabatan">Jabatan</label>
                            <input type="text" class="form-control" id="jabatan" value="<?= $karyawan->jabatan ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="karyawan">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama" id="karyawan" placeholder="input nama karyawan" value="<?= $karyawan->nama ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah password</small>
                </div>
                <button type="submit" class="btn btn-sm btn-primary" name="add"><i class="fa fa-save"></i> Save</button>
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