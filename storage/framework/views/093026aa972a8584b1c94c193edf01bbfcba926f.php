<?php $__env->startSection("menu"); ?>
  <div class="menu-sidebar">
    
    
    <div class="head-menu">PERSEDIAAN STOCK</div>
    <div class="menu-sidebar-menu" data-toggle="collapse" data-target="#materialmenu">
      <img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/master-data.png')); ?>" alt="">
    MENU MASTER <span class="fa fa-chevron-down pull-right"></span>
    </div>
    <div id="materialmenu" class="menu-sidebar-navigation collapse">
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.scansp')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/warehouse.png')); ?>" alt="">Gudang</a></div>
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.customer')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/handshake.png')); ?>" alt="">Costumer</a></div>
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.produk')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/pabrik/009-box.png')); ?>" alt="">Produk</a></div>
    </div>

     <div class="menu-sidebar-menu" data-toggle="collapse" data-target="#consmenu">
      <img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/transaction.png')); ?>" alt="">
      MENU TRANSAKSI <span class="fa fa-chevron-down pull-right"></span>
    </div>
    <div id="consmenu" class="menu-sidebar-navigation collapse">
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.masuk')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/giantrack.png')); ?>" alt="">Inventory Finish Goods</a></div>
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.keluar')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/barcode (2).png')); ?>" alt="">Delivery Finish Goods</a></div>
    </div>

    <div class="menu-sidebar-menu" data-toggle="collapse" data-target="#fgmenu">
      <img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/work-order.png')); ?>" alt="">
      MENU Report <span class="fa fa-chevron-down pull-right"></span>
    </div>
    <div id="fgmenu" class="menu-sidebar-navigation collapse">
      <div class="menu-sidebar-sub-menu"><a href="<?php echo e(route('gismobile.surat')); ?>"><img class="menu-sidebar-sub-menu-icon" src="<?php echo e(asset('images/icon_dashboard/umum/report.png')); ?>" alt="">Surat Jalan</a></div>
      
    </div>
  </div>
<?php $__env->stopSection(); ?>