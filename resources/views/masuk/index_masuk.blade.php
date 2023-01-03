@extends('layouts.app')
@include('layouts._menu')
@section('styles')
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
@endsection

@section('content')
@include('layouts._flash')

<div class="content-container">
    <div class="box-header with-border">
        <div class="col-lg-2 col-sm-3 col-xs-12 pull-right">
            <button id="add-btn" type="button"  data-toggle="modal" data-target="#modal-tambah" class="btn form-control btn-primary btn-add" title="Klik untuk Scan">
                <i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Tambah Data</button>
            </div>
        </div>
    </div>
</div>   

<div class="content-container">
        <div class="content-box-title"><label>Filter Material Supply Produksi</label></div>
            {!! Form::open(['method' => 'POST', 'id'=>'form_scpag']) !!}
        <div class="box-body form-horizontal">
            <div class="row form-group">
                <div class="col-sm-12">
                    
                <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Periode Awal</label>
                        {!! Form::date('tglawal', \Carbon\Carbon::now()->firstOfMonth(), ['class'=>'form-control','id' => 'tglawal']) !!}
                        {!! Form::hidden('tahun_temp', \Carbon\Carbon::now()->format('Y'), ['id'=>'tahun_temp', 'name'=>'tahun_temp']) !!}
                    </div>
                    
                    <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Periode Akhir</label>
                        {!! Form::date('tglakhir', \Carbon\Carbon::now(), ['class'=>'form-control', 'id' => 'tglakhir']) !!}
                        {!! Form::hidden('bulan_temp', \Carbon\Carbon::now()->format('m'), ['id'=>'bulan_temp', 'name'=>'bulan_temp']) !!}
                    </div>

                    <div class="col-sm-3">
                        <label>Gudang</label>
                        <select class="form-control select2" id='id_gudang' name="id_gudang" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            @foreach($gudang as $item)
                            <option value="{{$item->id_gudang}}">{{$item->id_gudang}} - {{$item->nama_gudang}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3">
                        <label>Produk</label>
                        <select class="form-control select2" id='produk' name="produk" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            @foreach($produk as $item)
                            <option value="{{$item->id_produk}}">{{$item->id_produk}} - {{$item->nama_produk}}</option>
                            @endforeach
                        </select>
                    </div>

                    
                </div>
                <div class="col-sm-12">
                <div class="col-sm-3">
                        <label>Customer</label>
                        <select class="form-control select2" id='id_customer' name="id_customer" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            @foreach($customer as $item)
                            <option value="{{$item->id_customer}}">{{$item->id_customer}} - {{$item->nama_customer}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3">
                        {!! Form::label('action', 'Aksi') !!}
                        <button id="display-btn" type="button" class="btn form-control btn-primary" data-toggle="tooltip" data-placement="top" title="Show Data"><i class="fa fa-search custom-icon-info"></i> &nbsp;Display</button>
                    </div>
                    <div class="col-sm-3">
                    {!! Form::label('print', 'Print') !!}
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
                    <th>Tanggal Produksi</th>
                    <th>Part Number</th>
                    <th>Part Name</th>
                    <th>Nama Gudang</th>
                    <th>Nama Customer</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
{!! Form::close() !!}
    @endsection
    @include('masuk._modal-masuk-tambah')
    @include('masuk._modal-produk-tambah')
    @section('scripts')

    <script>
        
        $(document).ready(function() {
            $('#display-btn').trigger("click");
        });
        
        
        $(document).on('click', '.btn-hapus',function(){
            let id_customer = $('#id_customer').val()
            valHapus(id_customer)
            console.log(id_customer);
        })
        
        var url = '{{ route("gismobile.masuk.dt", [base64_encode(\Carbon\Carbon::now()->format("Y-m-d")),\
        base64_encode(\Carbon\Carbon::now()->format("Y-m-d")), base64_encode("#"), base64_encode("#"), base64_encode("#")]) }}'

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
            {data: 'tgl_produksi', name:'tgl_produksi'},
            {data: 'no_produk', name:'no_produk'},   
            {data: 'nama_produk', name:'nama_produk'},   
            {data: 'nama_gudang', name:'nama_gudang'},   
            {data: 'nama_customer', name:'nama_customer'},   
            {data: 'qty', name:'qty'},   
            {data: 'action', name:'action'},   
            ]
        });
        
        $("#display-btn").on("click", function(){
                var tglawal = $('#tglawal').val();
                var tglakhir = $('#tglakhir').val();
                var id_gudang = $('#id_gudang').val();
                var produk = $('#produk').val();
                var id_customer = $('#id_customer').val();
                var url1 = "{{ route('gismobile.masuk.dt', ['param1','param2' ,'param3','param4','param5']) }}"
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
        function edit(a) {
            $('#modal-tambah').modal('show')
            reset_all()
            $('#kd_trans').val(a)
            $("#kd_trans").trigger("change")
            hideLoading()
        }
        //*************

        //**** Button Hapus *****
        $(document).on("click", ".btn-delete", function(){
            var kd_trans = $(this).attr("kd_trans")
            
        })
        function hapus(kd_trans){
            var urldel = "{{ route('gismobile.masuk.delete', ['param1']) }}"
            urldel = urldel.replace('param1', window.btoa(kd_trans))
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
                        kd_trans : kd_trans,
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
        var url = '{{ route("gismobile.masuk.modal") }}'
        
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
            console.log(kd_trans)
            url = '{{ route('gismobile.masuk.gen_trans') }}'
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
                            $("#kd_trans").val(item.kd_trans)
                            $("#tgl_produksi").val(ambilTanggal(item.tgl_produksi))
                            $("#gudang").val(item.id_gudang).trigger("change")
                            $("#id_produk").val(item.id_produk)
                            $("#nama_produk").val(item.nama_produk)
                            $("#no_produk").val(item.no_produk)
                            $("#nama_barang").val(item.nama_barang)
                            $("#customer").val(item.id_cust).trigger("change")
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
        $("#tgl_produksi").val('{{ \Carbon\Carbon::now()->format("Y-m-d") }}')
        $("#gudang").val('ALL').trigger("change");
        $("#id_produk").val('')
        $("#nama_produk").val('')
        $("#no_produk").val('')
        $("#customer").val('ALL').trigger("change");
        $("#qty").val('')
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
                    url: "{{ route('gismobile.masuk.store') }}",
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
                            swal("Data tidak dapat di edit, QTY ACT dan QTY LHP tidak ada", response_.mes, "warning")
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
        
        $("#btn_excel").on("click", function(){
            print_excel()
            
        })
        
        function print_excel() {
            var tglawal = $('#tglawal').val();
            var tglakhir = $('#tglakhir').val();
            var id_gudang = $('#id_gudang').val();
            var produk = $('#produk').val();
            var id_customer = $('#id_customer').val();
            var url = '{{ route("gismobile.masuk.print", ['param1', 'param2', 'param3', 'param4', 'param5']) }}'
            url = url.replace('param1', window.btoa(tglawal));
            url = url.replace('param2', window.btoa(tglakhir));
            url = url.replace('param3', window.btoa(id_gudang));
            url = url.replace('param4', window.btoa(produk));
            url = url.replace('param5', window.btoa(id_customer));
            window.location = url;
        }

        $(document).on("click", ".btn-pdf", function(){
            var myHeader = "<b>Edit Scan Out Material untuk Supply Produksi</b>";
            $("#modalLabel").html(myHeader);
            
        })
        function print_pdf(kd_trans) {
            console.log(kd_trans);
            var url = '{{ route("gismobile.masuk.pdf", ['param1']) }}'
            url = url.replace('param1', window.btoa(kd_trans));
            window.location = url;
        }

    </script>
    @endsection
    