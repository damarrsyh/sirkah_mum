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
	font-size: 14px;
	font-weight: bold;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 12px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 12px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 12px;
	font-weight: bold;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 12px;
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
  Laporan Rekap Pengajuan Pembiayaan berdasarkan <?php echo $by; ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'-');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'-');?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Pembiayaan : <?php echo $type;?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title">No</td>
      <td class="title"><?php echo $by; ?></td>
      <td class="title">Jumlah</td>
      <td class="title">Nominal</td>
      <td class="title">Pembiayaan</td>
      <td class="title">Persentase Jumlah</td>
      <td class="title">Persentase Nominal</td>
    </tr>
    <?php
	$no = 1;
	$total_anggota = 0;
	$total_pokok = 0;
    $sum_anggota = 0;
    $sum_pokok = 0;

    foreach($result as $data){
		$sum_a = $data['jumlah_anggota'];
		$sum_p = $data['nominal'];

		$sum_anggota += $sum_a;
		$sum_pokok += $sum_p;
	}

	foreach($result as $data){
		$jumlah_anggota = $data['jumlah_anggota'];
		$nominal = $data['nominal'];
		$keterangan = $data['keterangan'];
		$financing = $data['financing_type'];

        $persen_jumlah = ($jumlah_anggota / $sum_anggota) * 100;
        $persen_nominal = ($nominal / $sum_pokok) * 100;

		$total_anggota += $jumlah_anggota;
        $total_pokok += $nominal;

		if($financing == '0'){
			$pembiayaan = 'Kelompok';
		} else {
			$pembiayaan = 'Individu';
		}
    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $keterangan; ?></td>
      <td class="konten"><?php echo $jumlah_anggota; ?></td>
      <td class="nominal"><?php echo number_format($nominal,0,',','.'); ?></td>
      <td class="konten"><?php echo $pembiayaan; ?></td>
      <td class="nominal"><?php echo number_format($persen_jumlah,2,',','.').'%'; ?></td>
      <td class="nominal"><?php echo number_format($persen_nominal,2,',','.').'%'; ?></td>
    </tr>
    <?php } ?>      
    <tr>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="konten"><strong><?php echo $total_anggota; ?></strong></td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.'); ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
