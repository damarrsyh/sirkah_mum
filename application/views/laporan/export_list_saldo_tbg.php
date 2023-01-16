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
	font-size: 12px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 11px;
	color: #000;
	padding: 11px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 11px;
	color: #000;
	padding: 11px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 11px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 11px;
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
  Laporan Saldo Tabungan 
  </div>
  
  
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <thead>
  	<tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" colspan="3">Anggota</td>
      <th class="title" rowspan="2">Majelis</th>
      <th class="title" rowspan="2">Produk</th>
      <th class="title" rowspan="2">Saldo</th>
    </tr>
    <tr>
      <th class="title">Rekening</th>
      <th class="title">Nama</th>
      <th class="title">KTP</th>
    </tr>
  </thead>
  <tbody>
  	<?php 
	$no = 1;
	$total_saldo = 0;

	foreach ($result as $data){
		$rekening = $data['account_saving_no'];
		$nama = $data['nama'];
		$ktp = $data['no_ktp'];
		$majelis = $data['cm_name'];
		$produk = $data['nick_name'];
		$saldo = $data['saldo_memo'];

		$total_saldo += $saldo;
	?>    
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $ktp; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $produk; ?></td>
      <td class="nominal"><?php echo number_format($saldo,0,',','.'); ?></td>
    </tr>
    <?php } ?>    
    <tr>
      <td class="title" colspan="6">Total</td>
      <td class="total_saldo"><?php echo number_format($total_saldo,0,',','.'); ?></td>
    </tr>
  </tbody>
</table>
