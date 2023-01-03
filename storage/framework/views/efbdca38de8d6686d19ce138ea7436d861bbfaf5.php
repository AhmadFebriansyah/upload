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
                <a class="btn btn-primary form-control" id="printlp" style="display: block;" href="<?php echo e(route('gismobile.input_surat')); ?>"><i class="fa fa-plus custom-icon-info"></i> &nbsp;Tambah Data</a>
            </div>
        </div>
    </div>
</div>   

<div class="content-container">
        <div class="content-box-title"><label>Filter Surat</label></div>
        <div class="box-body form-horizontal">
            <?php echo Form::open(['method' => 'post',  'id'=>'form_scpag']); ?>

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
                        <label>Produk</label>
                        <select class="form-control select2" id='produk' name="produk" aria-controls="filter_site" required="true" style="width: 100%">
                            <option value="ALL" disabled selected="selected">SEMUA</option>
                            <?php $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                            <option value="<?php echo e($item->id_produk); ?>"><?php echo e($item->nama_produk); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <?php echo Form::label('action', 'Aksi'); ?>

                        <button id="display-btn" type="button" class="btn form-control btn-primary" data-toggle="tooltip" data-placement="top" title="Show Data"><i class="fa fa-search custom-icon-info"></i> &nbsp;Display</button>
                    </div>
                </div>
                </div>
                
            </div>
        </div>
    
        <div class="content-container">
        <div class="content-box-title"><label>Tabel Surat Jalan</label></div>
        <table id="table_inv" class="table table-bordered table-responsive dataTable thWarna" cellspacing="0" style="width: 100%;" >
            <thead>
                <tr>
                    <th>No Surat</th>
                    <th>No PO</th>
                    <th>No Polisi</th>
                    <th>No Kirim</th>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>Qty Kirim</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
    
    
    
    <?php $__env->stopSection(); ?>
    
    <?php $__env->startSection('scripts'); ?>
    <script>
        
        $(document).ready(function() {
            $('#display-btn').trigger("click");
        });
        
        var url = '<?php echo e(route("gismobile.surat.dt", [base64_encode(\Carbon\Carbon::now()->format("Y-m-d")),\
        base64_encode(\Carbon\Carbon::now()->format("Y-m-d")), base64_encode("#")])); ?>'

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
            {data: 'no_surat', name:'no_surat'},
            {data: 'no_po', name:'no_po'},
            {data: 'kendaraan', name:'kendaraan'},
            {data: 'no_kirim', name:'no_kirim'},   
            {data: 'tgl', name:'tgl'},   
            {data: 'nama_produk', name:'nama_produk'},   
            {data: 'qty_kirim', name:'qty_kirim'},   
            {data: 'action', name:'action'},   
            ]
        });
        
        $("#display-btn").on("click", function(){
                var tglawal = $('#tglawal').val();
                var tglakhir = $('#tglakhir').val();
                var produk = $('#produk').val();
                var url1 = "<?php echo e(route('gismobile.surat.dt', ['param1','param2' ,'param3'])); ?>"
                url1 = url1.replace("param1", window.btoa(tglawal))
                url1 = url1.replace("param2", window.btoa(tglakhir))
                url1 = url1.replace("param3", window.btoa(produk))
                table.ajax.url(url1).load();
        });


        $(document).on("click", ".btn-edit", function(){
            var myHeader = "<b>Edit Scan Out Material untuk Supply Produksi</b>";
            $("#modalLabel").html(myHeader);
            
        })
        function print_excel(no_surat) {
            console.log(no_surat);
            var url = '<?php echo e(route("gismobile.surat.print", ['param1'])); ?>'
            url = url.replace('param1', window.btoa(no_surat));
            window.location = url;
        }

    </script>
    <?php $__env->stopSection(); ?>
    
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>