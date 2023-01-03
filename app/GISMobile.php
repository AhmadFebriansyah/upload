<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Carbon\Carbon;

class GISMobile extends Model
{
    # RYAN START #
    
    public function getPeriode(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_SFC1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }
    
    
    public function get_qty_stock_by_notag($no_tag){
        if (config('app.env', 'local') === 'production') {
            $tglawal = Carbon::now()->startOfYear()->format("Ymd");
            $tgl_akhir = Carbon::now()->endOfYear()->format("Ymd");
        } else {
            $tglawal = "20210101";
            $tgl_akhir = "20211231";
        }
        $sisa = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(SELECT T1.NOMOR_RAK, T1.NO_TAG, T1.TGL_TAG, T1.KODE_PPC, T1.QTY, QTY - NVL(SUM(T2.QTY_BPB), 0) SISA FROM TAG_FG T1
        LEFT JOIN WHS_FG_SCAN T2 ON T1.NO_TAG = T2.NO_TAG
        WHERE T1.NO_TAG = '$no_tag'
        AND TO_CHAR(T1.TGL_TAG, 'YYYYMM') >= '$tglawal'
        AND TO_CHAR(T1.TGL_TAG, 'YYYYMM') <= '$tgl_akhir'
        GROUP BY T1.NOMOR_RAK, T1.NO_TAG, T1.KODE_PPC, T1.QTY, T1.TGL_TAG) X"))
        ->select(DB::raw("NVL(SISA, 0) SISA"))
        ->whereRaw("SISA > 0")
        ->orderByRaw("TGL_TAG DESC")
        ->value("SISA");
        
        return $sisa;
    }
    
    #Supply Produksi
    public function getPeriode2(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_BPB1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }
    
