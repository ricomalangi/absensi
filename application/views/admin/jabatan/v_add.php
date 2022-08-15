<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Tambah Jabatan
        </div>
        <div class="card-body">
            <form action="<?= base_url('jabatan/actionAdd') ?>" method="POST">
                <div class="form-group">
                    <label for="jabatan">Nama jabatan</label>
                    <input type="text" class="form-control" name="jabatan" id="jabatan" placeholder="input nama jabatan">
                </div>
                <a href="<?= base_url('jabatan') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-angle-left"></i> kembali</a>
                <button type="submit" class="btn btn-sm btn-primary" name="add"><i class="fa fa-save"></i> tambah jabatan</button>
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