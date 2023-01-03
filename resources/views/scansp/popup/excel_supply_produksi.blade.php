@extends('dashboard.gis_mobile.layout._layout')
@section('content')
<style>
    .content-box-title{
        background-color: #2f6495;
        color: #ffffff;
    }
</style>
<section class="content">
    @include('layouts._flash')
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="content-box">
                    <div class="content-box-title"><label>Filter Export Supply Produksi</label></div>
                    <div class="box-body">
                        {!! Form::open(['url'=> route('gismobile.scansp.print_supply_produksi', ['base64_encode("#")', 'base64_encode("#")', 'base64_encode("#")', 'base64_encode("#")']), 'method'=>'post', 'class'=>'form-horizontal', 'enctype'=>"multipart/form-data"]) !!}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-3" style="margin-bottom:8px;">
                                    <label>Periode BPB</label>
                                    {!! Form::text('operiode', $operiode , ['class'=>'form-control date-picker', 'id'=>'operiode', 'name' => 'operiode', 
                                    'readonly'=>'true']) !!}
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
                                    {!! Form::label('lblsite', 'Gudang') !!}
                                    <select class="form-control select2" id='site' name="site" aria-controls="filter_site" required="true" style="width: 100%">
                                        <option value="" disabled selected="selected">--Pilihan--</option>
                                        @foreach($site as $item)
                                        @if ($item->kd_gudang == $site_user)
                                        <option value="{{$item->kd_gudang}}" selected="selected">{{$item->kd_gudang}} - {{$item->nama_gudang}}</option>
                                        @else
                                        <option value="{{$item->kd_gudang}}">{{$item->kd_gudang}} - {{$item->nama_gudang}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                
                                <div class="col-sm-3" style="margin-bottom:8px;">
                                    {!! Form::label('lblst', 'Status') !!}
                                    <select class="form-control" id="status">
                                        <option value="A">All</option>
                                        <option value="F" selected>Open</option>
                                        <option value="T">Close</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label>Pilih Export Excel</label>
                                    <select class="form-control select2" id='excel' name="excle" aria-controls="filter_group" required="true" style="width: 100%">
                                        <option value="">Export All</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Print</label>
                                    <button id="exportExcel" type="button" class="btn btn-success form-control">Export Excel</button>
                                </div>
                            </div>
                        </div>
                        
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script type="text/javascript">
    
    
    $(".select2").select2();
    
    $("#exportExcel").on("click", function(){
        var tglawal = $('#tglawal').val();
        var tglakhir = $('#tglakhir').val();
        var site = $('#site').val();
        var status = $('#status').val();
        var url = '{{ route("gismobile.scansp.print_supply_produksi", ['param1', 'param2','param3','param4']) }}'
        url = url.replace("param1", window.btoa(tglawal))
        url = url.replace("param2", window.btoa(tglakhir))
        url = url.replace("param3", window.btoa(site))
        url = url.replace("param4", window.btoa(status))
        window.location = url;
    })
</script>
@endsection