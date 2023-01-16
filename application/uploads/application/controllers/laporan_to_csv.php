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
		$desc_date = substr($date,0,2).'/'.substr($date,2,2).'/'.substr($date,4,4);
		$date = substr($date,4,4).'-'.substr($date,2,2).'-'.substr($date,0,2);
		if($branch_id=="00000"){
			$branch_id = '';
		}
		$branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);

		$branch_code = $branch_data['branch_code'];
		$branch_name = $branch_data['branch_name'];

        $datas = $this->model_laporan_to_pdf->get_laporan_par_terhitung($date,$branch_code,$kol);

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
				'CPP Nominal' => $cadangan_piutang
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
                'Status' => $status
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

            $periode_jangka_waktu = $result['periode_jangka_waktu'];
            $pokok = $result['pokok'];
            $status_rekening = $result['status_rekening'];
            $financing = $result['financing_type'];
            $rekening = $result['account_financing_no'];
            $nama = $result['nama'];
            $majelis = $result['cm_name'];
            $tanggal_registrasi = $result['tanggal_registrasi'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $angsuran_pokok = $result['angsuran_pokok'];
            $angsuran_margin = $result['angsuran_margin'];
            $angsuran_catab = $result['angsuran_catab'];
            $jangka_waktu = $result['jangka_waktu'];
            $product = $result['nick_name'];

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

        	$arr_csv[] = array(
            	'No' => ($i + 1),
            	'Nomor Rekening' => "'".$rekening,
            	'Nama' => $nama,
                'Majelis' => $majelis,
                'Pembiayaan' => $jenis,
                'Produk' => $product,
            	'Tanggal Registrasi' => $tanggal,
            	'Plafon' => $pokok,
            	'Margin' => $margin,
            	'Angsuran Pokok' => $angsuran_pokok,
            	'Angsuran Margin' => $angsuran_margin,
            	'Angsuran Catab' => $angsuran_catab,
                'Total' => $total,
            	'Jangka Waktu' => $jangka_waktu.' '.$periode,
            	'Status Rekening' => $status
            );
        
        }

		download_send_headers('LAPORAN_REGISTRASI_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
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

        $datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan($cabang,$majelis,$from,$thru,$pembiayaan,$petugas,$peruntukan,$sektor,$produk);

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

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tanggal' => $droping_date,
                'Rekening' => "'".$rekening,
                'Nama' => $nama,
                'Pembiayaan' => $jenis,
                'Majelis' => $majelis,
                'PYD ke' => $pyd,
                'Produk' => $nick,
                'Plafon' => $pokok,
                'Margin' => $margin,
                'Periode' => $periode_jangka_waktu,
                'Jk Waktu' => $jangka_waktu,
                'Plafon  Sblmnya' => $s_pokok,
                'Keterangan' => $keterangan,
                'Pengguna Dana' => $pengguna_dana,
                'Peruntukan' => $dtp.' - '.$description,
                'Sektor' => $dts
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

            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk);
        // if($pembiayaan == 0){
        // } else {
        //     $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk);
        //     //
        // }

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
            $angsuran_pokok = $result['angsuran_pokok'];
            $angsuran_margin = $result['angsuran_margin'];
            $jml_bayar = $result['jml_bayar'];

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
                'Jumlah Bayar' => $jml_bayar
            );
        }

        download_send_headers('LAPORAN_ANGSURAN_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$from.'-'.$thru.'.csv');
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

        // if($pembiayaan == 0){
        //     $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_kelompok($from,$thru,$cabang,$majelis,$petugas,$produk);
        // } else {
        //     //
        // }
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from,$thru,$cabang,$majelis,$petugas,$produk);

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
            $angsuran_pokok = $result['angsuran_pokok'];
            $angsuran_margin = $result['angsuran_margin'];
            $angsuran_catab = $result['angsuran_catab'];
            $jml_bayar = $result['jml_bayar'];

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
                'Jumlah Bayar' => $jml_bayar
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
        $tanggal = date('Y-m-d');

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

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$produk,$peruntukan,$sektor,$tanggal);

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
            $droping = $result['droping_date'];
            $pokok = $result['pokok'];
            $margin = $result['margin'];
            $bayar = $result['freq_bayar_pokok'];
            $saldo = $result['freq_bayar_saldo'];
            $saldo_pokok = $result['saldo_pokok'];
            $saldo_margin = $result['saldo_margin'];

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
                'Droping' => $droping,
                'Pokok' => $pokok,
                'Margin' => $margin,
                'Bayar' => $bayar,
                'Freq' => $saldo,
                'Saldo Pokok' => $saldo_pokok,
                'Saldo Margin' => $saldo_margin
            );
        }

        download_send_headers('LAPORAN_OUTSTANDING_PEMBIAYAAN_'.$jenis2.'_'.$data_cabang.'_'.$tanggal.'.csv');
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

        $datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan($cabang,$pembiayaan,$petugas,$majelis,$from,$thru);

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

            $arr_csv[] = array(
            	'No' => ($i + 1),
            	'Tanggal Lunas' => $tanggal_lunas,
            	'Rekening' => "'".$rekening,
            	'Nama' => $nama,
            	'Majelis' => $majelis,
                'Pembiayaan' => $pembiayaan,
            	'Pokok' => $pokok,
            	'Margin' => $margin,
            	'Jangka Waktu' => $jangka_waktu,
                'Jatuh Tempo' => $jtempo,
            	'Cnt' => $sisa,
            	'Saldo Pokok' => $saldo_pokok,
            	'Saldo Margin' => $saldo_margin
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
            $tanggal_jtempo = $result['tanggal_jtempo'];
            $rencana_setoran = $result['rencana_setoran'];
            $status_rekening = $result['status_rekening'];
            $saldo_memo = $result['saldo_memo'];
            

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

        download_send_headers('LIST_PELUNASAN_PEMBIAYAAN'.$from_date1.'.csv');
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
        $datas          = $this->model_laporan->export_list_buka_tabungan_jtempo($produk,$from_date,$thru_date,$cabang);
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

            $tanggal_buka = $result['tanggal_buka'];

            $account_saving_no = $result['account_saving_no'];
            $nama = $result['nama'];
            $product_name = $result['product_name'];
            $rencana_jangka_waktu = $result['rencana_jangka_waktu'];
            $rencana_setoran = $result['rencana_setoran'];
            $saldo_memo = $result['saldo_memo'];
            

            $arr_csv[] = array(
                'No' => ($i + 1),
                'Tgl Buka' => $tanggal_buka,
                'No Rekening' => $account_saving_no,
                'Nama' => $nama,
                'Produk' => $product_name,
                'Jangka Waktu' => $rencana_jangka_waktu,
                'Setoran' => $rencana_setoran,
                'Status' => $status_rekening,
                'Saldo' => $saldo_memo
            );
        }

        download_send_headers('LIST_PEMBUKAAN_TABUNGAN_JATUH_TEMPO'.$from_date.'.csv');
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
            $saldo_memo = $result['saldo_memo'];
            

            $arr_csv[] = array(
                'No' => ($i + 1),
                'No Rekening' => $account_saving_no,
                'Majelis' => $cm_name,
                'Nama' => $nama,
                'Produk' => $product_name,
                'Aktif' => $status_rekening,
                'Saldo' => $saldo_memo  
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
        echo $thru_date; die();

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

        $datas = $this->model_laporan->export_list_transaksi_rembug_sub($branch_code,$cm_code,$from_trx_date,$thru_trx_date,$fa_code);

        $arr_csv = array();

        for($i = 0; $i < count($datas); $i++){
            $result = $datas[$i];

            $cif_no             = $result['cif_no'];
            $pyd                = $result['pembiayaan_ke'];
            $nama               = $result['nama'];
            $freq               = $result['freq'];
            $angsuran_pokok     = $result['angsuran_pokok'];
            $angsuran_margin    = $result['angsuran_margin'];
            $angsuran_catab     = $result['angsuran_catab'];
            $setoran_lwk        = $result['setoran_lwk'];
            $tab_sukarela_cr    = $result['tab_sukarela_cr'];
            $tab_wajib_cr       = $result['tab_wajib_cr'];
            $tab_kelompok_cr    = $result['tab_kelompok_cr'];
            $tab_sukarela_db    = $result['tab_sukarela_db'];
            $pokok              = $result['pokok'];
            $administrasi       = $result['administrasi'];
            $asuransi           = $result['asuransi'];

            $arr_csv[] = array(
                'No'        => ($i + 1),
                'Anggota'   => $cif_no,
                'PYD'       => $pyd,
                'Nama'      => $nama,
                'freq'      => $freq,
                'Pokok'     => $angsuran_pokok,
                'Margin'    => $angsuran_margin,
                'Catab'     => $angsuran_catab,
                'LWK'       => $setoran_lwk,
                'Sukarela'  => $tab_sukarela_cr,
                'Wajib'     => $tab_wajib_cr,
                'Kelompok'  => $tab_kelompok_cr,
                'sukarela'  => $tab_sukarela_db,
                'Plafon'    => $pokok,
                'Adm.'      => $administrasi,
                'Asuransi'  => $asuransi
            );
        }

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
        $cm_code = $this->uri->segment(4);
        
        $datas = $this->model_laporan->export_list_saldo_tabungan($branch_code,$cm_code);

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
            $tabungan_kelompok  = $result['tabungan_kelompok'];
            $tabungan_sukarela  = $result['tabungan_sukarela'];
            $saldo_pokok        = $result['saldo_pokok'];
            $saldo_margin       = $result['saldo_margin'];

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
                'Margin'                => $saldo_margin
            );
        }

        download_send_headers('LIST_SALDO_ANGGOTA_'.$branch_code.'.csv');
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
            $pembiayaan_ke_last          = $result['pembiayaan_ke_last'];
            $tanggal_akad_last           = $result['tanggal_akad_last'];
            $pokok_last                  = $result['pokok_last'];
            $alasan                      = $result['alasan'];
            $alasan_keluar               = $result['alasan_keluar'];
             
           
                         
            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => $cif_no,
                'Nama'                    => $nama,
                'Rembug Pusat'            => $cm_name,
                'Tanggal Gabung'          => $tgl_gabung,
                'Tanggal Keluar'          => $tanggal_mutasi,
                'PYD ke'                  => $pembiayaan_ke_last,
                'Tannggal Droping'        => $tanggal_akad_last,
                'Plafon'                  => $pokok_last,
                'Alasan Keluar'           => $alasan,
                'Keterangan Keluar'       => $alasan_keluar
            );
        }

        download_send_headers('LIST_ANGGOTA_KELUAR_'.$from_date1.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_list_anggota_masuk(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $from = $this->uri->segment(5);
        $from = $this->datepicker_convert(true,$from,'/');
        $thru = $this->uri->segment(6);
        $thru = $this->datepicker_convert(true,$thru,'/');
      
        $datas = $this->model_laporan->export_list_anggota_masuk($cabang,$majelis,$from,$thru);

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
            $ibu_kandung              = $result['ibu_kandung'];
            $tmp_lahir          = $result['tmp_lahir'];
            $tgl_lahir           = $result['tgl_lahir'];
            $usia                  = $result['usia'];
            $alamat                      = $result['alamat'];

            $arr_csv[] = array(
                'No'                      => ($i + 1),
                'ID'                      => "'".$cif_no,
                'Nama'                    => $nama,
                'Majelis'            => $cm_name,
                'Tanggal Gabung'          => $tgl_gabung,
                'Jenis Kelamin'          => 'Perempuan',
                'Ibu Kandung'                  => $ibu_kandung,
                'Tempat Lahir'        => $tmp_lahir,
                'Tanggal Lahir'                  => $tgl_lahir,
                'usia'           => $usia,
                'Alamat'       => $alamat
            );
        }

        download_send_headers('LIST_ANGGOTA_MASUK_'.$data_cabang.'.csv');
        echo array2csv($arr_csv);
        die();
    }

    function export_lap_list_bagihasil(){
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $periode = $this->uri->segment(6);

        $datas = $this->model_laporan_to_pdf->export_lap_list_bagihasil($majelis,$petugas,$periode);

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
        } else {
            $by = 'Peruntukan';
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
}
