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
                <i class="fa fa-qrcode" aria-hidden="true"></i>&nbsp; Scan Barang</button>
            </div>
        </div>
    </div>
</div>    
    <div class="content-container">
        <div class="content-box-title"><label>Filter Penyimpanan Barang</label></div>
        <div class="box-body form-horizontal">
            {!! Form::open(['method' => 'post',  'id'=>'form_scpag']) !!}
            <div class="row form-group">
                <div class="col-sm-12">
                    <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Periode BPB</label>
                       
                    </div>
                    
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
                        
                    </div>
                </div>
                <div class="col-sm-12">
                    
                    
                    <div class="col-sm-3" style="margin-bottom:8px;">
                        <label>Status</label>
                        <select class="form-control" id="status">
                            <option value="A">All</option>
                            <option value="F" selected>Open</option>
                            <option value="T">Close</option>
                        </select>
                    </div>
                    
                    <div class="col-sm-3">
                        {!! Form::label('action', 'Aksi') !!}
                        <button id="display-btn" type="button" class="btn form-control btn-primary" data-toggle="tooltip" data-placement="top" title="Show Data"><i class="fa fa-search custom-icon-info"></i> &nbsp;Display</button>
                    </div>
                    <div class="col-sm-3">
                        <label>Print Supply Produksi</label>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class="content-container">
        <div class="content-box-title"><label>Tabel Penyimpanan Barang</label></div>
        <table id="table_inv" class="table table-bordered table-responsive dataTable thWarna" cellspacing="0" style="width: 100%;" >
            <thead>
                <tr>
                    <th>AKSI</th>
                    <th>KODE TRANSAKSI</th>
                    <th>KODE BARANG</th>
                    <th>TANGGAL</th>
                    <th>NO TAG</th>
                    <th>NAMA BARANG</th>
                    <th>QTY PACK</th>
                    <th>QTY STOK</th>
                    <th>TYPE</th>
                    <th>GROUP</th>
                    <th>NO BPB</th>
                    <th>KETERANGAN</th>
                </tr>
            </thead>
        </table>
    </div>
    
    
    
    
    @endsection
    