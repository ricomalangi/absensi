<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Tambah Karyawan
        </div>
        <div class="card-body">
            <form action="<?= base_url('karyawan/actionAdd') ?>" method="POST">
                <div class="form-group">
                    <label for="karayawan">Nama Karyawan</label>
                    <input type="text" class="form-control" name="nama" id="karayawan" placeholder="input nama karyawan">
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <select name="jabatan" id="jabatan" class="form-control">
                        <option selected disabled>--pilih jabatan--</option>
                        <option value="Staff">Staff</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <a href="<?= base_url('karyawan') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-angle-left"></i> kembali</a>
                <button type="submit" class="btn btn-sm btn-primary" name="add"><i class="fa fa-save"></i> tambah karyawan</button>
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