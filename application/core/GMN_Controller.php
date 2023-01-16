<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GMN_Controller extends CI_Controller {

	public $_setoran_pokok;
	public $_setoran_wajib;

	public function __construct($securePage=false)
	{
		parent::__construct();
		
		ini_set('memory_limit','1024M');
		date_default_timezone_set('Asia/Jakarta');

		if($securePage==true)
		{
			if($this->session->userdata('is_logged_in')==false)
			{
				redirect('login');
			}
		}
		else
		{
			if($this->session->userdata('is_logged_in')==true)
			{
				redirect('dashboard');
			}	
		}

		$url 				= $this->uri->segment(1); // get url by segment 1

		if($url==false)
		{
			redirect('login');
		}

		$url = strtoupper($this->uri->segment(1).$this->uri->segment(2));
		if ($url!="") {
			$menu_is_exists = $this->model_core->cek_menu_is_exists($url);
			if ($menu_is_exists==true) {
				$menu_id = $this->model_core->get_menu_id_by_url($url);
				$url_is_allowed = $this->model_core->cek_url_is_allowed($menu_id,$this->session->userdata('role_id'));
				if ($menu_id!='4') { // if not dashboard
					if ($url_is_allowed==false) {
						show_404();
					}
				}
			}
		}
		
		$url 				= $this->uri->segment(1); // get url by segment 1

		$role_id 			= $this->session->userdata('role_id');
		$title 				= $this->model_core->get_menu_title($url); // get title by url
		$kontrol_periode    = $this->model_core->get_trx_kontrol_periode_active();
		$data['title'] 		= $title;
		$data['allnotif']   = $this->model_core->get_notification();
		$data['notif']		= $this->model_core->get_notification(1);
		$data['day_periode_awal'] = date('d',strtotime($kontrol_periode['periode_awal']));
		$data['month_periode_awal'] = date('m',strtotime($kontrol_periode['periode_awal']));
		$data['year_periode_awal'] = date('Y',strtotime($kontrol_periode['periode_awal']));
		$data['day_periode_akhir'] = date('d',strtotime($kontrol_periode['periode_akhir']));
		$data['month_periode_akhir'] = date('m',strtotime($kontrol_periode['periode_akhir']));
		$data['year_periode_akhir'] = date('Y',strtotime($kontrol_periode['periode_akhir']));
		$data['periode_awal'] = $this->format_date_detail($kontrol_periode['periode_awal'],'id',true,' ');
		$data['periode_akhir'] = $this->format_date_detail($kontrol_periode['periode_akhir'],'id',true,' ');
		$data['biaya_notaris'] = $this->session->userdata('titipan_notaris');
		$data['kontrol_periode'] = $kontrol_periode;
		$data['periode_id'] = $kontrol_periode['periode_id'];
		$this->load->vars($data);
		$this->generate_menu($role_id,$url);

		$list_setpok = $this->model_core->get_row_list_code_detail('amount_setoran_pokok');
		$list_setwjb = $this->model_core->get_row_list_code_detail('amount_setoran_wajib');
		$this->_setoran_pokok = $list_setpok['code_value'];
		$this->_setoran_wajib = $list_setwjb['code_value'];

		echo $this->menu_access();
	}

	function get_weeks($date)
	{
		$date_to_firstweek = date('Y-m',strtotime($date)).'-01';
		$firstweek = date('W',strtotime($date_to_firstweek));
		$totalweek = date('W',strtotime($date));
		return $totalweek-$firstweek+1;
	}

	public function get_numeric($numeric) {
		if ( $numeric=="" ) {
			return '0';
		} else {
			return $numeric;
		}
	}
	public function get($var) {
		if ( $var=="" ) {
			return NULL;
		} else {
			return $var;
		}
	}

	public function get_from_trx_date(){
		$kontrol_periode = $this->model_core->get_trx_kontrol_periode_active();
		return $kontrol_periode['periode_awal'];
	}

	public function get_thru_trx_date(){
		$kontrol_periode = $this->model_core->get_trx_kontrol_periode_active();
		return $kontrol_periode['periode_akhir'];
	}

	public function current_date()
	{
		return $this->model_core->get_current_date();
	}

	public function get_menu_id($menu_url)
	{
		$menu_id = $this->model_core->get_menu_id($menu_url);
		return $menu_id;
	}

	public function datepicker_convert($has_separator=false,$datepicker,$separator='/')
	{
		if(trim($datepicker)==''){
			return '';
		}
		if($has_separator==true){
			$datepicker = str_replace($separator, '', $datepicker);
		}
        $date = substr($datepicker,4,4).'-'.substr($datepicker,2,2).'-'.substr($datepicker,0,2);

        return $date;
	}

	public function generate_menu($role_id,$url)
	{
		$html = '';
		
		$menu = $this->model_core->get_menu($role_id,0);

		for ( $i = 0 ; $i < count($menu) ; $i++ )
		{

			/* BEGIN MENU */
			if($menu[$i]['menu_url']==$url)
			{
				$li_active = 'start active';
				$span_selected = 'selected';
			}
			else
			{
				$li_active = '';
				if($menu[$i]['menu_url']=="dashboard" || $menu[$i]['menu_flag_link']==1)
					$span_selected = '';
				else
					$span_selected = 'arrow';
			}

			if($menu[$i]['menu_flag_link']==0)
				$link_menu = 'javascript:;';
			else
				$link_menu = site_url($menu[$i]['menu_url']);

			$html .= '
			<li class="'.$li_active.'">
               <a href="'.$link_menu.'">
                  <i class="icon-'.$menu[$i]['menu_icon_parent'].'"></i>
                  <span class="title">'.$menu[$i]['menu_title'].'</span>
                  <span class="'.$span_selected.'"></span>
               </a>
			';
            
            /* BEGIN SUB MENU */
			$submenu = $this->model_core->get_menu($role_id,$menu[$i]['menu_id']);
			if ( count($submenu) > 0 )
            	$html .= '<ul class="sub-menu">';

			for ( $j = 0 ; $j < count($submenu) ; $j++ )
			{

				$submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
				if($submenu[$j]['menu_url']==$submenu_url)
					$lisub_active = ' class="active"';
				else
					$lisub_active = '';

				$sub_submenu = $this->model_core->get_menu($role_id,$submenu[$j]['menu_id']);
            	for ( $jtk = 0 ; $jtk < count($sub_submenu) ; $jtk++ )
            	{
					$sub_submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
					if($sub_submenu[$jtk]['menu_url']==$sub_submenu_url){
						$lisub_active = ' class="active"';
						break;
					}
					else{
						$lisub_active = '';
					}
				}

				if($submenu[$j]['menu_flag_link']==0)
					$span_selected2 = 'arrow';
				else
					$span_selected2 = '';

				$html .= '
				  <li'.$lisub_active.'>
                     <a href="'.site_url($submenu[$j]['menu_url']).'">
				        <i class="icon-'.$submenu[$j]['menu_icon_parent'].'"></i>
                     	<span class="title">'.$submenu[$j]['menu_title'].'</span>
				        <span class="'.$span_selected2.'"></span>
                     </a>
				';

				if ( count($sub_submenu) > 0 )
            		$html .= '<ul class="sub-menu">';

            	for ( $k = 0 ; $k < count($sub_submenu) ; $k++ )
				{
					$sub_submenu_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
					if($sub_submenu[$k]['menu_url']==$sub_submenu_url)
						$lisub_sub_active = ' class="active"';
					else
						$lisub_sub_active = '';

					if($sub_submenu[$k]['menu_flag_link']==0)
						$span_selected3 = 'arrow';
					else
						$span_selected3 = '';

					$html .= '
					  <li'.$lisub_sub_active.'>
						 <a href="'.site_url($sub_submenu[$k]['menu_url']).'">
					        <i class="icon-'.$sub_submenu[$k]['menu_icon_parent'].'"></i>
	                     	<span class="title">'.$sub_submenu[$k]['menu_title'].'</span>
	                     </a>
	                  </li>
					';
				}

				if ( count($sub_submenu) > 0 )
	            	$html .= '</ul>';

				$html .= '
                  </li>
                ';

			}

			if ( count($submenu) > 0 )
            	$html .= '</ul>';
            /* END SUB MENU */

			$html .= '</li>';
			/* END MENU */
		}

		$data['menu'] = $html;

		$this->load->vars($data);
	}

	/**
	 * fungsi untuk mengambil root menu
	 * @param role_id
	 */
	public function load_menu($role_id)
	{
		$menu = $this->model_core->get_menu($role_id,0);
		$this->load->vars('menu',$menu);
	}

	/**
	 * fungsi untuk mengambil sub menu
	 * @param role_id, menu_parent
	 */
	public function load_sub_menu($role_id,$menu_parent)
	{
		$submenu = $this->model_core->get_menu($role_id,$menu_parent);
		$this->load->vars('submenu',$submenu);
	}

	/**
	 fungsi untuk hak akses menu jika branch status = 2
	*/
	 public function menu_access()
	 {
	 	$branch_code = $this->session->userdata('branch_code');
	 	$url_active_one = $this->uri->segment(1);
	 	$url_active_two = $this->uri->segment(1)."/".$this->uri->segment(2);

	 	$branch_status = $this->model_core->get_branch_status($branch_code);

	 	for($i = 0; $i < count($branch_status); $i++)
	 	{
	 		$status[$i] = $branch_status[$i]['branch_status'];

	 		if($status[$i] == '2')
	 		{
	 			$user_status = $this->model_core->get_user_status($branch_code, $url_active_one, $url_active_two);

			 	for($n = 1; $n <= count($user_status); $n++)
			 	{
			 		if(isset($user_status[$n]['menu_tipe']) == '1')
			 		{
			 			return "<script>alert('Status cabang Regis Closing, transaksi tidak dapat dilakukan !'); window.location='".base_url('dashboard')."';</script>";
			 		}


			 	}
	 		}
	 	}
	 }

	public function get_age_by_ajax()
	{
		$date = $this->input->post('date');

		$age = $this->get_usia($date,date('Y-m-d'));
		// cek min age
		$valid=true;
		if($age<10){
			$valid=false;
		}

		echo json_encode(array('age'=>$age,'valid'=>$valid));
	}

	// untuk menghitung interval/hari dari suatu bulan ke bulan tujuan
	public function get_usia( $birthdate , $now)
	{
	 	$date1exp = explode('-',$birthdate);
		$date1year = $date1exp[0];
		$date1month = $date1exp[1];
		$date1date = $date1exp[2];
		
	 	$date2exp = explode('-',$now);
		$date2year = $date2exp[0];
		$date2month = $date2exp[1];
		$date2date = $date2exp[2];
		if($date2month<$date1month){
			$date2year = $date2year - 1;
		}
		
		$year = $date2year-$date1year;
		
		$date3 = $date2year.'-'.$date1month.'-'.$date1date;
		
		$date3 = strtotime($date3); // tanggal ulang tahun sekarang
		$date2 = strtotime($now); // tanggal sekarang
		
		$count = $this->count_days($date3,$date2);
		// echo $count;
		if($count>0)
		{
			$age = $year;
		}
		else
		{
			$age = $year-1;
		}
		
		return $age;
	}
	// untuk menghitung interval/hari dari suatu bulan ke bulan tujuan
	public function count_days( $a, $b )
	{
	    $gd_a = getdate( $a );
	    $gd_b = getdate( $b );
	 
	    $a_new = mktime( 12, 0, 0, $gd_a['mon'], $gd_a['mday'], $gd_a['year'] );
	    $b_new = mktime( 12, 0, 0, $gd_b['mon'], $gd_b['mday'], $gd_b['year'] );

	    // echo "a_new:".$a_new.",b_new:".$b_new."count:".round( ( $b_new - $a_new ) / 86400 );

	    return round( ( $b_new - $a_new ) / 86400 );
	}

	// pada parameter $tanggal. format datenya harus yyyy-mm-dd
	public function format_date_detail($tanggal,$lang='id',$description=false,$separator='/')
	{
		
		if($tanggal!="0000-00-00" || $tanggal!="" || $tanggal!=NULL)
		{
			$exp = explode('-',$tanggal);
			$year = $exp[0];
			$month = $exp[1];
			$date = $exp[2];
	
			if($description==true)
			{
				$month = $this->get_month_description($month,$lang);
			}
	
			if($lang=='id' || $lang=='en' || $lang=='iden')
			{
				if($lang=="id")
				{
					$return = $date.$separator.$month.$separator.$year;
				}
				else if($lang=="en")
				{
					$return = $year.$separator.$month.$separator.$date;
				}
				else if($lang=="iden")
				{
					$return = ((int)$date).$separator.$month.$separator.$year;
				}
			}
			else
			{
				die("Bahasa pada bulan tidak ditemukan. lang:$lang <strong>function:format_date_detail()</strong>");
			}
		}
		else
		{
			$return = '';
		}
		return $return;
	}

	// get description of month number
	public function get_month_description($month,$lang='id')
	{
		$month = (int) $month;

		if($lang!='id' || $lang!='en' || $lang!='iden')
		{
			if($lang=="en")
			{
				$month_name = array('','January','February','March','April','May','June','July','August','September','October','November','December');
			}
			else if($lang=="id")
			{
				$month_name = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			}
			else if($lang=="iden")
			{
				$month_name = array('','January','February','March','April','May','June','July','August','September','October','November','December');
			}
		}
		else
		{
			die("Bahasa pada bulan tidak ditemukan. lang:$lang <strong>function:get_month_description()</strong>");
		}

		return $month_name[$month];

	}

	public function convert_numeric($value)
	{
		$value = str_replace('.', '', $value);
		$result = str_replace(',', '.', $value);

		return $result;
	}
	
	
	public function convert_date($date='',$month_length='long',$lang='en_to_id')
	{
		if ( $date == '' )
			$date = date('Y-m-d');
	
		$e = explode ( '-' , $date );
	
		if ( $lang == 'en_to_id' )
		{
			if ( $month_length == 'short' )
			{
				$month = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nop','Des');
			}
			else
			{
				$month = array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
			}
	
			return $e[2] . '-' . $month [ (int) $e[1] ] . '-' . $e[0];
		}
	
		else if ( $lang == 'id_to_en' )
		{
			if ( $month_length == 'short' )
			{
				$month = array('','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			}
			else
			{
				$month = array('','January','February','March','April','Mei','June','July','August','September','October','November','December');
			}
	
			return $e[0] . '-' . $month [ (int) $e[1] ] . '-' . $e[2];
		}
	
		else 
		{
			return $date;
		}
	}

}

/* End of file GMN_Controller.php */
/* Location: ./application/core/GMN_Controller.php */