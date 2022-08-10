<?php if(isset($not_found)){ ?>
    <div class="text-center">
        <?= $not_found ?>
    </div>
<?php } else { ?>
    <div id="frame">
        <div class="row">
            <div class="col-md-4 text-center">
                <img src="<?=  $qrcode  ?>" width="100">
            </div>
            <div class="col-md-8">
                <ul>
                    <li>Nama: <?= $nama ?></li>
                    <li>Jabatan: <?= $jabatan ?></li>
                    <li>Kode Karyawan: <?= $kode_id ?></li>
                </ul>            
            </div>
        </div>
    </div>
    <button onclick="print()" class="btn btn-md btn-danger mt-3 ml-3">cetak pdf</button>
    <script>
        function print() {
            let frame = document.getElementById('frame');
            let opt = {
                margin:       1,
                filename:     "<?= $kode_id ?>.pdf",
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
                };
                html2pdf().set(opt).from(frame).save();
        }
    </script>
<?php } ?>
