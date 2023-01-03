<?php echo $__env->make('layouts._menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div style="text-align: center;">
            <span class="animated flipInY" style="font-size:45px; font-weight:bold;">WELCOME TO PERSEDIAAN STOK BARANG</span><br>
            <span style="font-size:20px;" class="animated flipInX">PT NUSA INDAH JAYA UTAMA</span><br>
            <img src="<?php echo e(asset('images/splash.png')); ?>" class="animated flipInX" style="width:300px;margin-top: 10px;margin-bottom: 20px; padding: 10px;">
            <span class="animated flipInX" style="font-size:20px; display:block;"> Selamat Datang, <br>
            <b class="animated flipInX">Divisi PPC</b></span>       
            <span class="animated flipInX" style="font-size:20px; display:block;">Silahkan Pilih Menu Yang Diinginkan</span> 
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script> 
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>