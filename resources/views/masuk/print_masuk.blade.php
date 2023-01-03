<!DOCTYPE html>
<html>
<head>
    <title>Supply Produksi</title>
    <style>
    </style>
</head>
<body>
    @php
    use Carbon\Carbon;
    @endphp
    <div class="box-body">
        <div class="form-group">
            <div >    
                {{ csrf_field() }}
                <br>
                <table class="table" border="3">
                    <thead >
                        <tr> 
                            <th colspan="2"> <img src="images/splash.png" width="100" border="2"> </th>
                            <td colspan="6" align="center" style="vertical-align: middle; border:1px solid #000;"><h5> PT Nusa Indah Jaya Utama <br> Inventory Finish Goods <br>
                                Periode = {{$tglawal}} s/d {{$tglakhir}} <br></h5></td>
                        </tr>
                        <tr>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No Transkasi</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Tanggal Produksi</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Part Number</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Part Name</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Gudang</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Customer</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td style="border:1px solid #000; padding: 3px; text-align: center; vertical-align: middle;">{{$loop->iteration}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->kd_trans}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->tgl_produksi}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->no_produk}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->nama_produk}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->nama_gudang}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->nama_customer}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->qty}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
</div>
</body>
</html>