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
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 10px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 10px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 9px;
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
  Laporan Jatuh Tempo
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'-');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'-');?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title" rowspan="2">No</td>
      <td class="title" rowspan="2">Tgl Droping</td>
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Majelis</td>
      <td class="title" rowspan="2">Jenis</td>
      <td class="title" rowspan="2">Desa</td>
      <td class="title" colspan="4">Pembiayaan</td>
      <td class="title" rowspan="2">Jangka Waktu</td>
      <td class="title" rowspan="2">Tgl Jatuh Tempo</td>
    </tr>
    <tr>
      <td class="title">Rekening</td>
      <td class="title">Nama</td>
      <td class="title">Ke</td>
      <td class="title">Pokok</td>
      <td class="title">Margin</td>
      <td class="title">Sisa</td>
    </tr>
    <?php 
	$no = 1;
	foreach($result as $data){
		$tanggal_akad = $data['tanggal_akad'];
		$rekening = $data['account_financing_no'];
		$nama = $data['nama'];
		$majelis = $data['cm_name'];
		$desa = $data['desa'];
		$ke = $data['ke'];
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$jangka_waktu = $data['jangka_waktu'];
		$jtempo = $data['tanggal_jtempo'];
		$periode_jangka_waktu = $data['periode_jangka_waktu'];
		$financing_type = $data['financing_type'];
		$saldo_pokok = $data['saldo_pokok'];
		$angsuran_pokok = $data['angsuran_pokok'];

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
	?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($tanggal_akad,'id',false,'-'); ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $pembiayaan; ?></td>
      <td class="konten"><?php echo $desa; ?></td>
      <td class="konten"><?php echo $ke; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $sisa.' '.$periode; ?></td>
      <td class="konten"><?php echo $jangka_waktu.' '.$periode; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($jtempo,'id',false,'-'); ?></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
