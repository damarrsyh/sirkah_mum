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
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 11px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 11px;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 9px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 11px;
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
  Laporan List Bagi Hasil SHU</div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $periode.'-01-01 s.d '.$periode.'-12-31'; ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title">No.</td>
      <td class="title">No. Anggota</td>
      <td class="title">Nama</td>
      <td class="title">Majelis</td>
      <td class="title">SHU</td>
    </tr>
    <?php 
    $no = 1;
	$total_bahas = 0;
	foreach ($result as $data){
		$cif_no = $data['cif_no'];
		$nama = $data['nama'];
		$majelis = $data['cm_name'];
		$bahas = $data['amount'];
		
		$total_bahas += $bahas;
    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $cif_no; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="nominal"><?php echo number_format($bahas,0,',','.'); ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td class="title" colspan="4">TOTAL</td>
      <td class="total_saldo"><?php echo number_format($total_bahas,0,',','.'); ?></td>
    </tr>
  </tbody>
</table>
