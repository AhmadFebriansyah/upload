<html style="zoom: 0.65;">
<head>
    <title>Surat_Jalan</title>
    <style>
        
        @media  print {
            html, body {
                font-size: 12px !important;
                font-family: 'Calibri' !important;
                margin : 0.5em 0.22em 0 0.22em;
                
            }
            .modal-dialog {
                position: relative;
                top: 0;
                left: 0;
            }
        }
        body{
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .table th {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        
        .table td {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .bordered td {
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }
        table {
            border-collapse: collapse;
        }
        caption {
            background-color: #F7F7F7;
            border-color: #959594;
            border-style: solid;
            border-width: 1px;
        }
        .coba{
            float:left;
            width:45%;
        }
        .coba2{
            float:left;
            width:20%;
        }
    </style>
</head>
<body>
    <div class="col-xs-12">
        <div class="combine">
        <table class="coba2">
                <tbody>
                    <tr>
                        <td width="100" style="padding: 0%; margin:0%;">
                            <img style="margin-left:70px;" src="images/splash.png" width="130" height="80" border="0"> 
                        </td>
                    </tr>
                </tbody>
            </table>
            <table class="coba">
                <tbody>
                    <tr>
                        <td width="33%" style="font-size: 12px; color:#00008B; text-align:center;">
                            <h1 style=" margin-bottom: 0;">  <b> PT. NUSA INDAH JAYA UTAMA </b> </h1>
                        </td>
                    </tr>
                    <tr>

                        <td style="text-align:center; color:#00008B"> Jl. Laskar No.49 </td>
                    </tr>
                    <tr>
                        
                        <td style="text-align:center; color:#00008B"> Pekayon Jaya - Bekasi </td>
                    </tr>
                    <tr>
                        
                        <td style="text-align:center; color:#00008B"> Telp : (021) 8241 1782 / 8243 7157 </td>
                    </tr>
                    <tr>
                        
                        <td style="text-align:center; color:#00008B"> email : pt.niju@yahoo.co.id </td>
                    </tr>
                    <tr>
                        
                        <td style="text-align:center; color:#00008B"> website : pt.niju.com </td>
                    </tr>
                </tbody>
            </table>
            <table style="position: absolute; right:230;">
                <tbody>
                    <tr>
                        <td style="text-align:left; float: right; color:#00008B"> Bekasi,  </td>
                        <td style="float: right;"> <?php echo date('d F Y', strtotime($master->tgl)); ?> </td>
                    </tr>
                    <tr style="margin-bottom:15px;">
                        <td style="text-align:left; float: right; color:#00008B"> Kepada Yth</td>
                        <td style="text-align:center; float: right;"> PT. MKM </td>
                    </tr>
                    <tr>
                    <td style="text-align:left; float: center;">Jakarta</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    
    <br>
    <div class="col-xs-12">
        <table>
                    <tbody>
                        <tr>
                            <td>
                        <b style="color:#00008B; margin-left:100px">SURAT JALAN NO.</b>  <?php echo e($master[0]->no_surat); ?>

                        </td>

                    </tr>
                </tbody>
            </table>
            <table>
                    <tbody>
                        <tr>
                        <td>
                        <b style="color:#00008B; margin-left:100px">Kami kirim dengan kendaraan</b> <?php echo e($master[0]->kendaraan); ?>

                        </td>

                    </tr>
                </tbody>
            </table>
        <table width="90%" align="center" border="1">
            <tr>
                <th style="text-align: center; font-size:10px">No</th>
                <th style="text-align: center; font-size:10px">Nama barang</th>
                <th style="text-align: center; font-size:10px">Jumlah</th>
                <th style="text-align: center; font-size:10px">Keterangan</th>
                </tr>
                <?php $__currentLoopData = $master; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row2): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                <tr style="border:1px solid #000; text-align:center;">
                    <td style="border:1px solid #000; text-align:center; font-size:8px;">
                        <b><?php echo e($loop->iteration); ?></b>  
                    </td>
                    <td style="border:1px solid #000; text-align:center; font-size:8px;">
                        <b><?php echo e($row2->nama_produk); ?></b>
                    </td>
                    <td style="border:1px solid #000; text-align:center; font-size:8px;">
                        <b><?php echo e($row2->qty_kirim); ?> PCS</b>
                    </td>
                    <td style="border:1px solid #000; text-align:center; font-size:8px;">
                        <b><?php echo e($row2->no_po); ?></b>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
            </table>
        </div>
                    </body>
                    </html>