    public function getUserSite($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE AS KD_GUDANG 
            FROM MWHS_GUDANG 
            WHERE KD_SUPP = '$user_str') v"))
            ->value('KD_GUDANG');
        } else if ($user = '07170'){
            $data = '001';
        } else if ($user = '13986' || $user = '12317' || $user = '12752'){
            $data = '001';
        } else {
            $data = '041';
        }
        
        return $data;
    }
    
    public function getWhsAll2(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
        FROM MWHS_GUDANG WHERE KODE = '001'
        OR KODE ='002' ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    public function getWhs($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG
            WHERE KD_SUPP = '$user_str'
            AND (KODE = '001' OR KODE ='002')
            ORDER BY 1,2) v"))
            ->get();
        } else {
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG WHERE KODE = '001'
            OR KODE ='002' ORDER BY 1,2) v"))
            ->get();
        }
        
        return $data;
    }
    
    public function getGudang(){
    $data = DB::table(DB::raw("(SELECT * FROM gudang) v"))
    ->get();
    return $data;
    }

    public function getProduk(){
        $data = DB::table(DB::raw("(SELECT * FROM produk) v"))
        ->get();
        return $data;
    }

    public function getCustomer(){
        $data = DB::table(DB::raw("(SELECT * FROM customer) v"))
        ->get();
        return $data;
    }
    
    #STO MATERIAL
    public function getPeriode3(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_STO1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }
    
    public function getWhs2($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG
            WHERE KD_SUPP = '$user_str'
            ORDER BY 1,2) v"))
            ->get();
        } else {
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG ORDER BY 1,2) v"))
            ->get();
        }
        
        return $data;
    }
    
    public function getSite($npk){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT A.KODE_SITE, B.KD_PLANT, B.DESKRIPSI
        FROM USRHRCORP.V_MAS_KARYAWAN A, MST_PLANT B
        WHERE npk = '$npk'
        AND A.KODE_SITE = B.KD_SITE) v"))
        ->first();
        return $data;
    }
    
    public function ambilgudang_transfer(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
        FROM MWHS_GUDANG ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    public function kel_lap($tahun, $bulan, $site){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT KEL_LAP FROM VSTO_TRANSFER
        WHERE TAHUN||BULAN = '$tahun'||'$bulan'
        AND KD_GUDANG = '$site'
        AND KEL_LAP = '2D') v"))
        ->get();
        
        return $data;
    }
    
    public function getWhsUpload($user){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT A.KD_GUDANG, B.NAMA_GUDANG, B.KD_SUPP 
        FROM VSTO_TAG_LPB_SCAN1 A, MWHS_GUDANG B
        WHERE A.KD_GUDANG = B.KODE
        ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    
    # RYAN END #
    
    # JIMMI START #
    
    #DELIVERY FG
    
    public function gudang_deliveryfg($user) {
        $data =  DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DECODE(KODE_SITE,'GKDJ','001','GKDC','002') KD_GUDANG, 
        Fnm_GUDANG(DECODE(KODE_SITE,'GKDJ','001','GKDC','002')) NAMA_GUDANG
        FROM USRHRCORP.V_MAS_KARYAWAN 
        WHERE NPK = '$user') v"))
        ->first();
        
        return $data;
    }
    
    public function grup_deliveryfg($tahun, $bulan, $site) {
        $data =  DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT KD_GROUP MPT_GROUP, NM_GROUP NAMA_GROUP 
        FROM VMUTASI_TAG_FG
        WHERE THN_MUTASI||BLN_MUTASI = '$tahun'||'$bulan'
        AND KD_GUDANG = '$site') v"))
        ->get();
        
        return $data;
    }
    
    public function getUser_Site($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE AS KD_GUDANG 
            FROM MWHS_GUDANG 
            WHERE KD_SUPP = '$user_str') v"))
            ->value('KD_GUDANG');
        } else if ($user = '07170'){
            $data = '001';
        } else if ($user = '13986' || $user = '12317' || $user = '12752'){
            $data = '001';
        } else {
            $data = '041';
        }
        
        return $data;
    }
    
    public function getgudang_deliveryfg($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG
            WHERE KD_SUPP = '$user_str'
            ORDER BY 1,2) v"))
            ->get();
        } else {
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG ORDER BY 1,2) v"))
            ->get();
        }
        
        return $data;
    }
    
    
    #STO FG
    
    public function getPeriode_Stofg(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_STO1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }
    
    public function getSite_stofg($user){
        $data =  DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DECODE(KODE_SITE,'GKDJ','001','GKDC','002') KD_GUDANG, 
        Fnm_GUDANG(DECODE(KODE_SITE,'GKDJ','001','GKDC','002')) NAMA_GUDANG
        FROM USRHRCORP.V_MAS_KARYAWAN 
        WHERE NPK = '$user') v"))
        ->first();
        
        return $data;
    }
    
    public function getlayout_stofg($site){
        $data= DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE_LAYOUT, KETERANGAN 
        FROM   MWHS_GUDANG_LAYOUT
        WHERE  KODE_GUDANG IN ('WIP','FG')
        AND KODE = '$site'
        ORDER  BY 1,2) v"))
        ->get();
        return $data;
    }
    
    public function getarea_stofg($site, $layout){
        if($layout == 'ALL'){
            $query_layout = "";
        } else {
            $query_layout = " AND KODE_LAYOUT = '$layout' ";
        }
        $data= DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE_AREA, KETERANGAN NAMA_AREA
        FROM   MWHS_GUDANG_AREA
        WHERE  KODE = '$site'
        $query_layout
        ORDER  BY 1,2) v"))
        ->get();
        return $data;
    }
    
    public function getgroup_stofg($tahun, $bulan, $site, $layout, $area){
        if($layout == 'ALL'){
            $query_layout = "";
        } else {
            $query_layout = " AND KD_LAYOUT = '$layout' ";
        }
        
        if($area == 'ALL'){
            $query_area = "";
        } else {
            $query_area = " AND KD_AREA = '$area' ";
        }
        
        
        $data= DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT KD_GROUP, NM_GROUP FROM VSTO_TAG_FG_REKON_SCAN1
        WHERE  TAHUN = '$tahun'
        AND    BULAN = '$bulan'
        AND    KD_GUDANG = '$site'
        $query_layout
        $query_area
        AND    KD_DOK = 'FG') v"))
        ->get();
        
        return $data;
    }
    
    public function getUserSite_stofg($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE AS KD_GUDANG 
            FROM MWHS_GUDANG 
            WHERE KD_SUPP = '$user_str') v"))
            ->value('KD_GUDANG');
        } else if ($user = '07170'){
            $data = '001';
        } else if ($user = '13986' || $user = '12317' || $user = '12752'){
            $data = '001';
        } else {
            $data = '041';
        }
        
        return $data;
    }
    
    public function getgudang_stofg($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG
            WHERE KD_SUPP = '$user_str'
            ORDER BY 1,2) v"))
            ->get();
        } else {
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG ORDER BY 1,2) v"))
            ->get();
        }
        
        return $data;
    }
    
    public function ambilgudang_stofg(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
        FROM MWHS_GUDANG ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    
    #STO CONS
    
    public function getSite_stocons($user){
        $data =  DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DECODE(KODE_SITE,'GKDJ','001','GKDC','002') KD_GUDANG, 
        Fnm_GUDANG(DECODE(KODE_SITE,'GKDJ','001','GKDC','002')) NAMA_GUDANG
        FROM USRHRCORP.V_MAS_KARYAWAN 
        WHERE NPK = '$user') v"))
        ->first();
        
        return $data;
    }
    
    public function getPeriode_Stocons(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_STO1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }
    
    public function getUserSite_stocons($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE AS KD_GUDANG 
            FROM MWHS_GUDANG 
            WHERE KD_SUPP = '$user_str') v"))
            ->value('KD_GUDANG');
        } else if ($user = '07170'){
            $data = '001';
        } else if ($user = '13986' || $user = '12317' || $user = '12752'){
            $data = '001';
        } else {
            $data = '041';
        }
        
        return $data;
    }
    
    public function ambilgudang_stocons(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
        FROM MWHS_GUDANG ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    public function getgudang_stocons($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG
            WHERE KD_SUPP = '$user_str'
            ORDER BY 1,2) v"))
            ->get();
        } else {
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG, KD_SUPP
            FROM MWHS_GUDANG ORDER BY 1,2) v"))
            ->get();
        }
        
        return $data;
    }
    
    public function getlayout_stocons($site){
        $data= DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KETERANGAN||' / '||KODE_GUDANG KETERANGAN, KODE_LAYOUT 
        FROM   MWHS_GUDANG_LAYOUT
        WHERE  KODE = '$site'
        AND    NVL(FLAG_AKTIF,'F') = 'T'
        ORDER  BY 1,2) v"))
        ->get();
        return $data;
    }
    
    public function getarea_stocons($site, $layout){
        if($layout == 'ALL'){
            $query_layout = "";
        } else {
            $query_layout = " AND KODE_LAYOUT = '$layout' ";
        }
        $data= DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KETERANGAN, KODE_AREA
        FROM   MWHS_GUDANG_AREA
        WHERE  KODE        = '$site'
        $query_layout
        AND    NVL(FLAG_AKTIF,'F') = 'T'
        ORDER  BY 1,2) v"))
        ->get();
        return $data;
    }
    
    #PRA REKON STO CONS FLAM
    public function getPeriode_prarekon_cons(){
        $data = DB::connection("oracle-usrgkdmfg")
        ->table(DB::raw("(select FOPEN_PERIODE_STO1('N') periode from dual) v"))
        ->select("periode")
        ->value('periode');
        
        return $data;
    }  
    
    public function getUserSite_prarekon_cons($user){
        if (strlen($user) > 5){
            $user_str = substr($user,0,6);
            
            $data = DB::connection('oracle-usrgkdmfg')
            ->table(DB::raw("(SELECT KODE AS KD_GUDANG 
            FROM MWHS_GUDANG 
            WHERE KD_SUPP = '$user_str') v"))
            ->value('KD_GUDANG');
        } else if ($user = '07170'){
            $data = '001';
        } else if ($user = '13986' || $user = '12317' || $user = '12752'){
            $data = '001';
        } else {
            $data = '041';
        }
        
        return $data;
    }
    
    public function getgudang_prarekon_cons(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG
        FROM MWHS_GUDANG ORDER BY 1,2) v"))
        ->get();
        
        return $data;
        
    }
    
    public function getStatus_prarekon_cons($tahun, $bulan, $site, $kdlap){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT FLAG_STATUS
        FROM   VSTO_TAG_CONS_REKON_SCAN1
        WHERE  TAHUN||BULAN = '$tahun'||'$bulan'
        AND    KD_GUDANG = '$site'
        AND KD_LAP = '$kdlap') v"))
        ->get();
        
        return $data;
    }
    
    public function getStatus_prarekon_fg($tahun, $bulan, $site){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT FLAG_STATUS
        FROM   VSTO_TAG_CONS_REKON_SCAN1
        WHERE  TAHUN||BULAN = '$tahun'||'$bulan'
        AND    KD_GUDANG = '$site') v"))
        ->get();
        
        return $data;
    }

    public function getStatus_prarekon_fg2($tahun, $bulan, $site){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT FLAG_STATUS
        FROM   VSTO_TAG_FG_REKON_SCAN1
        WHERE  TAHUN||BULAN = '$tahun'||'$bulan'
        AND    KD_GUDANG = '$site') v"))
        ->get();
        
        return $data;
    }

    public function ambilgudang_prarekon_cons(){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT KODE KD_GUDANG, NAMA_GUDANG
        FROM MWHS_GUDANG ORDER BY 1,2) v"))
        ->get();
        
        return $data;
    }
    
    public function kodelaporan_prarekon_cons($tahun, $bulan){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT MPT_WHS KD_LAP, FNM_LAP_WHS(MPT_WHS)NM_LAP_WHS
        FROM   VWHS_MUTASI_SITE
        WHERE  THN_MUTASI||BLN_MUTASI = '$tahun'||'$bulan'
        AND   MPT_WHS NOT LIKE  '2%'
        AND   MPT_WHS NOT IN ('13','1F','OS')
        ORDER BY 1) v"))
        ->get();
        
        return $data;
    }
    
    #TRANSFER STO CONS
    public function filter_kel_lap($tahun, $bulan, $site){
        $data = DB::connection('oracle-usrgkdmfg')
        ->table(DB::raw("(SELECT DISTINCT KEL_LAP FROM VSTO_TRANSFER
        WHERE TAHUN||BULAN = '$tahun'||'$bulan'
        AND KD_GUDANG = '$site'
        AND KEL_LAP NOT IN '2D' ) v"))
        ->get();
        
        return $data;
    }
    
    
    
    
    
    
    # JIMMI END #
    
}
