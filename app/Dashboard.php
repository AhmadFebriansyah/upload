<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;

class Dashboard extends Model
{

    public function getConn($conn, $table)
    {
        $data = DB::connection($conn)
                ->table($table);

        return $data;
    }

    public function akses($nama_role){
        $npk = Auth::user()->username;

        # if no permission on dashboard
        $data = DB::table(DB::raw("(select m1.npk, m2.id_role, m2.deskripsi_role from dashboard_permission m1 
                left join dashboard_role m2 on m1.id_role = m2.id where npk = '$npk') v"))
            ->get();
        if (count($data) > 0){
            // return false; # tidak diaktifkan dulu
        }

        # if admin by pass below
        $data = DB::table(DB::raw("(select m1.npk, m2.id_role, m2.deskripsi_role from dashboard_permission m1 
                left join dashboard_role m2 on m1.id_role = m2.id where npk = '$npk' and m2.id_role = 'admin') v"))
            ->get();
        if (count($data) > 0){
            return true;
        }

        # if has specific roles
        $left = 0;
        foreach ($nama_role as $id_role) {
            if (substr($id_role, -1) == "*") {
                $id_role = substr($id_role, 0, -1) . "%";
                $data = DB::table(DB::raw("(select m1.npk, m2.id_role, m2.deskripsi_role from dashboard_permission m1 
                    left join dashboard_role m2 on m1.id_role = m2.id where npk = '$npk' and m2.id_role like '$id_role') v"))
                ->get();
            } else {
                $data = DB::table(DB::raw("(select m1.npk, m2.id_role, m2.deskripsi_role from dashboard_permission m1 
                    left join dashboard_role m2 on m1.id_role = m2.id where npk = '$npk' and m2.id_role = '$id_role') v"))
                ->get();
            }

            if (count($data) == 0){
                if($left == count($nama_role)){
                    return false;
                } else {
                    $left++;
                }
            } else {
                return true;
            }
        }
    }

    public function getDataDies() 
    {
    	$data = DB::connection('oracle-usrgkdmfg')
	            ->table('dies_mst a')
	            ->select(DB::raw('a.kd_dies, a.nm_dies, fnm_gudang(kd_site) nm_site, a.blok'))
	            ->orderBy('nm_dies', 'asc')
	            ->get();

    	return $data;
    }

    public function searchDataDies($keyword) 
    {
    	$data = DB::connection('oracle-usrgkdmfg')
                ->table('dies_mst a')
                ->select(DB::raw('a.kd_dies, a.nm_dies, fnm_gudang(kd_site) nm_site, a.blok'))
                ->whereRaw("nm_dies like '%$keyword%'")
                ->first();

    	return $data;
    }

    public function getEngPath()    
    {
        if(config('app.env', 'local') === 'production') {
            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."eng".DIRECTORY_SEPARATOR."diesmtc";
        } else {
            $destinationPath = "\\\\".config('app.ip_g', 'XXX')."\\Portal\\".config('app.kd_pt', 'XXX')."\\eng\\diesmtc";
        }

        return $destinationPath;
    }

    public function getQcPath()    
    {
        if(config('app.env', 'local') === 'production') {
            $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."Digital Checksheet";
        } else {
            $destinationPath = public_path() . DIRECTORY_SEPARATOR . 'qc/Digital Checksheet';
          //  $destinationPath = asset('images/no_image.png');
        }

        return $destinationPath;
    }

    public function getNoOPL()
    {
        $data = DB::connection('oracle-usrgkdmfg')
                ->table('diest_topl')
                ->select(DB::raw("lpad(nvl(max(substr(id, 0, 3)), 0) + 1, 3, 0) || '/OPL/DIE-MTC/GKD/' || to_char(sysdate, 'mm') || '/' || to_char(sysdate, 'yy') numbering"))
                ->value('numbering');

        return $data;
    }

    public function checkDataDies($kd_dies) {
        $dies_det = DB::connection('oracle-usrgkdmfg')
                ->table('dies_det')
                ->select(DB::raw('count(*) as total'))
                ->where('kd_dies', $kd_dies)
                ->value('total');

        $dies_mst_prev = DB::connection('oracle-usrgkdmfg')
                ->table('dies_mst_prev')
                ->select(DB::raw('count(*) as total'))
                ->where('kd_dies', $kd_dies)
                ->value('total');

        $dies_mst_site = DB::connection('oracle-usrgkdmfg')
                ->table('dies_mst_site')
                ->select(DB::raw('count(*) as total'))
                ->where('kd_dies', $kd_dies)
                ->value('total');

        $dies_mst_bom = DB::connection('oracle-usrgkdmfg')
                ->table('dies_mst_bom')
                ->select(DB::raw('count(*) as total'))
                ->where('kd_dies', $kd_dies)
                ->value('total');

        return $dies_det + $dies_mst_prev + $dies_mst_site + $dies_mst_bom;

    }

    public static function checkSiteDies($kd_dies, $no_urut)
    {
        $data = DB::connection('oracle-usrgkdmfg')
                ->table('dies_mst_site')
                ->select(DB::raw('count(*) total'))
                ->where('kd_dies', $kd_dies)
                ->where('no_urut', $no_urut)
                ->value('total');

        return $data;
    }

    public static function checkStatusLock($kd_is)
    {
        $st_lock = DB::connection('oracle-usrgkdmfg')
                ->table('qct_mis1')
                ->select(DB::raw('st_lock'))
                ->where('kd_is', $kd_is)
                ->value('st_lock');

        return $st_lock;
    }

    public static function can($key)
    {
        if (session()->has('auth_stat_qe') && session()->has('app_key_qe')) {
            $flag = false;
            $role = session()->get('role_qe');

            for ($i=0; $i < count($role); $i++) { 
                for ($j=0; $j < count($key); $j++) { 
                    if ($key[$j] == '*') {
                        $flag = true;
                    } else {
                        if ($key[$j] == $role[$i]) {
                            $flag = true;
                        }
                    }
                }
            }
        } else {
            $flag = null;
        }
        return $flag;
        // return true;
    }

    public function getFoto($npk) {
        $foto = DB::table("v_mas_karyawan")
        ->select(DB::raw("coalesce(substr(foto,18),'-.jpg') foto"))
        ->where("npk", "$npk")
        ->value("foto");

        return $foto;
    }

    public function fotoKaryawan($foto, $nama) {
        if(config('app.env', 'local') === 'production') {
            if(config('app.env', 'local') === 'production') {
                $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$foto;
            } else {
                $file_temp = "\\\\".config('app.ip_g', 'XXX')."\\Portal\\foto\\".$foto;
            }
            if (!file_exists($file_temp)) {
                if($foto != null) {
                    if(config('app.env', 'local') === 'production') {
                        $file_temp = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR."foto".DIRECTORY_SEPARATOR.$foto;
                    } else {
                        $file_temp = "\\\\".config('app.ip_g', 'XXX')."\\Portal\\foto\\".$foto;
                    }
                }
            }
            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                return $image_codes;
            } else {
                return \Avatar::create($nama)->toBase64();
            }
        } else {
            return \Avatar::create($nama)->toBase64();
        }
    }

    public function getNmLine($kode_line) {
         $nama_line = DB::connection("oracle-usrgkdmfg")
                      ->table(DB::raw("usrgkdmfg.mline_mstrx")) 
                      ->select(DB::raw("mline_desc"))
                      ->where("mline_code", "$kode_line")
                      ->value("mline_desc");
        return $nama_line;
    }

    public function getNmProses($kode_proses) {
         $nama_proses = DB::connection("oracle-usrgkdmfg")
          ->table(DB::raw("(select fnm_proses('$kode_proses') as proses from dual) v"))
          ->select(DB::raw("proses"))
          ->value('proses');
        return $nama_proses;
    }

    public function getNmPart($kode_part) {
        $nama_part = DB::connection("oracle-usrgkdmfg")
          ->table(DB::raw("(select fnm_item('$kode_part') as part from dual) v"))
          ->select(DB::raw("part"))
          ->value('part');
        return $nama_part;
    }

    public function getLayoutMp($idprod, $posisi) {
        $npk = DB::table("prodm_henkaten_layout_mp")
            ->select(DB::raw("npk"))
            ->where("id_produksi", "$idprod")
            ->where("urutan_posisi", "$posisi")
            ->value("npk");
        return $npk;
    }

    public function getLayoutMpResume($kd_line, $posisi) {
        $now = Carbon::now()->format('Ymd');

        $cek_data = DB::table("prodm_henkaten_layout_mp")
        ->select(DB::raw("npk"))
        ->where("line", "$kd_line")
        ->where("urutan_posisi", "$posisi")
        ->whereRaw("to_char(dtcrea, 'YYYYMMDD') = '$now'" )
        ->value("npk");

        if(isset($cek_data)){
            $npk = DB::table("prodm_henkaten_layout_mp")
            ->select(DB::raw("npk"))
            ->where("line", "$kd_line")
            ->where("urutan_posisi", "$posisi")
            ->whereRaw("to_char(dtcrea, 'YYYYMMDD') = '$now'" )
            ->value("npk");
        } else {
            $npk = DB::table("prodm_henkaten_layout_mp")
            ->select(DB::raw("npk"))
            ->where("line", "$kd_line")
            ->where("urutan_posisi", "$posisi")
            ->value("npk");
        }
        return $npk;
    }

    public function getLayoutstandarOP($line, $posisi) {
        $operator = DB::table("prodt_henkaten_layout")
            ->select(DB::raw("operator"))
            ->where("line", "$line")
            ->where("urutan_posisi", "$posisi")
            ->value("operator");
       
            return $operator;
    }

    public function getLayoutOP($idprod, $npk) {
        $operator = DB::table("prodm_henkaten_layout_mp")
            ->select(DB::raw("operator"))
            ->where("id_produksi", "$idprod")
            ->where("npk", "$npk")
            ->value("operator");
        return $operator;
    }

    public function detailProdHenkaten($proddps, $line, $shift, $tgl) {
        // if( $line == 'W23' ||  $line == 'W34'){
        //  $cekdps =  DB::connection("oracle-usrgkdmfg")
        //  ->table("tdps051")
        //  ->select("*")
        //  ->where('no_prodhen', '=', $proddps)
        //  ->first();
        // }else{
           $cekdps =  DB::connection('oracle-usrgkdmfg')
           ->table(DB::raw("(SELECT DISTINCT MPT_CODE, MPROCESS_CODE, MLINE_CODE, fnm_proses(mprocess_code)  ||' - '||  fnm_item(mpt_code) produk,
            MPT_CODE||MPROCESS_CODE NO_PRODHEN
            FROM VSFC_ROUTING WHERE MPT_CODE||MPROCESS_CODE='$proddps' ) v"))
           ->first();
        //  }

       $detail = DB::table("prodm_henkaten_sch_prod")
       ->select("*")
       ->where("line", $line )
      // ->where("no_prodhen",  $proddps  )
       ->where("shift", $shift  )
       ->where("mpt_code", $cekdps->mpt_code  )
       ->where("mprocess_code", $cekdps->mprocess_code  )
       ->whereRaw("to_char(tanggal, 'YYYYMMDD') = '$tgl'" )
       ->first();

    
       return $detail;
    }

    public function getYamazumi($line, $mprocess_code, $mpt_code) {
          $param = DB::table("prodm_henkaten_yamazumi")
            ->select(DB::raw("dok_yamazumi"))
            ->where("line", "$line")
            ->where("mpt_code", "$mpt_code")
            ->where("mprocess_code", "$mprocess_code")
            ->value("dok_yamazumi");
           if (!empty($param)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp  = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."prod".DIRECTORY_SEPARATOR."henkaten".DIRECTORY_SEPARATOR."yamazumi".DIRECTORY_SEPARATOR.$param;
            } else {
                $file_temp = public_path() . DIRECTORY_SEPARATOR."prod".DIRECTORY_SEPARATOR."henkaten".DIRECTORY_SEPARATOR."yamazumi".DIRECTORY_SEPARATOR.$param;
            }
            
            // $destinationPath = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."prod".DIRECTORY_SEPARATOR."henkaten".DIRECTORY_SEPARATOR."layout";
            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                return $image_codes;
            } else {
            return null;
            }
        } else {
            return null;
        }
    }

    public function getPictAPD($param) {
           if (!empty($param)) {
            if(config('app.env', 'local') === 'production') {
                $file_temp  = DIRECTORY_SEPARATOR."serverh".DIRECTORY_SEPARATOR."Portal".DIRECTORY_SEPARATOR.config('app.kd_pt', 'XXX').DIRECTORY_SEPARATOR."prod".DIRECTORY_SEPARATOR."henkaten".DIRECTORY_SEPARATOR."apd".DIRECTORY_SEPARATOR.$param;
            } else {
                $file_temp = public_path() . DIRECTORY_SEPARATOR."prod".DIRECTORY_SEPARATOR."henkaten".DIRECTORY_SEPARATOR."apd".DIRECTORY_SEPARATOR.$param;
            }
            if (file_exists($file_temp)) {
                $loc_image = file_get_contents('file:///'.str_replace("\\\\","\\",$file_temp));
                $image_codes = "data:".mime_content_type($file_temp).";charset=utf-8;base64,".base64_encode($loc_image);
                return $image_codes;
            } else {
            return null;
            }
        } else {
            return null;
        }
    }

    public function getNamaCust($id) {
        $operator = DB::connection('oracle-usrdbgkd')
                    ->table('cust_mstr')
                    ->select(DB::raw('nama, kode_sa, init'))
                    ->whereRaw("nvl(customer,'N') = 'Y' and kode_sa = '$id'")
            ->value("nama");
        return $operator;
    }

    public function reminderAkumulatif() {
        try {
            // kirim telegram
            $token_bot = config('app.token_gkd_astra_bot', '-');

            $cekdata = DB::connection('oracle-usrgkdmfg')
                    ->table('vdies_prev4')
                    ->select(DB::raw("*"))
                    ->whereRaw("qty_persen > ".floatval('80')."")
                    ->whereRaw("flag_notif = 'F' and flag_status = 'O' and kd_site = '001'")
                    ->get();

            $countdata =0;
            if(count($cekdata) != 0){
                foreach ($cekdata as $item) {
                    $admins = DB::table(DB::raw("(
                        select b.npk, b.nama, u.telegram_id, string_agg(distinct u.email||' ('||u.username||')', ' | ' order by u.email||' ('||u.username||')') email , u.no_hp
                        from users u, role_user r, roles ro, v_mas_karyawan b 
                        where u.id = r.user_id 
                        and r.role_id = ro.id 
                        and split_part(upper(u.username),'.',1) = b.npk
                        and b.npk in ('13260','07170')
                        and u.status_active = 'T' 
                        group by b.npk, b.nama , u.telegram_id, u.no_hp
                    ) v"))
                    ->selectRaw("npk, nama, email, telegram_id, no_hp")
                    ->get();

                    foreach ($admins as $admin) {
                        $data_telegram = [];

                        $nm_a = DB::table("v_mas_karyawan")
                        ->select("nama")
                        ->where("npk", "=", $admin->npk)
                        ->value("nama");

                        if(config('app.env', 'local') === 'production') {
                            $pesan = "<strong>Reminder Dies Preventive </strong>\n\n";
                            $pesan .= salam()." Bapak ".$nm_a.", Berikut ini adalah informasi Dies yang harus segera dilakukan Preventive:"."\n\n";
                        } else {
                            $pesan = "<strong>Reminder Dies Preventive</strong>\n\n";
                            $pesan .= salam()." Bapak ".$nm_a.", Berikut ini adalah informasi Dies yang harus segera dilakukan Preventive:"."\n\n";
                        }

                        $pesan .= "--------------------------------------\n";
                        $pesan .= "Kode Dies : ".$item->kd_dies."\n";
                        $pesan .= "Nama Dies : ".$item->nama_dies."\n";
                        $pesan .= "Presentase : ".$item->qty_persen." %"."\n";
                        $pesan .= "Site : ".$item->nama_gudang."\n";
                        $pesan .= "Tipe : ".$item->kd_type."\n";

                        $pesan .= "--------------------------------------\n";

                        $pesan .= "Mohon Bapak untuk segera melaksanakan kegiatan preventive dan mengisi form pada link dibawah ini.\n\n";
                        $pesan .= "<strong>Tautan Terkait :</strong>\n";
                        $pesan .= "<a href='".route('dashboard.mtc.actual_preventive')."'> Klik disini untuk melakukan tindaklanjut.</a>\n\n";
                        $pesan .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";

                        $pesan .= strtoupper(config('app.nm_pt', 'Laravel'));

                        $data_telegram = array(
                            'chat_id' => $admin->telegram_id,
                            'text'=> $pesan,
                            'parse_mode'=>'HTML'
                        );
                        $result = KirimPerintah("sendMessage", $token_bot, $data_telegram);
                    }

                    $now = Carbon::now();
                    $stnotif = DB::connection('oracle-usrgkdmfg')
                    ->table('dies_mutasi')
                    ->whereRaw("no_id = '$item->no_id' and flag_notif = 'F'")
                    ->update(['flag_notif'=>'T', 'tgl_notif'=>$now]);
                    echo "Berhasil: Mengirimkan Data " .$item->kd_dies . " dengan No Id ". $item->no_id;
                    echo "<br>";

                    $countdata++;
                }
            }
            echo "<br><br>";
            echo "Berhasil: mengirimkan "  . $countdata ." dari ". count($cekdata) . " data.";
        } catch (Exception $e) {
            // kirim telegram ade 
            $gkd_astra_bot = config('app.token_gkd_astra_bot', '-');
            $telegram_id = '1296644643'; // Telegram Ade

            $pesan = "Terdapat kesalahan dalam mengirim reminder harian.";
            $pesan .= "\n\nPesan Error: " . $e->getMessage();
            $pesan .= "\nLine Error: " . $e->getLine();
            $pesan .= "\nFile Error: " . $e->getFile();
            $pesan .= "\n\n" . Carbon::now()->format('d F Y H:i A');
            $data_telegram = array(
                'chat_id' => $telegram_id,
                'text' => $pesan,
                'parse_mode' => 'HTML'
            );
            $result = KirimPerintah("sendMessage", $gkd_astra_bot, $data_telegram);

            echo "Gagal mengirimkan data!";
            echo "<br>";
            echo "Pesan Error: " . $e->getMessage();
            echo "<br>";
        }
    }


}
