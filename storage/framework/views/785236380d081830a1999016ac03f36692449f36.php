
<div id="scanbarcode" style="display: none;">
    <?php if(session()->has('flash_notification.message_scan')): ?>
    <div class="alert alert-dismissible alert-<?php echo e(session()->get('flash_notification.level')); ?>">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo session()->get('flash_notification.message_scan'); ?>

    </div>
    <?php endif; ?>
    <div class="box-body with-border">
        <div class="col-sm-12 animated zoomIn">
            <div class="row">
                <?php echo Form::hidden('no_scan', null, ['id' => 'no_scan']); ?>

                <center>
                    <div id="loadingMessage">
                        🎥 Tidak dapat mengakses video stream (pastikan url yang diakses localhost atau memiliki sertifikat <strong>HTTPS</strong>)
                    </div>
                    <div id="output" hidden>
                        <div id="outputMessage">Tidak ada QR Code Terdeteksi</div>
                        <div hidden><b>No. Tag:</b> <span id="outputData"></span></div>
                    </div>
                    <canvas id="canvas" hidden></canvas>
                </center>
            </div>
        </div>
    </div>
</div>


