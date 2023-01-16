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
	padding: 6px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 9px;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 9px;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 9px;
	font-weight: bold;
	color: #000;
	padding: 7px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 9px;
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
  Laporan List Saldo Anggota Bulan Lalu
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
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Rembug Pusat</td>
      <td class="title" rowspan="2">Desa</td>
      <td class="title" rowspan="2">Pembiayaan<br>Pokok</td>
      <td class="title" rowspan="2">Pembiayaan<br>Margin</td>
      <td class="title" colspan="4">Saldo Simpanan</td>
      <td class="title" colspan="3">Saldo Pembiayaan</td>
      <td class="title" rowspan="2">Saldo Tabber</td>
    </tr>
    <tr>
      <th class="title" align="center">Cif No</th>
      <td class="title" align="center">Nama</td>
      <td class="title" align="center" >LWK</td>
      <td class="title" align="center" >Wajib</td>
      <td class="title" align="center" >Kelompok</td>
      <td class="title" align="center" >Sukarela</td>
      <td class="title" align="center" >Pokok</td>
      <td class="title" align="center" >Margin</td>
      <td class="title" align="center" >Catab </td>
    </tr>
  </thead>
  <tbody>
  	<?php 
	$no = 1;
	foreach($result as $data){
		$cif_no = $data['cif_no'];
		$nama = $data['nama'];
		$rembug = $data['cm_name'];
		$desa = $data['desa'];
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$lwk = $data['setoran_lwk'];
		$saldo_tab_sukarela = $data['saldo_tab_sukarela'];
		$saldo_tab_wajib = $data['saldo_tab_wajib'];
		$saldo_tab_kelompok = $data['saldo_tab_kelompok'];
		$saldo_pokok = $data['saldo_pokok'];
		$saldo_margin = $data['saldo_margin'];
    $saldo_catab = $data['saldo_catab'];
		$saldo_tabber = $data['saldo_tabber'];
	?>    
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $cif_no; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $rembug; ?></td>
      <td class="konten"><?php echo $desa; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($lwk,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_tab_wajib,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_tab_kelompok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_tab_sukarela,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_catab,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_tabber,0,',','.'); ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>
