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
    Laporan Angsuran Pembiayaan
  </div>
  <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
    Tanggal : <?php echo @$CI->format_date_detail($from,'id',false,'-'); ?> s.d <?php echo @$CI->format_date_detail($thru,'id',false,'-'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
  <hr>
</div>

<table id="hor-minimalist-b" align="center">
  <thead>
  	<tr>
      <td rowspan="2" class="title">No</td>
      <td rowspan="2" class="title">Tgl. Bayar</td>
      <td colspan="2" class="title">Anggota </td>
      <td rowspan="2" class="title">Majelis</td>
      <td rowspan="2" class="title">Produk</td>
      <td rowspan="2" class="title">Plafon</td>
      <td rowspan="2" class="title">Margin</td>
      <td rowspan="2" class="title">Jangka Waktu</td>
      <td rowspan="2" class="title">Angs. Pokok </td>
      <td rowspan="2" class="title">Angs. Margin</td>
      <td rowspan="2" class="title">Angs. Catab</td>
      <td rowspan="2" class="title">Jml. Bayar </td>
    </tr>
  	<tr>
  	  <td class="title">Rekening</td>
  	  <td class="title">Nama</td>
    </tr>
  </thead> 
  <tbody>
	<?php
    $no = 1; 
    $total_bayar = 0;
    foreach($result as $data){
		$trx_date = $data['trx_date'];
		$trx_date = @$CI->format_date_detail($trx_date,'id',false,'-');
		$rekening = $data['account_financing_no'];
		$nama = $data['nama'];
		$majelis = $data['cm_name'];
		$produk = $data['nick_name'];
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$jangka_waktu = $data['jangka_waktu'];
		$angsuran_pokok = $data['angsuran_pokok'];
		$angsuran_margin = $data['angsuran_margin'];
    $angsuran_catab = $data['angsuran_catab'];
		$jml_bayar = $data['jml_bayar'];

		$total_bayar += $jml_bayar;      
    ?>
  	<tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $trx_date; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $produk; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $jangka_waktu; ?></td>
      <td class="nominal"><?php echo number_format($angsuran_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($angsuran_margin,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($angsuran_catab,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($jml_bayar,0,',','.'); ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="12" class="title"><strong>Total</strong></td>
      <td class="total_saldo"><?php echo number_format($total_bayar,0,',','.');?></td>
    </tr>
  </tbody>
</table>
