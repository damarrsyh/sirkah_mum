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
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 11px;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
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
    LAPORAN REKAP TRANSAKSI INDIVIDU
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    PETUGAS : <?php echo $petugas;?>  
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    MAJELIS : <?php echo $majelis;?>  
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    TANGGAL : <?php echo $from.' - '.$thru;?>  
    </div>
  <hr>
</div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
        <td rowspan="2" class="title">No</td>
        <td rowspan="2" class="title">No Rekening</td>
        <td rowspan="2" class="title">Majlis</td>
        <td rowspan="2" class="title">Nama</td>
        <td rowspan="2" class="title">Produk</td>
        <td colspan="2" class="title">Reaslisasi Pembiayaan</td>
        <td colspan="6" class="title">Angsuran</td>
      </tr>
      <tr>
        <td class="title">Plafon</td>
        <td class="title">Asuransi</td>
        <td class="title">Saldo</td>
        <td class="title">Bayar</td>
        <td class="title">Tunggak</td>
        <td class="title">@</td>
        <td class="title">Ext</td>
        <td class="title">Jumlah Ext</td>
      </tr>
      <?php
      $no = 1;
      
      $total_pokok = 0;
      $total_asuransi = 0;
      $total_angsuran = 0;

	  foreach($rekap as $data){
		  $rekening = $data['account_financing_no'];
		  $rembug = $data['cm_name'];
		  $nama = $data['nama'];
		  $pokok = $data['pokok'];
		  $adm = $data['biaya_administrasi'];
		  $asuransi = $data['biaya_asuransi_jiwa'];
		  $saldo = $data['jangka_waktu']-$data['counter_angsuran'];
		  $bayar = $data['counter_angsuran'];
		  $tunggakan = $data['tunggakan'];
		  $angsuran = $data['angsuran'];
      $product_name = $data['product_name'];
		  
		  if($tunggakan < 0){
			  $tunggakan = 0;
		  }

      $total_pokok += $pokok;
      $total_asuransi += $asuransi;
      $total_angsuran += $angsuran;
      ?>
      <tr class="value">
        <td class="konten"><?php echo $no++;?></td>
        <td class="konten"><?php echo $rekening;?></td>
        <td class="konten"><?php echo $rembug;?></td>
        <td class="konten"><?php echo $nama;?></td>
        <td class="konten"><?php echo $product_name;?></td>
        <td class="konten"><?php echo number_format($pokok,0,',','.');?></td>
        <td class="konten"><?php echo number_format($asuransi,0,',','.');?></td>
        <td class="konten"><?php echo $saldo;?></td>
        <td class="konten"><?php echo number_format($bayar,0,',','.');?></td>
        <td class="konten"><?php echo $tunggakan;?></td>
        <td class="konten"><?php echo number_format($angsuran,0,',','.');?></td>
        <td class="konten">&nbsp;</td>
        <td class="konten">&nbsp;</td>
      </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_asuransi,0,',','.');?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_angsuran,0,',','.');?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>    
    </tbody>
</table>
<table cellspacing="0" cellpadding="0" align="right" style="padding-top:10px;padding-right:35px;">
  <thead>
    <tr>
      <td style="background:#F7F7F7; width:96px; font-size:10px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777">Ttd. TPL</td>
      <td style="background:#F7F7F7; width:96px; font-size:10px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. Ketua Majelis</td>
      <td style="background:#F7F7F7; width:96px; font-size:10px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. ADM</td>
      <td style="background:#F7F7F7; width:96px; font-size:10px; line-height:15px; height:15px; text-align:center; font-weight:bold; border-top:solid 1px #777; border-bottom:solid 1px #777; border-right:solid 1px #777;">Ttd. Pemeriksa</td>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777; border-left:solid 1px #777;">&nbsp;</td>
      <td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
      <td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
      <td style="border-bottom:solid 1px #777; height:30px; border-right:solid 1px #777; border-right:solid 1px #777;">&nbsp;</td>
    </tr>
  </tbody>
</table>