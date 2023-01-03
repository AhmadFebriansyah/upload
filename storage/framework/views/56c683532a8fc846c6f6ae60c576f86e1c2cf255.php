<!DOCTYPE html>
<html>
<head>
    <title>Delivery Goods</title>
    <style>
    </style>
</head>
<body>
    <?php 
    use Carbon\Carbon;
     ?>
    <div class="box-body">
        <div class="form-group">
            <div >    
                <?php echo e(csrf_field()); ?>

                <br>
                <table class="table" border="3">
                    <thead >
                        <tr> 
                            <th colspan="2"> <img src="images/splash.png" width="100" border="2"> </th>
                            <td colspan="7" align="center" style="vertical-align: middle; border:1px solid #000;"><h5> PT Nusa Indah Jaya Utama <br> Delivery Finish Goods <br>
                                Periode = <?php echo e($tglawal); ?> s/d <?php echo e($tglakhir); ?> <br></h5></td>
                        </tr>
                        <tr>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No Transkasi</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No Kirim</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Tanggal Kirim</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Part Number</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Part Name</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Gudang</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Customer</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Qty Kirim</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getFirstLoop(); ?>
                        <tr>
                            <td style="border:1px solid #000; padding: 3px; text-align: center; vertical-align: middle;"><?php echo e($loop->iteration); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->kd_trans); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->no_kirim); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->tgl_kirim); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->no_produk); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->nama_produk); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->nama_gudang); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->nama_customer); ?></td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;"><?php echo e($row->qty_kirim); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getFirstLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</div>
</body>
</html>