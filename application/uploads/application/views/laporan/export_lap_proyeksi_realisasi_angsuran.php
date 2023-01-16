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
	font-size: 9px;
	font-weight: bold;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 8px;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 8px;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 8px;
	font-weight: bold;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 8px;
	font-weight: bold;
	color: #000;
	padding: 7px;
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
  Laporan Proyeksi Realisasi Angsuran
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Produk : <?php echo $produk; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Majelis</td>
      <td class="title" rowspan="2">Produk </td>
      <td class="title" rowspan="2">Plafon</td>
      <td class="title" rowspan="2">Margin</td>
      <td class="title" rowspan="2">Tanggal Droping</td>
      <td colspan="2" class="title">Proyeksi Angsuran</td>
      <td colspan="2" class="title">Realisasi Angsuran</td>
      <td class="title" rowspan="2">Saldo Pokok</td>
      <td class="title" rowspan="2">Saldo Margin</td>
      <td class="title" rowspan="2">Saldo Hutang</td>
    </tr>
    <tr>
      <td class="title">No. Rekening</td>
      <td class="title">Nama</td>
      <td class="title">Angs. Pokok</td>
      <td class="title">Angs. Margin</td>
      <td class="title">Angs. Pokok</td>
      <td class="title">Angs. Margin</td>
    </tr>
    <?php 
    $no = 1;
	$total_pokok = 0;
	$total_margin = 0;
	$total_angsuran_pokok = 0;
	$total_angsuran_margin = 0;
	$total_saldo_pokok = 0;
	$total_saldo_margin = 0;
	$total_saldo_hutang = 0;

	foreach ($result as $data){
		$pokok = $data['pokok'];
		$rekening = $data['account_financing_no'];
		$rembug = $data['cm_name'];
		$nick = $data['nick_name'];
		$nama = $data['nama'];
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$tanggal_akad = $data['tanggal_akad'];
		$angsuran_pokok = $data['angsuran_pokok'];
		$angsuran_margin = $data['angsuran_margin'];
		$saldo_pokok = $data['saldo_pokok'];
		$saldo_margin = $data['saldo_margin'];

		$saldo_hutang = $saldo_pokok + $saldo_margin;

		$total_pokok += $pokok;
		$total_margin += $margin;
		$total_angsuran_pokok += $angsuran_pokok;
		$total_angsuran_margin += $angsuran_margin;
		$total_saldo_pokok += $saldo_pokok;
		$total_saldo_margin += $saldo_margin;
		$total_saldo_hutang += $saldo_hutang;
    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $rembug; ?></td>
      <td class="konten"><?php echo $nick; ?></td>      	
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $tanggal_akad; ?></td>
      <td class="nominal">0</td>
      <td class="nominal">0</td>
      <td class="nominal"><?php echo number_format($angsuran_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($angsuran_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_hutang,0,',','.'); ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_margin,0,',','.');?></td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo">0</td>
      <td class="total_saldo">0</td>
      <td class="total_saldo"><?php echo number_format($total_angsuran_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_angsuran_margin,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_saldo_margin,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_saldo_hutang,0,',','.');?></td>
    </tr>
  </tbody>
</table>
