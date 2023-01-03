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
                    {{-- kode barang --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblkode_brg', 'KODE PRODUK') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('id_produk', null, ['class'=>'form-control','placeholder' => 'Kode Produk', 'name' => 'id_produk', 
                            'id' => 'id_produk']) !!}
                        </div>           
                    </div>
                    
                    {{-- nama barang --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblnama_barang', 'NAMA PRODUK') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('nama_produk', null, ['class'=>'form-control','placeholder' => 'Nama Produk', 'name' => 'nama_produk', 
                            'id' => 'nama_produk']) !!}
                        </div>           
                    </div>

                    {{-- nama barang --}}
                    <div class="row form-group">
                        <div class="col-sm-3">
                            {!! Form::label('lblnama_barang', 'NO PRODUK') !!}
                        </div>
                        <div class="col-sm-9">
                            {!! Form::text('no_produk', null, ['class'=>'form-control','placeholder' => 'No Produk', 'name' => 'no_produk', 
                            'id' => 'no_produk']) !!}
                        </div>           
                    </div>
                    

                </div>
                
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