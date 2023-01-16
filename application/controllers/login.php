<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends GMN_Controller {

	/**
	 * Halaman Pertama ketika site dibuka
	 * lokasi : application/controllers/login.php
	 */

	private $_salt = 'microfinance';

	public function __construct()
	{
		parent::__construct(false);
	}

	public function index()
	{
		$this->load->view('login2');
	}

	public function authentication()
	{	
		$this->load->model('model_login');
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$cek = $this->model_login->authentication($username,$password,$this->_salt);

		if($cek==true)
		{
			$get_access = $this->model_login->get_access($username);

			$get_day_in = $get_access['day_access'];

			$get_day1 = substr($get_day_in, 0,1);
			$get_day2 = substr($get_day_in, 1,1);
			$get_day3 = substr($get_day_in, 2,1);
			$get_day4 = substr($get_day_in, 3,1);
			$get_day5 = substr($get_day_in, 4,1);
			$get_day6 = substr($get_day_in, 5,1);
			$get_day7 = substr($get_day_in, 6,1);

			$get_time_start = $get_access['time_access_start'];
			$get_time_end = $get_access['time_access_end'];

			$day = date("N");
			$day_now = date("l");

			$time = date("H:i:s");


				if($day == $get_day1 or $day == $get_day2 or $day == $get_day3 or $day == $get_day4 or $day == $get_day5 or $day == $get_day6 or $day == $get_day7)
				{	
					if($get_time_start <= $time and $time <= $get_time_end)
					{
						$cek['is_logged_in'] = true;
						$this->session->set_userdata($cek);
						redirect('dashboard');
					}else
					{						
						$this->session->set_flashdata('login_message','Anda tidak dapat login pada jam '.$time);
						redirect('login');
					}

				}else
				{
					$this->session->set_flashdata('login_message','Anda tidak dapat login pada hari '.$day_now);
					redirect('login');
				}

			
		}
		else
		{
			$this->session->set_flashdata('login_message','Incorrect Username or Password !');
			redirect('login');
		}
	}

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */