<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sys extends GMN_Controller {

	/**
	 * Halaman untuk mengatur System Periode
	 */

	public function __construct()
	{
		parent::__construct(true);
		$this->load->model("model_sys");
		$this->load->model("model_core");
		$this->load->model("model_product");
		$this->load->model("model_laporan");
		$this->load->model("model_laporan_to_pdf");
		$this->load->library('phpexcel');
	}

	public function index()
	{
		$this->periode();
	}

	/***************************************************************************************/
	//BEGIN PERIODE SYSTEM
	/***************************************************************************************/
	public function periode()
	{
		$datas	= $this->model_sys->get_periode();
		$data['pawal'] = $datas['periode_awal'];
		$data['pakhir'] = $datas['periode_akhir'];
		$data['pid'] = $datas['periode_id'];
		$data['title'] = 'Peride System';
		$data['container'] = 'sys/periode_system';
		$this->load->view('core',$data);
	}

	public function update_periode()
	{
		$id			= $this->input->post('id');
		$tanggal1	= $this->input->post('tanggal');
		$tanggal2	= $this->input->post('tanggal2');

		$exp1 = explode("/", $tanggal1);
		$awal = $exp1[2].'-'.$exp1[1].'-'.$exp1[0];
		$exp2 = explode("/", $tanggal2);
		$akhir = $exp2[2].'-'.$exp2[1].'-'.$exp2[0];
		

			$data = array(
						  'periode_awal'	=>$awal
						 ,'periode_akhir'	=>$akhir
					);

		 	$param = array('periode_id' => $id );

		$this->db->trans_begin();
		$this->model_sys->update_periode($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}		

		echo json_encode($return);
	}
	/***************************************************************************************/
	//BEGIN PERIODE SYSTEM
	/***************************************************************************************/


	/**
	* MODUL : BAGIHASIL/BONUS TABUNGAN
	* @author : sayyid nurkilah
	*/
	function bagihasil_tabungan()
	{
		$data['title'] = 'Bagi Hasil Tabungan';
		$data['container'] = 'sys/bagihasil_tabungan';
		$data['product'] = $this->model_product->get_product_saving();
		$this->load->view('core',$data);
	}
	function do_bagihasil_tabungan()
	{
		$product_code=$this->input->post('product_code');
		$tanggal=$this->datepicker_convert(true,$this->input->post('tanggal'),'/');
		$rate=$this->input->post('rate');

		/*transaction database*/
		$this->db->trans_begin();
		$this->model_sys->do_bagihasil_tabungan($product_code,$tanggal,$rate);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('success',true);
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('failed',true);
		}
		redirect('sys/bagihasil_tabungan');
	}

	/**
	* MODUL : BAGIHASIL/BONUS TABUNGAN
	* @author : sayyid nurkilah
	*/
	function debet_adm()
	{
		$data['title'] = 'Debet Administrasi';
		$data['container'] = 'sys/debet_adm';
		$this->load->view('core',$data);
	}
	function do_debet_adm()
	{
		$tanggal=$this->datepicker_convert(true,$this->input->post('tanggal'),'/');

		/*transaction database*/
		$this->db->trans_begin();
		$this->model_sys->do_debet_adm($product_code,$tanggal,$rate);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$this->session->set_flashdata('success',true);
		}else{
			$this->db->trans_rollback();
			$this->session->set_flashdata('failed',true);
		}
		redirect('sys/debet_adm');
	}
	/*
	|	PROCESS CLOSING (PROSES TUTUP BUKU)
	|	created_by : aiman
	|	created_date : 2017-05-15 14:24
	*/
	function process_closing()
	{
		$data['title'] = 'Regis Closing';
		$data['container'] = 'sys/process_closing';
		$data['unverifieds']=$this->get_unverifieds_trx($this->session->userdata('branch_code'));
		$data['num_trx_cm_verified_not_yet'] = $this->model_sys->num_trx_cm_verified_not_yet($this->session->userdata('branch_code'));
		$data['num_trx_saving_verified_not_yet'] = $this->model_sys->num_trx_saving_verified_not_yet($this->session->userdata('branch_code'));
		$data['num_trx_mutasi_verified_not_yet'] = $this->model_sys->num_trx_mutasi_verified_not_yet($this->session->userdata('branch_code'));
		$this->load->view('core',$data);		
	}

	/*
	| CLOSING TRANSACTION (TUTUP BUKU TRANSAKSI)
	| created_by : sayyid
	| created_date : 2014-10-28 09:38
	*/
	function closing_transaction()
	{
		$data['title'] = 'Tutup Buku Transaksi';
		$data['container'] = 'sys/closing_transaction';
		$data['unverifieds']=$this->get_unverifieds_trx($this->session->userdata('branch_code'));
		$data['num_trx_cm_verified_not_yet'] = $this->model_sys->num_trx_cm_verified_not_yet($this->session->userdata('branch_code'));
		$data['num_trx_saving_verified_not_yet'] = $this->model_sys->num_trx_saving_verified_not_yet($this->session->userdata('branch_code'));
		$data['num_trx_mutasi_verified_not_yet'] = $this->model_sys->num_trx_mutasi_verified_not_yet($this->session->userdata('branch_code'));
		$this->load->view('core',$data);
	}
	function get_list_date_unverified_trx_cm($branch_code)
	{
		$param=array();
		$sql = "select trx_date from mfi_trx_cm_save a, mfi_cm b, mfi_branch c 
				where a.cm_code=b.cm_code and b.branch_id=c.branch_id ";
		if ($branch_code!="00000") {
			$sql .= " and c.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " group by 1 order by trx_date asc";
		$query = $this->db->query($sql,$param);
		$result = $query->result_array();
		$i=0;
		$list_date='';
		foreach($result as $row){
			if ($i>0) $list_date .= ', ';
			$list_date .= date('d M',strtotime($row['trx_date']));
			$i++;
		}
		return $list_date;
	}
	function get_list_date_unverified_trx_saving($branch_code)
	{
		$param=array();
		$sql = "select trx_date from mfi_trx_account_saving a, mfi_branch b
				where a.branch_id=b.branch_id and a.trx_status = 0 ";
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " group by 1 order by 1 asc";
		$query = $this->db->query($sql,$param);
		$result = $query->result_array();
		$i=0;
		$list_date='';
		foreach($result as $row){
			if ($i>0) $list_date .= ', ';
			$list_date .= date('d M',strtotime($row['trx_date']));
			$i++;
		}
		return $list_date;
	}
	function get_list_date_unverified_trx_mutasi($branch_code)
	{
		$param=array();
		$sql = "select tanggal_mutasi trx_date from mfi_cif_mutasi a, mfi_cif b
				where a.cif_no=b.cif_no and a.status = 0 and a.tipe_mutasi=1";
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk=?)";
			$param[] = $branch_code;
		}
		$sql .= " group by 1 order by 1 asc";
		$query = $this->db->query($sql,array($sql,$param));
		$result = $query->result_array();
		$i=0;
		$list_date='';
		foreach($result as $row){
			if ($i>0) $list_date .= ', ';
			$list_date .= date('d M',strtotime($row['trx_date']));
			$i++;
		}
		return $list_date;
	}

	//Process regis closing begin
	function regis_closing_process()
	{
		$branch_code = $this->session->userdata('branch_code');

		$query = $this->db->query("UPDATE mfi_branch SET branch_status = '2' WHERE branch_code = '$branch_code'");

		if($query == true)
		{
			$return = array('success'=>true,'message'=>'Proses Closing Selesai!');

		}else
		{
			$return = array('success'=>false,'message'=>'Failed to connect into Database, Please contact your administrator!');
		}

		
		echo json_encode($return);
	}

	function closing_transaction_process()
	{
		$debug = false;
		$periode_id=$this->input->post('periode_id');
		$periode=$this->input->post('periode');
		$periode=$this->datepicker_convert(true,$periode,'/');
		$pexp=explode('-',$periode);
		$from_date=$pexp[0].'-'.$pexp[1].'-01';
		$thru_date=$periode;
		$from_date_lm = date('Y-m-d',strtotime($from_date.' - 1 MONTH'));
		$branch_code=$this->session->userdata('branch_code');
		/*date next*/
		$next_from_date=date('Y-m-d',strtotime($from_date.' +1 month'));
		$next_thru_date=date('Y-m-t',strtotime($from_date.' +1 month'));
		
		$q = $this->db->query("
				select status from mfi_trx_kontrol_periode where periode_id=?
		",array($periode_id));
		$r = $q->row_array();
		if ( $r['status'] == 0 )
		{
			$return = array('success'=>false,'message'=>'Periode ini sudah dilakukan Closing!');
		}
		else
		{

			/*set closing id*/
			$closing_id=uuid(false);

			/*
			| SIMPAN DATA TABUNGAN ANGGOTA & SALDO RATA RATA
			*/
			$closing_balance=array();

			$balances=$this->model_sys->get_balance_data_for_closing($branch_code);
			foreach($balances as $balance){
				// $saldoRR=$this->model_sys->get_average_saldo_balance($balance['cif_no'],$from_date,$thru_date);
				// $saldoRRsukarela = $saldoRR['tabungan_sukarela'];
				// $saldoRRwajib = $saldoRR['tabungan_wajib'];
				// $saldoRRkelompok = $saldoRR['tabungan_kelompok'];
				$closing_balance[]=array(
						'closing_id'=>$closing_id
						,'closing_from_date'=>$from_date
						,'closing_thru_date'=>$thru_date
						,'cif_no'=>$balance['cif_no']
						,'saldo_tab_sukarela'=>$balance['tabungan_sukarela']
						,'saldo_tab_wajib'=>$balance['tabungan_wajib']
						,'saldo_tab_kelompok'=>$balance['tabungan_kelompok']
						,'saldo_rr_tab_sukarela'=>0
						,'saldo_rr_tab_wajib'=>0
						,'saldo_rr_tab_kelompok'=>0
						,'created_stamp'=>date('Y-m-d H:i:s')
						,'created_by'=>$this->session->userdata('user_id')
					);
			}

			/*
			| SIMPAN DATA FINANCING & SALDO RATA RATA
			*/
			$closing_pembiayaan=array();

			$financing=$this->model_sys->get_financing_data_for_closing($branch_code);
			foreach($financing as $pembiayaan){
				// $saldo_rata_rata=$this->model_sys->get_average_saldo_tabungan($pembiayaan['account_financing_no'],$from_date,$thru_date);
				$closing_pembiayaan[]=array(
						'closing_id'=>$closing_id
						,'closing_from_date'=>$from_date
						,'closing_thru_date'=>$thru_date
						,'account_financing_no'=>$pembiayaan['account_financing_no']
						,'saldo_pokok'=>$pembiayaan['saldo_pokok']
						,'saldo_margin'=>$pembiayaan['saldo_margin']
						,'saldo_catab'=>$pembiayaan['saldo_catab']
						,'saldo_rata_rata'=>0
						,'created_stamp'=>date('Y-m-d H:i:s')
						,'created_by'=>$this->session->userdata('user_id')
					);
			}

			/*
			| SIMPAN DATA TABUNGAN & SALDO RATA RATA
			*/
			$closing_tabungan=array();

			$saving=$this->model_sys->get_saving_data_for_closing($branch_code);
			foreach($saving as $tabungan){
				// $saldo_rata_rata=$this->model_sys->get_average_saldo_tabungan($tabungan['account_saving_no'],$from_date,$thru_date);
				$closing_tabungan[]=array(
						'closing_id'=>$closing_id
						,'closing_from_date'=>$from_date
						,'closing_thru_date'=>$thru_date
						,'account_saving_no'=>$tabungan['account_saving_no']
						,'saldo_riil'=>$tabungan['saldo_riil']
						,'saldo_memo'=>$tabungan['saldo_memo']
						,'saldo_rata_rata'=>0
						,'created_stamp'=>date('Y-m-d H:i:s')
						,'created_by'=>$this->session->userdata('user_id')
					);
			}

			/*
			| SIMPAN DATA KOLEKTIBILITAS & SALDO OUTSTANDING
			*/
			// $closing_kolektibilitas=array();

			// $branch=$this->model_sys->get_branch_by_branch_class(3);
			// foreach($branch as $capem){
			// 	/* cek & delete exists par */
			// 	$cek_par = $this->model_sys->cek_par($thru_date,$capem['branch_code']);
			// 	if($cek_par>0){
			// 		$this->db->trans_begin();
			// 		$this->model_sys->delete_par($thru_date,$capem['branch_code']);
			// 		if($this->db->trans_status()===true){
			// 			$this->db->trans_commit();
			// 		}else{
			// 			$this->db->trans_rollback();
			// 		}
			// 	}

			// 	$data = $this->model_laporan_to_pdf->get_laporan_par($thru_date,$capem['branch_code']);

			// 	for($i=0;$i<count($data);$i++)
			// 	{
			// 		$closing_kolektibilitas[] = array(
			// 				'branch_code' => $capem['branch_code']
			// 				,'tanggal_hitung' => $thru_date
			// 				,'account_financing_no' => $data[$i]['account_financing_no']
			// 				,'saldo_pokok' => $data[$i]['saldo_pokok']
			// 				,'saldo_margin' => $data[$i]['saldo_margin']
			// 				,'hari_nunggak' => $data[$i]['hari_nunggak']
			// 				,'freq_tunggakan' => $data[$i]['freq_tunggakan']
			// 				,'tunggakan_pokok' => $data[$i]['tunggakan_pokok']
			// 				,'tunggakan_margin' => $data[$i]['tunggakan_margin']
			// 				,'par_desc' => $data[$i]['par_desc']
			// 				,'par' => $data[$i]['par']
			// 				,'cadangan_piutang' => $data[$i]['cadangan_piutang']
			// 			);
			// 	}
			// }
			/*
			| UPDATE PERIODE SYSTEM TO BE INACTIVATE
			| THEN INSERT NEW PERIODE SYSTEM
			*/
			$close_periode = array('status'=>0); //-- 0 - tidak aktif, 1 - aktif
			$param_close_periode = array('periode_id'=>$periode_id);
			$open_periode = array(
				'periode_id'=>uuid(false)
				,'periode_awal'=>$next_from_date
				,'periode_akhir'=>$next_thru_date
				,'status'=>1 //-- 0 - tidak aktif, 1 - aktif
			);

			$first_date_at_year = date('Y',strtotime($thru_date)).'-01-01'; // will get 2014-01-01
			$last_date_at_year = date('Y',strtotime($thru_date)).'-12-'.date('t',strtotime($thru_date)); // will get 2014-12-31
			$month_of_date = date('m',strtotime($thru_date));

			/*
			| SIMPAN DATA LEDGER & SALDO RATA-RATA
			*/
			//$closing_ledger=array();
			if ($month_of_date!='12') {
				$branchs = $this->model_sys->getBranchsGL();
				for ($i = 0 ; $i < count($branchs) ; $i++) {
					$close_data = $this->model_sys->fn_insert_closing_ledger_data($branchs[$i]['branch_code'],$from_date_lm,$from_date,$thru_date,$closing_id,$this->session->userdata('user_id'));
					/*
					$ledger=$this->model_sys->get_ledger_data_for_closing($branchs[$i]['branch_code']);
					foreach($ledger as $account){
						// $saldo_rata_rata=$this->model_sys->get_average_saldo_ledger($account['account_code'],$from_date,$thru_date);
						$mutasi=$this->model_sys->get_amount_mutasi_ledger($branchs[$i]['branch_code'],$account['account_code']);
						$closing_ledger[]=array(
								'closing_id'=>$closing_id
								,'branch_code'=>$branchs[$i]['branch_code']
								,'closing_from_date'=>$from_date
								,'closing_thru_date'=>$thru_date
								,'account_code'=>$account['account_code']
								,'saldo_rata_rata'=>0
								,'saldo'=>$account['saldo']
								,'created_stamp'=>date('Y-m-d H:i:s')
								,'created_by'=>$this->session->userdata('user_id')
								,'total_mutasi_debet'=>$mutasi['total_trx_debet']
								,'total_mutasi_credit'=>$mutasi['total_trx_credit']
								,'saldo_awal'=>$account['saldo']+$mutasi['total_trx_debet']-$mutasi['total_trx_credit']
							);
					}
					*/
				}
			}

			/*
			| GET GL SHU TAHUN LALU
			*/
			$data_gl_shu_tahun_lalu = $this->model_sys->get_gl_list_code_detail('gl_shu_tahun_lalu');
			$gl_shu_tahun_lalu = @$data_gl_shu_tahun_lalu['code_value'];

			if ($debug==true) {
				echo "<pre>";
				echo $month_of_date;
				print_r($closing_balance);
				print_r($closing_tabungan);
				//print_r($closing_ledger);
				print_r($close_periode);
				print_r($param_close_periode);
				die('-Debug Mode-');
			} else {
				/*
				| EXECUTE TRANSACTION
				*/
				$this->db->trans_begin();

				// run jurnal funtion last_year
				if($month_of_date=='12') { // jika bulan desember
					$sql = "select a.branch_code,a.branch_name
							from mfi_branch a, mfi_trx_gl b
							where a.branch_code=b.branch_code 
							and a.branch_class <> 0 
							and b.voucher_date between ? and ?
							group by 1,2
							order by a.branch_code asc";
					$que = $this->db->query($sql,array($first_date_at_year,$last_date_at_year));
					$res = $que->result_array();

					foreach ($res as $row) {
						$sql = "select fn_proses_jurnal_akhir_tahun(?,?,?,?)";
						$query = $this->db->query($sql,array($first_date_at_year,$last_date_at_year,$row['branch_code'],$gl_shu_tahun_lalu));
					}
				}

				/*if($month_of_date=='12') { // jika bulan desember
					// echo "<pre>";
					$sql = "select fn_proses_jurnal_akhir_tahun(?,?,?,?)";
					$query = $this->db->query($sql,array($first_date_at_year,$last_date_at_year,'00000',$gl_shu_tahun_lalu));
					// print_r($this->db);
				}*/

				/*simpan data balance*/
				if(count($closing_balance)>0) $this->model_sys->insert_closing_balance_data($closing_balance);
				/*simpan data pembiayaan*/
				if(count($closing_pembiayaan)>0) $this->model_sys->insert_closing_financing_data($closing_pembiayaan);
				/*simpan data tabungan*/
				if(count($closing_tabungan)>0) $this->model_sys->insert_closing_saving_data($closing_tabungan);
				/*simpan data ledger*/
				//if(count($closing_ledger)>0) $this->model_sys->insert_closing_ledger_data($closing_ledger);
				
				/*simpan kolektibilitas*/
				//if(count($closing_kolektibilitas)>0) $this->model_sys->insert_closing_kolektibilitas_data($closing_kolektibilitas);
				/*update periode system*/
				$this->model_sys->update_periode($close_periode,$param_close_periode);
				$this->db->insert('mfi_trx_kontrol_periode',$open_periode);
				// echo $month_of_date;
				// die();

				$this->db->query('delete from mfi_gl_account_summary_mutasi');

				/*cek transaction database*/
				if($this->db->trans_status()===true){
					$this->db->trans_commit();
					// $this->session->set_flashdata('success',true);
					$return = array('success'=>true,'message'=>'Proses Closing Selesai!');
				}else{
					$this->db->trans_rollback();
					// $this->session->set_flashdata('failed',true);
					$return = array('success'=>false,'message'=>'Failed to connect into Database, Please contact your administrator!');
				}
				/*redirect to previous page*/
				// redirect('sys/closing_transaction');
			} //-- end of debug section
		} //-- end of status closing section
		echo json_encode($return);
	}




	/***************************************************************************************/
	//BEGIN BAGI HASIL BARU 17-09-2014
	function proses_bagihasil()
	{
		$data['title'] = 'Proses Bagi Hasil';
		$data['container'] = 'sys/proses_bagihasil';
		$data['product'] = $this->model_product->get_product_saving();
		$this->load->view('core',$data);
	}	

	public function get_data_bahas()
	{
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');
		$y = date('Y',strtotime($thru_date));
		$m = date('m',strtotime($thru_date));
		
		// $y	= $this->input->post('tahun');
		// $m	= $this->input->post('bulan');
		// $first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		// $last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));
		// $first = $this->get_from_trx_date();
		// $last = $this->get_thru_trx_date();

		$pembiayaan_yg_diberikan 	= $this->model_sys->pembiayaan_yg_diberikan($from_date,$thru_date);
		$pendapatan_operasional 	= $this->model_sys->pendapatan_operasional($from_date,$thru_date);
		$dana_pihak_ke3 			= $this->model_sys->dana_pihak_ke3($from_date,$thru_date);
		if($dana_pihak_ke3<0)
		{
		 $dana_pihak_ke3=0;
		}

		if ($pendapatan_operasional!=0) {
			$porsi_pendapatan_dp3 = $pendapatan_operasional*($dana_pihak_ke3/$pembiayaan_yg_diberikan);
		} else {
			$porsi_pendapatan_dp3 = 0;
		}

		if ($porsi_pendapatan_dp3>$pendapatan_operasional) {
			$porsi_pendapatan_dp3 = $pendapatan_operasional;
		}
		

		$data['pembiayaan_yg_diberikan']	= number_format($pembiayaan_yg_diberikan, 0, ",", ".");
		$data['pendapatan_operasional']		= number_format($pendapatan_operasional, 0, ",", ".");
		$data['dana_pihak_ke3']				= number_format($dana_pihak_ke3, 0, ",", ".");
		$data['porsi_pendapatan_dp3']		= number_format($porsi_pendapatan_dp3, 0, ",", ".");
		// $data['porsi_pendapatan_dp3']		= $porsi_pendapatan_dp3;
		
		echo json_encode($data);
	}

	public function generate_product_deposito()
	{
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');
		$dana_pihak_ke3	= str_replace(",", '.', str_replace(".", '', $this->input->post('dana_pihak_ke3')));
		$porsi_pendapatan_dp3 = str_replace(",", '.', str_replace(".", '', $this->input->post('porsi_pendapatan_dp3')));

		/*$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));*/

		$data 	= $this->model_sys->generate_product_deposito($thru_date);
		// Rate = (saldo/dana_pihak_ke3*porsi_pendapatan_d3*nisbah)/saldo*100
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{ 
			
			if ($data[$i]['saldo']==0 || $porsi_pendapatan_dp3==0 || $dana_pihak_ke3==0) {
				$rate = 0;
			} else {
				$rate = ($data[$i]['saldo']/$dana_pihak_ke3*$porsi_pendapatan_dp3*$data[$i]['nisbah']/100)/$data[$i]['saldo']*100;
			}
			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$html .='<tr>
					  <input type="hidden" name="deposit_product_code[]" value="'.$data[$i]['product_code'].'">
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                        <input name="deposit_saldo[]" readonly="" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_nisbah[]" readonly="" value="'.$data[$i]['nisbah'].'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                      </td> 
                      <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                      <input name="deposit_rate[]" readonly="" value="'.round($rate, 2).'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;"> 
                      </td>
                    </tr>';
		}
		
		echo $html;
	}
	public function generate_product_mudharabah()
	{
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');
		$dana_pihak_ke3			= str_replace(",", '.', str_replace(".", '', $this->input->post('dana_pihak_ke3')));
		$porsi_pendapatan_dp3	= str_replace(",", '.', str_replace(".", '', $this->input->post('porsi_pendapatan_dp3')));

		/*$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));*/

		$data 	= $this->model_sys->generate_product_mudharabah($thru_date);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{
			
			if ($data[$i]['saldo']==0 || $dana_pihak_ke3==0 || $dana_pihak_ke3==0) {
				$rate = 0;
			} else {
				// $rate = $data[$i]['saldo'].' - '.$dana_pihak_ke3.' - '.$porsi_pendapatan_dp3.' - '.$data[$i]['nisbah'].' - '.$data[$i]['saldo'].' - 100';
				$rate = ($data[$i]['saldo']/$dana_pihak_ke3*$porsi_pendapatan_dp3*$data[$i]['nisbah']/100)/$data[$i]['saldo']*100;
			} 

			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$saldo_bahas = ($saldo==0 || round($rate, 2)==0) ? 0 : $saldo*(round($rate, 2)/100) ;
			
                  $html .= '
                          <tr>
						  	  <input type="hidden" name="mudharabah_product_code[]" value="'.$data[$i]['product_code'].'">
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                            <input name="mudharabah_saldo[]" readonly="" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_nisbah[]" readonly="" value="'.(($data[$i]['nisbah']=="")?0:$data[$i]['nisbah']).'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:80%;"> 
	                          </td> 
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                          <input name="mudharabah_rate[]" readonly="" value="'.number_format(round($rate, 2), 2, ".", ",").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:80%;"> 
	                          </td>	                          
	                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
	                            <input name="mudharabah_jumlah_bahas[]" readonly="" value="'.number_format($saldo_bahas, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
	                          </td> 
                          </tr>';
		}
		
		echo $html;
	}
	public function generate_product_wadiah()
	{
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');

		// $first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		// $last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));

		$data 	= $this->model_sys->generate_product_wadiah($from_date,$thru_date);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) { 

			$saldo = ($data[$i]['saldo']<0) ? 0 : $data[$i]['saldo'] ;
			$html .= '     <tr id="tr_wadiah'.$i.'">
                          <input type="hidden" id="jumlah_product_wadiah" value="'.count($data).'">
                          <input type="hidden" name="wadiah_product_code[]" value="'.$data[$i]['product_code'].'">
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input id="wadiah_product_name" name="wadiah_product_name[]" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input readonly="" id="wadiah_saldo" name="wadiah_saldo[]" value="'.number_format($saldo, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input id="wadiah_rate" name="wadiah_rate[]" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;" maxlength="8" value="0.00"> 
                          <span id="td_span_wadiah_rate" style="display:none;padding-right:5px;">0.00</span>
                          </td> 
                          <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          <input readonly="" id="wadiah_jumlah_bonus" name="wadiah_jumlah_bonus[]" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;" value="0"> 
                          <span id="td_span_wadiah_jumlah_bonus" style="display:none;padding-right:5px;">0</span>
                          </td>
                          </tr>';
		}
		
		echo $html;
	}

	function generate_product_tabungan_anggota()
	{
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');

		/*$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));*/

		$data_tab_anggota=$this->model_sys->generate_product_tabungan_anggota($from_date,$thru_date);
		$saldo_tabungan_sukarela=$data_tab_anggota['saldo_tabungan_sukarela'];
		$saldo_tabungan_wajib=$data_tab_anggota['saldo_tabungan_wajib'];
		$saldo_tabungan_kelompok=$data_tab_anggota['saldo_tabungan_kelompok'];

		/* TABUNGAN SUKARELA */
		$html = ' <tr id="tr_anggota_1">
                   <input type="hidden" id="jumlah_product_sukarela" value="0">
                   <input type="hidden" name="sukarela_product_code" value="0">
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="sukarela_product_name" name="sukarela_product_name" readonly="" value="TABUNGAN SUKARELA" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                     <input readonly="" id="sukarela_saldo" name="sukarela_saldo" value="'.number_format($saldo_tabungan_sukarela, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="sukarela_rate" name="sukarela_rate" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;" maxlength="8" value="0.00"> 
                   <span id="td_span_sukarela_rate" style="display:none;padding-right:5px;">0.00</span>
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input readonly="" id="sukarela_jumlah_bonus" name="sukarela_jumlah_bonus" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;" value="0"> 
                   <span id="td_span_sukarela_jumlah_bonus" style="display:none;padding-right:5px;">0</span>
                   </td>
                   </tr>';

        /* TABUNGAN WAJIB */
		$html .= ' <tr id="tr_anggota_2">
                   <input type="hidden" id="jumlah_product_wajib" value="0">
                   <input type="hidden" name="wajib_product_code" value="0">
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="wajib_product_name" name="wajib_product_name" readonly="" value="TABUNGAN WAJIB" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                     <input readonly="" id="wajib_saldo" name="wajib_saldo" value="'.number_format($saldo_tabungan_wajib, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="wajib_rate" name="wajib_rate" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;" maxlength="8" value="0.00"> 
                   <span id="td_span_wajib_rate" style="display:none;padding-right:5px;">0.00</span>
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input readonly="" id="wajib_jumlah_bonus" name="wajib_jumlah_bonus" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;" value="0"> 
                   <span id="td_span_wajib_jumlah_bonus" style="display:none;padding-right:5px;">0</span>
                   </td>
                   </tr>';

        /* TABUNGAN KELOMPOK */
		$html .= ' <tr id="tr_anggota_3">
                   <input type="hidden" id="jumlah_product_kelompok" value="0">
                   <input type="hidden" name="kelompok_product_code" value="0">
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="kelompok_product_name" name="kelompok_product_name" readonly="" value="TABUNGAN KELOMPOK" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                     <input readonly="" id="kelompok_saldo" name="kelompok_saldo" value="'.number_format($saldo_tabungan_kelompok, 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input id="kelompok_rate" name="kelompok_rate" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border:1px dashed #ccc;" maxlength="8" value="0.00"> 
                   <span id="td_span_kelompok_rate" style="display:none;padding-right:5px;">0.00</span>
                   </td> 
                   <td align="right" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                   <input readonly="" id="kelompok_jumlah_bonus" name="kelompok_jumlah_bonus" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;" value="0"> 
                   <span id="td_span_kelompok_jumlah_bonus" style="display:none;padding-right:5px;">0</span>
                   </td>
                   </tr>';

		echo $html;
	}

	public function action_proses_bagihasil()
	{
		$proyeksi_bahas_id = $this->uuids(false);
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$trx_date = $this->input->post('trx_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');
		$trx_date = $this->datepicker_convert(true,$trx_date,'/');
		$periode_bulan = date('m',strtotime($thru_date));
		$periode_tahun = date('Y',strtotime($thru_date));

		// $periode_bulan = $this->input->post('periode_bulan');
		// if ($periode_bulan<10) {
		// 	$periode_bulan = str_replace("0", '', $periode_bulan);
		// }
		// $periode_tahun = $this->input->post('periode_tahun');

		$cek_periode = $this->model_sys->cek_periode_bahas($periode_bulan,$periode_tahun);
		if($cek_periode==1)
		{
			$return = array('success'=>false,'stat'=>'1','message'=>'Periode ini sudah diproses. Silahkan lihat komposisi bagi hasil');
		}
		else
		{
			$pembiayaan_yg_diberikan 	= $this->input->post('span_1');
			$pendapatan_operasional 	= $this->input->post('span_2');
			$dana_pihak_ke3 			= $this->input->post('span_3');
			$porsi_pendapatan_dp3 		= $this->input->post('span_4');
			
			$deposito_product_code 	= $this->input->post('deposit_product_code');
			$deposito_product_name 	= $this->input->post('deposit_product_name');
			$deposito_product_type 	= 2;
			$deposito_saldo 		= $this->input->post('deposit_saldo');
			$deposito_nisbah 		= $this->input->post('deposit_nisbah');
			$deposito_rate 			= $this->input->post('deposit_rate');
			$deposito_akad 			= 1;
	
			$mudharabah_product_code= $this->input->post('mudharabah_product_code');
			$mudharabah_product_name= $this->input->post('mudharabah_product_name');
			$mudharabah_product_type= 1;
			$mudharabah_saldo 		= $this->input->post('mudharabah_saldo');
			$mudharabah_jumlah_bahas= $this->input->post('mudharabah_jumlah_bahas');
			$mudharabah_nisbah 		= $this->input->post('mudharabah_nisbah');
			$mudharabah_rate 		= $this->input->post('mudharabah_rate');
			$mudharabah_akad 		= 1;
	
			$wadiah_product_code 	= $this->input->post('wadiah_product_code');
			$wadiah_product_name 	= $this->input->post('wadiah_product_name');
			$wadiah_product_type 	= 1; // 1 = Tabungan 2=deposito
			$wadiah_saldo 			= $this->input->post('wadiah_saldo');
			$jumlah_bonus 			= $this->input->post('wadiah_jumlah_bonus');
			$wadiah_rate 			= $this->input->post('wadiah_rate');
			$wadiah_akad 			= 0;
		
			$data_proyeksi_bahas = array(
					 'id' 				=> $proyeksi_bahas_id
					,'bulan' 			=> $periode_bulan
					,'tahun' 			=> $periode_tahun
					,'saldo_pembiayaan' => str_replace(",", ".", str_replace(".", "", $pembiayaan_yg_diberikan))
					,'saldo_dp3' 		=> str_replace(",", ".", str_replace(".", "", $dana_pihak_ke3))
					,'saldo_pendapatan' => str_replace(",", ".", str_replace(".", "", $pendapatan_operasional))
					,'pendapatan_dp3' 	=> str_replace(",", ".", str_replace(".", "", $porsi_pendapatan_dp3))
					,'created_by' => $this->session->userdata('user_id')
					,'created_date' => date('Y-m-d H:i:s')
				);
				
			$data_batch1 = array(); //BATCH1 UNTUK DEPOSITO
			if($deposito_product_code){
				for ( $i = 0 ; $i < count($deposito_product_code) ; $i++ )
				{
					$data_batch1[] = array(
							 'proyeksi_bahas_id'=> $proyeksi_bahas_id
							,'product_code' 	=> $deposito_product_code[$i]
							,'product_name' 	=> $deposito_product_name[$i]
							,'product_type' 	=> 2
							,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $deposito_saldo[$i]))
							,'nisbah' 			=> $deposito_nisbah[$i]
							,'rate' 			=> $deposito_rate[$i]
							,'akad' 			=> 1
						);
				}
			}
				
			$data_batch2 = array(); //BATCH2 UNTUK TABUNGAN MUDARABAH
			if($mudharabah_product_code){
				for ( $i = 0 ; $i < count($mudharabah_product_code) ; $i++ )
				{
					$data_batch2[] = array(
							 'proyeksi_bahas_id'=> $proyeksi_bahas_id
							,'product_code' 	=> $mudharabah_product_code[$i]
							,'product_name' 	=> $mudharabah_product_name[$i]
							,'product_type' 	=> 1
							,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $mudharabah_saldo[$i]))
							,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $mudharabah_jumlah_bahas[$i]))
							,'nisbah' 			=> $mudharabah_nisbah[$i]
							,'rate' 			=> $mudharabah_rate[$i]
							,'akad' 			=> 1
						);
				}
			}
				
			$data_batch3 = array(); //BATCH2 UNTUK TABUNGAN WADIAH
			if($wadiah_product_code){
				for ( $i = 0 ; $i < count($wadiah_product_code) ; $i++ )
				{
					$data_batch3[] = array(
							 'proyeksi_bahas_id'=> $proyeksi_bahas_id
							,'product_code' 	=> $wadiah_product_code[$i]
							,'product_name' 	=> $wadiah_product_name[$i]
							,'product_type' 	=> 1
							,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $wadiah_saldo[$i]))
							,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $jumlah_bonus[$i]))
							,'rate' 			=> $wadiah_rate[$i]
							,'akad' 			=> 0
						);
				}
			}
			
			$sukarela_saldo = $this->input->post('sukarela_saldo');
			$sukarela_jumlah_bonus = $this->input->post('sukarela_jumlah_bonus');
			$sukarela_rate = $this->input->post('sukarela_rate');

			$wajib_saldo = $this->input->post('wajib_saldo');
			$wajib_jumlah_bonus = $this->input->post('wajib_jumlah_bonus');
			$wajib_rate = $this->input->post('wajib_rate');

			$kelompok_saldo = $this->input->post('kelompok_saldo');
			$kelompok_jumlah_bonus = $this->input->post('kelompok_jumlah_bonus');
			$kelompok_rate = $this->input->post('kelompok_rate');

			$data_sukarela = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> '97'	
						,'product_name' 	=> 'TABUNGAN SUKARELA'
						,'product_type' 	=> 1
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $sukarela_saldo))
						,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $sukarela_jumlah_bonus))
						,'rate' 			=> $sukarela_rate
						,'akad' 			=> 0
					);

			$data_wajib = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> '98'
						,'product_name' 	=> 'TABUNGAN WAJIB'
						,'product_type' 	=> 1
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $wajib_saldo))
						,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $wajib_jumlah_bonus))
						,'rate' 			=> $wajib_rate
						,'akad' 			=> 0
					);

			$data_kelompok = array(
						 'proyeksi_bahas_id'=> $proyeksi_bahas_id
						,'product_code' 	=> '99'
						,'product_name' 	=> 'TABUNGAN KELOMPOK'
						,'product_type' 	=> 1
						,'saldo' 			=> str_replace(",", ".", str_replace(".", "", $kelompok_saldo))
						,'jumlah_bonus'		=> str_replace(",", ".", str_replace(".", "", $kelompok_jumlah_bonus))
						,'rate' 			=> $kelompok_rate
						,'akad' 			=> 0
					);
			
			$this->db->trans_begin();
			$this->model_sys->insert_into_mfi_proyeksi_bahas($data_proyeksi_bahas);
			if ( $this->db->trans_status() === true )
			{
				$this->db->trans_commit();
	
				if ( count($data_batch1) > 0 || count($data_batch2)>0 || count($data_batch3)>0) {
					$this->db->trans_begin();
					// if(count($data_batch1)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch1);				
					if(count($data_batch2)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch2);
					if(count($data_batch3)>0)$this->model_sys->insert_batch_proyeksi_bahas_detail($data_batch3);
					if(count($data_sukarela)>0)$this->model_sys->insert_proyeksi_bahas_detail($data_sukarela);
					if(count($data_wajib)>0)$this->model_sys->insert_proyeksi_bahas_detail($data_wajib);
					if(count($data_kelompok)>0)$this->model_sys->insert_proyeksi_bahas_detail($data_kelompok);
					if ( $this->db->trans_status() === true )
					{
						$this->db->trans_commit();
						//mulai proses distribusi bagi hasil
							//select semua data di mfi_proyeksi_bahas_detail
							$proyeksi_bahas = $this->model_sys->select_proyeksi_bahas_detail($proyeksi_bahas_id);
							// 	$this->model_sys->do_bagihasil_tabungan($proyeksi_bahas[$j]['product_code'],date('Y-m-d'),$proyeksi_bahas[$j]['rate']);
							// for ($j=0; $j <count($proyeksi_bahas) ; $j++) { //panggil function distribusi bahas
							$this->model_sys->do_bagihasi_kelompok($proyeksi_bahas_id,$trx_date);
							$this->model_sys->fn_proses_jurnal_titipan_bagihasil($proyeksi_bahas_id,$trx_date);
							// }
						//beres proses distribusi bagi hasil
						$return = array('success'=>true,'message'=>'Success');
					}
					else
					{
						$this->db->trans_rollback();
						$return = array('success'=>false,'message'=>'Failed');
					}
				} else {
					$return = array('success'=>true,'message'=>'Success');
				}
	
			}
			else
			{
				$this->db->trans_rollback();
				$return = array('success'=>false,'message'=>'Failed');
			}
		}

		echo json_encode($return);
	}
	public function action_cek_bagihasil()
	{
		$proyeksi_bahas_id = $this->uuids(false);
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		$from_date = $this->datepicker_convert(true,$from_date,'/');
		$thru_date = $this->datepicker_convert(true,$thru_date,'/');
		$periode_bulan = date('m',strtotime($thru_date));
		$periode_tahun = date('Y',strtotime($thru_date));
		/*$periode_bulan = $this->input->post('periode_bulan');
		if ($periode_bulan<10) {
			$periode_bulan = str_replace("0", '', $periode_bulan);
		}
		$periode_tahun = $this->input->post('periode_tahun');*/

		$cek_periode = $this->model_sys->cek_periode_bahas($periode_bulan,$periode_tahun);
		if($cek_periode>0)
		{
			$return = array('success'=>false,'stat'=>'1');
		}
		else
		{
			$return = array('success'=>false,'stat'=>'2');
		}

		echo json_encode($return);
	}
	public function uuids($hyphen = true) {

		// The field names refer to RFC 4122 section 4.1.2
		if($hyphen == false){
			return sprintf('%04x%04x%04x%03x4%04x%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
			);
		}else{

			return sprintf('%04x%04x-%04x-%03x4-%04x-%04x%04x%04x',
			mt_rand(0, 65535), mt_rand(0, 65535), // 32 bits for "time_low"
			mt_rand(0, 65535), // 16 bits for "time_mid"
			mt_rand(0, 4095),  // 12 bits before the 0100 of (version) 4 for "time_hi_and_version"
			bindec(substr_replace(sprintf('%016b', mt_rand(0, 65535)), '01', 6, 2)),
			// 8 bits, the last two of which (positions 6 and 7) are 01, for "clk_seq_hi_res"
			// (hence, the 2nd hex digit after the 3rd hyphen can only be 1, 5, 9 or d)
			// 8 bits for "clk_seq_low"
			mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535) // 48 bits for "node"
			);
		}
	} 

	public function get_data_proyeksi_bahas()
	{
		$from_date=$this->input->post('from_date');
		$thru_date=$this->input->post('thru_date');
		$from_date=$this->datepicker_convert(true,$from_date,'/');
		$thru_date=$this->datepicker_convert(true,$thru_date,'/');
		$y = date('Y',strtotime($thru_date));
		$m = date('m',strtotime($thru_date));

		/*
		$y	= $this->input->post('tahun');
		$m	= $this->input->post('bulan');
		$first = date('Y-m-01', strtotime($y.'-'.$m.'-01')); // hard-coded '01' for first day
		$last  = date('Y-m-t', strtotime($y.'-'.$m.'-01'));*/

		$data_bahas 	= $this->model_sys->get_data_proyeksi_bahas($m,$y);
		

		$data['pembiayaan_yg_diberikan']	= number_format($data_bahas['saldo_pembiayaan'], 0, ",", ".");
		$data['pendapatan_operasional']		= number_format($data_bahas['saldo_pendapatan'], 0, ",", ".");
		$data['dana_pihak_ke3']				= number_format($data_bahas['saldo_dp3'], 0, ",", ".");
		$data['porsi_pendapatan_dp3']		= number_format($data_bahas['pendapatan_dp3'], 0, ",", ".");
		$data['id_proyeksi_bahas']			= $data_bahas['id'];
		
		echo json_encode($data);
	}
	public function generate_product_komposisi()
	{
		$id_proyeksi_bahas	= $this->input->post('id_proyeksi_bahas');

		$data 	= $this->model_sys->generate_product_komposisi($id_proyeksi_bahas);
		$html = '';
		for ($i=0; $i <count($data) ; $i++) 
		{
			$jumlah_bonus = ($data[$i]['jumlah_bonus']>0) ? number_format($data[$i]['jumlah_bonus'], 0, ",", ".") : '-' ;
			$nisbah = ($data[$i]['akad']==0) ? '-' : $data[$i]['nisbah'] ;
			$html .= '  <tr>
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="product_name" readonly="" value="'.$data[$i]['product_name'].'" type="text" style="background-color:#fff;text-align:left;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input id="saldo"readonly="" value="'.number_format($data[$i]['saldo'], 0, ",", ".").'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td>
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                            <input id="saldo"readonly="" value="'.$nisbah.'" type="text" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:95%;"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="rate" type="text"readonly="" value="'.round($data[$i]['rate'],2).'" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;border-color:#fff" maxlength="8"> 
                          </td> 
                          <td align="center" style="padding:3px 0;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"> 
                          	<input id="jumlah_bonus"readonly="" type="text" value="'.$jumlah_bonus.'" style="background-color:#fff;text-align:right;border-color:#fff;box-shadow:none;transition:none;width:90%;"> 
                          </td>
                        </tr>';
		}
		
		echo $html;
	}
	//END BEGIN BAGI HASIL BARU
	/***************************************************************************************/
	

	/***************************************************************************************/
	//BEGIN GL BAHAS
	public function account_gl_bahas()
	{
		$data['container'] = 'sys/account_gl_bahas';
		$this->load->view('core',$data);
	}

	public function datatable_sys_account_setup()
	{
		/* Array of database columns which should be read and sent back to DataTables. Use a space where
		 * you want to insert a non-database field (for example a counter or static image)
		 */

		$code_group = isset($_GET['code_group'])?$_GET['code_group']:'';
		$aColumns = array('','code_group','code_value','display_text','');
				
		/* 
		 * Paging
		 */
		$sLimit = "";
		if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
		{
			$sLimit = " OFFSET ".intval( $_GET['iDisplayStart'] )." LIMIT ".
				intval( $_GET['iDisplayLength'] );
		}
		
		/*
		 * Ordering
		 */
		$sOrder = "";
		if ( isset( $_GET['iSortCol_0'] ) )
		{
			$sOrder = "ORDER BY   ";
			for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )
			{
				if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
				{
					$sOrder .= "".$aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".
						($_GET['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}
			
			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( $sOrder == "ORDER BY " )
			{
				$sOrder = "";
			}
		}
		
		$sWhere = '';

		$rResult 			= $this->model_sys->datatable_sys_account_setup($sWhere,$sOrder,$sLimit,$code_group); // query get data to view
		$rResultFilterTotal = $this->model_sys->datatable_sys_account_setup($sWhere,'','',$code_group); // get number of filtered data
		$iFilteredTotal 	= count($rResultFilterTotal); 
		$rResultTotal 		= $this->model_sys->datatable_sys_account_setup('','','',$code_group); // get number of all data
		$iTotal 			= count($rResultTotal);	
		
		/*
		 * Output
		 */
		$output = array(
			"sEcho" => intval($_GET['sEcho']),
			"iTotalRecords" => $iTotal,
			"iTotalDisplayRecords" => $iFilteredTotal,
			"aaData" => array()
		);
		
		foreach($rResult as $aRow)
		{
			$row = array();
			$row[] = '<input type="checkbox" value="'.$aRow['list_code_detail_id'].'" id="checkbox" class="checkboxes" >';
			$row[] = $aRow['code_group'];
			$row[] = $aRow['code_value'];
			$row[] = $aRow['display_text'];
			$row[] = '<div align="center"><a class="btn mini purple" href="javascript:;" list_code_detail_id="'.$aRow['list_code_detail_id'].'" id="link-edit">Edit</a></div>';

			$output['aaData'][] = $row;
		}
		
		echo json_encode( $output );
	}
	
	public function delete_sys_account_bahas()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');

		$success = 0;
		$failed  = 0;
		for ( $i = 0 ; $i < count($list_code_detail_id) ; $i++ )
		{
			$param = array('list_code_detail_id'=>$list_code_detail_id[$i]);
			$this->db->trans_begin();
			$this->model_sys->delete_sys_account_bahas($param);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
				$success++;
			}else{
				$this->db->trans_rollback();
				$failed++;
			}
		}

		if($success==0){
			$return = array('success'=>false,'num_success'=>$success,'num_failed'=>$failed);
		}else{
			$return = array('success'=>true,'num_success'=>$success,'num_faield'=>$failed);
		}

		echo json_encode($return);
	}
	public function proses_input_setup_gl_bahas()
	{
		$code_group 	= $this->input->post('code_group1');
		$code_value 	= $this->input->post('code_value1');
		$display_text 	= $this->input->post('display_text1');

		$data = array
				(
					'code_group'				=> $code_group
					,'code_value'				=> $code_value
					,'display_text'				=> $display_text
				);

		$this->db->trans_begin();
		$this->model_sys->proses_input_setup_gl_bahas($data);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	public function get_gl_account_bahas_by_id()
	{
		$list_code_detail_id = $this->input->post('list_code_detail_id');
		$data = $this->model_sys->get_gl_account_bahas_by_id($list_code_detail_id);

		echo json_encode($data);
	}
	public function proses_edit_setup_gl_bahas()
	{
		$list_code_detail_id 	= $this->input->post('list_code_detail_id');
		$code_group 	= $this->input->post('code_group2');
		$code_value 	= $this->input->post('code_value2');
		$display_text 	= $this->input->post('display_text2');

		$param = array('list_code_detail_id'=>$list_code_detail_id);
		$data = array
				(
					'code_group'				=> $code_group
					,'code_value'				=> $code_value
					,'display_text'				=> $display_text
				);

		$this->db->trans_begin();
		$this->model_sys->proses_edit_setup_gl_bahas($data,$param);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	//END BEGIN GL BAHAS
	/***************************************************************************************/


	function cek_validasi_transaksi()
	{
		$data['title'] = 'Cek Validasi Transaksi';
		$data['container'] = 'sys/cek_validasi_transaksi';
		$data['unverifieds'] = $this->get_unverifieds_trx($this->session->userdata('branch_code'));
		$data['cabang'] = $this->model_laporan->get_all_branch();
		$this->load->view('core',$data);
	}

	function ajax_get_unverifieds()
	{
		$branch_code = $this->input->post('branch_code');
		echo $this->get_unverifieds_trx($branch_code);
	}

	function get_unverifieds_trx($branch_code)
	{
		$num_trx_cm_verified_not_yet = $this->model_sys->num_trx_cm_verified_not_yet($branch_code);
		$num_trx_saving_verified_not_yet = $this->model_sys->num_trx_saving_verified_not_yet($branch_code);
		$num_trx_mutasi_verified_not_yet = $this->model_sys->num_trx_mutasi_verified_not_yet($branch_code);
		$list_date_unverified_trx_cm = $this->get_list_date_unverified_trx_cm($branch_code);
		$list_date_unverified_trx_saving = $this->get_list_date_unverified_trx_saving($branch_code);
		$list_date_unverified_trx_mutasi = $this->get_list_date_unverified_trx_mutasi($branch_code);

	    $n=0;

	    $unverified = '';

	    if( $num_trx_cm_verified_not_yet > 0 || $num_trx_saving_verified_not_yet > 0 || $num_trx_mutasi_verified_not_yet > 0 ){
	    	$unverified .= '
		    <div class="alert alert-warning">
		      <div style="font-weight:bold">Warning!</div>';
		    if ($num_trx_cm_verified_not_yet>0) {
			    $n++; 
			    $unverified .= $n.'. ('.$num_trx_cm_verified_not_yet.') Transaksi Rembug belum diverifikasi<br>'; 
			    $unverified .= 'Tanggal : '.$list_date_unverified_trx_cm.'<br>';
		    } 
		    if ($num_trx_saving_verified_not_yet>0) {
		        $n++; 
		        $unverified .= $n.'. ('.$num_trx_saving_verified_not_yet.') Transaksi Tabungan belum diverifikasi<br>'; 
		        $unverified .= 'Tanggal : '.$list_date_unverified_trx_saving.'<br>';
		    } 
		    if ($num_trx_mutasi_verified_not_yet>0) {
		        $n++; 
		        $unverified .= $n.'. ('.$num_trx_mutasi_verified_not_yet.') Registrasi Anggota Keluar belum diverifikasi<br>'; 
		        $unverified .= 'Tanggal : '.$list_date_unverified_trx_mutasi;
		    } 
		    $unverified .= '</div>';
	    }

	    return $unverified;
	}

	function load_data_cek_outstanding()
	{
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		if($from_date!=''){
			$from_date=$this->datepicker_convert(true,$from_date,'/');
		}
		if($thru_date!=''){
			$thru_date=$this->datepicker_convert(true,$thru_date,'/');
		}
		/*query outstanding pembiayaan*/
        
        $param = array();
		$sql = "select
				(select sum(a.saldo_pokok) from mfi_account_financing a, mfi_cif b
				where a.cif_no=b.cif_no and a.status_rekening=1 and b.status=1";
		if ($branch_code!="00000") {
			$sql .= " and b.branch_code in(select branch_code from mfi_branch_member where branch_induk='10201')";
			//$param[] = $branch_code;
		}
		$sql .= ") as rinci,
				(select
				fn_get_saldo_group_glaccount2(a.gl_report_item_id,a.item_type,?,?)
				from mfi_gl_report_item a where a.item_code='1030900' and a.report_code='10'
				) as ledger";
		$param[] = $thru_date;
		if ($branch_code=='00000') {
			$param[] = 'all';
		} else {
			$param[] = $branch_code;
		}
		$query = $this->db->query($sql,$param);
		$outstandings = $query->result_array();
		// $outstandings = array();

        $html = '';

		foreach ($outstandings as $outstanding) {
			$color_ledger='';
			$color_rinci='';
			if($outstanding['ledger']!=$outstanding['rinci']) $color_ledger=' color:red';
			if($outstanding['ledger']!=$outstanding['rinci']) $color_rinci=' color:red';
			$html .= '
				<tr>
				<td style="font-size:12px;font-weight:bold;">OUTSTANDING</td>
				<td style="font-size:13px;" align="right"><span style="'.$color_ledger.'">'.number_format($outstanding['ledger'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_rinci.'">'.number_format($outstanding['rinci'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="font-weight:bold;">'.number_format($outstanding['ledger']-$outstanding['rinci'],2,',','.').'</span></td>
				</tr>
			';
		}
		echo json_encode(array('html'=>$html));
	}

	function load_data_cek(){
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');

		if($from_date!=''){
			$from_date = $this->datepicker_convert(true,$from_date,'/');
		}

		if($thru_date!=''){
			$thru_date=$this->datepicker_convert(true,$thru_date,'/');
		}

		$pembiayaan = $this->model_sys->hitung_pembiayaan($branch_code,$from_date,$thru_date);

		$html = '
		<tr>
			<td style="font-size:12px;font-weight:bold;" colspan="4">PRODUK PEMBIAYAAN</td>
		</tr>
		';

		foreach($pembiayaan as $financing){
			/*
			if($financing['selisih'] < 0){
				$selisih = $financing['selisih'] * -1;
			} else {
				$selisih = $financing['selisih'];
			}
			*/
			$selisih = $financing['ledger'] - $financing['rinci'];
			$html .= '
			<tr>
				<td style="font-size:13px;">'.$financing['product_name'].'</td>
				<td style="font-size:13px;" align="right">'.number_format($financing['ledger'],2,',','.').'</td>
				<td style="font-size:13px;" align="right">'.number_format($financing['rinci'],2,',','.').'</td>
				<td style="font-size:13px;" align="right">'.number_format($selisih,2,',','.').'</td>
			</tr>
			';
		}

		$html .= '
		<tr>
			<td style="font-size:12px;font-weight:bold;" colspan="4">TABUNGAN ANGGOTA</td>
		</tr>
		';

		$catab = $this->model_sys->hitung_catab($branch_code,$from_date,$thru_date);
		$anggota = $this->model_sys->hitung_member($branch_code,$from_date,$thru_date);

		// selisih catab
		/*
		if($catab['selisih_catab'] < 0){
			$selisih_catab = $catab['selisih_catab'] * -1;
		} else {
			$selisih_catab = $catab['selisih_catab'];
		}
		*/
		
		$selisih_catab = $catab['ledger'] - $catab['total_catab'];

		// selisih tawab
		/*
		if($anggota['selisih_tawab'] < 0){
			$selisih_tawab = $anggota['selisih_tawab'] * -1;
		} else {
			$selisih_tawab = $anggota['selisih_tawab'];
		}
		*/
		
		$selisih_tawab = $anggota['ledger_tawab'] - $anggota['total_tawab'];

		// selisih takel
		/*
		if($anggota['selisih_takel'] < 0){
			$selisih_takel = $anggota['selisih_takel'] * -1;
		} else {
			$selisih_takel = $anggota['selisih_takel'];
		}
		*/
		
		$selisih_takel = $anggota['ledger_takel'] - $anggota['total_takel'];

		// selisih tasuk
		/*
		if($anggota['selisih_tasuk'] < 0){
			$selisih_tasuk = $anggota['selisih_tasuk'] * -1;
		} else {
			$selisih_tasuk = $anggota['selisih_tasuk'];
		}
		*/
		
		$selisih_tasuk = $anggota['ledger_tasuk'] - $anggota['total_tasuk'];

		// selisih lwk
		/*
		if($anggota['selisih_lwk'] < 0){
			$selisih_lwk = $anggota['selisih_lwk'] * -1;
		} else {
			$selisih_lwk = $anggota['selisih_lwk'];
		}
		*/
		
		$selisih_lwk = $anggota['ledger_lwk'] - $anggota['total_lwk'];

		$html .= '
		<tr>
			<td style="font-size:13px;">Tabungan Catab</td>
			<td style="font-size:13px;" align="right">'.number_format($catab['ledger'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($catab['total_catab'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($selisih_catab,2,',','.').'</td>
		</tr>
		<tr>	
			<td style="font-size:13px;">Tabungan Wajib</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['ledger_tawab'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['total_tawab'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($selisih_tawab,2,',','.').'</td>
		</tr>
		<tr>
			<td style="font-size:13px;">Tabungan Kelompok</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['ledger_takel'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['total_takel'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($selisih_takel,2,',','.').'</td>
		</tr>
		<tr>
			<td style="font-size:13px;">Tabungan Sukarela</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['ledger_tasuk'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['total_tasuk'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($selisih_tasuk,2,',','.').'</td>
		</tr>
		<tr>
			<td style="font-size:13px;">LWK</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['ledger_lwk'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($anggota['total_lwk'],2,',','.').'</td>
			<td style="font-size:13px;" align="right">'.number_format($selisih_lwk,2,',','.').'</td>
		</tr>
		';

		$html .= '
		<tr>
			<td style="font-size:12px;font-weight:bold;" colspan="4">TABUNGAN BERENCANA</td>
		</tr>
		';

		$tabungan = $this->model_sys->hitung_saving($branch_code,$from_date,$thru_date);

		foreach($tabungan as $saving){
			// selisih taber
			/*
			if($saving['selisih_tabungan'] < 0){
				$selisih_tabungan = $saving['selisih_tabungan'] * -1;
			} else {
				$selisih_tabungan = $saving['selisih_tabungan'];
			}
			*/
			
			$selisih_tabungan = $saving['ledger'] - $saving['rinci'];

			$html .= '
			<tr>
				<td style="font-size:13px;">'.$saving['product_name'].'</td>
				<td style="font-size:13px;" align="right">'.number_format($saving['ledger'],2,',','.').'</td>
				<td style="font-size:13px;" align="right">'.number_format($saving['rinci'],2,',','.').'</td>
				<td style="font-size:13px;" align="right">'.number_format($selisih_tabungan,2,',','.').'</td>
			</tr>
			';
		}

		$result = array('html' => $html);

		echo json_encode($result);

	}

	function load_data_cek_validasi_transaksi()
	{
		$branch_code = $this->input->post('branch_code');
		$from_date = $this->input->post('from_date');
		$thru_date = $this->input->post('thru_date');
		if($from_date!=''){
			$from_date=$this->datepicker_convert(true,$from_date,'/');
		}
		if($thru_date!=''){
			$thru_date=$this->datepicker_convert(true,$thru_date,'/');
		}

		/*query produk pembiayaan*/
		$sql="select 
				a.product_code,
				a.product_name,
				coalesce(fn_get_saldo_gl_account2(b.gl_saldo_pokok,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(b.gl_saldo_pokok,?,?,'C',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(b.gl_saldo_pokok,?,?,'D',?),0) as credit,
				coalesce(fn_get_saldo_rinci(a.product_code,?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci(a.product_code,?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci(a.product_code,?,?,'C',?),0) as credit_r
			  from mfi_product_financing a
			  left join mfi_product_financing_gl b on a.product_financing_gl_code=b.product_financing_gl_code
			  where a.jenis_pembiayaan = '1'
			";

		if($branch_code=='00000') $branch_code='all';

		$param=array($from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code);
		$query=$this->db->query($sql,$param);
		$produk=$query->result_array();
        
        $html = '<tr><td style="font-size:12px;font-weight:bold;" colspan="9">PRODUK PEMBIAYAAN</td></tr>';

		foreach ($produk as $product) {
			$saldo_akhir = $product['saldo_awal']+$product['debit']-$product['credit'];
			$saldo_akhir_r = $product['saldo_awal_r']+$product['debit_r']-$product['credit_r'];
			$color_debit='';
			$color_credit='';
			if($product['debit']!=$product['debit_r']) $color_debit=' color:red';
			if($product['credit']!=$product['credit_r']) $color_credit=' color:red';
				//<td style="font-size:13px;" align="right">'.number_format($product['saldo_awal'],2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format($saldo_akhir,2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format($product['saldo_awal_r'],2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format($saldo_akhir_r,2,',','.').'</td>
			$html .= '
				<tr>
				<td style="font-size:13px;">'.$product['product_name'].'</td>
				<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($product['debit'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($product['credit'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($product['debit_r'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($product['credit_r'],2,',','.').'</span></td>
				</tr>
			';
		}

		/*query gl tabungan*/
		$sql2="select * from mfi_product_cm_gl limit 1";
		$query2=$this->db->query($sql2);
		$cm_gl = $query2->row_array();
		
		/*query gl lwk*/
		$sql3="select code_value as gl_setoran_lwk from mfi_list_code_detail where code_group='gl_setoran_lwk'";
		$query3=$this->db->query($sql3);
		$lwk_gl = $query3->row_array();

		/*query gl infaq*/
		$sql4="select code_value as gl_infaq_kelompok from mfi_list_code_detail where code_group='gl_infaq_kelompok'";
		$query4=$this->db->query($sql4);
		$infaq_gl = $query4->row_array();

		$tab_wajib=$cm_gl['gl_tab_wajib'];
		$tab_kelompok=$cm_gl['gl_tab_kelompok'];
		$tab_sukarela=$cm_gl['gl_tab_sukarela'];
		$setoran_lwk=$lwk_gl['gl_setoran_lwk'];
		$infaq_kelompok=$infaq_gl['gl_infaq_kelompok'];

		/*
		| TABUNGAN CADANGAN (CATAB)
		*/
		$sqltab0="select 
				coalesce(fn_get_mutasi_gl_account_catab(?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account_catab(?,?,'C',?),0) as credit,
				coalesce(fn_get_mutasi_rinci_catab(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_catab(?,?,'C',?),0) as credit_r";
		$prmtab0= array(
				$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code,
				$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab0=$this->db->query($sqltab0,$prmtab0);
		$_ctb=$qrytab0->row_array();

        /*Generate HTML*/
		$color_debit='';
		$color_credit='';
		if($_ctb['debit']!=$_ctb['debit_r']) $color_debit=' color:red';
		if($_ctb['credit']!=$_ctb['credit_r']) $color_credit=' color:red';
        $html .= '
        	<tr><td style="font-size:12px;font-weight:bold;" colspan="9">TABUNGAN ANGGOTA</td></tr>
			<tr>
			<td style="font-size:13px;">Tabungan Catab</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_ctb['debit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_ctb['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_ctb['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_ctb['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*
		| TABUNGAN WAJIB
		*/
		$sqltab1="select coalesce(fn_get_saldo_gl_account2(?,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_tab_wajib(?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci_wajib(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_wajib(?,?,'C',?),0) as credit_r";
		$prmtab1= array(
				$tab_wajib,$from_date,$branch_code,$tab_wajib,$from_date,$thru_date,$branch_code,$tab_wajib,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab1=$this->db->query($sqltab1,$prmtab1);
		$_twjb=$qrytab1->row_array();

        /*Generate HTML*/
		$_satwjb = ($_twjb['saldo_awal']*-1)-$_twjb['debit']+$_twjb['credit'];
		$_satwjb_r = ($_twjb['saldo_awal_r']*-1)-$_twjb['debit_r']+$_twjb['credit_r'];
		$color_debit='';
		$color_credit='';
		if($_twjb['debit']!=$_twjb['debit_r']) $color_debit=' color:red';
		if($_twjb['credit']!=$_twjb['credit_r']) $color_credit=' color:red';
			//<td style="font-size:13px;" align="right">'.number_format(($_twjb['saldo_awal']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satwjb,2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format(($_twjb['saldo_awal_r']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satwjb_r,2,',','.').'</td>
        $html .= '
			<tr>
			<td style="font-size:13px;">Tabungan Wajib</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_twjb['debit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_twjb['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_twjb['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_twjb['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*
		| TABUNGAN KELOMPOK
		*/
		$sqltab2="select coalesce(fn_get_saldo_gl_account2(?,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_tab_kelompok(?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci_kelompok(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_kelompok(?,?,'C',?),0) as credit_r";
		$prmtab2= array(
				$tab_kelompok,$from_date,$branch_code,$tab_kelompok,$from_date,$thru_date,$branch_code,$tab_kelompok,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab2=$this->db->query($sqltab2,$prmtab2);
		$_tkel=$qrytab2->row_array();

        /*Generate HTML*/
		$_satkel = ($_tkel['saldo_awal']*-1)-$_tkel['debit']+$_tkel['credit'];
		$_satkel_r = ($_tkel['saldo_awal_r']*-1)-$_tkel['debit_r']+$_tkel['credit_r'];
		$color_debit='';
		$color_credit='';
		if($_tkel['debit']!=$_tkel['debit_r']) $color_debit=' color:red';
		if($_tkel['credit']!=$_tkel['credit_r']) $color_credit=' color:red';
			//<td style="font-size:13px;" align="right">'.number_format(($_tkel['saldo_awal']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satkel,2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format(($_tkel['saldo_awal_r']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satkel_r,2,',','.').'</td>
        $html .= '
			<tr>
			<td style="font-size:13px;">Tabungan Kelompok</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tkel['debit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tkel['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tkel['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tkel['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*
		| TABUNGAN SUKARELA
		*/
		$sqltab3="select coalesce(fn_get_saldo_gl_account2(?,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_tab_sukarela(?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci_sukarela(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_sukarela(?,?,'C',?),0) as credit_r";
		$prmtab3= array(
				$tab_sukarela,$from_date,$branch_code,$tab_sukarela,$from_date,$thru_date,$branch_code,$tab_sukarela,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab3=$this->db->query($sqltab3,$prmtab3);
		$_tskrl=$qrytab3->row_array();

        /*Generate HTML*/
		$_satskrl = ($_tskrl['saldo_awal']*-1)-$_tskrl['debit']+$_tskrl['credit'];
		$_satskrl_r = ($_tskrl['saldo_awal_r']*-1)-$_tskrl['debit_r']+$_tskrl['credit_r'];
		$color_debit='';
		$color_credit='';
		if($_tskrl['debit']!=$_tskrl['debit_r']) $color_debit=' color:red';
		if($_tskrl['credit']!=$_tskrl['credit_r']) $color_credit=' color:red';
			//<td style="font-size:13px;" align="right">'.number_format(($_tskrl['saldo_awal']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satskrl,2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format(($_tskrl['saldo_awal_r']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_satskrl_r,2,',','.').'</td>
        $html .= '
			<tr>
			<td style="font-size:13px;">Tabungan Sukarela</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tskrl['debit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tskrl['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tskrl['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tskrl['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*
		| TABUNGAN LWK
		*/
		$sqltab4="select coalesce(fn_get_saldo_gl_account2(?,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account2(?,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_minggon(?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci_lwk(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_lwk(?,?,'C',?),0) as credit_r";
		$prmtab4= array(
				$setoran_lwk,$from_date,$branch_code,$setoran_lwk,$from_date,$thru_date,$branch_code,$setoran_lwk,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab4=$this->db->query($sqltab4,$prmtab4);
		$_tlwk=$qrytab4->row_array();

        /*Generate HTML*/
		$_salwk = ($_tlwk['saldo_awal']*-1)-0+$_tlwk['credit'];
		$_salwk_r = ($_tlwk['saldo_awal_r']*-1)-$_tlwk['debit_r']+$_tlwk['credit_r'];
		$color_debit='';
		$color_credit='';
		if(0!=$_tlwk['debit_r']) $color_debit=' color:red';
		if($_tlwk['credit']!=$_tlwk['credit_r']) $color_credit=' color:red';
			//<td style="font-size:13px;" align="right">'.number_format(($_tlwk['saldo_awal']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_salwk,2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format(($_tlwk['saldo_awal_r']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_salwk_r,2,',','.').'</td>
        $html .= '
			<tr>
			<td style="font-size:13px;">LWK</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format(0,2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tlwk['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tlwk['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tlwk['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*
		| TABUNGAN INFAQ KELOMPOK
		*/
		$sqltab5="select coalesce(fn_get_saldo_gl_account2(?,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account3(?,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account3(?,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_infaq(?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_rinci_infaq(?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_rinci_infaq(?,?,'C',?),0) as credit_r";
		$prmtab5= array(
				$infaq_kelompok,$from_date,$branch_code,$infaq_kelompok,$from_date,$thru_date,$branch_code,$infaq_kelompok,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$qrytab5=$this->db->query($sqltab5,$prmtab5);
		$_tinfaq=$qrytab5->row_array();

        /*Generate HTML*/
		$_sainfaq = ($_tinfaq['saldo_awal']*-1)-0+$_tinfaq['credit'];
		$_sainfaq_r = ($_tinfaq['saldo_awal_r']*-1)-$_tinfaq['debit_r']+$_tinfaq['credit_r'];
		$color_debit='';
		$color_credit='';
		if(0!=$_tinfaq['debit_r']) $color_debit=' color:red';
		if($_tinfaq['credit']!=$_tinfaq['credit_r']) $color_credit=' color:red';
			//<td style="font-size:13px;" align="right">'.number_format(($_tinfaq['saldo_awal']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_sainfaq,2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format(($_tinfaq['saldo_awal_r']*-1),2,',','.').'</td>
			//<td style="font-size:13px;" align="right">'.number_format($_sainfaq_r,2,',','.').'</td>
        $html .= '
			<tr>
			<td style="font-size:13px;">INFAQ</td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format(0,2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tinfaq['credit'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($_tinfaq['debit_r'],2,',','.').'</span></td>
			<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($_tinfaq['credit_r'],2,',','.').'</span></td>
			</tr>
		';

		/*query produk tabungan*/
		$sql5="select 
				a.product_code,
				a.product_name,
				coalesce(fn_get_saldo_gl_account2(b.gl_saldo,?,?),0) as saldo_awal,
				coalesce(fn_get_mutasi_gl_account3(b.gl_saldo,?,?,'D',?),0) as debit,
				coalesce(fn_get_mutasi_gl_account3(b.gl_saldo,?,?,'C',?),0) as credit,
				coalesce(fn_get_saldo_berencana_rinci(a.product_code,?,?),0) as saldo_awal_r,
				coalesce(fn_get_mutasi_berencana_rinci(a.product_code,?,?,'D',?),0) as debit_r,
				coalesce(fn_get_mutasi_berencana_rinci(a.product_code,?,?,'C',?),0) as credit_r
			  from mfi_product_saving a
			  left join mfi_product_saving_gl b on a.product_saving_gl_code=b.product_saving_gl_code
			  where a.jenis_tabungan = 1 and a.product_code not in('0006')
			";

		if($branch_code=='00000') $branch_code='all';

		$param5=array(
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code,
				$from_date,$branch_code,$from_date,$thru_date,$branch_code,$from_date,$thru_date,$branch_code
			);
		$query5=$this->db->query($sql5,$param5);
		// echo "<pre>";
		// print_r($this->db);
		// die();
		$produk2=$query5->result_array();

        $html .= '<tr><td style="font-size:12px;font-weight:bold;" colspan="9">TABUNGAN BERENCANA</td></tr>';
		foreach ($produk2 as $product2) {
			$saldo_akhir2 = ($product2['saldo_awal']*-1)+$product2['debit']-$product2['credit'];
			$saldo_akhir2_r = ($product2['saldo_awal_r']*-1)+$product2['debit_r']-$product2['credit_r'];
			$color_debit='';
			$color_credit='';
			if($product2['debit']!=$product2['debit_r']) $color_debit=' color:red';
			if($product2['credit']!=$product2['credit_r']) $color_credit=' color:red';
				//<td style="font-size:13px;" align="right">'.number_format(($product2['saldo_awal']*-1),2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format($saldo_akhir2,2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format(($product2['saldo_awal_r']*-1),2,',','.').'</td>
				//<td style="font-size:13px;" align="right">'.number_format($saldo_akhir2_r,2,',','.').'</td>
			$html .= '
				<tr>
				<td style="font-size:13px;">'.$product2['product_name'].'</td>
				<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($product2['debit'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($product2['credit'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_debit.'">'.number_format($product2['debit_r'],2,',','.').'</span></td>
				<td style="font-size:13px;" align="right"><span style="'.$color_credit.'">'.number_format($product2['credit_r'],2,',','.').'</span></td>
				</tr>
			';
		}

		echo json_encode(array('html'=>$html));
	}

	function proses_bonus()
	{
		$data['title'] = 'Proses Bonus';
		$data['container'] = 'sys/proses_bonus';
		$data['from_date'] = $this->get_from_trx_date();
		$data['thru_date'] = $this->get_thru_trx_date();
		$this->load->view('core',$data);
	}

	function get_least_amount_titipan($cif_no)
	{
		$data = $this->model_sys->get_amount_titipan_bagihasil_by_cif_no($cif_no,'D');
		$amount = $data['amount'];
		
		$nr = substr($amount,-3);
		$nl = substr($amount,0,(strlen($amount)-3));
		if($nr>500){
			$n=$nl.'500';
			$sisa=$nr-500;
		}else if($nr>0){
			$n=$nl.'000';
			$sisa=$nr;
		}else{
			$n=$amount;
			$sisa=0;
		}
		$return['nominal'] = $n;
		$return['sisa'] = $sisa;
		return $return;
	}

	function do_proses_bonus()
	{
		$from_date=$this->datepicker_convert(true,$this->input->post('from_date'),'/');
		$thru_date=$this->datepicker_convert(true,$this->input->post('thru_date'),'/');
		// echo "<pre>";
		// var_dump($from_date);
		// var_dump($thru_date);
		// die();
		/*
		| GET TITIPAN BAGIHASIL
		| ------------------------------------------------------
		| @param : status = 0
		| @param : trx_date between from_date and thru_date
		*/
		$data_titipan = $this->model_sys->get_titipan_bagihasil_by_periode($from_date,$thru_date,'C');
		// print_r($data_titipan);
		// die();
		$data_trx_titipan = array();
		$data_debet_titipan = array();
		$is_called=false;
		for ( $i = 0 ; $i < count($data_titipan) ; $i++ )
		{
			
			$least_amount_titipan = $this->get_least_amount_titipan($cif_no);	

			switch ($data_titipan[$i]['keterangan']) {
				case 'TABUNGAN SUKARELA':
				$trx_type='1';
				$data_titipan[$i]['amount'] = $data_titipan[$i]['amount']-$least_amount_titipan['sisa'];
				break;
				case 'TABUNGAN WAJIB':
				$trx_type='2';
				break;
				case 'TABUNGAN KELOMPOK':
				$trx_type='3';
				break;
				default:
				$trx_type='4'; // tabungan
				break;
			}

			/*for history*/
			$data_trx_titipan[] = array(
					'cif_no'=>$data_titipan[$i]['cif_no'],
					'account_saving_no'=>$data_titipan[$i]['account_saving_no'],
					'trx_date'=>date('Y-m-d'),
					'amount'=>$data_titipan[$i]['amount'],
					'trx_type'=>$trx_type,
					'titipan_bagihasil_id'=>$data_titipan[$i]['titipan_bagihasil_id'],
					'created_stamp'=>date('Y-m-d H:i:s'),
					'created_by'=>$this->session->userdata('user_id')
				);

			/*for pendebetan titipan*/
			$data_debet_titipan[] = array(
					'titipan_bagihasil_id'=>uuid(false),
					'cif_no'=>$data_titipan[$i]['cif_no'],
					'account_saving_no'=>$data_titipan[$i]['account_saving_no'],
					'trx_date'=>$data_titipan[$i]['trx_date'],
					'amount'=>$data_titipan[$i]['amount'],
					'flag_debit_credit'=>'D',
					'keterangan'=>$data_titipan[$i]['keterangan'],
					'created_by'=>$this->session->userdata('user_id'),
					'created_stamp'=>date('Y-m-d H:i:s'),
					'bahas_type'=>$data_titipan[$i]['bahas_type'],
					'status'=>0
				);
		}

		if(count($data_trx_titipan)>0)
		{
			$this->db->trans_begin();
			$this->db->insert_batch('temp_mfi_trx_titipan_bagihasil',$data_trx_titipan);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
			}else{
				$this->db->trans_rollback();
			}
		}

		if(count($data_debet_titipan)>0)
		{
			$this->db->trans_begin();
			$this->db->insert_batch('temp_mfi_titipan_bagihasil',$data_debet_titipan);
			if($this->db->trans_status()===true){
				$this->db->trans_commit();
			}else{
				$this->db->trans_rollback();
			}
		}

		/*masukan bonus ke sukarela*/
		$data_bonus = $this->model_sys->get_sum_bonus_titipan($from_date,$thru_date);
		$amounts = 0;
		for( $j = 0 ; $j < count($data_bonus) ; $j++ )
		{
			$amounts+=$data_bonus[$j]['amount'];
			$data_balance = array('tabungan_sukarela'=>$data_bonus[$j]['amount']);
			$param_balance = array('cif_no'=>$data_bonus[$j]['cif_no']);
			
			// $this->db->trans_begin();
			// $this->db->update('mfi_account_default_balance',$data_balance,$param_balance);
			// if($this->db->trans_status()===true){
			// 	$this->db->trans_commit();
			// }else{
			// 	$this->db->trans_rollback();
			// }	
		}

		/*
		| UPDATE STATUS DEBET&CREDIT TITIPAN BAGIHASIL MENJADI 1
		*/
		// $this->db->trans_begin();
		// $this->db->query("update mfi_titipan_bagihasil set status=1 where status=0 and trx_date between ? and ?",array($from_date,$thru_date));
		// if($this->db->trans_status()===true){
		// 	$this->db->trans_commit();
		// }else{
		// 	$this->db->trans_rollback();
		// }
		
		/*
		| BEGIN JURNAL BAGIHASIL
		*/
		$trx_gl_id = uuid(false);

		/*query gl titipan bagihasil*/
		$gl_lcd = $this->model_core->get_gl_list_code_detail('gl_titipan_bagihasil');
		/*query gl tabungan*/
		$sql="select * from mfi_product_cm_gl limit 1";
		$query=$this->db->query($sql);
		$gl_cm = $query->row_array();

		$gl_titipan_bagihasil = $gl_lcd['code_value'];
		$gl_tab_sukarela = $gl_cm['gl_tab_sukarela'];

		/*
		| BEGIN COLLECT TRX GL BAGIHASIL
		*/
		$account = array(
			 'trx_gl_id' => $trx_gl_id ,'trx_date' => $thru_date
			,'voucher_no' => NULL ,'voucher_date' => $thru_date ,'voucher_ref' => NULL
			,'branch_code' => $this->session->userdata('branch_code') ,'jurnal_trx_type' => 0
			,'jurnal_trx_id' => NULL ,'created_by' => $this->session->userdata('user_id')
			,'created_date' => date('Y-m-d H:i:s') ,'description' => 'PROSES BONUS' ,'flag_status' => 0
  		);

			$accounts[] = array(
				'trx_gl_detail_id' => uuid(false) ,'trx_gl_id' => $trx_gl_id ,'account_code' => $gl_titipan_bagihasil
				,'flag_debit_credit' => 'D' ,'amount' => $amounts
				,'description' => 'PROSES BONUS (TITIPAN BAGIHASIL)' ,'trx_sequence' => 0
	  		);
			$accounts[] = array(
				'trx_gl_detail_id' => uuid(false) ,'trx_gl_id' => $trx_gl_id ,'account_code' => $gl_tab_sukarela
				,'flag_debit_credit' => 'C' ,'amount' => $amounts
				,'description' => 'PROSES BONUS (TAB.SUKARELA)' ,'trx_sequence' => 0
			);
		/*
		| END COLLECT TRX GL BAGIHASIL
		*/
		
		$this->db->trans_begin();
		$this->db->insert('temp_mfi_trx_gl',$account);
		$this->db->insert_batch('temp_mfi_trx_gl_detail',$accounts);
		if($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		}else{
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		/*
		| END JURNAL BAGIHASIL
		*/

		echo json_encode($return);
	}

	public function proses_awal_tahun()
	{
		$data['title'] = 'Proses Awal Tahun';
		$data['container'] = 'sys/proses_awal_tahun';
		$data['from_date'] = $this->get_from_trx_date();
		$data['thru_date'] = $this->get_thru_trx_date();
		$data['branchs'] = $this->model_sys->get_branch_awaltahun(date('Y'));
		$this->load->view('core',$data);
	}

	public function do_proses_awal_tahun()
	{
		date_default_timezone_set('Asia/Jakarta');
		$date1=$this->datepicker_convert(true,$this->input->post('from_date'),'/');
		$date2=$this->datepicker_convert(true,$this->input->post('thru_date'),'/');
		$createdby=$this->session->userdata('user_id');
		$branch_code=$this->input->post('branch_code');
		
		/**
		* create history/statement transaksi
		* dari titipan bagihasil (C) ke titipan bagihasil (D) 
		*/
		$this->db->trans_begin();
		$sql = "select fn_proses_posting_titipan_bahas_to_sukarela_v2(?,?,?,?)";
		// $sql = "select fn_proses_posting_titipan_bahas_to_sukarela_v2(?,?,?)";
		$this->db->insert('mfi_proses_awaltahun_log',array('branch_code'=>$branch_code,'tahun'=>date('Y')));
		$this->db->query($sql,array($date1,$date2,$createdby,$branch_code));
		if ($this->db->trans_status()===true){
			$this->db->trans_commit();
			$trx = true;
		} else {
			$this->db->trans_rollback();
			$trx = false;
		}

		/**
		* create journal 
		* akun titipan (D) -> saldo sukarela (C)
		*/
		if ($trx==true) {
			$accnt = $this->model_sys->get_account_bahas_to_sukarela();
			$accnt_titipan = $accnt['titipan'];
			$accnt_sukarela = $accnt['sukarela'];

			$trx_gl_id = uuid(false);
			$trx_date = date('Y-m-d');
			$voucher_no = null;
			$voucher_date = date('Y-m-d');
			$voucher_ref = null;
			$jurnal_trx_type = 5;
			$jurnal_trx_id = null;
			$created_by = $this->session->userdata('user_id');
			$created_date = date('Y-m-d H:i:s');
			$description = 'POSTING BAHAS '.$date1.' SD '.$date2;
			$amount = $this->model_sys->get_amount_titipan_bagihasil($date1,$date2,$branch_code);

			$account = array(
				'trx_gl_id' => $trx_gl_id,
				'trx_date' => $trx_date,
				'voucher_no' => $voucher_no,
				'voucher_date' => $voucher_date,
				'voucher_ref' => $voucher_ref,
				'branch_code' => $branch_code,
				'jurnal_trx_type' => $jurnal_trx_type,
				'jurnal_trx_id' => $jurnal_trx_id,
				'created_by' => $created_by,
				'created_date' => $created_date,
				'description' => $description
			);
			$accounts[] = array(
					'trx_gl_id'=>$trx_gl_id,
					'account_code'=>$accnt_titipan,
					'flag_debit_credit'=>'D',
					'amount'=>$amount,
					'description'=>'TITIPAN BAHAS',
					'trx_sequence'=>1
				);
			$accounts[] = array(
					'trx_gl_id'=>$trx_gl_id,
					'account_code'=>$accnt_sukarela,
					'flag_debit_credit'=>'C',
					'amount'=>$amount,
					'description'=>'SUKARELA',
					'trx_sequence'=>2
				);

			$this->db->trans_begin();
			$this->db->insert('mfi_trx_gl',$account);
			$this->db->insert_batch('mfi_trx_gl_detail',$accounts);
			if ($this->db->trans_status()===true){
				$this->db->trans_commit();
				$journal = array('success'=>true);
			} else {
				$this->db->trans_rollback();
				$journal = array('success'=>false);
			}

			echo json_encode($journal);

		} else {
			echo json_encode(array('success'=>false));
		}
		

	}

	public function getYearsHariLibur()
	{
		$data = $this->model_sys->getYearHariLibur();
		echo json_encode($data);
	}

	public function setup_hari_libur()
	{
		$data['container'] = 'sys/setup_hari_libur';
		$data['years'] = $this->model_sys->getYearHariLibur();
		$this->load->view('core',$data);
	}
	function add_setup_hari_libur()
	{
		$tanggal = $this->datepicker_convert(true,$this->input->post('tanggal'),'/');
		$description = $this->input->post('description');

		$data = array(
				'tanggal'=>$tanggal,
				'description'=>$description
			);
		$this->db->trans_begin();
		$this->db->insert('mfi_hari_libur',$data);
		if ($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}
	function get_setup_hari_libur_by_id()
	{
		$id = $this->input->post('id');
		$data = $this->model_sys->get_setup_hari_libur_by_id($id);
		echo json_encode($data);
	}
	function edit_setup_hari_libur()
	{
		$id = $this->input->post('id');
		$tanggal = $this->datepicker_convert(true,$this->input->post('tanggal'),'/');
		$description = $this->input->post('description');

		$data = array(
				'tanggal'=>$tanggal,
				'description'=>$description
			);
		$param = array('id'=>$id);
		$this->db->trans_begin();
		$this->db->update('mfi_hari_libur',$data,$param);
		if ($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}

		echo json_encode($return);
	}

	function delete_hari_libur()
	{
		$id = $this->input->post('id');
		$param = array('id'=>$id);
		$this->db->trans_begin();
		$this->db->delete('mfi_hari_libur',$param);
		if ($this->db->trans_status()===true){
			$this->db->trans_commit();
			$return = array('success'=>true);
		} else {
			$this->db->trans_rollback();
			$return = array('success'=>false);
		}
		echo json_encode($return);
	}

	public function jqgrid_setup_hari_libur()
	{
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;
		$limit_rows = isset($_REQUEST['rows'])?$_REQUEST['rows']:15;
		$sidx = isset($_REQUEST['sidx'])?$_REQUEST['sidx']:'account_financing_no';//1
		$sort = isset($_REQUEST['sord'])?$_REQUEST['sord']:'DESC';
		$year = isset($_REQUEST['year'])?$_REQUEST['year']:'';
		
		$totalrows = isset($_REQUEST['totalrows']) ? $_REQUEST['totalrows'] : false;
		if ($totalrows) { $limit_rows = $totalrows; }

		$result = $this->model_sys->jqgrid_setup_hari_libur('','','','',$year);

		$count = count($result);
		if ($count > 0) { $total_pages = ceil($count / $limit_rows); } else { $total_pages = 0; }

		if ($page > $total_pages)
		$page = $total_pages;
		$start = $limit_rows * $page - $limit_rows;
		if ($start < 0) $start = 0;

		$result = $this->model_sys->jqgrid_setup_hari_libur($sidx,$sort,$limit_rows,$start,$year);
		
		$responce['page'] = $page;
		$responce['total'] = $total_pages;
		$responce['records'] = $count;

		$i = 0;
		foreach ($result as $row)
		{
			$responce['rows'][$i]['id']=$row['id'];
		    $responce['rows'][$i]['cell']=array(
			     $row['id']
				,$row['tanggal']
				,$row['description']
			);
		    $i++;
		}

		echo json_encode($responce);
	}

	function shu(){
		$data['title'] = 'Import Sisa Hasil Usaha';
		$data['container'] = 'sys/shu';
		$this->load->view('core',$data);
	}

	function FormatDateExcel($date){
		return date('Y-m-d',strtotime($date));
	}

	function proses_shu(){
		ini_set('memory_limit',-1);
		$date = date('Y-m-d H:i:s');
		$name = $_FILES['userfile']['name'];
		$type = $_FILES['userfile']['type'];
		$tmp_name = $_FILES['userfile']['tmp_name'];
		$error = $_FILES['userfile']['error'];
		$size = $_FILES['userfile']['size'];
		$trx_date = $this->datepicker_convert(true,$this->input->post('trx_date'),'/');
		$status_zero = 0;
		$total_amount = 0;

		if (isset($_FILES['userfile'])) {

			switch ($type) {
				case 'application/msexcel':
				case 'application/vnd.ms-excel':
				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

				if ($size>100000000000) {

					$return = array('success'=>false,'error'=>'file size must be less than 100Mb');

				} else {

					try {
						$objPHPExcel = PHPExcel_IOFactory::load($tmp_name);
						$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
						$file_exists = true;
					} catch (Exception $e) {
						$file_exists = false;
					}

					if ($file_exists) {

						$getHighestColumn = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();

							$row = array();
							$i=0;
							$this->db->trans_begin();
							foreach ($sheetData as $data) {

								if ($i>0) {
									$cif_no = $data['A'];

									$check_status = $this->model_sys->check_status_cif_no($cif_no)->row_array();

									$status_cif = $check_status['status'];

									if($status_cif == 1){
										$insert = array(
											'cif_no' => $cif_no,
											'trx_date' => $trx_date,
											'amount' => $data['B'],
											'created_by'=>$this->session->userdata('user_id'),
											'created_stamp'=>date('Y-m-d H:i:s'),
											'name'=>$name
										);

										$this->model_sys->insert_shu_sukarela($insert);
										$this->model_sys->update_default_account_balance($data['B'],$cif_no);
									} else {
										$insert_rejected = array(
											'trx_date' => $trx_date,
											'cif_no' => $cif_no,
											'amount' => $data['B'],
											'name' => $name
										);
										$this->model_sys->insert_shu_sukarela_rejected($insert_rejected);
									}
								}

								$i++;

							}

							if($this->db->trans_status() === TRUE){
								$this->db->trans_commit();
								$return = array('success'=>true);
							} else {
								$this->db->trans_rollback();
								$return = array(
									'success' => FALSE,
									'error' => 'Gagal! Tidak ada koneksi'
								);
							}

							// print_r($row);
							// die();
					} else {
						$return = array('success'=>false,'error'=>'File does not exist. maybe permission to the path of file is denied');
					}
				}

				break;
				
				default:
				$return = array(
					'success'=> FALSE,
					'error'=>'wrong file type. file type should use the extension .xls and .xlsx only');
				break;
			}

		} else {

			$return = array('success'=>false,'error'=>'no selected file.');

		}
		echo json_encode($return);
	}

	// function kill_connection()
	// {
	// 	$sql = "SELECT * FROM pg_stat_activity;";
	// 	$query = $this->db->query($sql);
	// 	$results = $query->result_array();
	// 	foreach($results as $result):
	// 		$procpid = $result['procpid'];
	// 		$sql1 = "SELECT pg_cancel_backend($procpid);SELECT pg_terminate_backend($procpid);";
	// 		$query1 = $this->db->query($sql1);
	// 	endforeach;
	// }

	public function download_file_backup(){
		$data['title'] = 'Download File Backup';
		$data['container'] = 'sys/download_file_backup';
		$data['from_date'] = $this->get_from_trx_date();
		$this->load->view('core',$data);
	}

	public function show_list_backup(){
		$fromdate = $this->datepicker_convert(TRUE,$this->input->post('from'),'/');
		$thrudate = $this->datepicker_convert(TRUE,$this->input->post('thru'),'/');

		$showfiles = array();
		$files = scandir('/home/baik/backup/');
		$ext = '.sql.zip';

		for($i = 0 ; $i < count($files); $i++){
			$renamefile = substr($files[$i],8);
			$arrofDate = createDateRangeArray($fromdate,$thrudate);

			for($j = 0; $j < count($arrofDate); $j++){
				$exp = explode('-',$arrofDate[$j]);
				$nameofDate = $exp[2].'-'.$exp[1].'-'.$exp[0].$ext;

				if ($nameofDate==$renamefile) {
					array_push($showfiles, $files[$i]);
				}
			}
		}

		$result = array('hasil' => $showfiles);

		echo json_encode($result);
	}

	function proses_download_backup(){
		$file = $this->uri->segment(3);
		$filename = '/home/baik/backup/' . $file;

		if(file_exists($filename)){
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename($filename));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($filename));
		    readfile( $filename );
		    exit;
		} else {
			$this->session->set_flashdata('notification','<div class="alert alert-danger"><strong>Maaf!</strong> File tidak ditemukan</div>');
			redirect(site_url('sys/download_file_backup'));
		}
	}

	function backup(){
		$data['title'] = 'Backup Database';
		$data['container'] = 'sys/backup_database';
		$this->load->view('core',$data);
	}

	function test_cli(){
		if(!$this->input->is_cli_request()){
			echo 'This script can only be accessed via the command line' . PHP_EOL;
		} else {
			//
		}
	}

	function proses_backup(){
		$cmd = 'sudo /bin/sh /root/scripts/backup-baik-web.sh';
		$output = shell_exec($cmd);
		
		//echo $output; exit();

		if($output){
			$this->session->set_flashdata('notification','<div class="alert alert-success alert-dismissable"><h4><i class="icon fa fa-check"></i> Sukses!</h4> Data berhasil di-backup</div>');
		} else {
            $this->session->set_flashdata('notification','<div class="alert alert-danger alert-dismissable"><h4><i class="icon fa fa-times"></i> Gagal!</h4> Data gagal di-backup</div>');
		}

		redirect(site_url('sys/backup'));
	}
}