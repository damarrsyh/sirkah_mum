<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Api extends GMN_Controller {
    
    function __construct(){
        parent::__construct();
        $this->load->model('model_api');
        date_default_timezone_set('Asia/Jakarta');
    }

    function index(){
        echo 'Hello World';
    }

    function status_financing_kreditur(){
        $input = file_get_contents('php://input');

        $decode = json_decode($input);

        $datax = array('data' => $decode);

        $count = count($datax['data']);

        $approved = 0;
        $rejected = 0;

        $insert = array();

        for($i = 0; $i < $count; $i++){
            $status = $datax['data'][$i]->status;
            $rekening = $datax['data'][$i]->rekening;
    
            $update['status_pyd_kreditur'] = $status;

            if($status == '1'){
                $update['sumber_dana'] = '1';
                $update['kreditur_code'] = '01';
                $approved++;
            } else {
                $insert[] = array('account_financing_no' => $rekening);
                $rejected++;
            }

            $param = array('account_financing_no' => $rekening);
            $this->db->update('mfi_account_financing',$update,$param);
        }

        if($rejected > 0){
            $this->db->trans_begin();
            $this->model_api->insert_batch('mfi_account_financing_kreditur',$insert);

            if($this->db->trans_status() === TRUE){
                $this->db->trans_commit();
                $result = array(
                    'Disetujui' => $approved,
                    'Ditolak' => $rejected,
                );
            } else {
                $this->db->trans_rollback();
                $response = array(
                    'Disetujui' => 'Nan',
                    'Ditolak' => 'Nan'
                );
            }
        } else {
            $result = array(
                'Disetujui' => $approved,
                'Ditolak' => $rejected,
            );
    }

        echo json_encode($result);
    }

    function download_ktp(){
        $map_no = $this->uri->segment(3);

        $path = './assets/img/document/';

        $get_ktp = $this->model_api->get_all_document($map_no);
        $ktp = $get_ktp['doc_ktp'];

        $path_ktp = $path.$ktp;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path_ktp));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($path_ktp);
        exit;
    }

    function download_kk(){
        $map_no = $this->uri->segment(3);

        $path = './assets/img/document/';

        $get_kk = $this->model_api->get_all_document($map_no);
        $kk = $get_kk['doc_kk'];

        $path_kk = $path.$kk;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path_kk));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($path_kk);
        exit;
    }

    function download_pendukung(){
        $map_no = $this->uri->segment(3);

        $path = './assets/img/document/';

        $get_pendukung = $this->model_api->get_all_document($map_no);
        $pendukung = $get_pendukung['doc_pendukung'];

        $path_pendukung = $path.$pendukung;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path_pendukung));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($path_pendukung);
        exit;
    }

    function download_sign(){
        $map_no = $this->uri->segment(3);

        $path = './assets/img/ttd/';

        $get_sign = $this->model_api->get_all_document($map_no);
        $sign = $get_sign['ttd_anggota'];

        $path_sign = $path.$sign;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($path_sign));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        ob_clean();
        flush();
        readfile($path_sign);
        exit;
    }
}