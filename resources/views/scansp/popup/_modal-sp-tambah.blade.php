<div id="modal-tambah" class="modal" role="dialog" style="z-index: 99;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="margin-right: 0px;">
                <button type="button" id="close_modal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <button type="button" class="btn btn-default btn-sm " id="btn-back-scan" style="color: rgb(43, 43, 43); display: none;">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <span id='modalLabel' style="font-size: 12px; color: #4400ff;">Label</span>
            </div>
            <div class="modal-body">
                {{-- halaman input --}}
                <div id="formscan">

                    {{-- PERIODE --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblperiode', 'PERIODE BPB') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('operiode', $operiode , ['class'=>'form-control date-picker', 'id'=>'operiode', 'name' => 'operiode', 'readonly'=>'true']) !!}
                        </div>           
                    </div>

                     {{-- no transaksi --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblno_tra', 'NO TRANSAKSI') !!}
                        </div>
                        <div class="col-sm-9" >
                                {{-- no trans--}}
                                {!! Form::text('notrak', null, ['class'=>'form-control','placeholder' => 'No. Transaksi',  
                                'id' => 'notrak', 'name' => 'notrak', 'readonly'=>'true', 'data-toggle'=>"modal"]) !!}
                            
                            {!! Form::hidden('notrak_temp', null, ['id'=>'notrak_temp', 'name'=>'notrak_temp']) !!}
                        </div>
                    </div>

                    {{-- tanggal --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lbltgl', 'TANGGAL') !!}
                        </div>
                        <div class="col-sm-9">
                            <input type="date" name="tgl" id="tgl" value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" class="form-control">
                        </div>
                    </div>

                    {{-- LINE --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblline', 'LINE') !!}
                        </div>
                        <div class="col-sm-9">
                            <select class="form-control select2" id='mline_code' name="mline_code" aria-controls="filter_site" required="true" style="width: 100%">
                                <option value="" disabled selected="selected">--Pilihan--</option>
                                @foreach($line as $item)
                                @if ($item->mline_code)
                                <option value="{{$item->mline_code}}" selected="selected">{{$item->mline_code}} - {{$item->mline_desc}}</option>
                                @else
                                <option value="{{$item->mline_code}}">{{$item->mline_code}} - {{$item->mline_desc}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    {{-- no tag --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblno_tag', 'NO TAG') !!}
                        </div>
                        <div class="col-sm-9">
                            <div class="input-group">
                                {{-- popup --}}
                                {!! Form::text('no_tag', null, ['class'=>'form-control','placeholder' => 'No. Tag',  'id' => 'no_tag', 
                                'name' => 'no_tag', 'data-toggle'=>"modal", 'data-target'=>"#modalTag", 'readonly'=>'true']) !!}
                                {{-- scan --}}
                                <span class="input-group-btn">
                                    <button id="scan-btn" type="button" class="btn btn-success custom-icon-success">
                                        <span class="fa fa-camera"></span>
                                    </button>
                                </span>
                            </div>
                        </div>           
                    </div>
                    
                   
                    
                    {{-- kode barang --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblkode_brg', 'KODE BARANG') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('kode_brg', null, ['class'=>'form-control','placeholder' => 'Kode Barang', 'name' => 'kode_brg', 
                            'id' => 'kode_brg', 'readonly'=>'true']) !!}
                        </div>           
                    </div>
                    
                    {{-- nama barang --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblnama_barang', 'NAMA BARANG') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('nama_barang', null, ['class'=>'form-control','placeholder' => 'Nama Barang', 'name' => 'nama_barang', 
                            'id' => 'nama_barang', 'readonly'=>'true']) !!}
                        </div>           
                    </div>
                    
                    {{-- type --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblmodel', 'TYPE') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('model', null, ['class'=>'form-control','placeholder' => 'Type', '-' => 'model',
                            'id' => 'model', 'readonly'=>'true']) !!}
                        </div>           
                    </div>
                    
                    {{-- group --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblgroup', 'GROUP') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('nm_group', null, ['class'=>'form-control','placeholder' => 'Group', 'name' => 'nm_group',
                            'id' => 'nm_group', 'readonly'=>'true']) !!}
                        </div>           
                    </div>
                    
                    {{-- qty 1 --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblqtypack', 'QTY PACK') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('qty_packing', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'qty_packing',
                            'id' => 'qty_packing', 'readonly'=>'true']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('lblqstock', 'QTY STOCK') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('qty_akhir', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'qty_akhir',
                            'id' => 'qty_akhir', 'readonly'=>'true']) !!}
                        </div>
                    </div>
                    
                    {{-- qty 2 --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblqtyplan', 'QTY PLAN') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('qty_plan', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'qty_plan',
                            'id' => 'qty_plan', 'readonly'=>'true']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('lblqact', 'QTY ACT') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('qty_act', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'qty_act',
                            'id' => 'qty_act', 'readonly'=>'true']) !!}
                        </div>
                    </div>
                    
                    {{-- qty 3 --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblqtylhp', 'QTY LHP') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('qty_lhp', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'qty_lhp',
                            'id' => 'qty_lhp', 'readonly'=>'true']) !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::label('lblbpb', 'NO BPB') !!}
                        </div>
                        <div class="col-sm-3">
                            {!! Form::text('no_bpb', null, ['class'=>'form-control','placeholder' => '0', 'name' => 'no_bpb',
                            'id' => 'no_bpb', 'readonly'=>'true']) !!}
                        </div>
                    </div>

                    {{-- keterangan --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblket', 'KETERANGAN') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::textarea('keterangan', null, ['class'=>'form-control', 
                            'placeholder' => 'Jika ada catatan, isi disini ', 'name' => 'keterangan', 'id' => 'keterangan',
                            'rows' => 3, 'cols' => 50]) !!}
                        </div>           
                    </div>

                    {!! Form::close() !!}
                </div>
                
                @include('dashboard.gis_mobile.layout._layout-scan2')
                <div class="modal-footer" id="modfoot">
                    <button id="cl-btn" type="reset" class="btn btn-success" title="Clear">
                <i class="fa fa-times custom-icon-success"></i>&nbsp;Clear
            </button>
            <button id="sub-btn" type="submit" class="btn btn-primary" title="Simpan">
                <i class="fa fa-save custom-icon-primary"></i></i>&nbsp;Simpan
            </button>
                </div>
            </div>
        </div>
    </div>
</div>
