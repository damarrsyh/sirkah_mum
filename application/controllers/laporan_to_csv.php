<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_to_csv extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true,'main','back');
		$this->load->model("model_laporan_to_pdf");
		$this->load->model("model_laporan");
		$this->load->model("model_cif");
		$this->load->library('phpexcel');
		$CI =& get_instance();
	}

	function export_lap_aging(){
		$branch_id = $this->uri->segment(3);
		$date = $this->uri->segment(4);
		$kol = $this->uri->segment(5);
		$kol = urldecode($kol);
        $fa_code = $this->uri->segment(6);
        $kreditur = $this->uri->segment(7);

		$desc_date = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
		$date = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2);
		if($branch_id=="00000"){
			$branch_id = '';
		}
		$branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);

		$branch_code = $branch_data['branch_code'];
		$branch_name = $branch_data['branch_name'];

        $datas = $this->model_laporan_to_pdf->get_laporan_par_terhitung($date,$branch_code,$kol,$fa_code,$kreditur);

        $ii = 0;
		$total_pokok = 0;
		$total_margin = 0;
		$total_saldo_pokok = 0;
		$total_saldo_margin = 0;
		$total_tunggakan_pokok = 0;
		$total_tunggakan_margin = 0;
		$total_cadangan_piutang = 0;

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
        	$result = $datas[$i];
			
			$total_pokok += $result['pokok'];
			$total_margin += $result['margin'];
			$total_saldo_pokok += $result['saldo_pokok'];
			$total_saldo_margin += $result['saldo_margin'];
			$total_tunggakan_pokok += $result['tunggakan_pokok'];
			$total_tunggakan_margin += $result['tunggakan_margin'];
			$total_cadangan_piutang += $result['cadangan_piutang'];

            $account_financing_no = $result['account_financing_no'];
            $cm_name = $result['cm_name'];
            $nama = $result['nama'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $jangka_waktu = $result['jangka_waktu'];
            $droping_date = $result['droping_date'];
            $tanggal_mulai_angsur = $result['tanggal_mulai_angsur'];
            $angsuran_pokok = $result['angsuran_pokok'];
            $angsuran_margin = $result['angsuran_margin'];
            $terbayar = $result['terbayar'];
			$seharusnya = $result['seharusnya'];
			$saldo_pokok = $result['saldo_pokok'];
			$saldo_margin = $result['saldo_margin'];
			$hari_nunggak = $result['hari_nunggak'];
			$freq_tunggakan = $result['freq_tunggakan'];
			$tunggakan_pokok = $result['tunggakan_pokok'];
			$tunggakan_margin = $result['tunggakan_margin'];
			$par_desc = $result['par_desc'];
			$par = $result['par'];
			$cadangan_piutang = $result['cadangan_piutang']; 
            $petugas = $result['fa_name'];
            $sumber_dana = $result['kreditur_name'];

            $arr_csv[] = array(
            	'No' => ($i + 1),
            	'No. Rekening' => "'".$account_financing_no,
            	'Majelis' => $cm_name,
            	'Nama' => $nama,
            	'Pokok' => $pokok,
            	'Margin' => $margin,
            	'Jangka Waktu' => $jangka_waktu,
            	'Tanggal Cair' => $droping_date,
            	'Mulai Angsur' => $tanggal_mulai_angsur,
            	'Angsuran Pokok' => $angsuran_pokok,
            	'Angsuran Margin' => $angsuran_margin,
            	'Terbayar' => $terbayar,
				'Seharusnya' => $seharusnya,
				'Saldo Pokok' => $saldo_pokok,
				'Saldo Margin' => $saldo_margin,
				'Tunggakan Angsuran' => $freq_tunggakan,
				'Tunggakan (Hari)' => $hari_nunggak,
				'Tunggakan Pokok' => $tunggakan_pokok,
				'Tunggakan Margin' => $tunggakan_margin,
				'PAR' => $par_desc,
				'CPP Persentase' => $par,
				'CPP Nominal' => $cadangan_piutang, 
                'Petugas' => $petugas,  
                'Sumber Dana' => $sumber_dana  

            );
            
            $ii++;
        }

		download_send_headers('LIST_KOLEKTIBILITAS_'.$branch_name.'_'.$date.'.csv');
		echo array2csv($arr_csv);
		die();
    }

    function export_list_pengajuan_pembiayaan(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan($cabang,$from,$thru,$majelis,$pembiayaan,$petugas);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
        	$result = $datas[$i];

        	$registration_no = $result['registration_no'];
        	$rencana_droping = $result['rencana_droping'];
        	$status = $result['status'];
        	$tanggal_pengajuan = $result['tanggal_pengajuan'];
        	$nama = $result['nama'];
        	$cm_name = $result['cm_name'];
            $financing = $result['financing_type'];
        	$amount = $result['amount'];
        	$stat = $result['status'];
            $petugas = $result['fa_name'];

	        if($stat == 0){
	        	$status = 'Registrasi';
	        } else if($stat == 1){
	        	$status = 'Aktivasi';
	        } else if($stat == 2){
	        	$status = 'Ditolak';
	        } else if($stat == 3){
	        	$status = 'Batal';
	        }

            if($financing == 0){
                $jenis = 'Kelompok';
            } else {
                $jenis = 'Individu';
            }

            $arr_csv[] = array(
            	'No' => ($i + 1),
            	'No Registrasi' => $registration_no,
            	'Nama' => $nama,
            	'Majelis' => $cm_name,
                'pembiayaan' => $jenis,
            	'Tanggal Registrasi' => $tanggal_pengajuan,
            	'Rencana Cair' => $rencana_droping,
            	'Jumlah Pengajuan' => $amount,
                'Status' => $status,
                'Petugas'           => $petugas
            );
        }

		download_send_headers('LAPORAN_PENGAJUAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
		echo array2csv($arr_csv);
		die();
    }

	function export_list_registrasi_pembiayaan(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
		
        $datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $arr_csv = array(); 

		for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $periode_jangka_waktu   = $result['periode_jangka_waktu'];
            $pokok                  = $result['pokok'];
            $status_rekening        = $result['status_rekening'];
            $financing              = $result['financing_type'];
            $rekening               = $result['account_financing_no'];
            $nama                   = $result['nama'];
            $majelis                = $result['cm_name'];
            $tanggal_registrasi     = $result['tanggal_registrasi'];
            $pokok                  = $result['pokok'];
            $margin                 = $result['margin'];
            $angsuran_pokok         = $result['angsuran_pokok'];
            $angsuran_margin        = $result['angsuran_margin'];
            $angsuran_catab         = $result['angsuran_catab'];
            $jangka_waktu           = $result['jangka_waktu'];
            $product                = $result['nick_name'];
            $tanggal_pengajuan      = $result['tanggal_pengajuan'];
            $biaya_administrasi     = $result['biaya_administrasi'];
            $biaya_asuransi_jiwa    = $result['biaya_asuransi_jiwa'];

            $total = $angsuran_pokok + $angsuran_margin + $angsuran_catab;

            if($periode_jangka_waktu == 0){
                $periode = 'Hari';
            } else if($periode_jangka_waktu == 1){
                $periode = 'Minggu';
            } else if($periode_jangka_waktu == 2){
                $periode = 'Bulan';
            } else if($periode_jangka_waktu == 3){
                $periode = 'Jatuh Tempo';
            }

            $setor = $pokok * 0.05;

            if($status_rekening == 0){
                $status = 'Registrasi';
            } else if($status_rekening == 1){
                $status = 'Aktif';
            } else if($status_rekening == 2){
                $status = 'Lunas';
            } else{
                $status = 'Verifikasi';
            }

            if($financing == 0){
                $jenis = 'Kelompok';
            } else{
                $jenis = 'Individu';
            }

            if($tanggal_registrasi == ''){
                $tanggal = '-';
            } else {
                $tanggal = $this->format_date_detail($tanggal_registrasi,'id',false,'/');
            }

            if($tanggal_pengajuan == ''){
                $tanggal_peng = '-';
            } else {
                $tanggal_peng = $this->format_date_detail($tanggal_pengajuan,'id',false,'/');
            }

        	$arr_csv[] = array(
            	'No' => ($i + 1),
            	'Nomor Rekening' => "'".$rekening,
            	'Nama' => $nama,
                'Majelis' => $majelis,
                'Pembiayaan' => $jenis,
                'Produk' => $product,
                'Tanggal Pengajuan' => $tanggal_peng,
            	'Tanggal Registrasi' => $tanggal,
            	'Plafon' => $pokok,
            	'Margin' => $margin,
                'Jangka Waktu' => $jangka_waktu.' '.$periode,
            	'Angsuran Pokok' => $angsuran_pokok,
            	'Angsuran Margin' => $angsuran_margin,
            	'Angsuran Catab' => $angsuran_catab,
                'Total' => $total,
                'Biaya Administrasi' => $biaya_administrasi,
                'Biaya asuransi' => $biaya_asuransi_jiwa,
            	'Status Rekening' => $status
            );
        
        }

		download_send_headers('LAPORAN_REGISTRASI_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
		echo array2csv($arr_csv);
		die();
    }


    public function read_import_debitur(){ 
        $target = './assets/excel/import_debitur.xls';

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($target);
            } 
            catch(Exception $e){
                $confirm = FALSE;
                $result = array(
                    'result' => FALSE,
                    'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
                    'tbody' => ''
                );
            }


            $worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,TRUE,TRUE);
            $numRows = count($worksheet);
            $cif_no_array=" (";
            // MULAI BARIS KE-3
            for($i = 2; $i < ($numRows + 1); $i++){
                $cif_no = $worksheet[$i]['B'];
                $nama = $worksheet[$i]['C'];
                $majlis = $worksheet[$i]['D']; 

                if( $i !=$numRows) 
                    { $cif_no_array=$cif_no_array.$cif_no."', ";} 
                 else { $cif_no_array=$cif_no_array.$cif_no."')"; }  
        
            }
            ///echo "<tr>";
            ///echo "<td".$cif_no_array.">".$cif_no_array."</td>";
            ///echo "</tr>";
            return $cif_no_array;
            
    }


    public function read_import_akad(){ 
        $target = './assets/excel/import_akad.xls';

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($target);
            } 
            catch(Exception $e){
                $confirm = FALSE;
                $result = array(
                    'result' => FALSE,
                    'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
                    'tbody' => ''
                );
            }


            $worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,TRUE,TRUE);
            $numRows = count($worksheet);
            $cif_no_array=" (";
            // MULAI BARIS KE-3
            for($i = 2; $i < ($numRows + 1); $i++){
                $cif_no = $worksheet[$i]['B'];
                $nama = $worksheet[$i]['C'];
                $majlis = $worksheet[$i]['D']; 

                if( $i !=$numRows) 
                    { $cif_no_array=$cif_no_array.$cif_no."', ";} 
                 else { $cif_no_array=$cif_no_array.$cif_no."')"; }  
        
            }
            ///echo "<tr>";
            ///echo "<td".$cif_no_array.">".$cif_no_array."</td>";
            ///echo "</tr>";
            return $cif_no_array;
            
    }

    public function read_import_droping(){ 
        $target = './assets/excel/import_droping.xls';

        try {
            $objPHPExcel = PHPExcel_IOFactory::load($target);
            } 
            catch(Exception $e){
                $confirm = FALSE;
                $result = array(
                    'result' => FALSE,
                    'message' => 'Tidak dapat membuka file :' . $e->getMessage(),
                    'tbody' => ''
                );
            }


            $worksheet = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,TRUE,TRUE);
            $numRows = count($worksheet);
            $cif_no_array=" (";
            // MULAI BARIS KE-3
            for($i = 2; $i < ($numRows + 1); $i++){
                $cif_no = $worksheet[$i]['B'];
                $nama = $worksheet[$i]['C'];
                $majlis = $worksheet[$i]['D']; 

                if( $i !=$numRows) 
                    { $cif_no_array=$cif_no_array.$cif_no."', ";} 
                 else { $cif_no_array=$cif_no_array.$cif_no."')"; }  
        
            }
            ///echo "<tr>";
            ///echo "<td".$cif_no_array.">".$cif_no_array."</td>";
            ///echo "</tr>";
            return $cif_no_array;
            
    }


