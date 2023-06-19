<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  background: #fff;
  /* margin: 15px;
  margin-top: 15px;  */
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b .title {
	font-size: 8px;
	font-weight: bold;
	color: #000;
	padding: 4.5px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 5.5px;
	color: #000;
	padding: 4px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 5.5px;
	color: #000;
	padding: 4px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 5.5px;
	font-weight: bold;
	color: #000;
	padding: 4px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 5.5px;
	font-weight: bold;
	color: #000;
	padding: 4px;
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
  Laporan Outstanding Pembiayaan Bulan Lalu
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'-');?> 
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <thead>
  	<tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" colspan="4">Anggota</td>
      <th class="title" rowspan="2">Majelis</th>
      <th class="title" rowspan="2">Produk</th>
      <th class="title" rowspan="2">Sektor</th>
      <th class="title" rowspan="2">Peruntukan</th>
      <th class="title" rowspan="2">Sumber Dana</th>
      <th class="title" rowspan="2">Droping</th>
      <th class="title" rowspan="2">Pokok</th>
      <th class="title" rowspan="2">Margin</th>
      <th class="title" rowspan="2">J Waktu</th>
      <th class="title" rowspan="2">Bayar</th> 
      <th class="title" rowspan="2">Seharusnya</th> 
      <th class="title" colspan="4">Saldo</th>
      <th class="title" rowspan="2">Reschedulle</th>
      <th class="title" rowspan="2">TGL Jatuh Tempo</th>
      <th class="title" rowspan="2">Petugas</th>
    </tr>
    <tr>
      <th class="title">Rekening</th>
      <th class="title">Nama</th>
      <th class="title">No.KTP</th>
      <th class="title">Jenis</th>
      <th class="title">Freq</th>
      <th class="title">Pokok</th>
      <th class="title">Margin</th>
      <th class="title">Catab</th>
    </tr>
  </thead>
  <tbody>
  	<?php 
	$no = 1;
	$total_pokok = 0;
	$total_margin = 0;
	$total_saldo_pokok = 0;
	$total_saldo_margin = 0;
	$total_saldo_catab = 0;

	foreach ($result as $data){
		$rekening = $data['account_financing_no'];
		$nama = $data['nama'];
		$ktp = $data['no_ktp'];
		$jenis = $data['financing_type'];
		$majelis = $data['cm_name'];
		$produk = $data['nick_name'];
		$sektor = $data['sektor'];
		$peruntukan = $data['peruntukan'];
		$droping = $data['droping_date']; 
    $jangka_waktu = $data['jangka_waktu'];
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$bayar = $data['freq_bayar_pokok']; 
    $seharusnya = $data['seharusnya']-$data['hari_libur'];
    if($seharusnya>$jangka_waktu) {$seharusnya=$jangka_waktu;};
		$saldo = $data['freq_bayar_saldo'];
		$saldo_pokok = $data['saldo_pokok'];
		$saldo_margin = $data['saldo_margin'];
		$saldo_catab = $data['saldo_catab'];		
    $kreditur = $data['krd'];
    $fl_reschedulle = $data['fl_reschedulle'];
    $tanggal_jtempo = $data['tanggal_jtempo'];
    $petugas = $data['fa_name'];

		$total_pokok += $pokok;
        $total_margin += $margin;
        $total_saldo_pokok += $saldo_pokok;
        $total_saldo_margin += $saldo_margin;
		$total_saldo_catab += $saldo_catab;

		if($jenis == '0'){
			$pembiayaan = 'Kelompok';
		} else {
			$pembiayaan = 'Individu';
		}
	?>    
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $ktp; ?></td>
      <td class="konten"><?php echo $pembiayaan; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $produk; ?></td>
      <td class="konten"><?php echo $sektor; ?></td>
      <td class="konten"><?php echo $peruntukan; ?></td>
      <td class="konten"><?php echo $kreditur; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($droping,'id',false,'-'); ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $jangka_waktu; ?></td>
      <td class="konten"><?php echo $bayar; ?></td>
      <td class="konten"><?php echo $seharusnya; ?></td>
      <td class="konten"><?php echo $saldo; ?></td>
      <td class="nominal"><?php echo number_format($saldo_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_catab,0,',','.'); ?></td>
      <td class="konten"><?php echo $fl_reschedulle; ?></td>
      <td class="konten"><?php echo $tanggal_jtempo; ?></td>
      <td class="konten"><?php echo $petugas; ?></td>
    </tr>
    <?php } ?>    
    <tr>
      <td class="title" colspan="9">Total</td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.') ;?></td>
      <td class="total_saldo"><?php echo number_format($total_margin,0,',','.') ;?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td> 
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_saldo_pokok,0,',','.') ;?></td>
      <td class="total_saldo"><?php echo number_format($total_saldo_margin,0,',','.') ;?></td>
      <td class="total_saldo"><?php echo number_format($total_saldo_catab,0,',','.') ;?></td>
    </tr>
  </tbody>
</table>
