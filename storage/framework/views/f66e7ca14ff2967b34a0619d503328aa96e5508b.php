<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <link rel="shortcut icon" href="<?php echo e(asset('images/splash.png')); ?>"/>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('asset-ops/css/font-awesome.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/jquery.dataTables.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/dataTables.bootstrap.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/AdminLTE.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/skins/_all-skins.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/animate.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/animate.min.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('plugins/toastr/toastr.css')); ?>">
  
  <link rel="shortcut icon" href="<?php echo e(asset('images/splash.png')); ?>"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo e(asset('bootstrap/css/bootstrap.min.css')); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/font-awesome/css/font-awesome.min.css')); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/ionicons/css/ionicons.min.css')); ?>">
  <!-- DataTables -->
  
  <link rel="stylesheet" href="<?php echo e(asset('css/jquery.dataTables.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/dataTables.bootstrap.css')); ?>">
  <!-- daterange picker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/daterangepicker/daterangepicker.css')); ?>">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/datepicker/datepicker3.css')); ?>">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/colorpicker/bootstrap-colorpicker.min.css')); ?>">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/timepicker/bootstrap-timepicker.min.css')); ?>">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/select2/select2.min.css')); ?>">
  
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo e(asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/AdminLTE.min.css')); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo e(asset('dist/css/skins/_all-skins.min.css')); ?>">
  <!-- Sweet Alert 2-->
  <link href="<?php echo e(asset('css/sweetalert2.min.css')); ?>" rel="stylesheet">
  <link href="<?php echo e(asset('css/sweetalert2.min.css')); ?>" rel="stylesheet">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <noscript>
    <H1 align = 'center'>This page needs JavaScript activated to work.</H1>
    <style>nav { display:none; } div { display:none; }</style>
  </noscript>
  
  
  <style>
    /* Attribute */
    .hidden{
      visibility: hidden;
    }
    .hidden-sidebar{
      width:0px !important;
    }
    span{
      cursor: normal;
    }
    
    /* General */
    .nopaddright{
      padding-right: 0 !important;
    }
    .nopaddleft{
      padding-left: 0 !important;
    }
    
    /* Style: Menu */
    .menu-open{
      display: inline-block;
      font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-size: 20px;
      color: white;
      cursor: pointer;
      z-index: 5;
      float: left;
      margin-top: 10px;
      margin-left: 15px;
    }
    
    .menu-sidebar{
      margin: 0;
      padding: 0;
      margin-top: -5px;
      width: 250px;
      background-color: #ffffff;
      position: fixed;
      height: 100%;
      overflow: auto;
      transition: 0.4s;
      z-index: 5;
      padding-top: 30px;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
    }
    
    .menu-sidebar-menu{
      font-size: 14px;
      margin-top: 5px;
      padding-left: 8px;
      padding-right: 8px;
      padding-top: 4px;
      padding-bottom: 4px;
      transition: 0.5s;
      text-align: left;
      white-space: nowrap;
      background-color: #ffffff;
      color: black;
      font-weight: 600;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
      padding: 10px;
      cursor: pointer;
      border-top-right-radius: 10px;
    }
    .menu-sidebar-menu-prog{
      font-size: 14px;
      padding-left: 35px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      transition: 0.5s;
      text-align: left;
      white-space: nowrap;
      background-color: #ffffff;
      color: black;
      font-weight: 600;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
      cursor: pointer;
      border-top-right-radius: 10px;
      margin: 5px 0;
    }
    
    .menu-sidebar-footer{
      font-size: 1px;
      padding-bottom: 2px;
      transition: 0.5s;
      background-color: #88a8c4;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
    }
    
    .menu-sidebar-sub-menu{
      font-size: 14px;
      padding-left: 35px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      transition: 0.5s;
      text-align: left;
      white-space: nowrap;
      background-color: #ececec;
    }
    .menu-sidebar a{
      color: #353535;
      font-weight: 600;
    }
    .menu-sidebar-sub-menu:hover{
      background-color: #fff98b;
    }
    .menu-sidebar>a:active{
      background-color: #fff98b;
    }
    
    .menu-sidebar-sub-menu-prog{
      font-size: 14px;
      padding-left: 60px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      transition: 0.5s;
      text-align: left;
      white-space: nowrap;
      background-color: #ececec;
    }
    .menu-sidebar-menu-prog a{
      color: #353535;
      font-weight: 600;
    }
    .menu-sidebar-sub-menu-prog:hover{
      background-color: #fff98b;
    }
    .menu-sidebar-menu-prog>a:active{
      background-color: #fff98b;
    }
    
    /* Content Style */
    .content-container{
      background-color: #ffffff;
      color: rgb(19, 18, 18);
      border: 1px solid #dedede;
      padding: 10px;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
      border-radius: 10px;
      margin-bottom: 15px;
      transition: 1s;
    }
    .content-title{
      padding-top: 8px;
      padding-bottom: 8px;
      padding-left: 10px;
      background-color: #ffffffe0;
      margin-bottom: 15px;
      border-radius: 10px;
      font-weight: 600;
      text-align: center;
    }
    .wrapper {
      background-color: #ecf0f5 !important;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .modal-content {
      border-radius: 7px;
    }
    .border {
      border: 1px solid #ccc;
    }
    .box.box-primary {
      border-top-color: #6f9bbe;
      margin-bottom: 10px;
      padding: 10px;
      border-radius: 8px;
    }
    .panel-default>.panel-heading {
      color : #fff;
    }
    .panel {
      margin-bottom: 10px;
      border: 1px solid white;
    }
    
    .panel-box{
      margin-top: 25px;
      padding-bottom: 10px;
      background-color: #ffffff;
      border-radius: 7px;
      box-shadow: 0px 0px 2px black;
    }
    
    .header-panel{
      border-radius: 6px;
      padding: 20px;
      font-weight: 700;
      font-size: 20px;
    }
    .header-text{
      color: white;
    }
    .box-footer{
      padding: 20px;
      
    }
    #datetime {
      font-size: 16px;
      font-weight: 500;
    }
    select, option, input[type=checkbox] {
      cursor: pointer;
    }
    input[type=date] {
      cursor: text;
    }
    
    .dataTables_scrollHeadInner {    /for positioning header when scrolling is applied/
      padding:0% ! important
    }
    .table { 
      font-weight: 500;
      font-size: 12px;
    }
    .table>thead>tr>th{
      text-align: center;
      vertical-align: middle;
    }
    .thWarna>thead>tr>th{
      background-color: #dadfe9 !important;
      color: #3a3838;
    }
    .thWarna>tfoot{
      background-color: #dadfe9 !important;
      color: #3a3838;
      text-align: center;
    }
    .thWarna>tfoot>tr>td.middlefoot{
      vertical-align: middle;
      font-weight: bold;
    }
    .nav>li>a{
      color: #444;
      background: #f7f7f7;
      cursor: pointer;
    }
    .table-hover>tbody>tr:hover {
      background-color: #eaeff3;
    }
    
    .table>tbody>tr>td{
      vertical-align: middle;
      text-align: center;
    }
    
    #canvas {
      width: 100%;
    }
    
    /*  Loading */
    #loading-screen{
      width: 100%;
      height: 100vh;
      background-color: #7d777745;
      position: fixed;
      z-index: 100;
      text-align: center;
      padding-top: 40vh;
    }
    #loading-text{
      background-color: white;
      border-radius: 10px;
      text-align: center;
      width: 150px;
      height: 150px;
      display: inline-block;
      padding-top: 29px;
      transition: 0.3s ease-out;
    }
    .loader {
      border: 10px solid #f3f3f3;
      border-top: 10px solid #3498db;
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
      margin-left: 30%;
      margin-top: 0%;
      margin-bottom: 13%;
      position: relative;
      font-weight: 300;
    }  
    @keyframes  spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    /* Loading */
    
    @media  screen and (max-width: 1024px) {
      #loading-text{
        left: 43%;
      }
    }
    /* Navbar Bootstrap Custom */
    @media (min-width: 768px){
      .navbar {
        border-radius: 0px;
      }
    }
    @media  screen and (max-width: 655px) {
      #loading-text{
        left: 38%;
      }
    }
    @media  screen and (max-width: 530px){
      #loading-text{
        left: 34%;
      }
    }
    @media  screen and (max-width: 500px){
      #loading-text{
        left: 32%;
      }
    } 
    @media  screen and (max-width: 414){
      #loading-text{
        left: 30%;
      }
    }
    @media  screen and (max-width: 375){
      #loading-text{
        left: 27%;
      }
    }
    
    .navbar {
      position: relative;
      min-height: 50px;
      margin-bottom: 3px;
      border: none;
    }
    .navbar-inverse {
      background-image: linear-gradient(to top right, #007eff, #2c5577);
      border-color: #007eff;
      position: sticky;
      top: -1px;
      z-index: 6;
    }
    .menu-sidebar-sub-menu-icon{
      vertical-align: middle;
      width: 20px;
      margin-top: 0px;
      margin-right: 7px;
      float: left;
    }
    .menu-utama-icon{
      vertical-align: middle;
      width: 90px;
      margin-top: -7px;
      margin-right: 7px;
      margin-left: 14px;
      margin-bottom: 14px;
    }
    .modal{
      overflow-y: auto;
    }
    .custom-icon-info{
      font-weight: 600; 
      color: rgb(55, 79, 116);
    }
    .custom-icon-primary{
      font-weight: 600; 
      color: rgb(189, 211, 245);
    }
    .custom-icon-danger{
      font-weight: 600; 
      color: rgb(119, 16, 16);
    }
    .custom-icon-success{
      font-weight: 600; 
      color: #066d1c;
    }
    .content-box{
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
      border-radius: 8px;
      margin-top: 10px;
      background-color: white;
      padding: 10px;
    }
    .content-box-title{
      padding: 8px;
      margin-top: -10px;
      width: fit-content;
      border-radius: 0px 0px 8px 8px;
      height: 35px;
      margin-bottom: 5px;
    }
    .btn{
      font-weight: 600;
    }
    .head-menu{
      padding: 5px;
      font-weight: bold;
      font-size: 20px;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
      margin-top: 10px;
      margin-bottom: -6px;
      color: white;
      background-color: #007eff;
      margin-top: 30px;
    }
  </style>
  <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
  
  
  <div id="loading-screen" style="display:none;">
    <div id="loading-text">
      <div style="padding-left: 7px;">
        <div class="loader"></div>
      </div>
      <span style="font-weight: 300;">Sedang memuat data...</span>
    </div> 
  </div>
  <body background="<?php echo e(asset("images/bg-vendor-1.png")); ?>" style="width:100%; background-size:cover; background-repeat: repeat-y;">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <div class="menu-open"><span class="fa fa-chevron-down"></span>&nbsp; GIS MOBILE</div>
        </div>
        <ul class="nav navbar-nav" style="display:none;">
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-list-ul"></span> Navigation <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="">Dashboard</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
    
    
    <?php echo $__env->yieldContent("content"); ?>
    
    
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="<?php echo e(asset('plugins/jQuery/jquery-2.2.3.min.js')); ?>"></script>
    <script src="<?php echo e(asset('bootstrap/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/dataTables.fixedColumns.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dist/js/app.min.js')); ?>"></script> 
    <script src="<?php echo e(asset('js/sweetalert2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/toastr/toastr.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script> 
    <script src="<?php echo e(asset('plugins/select2/select2.full.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/webcodecamjquery.js')); ?>"></script>
    <script src="<?php echo e(asset('js/qrcodelib.js')); ?>"></script>
    <script src="<?php echo e(asset('js/jsQR.js')); ?>"></script>
    
    <script src="<?php echo e(asset('js/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/daterangepicker/daterangepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datepicker/bootstrap-datepicker.js')); ?>"></script>
    <script src="<?php echo e(asset('chartjs/Chart.bundle.js')); ?>"></script>
    <script src="<?php echo e(asset('chartjs/utils.js')); ?>"></script>
    <?php echo $__env->yieldContent('scripts'); ?>
    <script>
      $(".select2").select2()
      
      var windowWidth = 0
      function responsiveMenu(){
        windowWidth = $(window).width()
        if (!$(".menu-sidebar").hasClass("hidden-sidebar")){
          $(".menu-sidebar").toggleClass("hidden-sidebar")
          $(".menu-open").children().toggleClass("fa-bars")
        }
      }
      responsiveMenu()
      
      var resizeTimeout;
      $(window).on('resize', function(event){
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function(){  
          responsiveMenu()
        }, 800);
      });
      
      $(".menu-open").on("click", function(){
        $(".navbar-nav").toggleClass("hidden")
        $(".menu-sidebar").toggleClass("hidden-sidebar")
        $(".menu-open").children().toggleClass("fa-bars")
      })
      
      $('.construct').on('click', function(){
        swal({
          title: 'Sorry!',
          // icon: 'info',
          text: 'We are Under Construction',
          showCloseButton: false,
          showCancelButton: false,
          confirmButtonText:
          '<i class="fa fa-thumbs-up"></i> OK!',
          // confirmButtonAriaLabel: 'Thumbs up, great!',
          imageUrl: '<?php echo e(asset('images/icon_dashboard/umum/hook.png')); ?>',
          imageWidth: 200,
          imageHeight: 200,
          // imageAlt: 'Construct',
        })
      })
      
      function ambilTanggal(tanggal){
        var tanggal = new Date(tanggal);
        var dd = tanggal.getDate(); 
        var MM = tanggal.getMonth();
        var yyyy = tanggal.getFullYear(); 
        var tanggalnow= yyyy+ "-" +((MM+1) < 10 ? '0'+(MM+1) : (MM+1)) + "-" +((dd) < 10 ? '0'+dd : dd);
        
        return tanggalnow;
      }
      function ambilBulan(tanggal){
        var tanggal = new Date(tanggal);
        var MM = tanggal.getMonth(); 
        
        return ((MM+1) < 10 ? '0'+(MM+1) : (MM+1));
      }
      function ambilTahun(tanggal){
        var tanggal = new Date(tanggal);
        var yyyy = tanggal.getFullYear(); 
        
        return yyyy;
      }
      function ambilWaktu(tanggal){
        var tanggal = new Date(tanggal);
        var HH = tanggal.getHours(); 
        var mm = tanggal.getMinutes(); 
        var ss = tanggal.getSeconds();
        var tanggalnow= (HH < 10 ? '0' : '')+HH + ":" + (mm < 10 ? '0' : '')+mm + ":" + (ss < 10 ? '0': '')+ss ;
        
        return tanggalnow;
      }
      
      
      
      // harus di paling bawah
      // function loading
      function showLoading(){
        $("#loading-screen").show()
      }
      function hideLoading(){
        $("#loading-screen").hide()
      }
    </script>
    
    <script>
      window.Laravel = <?php echo json_encode([
      'csrfToken' => csrf_token(),
      ]); ?>
    </script>
    
  </body>
  </html>