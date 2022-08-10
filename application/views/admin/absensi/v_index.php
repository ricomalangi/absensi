<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            Absensi
        </div>
        <div class="card-body">
            <div id="sourceSelectPanel" style="display:none; margin-bottom:5px;">
                <label for="sourceSelect" class="mt-3">Change video source:</label>
                <select id="sourceSelect" class="form-control" style="max-width:400px"></select>
            </div>
            <div class="text-center">
                <video id="webcam-preview" width="400" height="400"></video>
            </div>
            <form action="<?= base_url('scan/cekId') ?>" method="POST" id="button">
                <input type="hidden" name="kode_id_karyawan" id="result">
            </form>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/zxing.min.js') ?>"></script>
<script type="text/javascript">
   window.addEventListener('load', function () {
    let selectedDeviceId;
    let audio = new Audio("assets/audio/beep.mp3");
    const codeReader = new ZXing.BrowserQRCodeReader()
    console.log('ZXing code reader initialized')
    codeReader.getVideoInputDevices()
    .then((videoInputDevices) => {
        const sourceSelect = document.getElementById('sourceSelect')
        selectedDeviceId = videoInputDevices[0].deviceId
        if (videoInputDevices.length >= 1) {
            videoInputDevices.forEach((element) => {
                const sourceOption = document.createElement('option')
                sourceOption.text = element.label
                sourceOption.value = element.deviceId
                sourceSelect.appendChild(sourceOption)
            })
            sourceSelect.onchange = () => {
                selectedDeviceId = sourceSelect.value;
            };
            const sourceSelectPanel = document.getElementById('sourceSelectPanel')
            sourceSelectPanel.style.display = 'block'
        }
        codeReader.decodeFromInputVideoDevice(selectedDeviceId, 'webcam-preview').then((result) => {
            document.getElementById('result').value = result.text
            if(result != null){
                audio.play();
            }
            $('#button').submit();
        }).catch((err) => {
            console.error(err)
            document.getElementById('result').textContent = err
        })
        console.log(`Started continous decode from camera with id ${selectedDeviceId}`)
    })
    .catch((err) => {
        console.error(err)
    })
})
</script>
<?php if($this->session->flashdata('alert') == TRUE):
    $result = $this->session->flashdata('alert');
?>
<script>
    Swal.fire({title: '<?= $result['title'] ?>',text: '<?= $result['message'] ?>',icon: '<?= $result['icon'] ?>',confirmButtonText: 'OK'})
</script>
<?php endif ?>
