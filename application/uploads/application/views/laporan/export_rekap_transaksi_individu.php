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
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
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
		  
		  if($tunggakan < 0){
			  $tunggakan = 0;
		  }
      ?>
      <tr class="value">
        <td class="konten"><?php echo $no++;?></td>
        <td class="konten"><?php echo $rekening;?></td>
        <td class="konten"><?php echo $rembug;?></td>
        <td class="konten"><?php echo $nama;?></td>
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
    </tbody>
</table>
