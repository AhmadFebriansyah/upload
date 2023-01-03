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

{!! Form::open(['route' => 'gismobile.customer.store', 'method' => 'post',  'id'=>'form_scpag']) !!}
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
        <div class="content-box-title"><label>Tabel Customer</label></div>
        <table id="table_inv" class="table table-bordered table-responsive dataTable thWarna" cellspacing="0" style="width: 100%;" >
            <thead>
                <tr>
                    <th>Kode Customer</th>
                    <th>Nama Customer</th>
                    <th>Alamat</th>
                    <th>No. Telpon</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    @endsection

    {!! Form::close() !!}
    @include('customer._modal-customer-tambah')
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
        
        var url = '{{ route("gismobile.customer.dt") }}'
        
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
            {data: 'id_customer', name:'id_customer'},
            {data: 'nama_customer', name:'nama_customer'},   
            {data: 'alamat_customer', name:'alamat_customer'},   
            {data: 'no_telp', name:'no_telp'},   
            {data: 'action', name:'action'},   
            ]
        });
        
        $("#display-btn").on("click", function(){
                var url1 = "{{ route('gismobile.customer.dt') }}"
                table.ajax.url(url1).load();
        });
        
        $('#add-btn').on('click', function() {
            var myHeader = "<b>Tambah Data Customer</b>";
            $("#modalLabel").html(myHeader);
            $("#modal-tambah").trigger("click")
            reset_all()
        })

         //**** Button Edit ******
         $(document).on("click", ".btn-edit", function(){
            var myHeader = "<b>Edit Customer</b>";
            $("#modalLabel").html(myHeader);
            
        })

        function edit(a,b,c,d) {
            $('#modal-tambah').modal('show')
            reset_all()
            $('#id_customer').val(a)
            $('#nama_customer').val(b)
            $('#alamat_customer').val(c)
            $('#no_telp').val(d)
            $("#id_customer").trigger("change")
            hideLoading()
        }
        //*************

        //**** Button Hapus *****
        $(document).on("click", ".btn-delete", function(){
            var id_customer = $(this).attr("id_customer")
            
        })
        function hapus(id_customer){
            var urldel = "{{ route('gismobile.customer.delete', ['param1']) }}"
            urldel = urldel.replace('param1', window.btoa(id_customer))
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
                        id_customer : id_customer,
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
        //*************

        $('#close_modal').on('click', function() {
            reset_all()
        })

        //**** Clear Button *****
        $('#cl-btn').on('click', function() {
            reset_all()
        })
        function reset_all(){
            $("#id_customer").val('')
            $("#nama_customer").val('')
            $("#alamat_customer").val('')
            $("#no_telp").val('')
        }
        //*************
        $('#sub-btn').on('click', function() {
            inputData();
        });
        function inputData(){
            var id_customer = $("#id_customer").val();
            var nama_customer = $("#nama_customer").val();
            var alamat_customer = $("#alamat_customer").val();
            var no_telp = $("#no_telp").val();
            token = window.Laravel.csrfToken
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
                    url: "{{ route('gismobile.customer.store') }}",
                    type: 'POST',
                    data: $('#form_scpag').serialize(),
                    data : {
                        id_customer : id_customer,
                        nama_customer : nama_customer,
                        alamat_customer : alamat_customer,
                        no_telp : no_telp,
                    _token : token,
                    },
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
    </script>
    @endsection
    