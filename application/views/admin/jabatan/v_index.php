<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url('jabatan/add') ?>" class="btn btn-sm btn-primary"><i class="fa fa-plus mr-2"></i>Tambah Jabatan</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No</th>
                    <th>Jabatan</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                <?php 
                $no = 1;
                foreach($jabatan as $data): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $data->nama_jabatan ?></td>
                        <td>
                            <?php if($data->id_jabatan != 1): ?>
                                <a href="<?= base_url() ?>jabatan/edit/<?= $data->id_jabatan ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                <a href="<?= base_url() ?>jabatan/deleteJabatan/<?= $data->id_jabatan ?>" class="btn btn-sm btn-danger" id="delete"><i class="fa fa-trash"></i></a>
                            <?php endif ?>
                        </td>
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

<script>
    $(document).ready(function(){
        $('a#delete').on('click', function(e){
            e.preventDefault()
            let href = $(this).attr('href')
            Swal.fire({
                title: 'Apakah anda ingin menghapus?',
                text: 'Data akan dihapus permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = href
                }
            })
        });
    })
</script>