<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends GMN_Controller {

	public function __construct()
	{
		parent::__construct(true);
		$this->load->library('phpexcel');
		$this->load->model('model_laporan');
	}


	function lembar_absensi_anggota()
	{
		// $branch_code = '00000';
		$branch_code = $this->uri->segment(3);
		// $fa_code = '80020002';
		$fa_code = $this->uri->segment(4);
		// $cm_code = 'all';
		$cm_code = $this->uri->segment(5);
		// $tahun = '2015';
		// $tahun = $this->uri->segment(6);
		$tahun = date('Y');

		$data_cif = $this->model_laporan->get_data_lembar_absensi_anggota($branch_code,$fa_code,$cm_code);

		$branch = $this->model_laporan->get_branch_by_code($branch_code);
		$branch_name = $branch['branch_name'];

		$fa_name = 'ALL';
		if ($fa_code!="all") {
			$fa = $this->model_laporan->get_fa_by_code($fa_code);
			$fa_name = $fa['fa_name'];
		}
		$cm_name = 'ALL';
		if ($cm_code!="all") {
			$cm = $this->model_laporan->get_cm_by_code($cm_code);
			$cm_name = $cm['cm_name'];
		}

		// Create new PHPExcel object
		$objPHPExcel = $this->phpexcel;
		// Set document properties
		$objPHPExcel->getProperties()->setCreator("MICROFINANCE")
									 ->setLastModifiedBy("MICROFINANCE")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("REPORT, generated using PHP classes.")
									 ->setKeywords("REPORT")
									 ->setCategory("Test result file");

		$objPHPExcel->setActiveSheetIndex(0); 

		$sheet = $objPHPExcel->getActiveSheet();

		$sheet->setCellValue('A1','Lembar Absensi Anggota');
		$sheet->setCellValue('A2','Cabang');
		$sheet->setCellValue('B2',': '.$branch_name);
		$sheet->setCellValue('A3','Petugas');
		$sheet->setCellValue('B3',': '.$fa_name);
		$sheet->setCellValue('A4','Majlis');
		$sheet->setCellValue('B4',': '.$cm_name);

		$koloms = createColumnsArray('BL');
		// echo "<pre>";
		// print_r($koloms);
		$months = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember');
		$nmonths = array('01','02','03','04','05','06','07','08','09','10','11','12');
		$sheet->setCellValue('A6','No');
		$sheet->setCellValue('B6','ID Anggota');
		$sheet->setCellValue('C6','Majlis');
		$sheet->setCellValue('D6','Nama');
		$sheet->mergeCells('A6:A7');
		$sheet->mergeCells('B6:B7');
		$sheet->mergeCells('C6:C7');
		$sheet->mergeCells('D6:D7');
		$sheet->getColumnDimension('A')->setWidth(9);
		$sheet->getColumnDimension('B')->setWidth(15.5);
		$sheet->getColumnDimension('C')->setWidth(18.5);
		$sheet->getColumnDimension('D')->setWidth(22);
		$sheet->getStyle('A6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('A6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('C6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('C6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		$sheet->getStyle('D6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('D6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		
		$j=0;
		for ( $i = 4 ; $i < 63 ; $i++ ) {

			$mod=$i%5;
			if ($mod==0) {
				$ncols = $i-1;
				$ncols2 = $i+3;
				$sheet->setCellValue($koloms[$ncols].'6',$months[$j]);
				$sheet->getStyle($koloms[$ncols].'6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				$sheet->mergeCells($koloms[$ncols].'6:'.$koloms[$ncols2].'6');
				$n=0;
				for ($k=1;$k<=5;$k++) {
					$sheet->setCellValue($koloms[$ncols+$n].'7',$k);
					$sheet->getColumnDimension($koloms[$ncols+$n])->setWidth(3);
					$sheet->getStyle($koloms[$ncols+$n].'7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$n++;
				}
				$j++;
			}
			
		}

		$x = 8;
		$no = 1;
		foreach ($data_cif as $cif) {

			$sheet->setCellValue('A'.$x,$no);
			$sheet->setCellValue('B'.$x,$cif['cif_no'].' ');
			$sheet->setCellValue('C'.$x,$cif['cm_name']);
			$sheet->setCellValue('D'.$x,$cif['nama']);
			$sheet->getStyle('A'.$x)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			$aa = 0;
			for ( $y = 4 ; $y < 63 ; $y++ ) {

			}

			$x++;
			$no++;

		}


		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="LEMBAR ABSENSI ANGGOTA.xlsx"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
	}

}