function export_lap_chn_debitur(){

        $cif_no_array = $this->read_import_debitur();   

        $datas = $this->model_laporan_to_pdf->create_lap_chn_debitur($cif_no_array);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $droping_date = $result['droping_date'];
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $branch_name = $result['branch_name'];
            $nick = $result['nick_name'];
            $dtp = $result['dtp'];
            $dts = $result['dts'];
            if($dts ="1") {$sektor="526000";} else {$sektor="369000";} ;

            $no_hp = $result['no_hp'];
            $sumber_dana = $result['krd'];
            $no_ktp = "'".$result['no_ktp']; 
            $status_perkawinan = $result['status_perkawinan']; 
            $tgl_lahir = $result['tgl_lahir']; 
            $tgl_gabung = $result['tgl_gabung'];
            $modal_awal = $result['modal_awal'];
            $omset_usaha = $result['omset_usaha'];
            $lokasi_usaha = $result['lokasi_usaha'];
            $rmhlantai = $result['rmhlantai'];
            $alamat = $result['alamat']; 
            $city_code = $result['city_code']; 
            $kodepos = $result['kodepos'];     


            $arr_csv[] = array(
                'No' => ($i + 1),
                'Nama' => $nama,
                'NIK'    => $no_ktp,
                'marriage' => '1',   
                'pekerjaan'  => '6',    
                'skemakredit' => '1', 
                'islinkage' => '1', 
                'nomorhp' => $no_hp, 
                'npwp' => "'".'000000000000000', 
                'birthdate' => $tgl_lahir,    
                'sex' => '2', 
                'uraian_agunan'  => 'TIDAK ADA AGUNAN',    
                'noizin'  => "'".'0000000', 
                'sektor' => $sektor,   
                'mulaiusaha' => $tgl_gabung, 
                'modal'   => $modal_awal,
                'omset'   => $omset_usaha,
                'jumlahpekerja'  => '1',  
                'jumlahkredit'   => $pokok, 
                'is_subsidized'  => '0',   
                'subsidi_sebelumnya'  => 'TIDAK ADA', 
                'alamatusaha' => $branch_name, 
                'kodewilayah' => $city_code, 
                'kodepos'     => $kodepos, 
                'kondisirumah' => '1', 
                'alamat' => $alamat, 

                
            );
        }

       download_send_headers('LAPORAN_CALON_DEBITUR.csv');
       echo array2csv($arr_csv);
       die();
    }


function export_lap_chn_akad(){

        $cif_no_array = $this->read_import_akad();   

        $datas = $this->model_laporan_to_pdf->create_lap_chn_akad($cif_no_array);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $nik                = "'".$result['nik']; 
            $noakad             = $result['norekening'];
            $norekening         = $result['norekening'];
            $statusakad         = $result['statusakad'];
            $statusrekening     = $result['statusrekening']; 
            $tanggalakad        = $result['tanggalakad'];
            $tanggaljatuhtempo  = $result['tanggaljatuhtempo'];
            $nilaiakad          = $result['nilaiakad'];
            $skema              = $result['skema']; 
            $idkelompok         = $result['idkelompok']; 
            $sukubunga          = $result['sukubunga']; 
            $sektor             = $result['sektor']; 
            if($sektor ="1") {$sektor="526000";} else {$sektor="369000";} ;
            $kodepenjamin       = $result['kodepenjamin']; 
            $nopenjaminan       = $result['nopenjaminan']; 
            $nilaidijamin       = $result['nilaidijamin'];   


            $arr_csv[] = array(
                'No'                => ($i + 1),
                'nik'               => $nik,
                'noakad'            => "'".$noakad, 
                'norekening'        => "'".$norekening,     
                'statusakad'        => $statusakad, 
                'statusrekening'    => $statusrekening, 
                'tanggalakad'       => $tanggalakad, 
                'tanggaljatuhtempo' => $tanggaljatuhtempo, 
                'nilaiakad'       	=> $nilaiakad, 
                'skema'       		=> $skema, 
                'idkelompok'       	=> "'".'000',
                'sukubunga'       	=> $sukubunga,
                'sektor'       		=> $sektor,
                'kodepenjamin'      => $kodepenjamin,
                'nopenjaminan'     	=> "'".'00000',  
                'nilaidijamin'     	=> $nilaidijamin,                 
            );
        }

       download_send_headers('LAPORAN_CHN_AKAD.csv');
       echo array2csv($arr_csv);
       die();
    }

