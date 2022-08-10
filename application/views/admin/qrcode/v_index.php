<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    Generate QR Code
                </div>
                <div class="card-body">
                    <label for="nama">Pilih Nama</label>
                    <select name="nama" id="nama" class="form-control">
                        <option disabled selected>--pilih user--</option>
                        <?php foreach($karyawan as $data): ?>
                            <option value="<?= $data->id_karyawan ?>"><?= $data->nama ?></option>
                        <?php endforeach ?>
                    </select>
                    <button class="btn btn-sm btn-primary mt-5" onclick="generateCode()">Submit</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    Informasi Qrcode Akan Tampil Disini
                </div>
                <div class="card-body" id="show-qrcode">
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function generateCode(){
        event.preventDefault();

        let id = $('#nama').val();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('Gen_qrcode/generate/') ?>',
            data: `id=${id}`,
            beforeSend: function() {
                $('#show-qrcode').html('<div class="text-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function(msg) {
                $('#show-qrcode').html(msg);
            }
        });
    }
</script>
