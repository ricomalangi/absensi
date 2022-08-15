<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="<?= base_url() ?>user_presensi" class="btn btn-md btn-primary">Kembali</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Tgl absensi</th>
                    <th>Jam Masuk Kantor</th>
                    <th>Jam Pulang Kantor</th>
                    <th>Jam Masuk Karyawan</th>
                    <th>Jam Keluar Karyawan</th>
                    <th>Status Kerja</th>
                    <th>Status Kehadiran</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($presensi as $data): ?>
                    <tr>
                        <td><?= $data->tanggal ?></td>
                        <td><?= $data->jam_masuk_kantor ?></td>
                        <td><?= $data->jam_pulang_kantor ?></td>
                        <td><?= $data->jam_masuk ?></td>
                        <td><?= $data->jam_keluar ?></td>
                        <td><?= $data->status_kerja ?></td>
                        <td><?= $data->status_kehadiran ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>
