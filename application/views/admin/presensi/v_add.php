<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Absen Manual
        </div>
        <div class="card-body">
            <form action="<?= base_url('presensi/actionAdd') ?>" method="POST">
                <div class="form-group">
                    <label for="karyawan">Nama Karyawan</label>
                    <select class="form-control" name="kode_id_karyawan" id="karyawan">
                        <option selected disabled>--pilih karyawan--</option>
                        <?php foreach($karyawan as $k): 
                            if($k['nama_jabatan'] == 'admin'){continue;}    
                        ?>

                            <option value="<?= $k['kode_id'] ?>"><?= $k['nama'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_masuk">Jam Masuk</label>
                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jam_keluar">Jam Keluar</label>
                            <input type="time" name="jam_keluar" id="jam_keluar" class="form-control">
                        </div>
                    </div>
                </div>
                
                
                <a href="<?= base_url('presensi') ?>" class="btn btn-sm btn-secondary"><i class="fa fa-angle-left"></i> kembali</a>
                <button type="submit" class="btn btn-sm btn-primary" name="add"><i class="fa fa-save"></i> Save</button>
            </form>
        </div>
    </div>

</div>
