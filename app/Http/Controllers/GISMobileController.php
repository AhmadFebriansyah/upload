<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Carbon\Carbon;
use DB;
use Yajra\Datatables\Facades\Datatables;
use Yajra\Datatables\Html\Builder;
use App\GISMobile;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\Oci8\Query\OracleBuilder;
use Illuminate\Support\Collection;
use App\Dashboard;
use Exception;
use App\User;
use DNS2D;
use DNS1D;
use Excel;
use PDF;
use Alert;

class GISMobileController extends Controller
{
  
  public function __construct(){
    $this->dashboard = new Dashboard();
    $this->user = new User();
    $this->gis_mobile = new GISMobile();
  }
  
  public function gismobile__val_periode_wip(Request $request){
    if ($request->ajax()){
      try {
        DB::beginTransaction();
        $bulan = Carbon::parse($request->tgl)->format("m");
        $tahun = Carbon::parse($request->tgl)->format("Y");
        
        $stat_periode = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT PERIODE_WIP FROM  TCLOSING
        WHERE TAHUN = '$tahun' AND BULAN ='$bulan')"))
        ->value("PERIODE_WIP");
        
        // dd($stat_periode, $tahun, $bulan);
        
        DB::commit();
        return response()->json(['msg' => 'Get Data Succes!', 
        'indctr' => '1',
        'stat_periode' => $stat_periode]);
      } catch (Exception $ex) {
        DB::rollback();
        $msg = "Terjadi kesalahan pada :".$ex->getMessage();
        $indctr = "0";
        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
      } 
    }
  }
  public function gismobile__index(){
      $data['title'] = 'Persediaan | Welcome';
      $data['judul'] = 'DASHBOARD';
      
      return view('auth.index')->with($data);
  }
  # RYAN START #
  # validasi
  public function validasiperiodsp(Request $request){
      try {
        DB::beginTransaction();
        $username = base64_decode($request->username);
        $password = base64_decode($request->password);
      
        $cekperiode = DB::table(DB::raw("(SELECT * FROM user
        where username = '$username' and password = '$password') v"))
        ->get();
        
        DB::commit();
        return response()->json(['msgstat' => 'Get Data Succes!', 
        'idxstat' => '1',
        'cekperiode' => $cekperiode]);
      } catch (Exception $ex) {
        DB::rollback();
        $msgstat = "terjadi kesalahan pada :".$ex->getMessage();
        $idxstat = "0";
        return response()->json(['msgstat' => $msgstat, 'idxstat' => $idxstat]);
      } 
  }
  public function login(){
    $data['title'] = 'Login';
    $data['judul'] = ' Login';
    
    Session::flash("flash_notification", [
      "level" => "warning",
      "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
    ]);
    
    return view("auth.login")->with($data);
  }
  public function supplyproduksi__scan(){
    $data['title'] = 'GUDANG';
    $data['judul'] = ' Gudang';
    $whs_supply = new GISMobile();
    
    Session::flash("flash_notification", [
      "level" => "warning",
      "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
    ]);
    
    return view("gudang.index_gudang")->with($data);
  }
  
  public function supplyproduksi__dt(){
    $data = DB::table(DB::raw("(SELECT * FROM gudang) v"));
    return Datatables::of($data)
    ->addColumn("action", function($row){
      return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
      no-trans="'. $row->id_gudang .'" title="Edit Data"
      onclick="edit(\''. $row->id_gudang .'\',\''. $row->nama_gudang .'\')">
      <span class="glyphicon glyphicon-edit"></span></button>
      
      <button type="button"  class="btn-delete btn btn-danger delete-row btn-sm custom-icon-danger" title="Hapus Data"
      no-trans="'. $row->id_gudang .'" 
      onclick="hapus(\''. $row->id_gudang .'\')">
      <span class="glyphicon glyphicon-trash"></span></button></center>';;
      
    })
    ->make(true);
  }
  
  public function supplyproduksi__norut_trans(){
    $kode_trans= DB::connection("oracle-usrgkdmfg")
    ->table("WHS_SUPPLY_PROD")
    ->select(DB::raw("MAX(SUBSTR(KODE_TRANS,1,4)) ID"))
    ->whereRaw("TAHUN = '$tahun' AND BULAN = '$bulan'")
    ->value('ID');
    $kode_trans = intval($kode_trans) + 1;
    $no_trans = sprintf('%04d', $kode_trans) . "/WSP" . $site. "/" . $periode;
    
    return response()->json(['msg' => 'No trans dibuat!', 
    'indctr' => '1',
    'norx' => $no_trans]);
  }
  
  public function supplyproduksi__gen_trans(Request $request){
    if($request->ajax()){
      $idtra = DB::connection('oracle-usrgkdmfg')
      ->table(DB::raw("(SELECT KODE_TRANS, MLINE_CODE , NO_REG, TGL
      FROM WHS_SUPPLY_PROD 
      WHERE KODE_TRANS = '$request->notrak')v"))
      ->get();
      
      return response()->json(['msg' => 'Generate Trans berhasil!', 
      'indctr' => '1',
      'idtra' => $idtra,
      'notrak' => $request->notrak]);
    }
  }
  
  public function supplyproduksi__gen_barang(Request $request){
    if($request->ajax()){
      $tahun = Carbon::parse($request->tgl)->format('Y');
      $bulan = Carbon::parse($request->tgl)->format('m');
      $site = $request->site;
      $kode_tran = $request->kode_trans;
      
      if ($kode_tran !== null){ 
        $tag = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT * FROM VWHS_SUPPLY_PROD 
        WHERE TAHUN = '$tahun' 
        AND BULAN = '$bulan' 
        AND   KD_GUDANG = '$site'
        AND NO_REG = '$request->no_tag' 
        AND NO_BPB IS NULL)v"))
        ->get();
        $msg = "Data akan di edit";
        $indctr = 3;
      } else { 
        $caritag2 = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT NO_REG, KODE_BRG, NAMA_BARANG, MODEL, 
        NM_GROUP, QTY_PACKING, QTY_AKHIR 
        FROM  VWHS_MUTASI_TAG M1 
        WHERE THN_MUTASI||BLN_MUTASI = '$tahun'||'$bulan'  
        AND   KD_GUDANG = '$site'
        AND NO_REG = '$request->no_tag'  
        AND   NVL(QTY_AKHIR_SCAN,0) <> 0  
        ORDER BY 1)v"))
        ->get();
        if($caritag2->count() > 0){ 
          $tag = DB::connection('oracle-usrgkdmfg')
          ->table(DB::raw("(SELECT *
          FROM  VWHS_MUTASI_TAG M1 
          WHERE THN_MUTASI||BLN_MUTASI = '$tahun'||'$bulan'  
          AND   KD_GUDANG = '$site'  
          AND   NVL(QTY_AKHIR_SCAN,0) <> 0
          AND NO_REG = '$request->no_tag'  
          ORDER BY 1)v"))
          ->get();
          
          $msg = "Berhasil scan";
          $indctr = 1;
        } else { 
          $tag = [];
          $msg = 'QTY akhir scan tidak ada';
          $indctr = 2;
        }
      }
      return response()->json([
        'msg' => $msg,
        'indctr'=> $indctr,
        'tag' => $tag,
      ]);
    }
  }
  
  public function supplyproduksi__store(Request $request){
    try {
      DB::beginTransaction();
      $caritrak2 = DB::table(DB::raw("(SELECT * FROM gudang where id_gudang = '$request->id') v"))
      ->get();
      if ($caritrak2->count() > 0){
        $edit = DB::table('gudang')
        ->whereRaw("id_gudang = '$request->id'")
        ->update([
          'nama_gudang' => $request->nama]);
          
          $msg = "Berhasil Update Data";
          $nummer = 1;
          
          $log_keterangan = "GISMobileController.scansp: Edit Scan Supply Produksi Berhasil. Kode: " .$request->id;
        } else {
          $insert = DB::table('gudang')
          ->insert(['id_gudang' => $request->id,
          'nama_gudang' => $request->nama
        ]);
        
        $msg = "Berhasil Submit Data";
        $nummer = 1;
        
        $log_keterangan = "GISMobileController.scansp: Input Scan Supply Produksi Berhasil. Kode: " .$request->id;
      }
      DB::commit();
      return response()->json(['nummer' => $nummer, 'mes' => $msg, 'id' => $request->id]);
    } catch (Exception $ex) {
      DB::rollback();
      
      # INSERT LOGS ERROR
      $log_keterangan = "GISMobileController.error: Create Scan Supply Produksi Error. Kode: " .$request->id.". Error System: ".$ex->getMessage();
      
      $msg = "terjadi kesalahan pada :".$ex->getMessage();
      return response()->json(['nummer' => 0, 'mes' => $msg]);
    }
  }
  
  public function supplyproduksi__delete(Request $request, $id_gudang){
    try{
      DB::beginTransaction();
      $id_gudang = base64_decode($id_gudang);
      DB::delete('delete from gudang where id_gudang = :id_gudang' ,['id_gudang' => $id_gudang]);
      $msg = "Sukses hapus data";
      $indctr = "1";     
      DB::commit();
      return response()->json([
        "msg" => $msg,
        'indctr' => $indctr,
        "id_gudang" => $id_gudang]);
      } catch(Exception $ex){
        DB::rollback();
        
        # INSERT LOGS ERROR
        $log_keterangan = "GISMobileController.error: Create Gudang Error. Kode: " .$id_gudang. ". Error System: ".$ex->getMessage();
        return response()->json(["status" => 0, "msg" => $ex->getMessage()]);
      }  
    }
    
    public function excel_supply_produksi(Request $request){
      if (Auth::user()->can('dashboard-gismobile-supplyprod-excel')) {
        $data['title'] = 'EXPORT EXCEL';
        $data['judul'] = 'EXPORT SCAN SUPPLY PRODUKSI';
        $whs_supply = new GISMobile();
        
        $user = Auth::user()->username;
        $data['user'] = $user;
        
        $data['site_user'] = $whs_supply->getUserSite($user);
        $data['site'] = $whs_supply->getWhs($user);
        $data['line'] = $whs_supply->getLine();
        $data['operiode'] = $whs_supply->getPeriode2();
        return view('dashboard.gis_mobile.material.scansp.popup.excel_supply_produksi')->with($data);
      } else {
        return view('errors.403');
      }
    }
    
    public function print_supply_produksi(Request $request, $tglawal, $tglakhir, $site, $status){
      $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
      $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
      $site =  base64_decode($site);
      $status =  base64_decode($status);
      
      if ($status == "F") {
        $qty_lhp = " and NVL(QTY_LHP,0) = 0";
      } else if ($status == "T") {
        $qty_lhp = " and QTY_LHP >= 1 ";
      } else {
        $qty_lhp = "";
      }
      
      $print = DB::connection("oracle-usrgkdmfg")
      ->table(DB::raw("(SELECT KODE_TRANS, SUBSTR(N1.KODE_BRG ,1,10) KODE_BRG, TGL, NO_REG, 
      SUBSTR(N1.NAMA_BARANG,1,200) NAMA_BARANG, SUBSTR(N1.MODEL,1,150) MODEL, SUBSTR(N1.NM_GROUP,1,100) NM_GROUP, 
      TO_NUMBER(N1.QTY_PACKING) QTY_PACKING, TO_NUMBER(N1.QTY_AKHIR) QTY_AKHIR, NO_BPB, KETERANGAN,
      N1.TAHUN, N1.BULAN, N1.KD_GUDANG 		
      FROM VWHS_SUPPLY_PROD N1
      WHERE TO_CHAR(TGL,'YYYYMMDD') >= '$tglawal'
      AND  TO_CHAR(TGL,'YYYYMMDD') <= '$tglakhir'
      AND N1.KD_GUDANG = '$site'
      $qty_lhp
      ORDER  BY TGL DESC) v"))
      ->get();    
      
      error_reporting(E_ALL * ~E_NOTICE & ~E_WARNING);
      ob_end_clean();
      ob_start();
      
      Excel::create('SUPPLY_PRODUKSI_', function($excel) use ($print, $tglawal, $tglakhir, $site, $status) {
        $excel->sheet('Excel sheet', function($sheet) use ($print, $tglawal, $tglakhir, $site, $status) {
          $sheet->loadView('dashboard.gis_mobile.material.scansp.popup.print_excel_supply_produksi')->with(compact(['print', 'tglawal', 'tglakhir', 'site', 'status']));
          $sheet->setOrientation('landscape');
          $sheet->setWidth('A', 1)->getStyle('A')->getAlignment()->setWrapText(true);
          $sheet->setWidth('B', 20)->getStyle('B')->getAlignment()->setWrapText(true);
          $sheet->setWidth('C', 20)->getStyle('C')->getAlignment()->setWrapText(true);
          $sheet->setWidth('D', 20)->getStyle('D')->getAlignment()->setWrapText(true);
          $sheet->setWidth('E', 20)->getStyle('E')->getAlignment()->setWrapText(true);
          $sheet->setWidth('F', 20)->getStyle('F')->getAlignment()->setWrapText(true);
          $sheet->setWidth('G', 15)->getStyle('G')->getAlignment()->setWrapText(true);
          $sheet->setWidth('H', 14)->getStyle('H')->getAlignment()->setWrapText(true);
          $sheet->setWidth('I', 25)->getStyle('I')->getAlignment()->setWrapText(true);
          $sheet->setWidth('J', 14)->getStyle('J')->getAlignment()->setWrapText(true);
          $sheet->setWidth('K', 14)->getStyle('K')->getAlignment()->setWrapText(true);
          $sheet->setWidth('L', 30)->getStyle('L')->getAlignment()->setWrapText(true);
        });
      })->export('xls');
    }
    
    public function customer(){
      $data['title'] = 'Customer';
      $data['judul'] = ' Customer';
      
      Session::flash("flash_notification", [
        "level" => "warning",
        "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
      ]);
      
      return view("customer.index_customer")->with($data);
    }
    
    public function customer__dt(){
      $data = DB::table(DB::raw("(SELECT * FROM customer) v"));
      return Datatables::of($data)
      ->addColumn("action", function($row){
        return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
        no-trans="'. $row->id_customer .'" title="Edit Data"
        onclick="edit(\''. $row->id_customer .'\',\''. $row->nama_customer .'\', \''. $row->alamat_customer .'\',\''. $row->no_telp .'\')">
        <span class="glyphicon glyphicon-edit"></span></button>
        
        <button type="button"  class="btn-delete btn btn-danger delete-row btn-sm custom-icon-danger" title="Hapus Data"
        no-trans="'. $row->id_customer .'" 
        onclick="hapus(\''. $row->id_customer .'\')">
        <span class="glyphicon glyphicon-trash"></span></button></center>';;
        
      })
      ->make(true);
    }
    
    public function customer__store(Request $request){
      try {
        DB::beginTransaction();
        $caritrak2 = DB::table(DB::raw("(SELECT * FROM customer where id_customer = '$request->id_customer') v"))
        ->get();
        if ($caritrak2->count() > 0){
          $edit = DB::table('customer')
          ->whereRaw("id_customer = '$request->id_customer'")
          ->update([
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'no_telp' => $request->no_telp]);
            
            $msg = "Berhasil Update Data";
            $nummer = 1;
            
            $log_keterangan = "GISMobileController.scansp: Edit Customer Berhasil. Kode: " .$request->id_customer;
          } else {
            $insert = DB::table('customer')
            ->insert(['id_customer' => $request->id_customer,
            'nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'no_telp' => $request->no_telp
          ]);
          
          $msg = "Berhasil Submit Data";
          $nummer = 1;
          
          $log_keterangan = "GISMobileController.scansp: Input Gudang Berhasil. Kode: " .$request->id_customer;
        }
        DB::commit();
        return response()->json(['nummer' => $nummer, 'mes' => $msg, 'id' => $request->id_customer]);
      } catch (Exception $ex) {
        DB::rollback();
        
        # INSERT LOGS ERROR
        $log_keterangan = "GISMobileController.error: Create Scan Supply Produksi Error. Kode: " .$request->id_customer.". Error System: ".$ex->getMessage();
        
        $msg = "terjadi kesalahan pada :".$ex->getMessage();
        return response()->json(['nummer' => 0, 'mes' => $msg]);
      }
    }
    
    public function customer__delete(Request $request, $id_customer){
      try{
        DB::beginTransaction();
        $id_customer = base64_decode($id_customer);
        DB::delete('delete from customer where id_customer = :id_customer' ,['id_customer' => $id_customer]);
        $msg = "Sukses hapus data";
        $indctr = "1";     
        DB::commit();
        return response()->json([
          "msg" => $msg,
          'indctr' => $indctr,
          "id_customer" => $id_customer]);
        } catch(Exception $ex){
          DB::rollback();
          
          # INSERT LOGS ERROR
          $log_keterangan = "GISMobileController.error: Hapus Customer Error. Kode: " .$id_customer. ". Error System: ".$ex->getMessage();
          return response()->json(["status" => 0, "msg" => $ex->getMessage()]);
        }  
      }
      
      public function produk(){
        $data['title'] = 'PRODUK';
        $data['judul'] = ' Produk';
        
        Session::flash("flash_notification", [
          "level" => "warning",
          "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
        ]);
        
        return view("produk.index_produk")->with($data);
      }
      
      public function produk__dt(){
        $data = DB::table(DB::raw("(SELECT * FROM produk order by id_produk asc) v"));
        return Datatables::of($data)
        ->addColumn("action", function($row){
          return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
          no-trans="'. $row->id_produk .'" title="Edit Data"
          onclick="edit(\''. $row->id_produk .'\',\''. $row->id_produk .'\',\''. $row->no_produk .'\')">
          <span class="glyphicon glyphicon-edit"></span></button>
          
          <button type="button"  class="btn-delete btn btn-danger delete-row btn-sm custom-icon-danger" title="Hapus Data"
          no-trans="'. $row->id_produk .'" 
          onclick="hapus(\''. $row->id_produk .'\')">
          <span class="glyphicon glyphicon-trash"></span></button></center>';;
          
        })
        ->make(true);
      }
      
      public function produk__store(Request $request){
        try {
          DB::beginTransaction();
          $caritrak2 = DB::table(DB::raw("(SELECT * FROM produk where id_produk = '$request->id_produk') v"))
          ->get();
          if ($caritrak2->count() > 0){
            $edit = DB::table('produk')
            ->whereRaw("id_produk = '$request->id_produk'")
            ->update([
              'nama_produk' => $request->nama_produk,
              'no_produk' => $request->no_produk]);
              
              $msg = "Berhasil Update Data";
              $nummer = 1;
              
              $log_keterangan = "GISMobileController.scansp: Edit Produk Berhasil. Kode: " .$request->id_produk;
            } else {
              $insert = DB::table('produk')
              ->insert(['id_produk' => $request->id_produk,
              'nama_produk' => $request->nama_produk,
              'no_produk' => $request->no_produk]);
              
              $msg = "Berhasil Submit Data";
              $nummer = 1;
              
              $log_keterangan = "GISMobileController.scansp: Input Produk Berhasil. Kode: " .$request->id_produk;
            }
            DB::commit();
            return response()->json(['nummer' => $nummer, 'mes' => $msg, 'id_produk' => $request->id_produk]);
          } catch (Exception $ex) {
            DB::rollback();
            
            # INSERT LOGS ERROR
            $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$request->id_produk.". Error System: ".$ex->getMessage();
            
            $msg = "terjadi kesalahan pada :".$ex->getMessage();
            return response()->json(['nummer' => 0, 'mes' => $msg]);
          }
        }
        
        public function produk__delete(Request $request, $id_produk){
          try{
            DB::beginTransaction();
            $id_produk = base64_decode($id_produk);
            DB::delete('delete from produk where id_produk = :id_produk' ,['id_produk' => $id_produk]);
            $msg = "Sukses hapus data";
            $indctr = "1";     
            DB::commit();
            return response()->json([
              "msg" => $msg,
              'indctr' => $indctr,
              "id_produk" => $id_produk]);
            } catch(Exception $ex){
              DB::rollback();
              
              # INSERT LOGS ERROR
              $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$id_produk. ". Error System: ".$ex->getMessage();
              return response()->json(["status" => 0, "msg" => $ex->getMessage()]);
            }  
          }
          
          public function masuk(){
            $data['title'] = 'Inventory Finish Good';
            $data['judul'] = ' Inventory Finish Good';
            
            $masuk = new GISMobile();
            
            $data['gudang'] = $masuk->getGudang();
            $data['produk'] = $masuk->getProduk();
            $data['customer'] = $masuk->getCustomer();
            
            Session::flash("flash_notification", [
              "level" => "warning",
              "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
            ]);
            
            return view("masuk.index_masuk")->with($data);
          }
          
          public function masuk__dt(Request $request, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer){
            $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
            $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
            $id_gudang = base64_decode($id_gudang);
            $produk = base64_decode($produk);
            $id_customer = base64_decode($id_customer);
            if($id_gudang == "null"){
              $kd_gudang = " ";
            } else{
              $kd_gudang = "and id_gudang = '$id_gudang'";
            }
            
            if($produk == "null"){
              $kd_produk = "";
            } else{
              $kd_produk = "and id_produk = '$produk'";
            }
            
            if($id_customer == "null"){
              $kd_customer = "";
            } else{
              $kd_customer = "and id_cust = '$id_customer'";
            }
            
            $data = DB::table(DB::raw("(SELECT * FROM inventory
            where DATE_FORMAT(tgl_produksi, '%Y%m%d') >= $tglawal
            and DATE_FORMAT(tgl_produksi, '%  Y%m%d') <= $tglakhir
            $kd_gudang
            $kd_produk
            $kd_customer
            and qty > 0)v"));
            return Datatables::of($data)
            ->addColumn("action", function($row){
              return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
              no-trans="'. $row->kd_trans .'" title="Edit Data"
              onclick="edit(\''. $row->kd_trans .'\')">
              <span class="glyphicon glyphicon-edit"></span></button>
              
              <button type="button"  class="btn-delete btn btn-danger delete-row btn-sm custom-icon-danger" title="Hapus Data"
              no-trans="'. $row->kd_trans .'" 
              onclick="hapus(\''. $row->kd_trans .'\')">
              <span class="glyphicon glyphicon-trash"></span></button>
              
              <button type="button" class="btn-pdf btn btn-success btn-sm custom-icon-success" style="margin-top:10px;"
              no-trans="'. $row->kd_trans .'" title="Print Surat"
              onclick="print_pdf(\''. $row->kd_trans .'\')">
              <span>Print Surat</span></button></center>';
              
            })
            ->make(true);
          }
          
          public function invoice__popup_produk(){
            $data = DB::table(DB::raw("(SELECT * FROM produk
            ORDER BY 1)v"));
            return Datatables::of($data)
            ->addIndexColumn()
            ->make(true);
            
            return response()->json([
              'msg' => 'Popup berhasil',
            ]); 
          }
          
          public function invoice__gen_supp(Request $request){
            if($request->ajax()){
              $inv = DB::table(DB::raw("(SELECT * FROM inventory
              WHERE kd_trans = '$request->kd_trans' ORDER BY 1) v"))
              ->get();
              $msg = "Data dapat di insert";
              $indctr = 1;
              
              return response()->json([
                'msg' => $msg, 
                'indctr' => $indctr,
                'inv' => $inv,
              ]);
            }
          }
          
          
          public function masuk__store(Request $request){
            $tahun = Carbon::parse($request->tgl_produksi)->format('Y');
            $bulan = Carbon::parse($request->tgl_produksi)->format('m');
            try {
              DB::beginTransaction();
              $caritrak2 = DB::table(DB::raw("(SELECT * FROM inventory where kd_trans = '$request->kd_trans') v"))
              ->get();
              if ($caritrak2->count() > 0){
                $nm_gudang = DB::table(DB::raw("(SELECT nama_gudang FROM gudang where id_gudang = '$request->gudang')v"))
                ->value('nama_gudang');
                $nm_cust = DB::table(DB::raw("(SELECT nama_customer FROM customer where id_customer = '$request->customer')v"))
                ->value('nama_customer');
                $edit = DB::table('inventory')
                ->whereRaw("kd_trans = '$request->kd_trans'")
                ->update([
                  'tgl_produksi' => $request->tgl_produksi,
                  'id_gudang' => $request->gudang,
                  'nama_gudang' => $nm_gudang,
                  'id_cust' => $request->customer,
                  'nama_customer' => $nm_cust,
                  'id_produk' => $request->id_produk,
                  'no_produk' => $request->no_produk,
                  'nama_produk' => $request->nama_produk,
                  'qty' => $request->qty]);
                  
                  $msg = "Berhasil Update Data";
                  $nummer = 1;
                  
                  $log_keterangan = "GISMobileController.scansp: Edit Produk Berhasil. Kode: " .$request->id_produk;
                } else {
                  $nm_gudang = DB::table(DB::raw("(SELECT nama_gudang FROM gudang where id_gudang = '$request->gudang')v"))
                  ->value('nama_gudang');
                  $nm_cust = DB::table(DB::raw("(SELECT nama_customer FROM customer where id_customer = '$request->customer')v"))
                  ->value('nama_customer');
                  
                  $cari = DB::table(DB::raw("(SELECT MAX(SUBSTR(kd_trans,1,4)) ID FROM inventory where 
                  DATE_FORMAT(tgl_produksi, '%Y') = '$tahun'
                  and DATE_FORMAT(tgl_produksi, '%m') = '$bulan') v"))
                  ->value('ID');
                  $kd_trans = intval($cari) + 1;
                  $no_trans = sprintf('%04d', $kd_trans) . "/NIJU/" . $tahun . "/" . $bulan;
                  $insert = DB::table('inventory')
                  ->insert(['kd_trans' => $no_trans,
                  'tgl_produksi' => $request->tgl_produksi,
                  'id_gudang' => $request->gudang,
                  'nama_gudang' => $nm_gudang,
                  'id_cust' => $request->customer,
                  'nama_customer' => $nm_cust,
                  'id_produk' => $request->id_produk,
                  'no_produk' => $request->no_produk,
                  'nama_produk' => $request->nama_produk,
                  'qty' => $request->qty]);
                  
                  $msg = "Berhasil Submit Data";
                  $nummer = 1;
                  
                  $log_keterangan = "GISMobileController.scansp: Input Berhasil. Kode: " .$no_trans;
                }
                DB::commit();
                return response()->json(['nummer' => $nummer, 'mes' => $msg, 'id_produk' => $request->id_produk]);
              } catch (Exception $ex) {
                DB::rollback();
                
                # INSERT LOGS ERROR
                $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$request->id_produk.". Error System: ".$ex->getMessage();
                
                $msg = "terjadi kesalahan pada :".$ex->getMessage();
                return response()->json(['nummer' => 0, 'mes' => $msg]);
              }
            }
            
            public function  masuk__delete(Request $request, $kd_trans){
              try{
                DB::beginTransaction();
                $kd_trans = base64_decode($kd_trans);
                DB::delete('delete from inventory where kd_trans = :kd_trans' ,['kd_trans' => $kd_trans]);
                $msg = "Sukses hapus data";
                $indctr = "1";     
                DB::commit();
                return response()->json([
                  "msg" => $msg,
                  'indctr' => $indctr,
                  "kd_trans" => $kd_trans]);
                } catch(Exception $ex){
                  DB::rollback();
                  
                  # INSERT LOGS ERROR
                  $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$id_produk. ". Error System: ".$ex->getMessage();
                  return response()->json(["status" => 0, "msg" => $ex->getMessage()]);
                }  
              }

              public function masuk__print(Request $request, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer){
                $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
                $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
                $id_gudang = base64_decode($id_gudang);
                $produk = base64_decode($produk);
                $id_customer = base64_decode($id_customer);


                if($id_gudang == "null"){
                  $kd_gudang = " ";
                } else{
                  $kd_gudang = "and id_gudang = '$id_gudang'";
                }
                
                if($produk == "null"){
                  $kd_produk = "";
                } else{
                  $kd_produk = "and id_produk = '$produk'";
                }
                
                if($id_customer == "null"){
                  $kd_customer = "";
                } else{
                  $kd_customer = "and id_cust = '$id_customer'";
                }
                
                $data = DB::table(DB::raw("(SELECT * FROM inventory
                where DATE_FORMAT(tgl_produksi, '%Y%m%d') >= $tglawal
                and DATE_FORMAT(tgl_produksi, '%  Y%m%d') <= $tglakhir
                $kd_gudang
                $kd_produk
                $kd_customer
                and qty > 0)v"))
                ->get();
                
                error_reporting(E_ALL * ~E_NOTICE & ~E_WARNING);
                ob_end_clean();
                ob_start();
                
                Excel::create('INVENTORY_FINISH_GOODS', function($excel) use ($data, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer) {
                    $excel->sheet('Excel sheet', function($sheet) use ($data, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer) {
                        $sheet->loadView('masuk.print_masuk')->with(compact(['data', 'tglawal', 'tglakhir', 'id_gudang', 'produk', 'id_customer']));
                        $sheet->setOrientation('landscape');
                        $sheet->setWidth('A', 6)->getStyle('A')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('B', 20)->getStyle('B')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('C', 20)->getStyle('C')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('D', 20)->getStyle('D')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('E', 20)->getStyle('E')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('F', 20)->getStyle('F')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('G', 20)->getStyle('G')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('H', 20)->getStyle('H')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('I', 20)->getStyle('I')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('J', 20)->getStyle('J')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('K', 20)->getStyle('K')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('L', 20)->getStyle('L')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('M', 20)->getStyle('M')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('N', 20)->getStyle('N')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('O', 20)->getStyle('O')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('P', 20)->getStyle('P')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('Q', 20)->getStyle('Q')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('R', 20)->getStyle('R')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('S', 20)->getStyle('S')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('T', 20)->getStyle('T')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('U', 20)->getStyle('U')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('V', 20)->getStyle('V')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('W', 20)->getStyle('W')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('X', 20)->getStyle('X')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('Y', 20)->getStyle('Y')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('Z', 20)->getStyle('Z')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AA',20)->getStyle('AA')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AB',20)->getStyle('AB')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AC',20)->getStyle('AC')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AD',20)->getStyle('AD')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AE',20)->getStyle('AE')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AF',20)->getStyle('AF')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AG',20)->getStyle('AG')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AH',20)->getStyle('AH')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AI',20)->getStyle('AI')->getAlignment()->setWrapText(true);
                        $sheet->setWidth('AJ',20)->getStyle('AJ')->getAlignment()->setWrapText(true);
                    });
                })->export('xls');
            }

            public function masuk__pdf(Request $request, $kd_trans){
              try { 
                $kd_trans = base64_decode($kd_trans);
                
                DB::beginTransaction();
                
                $master = DB::table(DB::raw("(SELECT * FROM inventory
                WHERE kd_trans = '$kd_trans' and qty > 0
                ) v"))
                ->get();

                $no_doc = DB::table(DB::raw("(SELECT * FROM inventory
                WHERE kd_trans = '$kd_trans' and qty > 0
                ) v"))
                ->first();

                $qr_code_1 = "data:image/png;base64," . DNS2D::getBarcodePNG($no_doc, 'QRCODE');
                
                // - Fungsi Print - //
                $error_level = error_reporting();
                error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
                ob_end_clean();
                ob_start();
                $pdf = PDF::loadview('masuk.pdf_masuk', compact('master', 'qr_code_1'))->setPaper('a4', 'portrait');
                
                return $pdf->download('Out_Going.pdf'); 
                // return view('surat.print_surat', compact('master'));
                
            }catch (Exception $ex) {
                DB::rollback();
                $msg = "Kesalahan Pada :<br>".$ex;
                $indctr = "0";
                return response()->json(['msg' => $msg, 'indctr' => $indctr]);
            }
          }
              
              public function keluar(){
                $data['title'] = 'Delivery Finish Good';
                $data['judul'] = ' Delivery Finish Good';
                
                $masuk = new GISMobile();
                
                $data['gudang'] = $masuk->getGudang();
                $data['produk'] = $masuk->getProduk();
                $data['customer'] = $masuk->getCustomer();
                
                Session::flash("flash_notification", [
                  "level" => "warning",
                  "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
                ]);
                
                return view("keluar.index_keluar")->with($data);
              }
              
              public function keluar__dt(Request $request, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer){
                $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
                $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
                $id_gudang = base64_decode($id_gudang);
                $produk = base64_decode($produk);
                $id_customer = base64_decode($id_customer);
                if($id_gudang == "null"){
                  $kd_gudang = " ";
                } else{
                  $kd_gudang = "and id_gudang = '$id_gudang'";
                }
                
                if($produk == "null"){
                  $kd_produk = "";
                } else{
                  $kd_produk = "and id_produk = '$produk'";
                }
                
                if($id_customer == "null"){
                  $kd_customer = "";
                } else{
                  $kd_customer = "and id_cust = '$id_customer'";
                }
                
                $data = DB::table(DB::raw("(SELECT * FROM inventory
                where DATE_FORMAT(tgl_produksi, '%Y%m%d') >= $tglawal
                and DATE_FORMAT(tgl_produksi, '%  Y%m%d') <= $tglakhir
                $kd_gudang
                $kd_produk
                $kd_customer
                and qty_kirim > 0)v"));
                return Datatables::of($data)
                ->addColumn("action", function($row){
                  return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
                  no-trans="'. $row->kd_trans .'" title="Edit Data"
                  onclick="edit(\''. $row->kd_trans .'\',\''. $row->no_kirim .'\')">
                  <span class="glyphicon glyphicon-edit"></span></button>
                  
                  <button type="button"  class="btn-delete btn btn-danger delete-row btn-sm custom-icon-danger" title="Hapus Data"
                  no-trans="'. $row->no_kirim .'" 
                  onclick="hapus(\''. $row->no_kirim .'\')">
                  <span class="glyphicon glyphicon-trash"></span></button></center>';;
                  
                })
                ->make(true);
              }
              
              public function keluar__gen_supp(Request $request){
                if($request->ajax()){
                  $cari = DB::table(DB::raw("(SELECT * FROM inventory
                  WHERE kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim' ORDER BY 1) v"))
                  ->first();
                  
                  if($cari !== null){
                    $inv = DB::table(DB::raw("(SELECT * FROM inventory
                    WHERE kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim' ORDER BY 1) v"))
                    ->get();
                    $msg = "Data dapat di edit";
                    $indctr = 2;
                  }else {
                    $inv = DB::table(DB::raw("(SELECT * FROM inventory
                    WHERE kd_trans = '$request->kd_trans' and qty >= 0 and no_kirim is null ORDER BY 1) v"))
                    ->get();
                    $msg = "Data dapat di insert";
                    $indctr = 1;
                  }
                  
                  
                  return response()->json([
                    'msg' => $msg, 
                    'indctr' => $indctr,
                    'inv' => $inv,
                  ]);
                }
              }

              public function keluar__gen_qty(Request $request){
                if($request->ajax()){
                 
                    $inv = DB::table(DB::raw("(SELECT * FROM inventory
                    WHERE kd_trans = '$request->kd_trans' and qty >= 0 and no_kirim is null ORDER BY 1) v"))
                    ->get();
                    $msg = "Data dapat di insert";
                    $indctr = 1;
                  
                  
                  return response()->json([
                    'msg' => $msg, 
                    'indctr' => $indctr,
                    'inv' => $inv,
                  ]);
                }
              }
              
              public function keluar__store(Request $request){
                $tahun = Carbon::parse($request->tgl_kirim)->format('Y');
                $bulan = Carbon::parse($request->tgl_kirim)->format('m');
                try {
                  DB::beginTransaction();
                  $caritrak2 = DB::table(DB::raw("(SELECT * FROM inventory where kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim') v"))
                  ->get();
                  if ($caritrak2->count() > 0){
                    $qty = DB::table(DB::raw("(SELECT qty FROM inventory where kd_trans = '$request->kd_trans')v"))
                    ->value('qty');
                    
                    // if($request->qty_kirim > $qty){
                    //   $msg = "Tidak Dapat Update Data";
                    //   $nummer = 2;
                    // }else{
                      $kirim = DB::table(DB::raw("(SELECT * FROM inventory where kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim')v"))
                      ->first();
                      
                      if($request->qty_kirim > $kirim->qty_kirim){
                        $hasil = $request->qty_kirim - $kirim->qty_kirim;
                        $hasil1 = $qty - $hasil;
                        
                        $edit = DB::table('inventory')
                        ->whereRaw("kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim'")
                        ->update([
                          'qty_kirim' => $request->qty_kirim]);
                          
                          $edit = DB::table('inventory')
                          ->whereRaw("kd_trans = '$request->kd_trans' and no_kirim is null")
                          ->update([
                            'qty' => $hasil1]);
                          } else{
                            $hasil = $kirim->qty_kirim - $request->qty_kirim;
                            $hasil1 = $qty + $hasil;
                            
                            $edit = DB::table('inventory')
                            ->whereRaw("kd_trans = '$request->kd_trans' and no_kirim = '$request->no_kirim'")
                            ->update([
                              'qty_kirim' => $request->qty_kirim]);
                              
                              $edit = DB::table('inventory')
                              ->whereRaw("kd_trans = '$request->kd_trans' and no_kirim is null")
                              ->update([
                                'qty' => $hasil1]);
                              }
                              
                              $msg = "Berhasil Update Data";
                              $nummer = 1;
                              
                              $log_keterangan = "GISMobileController.scansp: Edit Produk Berhasil. Kode: " .$request->kd_trans;
                          } else{
                            $qty = DB::table(DB::raw("(SELECT qty FROM inventory where kd_trans = '$request->kd_trans' and no_kirim is null)v"))
                            ->value('qty');

                            if($request->qty_kirim > $qty){
                              $msg = "Tidak Dapat Update Data";
                              $nummer = 2;
                            }else{
                              $kirim = DB::table(DB::raw("(SELECT * FROM inventory where kd_trans = '$request->kd_trans' and no_kirim is null)v"))
                              ->first();
                              
                              $cari = DB::table(DB::raw("(SELECT MAX(SUBSTR(no_kirim,1,4)) ID FROM inventory where 
                              DATE_FORMAT(tgl_kirim, '%Y') = '$tahun'
                              and DATE_FORMAT(tgl_kirim, '%m') = '$bulan') v"))
                              ->value('ID');
                              $kd_kirim = intval($cari) + 1;
                              $no_kirim = sprintf('%04d', $kd_kirim) . "/NIJU/" . "/DS/" . $tahun . "/" . $bulan;
                              $insert = DB::table('inventory')
                              ->insert(['kd_trans' => $request->kd_trans,
                              'no_kirim' => $no_kirim,
                              'tgl_produksi' => $kirim->tgl_produksi,
                              'tgl_kirim' => $request->tgl_kirim,
                              'id_gudang' => $kirim->id_gudang,
                              'nama_gudang' => $kirim->nama_gudang,
                              'id_cust' => $kirim->id_cust,
                              'nama_customer' => $kirim->nama_customer,
                              'id_produk' => $kirim->id_produk,
                              'no_produk' => $kirim->no_produk,
                              'nama_produk' => $kirim->nama_produk,
                              'qty_kirim' => $request->qty_kirim]);

                              $hasil = $qty - $request->qty_kirim;

                              $edit = DB::table('inventory')
                              ->whereRaw("kd_trans = '$request->kd_trans' and no_kirim is null")
                              ->update([
                                'qty' => $hasil]);
                              
                              $msg = "Berhasil Submit Data";
                              $nummer = 1;
                              
                              $log_keterangan = "GISMobileController.scansp: Input Berhasil. Kode: " .$no_kirim;
                            }
                          }
                          DB::commit();
                          return response()->json(['nummer' => $nummer, 'mes' => $msg, 'id_produk' => $request->id_produk]);
                        } catch (Exception $ex) {
                          DB::rollback();
                          
                          # INSERT LOGS ERROR
                          $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$request->id_produk.". Error System: ".$ex->getMessage();
                          
                          $msg = "terjadi kesalahan pada :".$ex->getMessage();
                          return response()->json(['nummer' => 0, 'mes' => $msg]);
                        }
                      }

                      public function  keluar__delete(Request $request, $no_kirim){
                        try{
                          DB::beginTransaction();
                          $no_kirim = base64_decode($no_kirim);
                          DB::delete('delete from inventory where no_kirim = :no_kirim' ,['no_kirim' => $no_kirim]);
                          $msg = "Sukses hapus data";
                          $indctr = "1";     
                          DB::commit();
                          return response()->json([
                            "msg" => $msg,
                            'indctr' => $indctr,
                            "no_kirim" => $no_kirim]);
                          } catch(Exception $ex){
                            DB::rollback();
                            
                            # INSERT LOGS ERROR
                            $log_keterangan = "GISMobileController.error: Create Produk Error. Kode: " .$no_kirim. ". Error System: ".$ex->getMessage();
                            return response()->json(["status" => 0, "msg" => $ex->getMessage()]);
                          }  
                        }

                        public function keluar__print(Request $request, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer){
                          $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
                          $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
                          $id_gudang = base64_decode($id_gudang);
                          $produk = base64_decode($produk);
                          $id_customer = base64_decode($id_customer);
          
          
                          if($id_gudang == "null"){
                            $kd_gudang = " ";
                          } else{
                            $kd_gudang = "and id_gudang = '$id_gudang'";
                          }
                          
                          if($produk == "null"){
                            $kd_produk = "";
                          } else{
                            $kd_produk = "and id_produk = '$produk'";
                          }
                          
                          if($id_customer == "null"){
                            $kd_customer = "";
                          } else{
                            $kd_customer = "and id_cust = '$id_customer'";
                          }
                          
                          $data = DB::table(DB::raw("(SELECT * FROM inventory
                          where DATE_FORMAT(tgl_produksi, '%Y%m%d') >= $tglawal
                          and DATE_FORMAT(tgl_produksi, '%  Y%m%d') <= $tglakhir
                          $kd_gudang
                          $kd_produk
                          $kd_customer
                          and qty_kirim > 0)v"))
                          ->get();
                          
                          error_reporting(E_ALL * ~E_NOTICE & ~E_WARNING);
                          ob_end_clean();
                          ob_start();
                          
                          Excel::create('DELIVERY_FINISH_GOODS', function($excel) use ($data, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer) {
                              $excel->sheet('Excel sheet', function($sheet) use ($data, $tglawal, $tglakhir, $id_gudang, $produk, $id_customer) {
                                  $sheet->loadView('keluar.print_keluar')->with(compact(['data', 'tglawal', 'tglakhir', 'id_gudang', 'produk', 'id_customer']));
                                  $sheet->setOrientation('landscape');
                                  $sheet->setWidth('A', 6)->getStyle('A')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('B', 20)->getStyle('B')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('C', 20)->getStyle('C')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('D', 20)->getStyle('D')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('E', 20)->getStyle('E')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('F', 20)->getStyle('F')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('G', 20)->getStyle('G')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('H', 20)->getStyle('H')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('I', 20)->getStyle('I')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('J', 20)->getStyle('J')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('K', 20)->getStyle('K')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('L', 20)->getStyle('L')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('M', 20)->getStyle('M')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('N', 20)->getStyle('N')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('O', 20)->getStyle('O')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('P', 20)->getStyle('P')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('Q', 20)->getStyle('Q')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('R', 20)->getStyle('R')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('S', 20)->getStyle('S')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('T', 20)->getStyle('T')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('U', 20)->getStyle('U')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('V', 20)->getStyle('V')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('W', 20)->getStyle('W')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('X', 20)->getStyle('X')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('Y', 20)->getStyle('Y')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('Z', 20)->getStyle('Z')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AA',20)->getStyle('AA')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AB',20)->getStyle('AB')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AC',20)->getStyle('AC')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AD',20)->getStyle('AD')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AE',20)->getStyle('AE')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AF',20)->getStyle('AF')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AG',20)->getStyle('AG')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AH',20)->getStyle('AH')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AI',20)->getStyle('AI')->getAlignment()->setWrapText(true);
                                  $sheet->setWidth('AJ',20)->getStyle('AJ')->getAlignment()->setWrapText(true);
                              });
                          })->export('xls');
                      }
                      
                        public function surat(){
                          $data['title'] = 'Surat Jalan';
                          $data['judul'] = ' Surat Jalan';
                          
                          $masuk = new GISMobile();
                          $data['produk'] = $masuk->getProduk();
                          
                          Session::flash("flash_notification", [
                            "level" => "warning",
                            "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
                          ]);
                          
                          return view("surat.index_surat")->with($data);
                        }

                        public function surat__dt(Request $request, $tglawal, $tglakhir, $produk){
                          $tglawal = Carbon::parse(base64_decode($tglawal))->format('Ymd');
                          $tglakhir = Carbon::parse(base64_decode($tglakhir))->format('Ymd');
                          $produk = base64_decode($produk);

                          if($produk == "null"){
                            $kd_produk = "";
                          } else{
                            $kd_produk = "and id_produk = '$produk'";
                          }
                          
                          $data = DB::table(DB::raw("(SELECT * FROM surat
                          where DATE_FORMAT(tgl, '%Y%m%d') >= $tglawal
                          and DATE_FORMAT(tgl, '%  Y%m%d') <= $tglakhir
                          $kd_produk)v"));
                          return Datatables::of($data)
                          ->addColumn("action", function($row){
                            return '<center><button type="button" class="btn-edit btn btn-success btn-sm custom-icon-success" 
                            no-trans="'. $row->no_surat .'" title="Print Surat"
                            onclick="print_excel(\''. $row->no_surat .'\')">
                            <span>Print Surat</span></button>';
                            
                          })
                          ->make(true);
                        }

                        public function input_surat(){
                          $data['title'] = 'Input Surat Jalan';
                          $data['judul'] = ' Input Surat Jalan';
                          
                          $masuk = new GISMobile();
                          $data['customer'] = $masuk->getCustomer();
                          
                          Session::flash("flash_notification", [
                            "level" => "warning",
                            "message_scan" => "Perhatian!<br>Tekan tombol panah diatas untuk kembali ke form scan."
                          ]);
                          
                          return view("surat.input_surat")->with($data);
                        }

                        public function popup_surat(){
                          $data = DB::table(DB::raw("(SELECT * FROM inventory
                          where no_kirim is not null and qty_kirim > 0
                          ORDER BY 1)v"));
                          return Datatables::of($data)
                          ->addIndexColumn()
                          ->make(true);
                          
                          return response()->json([
                            'msg' => 'Popup berhasil',
                          ]); 
                        }

                        public function surat_store(Request $request){
                          $data = $request->all();
                          try {
                               DB::beginTransaction();
                              
                              $user = substr(Auth::User()->username,0,6);
                              $datecrea = Carbon::now();
                              
                              $no_kirim = $data['no_kirim'];
                              
                              # CEK INSERT ATAU UPDATE
                              $cekdata = DB::table(DB::raw("(SELECT * FROM surat
                              WHERE  kd_trans = '$no_kirim') v"))
                              ->get();
                              
                              if ($cekdata->count()>0){
                                      $kirim = DB::table(DB::raw("(SELECT * FROM surat
                                      WHERE  kd_trans = '$no_kirim') v"))
                                      ->first();

                                      $row_mst = ['no_surat' => $kirim->no_surat,
                                      'no_po' => $kirim->no_po,
                                      'id_cust' => $kirim->nama_cust,
                                      'id_produk' => $kirim->id_produk,
                                      'nama_produk' => $kirim->nama_produk,
                                      'no_produk' => $kirim->no_produk,
                                      'kd_trans' => $kirim->kd_trans,
                                      'qty_kirim' => $kirim->qty_kirim,
                                      'tgl_kirim' => $kirim->tgl_kirim,];
                                      
                                      # UPDATE LHP SUPP MASTER
                                      $lhp_mst = DB::table("surat")
                                      ->where('kd_trans', $no_kirim)
                                      ->update($row_mst);
                                      
                                      $msg = "Berhasil Submit Data";
                                      $nummer = 1;

                                  } else {
                                      
                                      //INSERT LHP SUPP DETAIL
                                      foreach ($no_kirim as $key => $value){
                                            $kirim = DB::table(DB::raw("(SELECT * FROM inventory
                                          WHERE  no_kirim = '$no_kirim[$key]') v"))
                                          ->first();

                                              $row_coil = ['no_oc' => $no_oc,
                                              'mpt_dim_t' => $t[$key],
                                              'mpt_dim_w' => $w[$key],
                                              'mpt_code' => $kd_brg[$key],
                                              'tgl_delivery' => $tanggal[$key],
                                              'no_coil' => $no_coil[$key],
                                              'nama_kapal' => $nama_kapal[$key],
                                              'berat' => $weight[$key],
                                              'catatan' => $catatan1[$key]];
                                              
                                              $lhp_det = DB::table("surat")
                                              ->whereRaw("OC_COIL = '$no_oc' AND NO_COIL = '$no_coil[$key]'")
                                              ->insert($row_coil);
                                  }
                                  $msg = "Berhasil Submit Data";
                                  $nummer = 1;
                                }
                                  
                                  # INSERT LOGS
                                  $log_ip = \Request::session()->get('client_ip');
                                  $created_at = Carbon::now();
                                  $updated_at = Carbon::now();
                                  $logs = DB::table("logs")->insert(['user_id' => Auth::user()->id, 
                                  'keterangan' => $log_keterangan, 'ip' => $log_ip, 
                                  'created_at' => $created_at, 'updated_at' => $updated_at]);  
                                  
                                  DB::commit();
                                  
                                  return response()->json(['indctr' => $indctr, 'msg' => $msg]);
                          } catch (Exception $ex) {
                              DB::rollback();
                              
                              # INSERT LOGS ERROR
                              $log_keterangan = "WhsVendorController.error: Create Cutting Order Error" 
                              .Auth::User()->id." - ".Auth::User()->username.". Error System: ".$ex->getMessage();
                              $log_ip = \Request::session()->get('client_ip');
                              $created_at = Carbon::now();
                              $updated_at = Carbon::now();
                              $logs = DB::table("logs")->insert(['user_id' => Auth::user()->id, 
                              'keterangan' => $log_keterangan, 'ip' => $log_ip, 
                              'created_at' => $created_at, 'updated_at' => $updated_at]);
                              
                              $msg = "terjadi kesalahan pada :".$ex->getMessage();
                              return response()->json(['indctr' => 0, 'msg' => $msg]);
                          }  
                      }

                      public function surat_save(Request $request){
                        $data = $request->all();
                        $no_kirim = $data['no_kirim'];
                        $kendaraan = $data['kendaraan'];
                        $qty_kirim = $data['qty_kirim'];
                        $nama_produk = $data['nama_produk'];
                                try {   
                                    if (isset($no_kirim)) {
                                        foreach ($no_kirim as $key => $value){
                                            $data_reg = DB::table("inventory")
                                            ->where('no_kirim', $no_kirim[$key])
                                            ->first();

                                            $cari = DB::table(DB::raw("(SELECT MAX(SUBSTR(no_kirim,1,4)) ID FROM surat) v"))
                                            ->value('ID');
                                            $kd_trans = intval($cari) + 1;
                                            $no_surat = sprintf('%04d', $kd_trans) . "/NIJU/"  . "Surat";
                                            $no_po = sprintf('%04d', $kd_trans) . "/NIJU/"  . "PO";


                                                DB::table("surat")
                                                ->insert([
                                                    'no_po' => $no_po,
                                                    'no_surat' => $no_surat,
                                                    'kendaraan' => $kendaraan, 
                                                    'nama_produk' => $nama_produk[$key], 
                                                    'no_kirim' => $no_kirim[$key], 
                                                    'qty_kirim' => $qty_kirim[$key],
                                                    'tgl' => Carbon::now(),
                                                ]); 
                                        }
                                        $msg = "Berhasil Submit Data";
                                  $nummer = 1;
                                    }
                                    
                                    
                                    DB::commit();
                                    
                              return response()->json(['nummer' => $nummer, 'msg' => $msg]);
                                    
                                } catch (Exception $ex) {
                                  DB::rollback();
                                  
                                  # INSERT LOGS ERROR
                                  $log_keterangan = "GISMobileController.error: Create Produk Error. Error System: ".$ex->getMessage();
                                  
                                  $msg = "terjadi kesalahan pada :".$ex->getMessage();
                                  return response()->json(['nummer' => 0, 'msg' => $msg]);
                                }
                    }

                    public function surat__print(Request $request, $no_surat){
                      try { 
                        $no_surat = base64_decode($no_surat);
                        
                        DB::beginTransaction();
                        
                        $master = DB::table(DB::raw("(SELECT * FROM surat
                        WHERE no_surat = '$no_surat'
                        ) v"))
                        ->get();
                        
                        // - Fungsi Print - //
                        $error_level = error_reporting();
                        error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING); 
                        ob_end_clean();
                        ob_start();
                        $pdf = PDF::loadview('surat.print_surat', compact('master'))->setPaper('a4', 'landscape');
                        
                        return $pdf->download('Surat_Jalan.pdf'); 
                        // return view('surat.print_surat', compact('master'));
                        
                    }catch (Exception $ex) {
                        DB::rollback();
                        $msg = "Kesalahan Pada :<br>".$ex;
                        $indctr = "0";
                        return response()->json(['msg' => $msg, 'indctr' => $indctr]);
                    }
                  }
                    }
                    
                    