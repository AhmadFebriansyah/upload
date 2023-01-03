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
                
                <div id="formscan">
                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'KODE CUSTOMER'); ?>

                        </div>
                        <div class="col-sm-9">
                        <?php if('#id_customer' !== null): ?>
                           <?php echo Form::number('id_customer', null, ['class'=>'form-control','placeholder' => 'Kode Customer', 'name' => 'id_customer', 
                            'id' => 'id_customer', 'readonly' => 'readonly']); ?>

                            <?php else: ?>
                            <?php echo Form::number('id_customer', null, ['class'=>'form-control','placeholder' => 'Kode Customer', 'name' => 'id_customer', 
                            'id' => 'id_customer']); ?>

                            <?php endif; ?>
                        </div>           
                    </div>
                    
                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblnama_barang', 'NAMA CUSTOMER'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::text('nama_customer', null, ['class'=>'form-control','placeholder' => 'Nama Customer', 'name' => 'nama_customer', 
                            'id' => 'nama_customer']); ?>

                        </div>           
                    </div>

                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblnama_barang', 'ALAMAT'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::text('alamat_customer', null, ['class'=>'form-control','placeholder' => 'Alamat', 'name' => 'alamat_customer', 
                            'id' => 'alamat_customer']); ?>

                        </div>           
                    </div>

                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblnama_barang', 'TELPON'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::number('no_telp', null, ['class'=>'form-control','placeholder' => 'Telpon', 'name' => 'no_telp', 
                            'id' => 'no_telp']); ?>

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