<?php echo $__env->make('layouts._menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('styles'); ?>
<style>
    .btn>.btn-add{
        cursor: pointer;
    }
    #add-btn {
        background-color: #4074e6;
        border-color: #101ee2;
        color: #ffffff;
    }
    #add-btn:hover {
        background-color: #123786;
        color: #ffffff;
    }
    .content-box-title{
        background-color: #2f6495;
        color: #ffffff;
    }
    
    .dataTables_scrollHeadInner {   
        padding:0% ! important
    }
    .modal-backdrop{
        display: none;
    }
    .nowrap{
        white-space: nowrap;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('layouts._flash', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<div class="content-container">
    <div class="box-header with-border">
        <div class="col-lg-2 col-sm-3 col-xs-12 pull-right">
            <button id="add-btn" type="button"  data-toggle="modal" data-target="#modal-tambah" class="btn form-control btn-primary btn-add" title="Klik untuk Scan">
                <i class="fa fa-qrcode" aria-hidden="true"></i>&nbsp; Scan   Data</button>
            </div>
        </div>
    </div>
</div>   

<div class="content-container">
        <div class="content-box-title"><label>Filter Barang Keluar</label></div>
            <?php echo Form::open(['method' => 'POST', 'id'=>'form_scpag']); ?>

        <div class="box-body form-horizontal">
            <div class="row form-group">
                <div class="col-sm-12">
                    
                <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Periode Awal</label>
                        <?php echo Form::date('tglawal', \Carbon\Carbon::now()->firstOfMonth(), ['class'=>'form-control','id' => 'tglawal']); ?>

                        <?php echo Form::hidden('tahun_temp', \Carbon\Carbon::now()->format('Y'), ['id'=>'tahun_temp', 'name'=>'tahun_temp']); ?>

                    </div>
                    
                    <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Periode Akhir</label>
                        <?php echo Form::date('tglakhir', \Carbon\Carbon::now(), ['class'=>'form-control', 'id' => 'tglakhir']); ?>

                        <?php echo Form::hidden('bulan_temp', \Carbon\Carbon::now()->format('m'), ['id'=>'bulan_temp', 'name'=>'bulan_temp']); ?>

                    </div>

                    <div class="col-sm-3">
                        <label>Gudang</label>
                        <select class="form-control select2" id='id_gudang' name="id_gudang" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_gudang); ?>"><?php echo e($item->id_gudang); ?> - <?php echo e($item->nama_gudang); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label>Produk</label>
                        <select class="form-control select2" id='produk' name="produk" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            <?php $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_produk); ?>"><?php echo e($item->id_produk); ?> - <?php echo e($item->nama_produk); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>

                    
                </div>
                <div class="col-sm-12">
                <div class="col-sm-3">
                        <label>Customer</label>
                        <select class="form-control select2" id='id_customer' name="id_customer" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_customer); ?>"><?php echo e($item->id_customer); ?> - <?php echo e($item->nama_customer); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label('action', 'Aksi'); ?>

                        <button id="display-btn" type="button" class="btn form-control btn-primary" data-toggle="tooltip" data-placement="top" title="Show Data"><i class="fa fa-search custom-icon-info"></i> &nbsp;Display</button>
                    </div>
                    <div class="col-sm-3">
                    <?php echo Form::label('print', 'Print'); ?>

                    <button class="btn btn-success form-control" id="btn_excel" type="button" style="margin: 0 0 10px 10px;">
					<i class="fa fa-print"></i> Print Excel
                    </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-container">
        <div class="content-box-title"><label>Tabel Barang Masuk</label></div>
        <table id="table_inv" class="table table-bordered table-responsive dataTable thWarna" cellspacing="0" style="width: 100%;" >
            <thead>
                <tr>
                    <th>No Transaksi</th>
                    <th>No Kirim</th>
                    <th>Tanggal Kirim</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Nama Gudang</th>
                    <th>Nama Customer</th>
                    <th>Qty Kirim</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <?php $__env->stopSection(); ?>
    <?php echo $__env->make('keluar._modal-keluar-tambah', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('masuk._modal-produk-tambah', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php $__env->startSection('scripts'); ?>

<?php echo Form::close(); ?>

    <script>
        
        $(document).ready(function() {
            $('#display-btn').trigger("click");
        });
        
        
        $(document).on('click', '.btn-hapus',function(){
            let id_customer = $('#id_customer').val()
            valHapus(id_customer)
            console.log(id_customer);
        })
        
        var url = '<?php echo e(route("gismobile.keluar.dt", [base64_encode(\Carbon\Carbon::now()->format("Y-m-d")),\
        base64_encode(\Carbon\Carbon::now()->format("Y-m-d")), base64_encode("#"), base64_encode("#"), base64_encode("#")])); ?>'

        var table = $('#table_inv').DataTable({
            processing: true, 
            "scrollX": true,
            "columnDefs": [ {
                "targets": [0],
                "orderable": false
            } ],
            "oLanguage": {
                'sProcessing': '<div id="loading-screen"style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102, 0.8); z-index: 30001;"><div id="loading-text" style="margin-top: 40vh !important;"><div style="padding-left: 7px;"><div class="loader"></div></div><span style="font-weight: 300;">Memproses...</span></div></div>'
            }, 
            searching: true,
            "order": [[ 2, "desc" ]],
            "aLengthMenu": [[5, 10, 25, 50, 75, 100,], [5, 10, 25, 50, 75, 100]],
            ajax: {
                url: url,
            },
            "serverSide": false,
            "deferRender": true,
            columns: [
            {data: 'kd_trans', name:'kd_trans'},
            {data: 'no_kirim', name:'no_kirim'},
            {data: 'tgl_kirim', name:'tgl_kirim'},
            {data: 'no_produk', name:'no_produk'},   
            {data: 'nama_produk', name:'nama_produk'},   
            {data: 'nama_gudang', name:'nama_gudang'},   
            {data: 'nama_customer', name:'nama_customer'},   
            {data: 'qty_kirim', name:'qty_kirim'},   
            {data: 'action', name:'action'},   
            ]
        });
        
        $("#display-btn").on("click", function(){
                var tglawal = $('#tglawal').val();
                var tglakhir = $('#tglakhir').val();
                var id_gudang = $('#id_gudang').val();
                var produk = $('#produk').val();
                var id_customer = $('#id_customer').val();
                var url1 = "<?php echo e(route('gismobile.keluar.dt', ['param1','param2' ,'param3','param4','param5'])); ?>"
                url1 = url1.replace("param1", window.btoa(tglawal))
                url1 = url1.replace("param2", window.btoa(tglakhir))
                url1 = url1.replace("param3", window.btoa(id_gudang))
                url1 = url1.replace("param4", window.btoa(produk))
                url1 = url1.replace("param5", window.btoa(id_customer))
                table.ajax.url(url1).load();
        });
        
        $('#add-btn').on('click', function() {
            var myHeader = "<b>Tambah Data Inventory</b>";
            $("#modalLabel").html(myHeader);
            $("#modal-tambah").trigger("click")
            reset_all()
        })

        //**** Button Edit ******
        $(document).on("click", ".btn-edit", function(){
            var myHeader = "<b>Edit Scan Out Material untuk Supply Produksi</b>";
            $("#modalLabel").html(myHeader);
            
            showLoading()
        })
        function edit(a, b) {
            $('#modal-tambah').modal('show')
            reset_all()
            $('#kd_trans').val(a)
            $('#no_kirim').val(b)
            $("#kd_trans").trigger("change")
            hideLoading()
        }
        //*************

        //**** Button Hapus *****
        $(document).on("click", ".btn-delete", function(){
            var no_kirim = $(this).attr("no_kirim")
            
        })
        function hapus(no_kirim){
            var urldel = "<?php echo e(route('gismobile.keluar.delete', ['param1'])); ?>"
            urldel = urldel.replace('param1', window.btoa(no_kirim))
            token = window.Laravel.csrfToken
            swal({
                title: 'Yakin?',
                text: 'Anda akan menghapus Data ini.',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i>Ya, Hapus',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i>Kembali',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: false,
            }).then(function () {
                $.ajax({
                    url : urldel,
                    type : 'get',
                    dataType : 'json',
                    data : {
                        no_kirim : no_kirim,
                        _token : token,
                    },
                    success: function(_response){
                        if (_response.indctr == "1"){
                            swal("Sukses", _response.msg, "success")
                            table.ajax.reload();
                            reset_all()
                            $('#modal-tambah').modal('hide');
                        } else if (_response.indctr == "2"){
                            swal("Perhatian", _response.msg, "warning")
                        } else {
                            swal("Gagal", _response.msg, "error")
                        }
                    },
                    error: function(_response){
                        swal(
                        'Terjadi kesalahan',
                        'Segera hubungi Admin!',
                        'info'
                        )
                    }
                });
            }, )
        }

        $('#close_modal').on('click', function() {
        reset_all()
    })

    $("#no_inv").click(function(){
        popupInv();
    });
    $("#no_inv-btn").click(function(){
        popupInv();
    });

    function popupInv() {
        var myHeader = "<p>List Kode Produk</p>";
        $("#modalTwhsInv").html(myHeader);
        var url = '<?php echo e(route("gismobile.masuk.modal")); ?>'
        
        var tblinv = $('#tbl-inv').DataTable({
            processing: true, 
            serverSide: false,
            "pagingType": "numbers",
            ajax: url,
            "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
            "order": [[0, 'desc']],
            columns: [   
            {data: 'id_produk'},
            {data: 'nama_produk'},
            {data: 'no_produk'},                                   
            ],
            "bDestroy": true,
            "initComplete": function(settings, json) {
                $('#tbl-inv tbody').on( 'click', 'tr', function () {
                    var dataArr = [];
                    var rows = $(this);
                    var rowData = tblinv.rows(rows).data();
                    $.each($(rowData),function(key,value){
                        console.log(value)
                        $("#id_produk").val(value["id_produk"])
                        $("#nama_produk").val(value["nama_produk"])
                        $("#no_produk").val(value["no_produk"])
                        $("#id_produk").trigger('change')     
                        $('#modalInv').modal('hide');
                    });
                });
            },
        });
    }
    

    $("#kd_trans").change(function(){
            gen_trans();
        });
        
        function gen_trans() {
            //function generate barang satu satu lewat onchange
            var kd_trans = $("#kd_trans").val();
            var no_kirim = $("#no_kirim").val();
            console.log(no_kirim)
            url = '<?php echo e(route('gismobile.keluar.gen_trans')); ?>'
            token = window.Laravel.csrfToken
            
            showLoading()
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'json',
                data : {
                    kd_trans : kd_trans,
                    no_kirim : no_kirim,
                    _token : token,
                },
                success: function(_response) {
                    if (_response.indctr == '1') {
                        console.log(_response)
                        _response.inv.forEach(myFunction);
                        function myFunction(item,index,change){
                            $("#kd_trans").val(item.kd_trans)
                            // $("#tgl_kirim").val(ambilTanggal(item.tgl_kirim))
                            $("#gudang").val(item.id_gudang).trigger("change")
                            // $("#id_produk").val(item.id_produk)
                            $("#nama_produk").val(item.nama_produk)
                            $("#no_produk").val(item.no_produk)
                            $("#nama_barang").val(item.nama_barang)
                            $("#customer").val(item.id_cust).trigger("change")
                            $("#qty").val(item.qty)
                            $("#qty_kirim").val(item.qty_kirim)
                        }
                    } else if (_response.indctr == '2') {
                        console.log(_response)
                        _response.inv.forEach(myFunction);
                        function myFunction(item,index,change){
                            $("#kd_trans").val(item.kd_trans)
                            $("#tgl_kirim").val(ambilTanggal(item.tgl_kirim))
                            $("#gudang").val(item.id_gudang).trigger("change")
                            // $("#id_produk").val(item.id_produk)
                            $("#nama_produk").val(item.nama_produk)
                            $("#no_produk").val(item.no_produk)
                            $("#nama_barang").val(item.nama_barang)
                            $("#customer").val(item.id_cust).trigger("change")
                            $("#qty_kirim").val(item.qty_kirim)
                            gen_qty()
                    } 
                }else if (_response.indctr == '0') {
                        console.log(_response)
                    }
                    hideLoading()
                },
                error: function(_response) {
                    console.log(_response)
                }
            })
        }

        function gen_qty() {
            //function generate barang satu satu lewat onchange
            var kd_trans = $("#kd_trans").val();
            console.log(no_kirim)
            url = '<?php echo e(route('gismobile.keluar.gen_qty')); ?>'
            token = window.Laravel.csrfToken
            
            showLoading()
            $.ajax({
                url : url,
                type : 'GET',
                dataType : 'json',
                data : {
                    kd_trans : kd_trans,
                    _token : token,
                },
                success: function(_response) {
                    if (_response.indctr == '1') {
                        console.log(_response)
                        _response.inv.forEach(myFunction);
                        function myFunction(item,index,change){
                            $("#qty").val(item.qty)
                        }
                    } else if (_response.indctr == '0') {
                        console.log(_response)
                    }
                    hideLoading()
                },
                error: function(_response) {
                    console.log(_response)
                }
            })
        }
        function ambilTanggal(tanggal){
            //function mengambil tanggal
            var tanggal = new Date(tanggal);
            var dd = tanggal.getDate(); //ambil tanggal
            var MM = tanggal.getMonth(); //ambil bulan
            var yyyy = tanggal.getFullYear(); //ambil tahun
            var tanggalnow= yyyy+ "-" +((MM+1) < 10 ? '0'+(MM+1) : '') + "-" +((dd) < 10 ? '0'+dd : dd) ;
            
            return tanggalnow;
        }

    //*********** Clear Button **************
    $('#cl-btn').on('click', function() {
        reset_all()
    })
    function reset_all(){
        $("#kd_trans").val('')
        $("#tgl_produksi").val('<?php echo e(\Carbon\Carbon::now()->format("Y-m-d")); ?>')
        $("#gudang").val('ALL').trigger("change");
        $("#id_produk").val('')
        $("#nama_produk").val('')
        $("#no_produk").val('')
        $("#customer").val('ALL').trigger("change");
        $("#qty").val('')
        $("#qty_kirim").val('')
    }
    //***************************************

    //*************
    $('#sub-btn').on('click', function() {
            inputData();
        });
        function inputData(){
            swal({
                title: 'Yakin?',
                text: 'Anda akan menyimpan Data Customer ini. Pastikan Data yang di input benar.',
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Ya!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> Kembali',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: false,
            }).then(function () {
                showLoading()
                $.ajax({
                    url: "<?php echo e(route('gismobile.keluar.store')); ?>",
                    type: 'POST',
                    data: $('#form_scpag').serialize(),
                    dataType: 'json',
                    cache: false,
                    success: function(response_){
                        if(response_.nummer == '1'){
                            swal("Sukses", response_.mes, "success")
                            table.ajax.reload();
                            reset_all();
                        }else if(response_.nummer == '2'){
                            swal("Data tidak dapat di ubah, QTY Kirim lebih dari QTY", response_.mes, "warning")
                        }else if(response_.nummer == '3'){
                            swal("Perhatian", "Tanggal dan Periode tidak sama", "info", response_.mes, "warning")
                        }else if (response_.nummer == '0') {
                            swal("Gagal menyimpan data", response_.mes, "error")
                        }else{
                            swal('Perhatikan Inputan Anda', response_.mes , 'info')
                        }
                        hideLoading()
                    },
                    error: function(xhr, textStatus, errorThrown){
                        swal(
                        'Terjadi kesalahan',
                        'Error: '+xhr.status+'<br>'+errorThrown+'<br> Status: '+xhr.responseText,
                        'info'
                        )
                    }
                });
            }) 
        }
        //*************
        
         //=============================POPUP MODAL=================================
         var video = document.createElement("video")
        var canvasElement = document.getElementById("canvas")
        var canvas = canvasElement.getContext("2d")
        var loadingMessage = document.getElementById("loadingMessage")
        var outputContainer = document.getElementById("output")
        var outputMessage = document.getElementById("outputMessage")
        var outputData = document.getElementById("outputData")

        function back_timer(){
            swal({
                title: 'Info!',
                text: 'Tekan panah diatas untuk kembali ke form.',
                type: 'info',
                timer: 2000,
                showCancelButton: false,
                showConfirmButton: false,
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: false,
            });
        }

        $('#scan-btn').on('click', function(){
            
                back_timer()
                $('#formscan').css('display', 'none')
                $('#modfoot').css('display', 'none')
                $('#scanbarcode').css('display', 'inline')
                $('#btn-back-scan').css('display', 'inline')
                webCam()
        })
        $('#btn-back-scan').on('click', function(){
            $('#formscan').css('display', 'inline')
            $('#modfoot').css('display', 'block')
            $('#scanbarcode').css('display', 'none')
            $('#btn-back-scan').css('display', 'none')
            vidOff()
        })
        function webCam() {
            $('#pc-tablet-tv').addClass('animated zoomOut')
            setTimeout(function() {
                $('#pc-tablet-tv').css('display', 'none')
                
                function drawLine(begin, end, color) {
                    canvas.beginPath()
                    canvas.moveTo(begin.x, begin.y)
                    canvas.lineTo(end.x, end.y)
                    canvas.lineWidth = 4
                    canvas.strokeStyle = color
                    canvas.stroke()
                }
                
                navigator.mediaDevices.getUserMedia({ video: { facingMode: "environment" } }).then(function(stream) {
                    video.srcObject = stream
                    video.setAttribute("playsinline", true) // required to tell iOS safari we don't want fullscreen
                    video.play()
                    console.log("Vid On");
                    requestAnimationFrame(tick)
                })
                
                function tick() {
                    loadingMessage.innerText = "⌛ Loading video..."
                    if (video.readyState === video.HAVE_ENOUGH_DATA) {
                        loadingMessage.hidden = true
                        canvasElement.hidden = false
                        outputContainer.hidden = false
                        
                        canvasElement.height = video.videoHeight
                        canvasElement.width = video.videoWidth
                        canvas.drawImage(video, 0, 0, canvasElement.width, canvasElement.height)
                        var imageData = canvas.getImageData(0, 0, canvasElement.width, canvasElement.height)
                        var code = jsQR(imageData.data, imageData.width, imageData.height, {
                            inversionAttempts: "dontInvert",
                        })
                        if (code) {
                            drawLine(code.location.topLeftCorner, code.location.topRightCorner, "#FF3B58")
                            drawLine(code.location.topRightCorner, code.location.bottomRightCorner, "#FF3B58")
                            drawLine(code.location.bottomRightCorner, code.location.bottomLeftCorner, "#FF3B58")
                            drawLine(code.location.bottomLeftCorner, code.location.topLeftCorner, "#FF3B58")
                            outputMessage.hidden = true
                            outputData.parentElement.hidden = false
                            outputData.innerText = code.data
                            $('#no_scan').val(code.data)
                            panggilData()
                            vidOff()
                        } else {
                            outputMessage.hidden = false
                            outputData.parentElement.hidden = true
                        }
                    }
                    if (code) { } else { requestAnimationFrame(tick) }
                    
                }
            }, 900)
        }
        function panggilData(){
            $('#formscan').css('display', 'inline')
            $('#modfoot').css('display', 'block')
            $('#scanbarcode').css('display', 'none')
            $('#btn-back-scan').css('display', 'none')
            $('#kd_trans').val($('#no_scan').val())
            gen_trans(0)
        }
        function vidOff() {
            const mediaStream = video.srcObject;
            
            const tracks = mediaStream.getTracks();
            
            tracks[0].stop();
            
            tracks.forEach(track => track.stop())
            console.log("Vid Off");
        }
        //*************

        $("#btn_excel").on("click", function(){
            print_excel()
        })

        function print_excel() {
            var tglawal = $('#tglawal').val();
            var tglakhir = $('#tglakhir').val();
            var id_gudang = $('#id_gudang').val();
            var produk = $('#produk').val();
            var id_customer = $('#id_customer').val();
            var url = '<?php echo e(route("gismobile.keluar.print", ['param1', 'param2', 'param3', 'param4', 'param5'])); ?>'
            url = url.replace('param1', window.btoa(tglawal));
            url = url.replace('param2', window.btoa(tglakhir));
            url = url.replace('param3', window.btoa(id_gudang));
            url = url.replace('param4', window.btoa(produk));
            url = url.replace('param5', window.btoa(id_customer));
            window.location = url;
        }
    </script>
    <?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>