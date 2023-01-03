<!DOCTYPE html>
<html lang="en">
<head>
  <title>{{ (!isset($title) ? (!isset($judul) ? "e-Spartan App" : $judul) : $title) }}</title>
  @include ('layouts.head')  
  <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
  <link rel="stylesheet" href="{{ asset('css/animate.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
  <style>
    hr{
      margin-top: 3px;
      margin-bottom: 6px;
    }
    .hidden{
      visibility: hidden;
    }
    .hidden-sidebar{
      width:0px !important;
    }
    span{
      cursor: normal;
    }
    
    .nopaddright{
      padding-right: 0 !important;
    }
    .nopaddleft{
      padding-left: 0 !important;
    }
    
    /* Style: Menu Samping */
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
    .page-title{
      font-size: 25px;
      font-weight: normal;
      color: #045cb6;
    }
    .page-icon{
      vertical-align: middle;
      width: 30px;
      margin-top: -7px;
      margin-right: 7px;
      margin-left: 20px;
    }
    .menu-sidebar{
      margin: 0;
      padding: 0;
      margin-top: -5px;
      width: 300px;
      background-color: #fff;
      position: fixed;
      height: 100%;
      overflow: auto;
      transition: 0.4s;
      z-index: 1050;
      /* padding-top: 30px; */
      padding-bottom: 100px;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 10%);
    }
    .menu-sidebar-menu{
      font-size: 16px;
      margin-top: 5px;
      padding-left: 8px;
      padding-right: 8px;
      padding-top: 4px;
      padding-bottom: 4px;
      transition: 0.1s;
      text-align: left;
      white-space: nowrap;
      color: black;
      padding: 6px;
      cursor: pointer;
      margin-left: 12px;
      margin-right: 10px;
      margin-top: 15px;
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
      box-shadow: 0px 0px 0px rgb(0 0 0 / 10%);
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
      /* margin-left: 20px; */
      /* margin-right: 20px; */
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
      padding: 10px;
      box-shadow: 0px 4px 16px rgb(0 0 0 / 5%);
      border-radius: 5px;
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
      font-size: 15px;
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
      /* text-align: center; */
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
      z-index: 1100;
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
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    @media screen and (max-width: 1024px) {
      #loading-text{
        left: 43%;
      }
    }
    @media screen and (max-width: 945px) {
      #clocktime {
        display: none;
      }
    }
    /* Navbar Bootstrap Custom */
    @media (min-width: 768px){
      .navbar {
        border-radius: 0px;
      }
    }
    
    @media screen and (max-width: 655px) {
      #datetime {
        display: none;
      }
      #clocktime {
        display: none;
      }
      #loading-text{
        left: 38%;
      }
      .menu-sidebar{
        width: 100%;
      }
    }
    @media screen and (max-width: 530px){
      #loading-text{
        left: 34%;
      }
    }
    @media screen and (max-width: 500px){
      #loading-text{
        left: 32%;
      }
    } 
    @media screen and (max-width: 414){
      #loading-text{
        left: 30%;
      }
    }
    @media screen and (max-width: 375){
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
      background-image: linear-gradient(to top right, #007eff, #074c91);
      border-color: #007eff;
      position: sticky;
      top: -1px;
      z-index: 1050;
    }
    .menu-sidebar-sub-menu-icon{
      vertical-align: middle;
      width: 20px;
      margin-top: 0px;
      margin-right: 7px;
      float: left;
      filter: sepia(1) hue-rotate(-180deg);
    }
    .menu-utama-icon{
      vertical-align: middle;
      width: 90px;
      margin-top: -7px;
      margin-right: 7px;
      margin-left: 14px;
      display: none;
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

    /* FILTER STYLES */
    .saturate { filter: saturate(3); }
    .grayscale { filter: grayscale(100%); }
    .contrast { filter: contrast(160%); }
    .brightness { filter: brightness(0.25); }
    .blur { filter: blur(3px); }
    .invert { filter: invert(100%); }
    .sepia { filter: sepia(100%); }
    .huerotate { filter: hue-rotate(180deg); }
    .rss.opacity { filter: opacity(50%); }
  </style>
  <style>
    /* HOSHIN KANRI ONLY */
    #tab-empty{
      text-align: center;
    }
  </style>
  @yield('styles')
</head>
<body style="background-color: #eeeeee;">
  <div id="loading-screen" style="display:none;">
    <div id="loading-text">
      <div style="padding-left: 7px;">
        <div class="loader"></div>
      </div>
      <span style="font-weight: 300;">Memproses...</span>
    </div> 
  </div>
  
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <div class="menu-open"><span class="fa fa-chevron-down"></span> &nbsp;&nbsp; {{ !isset($judul) ? "e-Spartan App" : $judul }}</div>
      </div>
      <ul class="nav navbar-nav" style="display:none;">
        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="fa fa-list-ul"></span> Navigation <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="">Dashboard</a></li>
            <li><a href="{{ url('home') }}">Portal Karyawan</a></li>
          </ul>
        </li>
      </ul>
      <div class="pull-right" style="margin-top: 3px; color: white;">
        <span id="datetime"><b>00 Januari 0000 </b></span><br>
        <span id="clocktime">00:00 WIB</span>
      </div>
    </div>
  </nav>
  
  @yield('menu')
  
  <section class="content">
    @yield("content")
  </section> 
  
  @include ('layouts.script')
  @include ('layouts.script2')
  <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('js/jsQR.js') }}"></script>
  <script src="{{ asset('chartjs/utils.js') }}"></script>
  <script src="{{ asset('js/jquery.autosize.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
  
  <script>
    
    $('.select2').select2()
    
    setInterval(function() {
      $(document.body).css('padding-right','0px');
    }, 2000);
    
    var d = new Date();
    var weekday=new Array(7);
    var weekday=["Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"];
    var weekday_en=new Array(7);
    var weekday_en=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    var monthname=new Array(12);
    var monthname=["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
    var monthname_en=new Array(12);
    var monthname_en=["January","February","March","April","May","June","July","August","September","October","November","December"];
    var dayname=weekday[d.getDay()];
    var day=d.getDate();
    var month=monthname[d.getMonth()];
    var year=d.getFullYear();
    if ('idn'=='en') {
      var dayname=weekday_en[d.getDay()];
      var month=monthname_en[d.getMonth()];
    }
    setInterval(function() {
      d.setSeconds(d.getSeconds() + 1);
      $('#datetime').text(( day + " " + month + " " + year ));
      $('#clocktime').text(((d.getHours() < 10 ? '0' : '') + d.getHours() +':' + (d.getMinutes() < 10 ? '0' : '') + d.getMinutes() + ':' + (d.getSeconds() < 10 ? '0' : '') + d.getSeconds() + " WIB"));
    }, 1000);
    
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
        text: 'We are Under Construction',
        showCloseButton: false,
        showCancelButton: false,
        confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> OK!',
        imageUrl: '{{ asset('images/icon_dashboard/umum/hook.png') }}',
        imageWidth: 200,
        imageHeight: 200,
      })
    })
    
    function ambilTanggal(tanggal){
      //function mengambil tanggal format mm/dd/yyyy
      var tanggal = new Date(tanggal);
      var dd = tanggal.getDate(); //ambil tanggal
      var MM = tanggal.getMonth(); //ambil bulan
      var yyyy = tanggal.getFullYear(); //ambil tahun
      var tanggalnow= yyyy+ "-" +((MM+1) < 10 ? '0'+(MM+1) : (MM+1)) + "-" +((dd) < 10 ? '0'+dd : dd);
      
      return tanggalnow;
    }
    function ambilBulan(tanggal){
      //function mengambil tanggal
      var tanggal = new Date(tanggal);
      var MM = tanggal.getMonth(); //ambil bulan
      
      return ((MM+1) < 10 ? '0'+(MM+1) : (MM+1));
    }
    function ambilTahun(tanggal){
      //function mengambil tanggal
      var tanggal = new Date(tanggal);
      var yyyy = tanggal.getFullYear(); //ambil tahun
      
      return yyyy;
    }
    function ambilWaktu(tanggal){
      //function mengambil tanggal format mm/dd/yyyy
      var tanggal = new Date(tanggal);
      var HH = tanggal.getHours(); //ambil tanggal
      var mm = tanggal.getMinutes(); //ambil bulan
      var ss = tanggal.getSeconds(); //ambil tahun
      var tanggalnow= (HH < 10 ? '0' : '')+HH + ":" + (mm < 10 ? '0' : '')+mm + ":" + (ss < 10 ? '0': '')+ss ;
      
      return tanggalnow;
    }
    
    @if(isset($user))
    @if (strlen($user)>5)
    var html = '<a href="{{ url('home') }}">\
      <div class="menu-sidebar-sub-menu">\
        <img class="menu-sidebar-sub-menu-icon" src="{{ asset('images/icon_dashboard/umum/dashboard.png') }}" alt="">PORTAL SUPPLIER\
      </div>\
    </a>'
    @else 
    var html = '<a href="">\
      <div class="menu-sidebar-sub-menu">\
        <img class="menu-sidebar-sub-menu-icon" src="{{ asset('images/icon_dashboard/umum/dashboard.png') }}" alt="">DASHBOARD E-SPARTAN\
      </div>\
    </a>'
    @endif
    $(".direct-access").html(html)
    @endif
    
    $('.table:not(#table-ppb) tbody').on( 'click', 'tr', function () {
      $(this).css("background-color", "#f3f3f6") 
      $("tr").not(this).css("background-color", "white")
    });
    
    // harus di paling bawah
    // function loading
    function showLoading(){
      $("#loading-screen").show()
    }
    function hideLoading(){
      $("#loading-screen").hide()
    }
    $(".menu-sidebar-sub-menu").children().on("click", function(){
      showLoading()
    })
    $(".menu-sidebar-menu").on("click", function(){
      var thismenu = $(this)
    })

    function changeChevron(){
      $(".fa-chevron-down").toggleClass("fa-chevron-right")
      $(".fa-chevron-down").toggleClass("fa-chevron-down")
    }
    changeChevron()
  </script>
  @yield('scripts')
</body>
</html>