function export_lap_chn_droping(){

        $cif_no_array = $this->read_import_droping();   

        $datas = $this->model_laporan_to_pdf->create_lap_chn_droping($cif_no_array);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $nik                = "'".$result['nik']; 
            $noakad             = $result['norekening'];
            $norekening         = $result['norekening'];
            $statusakad         = $result['statusakad'];
            $statusrekening     = $result['statusrekening']; 
            $tanggalakad        = $result['tanggalakad'];
            $tanggaljatuhtempo  = $result['tanggaljatuhtempo'];
            $nilaiakad          = $result['nilaiakad'];
            $skema              = $result['skema']; 
            $idkelompok         = $result['idkelompok']; 
            $sukubunga          = $result['sukubunga']; 
            $sektor             = $result['sektor']; 
            if($sektor ="1") {$sektor="526000";} else {$sektor="369000";} ;
            $kodepenjamin       = $result['kodepenjamin']; 
            $nopenjaminan       = $result['nopenjaminan']; 
            $nilaidijamin       = $result['nilaidijamin'];   


            $arr_csv[] = array(
                'No'                => ($i + 1),
                'nik'               => $nik,
                'noakad'            => "'".$noakad, 
                'norekening'        => "'".$norekening,     
                'statusakad'        => $statusakad, 
                'statusrekening'    => $statusrekening, 
                'tanggalakad'       => $tanggalakad, 
                'tanggaljatuhtempo' => $tanggaljatuhtempo, 
                'nilaiakad'         => $nilaiakad, 
                'skema'             => $skema, 
                'idkelompok'        => "'".'000',
                'sukubunga'         => $sukubunga,
                'sektor'            => $sektor,
                'kodepenjamin'      => $kodepenjamin,
                'nopenjaminan'      => "'".'00000',  
                'nilaidijamin'      => $nilaidijamin,                 
            );
        }

       download_send_headers('LAPORAN_CHN_AKAD.csv');
       echo array2csv($arr_csv);
       die();
    }



    function export_lap_droping_pembiayaan(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $peruntukan = $this->uri->segment(9);
        $sektor = $this->uri->segment(10);
        $produk = $this->uri->segment(11);
        $kreditur = $this->uri->segment(12);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan($cabang,$majelis,$from,$thru,$pembiayaan,$petugas,$peruntukan,$sektor,$produk,$kreditur);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $periode = $result['periode_jangka_waktu'];
            $pyd = $result['pembiayaan_ke'];
            $s_pokok = $result['pokok_sebelum'];
            $pembiayaan = $result['financing_type'];
            $droping_date = $result['droping_date'];
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $nick = $result['nick_name'];
            $jangka_waktu = $result['jangka_waktu'];
            $dtp = $result['dtp'];
            $dts = $result['dts'];
            $description = $result['description'];
            $pengguna_dana = $result['pengguna_dana'];
            $no_hp = $result['no_hp'];
            $biaya_administrasi = $result['biaya_administrasi'];
            $biaya_asuransi_jiwa = $result['biaya_asuransi_jiwa'];
            $sumber_dana = $result['krd'];
            $tgl_jtempo = $result['tanggal_jtempo'];

            if($periode == 0){
                $periode_jangka_waktu = 'Harian';
            } else if($periode == 1){
                $periode_jangka_waktu = 'Mingguan';
            } else if($periode == 2){
                $periode_jangka_waktu = 'Bulanan';
            } else{
                $periode_jangka_waktu = 'Jatuh Tempo';
            }

            if($pyd == 1){
                $keterangan = 'Droping Baru';
            } else if($pokok == $s_pokok){
                $keterangan = 'Droping Tetap';
            } else if($pokok > $s_pokok){
                $keterangan = 'Droping Naik';
            } else {
                $keterangan = 'Droping Turun';
            }

            if($pembiayaan == 0){
                $jenis = 'Kelompok';
            } else {
                $jenis = 'Individu';
            }

            if($pengguna_dana == 1){
              $pengguna_dana = 'Anggota';
            } else if ($pengguna_dana == 2 ) {
              $pengguna_dana = 'Suami';
            } else {
              $pengguna_dana = 'Anak';
            }

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tanggal' => $droping_date,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Pembiayaan' => $jenis,
                'Majelis' => $majelis,
                'Sumber Dana' => $sumber_dana,
                'PYD ke' => $pyd,
                'Produk' => $nick,
                'Plafon' => $pokok,
                'Margin' => $margin,
                'Periode' => $periode_jangka_waktu,
                'T. Jatuh Tempo' => $tgl_jtempo,
                'Jk Waktu' => $jangka_waktu,
                'Biaya Administrasi' => $biaya_administrasi,
                'Biaya Asuransi' => $biaya_asuransi_jiwa,
                'Plafon  Sblmnya' => $s_pokok,
                'Keterangan' => $keterangan,
                'Pengguna Dana' => $pengguna_dana,
                'Peruntukan' => $dtp.' - '.$description,
                'Sektor' => $dts,
                'No Hp' => $no_hp
            );
        }

       download_send_headers('LAPORAN_PENCAIRAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
       echo array2csv($arr_csv);
       die();
    }

    function export_list_proyeksi_realisasi_angsuran(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);

        $datas = $this->model_laporan_to_pdf->export_list_proyeksi_realisasi_angsuran($from,$thru,$cabang,$produk,$majelis);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $pokok = $result['pokok'];
            $rekening = $result['account_financing_no'];
            $rembug = $result['cm_name'];
            $nick = $result['nick_name'];
            $nama = $result['nama'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $tanggal_akad = $result['tanggal_akad'];
            $angsuran_pokok = $result['angsuran_pokok'];
            $angsuran_margin = $result['angsuran_margin'];
            $saldo_pokok = $result['saldo_pokok'];
            $saldo_margin = $result['saldo_margin'];

            $saldo_hutang = $saldo_pokok + $saldo_margin;

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No. Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Majelis' => $rembug,
                'Produk' => $nick,
                'Plafon' => $pokok,
                'Margin' => $margin,
                'Tgl. Droping' => $tanggal_akad,
                'Proyeksi Pokok' => '0',
                'Proyeksi Margin' => '0',
                'Realisasi Pokok' => $angsuran_pokok,
                'Realisasi Margin' => $angsuran_margin,
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin,
                'Saldo Hutang' => $saldo_hutang
            );
        }

       download_send_headers('LAPORAN_PROYEKSI_REALISASI_ANGSURAN_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_angsuran_pembiayaan(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        $kreditur = $this->uri->segment(10);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            //$petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if($pembiayaan == 0){
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk,$kreditur);
        } else if($pembiayaan == 1){
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk,$kreditur);
            //
        }

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        if($pembiayaan == 0){

        
        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $trx_date           = $result['trx_date'];
            $trx_date           = $this->format_date_detail($trx_date,'id',false,'-');
            $rekening           = $result['account_financing_no'];
            $nama               = $result['nama'];
            $majelis            = $result['cm_name'];
            $produk             = $result['nick_name'];
            $pokok              = $result['pokok'];
            $margin             = $result['margin'];
            $jangka_waktu       = $result['jangka_waktu'];
            $angsuran_pokok     = $result['angsuran_pokok'];
            $angsuran_margin    = $result['angsuran_margin'];
            $angsuran_catab     = $result['angsuran_catab'];
            $jml_bayar          = $result['jml_bayar'];
            $kas_petugas        = $result['account_cash_name'];

            $arr_csv[] = array(
                'No'                => ($i + 1),
                'Tanggal Bayar'     => $trx_date,
                'Rekening'          => "'".$rekening,
                'Nama'              => $nama,
                'Majelis'           => $majelis,
                'Produk'            => $produk,
                'Pokok'             => $pokok,
                'Margin'            => $margin,
                'Jangka Waktu'      => $jangka_waktu,
                'Angsuran Pokok'    => $angsuran_pokok,
                'Angsuran Margin'   => $angsuran_margin,
                'Angsuran Catab'    => $angsuran_catab,
                'Jumlah Bayar'      => $jml_bayar,
                'Kas Petugas'       => $kas_petugas
            );
        }
     } else if($pembiayaan == 1){
        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $trx_date = $result['trx_date'];
            $trx_date = $this->format_date_detail($trx_date,'id',false,'-');
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $produk = $result['nick_name'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $jangka_waktu = $result['jangka_waktu'];
            $angsuran_pokok = $result['bayar_pokok'];
            $angsuran_margin = $result['bayar_margin'];
            $angsuran_catab = $result['bayar_catab'];
            $jml_bayar = $result['jml_bayar'];
            $kas_petugas = $result['account_cash_name'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tanggal Bayar' => $trx_date,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Jangka Waktu' => $jangka_waktu,
                'Angsuran Pokok' => $angsuran_pokok,
                'Angsuran Margin' => $angsuran_margin,
                'Angsuran catab' => $angsuran_catab,
                'Jumlah Bayar' => $jml_bayar,
                'Kas Petugas' => $kas_petugas
            );
        }
     }

        download_send_headers('LAPORAN_ANGSURAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_list_proyeksi_angsuran(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        $kreditur = $this->uri->segment(10);

        $datas = $this->model_laporan_to_pdf->export_list_proyeksi_angsuran($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk,$kreditur);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }
      
        if($cabang != '00000') 
        {
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } 
        else 
        { $data_cabang = 'SEMUA_CABANG'; }

        
            $arr_csv = array();

            for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];
            $rekening           = $result['account_financing_no'];
            $nama               = $result['nama'];
            $majelis            = $result['cm_name'];
            $pokok              = $result['pokok'];
            $margin             = $result['margin'];
            $jangka_waktu       = $result['jangka_waktu'];
            $angsuran_pokok     = $result['angsuran_pokok'];
            $angsuran_margin    = $result['angsuran_margin'];
            $angsuran_catab     = $result['angsuran_catab'];
            $total_angsuran     = $angsuran_pokok+$angsuran_margin+$angsuran_catab;
            $counter_angsuran   = $result['counter_angsuran'];
            $saldo_pokok        = $result['saldo_pokok'];
            $saldo_margin       = $result['saldo_margin'];
            $proyeksi_count     = $result['proyeksi_count']-$result['hari_libur1'];
            if ($proyeksi_count>$jangka_waktu) {$proyeksi_count=$jangka_waktu;};
            $proyeksi_count2    = $result['proyeksi_count2']-$result['hari_libur2'];
            if ($proyeksi_count2>$jangka_waktu) {$proyeksi_count2=$jangka_waktu;};
            $proyeksi_nominal   =($proyeksi_count2-$proyeksi_count+1)*$total_angsuran; 

            if ($counter_angsuran>=$jangka_waktu) {
                $proyeksi_bayar=0; $real_count=0; $real_count2=0; $real_nominal=0; 
            } else {
                $proyeksi_bayar=$result['proyeksi_bayar']; 
                $counter_lebih=$counter_angsuran+$proyeksi_bayar-$jangka_waktu;
                if ($counter_lebih>0) {$proyeksi_bayar=$proyeksi_bayar-$counter_lebih;};        
                $real_count=$counter_angsuran+1; 
                $real_count2=$counter_angsuran+$proyeksi_bayar; 
                $real_nominal=$proyeksi_bayar*$total_angsuran ;
            } 

            $arr_csv[] = array(
                'No'                => ($i + 1),
                'Rekening'          => "'".$rekening,
                'Nama'              => $nama,
                'Majelis'           => $majelis,
                'Pokok'             => $pokok,
                'Margin'            => $margin,
                'Jangka Waktu'      => $jangka_waktu,
                'Jml Angsuran'      => $total_angsuran, 
                'Angsuran Masuk'    => $counter_angsuran,
                'Sisa Angsuran'     => $jangka_waktu-$counter_angsuran,
                'Saldo Pokok'       => $saldo_pokok, 
                'Saldo Margin'      => $saldo_margin,  
                'Pro Jadwal'        => $proyeksi_count2-$proyeksi_count, 
                'Pro ke'            => $proyeksi_count, 
                'Pro sd'            => $proyeksi_count2,
                'Pro Nominal'       => $proyeksi_nominal,
                'Pro Terima'        => $real_count2-$real_count, 
                'Terima ke'         => $real_count, 
                'Terima sd'         => $real_count2,
                'Terima nominal'    => $real_nominal             

            );
        }

        download_send_headers('LAPORAN_PROYEKSI_ANGSURAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_list_angsuran_pembiayaan_individu(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        $kreditur = $this->uri->segment(10);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {   
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        // if($pembiayaan == 0){
        //     $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk);
        // } else {
        //     //
        // }
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk,$kreditur);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $trx_date = $result['trx_date'];
            $trx_date = $this->format_date_detail($trx_date,'id',false,'-');
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $produk = $result['nick_name'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $jangka_waktu = $result['jangka_waktu'];
            $angsuran_pokok = $result['bayar_pokok'];
            $angsuran_margin = $result['bayar_margin'];
            $angsuran_catab = $result['bayar_catab'];
            $jml_bayar = $result['jml_bayar'];
            $kas_petugas = $result['account_cash_name'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tanggal Bayar' => $trx_date,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Jangka Waktu' => $jangka_waktu,
                'Angsuran Pokok' => $angsuran_pokok,
                'Angsuran Margin' => $angsuran_margin,
                'Angsuran catab' => $angsuran_catab,
                'Jumlah Bayar' => $jml_bayar,
                'Kas Petugas' => $kas_petugas
            );
        }

        download_send_headers('LAPORAN_ANGSURAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_list_outstanding_pembiayaan(){
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $peruntukan = $this->uri->segment(8);
        $sektor = $this->uri->segment(9);
        $cif_type = $this->uri->segment(10);
        $kreditur = $this->uri->segment(11);
        $tanggal = date('Y-m-d');        

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else if($pembiayaan == 9){
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if($cif_type == 1){
            $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_ind($cabang,$cif_type,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur);            
        } else if($cif_type == 0){

            $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan($cabang,$cif_type,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur);
        }

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        if($cif_type == 0){

            for($i = 0; $i < count($datas); $i++){
                $result = $datas[$i];

                $rekening = $result['account_financing_no'];
                $nama = $result['nama'];
                $ktp = $result['no_ktp'];
                $jenis = $result['financing_type'];
                $majelis = $result['cm_name'];
                $produk = $result['nick_name'];
                $sektor = $result['sektor'];
                $peruntukan = $result['peruntukan'];
                $droping = $result['droping_date'];
                $jangka_waktu = $result['jangka_waktu'];
                $pokok = $result['pokok'];
                $margin = $result['margin'];
                $bayar = $result['freq_bayar_pokok'];
                $seharusnya = $result['seharusnya']-$result['hari_libur'];
                if ($seharusnya>$jangka_waktu) {$seharusnya=$jangka_waktu;};
                $saldo = $result['freq_bayar_saldo'];
                $saldo_pokok = $result['saldo_pokok'];
                $saldo_margin = $result['saldo_margin'];
                $saldo_catab = $result['saldo_catab'];            
                $kreditur = $result['krd'];
                $tgl_jtempo = $result['tanggal_jtempo'];
                $reschedulle = $result['fl_reschedulle'];
                $petugas = $result['fa_name'];

                if($jenis == '0'){ $pembiayaan = 'Kelompok'; } else { $pembiayaan = 'Individu'; }

                $arr_csv[] = array(
                'No'                 => ($i + 1),
                'Rekening'          => "'".$rekening,
                'Nama'              => $nama,
                'No. KTP'           => "'".$ktp,
                'Jenis'             => $pembiayaan,
                'Majelis'           => $majelis,
                'Produk'            => $produk,
                'Sektor'            => $sektor,
                'Peruntukan'        => $peruntukan,
                'Sumber Dana'       => $kreditur,
                'Droping'           => $droping,
                'Pokok'             => $pokok,
                'Margin'            => $margin,
                'Jangka Waktu'      => $jangka_waktu,
                'T. Jatuh Tempo'    => $tgl_jtempo,
                'Freq Bayar'        => $bayar, 
                'Freq Seharusnya'   => $seharusnya, 
                'Freq Sisa'         => $saldo,
                'Saldo Pokok'       => $saldo_pokok,
                'Saldo Margin'      => $saldo_margin,
                'Saldo catab'       => $saldo_catab,
                'Re-schedulle'      => $reschedulle,
                'Petugas'           => $petugas
                );
            }
        }else if($cif_type == 1){
            for($i = 0; $i < count($datas); $i++){
                $result = $datas[$i];

                $rekening = $result['account_financing_no'];
                $nama = $result['nama'];
                $ktp = $result['no_ktp'];
                // $jenis = $result['financing_type'];
                // $majelis = $result['cm_name'];
                $produk = $result['nick_name'];
                $sektor = $result['sektor'];
                $peruntukan = $result['peruntukan'];
                $kreditur = $result['krd'];
                $droping = $result['droping_date'];
                $pokok = $result['pokok'];
                $margin = $result['margin'];
                $bayar = $result['freq_bayar_pokok'];
                $saldo = $result['freq_bayar_saldo'];
                $saldo_pokok = $result['saldo_pokok'];
                $saldo_margin = $result['saldo_margin'];
                $saldo_catab = $result['saldo_catab'];
                $jangka_waktu = $result['jangka_waktu'];
                $jangka_waktu = $result['jangka_waktu'];
                $tgl_jtempo = $result['tanggal_jtempo'];
                $reschedulle = $result['fl_reschedulle'];
                $petugas = $result['fa_name'];

                if($jenis == '0'){ $pembiayaan = 'Kelompok'; } else { $pembiayaan = 'Individu'; }

                $arr_csv[] = array(
                'No' => ($i + 1),
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'No. KTP' => "'".$ktp,
                // 'Jenis' => $pembiayaan,
                // 'Majelis' => $majelis,
                'Produk' => $produk,
                'Sektor' => $sektor,
                'Peruntukan' => $peruntukan,
                'Sumber Dana' => $kreditur,
                'Droping' => $droping,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Jangka Waktu' => $jangka_waktu,
                'T. Jatuh Tempo' => $tgl_jtempo,
                'Bayar' => $bayar,
                'Freq' => $saldo,
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin,
                'Saldo Catab' => $saldo_catab,
                'Re-schedulle' => $reschedulle,
                'Petugas' => $petugas
                );
            }
        }

        download_send_headers('LAPORAN_OUTSTANDING_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_list_outstanding_pembiayaan_lalu(){
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $peruntukan = $this->uri->segment(8);
        $sektor = $this->uri->segment(9);
        $hari = $this->uri->segment(10);
        $bulan = $this->uri->segment(11);
        $tahun = $this->uri->segment(12);
        $kreditur = $this->uri->segment(13);
        $tanggal = $tahun.'-'.$bulan.'-'.$hari;

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_lalu($cabang,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal,$kreditur);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $ktp = $result['no_ktp'];
            $jenis = $result['financing_type'];
            $majelis = $result['cm_name'];
            $produk = $result['nick_name'];
            $sektor = $result['sektor'];
            $peruntukan = $result['peruntukan'];
            $kreditur = $result['krd'];
            $droping = $result['droping_date']; 
            $pokok = $result['pokok'];
            $margin = $result['margin']; 
            $jangka_waktu = $result['jangka_waktu'];
            $bayar = $result['freq_bayar_pokok'];
            $seharusnya = $result['seharusnya']-$result['hari_libur']; 
            if ($seharusnya>$jangka_waktu) {$seharusnya=$jangka_waktu;};
            $saldo = $result['freq_bayar_saldo'];            
            $saldo_pokok = $result['saldo_pokok'];
            $saldo_margin = $result['saldo_margin'];
            $saldo_catab = $result['saldo_catab'];
            $fl_reschedulle = $result['fl_reschedulle'];
            $tanggal_jtempo = $result['tanggal_jtempo'];
            $petugas = $result['fa_name'];

            if($jenis == '0'){
                $pembiayaan = 'Kelompok';
            } else {
                $pembiayaan = 'Individu';
            }

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'No. KTP' => "'".$ktp,
                'Jenis' => $pembiayaan,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Sektor' => $sektor,
                'Peruntukan' => $peruntukan,
                'Sumber Dana' => $kreditur,
                'Droping' => $droping,
                'Pokok' => $pokok,
                'Margin' => $margin, 
                'Jangka Waktu' => $jangka_waktu,
                'Freq Bayar' => $bayar,
                'Freq Seharusnya' => $seharusnya,
                'Freq Sisa' => $saldo,                
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin,
                'Saldo Catab' => $saldo_catab,
                'Reschedulle' => $fl_reschedulle,
                'Jatuh Tempo' => $tanggal_jtempo,
                'Petugas' => $petugas
            );
        }

        download_send_headers('LAP_OUTSTANDING_PEMBIAYAAN_BULAN_LALU_'.$jenis2.'_'.$data_cabang.'_'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_list_outstanding_tabungan_lalu(){
        $cabang = $this->uri->segment(3);
        $tabungan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $hari = $this->uri->segment(8);
        $bulan = $this->uri->segment(9);
        $tahun = $this->uri->segment(10);
        $tanggal = $tahun.'-'.$bulan.'-'.$hari;

        if($petugas == '00000'){
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_tabungan_lalu($cabang,$tabungan,$petugas,$majelis,$produk,$tanggal);

        if($cabang != '00000'){
            $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $rekening = $datas[$i]['account_saving_no'];
            $nama = $datas[$i]['nama'];
            $ktp = $datas[$i]['no_ktp'];
            $majelis = $datas[$i]['cm_name'];
            $produk = $datas[$i]['nick_name'];
            $saldo = $datas[$i]['saldo_memo'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'No. KTP' => "'".$ktp,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Sektor' => number_format($saldo,2,',','.')
            );
        }

        download_send_headers('LAPORAN_SALDO_TABUNGAN_BULAN_LALU_'.$cabang.'_'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    } 


    function export_list_saldo_tbg(){
        $cabang = $this->uri->segment(3);
        $tabungan = $this->uri->segment(4);
        $produk = $this->uri->segment(5);

        $datas = $this->model_laporan_to_pdf->export_list_saldo_tbg($cabang,$tabungan,$produk);

        if($cabang != '00000'){
            $data['cabang'] = 'CABANG '.strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $rekening = $datas[$i]['account_saving_no'];
            $nama = $datas[$i]['nama'];
            $ktp = $datas[$i]['no_ktp'];
            $majelis = $datas[$i]['cm_name'];
            $produk = $datas[$i]['nick_name'];
            $saldo = $datas[$i]['saldo_memo'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'No. KTP' => "'".$ktp,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Saldo' => number_format($saldo,2,',','.')
            );
        }

        download_send_headers('LAPORAN_SALDO_TABUNGAN_'.$cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }



    function export_lap_list_outstanding_pembiayaan_individu(){
        $tanggal = date('Y-m-d');
        $cabang     = $this->uri->segment(3);   
        $product_code   = $this->uri->segment(4);
        $peruntukan   = $this->uri->segment(5);
        $sektor   = $this->uri->segment(6);

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_individu($cabang,$tanggal,$product_code,$peruntukan,$sektor);

        if($cabang !='00000'){
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data_cabang = "Semua Cabang";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $account_financing_no   = $result['account_financing_no'];
            $nama                   = $result['nama'];
            $no_ktp                 = $result['no_ktp'];
            $cm_name                = $result['cm_name'];
            $pn                     = $result['pn'];
            $fdt                    = $result['fdt'];
            $desa                   = $result['desa'];
            $droping_date           = $result['droping_date'];
            $pokok                  = $result['pokok'];
            $margin                 = $result['margin'];
            $freq_bayar_pokok       = $result['freq_bayar_pokok'];
            $freq_bayar_saldo       = $result['freq_bayar_saldo'];
            $saldo_pokok            = $result['saldo_pokok'];
            $saldo_margin           = $result['saldo_margin'];
            $saldo_catab            = $result['saldo_catab'];
            $display_text            = $result['display_text'];

            $arr_csv[] = array(
                'No'               => ($i + 1),
                'No Rekening'      => $account_financing_no,
                'Nama'             => $nama,
                'No.KTP'           => $no_ktp,
                'Rembug'           => $cm_name,
                'Akad'             => $pn,
                'Sektor'           => $fdt,
                'Desa'             => $desa,
                'Tanggal Droping'  => $droping_date,
                'Pokok'            => $pokok,
                'Margin'           => $margin,
                'Freq Bayar'       => $freq_bayar_pokok,
                'Freq'             => $freq_bayar_saldo,
                'Pokok'            => $saldo_pokok,
                'Margin'           => $saldo_margin,
                'Catab'            => $saldo_catab,
                'Peruntukan'       => $display_text
            );
        }

        download_send_headers('LIST_OUTSTANDING_PEMBIAYAAN_'.$data_cabang.'_'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    }
    

	function list_pelunasan_pembiayaan(){
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $from = $this->uri->segment(7);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(8);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $kreditur = $this->uri->segment(9);

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$from,$thru,$kreditur);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

		$arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
        	$result = $datas[$i];

            $tanggal_lunas = $result['tanggal_lunas'];
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $jangka_waktu = $result['jangka_waktu'];
            $jtempo = $result['tanggal_jtempo'];
            $saldo_pokok = $result['saldo_pokok'];
            $saldo_margin = $result['saldo_margin'];
            $periode_jangka_waktu = $result['periode_jangka_waktu'];
            $counter = $result['counter_angsuran'];
            $financing_type = $result['financing_type'];
            $saldo_catab = $result['saldo_catab'];
            $saldo_wajib = $result['saldo_wajib'];
            $saldo_kelompok = $result['saldo_kelompok'];
            $saldo_kelompok = $result['saldo_kelompok'];
            $status_pelunasan = $result['status_pelunasan'];
            $sumber_dana = $result['krd'];

            $sisa = $jangka_waktu - $counter;

            if($periode_jangka_waktu == '0'){
                $periode = 'Hari';
            } else if($periode_jangka_waktu == '1'){
                $periode = 'Minggu';
            } else if($periode_jangka_waktu == '2'){
                $periode = 'Bulan';
            } else if($periode_jangka_waktu == '3'){
                $periode = 'Jatuh Tempo';
            }
            if($financing_type == '0'){
                $pembiayaan = 'Kelompok';
            } else {
                $pembiayaan = 'Individu';
            }
            if($status_pelunasan == '0'){
                $stat_lunas = 'T';
            } else {
                $stat_lunas = 'Y';
            }

            $arr_csv[] = array(
            	'No' => ($i + 1),
            	'Tanggal Lunas' => $tanggal_lunas,
            	'Rekening' => "'".$rekening,
            	'Nama' => $nama,
            	'Majelis' => $majelis,
                'Pembiayaan' => $pembiayaan,
                'Sumber Dana' => $sumber_dana,
            	'Pokok' => $pokok,
            	'Margin' => $margin,
            	'Jangka Waktu' => $jangka_waktu,
                'Jatuh Tempo' => $jtempo,
            	'Cnt' => $sisa,
            	'Saldo Pokok' => $saldo_pokok,
            	'Saldo Margin' => $saldo_margin,
                'Saldo Catab' => $saldo_catab,
                'Saldo Wajib' => $saldo_wajib,
                'Saldo Kelompok' => $saldo_kelompok,
                'Verif' => $stat_lunas

            );
        }

        download_send_headers('LAPORAN_PELUNASAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
	}

	function export_list_jatuh_tempo(){
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $from = $this->uri->segment(7);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(8);
        $thru = $this->datepicker_convert(true,$thru,'/');

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->export_list_jatuh_tempo($cabang,$pembiayaan,$petugas,$majelis,$from,$thru);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }
        
        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $tanggal_akad = $result['tanggal_akad'];
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $desa = $result['desa'];
            $ke = $result['ke'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $jangka_waktu = $result['jangka_waktu'];
            $jtempo = $result['tanggal_jtempo'];
            $periode_jangka_waktu = $result['periode_jangka_waktu'];
            $financing_type = $result['financing_type'];
            $saldo_pokok = $result['saldo_pokok'];
            $angsuran_pokok = $result['angsuran_pokok'];

            if($periode_jangka_waktu == '0'){
                $periode = 'Hari';
            } else if($periode_jangka_waktu == '1'){
                $periode = 'Minggu';
            } else if($periode_jangka_waktu == '2'){
                $periode = 'Bulan';
            } else if($periode_jangka_waktu == '3'){
                $periode = 'Jatuh Tempo';
            }
            
            if($financing_type == '0'){
                $pembiayaan = 'Kelompok';
            } else {
                $pembiayaan = 'Individu';
            }

            $sisa_angsuran = $saldo_pokok / $angsuran_pokok;
            $sisa = ceil($sisa_angsuran);

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tgl Droping' => $tanggal_akad,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Majelis' => $majelis,
                'Jenis' => $pembiayaan,
                'Desa' => $desa,
                'Pembiayaan Ke' => $ke,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Sisa' => $sisa.' '.$periode,
                'Jangka Wajtu' => $jangka_waktu.' '.$periode,
                'Jatuh Tempo' => $jtempo
            );
        }

        download_send_headers('LAPORAN_JATUH_TEMPO_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_buka_tabungan()
    {
        $produk         = $this->uri->segment(3);        
        $from_date1     = $this->uri->segment(4);
        $from_date      = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1     = $this->uri->segment(5);   
        $thru_date      = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);
        $cabang         = $this->uri->segment(6);
        $datas          = $this->model_laporan->export_list_buka_tabungan($produk,$from_date,$thru_date,$cabang);
        $produk_name    = $this->model_laporan->get_produk($produk);
        if($produk_name!=null){
            $produk_name = $produk_name;
        }else{
            $produk_name = "SEMUA PRODUK";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $status_rekening = $datas[$i]['status_rekening'];
                if($status_rekening==1){
                    $status_rekening = "Aktif";
                }else{
                    $status_rekening = "Tidak Aktif";
                }


            $result = $datas[$i];

            
            $account_saving_no = $result['account_saving_no'];
            $nama = $result['nama'];
            $cm_name = $result['cm_name'];
            $product_name = $result['product_name'];
            $tanggal_buka = $result['tanggal_buka'];
            $rencana_jangka_waktu = $result['rencana_jangka_waktu'];
            // $tanggal_jtempo = $result['tanggal_jtempo'];
            $rencana_setoran = $result['rencana_setoran'];
            $status_rekening = $result['status_rekening'];
            $saldo_memo = $result['saldo_memo'];
            
            if ($result['rencana_periode_setoran']==0){
              $tanggal_jtempo = date("Y-m-d",strtotime($result['tanggal_buka'].'+'.$result['rencana_jangka_waktu'].' months'));
            } else if ($result['rencana_periode_setoran']==1){
              $tanggal_jtempo = date("Y-m-d",strtotime($result['tanggal_buka'].'+'.$result['rencana_jangka_waktu'].' weeks'));
            } else if ($result['rencana_periode_setoran']==2){
              $tanggal_jtempo = date("Y-m-d",strtotime($result['tanggal_buka'].'+'.$result['rencana_jangka_waktu'].' days'));
            }

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No. Rekening' => $account_saving_no,
                'Nama' => $nama,
                'Produk' => $product_name,
                'Tgl Buka' => $tanggal_buka,
                'Jangka Waktu' => $rencana_jangka_waktu,
                'Tanggal Jtempo'=> $tanggal_jtempo,
                'Setoran' => $rencana_setoran,
                'Status' => $status_rekening,
                'Saldo' => $saldo_memo
                
            );
        }

        download_send_headers('LIST_PEMBUKAAN_REK_TAB'.$cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_buka_tabungan_jtempo(){
        $produk         = $this->uri->segment(3);        
        $from_date1     = $this->uri->segment(4);
        $from_date      = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1     = $this->uri->segment(5);   
        $thru_date      = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);
        $cabang         = $this->uri->segment(6);
        $status         = $this->uri->segment(7);
        $rembug         = $this->uri->segment(8);
        $datas          = $this->model_laporan->export_list_buka_tabungan_jtempo($produk,$from_date,$thru_date,$cabang,$status,$rembug);
        $produk_name    = $this->model_laporan->get_produk($produk);

        if($produk_name!=null){
            $produk_name = $produk_name;
        }else{
            $produk_name = "SEMUA PRODUK";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $status_rekening = $datas[$i]['status_rekening'];

            if($status_rekening == 0)
            {
                $status_rekening = "Registrasi";
            }
            else if($status_rekening == 1)
            {
                $status_rekening = "Aktif";
            }
            else if($status_rekening == 2)
            {
                $status_rekening = "Cair / Tutup";
            }
            else if($status_rekening == 3)
            {
                $status_rekening = "Proses Pencarian";
            }
            else{
                $status_rekening = "Anggota Keluar";
            }

            $result = $datas[$i];

            $tanggal_buka = $result['tanggal_buka'];

            $account_saving_no = $result['account_saving_no'];
            $nama = $result['nama'];
            $product_name = $result['product_name'];
            $rencana_jangka_waktu = $result['rencana_jangka_waktu'];
            $rencana_setoran = $result['rencana_setoran'];
            $saldo_memo = $result['saldo_memo'];
            $counter_angsruan = $result['counter_angsruan'];
            $rembug = $result['cm_name'];
            

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tgl Buka' => $tanggal_buka,
                'No Rekening' => $account_saving_no,
                'Majelis' => $rembug,
                'Nama' => $nama,
                'Produk' => $product_name,
                'Jangka Waktu' => $rencana_jangka_waktu,
                'Setoran' => $rencana_setoran,
                'Bayar' => $counter_angsruan,
                'Saldo' => $saldo_memo,
                'Status' => $status_rekening
            );
        }

        download_send_headers('LIST_JATUH_TEMPO'.$from_date.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_pembukaan_tabungan(){
        $produk      = $this->uri->segment(3);       
        $branch_code    = $this->uri->segment(4);

        $now = date('Y-m-d');

        if($branch_code=='00000'){
            $branch_name = 'KANTOR PUSAT';
        }else{
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = 'KANTOR CABANG '.strtoupper($branch['branch_name']);
        }

        $datas          = $this->model_laporan->export_list_pembukaan_tabungan($produk,$branch_code);
        
        if($produk == 'all'){
            $produk_name = 'SEMUA PRODUK';
        } else {
            $produk_name = $this->model_laporan->get_produk($produk);
        } 

        $arr_csv = array();
        for($i = 0; $i < count($datas); $i++){
            $status_rekening = $datas[$i]['status_rekening'];
                if($status_rekening==1){
                    $status_rekening = "Aktif";
                }else{
                    $status_rekening = "Tidak Aktif";
                }


            $result = $datas[$i];
            $account_saving_no = $result['account_saving_no'];
            $cm_name = $result['cm_name'];
            $nama = $result['nama'];
            $product_name = $result['product_name'];
            $tanggal_buka = $result['tanggal_buka'];
            $rencana_jangka_waktu = $result['rencana_jangka_waktu'];
            $rencana_setoran = $result['rencana_setoran'];
            $counter_angsruan = $result['counter_angsruan'];
            $saldo_memo = $result['saldo_memo'];
            

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No Rekening' => $account_saving_no,
                'Majelis' => $cm_name,
                'Nama' => $nama,
                'Produk' => $product_name,
                'Tanggal Buka' => $tanggal_buka,
                'Rencana Jangka Waktu' => $rencana_jangka_waktu,
                'Setoran' => $rencana_setoran,
                'Terbayar' => $counter_angsruan,
                'Saldo' => $saldo_memo,
                'Aktif' => $status_rekening
            );
        }

        download_send_headers('LIST_SALDO_TABUNGAN_'.$produk.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_blokir_tabungan(){
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date,4,4).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date  = $this->uri->segment(4);   
        $thru_date = substr($thru_date,4,4).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2); 
        $branch_code    = $this->uri->segment(5);

        $datas = $this->model_laporan_to_pdf->export_list_blokir_tabungan($from_date,$thru_date,$branch_code);

        if($branch_code=='00000'){
            $branch_name = 'KANTOR PUSAT';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = 'KANTOR CABANG '.strtoupper($branch['branch_name']);
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $status_rekening = $datas[$i]['status_rekening'];

            if($status_rekening==1){
                $status_rekening = "Aktif";
            }else{
                $status_rekening = "Tidak Aktif";
            }

            $result = $datas[$i];
            $no_rek = $result['no_rek'];
            $nama = $result['nama'];
            $tgl_blokir = $result['tgl_blokir'];
            $jumlah = $result['jumlah'];
            $tgl_buka = $result['tgl_buka'];
            $keterangan = $result['keterangan'];

            $arr_csv[] = array(
                'No'                => ($i + 1),
                'No Rekening'       => $no_rek,
                'Nama'              => $nama,
                'Tangggal Blokir'   => $tgl_blokir,
                'Jumlah'            => $jumlah,
                'Tangggal Buka'     => $tgl_buka,
                'Keterangan'        => $keterangan  
            );
        }

        download_send_headers('LIST_BLOKIR_TABUNGAN_'.$from_date.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_pencairan_tabungan_berencana(){
        $produk    = $this->uri->segment(3);
        $from_date = $this->uri->segment(4);
        $from_date = substr($from_date,4,5).'-'.substr($from_date,2,2).'-'.substr($from_date,0,2);
        $thru_date = $this->uri->segment(5);    
        $thru_date = substr($thru_date,4,5).'-'.substr($thru_date,2,2).'-'.substr($thru_date,0,2);          
        $cabang = $this->uri->segment(6);               
        $rembug = $this->uri->segment(7);

        $datas = $this->model_laporan_to_pdf->export_lap_pencairan_tabungan_berencana($produk,$cabang,$rembug,$from_date,$thru_date);

        if($cabang !='00000'){

            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data_cabang = "Semua Cabang";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $id_anggota = $result['id_anggota'];
            $nama = $result['nama'];
            $majelis = $result['majelis'];
            $produk = $result['product_name'];
            $tanggal_buka = $result['tanggal_buka'];
            $jangka_waktu = $result['jangka_waktu'];
            $tanggal_cair = $result['tanggal_cair'];
            $pencairan = $result['pencairan'];

            $arr_csv[] = array(
                'No'                => ($i + 1),
                'ID Anggota'        => "'".$id_anggota,
                'Nama'              => $nama,
                'Majelis'           => $majelis,
                'Produk'            => $produk,
                'Tanggal Buka'      => $tanggal_buka,
                'Jangka Waktu'      => $jangka_waktu,
                'Tanggal Cair'      => $tanggal_cair,
                'Pencarian'         => $pencairan  
            );
        }

        download_send_headers('LIST_PENCARIAN_TABUNGAN_'.$from_date.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_transaksi_rembug(){
        $branch_code = $this->uri->segment(3);
        $from_trx_date = $this->datepicker_convert(false,$this->uri->segment(4));
        $thru_trx_date = $this->datepicker_convert(false,$this->uri->segment(5));
        $cm_code = $this->uri->segment(6);
        $fa_code = $this->uri->segment(7);

        if($branch_code!='00000'){
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        }else{
            $branch_id = $branch_code;
        }

        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        if($cm_code==false){
            $rembug['cm_code'] = false;
            $rembug['cm_name'] = 'Semua Rembug';
        }else{
            $rembug = $this->model_cif->get_cm_by_cm_code($cm_code);
        }

        // $datas = $this->model_laporan->export_list_transaksi_rembug($branch_code,$cm_code,$from_trx_date,$thru_trx_date,$fa_code);

        

        $arr_csv = array();

        // for($i = 0; $i < count($datas); $i++){


            $datass = $this->model_laporan->export_list_transaksi_rembug_sub2($branch_code,$cm_code,$from_trx_date,$thru_trx_date,$fa_code);
            // $datass = $this->model_laporan->export_list_transaksi_rembug_sub2($datas[$i]['trx_cm_id'],$from_trx_date,$thru_trx_date,$datas[$i]['trx_date']);

            

            // echo "<pre>";
            // echo print_r($datass);
            // die();

            for ( $j = 0 ; $j < count($datass) ; $j++ )
            {
            $result = $datass[$j];
            // $resultt = $datas[$i];

            
            $created_date       = $result['tanggal_transaksi'];
            $trx_date           = $result['tgl_bayar'];
            $cm_name            = $result['majlis'];
            $fa_name            = $result['nama_petugas'];
            $cif_no             = $result['id_anggota'];
            $nama               = $result['nama'];
            $freq               = $result['freq'];
            $angsuran_pokok     = $result['angsuran_pokok'];
            $angsuran_margin    = $result['angsuran_margin'];
            $angsuran_catab     = $result['angsuran_catab'];
            $setoran_lwk        = $result['lwk'];
            $tab_sukarela_cr    = $result['setoran_sukarela'];
            $tab_wajib_cr       = $result['wajib'];
            $tab_kelompok_cr    = $result['kelompok'];
            $tab_sukarela_db    = $result['penarikan_sukarela'];
            $pokok              = $result['plafon'];
            $administrasi       = $result['adm'];
            $asuransi           = $result['asuransi']; 
            $keterangan         = $result['keterangan']; 

            // if($setoran_lwk == NULL){
            //     $setoran_lwk_ ="0";
            // }
            // if($pokok == NULL){
            //     $pokok_ ="0";
            // }
            // if($administrasi == NULL){
            //     $administrasi_ ="0";
            // }
            // if($asuransi == NULL){
            //     $asuransi_ ="0";
            // }

            $arr_csv[] = array(
                
                'No'                => ($j + 1),
                'Tanggal Transaksi' => $created_date,
                'Tanggal Bayar'     => $trx_date,
                'Majelis'           => $cm_name,
                'Nama Petugas'      => $fa_name,
                'ID Anggota'        => "'".$cif_no,
                'Nama'              => $nama,
                'freq'              => $freq,
                'Pokok'             => $angsuran_pokok,
                'Margin'            => $angsuran_margin,
                'Catab'             => $angsuran_catab,
                'LWK'               => $setoran_lwk,
                'Sukarela'          => $tab_sukarela_cr,
                'Wajib'             => $tab_wajib_cr,
                'Kelompok'          => $tab_kelompok_cr,
                'sukarela'          => $tab_sukarela_db,
                'Plafon'            => $pokok,
                'Adm.'              => $administrasi,
                'Asuransi'          => $asuransi, 
                'Keterangan'        => $keterangan 
            );
        }
        // }

        download_send_headers('LIST_TRANSAKSI_REMBUG'.$from_trx_date.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_saldo_kas_petugas(){
        $tanggal = $this->uri->segment(3);
        $tanggal2 = substr($tanggal,4,4).'-'.substr($tanggal,2,2).'-'.substr($tanggal,0,2);
        $cabang = $this->uri->segment(4);
        $account_cash_code = $this->uri->segment(5);

        $datas = $this->model_laporan_to_pdf->export_saldo_kas_petugas($cabang,$tanggal2);
        $cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang); 
        
        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $account_cash_code  = $result['account_cash_code'];
            $fa_name            = $result['fa_name'];
            $saldoawal          = $result['saldoawal'];
            $mutasi_debet       = $result['mutasi_debet'];
            $mutasi_credit      = $result['mutasi_credit'];
            $saldoakhir         = $datas[$i]['saldoawal']+$datas[$i]['mutasi_debet']-$datas[$i]['mutasi_credit'];
            

            $arr_csv[] = array(
                'No'            => ($i + 1),
                'Kas Petugas'   => $account_cash_code,
                'Pemegang Kas'  => $fa_name,
                'Saldo Awal'    => $saldoawal,
                'Mutasi Debet'  => $mutasi_debet,
                'Mutasi Credit' => $mutasi_credit,
                'Saldo Akhir'   => $saldoakhir
                
                
            );
        }

        download_send_headers('LIST_TRANSAKSI_REMBUG'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    }
    
    function export_list_saldo_tabungan(){
        $branch_code = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $cm_code = $this->uri->segment(5);
        
        $datas = $this->model_laporan->export_list_saldo_tabungan($branch_code,$fa_code,$cm_code);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $tanggal_mulai_angsur = '';
            if(@$datas[$i]['tanggal_mulai_angsur']==null || @$datas[$i]['tanggal_mulai_angsur']==""){
                $tanggal_mulai_angsur = '';
            }else{
                $tanggal_mulai_angsur = $this->format_date_detail($datas[$i]['tanggal_mulai_angsur'],'id',false,'/');
            }

            $result = $datas[$i];

            $cif_no             = $result['cif_no'];
            $nama               = $result['nama'];
            $cm_name            = $result['cm_name'];
            $desa               = $result['desa'];
            $pokok              = $result['pokok'];
            $margin             = $result['margin'];
            $setoran_lwk        = $result['setoran_lwk'];
            $tabungan_minggon   = $result['tabungan_minggon'];
            $tabungan_kelompok  = $result['saldo_dtk'];
            $tabungan_sukarela  = $result['tabungan_sukarela'];
            $saldo_pokok        = $result['saldo_pokok'];
            $saldo_margin       = $result['saldo_margin'];
            $petugas            = $result['fa_name'];

            $arr_csv[] = array(
                'No'                    => ($i + 1),
                'ID'                    => $cif_no,
                'Nama'                  => $nama,
                'Rembug Pusat'          => $cm_name,
                'Desa'                  => $desa,
                'Pembiayaan Pokok'      => $pokok,
                'Pembiayaan Margin'     => $margin,
                'LWK'                   => $setoran_lwk,
                'Wajib'                 => $tabungan_minggon,
                'Kelompok'              => $tabungan_kelompok,
                'Sukarela'              => $tabungan_sukarela,
                'Pokok'                 => $saldo_pokok,
                'Margin'                => $saldo_margin,
                'Petugas'               => $petugas 
            );
        }

        download_send_headers('LIST_SALDO_ANGGOTA_'.$branch_code.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_saldo_anggota(){
        $branch_code = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $cm_code = $this->uri->segment(5);
        
        $datas = $this->model_laporan->export_list_saldo_anggota($branch_code,$fa_code,$cm_code);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            
            $result = $datas[$i];

            $cif_no             = $result['cif_no'];
            $nama               = $result['nama'];
            $cm_name            = $result['cm_name'];
            $desa               = $result['desa'];
            $setoran_lwk        = $result['setoran_lwk'];
            $tabungan_minggon   = $result['tabungan_minggon'];
            $tabungan_kelompok  = $result['saldo_dtk'];
            $tabungan_sukarela  = $result['tabungan_sukarela'];
            $tabungan_berencana = $result['saldo_taber'];
            $pokok              = $result['pokok'];
            $margin             = $result['margin'];
            $saldo_pokok        = $result['saldo_pokok'];
            $saldo_margin       = $result['saldo_margin'];
            $petugas            = $result['fa_name'];

            $arr_csv[] = array(
                'No'                    => ($i + 1),
                'ID'                    => $cif_no,
                'Nama'                  => $nama,
                'Rembug Pusat'          => $cm_name,
                'Desa'                  => $desa, 
                'LWK'                   => $setoran_lwk,
                'Wajib'                 => $tabungan_minggon,
                'Kelompok'              => $tabungan_kelompok,
                'Sukarela'              => $tabungan_sukarela,
                'Tab berencana'         => $tabungan_berencana,
                'Pemby. Pokok'          => $pokok,
                'Pemby. Margin'         => $margin,
                'Saldo Pokok'           => $saldo_pokok,
                'Saldo Margin'          => $saldo_margin,
                'Petugas'               => $petugas 
            );
        }

        download_send_headers('LIST_SALDO_REK_ANGGOTA_'.$branch_code.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_lap_list_premi_anggota(){
        $cabang = $this->uri->segment(3);
        $rembug = $this->uri->segment(4);
        $product_code = $this->uri->segment(5);
        $financing_type = $this->uri->segment(6);

        if($financing_type == 1){
            $rembug = '00000';
            $jenis = 'INDIVIDU';
        } else {
            $jenis = 'KELOMPOK';
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_premi_anggota($cabang,$rembug,$product_code,$financing_type);

        if($cabang != '00000'){
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data_cabang = "SEMUA CABANG";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $tanggal_mulai_angsur = '';
            if(@$datas[$i]['tanggal_mulai_angsur']==null || @$datas[$i]['tanggal_mulai_angsur']==""){
                $tanggal_mulai_angsur = '';
            }else{
                $tanggal_mulai_angsur = $this->format_date_detail($datas[$i]['tanggal_mulai_angsur'],'id',false,'/');
            }

            $result = $datas[$i];

            $account_financing_no        = $result['account_financing_no'];
            $nama                        = $result['nama'];
            $cm_name                     = $result['cm_name'];
            $tgl_lahir                   = $result['tgl_lahir'];
            $usia                        = $result['usia'];
            $p_nama                      = $result['p_nama'];
            $tanggal_peserta_asuransi    = $result['tanggal_peserta_asuransi'];
            $p_usia                      = $result['p_usia'];
            $pokok                       = $result['pokok'];
            $droping_date                = $result['droping_date'];
            $jangka_waktu                = $result['jangka_waktu']; 
            $tanggal_jtempo              = $result['tanggal_jtempo'];
            $saldo_pokok                 = $result['saldo_pokok'];
            $biaya_asuransi_jiwa         = $result['biaya_asuransi_jiwa'];
                         
            if($usia!=''){
                $a = explode(' ',$usia);
                $umur = $a[0].' Tahun '.@$a[2].' Bulan ';
            }else{
                $umur = '';
            }

            if($p_usia != ''){
                $b = explode(' ',$p_usia);
                @$p_umur = $b[0].' Tahun '.$b[2].' Bulan ';
            }else{
                $p_umur = ' ';
            }

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No Rekening' => "'".$account_financing_no,
                'Nama Anggota' => $nama,
                'Rembug Pusat' => $cm_name,
                'Tg Lahir' => $tgl_lahir,
                'Usia' => $umur,
                'Nama Pasangan' => $p_nama,
                'Tg Lahir Pasangan' => $tanggal_peserta_asuransi,
                'Usia Pasangan' => $p_umur,
                'Pokok' => $pokok,
                'Tgl Droping' => $droping_date,
                'Jangka Waktu' => $jangka_waktu,
                'Tgl JTempo' => $tanggal_jtempo,
                'Saldo Pokok' => $saldo_pokok,
                'Biaya Asuransi' => $biaya_asuransi_jiwa
            );
        }

        download_send_headers('LIST_BIAYA_ASURANSI_ANGGOTA_'.$jenis.'_'.$data_cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_anggota_keluar(){
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);      
        $from_date1 = $this->uri->segment(5);
        $from_date  = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 = $this->uri->segment(6);   
        $thru_date  = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  
        $alasan = $this->uri->segment(7);   
      
        $datas = $this->model_laporan->export_list_anggota_keluar($branch_code,$cm_code,$from_date,$thru_date,$alasan);

        if($branch_code !='00000'){
            $cabang = $this->model_laporan_to_pdf->get_cabang($branch_code);
        } else {
            $cabang = "Semua Data";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $tanggal_mulai_angsur = '';
            if(@$datas[$i]['tanggal_mulai_angsur']==null || @$datas[$i]['tanggal_mulai_angsur']==""){
                $tanggal_mulai_angsur = '';
            }else{
                $tanggal_mulai_angsur = $this->format_date_detail($datas[$i]['tanggal_mulai_angsur'],'id',false,'/');
            }

            $result = $datas[$i];

            $cif_no                      = $result['cif_no'];
            $nama                        = $result['nama'];
            $cm_name                     = $result['cm_name'];
            $tgl_gabung                  = $result['tgl_gabung'];
            $tanggal_mutasi              = $result['tanggal_mutasi'];  

            $saldo_pembiayaan_pokok      = $result['saldo_pembiayaan_pokok']; 
            $saldo_pembiayaan_margin     = $result['saldo_pembiayaan_margin'];
            $saldo_pembiayaan_catab      = $result['saldo_pembiayaan_catab'];
            $saldo_tab_wajib             = $result['saldo_tab_wajib'];
            $saldo_tab_kelompok          = $result['saldo_tab_kelompok'];
            $saldo_tab_sukarela          = $result['saldo_tab_sukarela'];
            $saldo_tab_berencana         = $result['saldo_tab_berencana'];
            $saldo_simpanan_pokok        = $result['saldo_simpanan_pokok'];
            $saldo_smk                   = $result['saldo_smk'];
            $saldo_lwk                   = $result['saldo_lwk']; 

            $pembiayaan_ke_last          = $result['pembiayaan_ke_last']; 
            $tanggal_akad_last           = $result['tanggal_akad_last'];
            $pokok_last                  = $result['pokok_last'];
            $pokok                       = $result['pokok_last'];
            $margin                      = $result['margin_last'];
            $alasan                      = $result['alasan'];
            $alasan_keluar               = $result['alasan_keluar'];           
           
                         
            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => $cif_no,
                'Nama'                    => $nama,
                'Rembug Pusat'            => $cm_name,
                'Tanggal Gabung'          => $tgl_gabung,
                'Tanggal Keluar'          => $tanggal_mutasi, 

                'saldo_pembiayaan_pokok'  => $saldo_pembiayaan_pokok, 
                'saldo_pembiayaan_margin' => $saldo_pembiayaan_margin, 
                'saldo_pembiayaan_catab'  => $saldo_pembiayaan_catab, 
                'saldo_tab_wajib'         => $saldo_tab_wajib, 
                'saldo_tab_kelompok'      => $saldo_tab_kelompok, 
                'saldo_tab_sukarela'      => $saldo_tab_sukarela, 
                'saldo_tab_berencana'     => $saldo_tab_berencana, 
                'saldo_simpanan_pokok'    => $saldo_simpanan_pokok, 
                'saldo_smk'               => $saldo_smk, 
                'saldo_lwk'               => $saldo_lwk, 

                'PYD Terakhir ke'         => $pembiayaan_ke_last,
                'Tgl Droping Terakhir'    => $tanggal_akad_last,
                'Plafon PYD Terakhir'     => $pokok,
                'Margin PYD Terakhir'     => $margin,
                'Alasan Keluar'           => $alasan,
                'Keterangan Keluar'       => $alasan_keluar
            );
        }

        download_send_headers('LIST_ANGGOTA_KELUAR_'.$cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }



    function export_list_anggota_mutasi(){
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);      
        $from_date1 = $this->uri->segment(5);
        $from_date  = substr($from_date1,4,4).'-'.substr($from_date1,2,2).'-'.substr($from_date1,0,2);
        $thru_date1 = $this->uri->segment(6);   
        $thru_date  = substr($thru_date1,4,4).'-'.substr($thru_date1,2,2).'-'.substr($thru_date1,0,2);  
        $alasan = $this->uri->segment(7);   
      
        $datas = $this->model_laporan->export_list_anggota_mutasi($branch_code,$cm_code,$from_date,$thru_date,$alasan);

        if($branch_code !='00000'){
            $cabang = $this->model_laporan_to_pdf->get_cabang($branch_code);
        } else {
            $cabang = "Semua Data";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            
            $result = $datas[$i];

            $cif_no                      = $result['cif_no'];
            $nama                        = $result['nama'];
            $majlis_lama                 = $result['majlis_lama']; 
            $majlis_baru                 = $result['majlis_baru']; 
            $tanggal_mutasi              = $result['tanggal_mutasi'];  

            $saldo_pembiayaan_pokok      = $result['saldo_pembiayaan_pokok']; 
            $saldo_pembiayaan_margin     = $result['saldo_pembiayaan_margin'];
            $saldo_pembiayaan_catab      = $result['saldo_pembiayaan_catab'];
            $saldo_tab_wajib             = $result['saldo_tab_wajib'];
            $saldo_tab_kelompok          = $result['saldo_tab_kelompok'];
            $saldo_tab_sukarela          = $result['saldo_tab_sukarela'];
            $saldo_tab_berencana         = $result['saldo_tab_berencana'];
            $saldo_simpanan_pokok        = $result['saldo_simpanan_pokok'];
            $saldo_smk                   = $result['saldo_smk'];
            $saldo_lwk                   = $result['saldo_lwk']; 
;
            $alasan                      = $result['alasan'];
            $keterangan                  = $result['keterangan'];           
           
                         
            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => $cif_no,
                'Nama'                    => $nama,
                'Majlis Lama'             => $majlis_lama,
                'Majlis Baru'             => $majlis_baru,
                'Tanggal Mutasi'          => $tanggal_mutasi, 

                'saldo_pembiayaan_pokok'  => $saldo_pembiayaan_pokok, 
                'saldo_pembiayaan_margin' => $saldo_pembiayaan_margin, 
                'saldo_pembiayaan_catab'  => $saldo_pembiayaan_catab, 
                'saldo_tab_wajib'         => $saldo_tab_wajib, 
                'saldo_tab_kelompok'      => $saldo_tab_kelompok, 
                'saldo_tab_sukarela'      => $saldo_tab_sukarela, 
                'saldo_tab_berencana'     => $saldo_tab_berencana, 
                'saldo_simpanan_pokok'    => $saldo_simpanan_pokok, 
                'saldo_smk'               => $saldo_smk, 
                'saldo_lwk'               => $saldo_lwk, 

                'Alasan Mutasi'           => $alasan,
                'Keterangan Mutasi'       => $keterangan
            );
        }

        download_send_headers('LIST_MUTASI_ANGGOTA_'.$cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_list_anggota_masuk(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $fa_code = $this->uri->segment(4);
        $from = $this->uri->segment(5);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(6);
        $thru = $this->datepicker_convert(true,$thru,'/');
      
        $datas = $this->model_laporan->export_list_anggota_masuk($cabang,$majelis,$fa_code,$from,$thru);

        if($cabang !='00000'){
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data_cabang = "Semua Data";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];
            $cif_no                      = $result['cif_no'];
            $nama                        = $result['nama'];
            $cm_name                     = $result['cm_name'];
            $tgl_gabung                  = $result['tgl_gabung'];
            $ibu_kandung                 = $result['ibu_kandung'];
            $tmp_lahir                   = $result['tmp_lahir'];
            $tgl_lahir                   = $result['tgl_lahir'];
            $usia                        = $result['usia'];
            $alamat                      = $result['alamat'];
            $fa_code                     = $result['fa_name'];

            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => "'".$cif_no,
                'Nama'                    => $nama,
                'Majelis'                 => $cm_name,
                'Tanggal Gabung'          => $tgl_gabung,
                'Jenis Kelamin'           => 'Perempuan',
                'Ibu Kandung'             => $ibu_kandung,
                'Tempat Lahir'            => $tmp_lahir,
                'Tanggal Lahir'           => $tgl_lahir,
                'usia'                    => $usia,
                'Alamat'                  => $alamat,
                'Petugas'                 => $fa_code 
            );
        }

        download_send_headers('LIST_ANGGOTA_MASUK_'.$data_cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_list_anggota_absen(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $from = $this->uri->segment(5);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(6);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $user_id = $this->session->userdata('user_id');
      
        ///$insert_temp = $this->model_laporan_to_pdf->insert_temp_2($cabang,$report_code,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun);
        $insert_absen_report = $this->model_laporan_to_pdf->insert_absen_report($cabang,$majelis,$from,$thru,$user_id);

        $datas = $this->model_laporan->export_list_anggota_absen($cabang,$majelis,$from,$thru);

        if($cabang !='00000'){
            $data_cabang = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data_cabang = "Semua Data";
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];
            $cif_no                      = $result['cif_no'];
            $nama                        = $result['nama'];
            $cm_name                     = $result['cm_name'];
            $tgl_gabung                  = $result['tgl_gabung'];
            $hadir                       = $result['h'];
            $ijin                        = $result['i'];
            $sakit                       = $result['s'];
            $abstain                     = $result['a'];

            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => "'".$cif_no,
                'Nama'                    => $nama,
                'Majelis'                 => $cm_name,
                'Tanggal Gabung'          => $tgl_gabung,
                'Hadir'                   => $hadir,
                'Ijin'                    => $ijin,
                'Sakit'                   => $sakit,
                'Abstain'                 => $abstain
            );
        }

        download_send_headers('LIST_KEHADIRAN_ANGOTA_'.$data_cabang.'_'.$from.'_sd_'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }


    function export_lap_list_bagihasil(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $periode = $this->uri->segment(6);

        $datas = $this->model_laporan_to_pdf->export_lap_list_bagihasil($cabang,$majelis,$petugas,$periode);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $cif_no = $result['cif_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $bahas = $result['tab_sukarela_cr'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No. Anggota' => "'".$cif_no,
                'Nama' => $nama,
                'Majelis' => $majelis,
                'Bagi Hasil' => $bahas
            );
        }

       download_send_headers('LAPORAN_BAGI_HASIL_'.$data_cabang.'_PERIODE_'.$periode.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_list_bagihasil_shu(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $periode = $this->uri->segment(6);

        $datas = $this->model_laporan_to_pdf->export_lap_list_bagihasil_shu($cabang,$majelis,$petugas,$periode);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $cif_no = $result['cif_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $bahas = $result['amount'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No. Anggota' => "'".$cif_no,
                'Nama' => $nama,
                'Majelis' => $majelis,
                'Bagi Hasil' => $bahas
            );
        }

       download_send_headers('LAPORAN_BAHAS_SHU_'.$data_cabang.'_PERIODE_'.$periode.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function list_anggota(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);

        $datas = $this->model_laporan_to_pdf->export_list_anggota2($cabang,$majelis);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            if($result['jenis_kelamin'] == 'P'){
                $jenis_kelamin = 'Perempuan';
            } else {
                $jenis_kelamin = 'Laki-laki';
            }

            $arr_csv[] = array(
                'Majelis' => $result['cm_name'],
                'ID Anggota' => "'".$result['cif_no'],
                'Nama' => $result['nama'],
                'Panggilan' => $result['panggilan'],
                'Desa' => $result['desa'],
                'Kecamatan' => $result['kecamatan'],
                'Kabupaten' => $result['kabupaten'],
                'Tanggal Regis' => $result['tgl_gabung'],
                'Jenis Kelamin' => $jenis_kelamin,
                'BIN' => $result['ibu_kandung'],
                'Tempat Lahir' => $result['tmp_lahir'],
                'Tanggal Lahir' => $result['tgl_lahir'],
                'Usia' => $result['usia'],
                'Alamat' => $result['alamat'],
                'RT/RW' => $result['rt_rw'],
                'Kodepos' => $result['kodepos'],
                'KTP' => "'".$result['no_ktp'],
                'NPWP' => $result['no_npwp'],
                'Telp. Rumah' => $result['telpon_rumah'],
                'Telp. Seluler' => $result['telpon_seluler'],
                'Pendidikan' => $result['pendidikan'],
                'Status Kawin' => $result['status_perkawinan'],
                'Pekerjaan' => $result['pekerjaan'],
                'Ket. Pekerjaan' => $result['ket_pekerjaan'],
                'Pendapatan' => $result['pendapatan_perbulan'],
                'Setoran LWK' => $result['setoran_lwk'],
                'Setoran Mingguan' => $result['setoran_mingguan'],
                'Literasi Latin' => $result['literasi_latin'],
                'Literasi Arab' => $result['literasi_arab'],
                'Nama Pasangan' => $result['p_nama'],
                'Tempat Lahir Pasangan' => $result['p_tmplahir'],
                'Tanggal Lahir Pasangan' => $result['p_tglahir'],
                'Usia Pasangan' => $result['p_usia'],
                'Pendidikan Pasangan' => $result['p_pendidikan'],
                'Pekerjaan Pasangan' => $result['p_pekerjaan'],
                'Ket. Pekerjaan Pasangan' => $result['p_ketpekerjaan'],
                'Pendapatan Pasangan' => $result['p_pendapatan'],
                'Periode Pendapatan' => $result['p_periodependapatan'],
                'Literasi Latin Pasangan' => $result['p_literasi_latin'],
                'Literasi Arab Pasangan' => $result['p_literasi_arab'],
                'Jumlah Tanggungan Pasangan' => $result['p_jmltanggungan'],
                'Jumlah Keluarga Pasangan' => $result['p_jmlkeluarga'],
                'Rumah Status' => $result['rmhstatus'],
                'Rumah Ukuran' => $result['rmhukuran'],
                'Rumah Atap' => $result['rmhatap'],
                'Rumah Dinding' => $result['rmhdinding'],
                'Rumah Lantai' => $result['rmhlantai'],
                'Rumah Jamban' => $result['rmhjamban'],
                'Rumah Air' => $result['rmhair'],
                'Lahan Sewa' => $result['lahansawah'],
                'Lahan Kebun' => $result['lahankebun'],
                'Lahan Pekarangan' => $result['lahanpekarangan'],
                'Ternak Kerbau' => $result['ternakkerbau'],
                'Ternak Domba' => $result['ternakdomba'],
                'Ternak Unggas' => $result['ternakunggas'],
                'ELek Tape' => $result['elektape'],
                'Elek TV' => $result['elektv'],
                'Elek Player' => $result['elekplayer'],
                'Elek Kulkas' => $result['elekkulkas'],
                'Sepeda' => $result['kendsepeda'],
                'Motor' => $result['kendmotor'] ,
                'Usaha Rumah Tangga' => $result['ushrumahtangga'],
                'Usaha Komoditi' => $result['ushkomoditi'],
                'Usaha Lokasi' => $result['ushlokasi'],
                'Usaha Omset' => $result['ushomset'],
                'Biaya Beras' => $result['byaberas'],
                'Biaya Dapur' => $result['byadapur'],
                'Biaya Listrik' => $result['byalistrik'],
                'Biaya Telepon' => $result['byatelpon'],
                'Biaya Sekolah' => $result['byasekolah'],
                'Biaya Lain' => $result['byalain']
            );
        }

        download_send_headers('LAPORAN_ANGGOTA_'.$data_cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_rekap_pengajuan_pembiayaan(){
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $kategori = $this->uri->segment(5);
        $from = $this->uri->segment(6);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(7);
        $thru = $this->datepicker_convert(true,$thru,'/');

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if($kategori == '1'){
            $by = 'Majelis';
        } else if($kategori == '2'){
            $by = 'Petugas';
        } else if($kategori == '3'){
            $by = 'Peruntukan';
        } else if($kategori == '4'){
            $by = 'Cabang';
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan($cabang,$pembiayaan,$kategori,$from,$thru);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        $sum_anggota = 0;
        $sum_pokok = 0;

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $sum_a = $result['jumlah_anggota'];
            $sum_p = $result['nominal'];

            $sum_anggota += $sum_a;
            $sum_pokok += $sum_p;
        }

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $jumlah_anggota = $result['jumlah_anggota'];
            $nominal = $result['nominal'];
            $keterangan = $result['keterangan'];
            $financing = $result['financing_type'];

            $persen_jumlah = ($jumlah_anggota / $sum_anggota) * 100;
            $persen_nominal = ($nominal / $sum_pokok) * 100;

            if($financing == '0'){
                $pembiayaan = 'Kelompok';
            } else {
                $pembiayaan = 'Individu';
            }

            $arr_csv[] = array(
                'No' => ($i + 1),
                $by => $keterangan,
                'Jumlah' => $jumlah_anggota,
                'Nominal' => $nominal,
                'Pembiayaan' => $pembiayaan,
                'Persentase Jumlah' => number_format($persen_jumlah,2,',','.').'%',
                'Persentas Nominal' => number_format($persen_nominal,2,',','.').'%'
            );
        }

        download_send_headers('LAPORAN_REKAP_PENGAJUAN_PEMBIAYAAN_BERDASARKAN_'.strtoupper($by).'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    // EXPORT LAPORAN LIST ANGGOTA BULAN LALU
    function export_lap_list_anggota_bulan_lalu(){
        $cabang = $this->uri->segment(3);
        $petugas = $this->uri->segment(4);
        $majelis = $this->uri->segment(5);
        $hari = $this->uri->segment(6);
        $bulan = $this->uri->segment(7);
        $tahun = $this->uri->segment(8);
        $tanggal = $tahun.'-'.$bulan.'-'.$hari;

        $datas = $this->model_laporan_to_pdf->export_lap_list_anggota_bulan_lalu($cabang,$petugas,$majelis,$tanggal);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $cif_no = $result['cif_no'];
            $nama               = $result['nama'];
            $rembug             = $result['cm_name'];
            $desa               = $result['desa'];
            $lwk                = $result['setoran_lwk'];
            $saldo_pokok        = $result['saldo_pokok'];
            $saldo_margin       = $result['saldo_margin'];
            $saldo_tab_sukarela = $result['saldo_tab_sukarela'];
            $pokok              = $result['pokok'];
            $margin             = $result['margin'];
            $saldo_tab_wajib    = $result['saldo_tab_wajib'];
            $saldo_tab_kelompok = $result['saldo_tab_kelompok'];
            $saldo_catab        = $result['saldo_catab'];
            $saldo_tabber       = $result['saldo_tabber'];
            
            $arr_csv[] = array(
                'No' => ($i + 1),
                'Cif No' => "'".$cif_no,
                'Nama' => $nama,
                'Majelis' => $rembug,
                'Desa' => $desa,
                'Lwk' => $lwk,
                'Saldo Simpanan Wajib' => $saldo_tab_wajib,
                'Saldo Simpanan Kelompok' => $saldo_tab_kelompok,
                'Saldo Simpanan Sukarela' => $saldo_tab_sukarela,
                'Pembiayaan pokok' => $pokok,
                'Pembiayaan Margin' => $margin,
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin,
                'Saldo Catab' => $saldo_catab,
                'Saldo Tabber' => $saldo_tabber
            );
        }

        download_send_headers('LAPORAN_LIST_SALDO_ANGGOTA_BULAN_LALU_'.$data_cabang.'_'.$tanggal.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    // List Wakalah | T | TGL 07-09-2017
    function export_list_wakalah(){
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true,$thru,'/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        
        $datas = $this->model_laporan_to_pdf->export_list_wakalah($from,$thru,$cabang,$majelis,$pembiayaan,$petugas,$produk);

        if($cabang != '00000'){
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($cabang)));
        } else {
            $data_cabang = 'SEMUA_CABANG';
        }

        if($pembiayaan == 1){
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $arr_csv = array(); 

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];
           
            $tanggal_wakalah    = $result['tanggal_wakalah'];
            $rekening           = $result['account_financing_no'];
            $nama               = $result['nama'];
            $majelis            = $result['cm_name'];
            $product            = $result['product_name'];
            $jumlah_wakalah     = $result['jumlah_wakalah'];
            $petugas            = $result['fa_name'];
            $status_wakalah     = $result['status_wakalah'];

            if($status_wakalah == 0){
                $status = 'Registrer';
            } else{
                $status = 'Reverse';
            }

            // if($financing == 0){
            //     $jenis = 'Kelompok';
            // } else{
            //     $jenis = 'Individu';
            // }

            if($tanggal_wakalah == ''){
                $tanggal = '-';
            } else {
                $tanggal = $this->format_date_detail($tanggal_wakalah,'id',false,'/');
            }

            $arr_csv[] = array(
                'No'                => ($i + 1),
                'Tanggal Wakalah'   => $tanggal,
                'Nomor Rekening'    => "'".$rekening,
                'Nama'              => $nama,
                'Majelis'           => $majelis,
                'Produk'            => $product,
                'Jumlah Wakalah'    => $jumlah_wakalah,
                'Petugas'           => $petugas,
                'Status'            => $status
            );
        
        }

        download_send_headers('LAPORAN_LIST_WAKALAH_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    /***************************************************************************************/
    //BEGIN PROYEKSI DROPING
    //Author : Aiman
    //Tgl    : 29 - 05 - 18
    /***************************************************************************************/

    function export_lap_proyeksi_droping(){
        $branch_code = $this->uri->segment(3);
        $year = $this->uri->segment(4); 

        if($branch_code == '9999')
        {
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping($branch_code, $year);            
        }else if($branch_code == '00000')
        {
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping_pusat($branch_code, $year);
        }else
        {            
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping($branch_code, $year);    
        }

        if($branch_code == '9999')
        {
            $data_cabang = 'SEMUA_CABANG';     
        }else if($branch_code == '00000')
        {
            $data_cabang = 'PUSAT';
        }else
        {            
            $data_cabang = 'CABANG_'.str_replace(' ','_',strtoupper($this->model_laporan_to_pdf->get_cabang($branch_code)));
        }

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $year = $result['year'];
            $month = $result['month'];
            $account_target = $result['account_target'];
            $amount_target = $result['amount_target'];
            $account_real = $result['account_real'];
            $amount_real = $result['amount_real'];

            if($branch_code == '00000')
            {
                $branch_name = 'Pusat';
            }else
            {
                $branch_name = $result['branch_name'];
            }
            
            if($month == '1'){$mont_ = 'Januari';}else
            if($month == '2'){$mont_ = 'Februari';}else
            if($month == '3'){$mont_ = 'Maret';}else
            if($month == '4'){$mont_ = 'April';}else
            if($month == '5'){$mont_ = 'Mei';}else
            if($month == '6'){$mont_ = 'Juni';}else
            if($month == '7'){$mont_ = 'Juli';}else
            if($month == '8'){$mont_ = 'Agustus';}else
            if($month == '9'){$mont_ = 'September';}else
            if($month == '10'){$mont_ = 'Oktober';}else
            if($month == '11'){$mont_ = 'November';}else
            if($month == '12'){$mont_ = 'Desember';}

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Cabang' => $branch_name,
                'Periode' => $mont_.' '.$year,
                'Proyeksi Anggota' => number_format($account_target,0,',','.'),
                'Proyeksi Nominal' => number_format($amount_target,2,',','.'),
                'Realisasi Anggota' => number_format($account_real,0,',','.'),
                'Realisasi Nominal' => number_format($amount_real,2,',','.')
            );
        }

        download_send_headers('LAPORAN_PROYEKSI_DROPING_'.$data_cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    /***************************************************************************************/
    //END PROYEKSI DROPING
    /***************************************************************************************/

    function export_list_api_debitur(){
        $kreditur_code = $this->uri->segment(3);
		$batch_no = $this->uri->segment(4);
        $status_pyd_kreditur = $this->uri->segment(5);
        $branch_code = $this->session->userdata('branch_code');

		if($status_pyd_kreditur <> '2'){
			$datas = $this->model_laporan_to_pdf->export_list_api_debitur_not_reject($kreditur_code,$batch_no,$status_pyd_kreditur,$branch_code);
		} else {
			$datas = $this->model_laporan_to_pdf->export_list_api_debitur_reject($kreditur_code,$batch_no,$branch_code);
		}

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
			$rekening = $datas[$i]['account_financing_no'];
			$nama = $datas[$i]['nama'];
			$ktp = $datas[$i]['no_ktp'];
			$jenis = $datas[$i]['financing_type'];
			$majelis = $datas[$i]['cm_name'];
			$produk = $datas[$i]['nick_name'];
			$sektor = $datas[$i]['sektor'];
			$peruntukan = $datas[$i]['peruntukan'];
			$droping = $datas[$i]['droping_date'];
			$jangka_waktu = $datas[$i]['jangka_waktu'];
			$pokok = $datas[$i]['pokok'];
			$margin = $datas[$i]['margin'];
			$bayar = $datas[$i]['freq_bayar_pokok']; 
			$saldo = $datas[$i]['freq_bayar_saldo'];
			$saldo_pokok = $datas[$i]['saldo_pokok'];
			$saldo_margin = $datas[$i]['saldo_margin'];
			$saldo_catab = $datas[$i]['saldo_catab']; 			
			$kreditur = $datas[$i]['krd'];
			$tgl_jtempo = $datas[$i]['tanggal_jtempo'];
			$status_pyd_kreditur = $datas[$i]['status_pyd_kreditur'];
			$branch_name = $datas[$i]['branch_name'];

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Cabang' => $branch_name,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'No. KTP' => "'".$ktp,
                'Majelis' => $majelis,
                'Produk' => $produk,
                'Sektor' => $sektor,
                'Peruntukan' => $peruntukan,
                'Sumber Dana' => $kreditur,
                'Droping' => $droping,
                'Jangka Waktu' => $jangka_waktu,
                'T. Jatuh Tempo' => $tgl_jtempo,
                'Status' => $status_pyd_kreditur,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Freq Sisa' => $saldo,
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin,
                'Saldo catab' => $saldo_catab,
                'No. Batch' => $batch_no
            );
        }

        download_send_headers('LAPORAN_LIST_DEBITUR.csv');
        echo array2csv($arr_csv);
        die();
    }
}
