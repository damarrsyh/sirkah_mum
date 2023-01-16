<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b .title {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 8px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 9px;
	color: #000;
	padding: 8px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 9px;
	color: #000;
	padding: 8px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 9px;
	font-weight: bold;
	color: #000;
	padding: 8px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 9px;
	font-weight: bold;
	color: #000;
	padding: 8px;
	border-right: 1px solid #262626;
	text-align: center;
}

-->
</style>
<div style="width:100%;">
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
  <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
  <?php echo $cabang; ?>
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
  Laporan Registrasi Pembiayaan
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Jenis Pembiayaan : <?php echo $pembiayaan; ?>
  </div>
  <div style="text-align:right;padding-top:10px;font-family:Arial;font-size:13px;margin-top: -50px;">
  Produk : <?php echo $produk; ?>
  </div>
  <div style="text-align:right;padding-top:10px;font-family:Arial;font-size:13px;">
  Majelis : <?php echo $majelis; ?>
  </div>
  <hr>
</div>
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title" rowspan="2">No</td>
      <td class="title" rowspan="2">Nomor<br />
      Rekening</td>
      <td colspan="2" class="title">Anggota</td>
      <td class="title" rowspan="2">Pembiayaan</td>
      <td class="title" rowspan="2">Produk</td>
      <td class="title" rowspan="2">Tanggal <br> Pengajuan</td>
      <td class="title" rowspan="2">Tanggal<br />Registrasi</td>
      <td class="title" rowspan="2">Plafon</td>
      <td class="title" rowspan="2">Margin</td>
      <td class="title" rowspan="2">Jangka<br />
      Waktu</td>
      <td class="title" colspan="4">Angsuran</td>
      <td class="title" rowspan="2">Biaya <br> Adm</td>
      <td class="title" rowspan="2">Biaya <br> Asuransi</td>
      <td class="title" rowspan="2">Status</td>
    </tr>
    <tr>
      <td class="title">Nama</td>
      <td class="title">Majelis</td>
      <td class="title">Pokok</td>
      <td class="title">Margin</td>
      <td class="title">Catab</td>
      <td class="title">Total</td>
    </tr>
    <?php 
	$no = 1;

	foreach($result as $data){
		$periode_jangka_waktu   = $data['periode_jangka_waktu'];
		$pokok                  = $data['pokok'];
		$status_rekening        = $data['status_rekening'];
		$financing              = $data['financing_type'];
		$rekening               = $data['account_financing_no'];
		$nama                   = $data['nama'];
		$majelis                = $data['cm_name'];
		$tanggal_registrasi     = $data['tanggal_registrasi'];
		$pokok                  = $data['pokok'];
		$margin                 = $data['margin'];
		$angsuran_pokok         = $data['angsuran_pokok'];
		$angsuran_margin        = $data['angsuran_margin'];
		$angsuran_catab         = $data['angsuran_catab'];
		$jangka_waktu           = $data['jangka_waktu'];
		$product                = $data['nick_name'];
    $tanggal_pengajuan      = $data['tanggal_pengajuan'];
    $biaya_administrasi     = $data['biaya_administrasi'];
    $biaya_asuransi_jiwa    = $data['biaya_asuransi_jiwa'];

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
			$tanggal = $CI->format_date_detail($tanggal_registrasi,'id',false,'/');
		}

    if($tanggal_pengajuan == ''){
      $tanggal_peng = '-';
    } else {
      $tanggal_peng = $CI->format_date_detail($tanggal_pengajuan,'id',false,'/');
    }
    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $jenis; ?></td>
      <td class="konten"><?php echo $product; ?></td>
      <td class="konten"><?php echo $tanggal_peng; ?></td>
      <td class="konten"><?php echo $tanggal; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $jangka_waktu.' '.$periode; ?></td>
      <td class="nominal"><?php echo number_format($angsuran_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($angsuran_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($angsuran_catab,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($total,0,',','.'); ?></td>
      <td class="konten"><?php echo $biaya_administrasi; ?></td>
      <td class="konten"><?php echo $biaya_asuransi_jiwa; ?></td>
      <td class="konten"><?php echo $status; ?></td>
    </tr>      
    <?php } ?>
  </tbody>
</table>
