{{-- halaman scan --}}
<div id="scanbarcode" style="display: none;">
    @if (session()->has('flash_notification.message_scan'))
    <div class="alert alert-dismissible alert-{{ session()->get('flash_notification.level') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        {!! session()->get('flash_notification.message_scan') !!}
    </div>
    @endif
    <div class="box-body with-border">
        <div class="col-sm-12 animated zoomIn">
            <div class="row">
                {!! Form::hidden('no_scan', null, ['id' => 'no_scan']) !!}
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
{{-- <b>Last App Rev</b> 22/03/2021 | <b>Version</b> 1.0 --}}

