<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_to_pdf extends GMN_Controller
{

    public function __construct()
    {
        parent::__construct(true, 'main', 'back');
        $this->load->library('html2pdf');
        $this->load->model('model_laporan_to_pdf');
        $this->load->model('model_cif');
        $this->load->model('model_laporan');
        $this->load->model('model_transaction');
        $CI = &get_instance();
    }

    /****************************************************************************/
    //BEGIN LAPORAN SALDO KAS PETUGAS
    /****************************************************************************/
    public function export_saldo_kas_petugas()
    {
        $cabang     = $this->uri->segment(4);
        $tanggal    = $this->uri->segment(3);
        $tanggal2 = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);

        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['saldo_kas_petugas'] = $this->model_laporan_to_pdf->export_saldo_kas_petugas($cabang, $tanggal2);
            $data['tanggal'] = $tanggal2;


            if ($cabang != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $this->load->view('laporan/export_pdf_saldo_kas_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_saldo_kas_petugas_"' . $tanggal2 . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN SALDO KAS PETUGAS
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN TRANSAKSI KAS PETUGAS
    /****************************************************************************/
    public function export_transaksi_kas_petugas()
    {

        $account_cash_name  = $this->uri->segment(3);
        $pemegeng_kas       = $this->uri->segment(4);
        $tanggal            = $this->uri->segment(5);
        $tanggal = substr($tanggal, 4, 4) . '-' . substr($tanggal, 2, 2) . '-' . substr($tanggal, 0, 2);
        $tanggal2           = $this->uri->segment(6);
        $tanggal2 = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $account_cash_code  = $this->uri->segment(7);


        if ($account_cash_name == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['saldo_awal'] = $this->model_laporan->get_saldo_awal_kas_petugas($account_cash_code, $tanggal);
            $data['transaksi_kas_petugas']  = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal, $tanggal2, $account_cash_code);
            $data['account_cash_name']  = $account_cash_name;
            $data['pemegeng_kas']       = $pemegeng_kas;
            $data['tanggal']            = $tanggal;
            $data['tanggal2']           = $tanggal2;

            $this->load->view('laporan/export_pdf_transaksi_kas_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_pdf_transaksi_kas_petugas_"' . $tanggal2 . '-' . $tanggal2 . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN TRANSAKSI KAS PETUGAS
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN LAPORAN LABA RUGI
    /****************************************************************************/
    public function export_lap_lr()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        // $from_date = date('Y-m-d',strtotime($from_date.' -1 day'));
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($cabang == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang != '00000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if ($branch['branch_class'] == "1") {
                    $data['cabang'] .= " ";
                }
            } else {
                $data['cabang'] = "PUSAT ";
            }
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi($cabang, $from_date, $last_date);

            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/export_pdf_laporan_lr', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Laba Rugi"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    // BEGIN KEUANGAN LABARUGI BULANAN
    function export_keuangan_labarugi_bulanan()
    {
        $cabang = $this->uri->segment(3);
        $periode  = $this->uri->segment(4);
        $report_code = $this->uri->segment(5);

        $tanggal = substr($periode, 0, 2);
        $bulan = substr($periode, 2, 2);
        $tahun = substr($periode, -4);

        $last_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $data['report_item'] = $this->model_laporan_to_pdf->export_keuangan_labarugi_bulanan($cabang, $last_date, $report_code, $bulan);

        if ($report_code == '20') {
            $jenis = 'Laba Rugi';
            $judul = 'LAPORAN LABA RUGI';
        } else {
            $jenis = 'Laba Rugi Rinci';
            $judul = 'LAPORAN LABA RUGI RINCI';
        }

        $data['last_date'] = $last_date;
        $data['judul'] = $judul;
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_labarugi_bulanan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Laporan Keuangan Trial Balance
    function export_keuangan_trial_balance()
    {
        $cabang = $this->uri->segment(3);
        $periode  = $this->uri->segment(4);
        $report_code = $this->uri->segment(5);

        $tanggal = substr($periode, 0, 2);
        $bulan = substr($periode, 2, 2);
        $tahun = substr($periode, -4);

        $from_date = $tahun . '-' . $bulan . '-' . $tanggal;
        $last_date = date('Y-m-d', strtotime($from_date . '+ 1 MONTH - 1 DAY'));

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $datas = $this->model_laporan_to_pdf->export_keuangan_trial_balance($cabang, $from_date, $last_date);

        if ($report_code == '30') {
            $jenis = 'Trial Balance';
            $judul = 'LAPORAN TRIAL BALANCE';
        } //else {
        // $jenis = 'Laba Rugi Rinci';
        //$judul = 'LAPORAN LABA RUGI RINCI';
        //}

        $data['last_date'] = $last_date;
        $data['judul'] = $judul;
        $data['result'] = $datas;
        $data['branch_officer_name'] = $branch['branch_officer_name'];

        $this->load->view('laporan/export_keuangan_trial_balance', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_lap_lr_v2()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        // $from_date = date('Y-m-d',strtotime($from_date.' -1 day'));
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($cabang == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang != '00000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                if ($branch['branch_class'] == "1") {
                    $data['cabang'] .= " ";
                }
            } else {
                $data['cabang'] = "PUSAT ";
            }
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi_v2($cabang, $from_date, $last_date);

            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/export_pdf_laporan_lr', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Laba Rugi"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LABA RUGI
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN EXPORT NERACA_GL
    /****************************************************************************/
    public function export_neraca_gl()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($branch_code == "") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_gl2($branch_code, $last_date);
            if ($branch_code != '00000') {
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                // if($branch['branch_class']=="1"){
                //     $data['branch_name'] .= " ";
                // }
            } else {
                $data['branch_name'] = "PUSAT";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/export_pdf_neraca_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_pdf_neraca_gl"' . $branch_code . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_neraca_gl_v2()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);
        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($branch_code == "") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_gl_v2($branch_code, $last_date);
            if ($branch_code != '00000') {
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                // if($branch['branch_class']=="1"){
                //     $data['branch_name'] .= " ";
                // }
            } else {
                $data['branch_name'] = "PUSAT";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/export_pdf_neraca_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_pdf_neraca_gl"' . $branch_code . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END EXPORT NERACA_GL
    /****************************************************************************/

    // BEGIN KEUANGAN NERACA BULANAN
    function export_keuangan_neraca_bulanan()
    {
        $branch_code  = $this->uri->segment(3);
        $periode  = $this->uri->segment(4);
        $report_code = $this->uri->segment(5);

        $tanggal = substr($periode, 0, 2);
        $bulan = substr($periode, 2, 2);
        $tahun = substr($periode, -4);

        $last_date = $tahun . '-' . $bulan . '-' . $tanggal;

        if ($report_code == '10') {
            $jenis = 'neraca';
            $judul = 'LAPORAN NERACA BULANAN';
        } else if ($report_code == '11') {
            $jenis = 'neraca_rinci';
            $judul = 'LAPORAN NERACA RINCI BULANAN';
        }

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $this->model_laporan_to_pdf->export_keuangan_neraca_bulanan($branch_code, $last_date, $report_code, $bulan);
        if ($branch_code != '00000') {
            $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
        } else {
            $data['branch_name'] = "PUSAT";
        }

        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $data['last_date'] = $last_date;
        $data['judul'] = $judul;
        $this->load->view('laporan/export_keuangan_neraca_bulanan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_keuangan_neraca_bulanan_' . $jenis . '_' . $branch_code . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //BEGIN LAPORAN LABA RUGI PUBLISH
    /****************************************************************************/
    public function export_lap_lr_publish()
    {
        $cabang     = $this->uri->segment(3);

        if ($cabang == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else {

            ob_start();

<<<<<<< HEAD
            $datas = '';

=======
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } else {
                $data['cabang'] = "Semua Data";
            }
            $data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_pdf_laporan_lr_publish', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Laba Rugi Publish"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LABA RUGI PUBLISH
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    function export_lap_droping_pembiayaan()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $peruntukan = $this->uri->segment(9);
        $sektor = $this->uri->segment(10);
        $produk = $this->uri->segment(11);
        $kreditur = $this->uri->segment(12);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }



        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_droping_pembiayaan($cabang, $majelis, $from, $thru, $pembiayaan, $petugas, $peruntukan, $sektor, $produk, $kreditur);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        // echo "<pre>";
        // print_r($datas);
        // die();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_lap_droping_pembiayaan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Pencairan Pembiayaan (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN CHANELLING DEBITUR
    /****************************************************************************/
    function export_list_chn_debitur()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $kreditur = $this->uri->segment(6);


        $datas = $this->model_laporan_to_pdf->export_lap_chn_debitur($cabang, $from, $thru, $kreditur);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        // echo "<pre>";
        // print_r($datas);
        // die();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;

        $this->load->view('laporan/export_lap_chn_debitur', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('List Calon Debitur ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN CHANELLING DEBITUR
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN LAPORAN PROYEKSI REALISASI ANGSURAN
    /****************************************************************************/
    function export_list_proyeksi_realisasi_angsuran()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);

        $datas = $this->model_laporan_to_pdf->export_list_proyeksi_realisasi_angsuran($from, $thru, $cabang, $produk, $majelis);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['produk'] = $this->model_laporan->get_produk_name($produk);

        $this->load->view('laporan/export_lap_proyeksi_realisasi_angsuran', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Proyeksi Realisasi Angsuran ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //BEGIN LAPORAN AGING
    /****************************************************************************/
    public function export_lap_aging()
    {
        $branch_code = $this->uri->segment(3);
        $date = $this->uri->segment(4);
<<<<<<< HEAD
        $kol = $this->uri->segment(5);
        $fa_code = $this->uri->segment(6);
        $kreditur = $this->uri->segment(7);
=======
        $desc_date = substr($date, 0, 2) . '/' . substr($date, 2, 2) . '/' . substr($date, 4, 4);
        $date = substr($date, 4, 4) . '-' . substr($date, 2, 2) . '-' . substr($date, 0, 2);
        $branch_data = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_code = $branch_data['branch_code'];
        if ($branch_id == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else {
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

        $kol = urldecode($kol);
        $desc_date = substr($date, 0, 2) . '/' . substr($date, 2, 2) . '/' . substr($date, 4, 4);
        $date = substr($date, 4, 4) . '-' . substr($date, 2, 2) . '-' . substr($date, 0, 2);

        if ($branch_code != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $cabang = $data['cabang'];
        $data['tanggal'] = $date;
        $tanggal = $data['tanggal'];

        if ($branch_code == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else {
            ob_start();

<<<<<<< HEAD
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['PAR'] = $this->model_laporan_to_pdf->get_laporan_par_terhitung($date, $branch_code, $kol, $fa_code, $kreditur);

            $this->load->view('laporan/export_pdf_list_kolektibilitas', $data);
=======

            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            //$data['lap_lr'] = $this->model_laporan_to_pdf->export_lap_lr($cabang);
            //$data['tanggal']= $tanggal;

            $data['result'] = $datas;
            if ($branch_id != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();
            $data['date'] = $desc_date;
            $data['branch_name'] = $branch_data['branch_name'];
            $data['par'] = $this->model_laporan_to_pdf->get_laporan_par($date);

            $this->load->view('anggota/export_lap_aging', $data);
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

            $content = ob_get_clean();

            try {
<<<<<<< HEAD
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_kolektibilitas_"' . $cabang . '".pdf');
=======
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('Laporan Aging.pdf');
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN AGING
    /****************************************************************************/


    // BEGIN LAPORAN LIST JATUH TEMPO
    function export_list_jatuh_tempo()
    {
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $from = $this->uri->segment(7);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(8);
        $thru = $this->datepicker_convert(true, $thru, '/');

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_list_jatuh_tempo($cabang, $pembiayaan, $petugas, $majelis, $from, $thru);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_list_jatuh_tempo', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Jatuh Tempo (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    // BEGIN LAPORAN LIST PELUNASAN PEMBIAYAAN
    function list_pelunasan_pembiayaan()
    {
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $from = $this->uri->segment(7);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(8);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $kreditur = $this->uri->segment(9);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->list_pelunasan_pembiayaan($cabang, $pembiayaan, $petugas, $majelis, $from, $thru, $kreditur);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_list_pelunasan_pembiayaan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Pelunasan Pembiayaan (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    // BEGIN LAPORAN OUTSTANDING
    function export_lap_list_outstanding_pembiayaan()
    {
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $peruntukan = $this->uri->segment(8);
        $sektor = $this->uri->segment(9);
        $tanggal = date('Y-m-d');
        $cif_type = $this->uri->segment(10);
        $kreditur = $this->uri->segment(11);


        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else if ($pembiayaan == 9) {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }


        if ($cif_type == 1) {
            $pembiayaan = 1;
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($cif_type == 0) {
            // $pembiayaan =0;
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }
        if ($cif_type == 1) {
            $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_ind($cabang, $cif_type, $pembiayaan, $petugas, $majelis, $produk, $peruntukan, $sektor, $tanggal, $kreditur);
        } else {

            $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan($cabang, $cif_type, $pembiayaan, $petugas, $majelis, $produk, $peruntukan, $sektor, $tanggal, $kreditur);
        }


        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $tanggal;
        $data['petugas'] = $fa;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        // if($cif_type == 1){
        //     $majelis =" ";
        // } else if($cif_type == 0 ){
        //     $majelis ='00000';

        // }

        if ($cif_type == 1) {
            $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_ind', $data);
        } else if ($cif_type == 0) {

            $this->load->view('laporan/export_lap_list_outstanding_pembiayaan', $data);
        }


        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Outstanding Pembiayaan (' . $jenis2 . ') ' . $tanggal . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    // BEGIN LAPORAN OUTSTANDING
    function export_lap_list_outstanding_pembiayaan_lalu()
    {
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
        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_pembiayaan_lalu($cabang, $pembiayaan, $petugas, $majelis, $produk, $peruntukan, $sektor, $tanggal, $kreditur);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $tanggal;
        $data['petugas'] = $fa;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $this->load->view('laporan/export_lap_list_outstanding_pembiayaan_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Outstanding Pembiayaan Bulan Lalu (' . $jenis2 . ') ' . $tanggal . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_lap_list_outstanding_tabungan_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tabungan = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $produk = $this->uri->segment(7);
        $hari = $this->uri->segment(8);
        $bulan = $this->uri->segment(9);
        $tahun = $this->uri->segment(10);
        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_outstanding_tabungan_lalu($cabang, $tabungan, $petugas, $majelis, $produk, $tanggal);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $tanggal;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_lap_list_outstanding_tabungan_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Outstanding Tabungab Bulan Lalu ' . $tanggal . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    function export_list_saldo_tbg()
    {
        $cabang = $this->uri->segment(3);
        $tabungan = $this->uri->segment(4);
        $produk = $this->uri->segment(5);

        $datas = $this->model_laporan_to_pdf->export_list_saldo_tbg($cabang, $tabungan, $produk);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $this->load->view('laporan/export_list_saldo_tbg', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Saldo Tabungan ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    // BEGIN LAPORAN PREMI ANGGOTA
    public function export_lap_list_premi_anggota_individu()
    {
        $tanggal = $this->current_date();
        $cabang = $this->uri->segment(3);
        $product_code = $this->uri->segment(4);
        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_lap_list_premi_anggota_individu($cabang, $tanggal, $product_code);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';



            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['data_cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['data_cabang'] = "SEMUA CABANG";
            }

            $data['tanggal'] = $tanggal;

            $this->load->view('laporan/export_lap_list_premi_anggota_individu', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_premi_anggota_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    function export_lap_list_premi_anggota()
    {
        $cabang = $this->uri->segment(3);
        $rembug = $this->uri->segment(4);
        $product_code = $this->uri->segment(5);
        $financing_type = $this->uri->segment(6);

        if ($product_code != '00000') {
            $product_financing = $this->model_laporan->get_product_financing_by_code($product_code);
            $product_name = $product_financing['product_name'];
        } else {
            $product_name = 'SEMUA PRODUK';
        }

        if ($financing_type == 1) {
            $rembug = '00000';
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_premi_anggota($cabang, $rembug, $product_code, $financing_type);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['data_cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['data_cabang'] = "SEMUA CABANG";
        }


        $data['product_name'] = $product_name;

        $this->load->view('laporan/export_lap_list_premi_anggota_kelompok', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_premi_anggota_"' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN PREMI ANGGOTA
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/
    public function list_registrasi_pembiayaan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);

        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($cabang, $tanggal1_, $tanggal2_, $cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }

            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_list_registrasi_pembiayaan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_registrasi_pembiayaan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PELUNASAN PEMBIAYAAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN REKAP JATUH TEMPO
    /****************************************************************************/

    //Rekap jatuh tempo by cabang
    public function export_rekap_jatuh_tempo_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } else {
                $data['cabang'] = "Semua Data";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Rembug
    public function export_rekap_jatuh_tempo_rembug()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_rembug($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } else {
                $data['cabang'] = "Semua Data";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_rembug', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_rembug"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Petugas
    public function export_rekap_jatuh_tempo_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_petugas($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo pembiayaan by produk
    public function export_rekap_jatuh_tempo_produk()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_produk($cabang, $tanggal1_, $tanggal2_);

            ob_start();

            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_produk', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap jatuh tempo by Peruntukan
    public function export_rekap_jatuh_tempo_peruntukan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_jatuh_tempo_peruntukan($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_jatuh_tempo_by_peruntukan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_jatuh_tempo_by_peruntukan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP JATUH TEMPO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP OUTSTANDING PIUTANG
    /****************************************************************************/

    //Semua Cabang
    public function export_rekap_outstanding_pembiayaan_semua_cabang()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    function export_rekap_outstanding_pembiayaan_cabang_lalu()
    {
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_cabang_lalu($cabang, $tanggal);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BULAN LALU.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_cabang()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == FALSE) {
            $cabang = '00000';
        } else {
            $cabang = $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_cabang($cabang);

        ob_start();

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = 'SEMUA CABANG';
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_cabang', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP_OUTSTANDING_PIUTANG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_rembug()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == FALSE) {
            $cabang = '00000';
        } else {
            $cabang = $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_rembug($cabang);

        ob_start();

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = 'SEMUA CABANG';
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP_OUTSTANDING_PIUTANG_BY_REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_rembug_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_rembug_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_petugas()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == FALSE) {
            $cabang = '00000';
        } else {
            $cabang =  $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_petugas($cabang);

        ob_start();

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = 'SEMUA CABANG';
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_petugas', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP_OUTSTANDING_PIUTANG_BY_PETUGAS.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_petugas_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_petugas_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_petugas', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PETUGAS.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Produk
    public function export_rekap_outstanding_pembiayaan_produk()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_produk($cabang);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_produk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PRODUK.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    function export_rekap_outstanding_pembiayaan_produk_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_produk_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_produk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PRODUK.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Peruntukan
    public function export_rekap_outstanding_pembiayaan_peruntukan()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_peruntukan($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_peruntukan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PERUNTUKAN.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    function export_rekap_outstanding_pembiayaan_peruntukan_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_peruntukan_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_peruntukan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY PERUNTUKAN.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_outstanding_pembiayaan_sektor_usaha()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_sektor_usaha($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_sektor_usaha', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_outstanding_pembiayaan_sumber_dana()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_sumber_dana($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_sumber_dana', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_sektor_usaha_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_sektor_usaha_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_sektor_usaha', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_outstanding_pembiayaan_sumber_dana_lalu()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $closing_thru_date = $tahun . '-' . $bulan . '-' . $tanggal;

        $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_sumber_dana_lalu($cabang, $closing_thru_date);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_sumber_dana', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP OUTSTANDING PIUTANG BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP OUTSTANDING PIUTANG
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP JUMLAH ANGGOTA
    /****************************************************************************/

    //Semua Cabang
    public function export_rekap_jumlah_anggota_semua_cabang()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota();
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA SEMUA CABANG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Cabang Yang dipilih
    public function export_rekap_jumlah_anggota_cabang()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_kota($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA BY CABANG.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan kecamatan
    public function export_rekap_jumlah_anggota_kecamatan()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_kecamatan($cabang);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA BY KECAMATAN.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan desa
    public function export_rekap_jumlah_anggota_desa()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_desa($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA BY DESA.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Rembug
    public function export_rekap_jumlah_anggota_rembug()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_rembug($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA BY REMBUG.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Petugas
    public function export_rekap_jumlah_anggota_petugas()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_petugas($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAHANGGOTA BY PETUGAS.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //berdasarkan sektor usaha
    public function export_rekap_jumlah_anggota_sektor_usaha()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan->export_pdf_rekap_jumlah_anggota_sektor($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_jumlah_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP JUMLAH ANGGOTA BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP JUMLAH ANGGOTA
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN LAPORAN REKAP SEBARAN ANGGOTA
    /****************************************************************************/

    //Semua Cabang
    public function export_rekap_sebaran_anggota_semua_cabang()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        $datas = $this->model_laporan_to_pdf->export_rekap_sebaran_anggota_semua_cabang($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_sebaran_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SEBARAN ANGGOTA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Cabang Yang dipilih
    public function export_rekap_sebaran_anggota_cabang()
    {

        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_sebaran_anggota_semua_cabang($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_sebaran_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP REKAP SEBARAN ANGGOTA.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    /****************************************************************************/
    //END LAPORAN REKAP SEBARAN ANGGOTA 
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP PENCAIRAN PEMBIAYAAN
    /****************************************************************************/
    //Rekap pencairan semua cabang
    public function export_rekap_pencairan_pembiayaan_semua_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_semua_cabang($tanggal1_, $tanggal2_);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            // $data['result']= $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap Pencairan by cabang
    public function export_rekap_pencairan_pembiayaan_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by cabang  

    //Rekap pencairan by Rembug
    public function export_rekap_pencairan_pembiayaan_rembug()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_rembug($cabang, $tanggal1_, $tanggal2_);

            ob_start();

            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_pencairan_by_rembug', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_rembug"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by rembug  

    //Rekap Pencairan by Petugas
    public function export_rekap_pencairan_pembiayaan_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_petugas($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by petugas  

    //Rekap pencairan by Produk
    public function export_rekap_pencairan_pembiayaan_produk()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_produk($cabang, $tanggal1_, $tanggal2_);

            ob_start();

            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_pencairan_by_produk', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_produk"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    } //End rekap pencairan by produk



    //Rekap pencairan by Peruntukan
    public function export_rekap_pencairan_pembiayaan_peruntukan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_peruntukan($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_peruntukan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_peruntukan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /// end rekap pencairan by peruntukan 

    //Rekap pencairan by nominal 
    public function export_rekap_pencairan_pembiayaan_nominal()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_nominal($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_nominal', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_nominal"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by nominal 

    //Rekap pencairan by sektor 
    public function export_rekap_pencairan_pembiayaan_sektor()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_sektor($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_sektor', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_sektor"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by sektor 

    //Rekap pencairan by kreditur 
    public function export_rekap_pencairan_pembiayaan_kreditur()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pencairan_pembiayaan_kreditur($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pencairan_by_sektor', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pencairan_by_sektor"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    //End Rekap pencairan by kreditur 

    /****************************************************************************/
    //END LAPORAN REKAP PENCAIRAN PEMBIAYAAN
    /****************************************************************************/


<<<<<<< HEAD
    function export_rekap_target_realisasi()
    {
        $branch_code  = $this->uri->segment(3);
        $jenistarget  = $this->uri->segment(4);
        $tahuntarget  = $this->uri->segment(5);

        $judul = 'LAPORAN REKAP TARGET VS REALISASI';


        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $this->model_laporan_to_pdf->export_rekap_target_realisasi($branch_code, $jenistarget, $tahuntarget);
        if ($branch_code != '00000') {
            $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
        } else {
            $data['branch_name'] = "PUSAT";
        }

        $data['judul'] = $judul;
        $data['branch_code'] = $branch['branch_code'];
        $data['jenistarget'] = $jenistarget;
        $data['tahuntarget'] = $tahuntarget;
        $this->load->view('laporan/export_rekap_target_realisasi', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_target_realisasi_' . $branch_code . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }






=======
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
    /****************************************************************************************/
    // START REKAP PELUNASAN
    // Author : Aiman
    // Date   : 25 - 04 - 2018
    /****************************************************************************************/


    //By Kreditur
    function export_rekap_pelunasan_pembiayaan_kreditur()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_kreditur($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_kreditur', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_kreditur"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Sektor
    function export_rekap_pelunasan_pembiayaan_sektor()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_sektor($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_sektor', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_sektor"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Nominal
    function export_rekap_pelunasan_pembiayaan_nominal()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_nominal($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_nominal', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_nominal"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Peruntukan
    function export_rekap_pelunasan_pembiayaan_peruntukan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_peruntukan($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_peruntukan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_peruntukan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Produk
    function export_rekap_pelunasan_pembiayaan_produk()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_produk($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_produk', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_produk"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Petugas
    function export_rekap_pelunasan_pembiayaan_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_petugas($cabang, $tanggal1_, $tanggal2_);
<<<<<<< HEAD
=======
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Rembug
    function export_rekap_pelunasan_pembiayaan_rembug()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_rembug($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_rembug', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_rembug"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //By Cabang
    function export_rekap_pelunasan_pembiayaan_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_pelunasan_pembiayaan_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_pelunasan_pembiayaan_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_pelunasan_pembiayaan_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    /****************************************************************************************/
    // END REKAP PELUNASAN
    /****************************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN REKAP ANGGOTA KELUAR
    /****************************************************************************/
    //Rekap anggota keluar semua cabang
    public function export_rekap_anggota_keluar_semua_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_keluar_semua_cabang($tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            // $data['result']= $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_anggota_keluar_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_keluar_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_keluar by cabang
    public function export_rekap_anggota_keluar_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_keluar_by_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_keluar_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_keluar_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_keluar by Petugas
    public function export_rekap_anggota_keluar_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_keluar_petugas($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_keluar_by_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_keluar_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_keluar by kecamatan
    public function export_rekap_anggota_keluar_kecamatan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        $kecamatan      = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_keluar_kecamatan($cabang, $tanggal1_, $tanggal2_, $kecamatan);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_keluar_by_kecamatan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_keluar_by_kecamatan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_keluar by alasan keluar
    public function export_rekap_anggota_keluar_alasan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        $kecamatan      = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_keluar_alasan($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_keluar_by_alasan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_keluar_by_alasan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP ANGGOTA KELUAR  
    /****************************************************************************/
    
    /****************************************************************************/
    //BEGIN LAPORAN REKAP ANGGOTA MASUK
    /****************************************************************************/

    //Rekap anggota_masuk by cabang
    public function export_rekap_anggota_masuk_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_by_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_masuk by Petugas
    public function export_rekap_anggota_masuk_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_petugas($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_masuk by kecamatan
    public function export_rekap_anggota_masuk_kecamatan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        $kecamatan      = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_kecamatan($cabang, $tanggal1_, $tanggal2_, $kecamatan);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_kecamatan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_kecamatan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP ANGGOTA MASUK 
    /****************************************************************************/


    //Rekap anggota keluar semua cabang
    public function export_rekap_anggota_masuk_semua_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_semua_cabang($tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            // $data['result']= $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;

            $this->load->view('laporan/export_rekap_anggota_masuk_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_kelua by cabang
    public function export_rekap_anggota_masuk_cabang()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_by_cabang($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_cabang', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_cabang"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }


    //Rekap anggota_masuk by kecamatan
    public function export_rekap_anggota_masuk_kecamatan()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        $kecamatan      = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_kecamatan($cabang, $tanggal1_, $tanggal2_, $kecamatan);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_kecamatan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_kecamatan"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    //Rekap anggota_masuk by Petugas
    public function export_rekap_anggota_masuk_petugas()
    {
        $tanggal1       = $this->uri->segment(3);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(4);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $cabang         = $this->uri->segment(5);
        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        if ($tanggal1 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($tanggal2 == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_rekap_anggota_masuk_petugas($cabang, $tanggal1_, $tanggal2_);
            //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $tanggal1__;
            $data['tanggal2_'] = $tanggal2__;
            //$data['report_item'] = $this->model_laporan_to_pdf->getReportItem();

            $this->load->view('laporan/export_rekap_anggota_masuk_by_petugas', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_rekap_anggota_masuk_by_petugas"' . $tanggal1__ . '_"' . $tanggal1__ . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }


    // BEGIN LAPORAN REKAP PENGAJUAN PEMBIAYAAN
    function export_rekap_pengajuan_pembiayaan()
    {
        $cabang = $this->uri->segment(3);
        $pembiayaan = $this->uri->segment(4);
        $kategori = $this->uri->segment(5);
        $from = $this->uri->segment(6);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(7);
        $thru = $this->datepicker_convert(true, $thru, '/');

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_pengajuan_pembiayaan($cabang, $pembiayaan, $kategori, $from, $thru);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['type'] = $jenis;

        if ($kategori == '1') {
            $data['by'] = 'Majelis';
        } else if ($kategori == '2') {
            $data['by'] = 'Petugas';
        } else if ($kategori == '3') {
            $data['by'] = 'Peruntukan';
        } else if ($kategori == '4') {
            $data['by'] = 'Cabang';
        }
        $this->load->view('laporan/export_rekap_pengajuan_pembiayaan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Rekap Pengajuan Pembiayaan Berdasarkan ' . $jenis2 . ' ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //BEGIN LAPORAN LIST REGISTRASI PEMBIAYAAN
    /****************************************************************************/
    function export_list_registrasi_pembiayaan()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        if ($produk == '00000') {
            $pro = 'SEMUA PRODUK';
        } else {
            $getproduk = $this->model_laporan->get_product_financing_by_code($produk);
            $pro = $getproduk['product_name'];
        }

        if ($majelis == '00000') {
            $maj = 'SEMUA MAJELIS';
        } else {
            $getmaj = $this->model_laporan->get_cm_name_by_cm_code($majelis);
            $maj = $getmaj;
        }

        $datas = $this->model_laporan_to_pdf->export_list_registrasi_pembiayaan($from, $thru, $cabang, $majelis, $pembiayaan, $petugas, $produk);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;
        $data['pembiayaan'] = $jenis;
        $data['produk'] = $pro;
        $data['majelis'] = $maj;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $this->load->view('laporan/export_list_registrasi_pembiayaan', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Registrasi Pembiayaan (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST REGISTRASI PEMBIAYAAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST PENGAJUAN PEMBIAYAAN
    /****************************************************************************/
    function export_list_pengajuan_pembiayaan()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_list_pengajuan_pembiayaan($cabang, $from, $thru, $majelis, $pembiayaan, $petugas);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = 'SEMUA CABANG';
        }

        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_list_pengajuan_pembiayaan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Pengajuan Pembiayaan (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' Cabang ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PENGAJUAN PEMBIAYAAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN CASH FLOW TRANSAKSI REMBUG
    /****************************************************************************/
    public function export_cashflow_transaksi_rembug()
    {
        $branch_code = $this->uri->segment(3);
        $from_trx_date = $this->datepicker_convert(false, $this->uri->segment(4));
        $thru_trx_date = $this->datepicker_convert(false, $this->uri->segment(5));
        $fa_code = $this->uri->segment(6);
        $cm_code = $this->uri->segment(7);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cm_code == '0000') {
            //$rembug['cm_code'] = false;
            $data['cm_name'] = 'Semua Majelis';
        } else {
            $data_cm = $this->model_cif->get_cm_by_cm_code($cm_code);
            $data['cm_name'] = $data_cm['cm_name'];
        }

        $datas = $this->model_laporan->export_cashflow_transaksi_rembug($branch_code, $cm_code, $fa_code, $from_trx_date, $thru_trx_date);
        $datadropingbyproduk = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_produk($branch_code, $fa_code, $from_trx_date, $thru_trx_date, $cm_code);
        $datadropingbyperuntukan = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_peruntukan($branch_code, $fa_code, $from_trx_date, $thru_trx_date, $cm_code);
        $datadropingbysektor = $this->model_laporan->export_rekap_pencairan_pembiayaan_by_sektor($branch_code, $fa_code, $from_trx_date, $thru_trx_date, $cm_code);

        if (count($datas) == 0) {
            echo '<script>alert("Data Tidak ditemukan");</script>';
            echo '<script>window.close();</script>';
            die();
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['data'] = $datas;
        $data['datadropingbyproduk'] = $datadropingbyproduk;
        $data['datadropingbyperuntukan'] = $datadropingbyperuntukan;
        $data['datadropingbysektor'] = $datadropingbysektor;


        if ($branch_code != '0000') {
            $data['branch_code'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($branch_code));
        } else {
            $data['branch_code'] = "Semua Cabang";
        }

        if ($fa_code == '0000') {
            $data['fa_name'] = 'Semua Petugas';
        } else {
            $data_fa = $this->model_laporan->show_fa_name($fa_code);
            $data['fa_name'] = $data_fa['fa_name'];
        }

        $data['from_trx_date'] = $from_trx_date;
        $data['thru_trx_date'] = $thru_trx_date;

        $this->load->view('laporan/export_cashflow_transaksi_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_cashflow_transaksi_rembug"' . $from_trx_date . '_"' . $thru_trx_date . '""_"' . $branch_code . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN CASH FLOW TRANSAKSI REMBUG
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST TRANSAKSI REMBUG
    /****************************************************************************/
    public function export_lap_trx_rembug()
    {
        $branch_code = $this->uri->segment(3);
        $from_trx_date = $this->datepicker_convert(false, $this->uri->segment(4));
        $thru_trx_date = $this->datepicker_convert(false, $this->uri->segment(5));
        $cm_code = $this->uri->segment(6);
        $fa_code = $this->uri->segment(7);
        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        if ($cm_code == false) {
            $rembug['cm_code'] = false;
            $rembug['cm_name'] = 'Semua Rembug';
        } else {
            $rembug = $this->model_cif->get_cm_by_cm_code($cm_code);
        }
        // var_dump($branch_code);
        // die();
        $datas = $this->model_laporan->export_list_transaksi_rembug($branch_code, $cm_code, $from_trx_date, $thru_trx_date, $fa_code);

        // var_dump($branch_code);
        // var_dump($cm_code);
        // var_dump($from_trx_date);
        // var_dump($thru_trx_date);
        // var_dump($fa_code);
        // die();
        if (count($datas) == 0) {
            echo '<script>alert("Data Tidak ditemukan");</script>';
            echo '<script>window.close();</script>';
            die();
        }

        ob_start();

        $grandtotal_angsuran_pokok = 0;
        $grandtotal_angsuran_margin = 0;
        $grandtotal_angsuran_catab = 0;
        $grandtotal_setoran_lwk = 0;
        $grandtotal_tab_sukarela_cr = 0;
        $grandtotal_minggon = 0;
        $grandtotal_tab_wajib_cr = 0;
        $grandtotal_tab_kelompok_cr = 0;
        $grandtotal_tab_rencana = 0;
        $grandtotal_tab_sukarela_db = 0;
        $grandtotal_pokok = 0;
        $grandtotal_administrasi = 0;
        $grandtotal_asuransi = 0;
        $grandtotal_infaq = 0;
        $grandtotal_setoran = 0;
        $grandtotal_penarikan = 0;

        $html = '
        
        <div style="font-size:11px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td colspan="17">
        
        <h4 style="margin-bottom:0;text-align:center">LAPORAN TRANSAKSI REMBUG</h4>
        <h4 style="margin-top:10px;text-align:center">' . $branch['branch_name'] . '</h4>
        
        <p>&nbsp;</p>
        </td>
        </tr>
                 ';

        for ($i = 0; $i < count($datas); $i++) {
            $datass = $this->model_laporan->export_list_transaksi_rembug_sub($datas[$i]['trx_cm_id'], $from_trx_date, $thru_trx_date, $datas[$i]['trx_date']);

            // }

            if ($i == 0) {
                $html .= '<tr>';
                $html .= '<td style="padding:3px;">Rembug</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['cm_name'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal Bayar</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['trx_date'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Status Verifikasi</td>';
                $html .= '<td style="padding:3px 0;">: ' . $datas[$i]['status_verifikasi'] . '</td>';
                $html .= '<td style="padding:3px 3px 3px 0;" rowspan="2" colspan="7">';
                $html .= '
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Total Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Total Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($datas[$i]['infaq'], 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($datas[$i]['setoran'], 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">' . number_format($datas[$i]['penarikan'], 0, ',', '.') . '</td>
                            </tr>
                        </table>';
                $html .= '</td>';

                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="padding:3px;">Petugas</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['fa_name'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal</td>';
                $html .= '<td style="padding:3px 0;" colspan="12">: ' . $datas[$i]['created_date'] . '</td>';
                $html .= '</tr>';

                $html .= '
                     <tr>
                        <td width="120" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;" colspan="2">ID</td>
                        <td width="150" valign="middle" align="center" style="border-top:solid 1px #999;border-bottom:solid 1px transparent;" rowspan="2">NAMA</td>
                        <td width="230" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;" colspan="4">ANGSURAN</td>
                        <td width="200" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;" colspan="3">Setoran</td>
                        <td width="60" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;border-right:solid 1px #FFF;">Penarikan</td>
                        <td width="180" align="center" style="border:solid 1px #999;border-bottom:solid 0px #FFF;" colspan="3">REALISASI PEMBIAYAAN</td>
                     </tr>
                     <tr>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">ANGGOTA</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;">PYD</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Freq</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Pokok</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Margin</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Catab</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:53px;text-align:center;">Simpok<br/>Simwa</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:52px;text-align:center;">Sukarela</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;text-align:center;">TABREN</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;">Sukarela</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:55px;">Plafon</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;border-right:solid 0px #FFF;width:55px;">Adm.</td>
                        <td align="center" style="border:solid 1px #999;border-bottom:solid 1px transparent;width:55px;">Asuransi</td>
                     </tr>
                ';
            } else {

                $html .= '<tr>';
                $html .= '<td style="padding:3px; border-left:solid 1px #999;">Rembug</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['cm_name'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal Bayar</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['trx_date'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Status Verifikasi</td>';
                $html .= '<td style="padding:3px 0;">: ' . $datas[$i]['status_verifikasi'] . '</td>';
                $html .= '<td style="padding:3px 3px 3px 0; border-right:solid 1px #999;" colspan="7" rowspan="2">';

                $html .= '
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Total Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Total Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($datas[$i]['infaq'], 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($datas[$i]['setoran'], 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">' . number_format($datas[$i]['penarikan'], 0, ',', '.') . '</td>
                            </tr>
                        </table>';

                $html .= '</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                $html .= '<td style="padding:3px; border-left:solid 1px #999;">Petugas</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">: ' . $datas[$i]['fa_name'] . '</td>';
                $html .= '<td style="padding:3px 0;" colspan="2">Tanggal</td>';
                $html .= '<td style="padding:3px 0; border-right:solid 1px #999;" colspan="12">: ' . $datas[$i]['created_date'] . '</td>';
                $html .= '</tr>';
            }


            $total_angsuran_pokok = 0;
            $total_angsuran_margin = 0;
            $total_angsuran_catab = 0;
            $total_setoran_lwk = 0;
            $total_tab_sukarela_cr = 0;
            $total_minggon = 0;
            $total_tab_wajib_cr = 0;
            $total_tab_kelompok_cr = 0;
            $total_tab_rencana = 0;
            $total_tab_sukarela_db = 0;
            $total_pokok = 0;
            $total_administrasi = 0;
            $total_asuransi = 0;

            $grandtotal_infaq += $datas[$i]['infaq'];
            $grandtotal_setoran += $datas[$i]['setoran'];
            $grandtotal_penarikan += $datas[$i]['penarikan'];

            for ($j = 0; $j < count($datass); $j++) {

                $total_angsuran_pokok   += ($datass[$j]['freq'] * $datass[$j]['angsuran_pokok']);
                $total_angsuran_margin  += ($datass[$j]['freq'] * $datass[$j]['angsuran_margin']);
                $total_angsuran_catab   += ($datass[$j]['freq'] * $datass[$j]['angsuran_catab']);
                $total_setoran_lwk      += ($datass[$j]['setoran_lwk'] + $datass[$j]['setoran_mingguan']);
                $total_tab_sukarela_cr  += $datass[$j]['tab_sukarela_cr'];
                $total_minggon          += $datass[$j]['minggon'];
                $total_tab_wajib_cr     += ($datass[$j]['freq'] * $datass[$j]['tab_wajib_cr']);
                $total_tab_kelompok_cr  += ($datass[$j]['freq'] * $datass[$j]['tab_kelompok_cr']);
                $total_tab_rencana      += $datass[$j]['tabren'];
                $total_tab_sukarela_db  += $datass[$j]['tab_sukarela_db'];
                $total_pokok            += $datass[$j]['pokok'];
                $total_administrasi     += $datass[$j]['administrasi'];
                $total_asuransi         += $datass[$j]['asuransi'];
                $html .= '<tr>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . $datass[$j]['cif_no'] . '</td>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . (($datass[$j]['angsuran_pokok'] == 0 && $datass[$j]['pokok'] == 0) ? '' : $datass[$j]['pembiayaan_ke']) . '</td>
                        <td align="left" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . $datass[$j]['nama'] . '</td>
                        <td align="center" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . $datass[$j]['freq'] . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['angsuran_pokok'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['angsuran_margin'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['angsuran_catab'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format(($datass[$j]['setoran_lwk'] + $datass[$j]['setoran_mingguan']), 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['tab_sukarela_cr'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['tabren'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['tab_sukarela_db'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['pokok'], 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;">' . number_format($datass[$j]['administrasi'], 0, ',', '.') . '</td>
                        <td align="right" style="text-align:right;padding:3px;font-size:11px;border-top:solid 1px #999;border-left:solid 1px #999;border-right:solid 1px #999">' . number_format($datass[$j]['asuransi'], 0, ',', '.') . '</td>
                     </tr>';
            }

            $html .= '
                     <tr>
                        <td align="right" style="padding:3px 6px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;font-weight:bold;" colspan="4">Total</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_setoran_lwk, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_tab_sukarela_cr, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_tab_rencana, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_pokok, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-right:solid 0px #FFF;">' . number_format($total_administrasi, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;">' . number_format($total_asuransi, 0, ',', '.') . '</td>
                     </tr>';


            $grandtotal_angsuran_pokok += $total_angsuran_pokok;
            $grandtotal_angsuran_margin += $total_angsuran_margin;
            $grandtotal_angsuran_catab += $total_angsuran_catab;
            $grandtotal_setoran_lwk += $total_setoran_lwk;
            $grandtotal_tab_sukarela_cr += $total_tab_sukarela_cr;
            $grandtotal_tab_wajib_cr += $total_minggon;
            $grandtotal_tab_kelompok_cr += $total_tab_kelompok_cr;
            $grandtotal_tab_rencana += $total_tab_rencana;
            $grandtotal_tab_sukarela_db += $total_tab_sukarela_db;
            $grandtotal_pokok += $total_pokok;
            $grandtotal_administrasi += $total_administrasi;
            $grandtotal_asuransi += $total_asuransi;
        }

        $html .= '
                     <tr>
                        <td align="right" style="padding:3px 6px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;font-weight:bold;" colspan="4">Grand Total</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_angsuran_pokok, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_angsuran_margin, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_angsuran_catab, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_setoran_lwk, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_tab_sukarela_cr, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_tab_rencana, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_tab_sukarela_db, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_pokok, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;border-right:solid 0px #FFF;">' . number_format($grandtotal_administrasi, 0, ',', '.') . '</td>
                        <td align="right" style="padding:3px;font-size:11px;border:solid 1px #999;border-top:solid 1px transparent;">' . number_format($grandtotal_asuransi, 0, ',', '.') . '</td>
                     </tr>';

        $html .= '
                     <tr>
                        <td colspan="17" style="padding-top:5px;">
                        <table cellspacing="0" cellpadding="0" align="center" style="width:300px;">
                            <tr>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Infaq</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;border-right:solid 0px #FFF;">Grand Total<br>Setoran</td>
                                <td style="background:#EEE;width:100px;text-align:center;padding:3px;font-weight:bold;border:solid 1px #999;">Grand Total<br>Penarikan</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($grandtotal_infaq, 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-right:solid 0px #FFF;border-top:solid 0px #FFF;">' . number_format($grandtotal_setoran, 0, ',', '.') . '</td>
                                <td style="text-align:center;padding:3px;border:solid 1px #999;border-top:solid 0px #FFF;">' . number_format($grandtotal_penarikan, 0, ',', '.') . '</td>
                            </tr>
                        </table>
                        </td>
                     </tr>';

        $html .= '</table></div><p>&nbsp;</p>';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_lap_trx_rembug".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST TRANSAKSI REMBUG
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/
    public function export_list_saldo_tabungan()
    {
        $branch_code = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $cm_code = $this->uri->segment(5);
        // $datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } /*
        else if ($cm_code=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }*/ else {

            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['saldo_tabungan'] = $this->model_laporan->export_list_saldo_tabungan($branch_code, $fa_code, $cm_code);

            // $data['result']= $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_list_saldo_tabungan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_saldo_tabungan_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST SALDO ANGGOTA
    /****************************************************************************/
    public function export_list_saldo_anggota()
    {
        $branch_code = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $cm_code = $this->uri->segment(5);
        // $datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
<<<<<<< HEAD
        } else {
=======
        } /*
        else if ($cm_code=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }*/ else {
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['saldo_tabungan'] = $this->model_laporan->export_list_saldo_anggota($branch_code, $fa_code, $cm_code);

            // $data['result']= $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_list_saldo_anggota', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_saldo_anggota_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST SALDO ANGGOTA
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST ANGGOTA KELUAR
    /****************************************************************************/
    public function export_list_anggota_keluar()
    {
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);
        $from_date1 = $this->uri->segment(5);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(6);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['list_anggota_keluar'] = $this->model_laporan->export_list_anggota_keluar($branch_code, $cm_code, $from_date, $thru_date);

            // $data['result']= $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_list_anggota_keluar', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_anggota_keluar_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST ANGGOTA KELUAR
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST ANGGOTA MUTASI 
    /****************************************************************************/
    public function export_list_anggota_mutasi()
    {
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);
        $from_date1 = $this->uri->segment(5);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(6);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else {
            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['list_anggota_mutasi'] = $this->model_laporan->export_list_anggota_mutasi($branch_code, $cm_code, $from_date, $thru_date);

            // $data['result']= $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_list_anggota_mutasi', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_list_mutasi_anggota_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST ANGGOTA MUTASI 
    /****************************************************************************/



    // BEGIN ANGGOTA MASUK
    function export_list_anggota_masuk()
    {
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
<<<<<<< HEAD
        $from = $this->uri->segment(5);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(6);
=======
        $fa_code = $this->uri->segment(5);
        $from = $this->uri->segment(6);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(7);
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        $thru = $this->datepicker_convert(true, $thru, '/');

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

<<<<<<< HEAD
        $data['list_anggota_keluar'] = $this->model_laporan->export_list_anggota_masuk($cabang, $majelis, $from, $thru);
=======
        $data['list_anggota_masuk'] = $this->model_laporan->export_list_anggota_masuk($cabang, $majelis, $fa_code, $from, $thru);
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

        // $data['result']= $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $data_cabang = $data['cabang'];

        $this->load->view('laporan/export_pdf_list_anggota_masuk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_anggota_masuk_"' . $data_cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST ANGGOTA MASUK
    /****************************************************************************/

    // BEGIN LAPORAN LIST ANGGOTA ABSEN 
    function export_list_anggota_absen()
    {
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $from = $this->uri->segment(5);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(6);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $user_id = $this->session->userdata('user_id');


        ///$insert_temp = $this->model_laporan_to_pdf->insert_temp_2($cabang,$report_code,$fromlm,$from,$thru,$user_id,$flag_akhir_tahun);
        $insert_absen_report = $this->model_laporan_to_pdf->insert_absen_report($cabang, $majelis, $from, $thru, $user_id);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['list_anggota_absen'] = $this->model_laporan->export_list_anggota_absen($cabang, $majelis, $from, $thru);

        // $data['result']= $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $data_cabang = $data['cabang'];

        $this->load->view('laporan/export_pdf_list_anggota_absen', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_anggota_absen_"' . $data_cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST ANGGOTA ABSEN 
    /****************************************************************************/

    // BEGIN LEMBAR ABSEN ANGGOTA  
    function export_lembar_absen_anggota()
    {
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $tahun = $this->uri->segment(5);
        ///$from = $this->datepicker_convert(true,$from,'/');
        $user_id = $this->session->userdata('user_id');

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['lembar_absen_anggota'] = $this->model_laporan->export_lembar_absen_anggota($cabang, $majelis, $tahun);

        // $data['result']= $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $data_cabang = $data['cabang'];

        $this->load->view('laporan/export_pdf_lembar_absen_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'F4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('lembar_absensi_anggota_"' . $data_cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST ANGGOTA ABSEN 
    /****************************************************************************/



    /****************************************************************************/
    //BEGIN LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/
    public function export_list_pembukaan_tabungan()
    {
        $produk = $this->uri->segment(3);
        $branch_code = $this->uri->segment(4);

        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['saldo_tabungan'] = $this->model_laporan->export_list_pembukaan_tabungan($produk, $branch_code);

        if ($produk == 'all') {
            $data['product_name'] = 'SEMUA PRODUK';
        } else {
            $data['product_name'] = $this->model_laporan->get_produk($produk);
        }

        $data['produk']         = $produk;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;

        $this->load->view('laporan/export_list_pembukaan_tabungan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_saldo_tabungan_"' . $produk . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST SALDO TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN BLOKIR TABUNGAN
    /****************************************************************************/
    public function export_list_blokir_tabungan()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

        $branch_code = $this->uri->segment(5);
        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['blokir_tabungan'] = $this->model_laporan_to_pdf->export_list_blokir_tabungan($from_date, $thru_date, $branch_code);
        $data['tanggal1_view']   = $from_date;
        $data['tanggal2_view']   = $thru_date;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;

        $this->load->view('laporan/export_list_blokir_tabungan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_blokir_tabungan_"' . $from_date . 's/d' . $thru_date . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN BLOKIR TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST REKENING TABUNGAN
    /****************************************************************************/
    public function export_list_rekening_tabungan()
    {
        $cif_no     = $this->uri->segment(3);
        $no_rek     = $this->uri->segment(4);
        $from_date1 = $this->uri->segment(5);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(6);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $awal_debit                 = $this->model_laporan->get_saldo_awal_debet($no_rek, $from_date);
        $awal_credit                = $this->model_laporan->get_saldo_awal_credit($no_rek, $from_date);
        $data['saldo_awal']         = $awal_credit['credit'] - $awal_debit['debit'];
        $data['rek_tabungan']       = $this->model_laporan->export_list_statement_tabungan($cif_no, $no_rek, $from_date, $thru_date);
        $data['product_name']       = $this->model_laporan->get_produk_saving_by_norek($no_rek);
        $data['nama']               = $this->model_laporan->get_nama($cif_no);
        // $data['produk']             = $produk;
        $data['tanggal1_view']      = $from_date;
        $data['tanggal2_view']      = $thru_date;
        $data['tgl_saldo_akhir']    = date("Y-m-d", strtotime($from_date . ' -1 days'));
        $data['no_rek']             = $no_rek;
        $data['cif_no']             = $cif_no;

        $this->load->view('laporan/export_list_rekening_tabungan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_rekening_tabungan_"' . $cif_no . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST REKENING TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST PEMBUKAAAN TABUNGAN
    /****************************************************************************/
    public function export_list_buka_tabungan()
    {
        $produk = $this->uri->segment(3);
        $from_date1 = $this->uri->segment(4);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(5);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);
        $branch_code = $this->uri->segment(6);
        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }


        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['saldo_tabungan'] = $this->model_laporan->export_list_buka_tabungan($produk, $from_date, $thru_date, $branch_code);
        $data['product_name']   = $this->model_laporan->get_produk($produk);
        $data['produk']         = $produk;
        $data['tanggal1_view']  = $from_date;
        $data['tanggal2_view']  = $thru_date;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;
        // $data['branch']         = $this->model_cif->get_rembug_by_keyword;

        $this->load->view('laporan/export_list_buka_tabungan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            ob_end_clean();
            $html2pdf->Output('export_list_pembukaan_tabungan.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    //BEGIN LAPORAN LIST PEMBUKAAAN TABUNGAN
    /****************************************************************************/
    public function export_list_buka_tabungan_jtempo()
    {
        $produk = $this->uri->segment(3);
        $from_date1 = $this->uri->segment(4);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(5);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);
        $branch_code = $this->uri->segment(6);
        $status = $this->uri->segment(7);
        $rembug = $this->uri->segment(8);
        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['saldo_tabungan'] = $this->model_laporan->export_list_buka_tabungan_jtempo($produk, $from_date, $thru_date, $branch_code, $status, $rembug);
        $data['product_name']   = $this->model_laporan->get_produk($produk);
        $data['produk']         = $produk;
        $data['tanggal1_view']  = $from_date;
        $data['tanggal2_view']  = $thru_date;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;

        $this->load->view('laporan/export_list_buka_tabungan_jtempo', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pembukaan_tabungan_"' . $produk . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST PEMBUKAAN TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN CETAK TRANSAKSI BUKU TABUNGAN
    /****************************************************************************/
    public function cetak_trans_buku()
    {
        // $produk = $this->uri->segment(3);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['cetak_buku']         = $this->model_laporan->export_cetak_trans_buku();
        // $data['margin']             = $this->model_laporan->get_margin();
        // $data['saldo_tabungan']  = $this->model_laporan->export_cetak_trans_buku($produk);
        // $data['product_name']    = $this->model_laporan->get_produk($produk);
        // $data['produk']          = $produk;

        $this->load->view('laporan/export_cetak_trans_buku', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_cetak_trans_buku.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END CETAK TRANSAKSI BUKU TABUNGAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN PEMBUKAAN DEPOSITO
    /****************************************************************************/
    public function export_list_pembukaan_deposito()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $branch_code = $this->uri->segment(5);
        $product_code     = $this->uri->segment(6);

        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }

        if ($product_code != '0000') {
            $product_financing = $this->model_laporan_to_pdf->get_product2($product_code);
            $product_name = $product_financing['product_name'];
        } else {
            $product_name = 'SEMUA PRODUK';
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['regis_deposito']  = $this->model_laporan_to_pdf->export_list_pembukaan_deposito($from_date, $thru_date, $branch_code, $product_code);

        $data['tanggal1_view']   = $from_date;
        $data['tanggal2_view']   = $thru_date;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;

        $data['produk'] = $product_name;


        $this->load->view('laporan/export_list_pembukaan_deposito', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_pembukaan_deposito_"' . $from_date . 's/d' . $thru_date . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN PEMBUKAAN DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN SALDO DEPOSITO
    /****************************************************************************/
    public function export_list_saldo_deposito()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $produk = $this->uri->segment(5);
        $branch_code = $this->uri->segment(6);

        if ($branch_code == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }
        if ($produk != '0000') {
            $product_financing = $this->model_laporan_to_pdf->get_product2($produk);
            $product_name = $product_financing['product_name'];
        } else {
            $product_name = 'SEMUA PRODUK';
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['saldo_deposito'] = $this->model_laporan->export_list_saldo_deposito($from_date, $thru_date, $produk, $branch_code);
        //$data['product_name']   = $this->model_laporan->get_produk_deposito($produk);

        $data['tanggal1_view']   = $from_date;
        $data['tanggal2_view']   = $thru_date;
        $data['cabang']         = ($branch_code == '0000') ? 'SEMUA CABANG' : 'CABANG ' . $branch_name;

        $data['produk'] = $product_name;

        $this->load->view('laporan/export_list_saldo_deposito2', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_list_saldo_deposito2_"' . $produk . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN SALDO DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING DEPOSITO
    /****************************************************************************/
    public function export_lap_droping_deposito()
    {
        $from_date  = $this->uri->segment(3);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $cabang     = $this->uri->segment(5);
        $produk = $this->uri->segment(6);

        if ($cabang == '0000') {
            $branch_name = '';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }
        if ($produk != '0000') {
            $product_financing = $this->model_laporan_to_pdf->get_product2($produk);
            $product_name = $product_financing['product_name'];
        } else {
            $product_name = 'SEMUA PRODUK';
        }
        // if ($rembug==false) 
        // {
        //     $rembug = "";
        // } 
        // else 
        // {
        //     $rembug =   $rembug;            
        // }

        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($from_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else if ($thru_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_lap_droping_deposito($from_date, $thru_date, $cabang, $produk);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_droping_deposito', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_droping_deposito"' . $from_date . '_"' . $thru_date . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP PEMBUKAAN DEPOSITO
    /****************************************************************************/
    public function export_rekap_pembukaan_deposito()
    {
        $cabang     = $this->uri->segment(3);
        $produk     = $this->uri->segment(4);
        $from_date  = $this->uri->segment(5);
        $from_date  = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(6);
        $thru_date  = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

        if ($produk == '0000') {
            $pro = 'SEMUA PRODUK';
        } else {
            $getproduk = $this->model_laporan->get_product_financing_by_code($produk);
            $pro = $getproduk['product_name'];
        }


        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['regis_deposito'] = $this->model_laporan->export_rekap_pembukaan_deposito($cabang, $produk, $from_date, $thru_date);
        // $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['tanggal1']       = $from_date;
        $data['tanggal2']       = $thru_date;
        $data['product_name']         = $pro;

        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_rekap_pembukaan_deposito', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_pembukaan_deposito_"' . $produk . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP PEMBUKAAN DEPOSITO
    /****************************************************************************/

    //BEGIN LAPORAN OUTSTANDING
    /****************************************************************************/
    public function export_rekap_outstanding_deposito()
    {
        $tanggal    = $this->current_date();
        $produk     = $this->uri->segment(3);
        $cabang     = $this->uri->segment(4);
        // $rembug     = $this->uri->segment(5);    

        // if ($rembug==false) 
        // {
        //     $rembug = "";
        // } 
        // else 
        // {
        //     $rembug =   $rembug;            
        // }

        $datas = $this->model_laporan->export_rekap_saldo_deposito($cabang, $tanggal, $produk);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';


        $data['datas'] = $this->model_laporan->export_rekap_saldo_deposito($cabang, $tanggal, $produk);

        if ($cabang != '0000')
            $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['data_cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['data_cabang'] = "Semua Cabang";
        }

        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['tanggal']        = $tanggal;

        $this->load->view('laporan/export_rekap_saldo_deposito', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_outstanding_deposito_"' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN OUTSTANDING
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN REKAP BAGI HASIL DEPOSITO
    /****************************************************************************/
    public function export_rekap_bagi_hasil_deposito()
    {
        $produk     = $this->uri->segment(3);
        $from_date  = $this->uri->segment(4);
        $from_date  = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(5);
        $thru_date  = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['bahas_deposito'] = $this->model_laporan->export_rekap_bagi_hasil_deposito($produk, $from_date, $thru_date);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['tanggal1']       = $from_date;
        $data['tanggal2']       = $thru_date;

        $this->load->view('laporan/export_rekap_bagi_hasil_deposito', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_bagi_hasil_deposito_"' . $produk . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN REKAP BAGI HASIL DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN HISTORY TRANSAKSI DEPOSITO
    /****************************************************************************/
    public function export_list_rekening_deposito()
    {
        $cif_no     = $this->uri->segment(3);
        $no_rek     = $this->uri->segment(4);
        $produk     = $this->uri->segment(5);
        $from_date1 = $this->uri->segment(6);
        $from_date  = substr($from_date1, 4, 4) . '-' . substr($from_date1, 2, 2) . '-' . substr($from_date1, 0, 2);
        $thru_date1 = $this->uri->segment(7);
        $thru_date  = substr($thru_date1, 4, 4) . '-' . substr($thru_date1, 2, 2) . '-' . substr($thru_date1, 0, 2);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['rek_tabungan']   = $this->model_laporan->export_list_rekening_deposito($cif_no, $no_rek, $produk, $from_date, $thru_date);
        $data['product_name']   = $this->model_laporan->get_produk_deposito($produk);
        $data['nama']           = $this->model_laporan->get_nama($cif_no);
        $data['produk']         = $produk;
        $data['tanggal1_view']  = $from_date;
        $data['tanggal2_view']  = $thru_date;
        $data['no_rek']         = $no_rek;
        $data['cif_no']         = $cif_no;

        $this->load->view('laporan/export_list_rekening_deposito', $data);

        // $content = ob_get_clean();

        // try
        // {
        //     $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
        //     $html2pdf->pdf->SetDisplayMode('fullpage');
        //     $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //     $html2pdf->Output('export_list_rekening_deposito_"'.$cif_no.'".pdf');
        // }
        // catch(HTML2PDF_exception $e) {
        //     echo $e;
        //     exit;
        // }
    }
    /****************************************************************************/
    //END LAPORAN HISTORY TRANSAKSI DEPOSITO
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    public function export_lap_transaksi_tabungan()
    {
        $from_date  = $this->uri->segment(3);
        $from_date  = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date  = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $cabang     = $this->uri->segment(5);
        $rembug     = $this->uri->segment(6);
        if ($rembug == false) {
            $rembug = "";
        } else {
            $rembug =   $rembug;
        }

        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($from_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else if ($thru_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_lap_transaksi_tabungan($cabang, $rembug, $from_date, $thru_date);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_transaksi_tabungan', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_transaksi_tabungan"' . $from_date . '_"' . $thru_date . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/
    public function export_lap_transaksi_akun()
    {
        $from_date  = $this->uri->segment(3);
        $from_date  = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date  = $this->uri->segment(4);
        $thru_date  = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $cabang     = $this->uri->segment(5);
        $rembug     = $this->uri->segment(6);
        if ($rembug == false) {
            $rembug = "";
        } else {
            $rembug =   $rembug;
        }

        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($from_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else if ($thru_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else {

            $datas = $this->model_laporan_to_pdf->export_lap_transaksi_akun($cabang, $rembug, $from_date, $thru_date);

            ob_start();


            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';

            $data['result'] = $datas;

            $data['result'] = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            } else {
                $data['cabang'] = "Semua Data";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;

            $this->load->view('laporan/export_lap_transaksi_akun', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_transaksi_akun"' . $from_date . '_"' . $thru_date . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN DROPING PEMBIAYAAN
    /****************************************************************************/

    // public function export_rekap_saldo_anggota_semua_cabang()
    // {
    //     $cabang = $this->uri->segment(3);   

    //     $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
    //     // echo "<pre>";
    //     // print_r($datas);
    //     // die();
    //     ob_start();

    //     $config['full_tag_open'] = '<p>';
    //     $config['full_tag_close'] = '</p>';

    //     $data['result']= $datas;
    //     if ($cabang !='0000')  {
    //         $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
    //     } else {
    //         $data['cabang'] = "Semua Data";
    //     }

    //     $this->load->view('laporan/export_pdf_rekap_saldo_anggota',$data);

    //     $content = ob_get_clean();

    //     try
    //     {
    //         $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
    //         $html2pdf->pdf->SetDisplayMode('fullpage');
    //         $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //         $html2pdf->Output('REKAP SALDO ANGGOTA.pdf');
    //     }
    //     catch(HTML2PDF_exception $e) {
    //         echo $e;
    //         exit;
    //     }
    // }

    /****************************************************************************/
    //BEGIN LAPORAN REKAP SALDO ANGGOTA
    /****************************************************************************/
    public function export_rekap_saldo_anggota_semua_cabang()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);
        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY CABANG "' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    // public function export_rekap_saldo_anggota_semua_cabang_lalu()
    // {
    //     $cabang = $this->uri->segment(3);  

    //     if($cabang==false){
    //         $cabang = "0000";
    //     }else{
    //         $cabang =   $cabang;            
    //     }

    //     $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_lalu($cabang);
    //     ob_start();

    //     $config['full_tag_open'] = '<p>';
    //     $config['full_tag_close'] = '</p>';
    //     $data['result']= $datas;
    //     if ($cabang !='0000'){
    //         $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
    //     }else{
    //         $data['cabang'] = "Semua Data";
    //     }

    //     $this->load->view('laporan/export_pdf_rekap_saldo_anggota',$data);

    //     $content = ob_get_clean();

    //     try
    //     {
    //         $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
    //         $html2pdf->pdf->SetDisplayMode('fullpage');
    //         $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //         $html2pdf->Output('REKAP SALDO ANGGOTA BY CABANG "'.$cabang.'".pdf');
    //     }
    //     catch(HTML2PDF_exception $e) {
    //         echo $e;
    //         exit;
    //     }
    // }

    public function export_rekap_saldo_anggota_cabang()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota($cabang);

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY CABANG "' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_rembug()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug($cabang);

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_by_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY REMBUG "' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_petugas()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas($cabang);

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
        } else {
            $data['cabang'] = "Semua Data";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_by_petugas', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PETUGAS "' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP SALDO ANGGOTA
    /****************************************************************************/

    /* PDF GL INQUIRY */
    public function list_jurnal_umum_gl()
    {

        $branch_code = $this->uri->segment(3);
        $account_code = $this->uri->segment(4);
        $from_date = $this->uri->segment(5);
        $thru_date = $this->uri->segment(6);

        $from_date = $this->datepicker_convert(false, $from_date, '');
        $thru_date = $this->datepicker_convert(false, $thru_date, '');

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];

        if ($account_code == '-') {
            $account_name = '-';
        } else {
            $account = $this->model_cif->get_gl_account_by_account_code($account_code);
            $account_code = $account['account_code'];
            $account_name = $account['account_name'];
        }

        $datas = $this->model_laporan->get_gl_account_history($branch_code, $account_code, $from_date, $thru_date);
        $saldo = $this->model_laporan->fn_get_saldo_gl_account2($account_code, $from_date, $branch_code);

        $saldo_akhir = $saldo['saldo_awal'];
        $total_debit = 0;
        $total_credit = 0;
        $i = 0;
        for ($j = 0; $j < count($datas) + 1; $j++) {
            if ($j == 0) {
                $data['data'][$j]['nomor'] = '';
                $data['data'][$j]['trx_date'] = '';
                $data['data'][$j]['description'] = 'Saldo Awal';
                $data['data'][$j]['debit'] = '';
                $data['data'][$j]['credit'] = '';
                $data['data'][$j]['saldo_akhir'] = $saldo_akhir;
                $data['data'][$j]['trx_gl_id'] = '';
            } else {
                if ($datas[$i]['flag_debit_credit'] == "C") {
                    if ($datas[$i]['transaction_flag_default'] == 'C') {
                        $saldo_akhir += $datas[$i]['amount'];
                    } else {
                        $saldo_akhir -= $datas[$i]['amount'];
                    }
                }
                if ($datas[$i]['flag_debit_credit'] == "D") {
                    if ($datas[$i]['transaction_flag_default'] == 'D') {
                        $saldo_akhir += $datas[$i]['amount'];
                    } else {
                        $saldo_akhir -= $datas[$i]['amount'];
                    }
                }
                $data['data'][$j]['nomor'] = $i + 1;
                $data['data'][$j]['trx_date'] = $datas[$i]['voucher_date'];
                $data['data'][$j]['description'] = $datas[$i]['description'];
                $data['data'][$j]['debit'] = $datas[$i]['debit'];
                $data['data'][$j]['credit'] = $datas[$i]['credit'];
                $data['data'][$j]['saldo_akhir'] = $saldo_akhir;
                $data['data'][$j]['trx_gl_id'] = $datas[$i]['trx_gl_id'];

                $total_debit  += $datas[$i]['debit'];
                $total_credit += $datas[$i]['credit'];

                $i++;
            }
        }
        $data['total_debit'] = $total_debit;
        $data['total_credit'] = $total_credit;


        ob_start();

        // HEAD
        $html = '
            <page backbottom="10mm">
            <page_footer><div style="text-align:center;width:100%;">([[page_cu]])</div></page_footer>
            <h3 align="center" style="line-height:30px;">' . $this->session->userdata('institution_name') . '<br>' . $branch_name . '<br>GL INQUIRY</h3>
            <table>
                <tr>
                    <td>GL Account</td>
                    <td>:</td>
                    <td>' . $account_name . '</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>' . $this->format_date_detail($from_date, 'id', false, '/') . ' s.d ' . $this->format_date_detail($thru_date, 'id', false, '/') . '</td>
                </tr>
            </table>
            <hr size="1">
        ';
        // TABLE DATA
        $html .= '
            <br>
            <table width="100" cellspacing="0" cellpadding="0" align="center">
                <thead>
                    <tr>
                        <th width="30" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">No.</th>
                        <th width="120" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Tanggal Transaksi</th>
                        <th width="400" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Deskripsi</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Debet</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;padding:5px;">Credit</th>
                        <th width="130" align="center" style="background:#EEE;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;padding:5px;">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody>
                ';

        for ($i = 0; $i < count($data['data']); $i++) {
            $html .= '
                    <tr>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">' . $data['data'][$i]['nomor'] . '</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="center">' . (($data['data'][$i]['trx_date'] == "") ? "" : $this->format_date_detail($data['data'][$i]['trx_date'], 'id', false, '/')) . '</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC; white-space:normal; width:400px;">' . $data['data'][$i]['description'] . '</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">' . (($data['data'][$i]['debit'] == "") ? '' : number_format($data['data'][$i]['debit'], 2, ',', '.')) . '</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">' . (($data['data'][$i]['credit'] == "") ? '' : number_format($data['data'][$i]['credit'], 2, ',', '.')) . '</td>
                        <td style="font-size:12px;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;" align="right">' . number_format($data['data'][$i]['saldo_akhir'], 2, ',', '.') . '</td>
                    </tr>
            ';
        }

        $html .= '
                    <tr>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" colspan="3" align="right">Total</td>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">' . number_format($data['total_debit'], 2, ',', '.') . '</td>
                        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;" align="right">' . number_format($data['total_credit'], 2, ',', '.') . '</td>
                        <td style="padding:5px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;"></td>
                    </tr>
        ';

        $html .= '
                </tbody>
            </table>
            </page>
        ';

        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN GL INQUIRY.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_semua_cabang($from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['branch_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA CABANG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA BY CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_cabang($cabang, $from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['branch_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY CABANG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_rembug_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA REMBUG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_semua_cabang($from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['cm_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_rembug_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA BY REMBUG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_rembug_cabang($cabang, $from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['cm_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_petugas_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA PETUGAS</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_semua_cabang($from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['fa_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY SEMUA PETUGAS.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_transaksi_rembug_by_petugas_cabang()
    {
        $cabang = $this->uri->segment(3);
        $from_date = ($this->uri->segment(4) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(4), '-');
        $desc_from_date = ($from_date == "") ? "" : $this->format_date_detail($from_date, 'id', false, '/');
        $thru_date = ($this->uri->segment(5) == "-") ? "" : $this->datepicker_convert(false, $this->uri->segment(5), '-');
        $desc_thru_date = ($thru_date == "") ? "" : $this->format_date_detail($thru_date, 'id', false, '/');

        ob_start();

        $html = '
        <h3 align="center">LAPORAN REKAP TRANSAKSI ANGGOTA</h3>
        <h3 align="center" style="margin-top:0;">SEMUA CABANG</h3>
        <table style="padding-left:20px;">
            <tr>
                <td>Tanggal</td>
                <td>:</td>
                <td>' . $desc_from_date . ' s.d ' . $desc_thru_date . '</td>
            </tr>
        </table>
        ';

        $html .= '<div style="font-size:12px;margin-top:10px;">
        <table cellspacing="0" cellpadding="0" align="center">
        <tr>
        <td style="font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;border-top:solid 1px #CCC;vertical-align:middle;padding:4px;text-align:center;width:190px;" rowspan="2">Keterangan</td>
        <td colspan="5" style="font-weight:bold;border:solid 1px #CCC;padding:5px;border-right:0 solid transparent;text-align:center">SETORAN</td>
        <td colspan="2" style="font-weight:bold;border:solid 1px #CCC;padding:5px;text-align:center">PENARIKAN</td>
        </tr>
        <tr>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Pokok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Margin</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Catab</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Wajib</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">Tabungan Kelompok</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;width:100px;">DROPING</td>
        <td style="vertical-align:middle;font-weight:bold;border-left:solid 1px #CCC;border-bottom:solid 1px #CCC;padding:4px;text-align:center;border-right:solid 1px #CCC;width:100px;">SUKARELA</td>
        </tr>
        ';

        $datas = $this->model_laporan_to_pdf->get_data_rekap_transaksi_rembug_by_petugas_cabang($cabang, $from_date, $thru_date);
        $total_angsuran_pokok = 0;
        $total_angsuran_margin = 0;
        $total_angsuran_catab = 0;
        $total_tab_wajib_cr = 0;
        $total_tab_sukarela_db = 0;
        $total_droping = 0;
        $total_tab_kelompok_cr = 0;
        for ($i = 0; $i < count($datas); $i++) {

            $total_angsuran_pokok += $datas[$i]['angsuran_pokok'];
            $total_angsuran_margin += $datas[$i]['angsuran_margin'];
            $total_angsuran_catab += $datas[$i]['angsuran_catab'];
            $total_tab_wajib_cr += $datas[$i]['tab_wajib_cr'];
            $total_tab_sukarela_db += $datas[$i]['tab_sukarela_db'];
            $total_droping += $datas[$i]['droping'];
            $total_tab_kelompok_cr += $datas[$i]['tab_kelompok_cr'];

            $html .= '
            <tr>
            <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . $datas[$i]['fa_name'] . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_pokok'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_margin'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['angsuran_catab'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_wajib_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['tab_kelompok_cr'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;">' . number_format($datas[$i]['droping'], 0, ',', '.') . '</td>
            <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;border-right:solid 1px #CCC;">' . number_format($datas[$i]['tab_sukarela_db'], 0, ',', '.') . '</td>
            </tr>';
        }
        $html .= '
        <tr>
        <td style="padding:3px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;text-align:right;font-weight:bold;">Total:</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_pokok, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_margin, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_angsuran_catab, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_wajib_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_tab_kelompok_cr, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;">' . number_format($total_droping, 0, ',', '.') . '</td>
        <td style="text-align:right;padding:4px;border-bottom:solid 1px #CCC;border-left:solid 1px #CCC;font-weight:bold;border-right:solid 1px #CCC;">' . number_format($total_tab_sukarela_db, 0, ',', '.') . '</td>
        </tr>';

        $html .= '
        </table></div>
        ';
        echo $html;

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('LAPORAN REKAP TRANSAKSI REMBUG FILTERED BY PETUGAS.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /**********************************************************************************************************/
    // BEGIN EXPORT KARTU PENGAWASAN ANGSURAN
    /**********************************************************************************************************/
    function export_kartu_pengawasan_angsuran()
    {
        $account_financing_no = $this->uri->segment(3);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data_cif = $this->model_laporan->get_cif_by_account_financing_no($account_financing_no);
        $cif_no = $data_cif['cif_no'];
        $cif_type = $data_cif['cif_type'];

        $datas['data'] = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);

        $financing_type = $datas['data']['financing_type'];

        if (isset($datas['data']['nama'])) {
            $datass = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);

            $html = '';
            $no = 1;
            $tgl_angsur = '';

            foreach ($datass as $data) {
                $jumlah_angsur = $data['jumlah_angsuran'];
                $pokok = $data['pokok'];

                for ($i = 0; $i < $data['jangka_waktu']; $i++) {
                    if ($i == 0) {
                        $tgl_angsur = $data['tanggal_mulai_angsur'];
                    } else {
                        if ($data['periode_jangka_waktu'] == 0) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
                        } else if ($data['periode_jangka_waktu'] == 1) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
                        } else if ($data['periode_jangka_waktu'] == 2) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 month"));
                        } else if ($data['periode_jangka_waktu'] == 3) {
                            $tgl_angsur = $data['tgl_jtempo'];
                        }

                        $iJto = 1;
                        do {
                            $cekHariLibur = $this->model_laporan->cek_libur($tgl_angsur);

                            if ($cekHariLibur == TRUE) {
                                if ($data['periode_jangka_waktu'] == 0) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
                                } else if ($data['periode_jangka_waktu'] == 1) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
                                } else if ($data['periode_jangka_waktu'] == 2) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 month"));
                                } else if ($data['periode_jangka_waktu'] == 3) {
                                    $tgl_angsur = $data['tgl_jtempo'];
                                }
                                $iJto++;
                            } else {
                                break;
                            }
                        } while ($iJto > 1);
                    }

                    $pokok -= $data['angsuran_pokok'];

                    $historycm = $this->model_laporan->get_history_cm_trx_date_by_account_financing_no($account_financing_no, $no, $financing_type, $tgl_angsur);

                    $tgl_bayar = (isset($historycm['trx_date'])) ? (date('d-m-Y', strtotime($historycm['trx_date']))) : '';

                    $validasi = (isset($historycm['validasi'])) ? ($historycm['validasi']) : '';

                    $html .= '<tr>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . date("d-m-Y", strtotime($tgl_angsur)) . '</td>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $tgl_bayar . '</td>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $no . '</td>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($jumlah_angsur, 0, ',', '.') . '</td>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($pokok, 0, ',', '.') . '</td>
                                  <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . $validasi . '</td>
                              </tr>';
                    $no++;
                }
            }
            $datas['row_angsuran'] = $html;
        } else {
            $datas['row_angsuran'] = '';
        }



        $this->load->view('laporan/export_kartu_pengawasan_angsuran', $datas);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('kartu_pengawasan_angsuran"' . $cif_no . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /**********************************************************************************************************/
    // END EXPORT KARTU PENGAWASAN ANGSURAN
    /**********************************************************************************************************/

    /**********************************************************************************************************/
    // BEGIN EXPORT KARTU PENGAWASAN ANGSURAN LENGKAP
    /**********************************************************************************************************/
    function export_kartu_pengawasan_angsuran_lengkap()
    {
        $account_financing_no = $this->uri->segment(3);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data_cif = $this->model_laporan->get_cif_by_account_financing_no($account_financing_no);
        $cif_no = $data_cif['cif_no'];
        $cif_type = $data_cif['cif_type'];

        $datas['data'] = $this->model_laporan->get_kartu_pengawasan_angsuran_by_account_no($account_financing_no);

        $financing_type = $datas['data']['financing_type'];

        if (isset($datas['data']['nama'])) {
            $datass = $this->model_laporan->get_row_pembiayaan_by_account_no($account_financing_no);

            $html = '';
            $no = 1;
            $tgl_angsur = '';

            foreach ($datass as $data) {
                $jumlah_angsur = $data['jumlah_angsuran'];
                $pokok = $data['pokok'];
                $margin = $data['margin'];
                $catab = 0;

                for ($i = 0; $i < $data['jangka_waktu']; $i++) {
                    if ($i == 0) {
                        $tgl_angsur = $data['tanggal_mulai_angsur'];
                    } else {
                        if ($data['periode_jangka_waktu'] == 0) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
                        } else if ($data['periode_jangka_waktu'] == 1) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
                        } else if ($data['periode_jangka_waktu'] == 2) {
                            $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 month"));
                        } else if ($data['periode_jangka_waktu'] == 3) {
                            $tgl_angsur = $data['tgl_jtempo'];
                        }

                        $iJto = 1;
                        do {
                            $cekHariLibur = $this->model_laporan->cek_libur($tgl_angsur);

                            if ($cekHariLibur == TRUE) {
                                if ($data['periode_jangka_waktu'] == 0) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 day"));
                                } else if ($data['periode_jangka_waktu'] == 1) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 7 day"));
                                } else if ($data['periode_jangka_waktu'] == 2) {
                                    $tgl_angsur = date("Y-m-d", strtotime($tgl_angsur . " + 1 month"));
                                } else if ($data['periode_jangka_waktu'] == 3) {
                                    $tgl_angsur = $data['tgl_jtempo'];
                                }
                                $iJto++;
                            } else {
                                break;
                            }
                        } while ($iJto > 1);
                    }

                    $pokok -= $data['angsuran_pokok'];
                    $margin -= $data['angsuran_margin'];
                    $catab += $data['angsuran_catab'];

                    $historycm = $this->model_laporan->get_history_cm_trx_date_by_account_financing_no($account_financing_no, $no, $financing_type, $tgl_angsur);

                    $tgl_bayar = (isset($historycm['trx_date'])) ? (date('d-m-Y', strtotime($historycm['trx_date']))) : '';

                    $validasi = (isset($historycm['validasi'])) ? ($historycm['validasi']) : '';

                    $html .= '<tr>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . date("d-m-Y", strtotime($tgl_angsur)) . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $tgl_bayar . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $no . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($jumlah_angsur, 0, ',', '.') . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($pokok, 0, ',', '.') . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($margin, 0, ',', '.') . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:right;">' . number_format($catab, 0, ',', '.') . '</td>
                              <td style="border-left:solid 1px #CCC;border-right:solid 1px #CCC;border-top:solid 1px #CCC;border-bottom:solid 1px #CCC; padding:5px; padding:5px; text-align:center;">' . $validasi . '</td>
                          </tr>';
                    $no++;
                }
            }
            $datas['row_angsuran'] = $html;
        } else {
            $datas['row_angsuran'] = '';
        }



        $this->load->view('laporan/export_kartu_pengawasan_angsuran_lengkap', $datas);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('kartu_pengawasan_angsuran"' . $cif_no . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /**********************************************************************************************************/
    // END EXPORT KARTU PENGAWASAN ANGSURAN LENGKAP
    /**********************************************************************************************************/

    /****************************************************************************/
    //BEGIN CETAK AKAN PEMBIAYAAN Ade Sagita 18-08-2014
    /****************************************************************************/
    public function cetak_akad_pembiayaan()
    {

        $account_financing_id  = $this->uri->segment(3);

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['institution']    = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_get_institution();
        $data['cetak']          = $this->model_laporan_to_pdf->cetak_akad_pembiayaan_data($account_financing_id);

        $this->load->view('laporan/export_cetak_akad_pembiayaan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('cetak_akad_pembiayaan".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END CETAK AKAN PEMBIAYAAN
    /****************************************************************************/

    /*
    Modul : Laporan Rekapitulasi NPL
    author : Sayyid
    date : 2014-11-17 16:20
    */

    public function export_rekapitulasi_npl()
    {
        $cabang = $this->uri->segment(3);
        $tanggal_hitung = $this->uri->segment(4);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl($cabang, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $data['branch_class_filter'] = $branch['branch_class'];

        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));


        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $this->load->view('laporan/export_rekapitulasi_npl', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekapitulasi_npl_petugas()
    {
        $cabang = $this->uri->segment(3);
        $tanggal_hitung = $this->uri->segment(4);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl_by_petugas($cabang, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $data['branch_class_filter'] = $branch['branch_class'];

        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $this->load->view('laporan/export_rekapitulasi_npl_petugas', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    function export_rekapitulasi_npl_rembug()
    {
        $cabang = $this->uri->segment(3);
        $tanggal_hitung = $this->uri->segment(4);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl_by_rembug($cabang, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_class = $branch['branch_class'];

        $data['branch_class_filter'] = $branch['branch_class'];

        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $this->load->view('laporan/export_rekapitulasi_npl_rembug', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl_rembug".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekapitulasi_npl_produk()
    {
        $cabang = $this->uri->segment(3);
        $tanggal_hitung = $this->uri->segment(4);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl_by_produk($cabang, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $data['branch_class_filter'] = $branch['branch_class'];

        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $this->load->view('laporan/export_rekapitulasi_npl_produk', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekapitulasi_npl_peruntukan()
    {
        $cabang = $this->uri->segment(3);
        $tanggal_hitung = $this->uri->segment(4);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl_by_peruntukan($cabang, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $data['branch_class_filter'] = $branch['branch_class'];

        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $this->load->view('laporan/export_rekapitulasi_npl_peruntukan', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekapitulasi_npl2()
    {
        $cabang = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $cm_code = $this->uri->segment(5);
        $tanggal_hitung = $this->uri->segment(6);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_npl2($cabang, $fa_code, $cm_code, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }
        $data['branch_class'] = $branch['branch_class'];
        $this->load->view('laporan/export_rekapitulasi_npl2', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'LEGAL', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekapitulasi_kol()
    {
        $cabang = $this->uri->segment(3);
        $kol = $this->uri->segment(4);
        $tanggal_hitung = $this->uri->segment(5);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_kol($cabang, $kol, $tanggal_hitung);


        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);


        $data['tanggal'] = date('d-m-Y', strtotime($tanggal_hitung));

        // echo "<pre>";
        // print_r($tanggal);
        // echo "</pre>";
        // die();

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }



        $this->load->view('laporan/export_rekapitulasi_kol', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekapitulasi_kol2()
    {
        $cabang = $this->uri->segment(3);
        $kol = $this->uri->segment(4);
        $tanggal_hitung = $this->uri->segment(5);
        $datas = $this->model_laporan_to_pdf->export_rekapitulasi_kol2($cabang, $kol, $tanggal_hitung);
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['result'] = $datas;

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
                $nama_cabang = 'CABANG ' . $data['cabang'];
            }
        } else {
            $data['cabang'] = "PUSAT ";
            $nama_cabang = "PUSAT ";
        }

        // echo "<pre>";
        // print_r($datas);
        // echo "</pre>";
        // die();

        $this->load->view('laporan/export_rekapitulasi_kol2', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekapitulasi_npl2".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function neraca_saldo_gl2()
    {
        $branch_code = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $jenis = $this->uri->segment(5);
        $user_id = $this->session->userdata('user_id');

        $from_tanggal = substr($tanggal, 0, 2);
        $from_bulan = substr($tanggal, 2, 2);
        $from_tahun = substr($tanggal, -4);

        if ($jenis == 'BL') {
            $from = $from_tahun . '-' . $from_bulan . '-' . $from_tanggal;
            $thru = date('Y-m-d', strtotime($from . ' + 1 MONTH - 1 DAY'));
        } else {
            $from = $from_tahun . '-' . $from_bulan . '-01';
            $thru = $from_tahun . '-' . $from_bulan . '-' . $from_tanggal;
        }

        $startGetClosing = $from_tahun . '-' . $from_bulan . '-01';
        $fromlm = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));

        $periode = $this->model_laporan->get_periode_now();
        $periode_awal = $periode['periode_awal'];
        $periode_akhir = $periode['periode_akhir'];

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];

        if ($from < $periode_awal or $thru < $periode_awal) {
            $datas = $this->model_laporan->saldo_bulan_lalu($branch_code, $from, $thru);
        } else {
            if ($from_bulan == '01') {
                $flag_akhir_tahun = 'Y';
            } else {
                $flag_akhir_tahun = 'T';
            }
            $this->model_laporan_to_pdf->insert_temp($branch_code, $fromlm, $from, $thru, $user_id, $flag_akhir_tahun);
            $datas = $this->model_laporan->saldo_bulan_ini($branch_code, $user_id);
        }

        $total_debit = 0;
        $total_credit = 0;
        $ii = 0;
        $group_name = '';
        for ($i = 0; $i < count($datas); $i++) {
            $group = $this->model_laporan->get_account_group_by_code($datas[$i]['account_group_code']);
            if (count($group) > 0) {
                if ($group_name != $group['group_name']) {
                    $group_name = $group['group_name'];
                    $data['data'][$ii]['nomor'] = '';
                    $data['data'][$ii]['saldo_awal'] = '';
                    $data['data'][$ii]['account'] = $group_name;
                    $data['data'][$ii]['debit'] = '';
                    $data['data'][$ii]['credit'] = '';
                    $data['data'][$ii]['saldo_akhir'] = '';
                    $ii++;
                }
            } else {
                $group_name = '';
            }

            $data['data'][$ii]['nomor'] = $i + 1;
            $data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
            $data['data'][$ii]['account'] = $datas[$i]['account_code'] . ' - ' . $datas[$i]['account_name'];
            $data['data'][$ii]['debit'] = $datas[$i]['debit'];
            $data['data'][$ii]['credit'] = $datas[$i]['credit'];
            $data['data'][$ii]['saldo_akhir'] = $datas[$i]['saldo_akhir'];

            $total_debit  += $datas[$i]['debit'];
            $total_credit += $datas[$i]['credit'];
            if (count($group) > 0) {
                $group_name = $group['group_name'];
            }
            $ii++;
        }
        $data['total_debit'] = $total_debit;
        $data['total_credit'] = $total_credit;

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['branch_name'] = $branch_name;
        $data['periode1'] = $from;
        $data['periode2'] = $thru;
        $this->load->view('laporan/pdf_neraca_saldo_gl', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Trial_Balance_' . date('YmdHis') . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /////////////////rekap_mutasi_gl///////////////////////
    public function rekap_mutasi_gl()
    {
        $from_date = $this->uri->segment(3);
        $thru_date = $this->uri->segment(4);
        $branch_code = $this->uri->segment(5);

        $from_date = str_replace('/', '', $from_date);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date = str_replace('/', '', $thru_date);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
        $branch_name = $branch['branch_name'];
        $datas = $this->model_laporan->get_rekap_mutasi_gl($branch_code, $from_date, $thru_date);
        $total_debit = 0;
        $total_credit = 0;
        $ii = 0;
        $group_name = '';
        $data['data'][$ii]['nomor'] = '&nbsp;';
        $data['data'][$ii]['account'] = '&nbsp;';
        // $data['data'][$ii]['saldo_awal'] = 0;
        $data['data'][$ii]['debit'] = 0;
        $data['data'][$ii]['credit'] = 0;
        // $data['data'][$ii]['saldo_akhir'] = 0;
        for ($i = 0; $i < count($datas); $i++) {
            $data['data'][$ii]['nomor'] = $i + 1;
            // $data['data'][$ii]['saldo_awal'] = $datas[$i]['saldo_awal'];
            $data['data'][$ii]['account'] = $datas[$i]['account_code'] . ' - ' . $datas[$i]['account_name'];
            $data['data'][$ii]['debit'] = $datas[$i]['debit'];
            $data['data'][$ii]['credit'] = $datas[$i]['credit'];
            // $data['data'][$ii]['saldo_akhir'] = $datas[$i]['saldo_awal']+$datas[$i]['debit']-$datas[$i]['credit'];

            $total_debit  += $datas[$i]['debit'];
            $total_credit += $datas[$i]['credit'];

            $ii++;
        }
        $data['total_debit'] = $total_debit;
        $data['total_credit'] = $total_credit;

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['branch_name'] = $branch_name;
        $data['from_date'] = $from_date;
        $data['thru_date'] = $thru_date;
        $this->load->view('laporan/pdf_rekap_mutasi_gl', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('rekap_mutasi_gl' . date('YmdHis') . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /////////////////End rekap_mutasi_gl///////////////////////


    public function export_lap_lr_rinci()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);

        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($cabang == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang != '00000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                // if($branch['branch_class']=="1"){
                //     $data['cabang'] .= " (Perwakilan)";
                // }
            } else {
                $data['cabang'] = "PUSAT";
            }

            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi_rinci($cabang, $from_date, $last_date);
            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/pdf_laba_rugi_rinci_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_laba_rugi_rinci_gl".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_lap_lr_rinci_v2()
    {
        $cabang = $this->uri->segment(3);
        $periode_bulan = $this->uri->segment(4);
        $periode_tahun = $this->uri->segment(5);
        $periode_hari = $this->uri->segment(6);

        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;

        if ($cabang == "") {
            echo "<script>alert('Mohon pilih kantor cabang terlebih dahulu !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode belum dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            if ($cabang != '00000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
                // if($branch['branch_class']=="1"){
                //     $data['cabang'] .= " (Perwakilan)";
                // }
            } else {
                $data['cabang'] = "PUSAT";
            }

            $data['report_item'] = $this->model_laporan_to_pdf->export_lap_laba_rugi_rinci_v2($cabang, $from_date, $last_date);
            $data['last_date'] = $last_date;
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $this->load->view('laporan/pdf_laba_rugi_rinci_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_laba_rugi_rinci_gl".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /*
    public function export_neraca_rinci_gl()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari  = $this->uri->segment(6);
        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun.'-'.$periode_bulan.'-01';
        $last_date = $periode_tahun.'-'.$periode_bulan.'-'.$periode_hari;
        if ($branch_code=="") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        }else if ($periode_bulan=="" && $periode_tahun=="") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        }else{

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_rinci_gl2($branch_code,$last_date);
            if ($branch_code !='00000'){
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                // if($branch['branch_class']=="1"){
                //     $data['branch_name'] .= " (Perwakilan)";
                // }
            }else{
                $data['branch_name'] = "PUSAT";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/pdf_neraca_rinci_gl',$data);
            $content = ob_get_clean();
            try
            {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_neraca_rinci_gl"'.$branch_code.'".pdf');
            }
            catch(HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
*/
    public function export_neraca_rinci_gl()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari  = $this->uri->segment(6);
        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;
        if ($branch_code == "") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_rinci_gl2($branch_code, $last_date);
            if ($branch_code != '00000') {
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                // if($branch['branch_class']=="1"){
                //     $data['branch_name'] .= " (Perwakilan)";
                // }
            } else {
                $data['branch_name'] = "PUSAT";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/pdf_neraca_rinci_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_neraca_rinci_gl"' . $branch_code . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    public function export_neraca_rinci_gl_v2()
    {
        $branch_code  = $this->uri->segment(3);
        $periode_bulan  = $this->uri->segment(4);
        $periode_tahun  = $this->uri->segment(5);
        $periode_hari  = $this->uri->segment(6);
        // $from_date = $this->get_from_trx_date();
        $from_date = $periode_tahun . '-' . $periode_bulan . '-01';
        $last_date = $periode_tahun . '-' . $periode_bulan . '-' . $periode_hari;
        if ($branch_code == "") {
            echo "<script>alert('Cabang Belum Dipilih !');javascript:window.close();</script>";
        } else if ($periode_bulan == "" && $periode_tahun == "") {
            echo "<script>alert('Periode Belum Dipilih !');javascript:window.close();</script>";
        } else {

            $branch_id = $this->model_cif->get_branch_id_by_branch_code($branch_code);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            ob_start();
            $config['full_tag_open'] = '<p>';
            $config['full_tag_close'] = '</p>';
            // $from_periode = $periode_tahun.'-'.$periode_bulan.'-01';
            $data['result'] = $this->model_laporan_to_pdf->export_neraca_rinci_gl_v2($branch_code, $last_date);
            if ($branch_code != '00000') {
                $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
                // if($branch['branch_class']=="1"){
                //     $data['branch_name'] .= " (Perwakilan)";
                // }
            } else {
                $data['branch_name'] = "PUSAT";
            }
            $data['branch_class'] = $branch['branch_class'];
            $data['branch_officer_name'] = $branch['branch_officer_name'];
            $data['last_date'] = $last_date;
            $this->load->view('laporan/pdf_neraca_rinci_gl', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('pdf_neraca_rinci_gl"' . $branch_code . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    function export_list_angsuran_pembiayaan()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        $kreditur = $this->uri->segment(10);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $data['jenis'] = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            // $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $data['jenis'] = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $data['jenis'] = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($majelis == '00000') {
            $data['post_majelis'] = 'SEMUA';
        } else {
            $get_majelis = $this->model_cif->get_majelis($majelis);
            $data['post_majelis'] = $get_majelis['cm_name'];
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_account_cash_code($petugas);
            $fa = $getPetugas['account_cash_name'];
        }

        if ($kreditur == '00000') {
            $data['post_kreditur'] = 'SEMUA';
        } else {
            $get_kreditur = $this->model_laporan->get_kreditur_by_code($kreditur);
            $data['post_kreditur'] = $get_kreditur['display_text'];
        }


        if ($pembiayaan == 0) {
            //kelompok
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_kelompok($from, $thru, $cabang, $majelis, $petugas, $produk, $kreditur);
        } else if ($pembiayaan == 1) {
            //individu
            $datas = $this->model_laporan_to_pdf->export_list_angsuran_pembiayaan_individu($from, $thru, $cabang, $majelis, $petugas, $produk, $kreditur);
        }

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;
        #$data['petugas'] = $fa;

        if ($pembiayaan == 0) {

            $this->load->view('laporan/export_list_angsuran_pembiayaan', $data);
        } else if ($pembiayaan == 1) {
            $this->load->view('laporan/export_list_angsuran_pembiayaan_individu', $data);
        }


        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            ob_get_clean();
            $html2pdf->Output('Laporan Angsuran Pembiayaan (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    function export_list_proyeksi_angsuran()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);
        $kreditur = $this->uri->segment(10);
        $jenispyd = $this->uri->segment(11);
        $user_id = $this->session->userdata('user_id');

        $datas = $this->model_laporan_to_pdf->export_list_proyeksi_angsuran($from, $thru, $cabang, $majelis, $pembiayaan, $petugas, $produk, $kreditur);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $data['jenis'] = 'Individu';
            $jenis2 = strtoupper($jenis);
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $data['jenis'] = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $data['jenis'] = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($kreditur == '00000') {
            $data['post_kreditur'] = 'SEMUA';
        } else {
            $get_kreditur = $this->model_laporan->get_kreditur_by_code($kreditur);
            $data['post_kreditur'] = $get_kreditur['display_text'];
            #$data['post_kreditur'] = 'SEMUA';
        }

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $data['result'] = $datas;
        $data['from'] = $from;
        $data['thru'] = $thru;

        $this->load->view('laporan/export_list_proyeksi_angsuran', $data);


        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            ob_get_clean();
            $html2pdf->Output('Laporan Proyeksi Angsuran (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }



    public function statement_tab_kelompok()
    {
        $filename = "STATEMENT TAB KELOMPOK.pdf";

        $cm_code = $this->uri->segment(3);
        $cif_no = $this->uri->segment(4);
        $tabungan = $this->uri->segment(5);
        $no_rekening = $this->uri->segment(6);
        $tanggal1 = $this->uri->segment(7);
        $tanggal2 = $this->uri->segment(8);
        $exp1 = explode('-', $tanggal1);
        $exp2 = explode('-', $tanggal2);
        $from_date = $exp1[2] . '-' . $exp1[1] . '-' . $exp1[0];
        $thru_date = $exp2[2] . '-' . $exp2[1] . '-' . $exp2[0];
        // echo $from_date.' + '.$thru_date;die();

        $datas['nama'] = $this->model_laporan->get_name_and_cm_by_cif_no($cif_no);
        $datas['cif'] = $cif_no;
        $datas['from_date'] = $tanggal1;
        $datas['thru_date'] = $tanggal2;
        $datas['no_rekening'] = $no_rekening;
        $datas['tabungan'] = $tabungan;

        $bValid = false;
        // QUERY BERDASARKAN JENIS TABUNGAN
        if ($tabungan == 'tab_wajib') {
            $bValid = true;
            $datas['saldo_awal'] = $this->model_laporan->get_saldo_awal_tab_wajib_kelompok($cif_no, $from_date);
            $datas['credit'] = $this->model_laporan->get_statement_tab_kelompok_tab_wajib($cif_no, $from_date, $thru_date);
            $view = 'laporan/export_statement_tab_kelompok_tab_wajib';
        } else if ($tabungan == 'tab_kelompok') {
            $bValid = true;
            $datas['saldo_awal'] = $this->model_laporan->get_saldo_awal_tab_kel_kelompok($cif_no, $from_date);
            $datas['credit'] = $this->model_laporan->get_statement_tab_kelompok_tab_kel($cif_no, $from_date, $thru_date);
            $view = 'laporan/export_statement_tab_kelompok_tab_kel';
        } else if ($tabungan == 'sim_wajib') {
            $bValid = true;
            $datas['saldo_awal'] = $this->model_laporan->get_saldo_awal_sim_wajib($cif_no, $from_date);
            $datas['credit'] = $this->model_laporan->get_statement_tab_kelompok_sim_wajib($cif_no, $from_date, $thru_date);
            $view = 'laporan/export_statement_tab_kelompok_sim_wajib';
        } else if ($tabungan == 'tab_sukarela') {
            $bValid = true;
            $datas['saldo_awal'] = $this->model_laporan->get_saldo_awal_tab_sukarela($cif_no, $from_date);
            $datas['datas'] = $this->model_laporan->get_statement_tab_kelompok_tab_sukarela($cif_no, $from_date, $thru_date);
            $view = 'laporan/export_statement_tab_kelompok_tab_sukarela';
        } else if ($tabungan == 'tab_berencana') {
            $bValid = true;
            $datas['saldo_awal'] = $this->model_laporan->get_saldo_awal_tab_berencana($no_rekening, $from_date);
            $datas['datas'] = $this->model_laporan->get_statement_tab_kelompok_tab_berencana($no_rekening, $from_date, $thru_date);
            $view = 'laporan/export_statement_tab_kelompok_tab_berencana';
        }
        // END QUERY BERDASARKAN JENIS TABUNGAN

        ob_start();
        if ($bValid == true) {
            $this->load->view($view, $datas);
        } else {
            show_404();
        }

        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output($filename);
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    public function statement_kehadiran()
    {
        $filename = "STATEMENT KEHADIRAN.pdf";
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);
        $cif_no = $this->uri->segment(5);
        $tanggal1 = $this->uri->segment(6);
        $tanggal2 = $this->uri->segment(7);
        $exp1 = explode('-', $tanggal1);
        $exp2 = explode('-', $tanggal2);
        $from_date = $exp1[2] . '-' . $exp1[1] . '-' . $exp1[0];
        $thru_date = $exp2[2] . '-' . $exp2[1] . '-' . $exp2[0];
        // echo $from_date.' + '.$thru_date;die(); 

        $datas['branch'] = $this->model_laporan->get_branch_by_code($branch_code);
        $datas['anggota'] = $this->model_laporan->get_name_and_cm_by_cif_no($cif_no);
        $datas['cif'] = $cif_no;
        $datas['from_date'] = $tanggal1;
        $datas['thru_date'] = $tanggal2;

        $bValid = false;

        $bValid = true;
        ///$datas['datas'] = $this->model_laporan->get_statement_tab_kelompok_tab_sukarela($cif_no,$from_date,$thru_date);
        ///$view = 'laporan/export_statement_tab_kelompok_tab_sukarela';

        $datas['datas'] = $this->model_laporan->get_statement_kehadiran($cif_no, $from_date, $thru_date);
        $view = 'laporan/export_statement_kehadiran';


        ob_start();
        if ($bValid == true) {
            $this->load->view($view, $datas);
        } else {
            show_404();
        }

        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output($filename);
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function rekap_trx_rembug()
    {
        $branch_code = $this->uri->segment(3);
        $fa_code = $this->uri->segment(4);
        $hari = $this->uri->segment(5);
        $tanggal = $this->uri->segment(6);
        $tanggal = $this->datepicker_convert(true, $tanggal, '-');
        $branch = $this->uri->segment(7);
        $majelis = $this->uri->segment(8);

        $data_rembug = $this->model_laporan->get_rembug_by_fa_code_hari($fa_code, $hari, $majelis);
        ob_start();

        for ($x = 0; $x < count($data_rembug); $x++) {
            $cm_code = $data_rembug[$x]['cm_code'];
            $cm = $data_rembug[$x]['cm_name'];
<<<<<<< HEAD
            $desa = $data_rembug[$x]['desa'];
=======
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

            $rows = $this->model_transaction->get_trx_rembug_data($cm_code, $tanggal);
            $i = 0;
            $data['data'] = array();
            $data['tab_berencana'] = array();
            foreach ($rows as $row) {
                $data_tabungan_berencana = $this->model_transaction->get_tabungan_berencana_by_cif_no3($row['cif_no']);
                $data['tab_berencana'][$i] = $data_tabungan_berencana;
                if (count($data_tabungan_berencana) > 0) {
                    for ($j = 0; $j < count($data_tabungan_berencana); $j++) {
                        if ($j == 0) {
                            $data['data'][$i]['no_urut'] = ($row['kelompok'] == null) ? 0 : $row['kelompok'];
                            $data['data'][$i]['cif_id'] = ($row['cif_id'] == null) ? 0 : $row['cif_id'];
                            $data['data'][$i]['cm_code'] = ($row['cm_code'] == null) ? 0 : $row['cm_code'];
                            $data['data'][$i]['cif_no'] = ($row['cif_no'] == null) ? 0 : $row['cif_no'];
                            $data['data'][$i]['nama'] = ($row['nama'] == null) ? 0 : $row['nama'];
                            $data['data'][$i]['account_financing_no'] = ($row['account_financing_no'] == null) ? '' : $row['account_financing_no'];
                            $data['data'][$i]['tabungan_minggon'] = ($row['tabungan_minggon'] == null) ? 0 : $row['tabungan_minggon'];
                            $data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela'] == null) ? 0 : $row['tabungan_sukarela'];
                            $data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk'] == null) ? 0 : $row['setoran_lwk'];
                            $data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain'] == null) ? 0 : $row['transaksi_lain'];
                            $data['data'][$i]['angsuran'] = ($row['angsuran'] == null) ? 0 : $row['angsuran'];
                            $data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan'] == null) ? 0 : $row['pokok_pembiayaan'];
                            $data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan'] == null) ? 0 : $row['margin_pembiayaan'];
                            $data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan'] == null) ? 0 : $row['catab_pembiayaan'];
<<<<<<< HEAD
                            $data['data'][$i]['tanggal_akad'] = ($row['tanggal_akad'] == null) ? 0 : $row['tanggal_akad'];
                            $data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok'] == null) ? 0 : $row['tabungan_kelompok'];
                            $data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran'] == null) ? 0 : $row['jumlah_angsuran'];
                            $data['data'][$i]['pokok'] = '';
                            $data['data'][$i]['droping'] = ($row['droping'] == null) ? 0 : $row['droping'];
=======
                            $data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok'] == null) ? 0 : $row['tabungan_kelompok'];
                            $data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran'] == null) ? 0 : $row['jumlah_angsuran'];
                            $data['data'][$i]['pokok'] = '';
                            $data['data'][$i]['droping'] = '';
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
                            $data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok'] == null) ? 0 : $row['angsuran_pokok'];
                            $data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin'] == null) ? 0 : $row['angsuran_margin'];
                            $data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab'] == null) ? 0 : $row['angsuran_catab'];
                            $data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib'] == null) ? 0 : $row['angsuran_tab_wajib'];
                            $data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok'] == null) ? 0 : $row['angsuran_tab_kelompok'];
                            $data['data'][$i]['adm'] = '';
<<<<<<< HEAD
                            $data['data'][$i]['asuransi'] = ($row['asuransi'] == null) ? 0 : $row['asuransi'];
=======
                            $data['data'][$i]['asuransi'] = '';
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
                            $data['data'][$i]['nick_name'] = ($data_tabungan_berencana[$j]['nick_name'] == null) ? 0 : $data_tabungan_berencana[$j]['nick_name'];
                            $data['data'][$i]['setoran_berencana'] = ($data_tabungan_berencana[$j]['rencana_setoran'] == null) ? 0 : $data_tabungan_berencana[$j]['rencana_setoran'];
                            $data['data'][$i]['taber_saldo_bayar'] = ($data_tabungan_berencana[$j]['rencana_jangka_waktu'] - $data_tabungan_berencana[$j]['counter_angsruan']);
                            $data['data'][$i]['saldo_dtk'] = ($row['saldo_dtk'] == null) ? 0 : $row['saldo_dtk'];
                            $data['data'][$i]['saldo_lwk'] = ($row['saldo_lwk'] == null) ? 0 : $row['saldo_lwk'];
<<<<<<< HEAD
                            $data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan'] == null) ? 0 : $row['setoran_mingguan'] + $row['setoran_lwk'];
=======
                            $data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan'] == null) ? 0 : $row['setoran_mingguan'];
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
                            $data['data'][$i]['margin'] = ($row['margin'] == null) ? 0 : $row['margin'];
                            $data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok'] == null) ? 0 : $row['saldo_pokok'];
                            $data['data'][$i]['saldo_margin'] = ($row['saldo_margin'] == null) ? 0 : $row['saldo_margin'];
                            $data['data'][$i]['saldo_catab'] = ($row['saldo_catab'] == null) ? 0 : $row['saldo_catab'];
                            $data['data'][$i]['status'] = $row['status'];
                            $data['data'][$i]['status_droping'] = $row['status_droping'];
                            $data['data'][$i]['counter_angsuran'] = ($row['freq_saldo_outstanding'] != '') ? $row['counter_angsuran'] : '';
                            $data['data'][$i]['freq_saldo_outstanding'] = $row['freq_saldo_outstanding'];
                            $data['data'][$i]['freq_tunggakan'] = ($row['freq_tunggakan'] > 0) ? $row['freq_tunggakan'] : 0;
                            $i++;
                        } else {
                            $data['data'][$i]['no_urut'] = '';
                            $data['data'][$i]['cif_id'] = '';
                            $data['data'][$i]['cm_code'] = '';
                            $data['data'][$i]['cif_no'] = '';
                            $data['data'][$i]['nama'] = '';
                            $data['data'][$i]['account_financing_no'] = '';
                            $data['data'][$i]['tabungan_minggon'] = '';
                            $data['data'][$i]['tabungan_sukarela'] = '';
                            $data['data'][$i]['saldo_dtk'] = '';
                            $data['data'][$i]['setoran_lwk'] = '';
                            $data['data'][$i]['transaksi_lain'] = '';
                            $data['data'][$i]['angsuran'] = '';
                            $data['data'][$i]['pokok_pembiayaan'] = '';
                            $data['data'][$i]['margin_pembiayaan'] = '';
                            $data['data'][$i]['catab_pembiayaan'] = '';
                            $data['data'][$i]['tanggal_akad'] = '';
                            $data['data'][$i]['tabungan_kelompok'] = '';
                            $data['data'][$i]['jumlah_angsuran'] = '';
                            $data['data'][$i]['pokok'] = '';
                            $data['data'][$i]['droping'] = '';
                            $data['data'][$i]['angsuran_pokok'] = '';
                            $data['data'][$i]['angsuran_margin'] = '';
                            $data['data'][$i]['angsuran_catab'] = '';
                            $data['data'][$i]['angsuran_tab_wajib'] = '';
                            $data['data'][$i]['angsuran_tab_kelompok'] = '';
                            $data['data'][$i]['adm'] = '';
                            $data['data'][$i]['asuransi'] = '';
                            $data['data'][$i]['nick_name'] = ($data_tabungan_berencana[$j]['nick_name'] == null) ? 0 : $data_tabungan_berencana[$j]['nick_name'];
                            $data['data'][$i]['setoran_berencana'] = ($data_tabungan_berencana[$j]['rencana_setoran'] == null) ? 0 : $data_tabungan_berencana[$j]['rencana_setoran'];
                            $data['data'][$i]['taber_saldo_bayar'] = ($data_tabungan_berencana[$j]['rencana_jangka_waktu'] - $data_tabungan_berencana[$j]['counter_angsruan']);
                            $data['data'][$i]['saldo_dtk'] = '';
                            $data['data'][$i]['saldo_lwk'] = '';
                            $data['data'][$i]['setoran_mingguan'] = '';
                            $data['data'][$i]['margin'] = '';
                            $data['data'][$i]['saldo_pokok'] = '';
                            $data['data'][$i]['saldo_margin'] = '';
                            $data['data'][$i]['saldo_catab'] = '';
                            $data['data'][$i]['status'] = '';
                            $data['data'][$i]['status_droping'] = '';
                            $data['data'][$i]['counter_angsuran'] = '';
                            $data['data'][$i]['freq_saldo_outstanding'] = '';
                            $data['data'][$i]['freq_tunggakan'] = '';
                            $i++;
                        }
                    }
                } else {
                    $data['data'][$i]['no_urut'] = ($row['kelompok'] == null) ? 0 : $row['kelompok'];
                    $data['data'][$i]['cif_id'] = ($row['cif_id'] == null) ? 0 : $row['cif_id'];
                    $data['data'][$i]['cm_code'] = ($row['cm_code'] == null) ? 0 : $row['cm_code'];
                    $data['data'][$i]['cif_no'] = ($row['cif_no'] == null) ? 0 : $row['cif_no'];
                    $data['data'][$i]['nama'] = ($row['nama'] == null) ? 0 : $row['nama'];
                    $data['data'][$i]['account_financing_no'] = ($row['account_financing_no'] == null) ? '' : $row['account_financing_no'];
                    $data['data'][$i]['tabungan_minggon'] = ($row['tabungan_minggon'] == null) ? 0 : $row['tabungan_minggon'];
                    $data['data'][$i]['tabungan_sukarela'] = ($row['tabungan_sukarela'] == null) ? 0 : $row['tabungan_sukarela'];
                    $data['data'][$i]['setoran_lwk'] = ($row['setoran_lwk'] == null) ? 0 : $row['setoran_lwk'];
                    $data['data'][$i]['transaksi_lain'] = ($row['transaksi_lain'] == null) ? 0 : $row['transaksi_lain'];
                    $data['data'][$i]['angsuran'] = ($row['angsuran'] == null) ? 0 : $row['angsuran'];
                    $data['data'][$i]['pokok_pembiayaan'] = ($row['pokok_pembiayaan'] == null) ? 0 : $row['pokok_pembiayaan'];
                    $data['data'][$i]['margin_pembiayaan'] = ($row['margin_pembiayaan'] == null) ? 0 : $row['margin_pembiayaan'];
                    $data['data'][$i]['catab_pembiayaan'] = ($row['catab_pembiayaan'] == null) ? 0 : $row['catab_pembiayaan'];
<<<<<<< HEAD
                    $data['data'][$i]['tanggal_akad'] = ($row['tanggal_akad'] == null) ? 0 : $row['tanggal_akad'];
=======
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
                    $data['data'][$i]['tabungan_kelompok'] = ($row['tabungan_kelompok'] == null) ? 0 : $row['tabungan_kelompok'];
                    $data['data'][$i]['jumlah_angsuran'] = ($row['jumlah_angsuran'] == null) ? 0 : $row['jumlah_angsuran'];
                    $data['data'][$i]['pokok'] = '';
                    $data['data'][$i]['droping'] = '';
                    $data['data'][$i]['angsuran_pokok'] = ($row['angsuran_pokok'] == null) ? 0 : $row['angsuran_pokok'];
                    $data['data'][$i]['angsuran_margin'] = ($row['angsuran_margin'] == null) ? 0 : $row['angsuran_margin'];
                    $data['data'][$i]['angsuran_catab'] = ($row['angsuran_catab'] == null) ? 0 : $row['angsuran_catab'];
                    $data['data'][$i]['angsuran_tab_wajib'] = ($row['angsuran_tab_wajib'] == null) ? 0 : $row['angsuran_tab_wajib'];
                    $data['data'][$i]['angsuran_tab_kelompok'] = ($row['angsuran_tab_kelompok'] == null) ? 0 : $row['angsuran_tab_kelompok'];
                    $data['data'][$i]['adm'] = '';
                    $data['data'][$i]['asuransi'] = '';
                    $data['data'][$i]['nick_name'] = '';
                    $data['data'][$i]['setoran_berencana'] = '';
                    $data['data'][$i]['taber_saldo_bayar'] = '';
                    $data['data'][$i]['saldo_dtk'] = ($row['saldo_dtk'] == null) ? 0 : $row['saldo_dtk'];
                    $data['data'][$i]['saldo_lwk'] = ($row['saldo_lwk'] == null) ? 0 : $row['saldo_lwk'];
<<<<<<< HEAD
                    $data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan'] == null) ? 0 : $row['setoran_mingguan'] + $row['setoran_lwk'];
=======
                    $data['data'][$i]['setoran_mingguan'] = ($row['setoran_mingguan'] == null) ? 0 : $row['setoran_mingguan'];
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
                    $data['data'][$i]['margin'] = ($row['margin'] == null) ? 0 : $row['margin'];
                    $data['data'][$i]['saldo_pokok'] = ($row['saldo_pokok'] == null) ? 0 : $row['saldo_pokok'];
                    $data['data'][$i]['saldo_margin'] = ($row['saldo_margin'] == null) ? 0 : $row['saldo_margin'];
                    $data['data'][$i]['saldo_catab'] = ($row['saldo_catab'] == null) ? 0 : $row['saldo_catab'];
                    $data['data'][$i]['status'] = $row['status'];
                    $data['data'][$i]['status_droping'] = $row['status_droping'];
                    $data['data'][$i]['counter_angsuran'] = ($row['freq_saldo_outstanding'] != '') ? $row['counter_angsuran'] : '';
                    $data['data'][$i]['freq_saldo_outstanding'] = $row['freq_saldo_outstanding'];
                    $data['data'][$i]['freq_tunggakan'] = ($row['freq_tunggakan'] > 0) ? $row['freq_tunggakan'] : 0;
                    $i++;
                }
            }

            $data['kas_awal'] = 0;
            $data['cabang'] = $branch;
            $data['majelis'] = $cm . ' - ' . $desa;
            $data['desa'] = $desa;

            if (count($rows) > 0) {
                $this->load->view('transaction/print_form_trx_rembug', $data);
            }
        }

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', array('330', '216'), 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
<<<<<<< HEAD
            $html2pdf->Output('FORM TRANSAKSI REMBUG.pdf');
=======
            $html2pdf->Output('FORMULIR TRANSAKSI REMBUG.pdf');
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_rekap_transaksi_individu()
    {
        $cabang = $this->uri->segment(3);
        $rembug = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $from = $this->datepicker_convert(FALSE, $this->uri->segment(6));
        $thru = $this->datepicker_convert(FALSE, $this->uri->segment(7));

        if ($cabang == '00000') {
            $branch_name = 'SEMUA CABANG';
        } else {
            $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
            $branch = $this->model_cif->get_branch_by_branch_id($branch_id);
            $branch_name = strtoupper($branch['branch_name']);
        }

        if ($rembug == '00000') {
            $cm_name = 'SEMUA MAJELIS';
        } else {
            $cm = $this->model_cif->get_cm_by_cm_code($rembug);
            $cm_name = strtoupper($cm['cm_name']);
        }

        if ($petugas == '00000') {
            $fa_name = 'SEMUA PETUGAS';
        } else {
            $fa = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa_name = strtoupper($fa['fa_name']);
        }

        ob_start();

        $config['full_tag_open']    = '<p>';
        $config['full_tag_close']   = '</p>';

        $data['cabang'] = $branch_name;
        $data['majelis'] = $cm_name;
        $data['petugas'] = $fa_name;
        $data['from'] = $from;
        $data['thru'] = $thru;

        $data['rekap'] = $this->model_laporan_to_pdf->export_rekap_transaksi_individu($cabang, $rembug, $petugas, $from, $thru);

        $this->load->view('laporan/export_rekap_transaksi_individu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_transaksi_individu_' . $from . '-' . $thru . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function laporan_jurnal_transaksi()
    {
        $branch_code = $this->uri->segment(3);
        $from_date = $this->uri->segment(4);
        $thru_date = $this->uri->segment(5);

        $from_date = $this->datepicker_convert(false, $from_date);
        $thru_date = $this->datepicker_convert(false, $thru_date);

        $trx_gl = $this->model_laporan->get_trx_gl($from_date, $thru_date, $branch_code);

        $data['branch_name'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
        $data['from_date'] = $from_date;
        $data['thru_date'] = $thru_date;

        $html = '';
        $no = 1;
        for ($i = 0; $i < count($trx_gl); $i++) {

            $trx_gl_detail = $this->model_laporan->get_trx_gl_detail_by_trx_gl_id($trx_gl[$i]['trx_gl_id']);
            $count = count($trx_gl_detail);
            for ($j = 0; $j < count($trx_gl_detail); $j++) {
                $trx_date = date('d-m-Y', strtotime($trx_gl[$i]['trx_date']));
                $voucher_date = date('d-m-Y', strtotime($trx_gl[$i]['voucher_date']));
                $description = $trx_gl[$i]['description'];
                if ($j > 0) {
                    $trx_date = '';
                    $voucher_date = '';
                    $description    = '';
                    $html2 = '';
                } else {
                    $html2 = '<td rowspan="' . $count . '" style="font-size:10px;vertical-align:top;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;padding:5px;text-align:right;">' . $no . '</td>
                              <td rowspan="' . $count . '" style="font-size:10px;vertical-align:top;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;padding:5px;text-align:center;">' . $trx_date . '</td>
                              <td rowspan="' . $count . '" style="font-size:10px;vertical-align:top;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;padding:5px;text-align:center;">' . $voucher_date . '</td>
                              <td rowspan="' . $count . '" style="font-size:10px;vertical-align:top;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;padding:5px;white-space:normal;width:150px;">' . $description . '</td>';
                    $no++;
                }

                $html .= '<tr>
                            ' . $html2 . '
                            <td style="font-size:10px;padding:5px;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;white-space:normal;width:180px;">' . $trx_gl_detail[$j]['account_name'] . '</td>
                            <td style="font-size:10px;padding:5px;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;text-align:right;">' . number_format($trx_gl_detail[$j]['debit'], 2, ',', '.') . '</td>
                            <td style="font-size:10px;padding:5px;border-bottom:solid 1px #ccc;border-left:solid 1px #ccc;border-right:solid 1px #ccc;text-align:right;">' . number_format($trx_gl_detail[$j]['credit'], 2, ',', '.') . '</td>
                        </tr>';
            }
        }
        $data['html'] = $html;

        ob_start();

        $this->load->view('laporan/pdf_laporan_jurnal_transaksi', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('FORMULIR TRANSAKSI REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /*
    | Laporan Pencairan Tabungan Berencana
    | ujangirawan 29 April 2015
    */
    public function export_lap_pencairan_tabungan_berencana()
    {
        $produk    = $this->uri->segment(3);
        $from_date = $this->uri->segment(4);
        $from_date = substr($from_date, 4, 5) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date = $this->uri->segment(5);
        $thru_date = substr($thru_date, 4, 5) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $cabang = $this->uri->segment(6);
        $rembug = $this->uri->segment(7);


        if ($cabang == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($from_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else if ($thru_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan_to_pdf->export_lap_pencairan_tabungan_berencana($produk, $cabang, $rembug, $from_date, $thru_date);
            ob_start();
            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';
            $data['produk']             = $produk;
            $data['result']             = $datas;
            $data['result']             = $datas;
            if ($cabang != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['tanggal1_'] = $from_date;
            $data['tanggal2_'] = $thru_date;
            $this->load->view('laporan/export_lap_pencairan_tabungan_berencana', $data);
            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_lap_pencairan_tabungan_berencana"' . $from_date . '_"' . $thru_date . '""_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    /*
    | Laporan Pencairan Tabungan Berencana
    | ujangirawan 29 April 2015
    */
    public function export_laporan_bagihasil()
    {
        $from_date = $this->uri->segment(3);
        $from_date = substr($from_date, 4, 4) . '-' . substr($from_date, 2, 2) . '-' . substr($from_date, 0, 2);
        $thru_date = $this->uri->segment(4);
        $thru_date = substr($thru_date, 4, 4) . '-' . substr($thru_date, 2, 2) . '-' . substr($thru_date, 0, 2);
        $branch_code = $this->uri->segment(5);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } else if ($from_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else if ($thru_date == "") {
            echo "<script>alert('Tanggal Belum Diisi !');javascript:window.close();</script>";
        } else {
            $datas = $this->model_laporan->get_data_bahas2($branch_code, $from_date, $thru_date);
            ob_start();
            $data['result'] = $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($branch_code));
            } else {
                $data['cabang'] = "SEMUA CABANG";
            }
            $data['from_date'] = $from_date;
            $data['thru_date'] = $thru_date;
            $this->load->view('laporan/export_laporan_bagihasil', $data);

            $content = ob_get_clean();
            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                ob_get_clean();
                $html2pdf->Output('laporan bagihasil"' . $from_date . '_"' . $thru_date . '""_"' . $data['cabang'] . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }

    public function export_rekap_angsuran_semua_cabang()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $financing_type = $this->uri->segment(6);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type = '0') {
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_semua_cabang($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_semua_cabang_individu($cabang, $tanggal1_, $tanggal2_);
        }

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_angsuran', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
<<<<<<< HEAD
            $html2pdf->Output('REKAP_ANGSURAN_' . $cabang . '.pdf');
=======
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . '.pdf');
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Cabang Yang dipilih
    public function export_rekap_angsuran_cabang()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_cabang($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_cabang_individu($cabang, $tanggal1_, $tanggal2_);
        }

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_angsuran_cabang', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Rembug
    public function export_rekap_angsuran_rembug()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $financing_type = $this->uri->segment(6);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_rembug($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_rembug_individu($cabang, $tanggal1_, $tanggal2_);
        }

        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_angsuran_rembug', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY REMBUG.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Petugas
    public function export_rekap_angsuran_petugas()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_petugas($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_petugas_individu($cabang, $tanggal1_, $tanggal2_);
        }
        ob_start();
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_angsuran_petugas', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY PETUGAS.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Produk
    public function export_rekap_angsuran_produk()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_produk($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_produk_individu($cabang, $tanggal1_, $tanggal2_);
        }


        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_angsuran_produk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY PRODUK.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //Berdasarkan Peruntukan
    public function export_rekap_angsuran_peruntukan()
    {
        $cabang = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_peruntukan($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_peruntukan_individu($cabang, $tanggal1_, $tanggal2_);
        }


        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_angsuran_peruntukan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY PERUNTUKAN.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }


    public function export_rekap_angsuran_sektor_usaha()
    {
        $cabang         = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_sektor_usaha($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_sektor_usaha_individu($cabang, $tanggal1_, $tanggal2_);
        }

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_sektor_usaha', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_angsuran_kreditur()
    {
        $cabang         = $this->uri->segment(3);
        $tanggal1       = $this->uri->segment(4);
        $tanggal1__     = substr($tanggal1, 0, 2) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 4, 4);
        $tanggal1_      = substr($tanggal1, 4, 4) . '-' . substr($tanggal1, 2, 2) . '-' . substr($tanggal1, 0, 2);
        $tanggal2       = $this->uri->segment(5);
        $tanggal2__     = substr($tanggal2, 0, 2) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 4, 4);
        $tanggal2_      = substr($tanggal2, 4, 4) . '-' . substr($tanggal2, 2, 2) . '-' . substr($tanggal2, 0, 2);
        $financing_type = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        if ($financing_type == '0') {
            $data['post_pembiayaan'] = "Kelompok";
            $post_pembiayaan = "KELOMPOK";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_kreditur($cabang, $tanggal1_, $tanggal2_);
        } else if ($financing_type == '1') {
            $data['post_pembiayaan'] = "Individu";
            $post_pembiayaan = "INDIVIDU";
            $datas = $this->model_laporan_to_pdf->export_rekap_angsuran_kreditur_individu($cabang, $tanggal1_, $tanggal2_);
        }


        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
        $data['tanggal1_'] = $tanggal1__;
        $data['tanggal2_'] = $tanggal2__;
        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_outstanding_piutang_kreditur', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP ANGSURAN ' . $post_pembiayaan . ' BY SUMBER DANA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //BEGIN LAPORAN SIMPANAN POKOK
    /****************************************************************************/
    public function export_simpanan_pokok()
    {
        $branch_code = $this->uri->segment(3);
        $cm_code = $this->uri->segment(4);
        // $datas = $this->model_laporan_to_pdf->export_transaksi_kas_petugas($tanggal_,$tanggal2_,$account_cash_code);

        if ($branch_code == "") {
            echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        } /*
        else if ($cm_code=="")
        {
         echo "<script>alert('Parameter Bulum Lengkap !');javascript:window.close();</script>";
        }*/ else {

            ob_start();


            $config['full_tag_open']    = '<p>';
            $config['full_tag_close']   = '</p>';

            $data['simpanan_pokok'] = $this->model_laporan->export_simpanan_pokok($branch_code, $cm_code);

            // $data['result']= $datas;
            if ($branch_code != '0000') {
                $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($branch_code);
            } else {
                $data['cabang'] = "Semua Data";
            }

            $cabang = $data['cabang'];

            $this->load->view('laporan/export_pdf_simpanan_pokok', $data);

            $content = ob_get_clean();

            try {
                $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
                $html2pdf->pdf->SetDisplayMode('fullpage');
                $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
                $html2pdf->Output('export_simpanan_pokok_"' . $cabang . '".pdf');
            } catch (HTML2PDF_exception $e) {
                echo $e;
                exit;
            }
        }
    }
    /****************************************************************************/
    //END LAPORAN SIMPANAN POKOK
    /****************************************************************************/

    /****************************************************************************/
    // BEGIN LAPORAN REKAP SALDO TABUNGAN
    /****************************************************************************/
    function export_rekap_saldo_tabungan()
    {
        $cabang = $this->uri->segment(3);

        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_tabungan($cabang);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['result'] = $datas;

        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_rekap_saldo_tabungan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('export_rekap_saldo_tabungan_"' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    // END LAPORAN REKAP SALDO TABUNGAN
    /****************************************************************************/


    /****************************************************************************/
    // BEGIN LAPORAN REKAP SALDO TABUNGAN
    /****************************************************************************/
    function export_rekap_saldo_tabungan_lalu()
    {
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        if ($cabang == false) {
            $cabang = "0000";
        } else {
            $cabang =   $cabang;
        }

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        ///$datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_semua_cabang_lalu($cabang,$tanggal);

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_tabungan_lalu($cabang, $tanggal);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['result'] = $datas;

        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $data['tanggal'] = $tanggal;

        $this->load->view('laporan/export_rekap_saldo_tabungan_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('rekap_saldo_tab_bln_lalu_"' . $cabang . '".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    // END LAPORAN REKAP SALDO TABUNGAN
    /****************************************************************************/



    /* BEGIN LAPORAN LIST BAGI HASIL */
    function export_lap_list_bagihasil()
    {
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $periode = $this->uri->segment(6);

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_bagihasil($cabang, $majelis, $petugas, $periode);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['periode'] = $periode;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_lap_list_bagihasil', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Bagihasil ' . $cabang . ' Periode ' . $periode . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /* BEGIN LAPORAN LIST BAGI HASIL */
    function export_lap_list_bagihasil_shu()
    {
        $cabang = $this->uri->segment(3);
        $majelis = $this->uri->segment(4);
        $petugas = $this->uri->segment(5);
        $periode = $this->uri->segment(6);

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_bagihasil_shu($cabang, $majelis, $petugas, $periode);

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['periode'] = $periode;
        $data['petugas'] = $fa;

        $this->load->view('laporan/export_lap_list_bagihasil_shu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Bagihasil ' . $cabang . ' Periode ' . $periode . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_neraca_temp()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $tanggal = $this->datepicker_convert(true, $tanggal, '/');
        $report_code = $this->uri->segment(5);
        $user_id = $this->session->userdata('user_id');

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $startGetClosing = substr($tanggal, 0, 7) . '-01';
        $startClosing = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));
        $getClosing = $this->model_laporan_to_pdf->getClosing($cabang);

        $fromlm = $startClosing;
        $from = $startGetClosing;
        $thru = $tanggal;

        $insert_temp = $this->model_laporan_to_pdf->insert_temp($cabang, $fromlm, $from, $thru, $user_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $data['result'] = $this->model_laporan_to_pdf->export_neraca_temp($cabang, $report_code);

        if ($report_code == '10') {
            $jenis = 'Neraca';
            $judul = 'LAPORAN NERACA';
        } else {
            $jenis = 'Neraca Rinci';
            $judul = 'LAPORAN NERACA RINCI';
        }

        $data['judul'] = $judul;
        $data['tanggal'] = $tanggal;
        $data['branch_name'] = $branch['branch_name'];
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_neraca_temp', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_neraca_temp_2()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $tanggal = $this->datepicker_convert(true, $tanggal, '/');
        $report_code = $this->uri->segment(5);
        $user_id = $this->session->userdata('user_id');
        $bulan = substr($tanggal, 5, 2);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $startGetClosing = substr($tanggal, 0, 7) . '-01';
        $startClosing = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));
        $getClosing = $this->model_laporan_to_pdf->getClosing($cabang);

        $fromlm = $startClosing;
        $from = $startGetClosing;
        $thru = $tanggal;

        if ($bulan == '01') {
            $flag_akhir_tahun = 'Y';
        } else {
            $flag_akhir_tahun = 'T';
        }

        $insert_temp = $this->model_laporan_to_pdf->insert_temp_2($cabang, $report_code, $fromlm, $from, $thru, $user_id, $flag_akhir_tahun);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $data['result'] = $this->model_laporan_to_pdf->export_neraca_temp_2($cabang, $report_code, 'T', $user_id);

        if ($report_code == '10') {
            $jenis = 'Neraca';
            $judul = 'LAPORAN NERACA';
        } else {
            $jenis = 'Neraca Rinci';
            $judul = 'LAPORAN NERACA RINCI';
        }

        $data['judul'] = $judul;
        $data['tanggal'] = $tanggal;
        $data['branch_name'] = $branch['branch_name'];
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_neraca_temp', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_lr_temp()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $tanggal = $this->datepicker_convert(true, $tanggal, '/');
        $report_code = $this->uri->segment(5);
        $user_id = $this->session->userdata('user_id');

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $startGetClosing = substr($tanggal, 0, 7) . '-01';
        $startClosing = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));
        $getClosing = $this->model_laporan_to_pdf->getClosing($cabang);

        $fromlm = $startClosing;
        $from = $startGetClosing;
        $thru = $tanggal;

        $insert_temp = $this->model_laporan_to_pdf->insert_temp($cabang, $fromlm, $from, $thru, $user_id);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $data['result'] = $this->model_laporan_to_pdf->export_lr_temp($cabang, $report_code);

        if ($report_code == '20') {
            $jenis = 'Laba Rugi';
            $judul = 'LAPORAN LABA RUGI';
        } else if ($report_code == '21') {
            $jenis = 'Laba Rugi Rinci';
            $judul = 'LAPORAN LABA RUGI RINCI';
        } else {
            $jenis = 'Laba Rugi Konsolidasi';
            $judul = 'LAPORAN LABA RUGI KONSOLIDASI';
        }

        $data['judul'] = $judul;
        $data['tanggal'] = $tanggal;
        $data['branch_name'] = $branch['branch_name'];
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_lr_temp', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    function export_lr_temp_2()
    {
        $cabang = $this->uri->segment(3);
        $tanggal = $this->uri->segment(4);
        $tanggal = $this->datepicker_convert(true, $tanggal, '/');
        $report_code = $this->uri->segment(5);
        $user_id = $this->session->userdata('user_id');
        $bulan = substr($tanggal, 5, 2);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $startGetClosing = substr($tanggal, 0, 7) . '-01';
        $startClosing = date('Y-m-d', strtotime($startGetClosing . ' - 1 MONTH'));
        $getClosing = $this->model_laporan_to_pdf->getClosing($cabang);

        $fromlm = $startClosing;
        $from = $startGetClosing;
        $thru = $tanggal;

        if ($bulan == '01') {
            $flag_akhir_tahun = 'Y';
        } else {
            $flag_akhir_tahun = 'T';
        }

        $insert_temp = $this->model_laporan_to_pdf->insert_temp_2($cabang, $report_code, $fromlm, $from, $thru, $user_id, $flag_akhir_tahun);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $data['result'] = $this->model_laporan_to_pdf->export_lr_temp_2($cabang, $report_code, 'T', $user_id);

        if ($report_code == '20') {
            $jenis = 'Laba Rugi';
            $judul = 'LAPORAN LABA RUGI';
        } else if ($report_code == '21') {
            $jenis = 'Laba Rugi Rinci';
            $judul = 'LAPORAN LABA RUGI RINCI';
        } else {
            $jenis = 'Laba Rugi Konsolidasi';
            $judul = 'LAPORAN LABA RUGI KONSOLIDASI';
        }

        $data['judul'] = $judul;
        $data['tanggal'] = $tanggal;
        $data['branch_name'] = $branch['branch_name'];
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_lr_temp', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    //EXPORT TRIAL BALANCE TEMP//
    // -------------------------- //

    function export_trial_balance_temp()
    {
        $cabang = $this->uri->segment(3);
        $from = $this->uri->segment(4);
        $from = $this->datepicker_convert(true, $from, '/');
        $report_code = $this->uri->segment(5);

        $branch_id = $this->model_cif->get_branch_id_by_branch_code($cabang);
        $branch = $this->model_cif->get_branch_by_branch_id($branch_id);

        $start = substr($from, 0, 7) . '-01';
        $fromlm = date('Y-m-d', strtotime($start . '- 1 MONTH'));

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        if ($cabang != '00000') {
            $data['cabang'] = $this->model_laporan_to_pdf->get_cabang($cabang);
            if ($branch['branch_class'] == "1") {
                $data['cabang'] .= " ";
            }
        } else {
            $data['cabang'] = "PUSAT ";
        }

        $datas = $this->model_laporan_to_pdf->export_trial_balance_temp($cabang, $fromlm, $start, $from, $report_code);

        if ($report_code == '30') {
            $jenis = 'Trial Balance';
            $judul = 'LAPORAN TRIAL BALANCE';
        }

        $data['judul'] = $judul;
        $data['tanggal'] = $from;
        $data['datas'] = $datas;
        $data['branch_name'] = $branch['branch_name'];
        $data['branch_class'] = $branch['branch_class'];
        $data['branch_officer_name'] = $branch['branch_officer_name'];
        $this->load->view('laporan/export_keuangan_trialbalance_temp', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan ' . $jenis . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    // FINISH //

    // BEGIN LAPORAN ANGGOTA BULAN LALU
    function export_lap_list_anggota_bulan_lalu()
    {
        $cabang = $this->uri->segment(3);
        $petugas = $this->uri->segment(4);
        $majelis = $this->uri->segment(5);
        $hari = $this->uri->segment(6);
        $bulan = $this->uri->segment(7);
        $tahun = $this->uri->segment(8);
        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_lap_list_anggota_bulan_lalu($cabang, $petugas, $majelis, $tanggal);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['from'] = $tanggal;
        $data['petugas'] = $fa;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $this->load->view('laporan/export_lap_list_anggota_bulan_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan List Anggota Bulan Lalu ' . $tanggal . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }





    /****************************************************************************/
    //BEGIN LAPORAN REKAP SALDO ANGGOTA BULAN LALU
    /****************************************************************************/

    //Semua Cabang
    public function export_rekap_saldo_anggota_semua_cabang1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_semua_cabang1($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota1', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    function export_rekap_saldo_anggota_semua_cabang_lalu()
    {
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_semua_cabang_lalu($cabang, $tanggal);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BULAN LALU.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_cabang1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_cabang1($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_cabang', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    function export_rekap_saldo_anggota_cabang_lalu()
    {
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_cabang_lalu($cabang, $tanggal);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

<<<<<<< HEAD
=======
        $data['result'] = $datas;

>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $data['tanggal'] =  $tanggal;

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_cabang_lalu', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BULAN LALU.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

<<<<<<< HEAD
    public function export_rekap_saldo_anggota_rembug_lalu()
    {
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug_lalu($cabang, $tanggal);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $data['tanggal'] =  $tanggal;

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_rembug_lalu', $data);

        $content = ob_get_clean();

=======
    //Berdasarkan Rembug
    public function export_rekap_saldo_anggota_rembug1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug1($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY REMBUG.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    public function export_rekap_saldo_anggota_rembug_lalu()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_rembug_lalu($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_rembug', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY REMBUG.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Petugas
    public function export_rekap_saldo_anggota_petugas1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas1($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_petugas', $data);

        $content = ob_get_clean();

>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
<<<<<<< HEAD
            $html2pdf->Output('REKAP SALDO ANGGOTA BULAN LALU BY REMBUG.pdf');
=======
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PETUGAS.pdf');
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    public function export_rekap_saldo_anggota_petugas_lalu()
    {
<<<<<<< HEAD
        $cabang = $this->uri->segment(3);
        $hari = $this->uri->segment(4);
        $bulan = $this->uri->segment(5);
        $tahun = $this->uri->segment(6);

        $tanggal = $tahun . '-' . $bulan . '-' . $hari;

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas_lalu($cabang, $tanggal);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

=======
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }
        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_petugas_lalu($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
<<<<<<< HEAD
        $data['tanggal'] =  $tanggal;

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_petugas_lalu', $data);
=======

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_petugas', $data);
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
<<<<<<< HEAD
            $html2pdf->Output('REKAP SALDO ANGGOTA BULAN LALU BY PETUGAS.pdf');
=======
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PETUGAS.pdf');
>>>>>>> fa72a87dd8587cd62a2c3aecb932f9d1cda64dda
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    
    //Berdasarkan Produk
    public function export_rekap_saldo_anggota_produk1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_produk1($cabang);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_produk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PRODUK.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    public function export_rekap_saldo_anggota_produk_lalu()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_produk_lalu($cabang);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_produk', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PRODUK.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    //Berdasarkan Peruntukan
    public function export_rekap_saldo_anggota_peruntukan1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_peruntukan1($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_peruntukan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PERUNTUKAN.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    public function export_rekap_saldo_anggota_peruntukan_lalu()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        // $datas = $this->model_laporan_to_pdf->export_rekap_outstanding_pembiayaan_semua_cabang($cabang,$tanggal1_,$tanggal2_);
        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_peruntukan_lalu($cabang);
        //$cabang_ = $this->model_laporan_to_pdf->get_cabang($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }
        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_peruntukan', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY PERUNTUKAN.pdf');
            // $html2pdf->Output('export_list_jatuh_tempo"'.$tanggal1__.'_"'.$tanggal1__.'""_"'.$cabang.'".pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
        // }
    }

    public function export_rekap_saldo_anggota_sektor_usaha1()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_sektor_usaha1($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_sektor_usaha', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    public function export_rekap_saldo_anggota_sektor_usaha_lalu()
    {
        $cabang         = $this->uri->segment(3);
        if ($cabang == false) {
            $cabang = "00000";
        } else {
            $cabang =   $cabang;
        }

        $datas = $this->model_laporan_to_pdf->export_rekap_saldo_anggota_sektor_usaha_lalu($cabang);

        ob_start();


        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['result'] = $datas;
        if ($cabang != '0000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
        } else {
            $data['cabang'] = "SEMUA CABANG";
        }

        $this->load->view('laporan/export_pdf_rekap_saldo_anggota_sektor_usaha', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('REKAP SALDO ANGGOTA BY SEKTOR USAHA.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /****************************************************************************/
    //END LAPORAN REKAP OUTSTANDING PIUTANG
    /****************************************************************************/

    /****************************************************************************/
    //BEGIN LAPORAN LIST Wakalah | T | TGL 07-09-2017
    /****************************************************************************/
    function export_list_wakalah()
    {
        $from = $this->uri->segment(3);
        $from = $this->datepicker_convert(true, $from, '/');
        $thru = $this->uri->segment(4);
        $thru = $this->datepicker_convert(true, $thru, '/');
        $cabang = $this->uri->segment(5);
        $majelis = $this->uri->segment(6);
        $pembiayaan = $this->uri->segment(7);
        $petugas = $this->uri->segment(8);
        $produk = $this->uri->segment(9);

        if ($pembiayaan == 1) {
            $jenis = 'Individu';
            $jenis2 = strtoupper($jenis);
            $majelis = '00000';
            $petugas = '00000';
        } else if ($pembiayaan == 0) {
            $jenis = 'Kelompok';
            $jenis2 = strtoupper($jenis);
        } else {
            $jenis = 'Semua';
            $jenis2 = strtoupper($jenis);
        }

        if ($petugas == '00000') {
            $fa = 'SEMUA PETUGAS';
        } else {
            $getPetugas = $this->model_cif->get_fa_by_fa_code($petugas);
            $fa = $getPetugas['fa_name'];
        }

        if ($produk == '00000') {
            $pro = 'SEMUA PRODUK';
        } else {
            $getproduk = $this->model_laporan->get_product_financing_by_code($produk);
            $pro = $getproduk['product_name'];
        }

        if ($majelis == '00000') {
            $maj = 'SEMUA MAJELIS';
        } else {
            $getmaj = $this->model_laporan->get_cm_name_by_cm_code($produk);
            $maj = $getmaj['cm_name'];
        }

        $datas = $this->model_laporan_to_pdf->export_list_wakalah($from, $thru, $cabang, $majelis, $pembiayaan, $petugas, $produk);

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        $data['from'] = $from;
        $data['thru'] = $thru;
        $data['petugas'] = $fa;
        $data['pembiayaan'] = $jenis;
        $data['produk'] = $pro;
        $data['majelis'] = $maj;

        if ($cabang != '00000') {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($cabang));
            $cabang = $data['cabang'];
        } else {
            $data['cabang'] = 'SEMUA CABANG';
            $cabang = $data['cabang'];
        }

        $this->load->view('laporan/export_list_wakalah', $data);
        $content = ob_get_clean();
        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Wakalah (' . $jenis2 . ') ' . $from . ' - ' . $thru . ' ' . $cabang . '.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
    /****************************************************************************/
    //END LAPORAN LIST Wakalah
    /****************************************************************************/


    /***************************************************************************************/
    //BEGIN PROYEKSI DROPING
    //Author : Aiman
    //Tgl    : 29 - 05 - 18
    /***************************************************************************************/

    function export_lap_proyeksi_droping()
    {
        $branch_code = $this->uri->segment(3);
        $year = $this->uri->segment(4);

        if ($branch_code == '9999') {
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping($branch_code, $year);
        } else if ($branch_code == '00000') {
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping_pusat($branch_code, $year);
        } else {
            $datas = $this->model_laporan_to_pdf->export_lap_proyeksi_droping($branch_code, $year);
        }


        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;

        if ($branch_code == '9999') {
            $data['cabang'] = 'SEMUA CABANG';
        } else if ($branch_code == '00000') {
            $data['cabang'] = 'Kantor Pusat';
        } else {
            $data['cabang'] = 'CABANG ' . strtoupper($this->model_laporan_to_pdf->get_cabang($branch_code));
        }

        $this->load->view('laporan/export_lap_proyeksi_droping', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan Proyeksi Droping.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }

    /***************************************************************************************/
    //END PROYEKSI DROPING
    /***************************************************************************************/

    function export_list_api_debitur()
    {
        $kreditur_code = $this->uri->segment(3);
        $batch_no = $this->uri->segment(4);
        $status_pyd_kreditur = $this->uri->segment(5);
        $branch_code = $this->session->userdata('branch_code');

        if ($status_pyd_kreditur <> '2') {
            $datas = $this->model_laporan_to_pdf->export_list_api_debitur_not_reject($kreditur_code, $batch_no, $status_pyd_kreditur, $branch_code);
        } else {
            $datas = $this->model_laporan_to_pdf->export_list_api_debitur_reject($kreditur_code, $batch_no, $branch_code);
        }

        ob_start();

        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';

        $data['result'] = $datas;
        $data['batch'] = $batch_no;

        $this->load->view('laporan/export_lap_list_debitur', $data);

        $content = ob_get_clean();

        try {
            $html2pdf = new HTML2PDF('L', array(215, 330), 'fr', true, 'UTF-8', 5);
            $html2pdf->pdf->SetDisplayMode('fullpage');
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('Laporan_List Debitur.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
}
