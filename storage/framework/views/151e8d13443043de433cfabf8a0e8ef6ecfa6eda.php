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
            <?php echo Form::open(['method' => 'POST', 'id'=>'form_scpag']); ?>

                
                <div id="formscan">
                
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'KODE TRANSAKSI'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::text('kd_trans', null, ['class'=>'form-control','placeholder' => 'Kode Transaksi', 'name' => 'kd_trans', 
                            'id' => 'kd_trans', 'readonly' => 'readonly']); ?>

                        </div>           
                    </div> 
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lbltgl', 'TANGGAL'); ?>

                        </div>
                        <div class="col-sm-9">
                            <input type="date" name="tgl_produksi" id="tgl_produksi" value="<?php echo e(\Carbon\Carbon::now()->format('Y-m-d')); ?>" class="form-control">
                        </div>
                    </div>

                    <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Gudang</label>
                        </div>
                    <div class="col-sm-9">
                        <select class="form-control select2" id='gudang' name="gudang" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">-- Pilihan --</option>
                            <?php $__currentLoopData = $gudang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_gudang); ?>"><?php echo e($item->id_gudang); ?> - <?php echo e($item->nama_gudang); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>
                    </div>

                    <div class="row form-group">
                    <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'ID PRODUK'); ?>

                        </div>
                     <div class="col-sm-9">
                            <div class="input-group">
                                <?php echo Form::text('id_produk', null, ['class'=>'form-control','placeholder' => 'Id Produk',  
                                'id' => 'id_produk', 'name' => 'id_produk'
                                , 'data-toggle'=>"modal",
                                'data-target'=>"#modalInv"]); ?>

                                <span class="input-group-btn">
                                    <button id="no_inv-btn" type="button" class="btn btn-info custom-icon-info" data-toggle="modal" data-target="#modalInv">
                                        <i class="fa fa-search "></i>
                                    </button>
                                </span>
                            </div>
                        </div>          
                    </div>

                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'NAMA PART'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::text('nama_produk', null, ['class'=>'form-control','placeholder' => 'Nama Part', 'name' => 'nama_produk', 
                            'id' => 'nama_produk', 'readonly'=>'true']); ?>

                        </div>           
                    </div>

                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblkode_brg', 'NO PART'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::text('no_produk', null, ['class'=>'form-control','placeholder' => 'NO Part', 'name' => 'no_produk', 
                            'id' => 'no_produk', 'readonly'=>'true']); ?>

                        </div>           
                    </div>

                    <div class="row form-group">
                    <div class="col-sm-3">
                        <label>Customer</label>
                        </div>
                    <div class="col-sm-9">
                        <select class="form-control select2" id='customer' name="customer" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">-- Pilihan --</option>
                            <?php $__currentLoopData = $customer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_customer); ?>"><?php echo e($item->id_customer); ?> - <?php echo e($item->nama_customer); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>
                    </div>

                    
                    <div class="row form-group">
                        <div class="col-sm-3">
                            <?php echo Form::label('lblnama_barang', 'QTY'); ?>

                        </div>
                        <div class="col-sm-9">
                            <?php echo Form::number('qty', null, ['class'=>'form-control','placeholder' => 'pcs', 'name' => 'qty', 
                            'id' => 'qty']); ?>

                        </div>           
                    </div>
                    

<?php echo Form::close(); ?>

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
