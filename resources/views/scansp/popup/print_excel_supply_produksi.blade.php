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
                            <th colspan="2"> <img src="images/logo.png" width="100" border="2"> </th>
                            <td colspan="10" align="center" style="vertical-align: middle; border:1px solid #000;"><h5> PT Gemala Kempa Daya <br> Supply Produksi <br>
                                Periode = {{$tglawal}} s/d {{$tglakhir}} <br></h5></td>
                        </tr>
                        <tr>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Kode Transkasi</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Kode Barang</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Tanggal</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No Reg</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Barang</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Qty Packing</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Qty Akhir</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Model</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Nama Group</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">No Bpb</th>
                            <th align="center" style="border:1px solid #000; text-align:center; vertical-align: middle;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($print as $row)
                        <tr>
                            <td style="border:1px solid #000; padding: 3px; text-align: center; vertical-align: middle;">{{$loop->iteration}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->kode_trans}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->kode_brg}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->tgl}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->no_reg}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->nama_barang}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->qty_packing}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->qty_akhir}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->model}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->nm_group}}</td> 
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->no_bpb}}</td>
                            <td align="center" style="border:1px solid #000; padding: 3px; vertical-align: middle;">{{$row->keterangan}}</td>
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