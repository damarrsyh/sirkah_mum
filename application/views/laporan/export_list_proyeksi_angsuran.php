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
	padding: 5px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 10px;
	color: #000;
	padding: 5px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 10px;
	color: #000;
	padding: 5px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 5px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 5px;
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
    Laporan Proyeksi Angsuran Pembiayaan
  </div>
  <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
    Tanggal : <?php echo @$CI->format_date_detail($from,'id',false,'-'); ?> s.d <?php echo @$CI->format_date_detail($thru,'id',false,'-'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Pembiayaan : <?php echo $jenis; ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Sumber Dana : <?php echo $post_kreditur; ?>
  </div>
  <hr>
</div>

<table id="hor-minimalist-b" align="center">
  <thead>
  	<tr>
      <td rowspan="2" class="title">No</td>
      <td colspan="3" class="title">Anggota </td>
      <td colspan="8" class="title">Pembiayaan</td>
      <td colspan="4" class="title">Proyeksi Jadwal Angs</td>       
      <td colspan="4" class="title">Proyeksi Penerimaan Angs</td>
    </tr>
  	<tr>
  	  <td class="title">Rekening</td>
  	  <td class="title" style="width: 120px;">Nama</td>
      <td class="title" style="width: 90px;">Majlis</td>
      
      <td class="title">Plafon</td>
      <td class="title">Margin</td>
      <td class="title">Jk<br>Waktu</td>
      <td class="title">Jumlah<br>Angs</td>        
      <td class="title">Angs<br>masuk</td> 
      <td class="title">Sisa<br>Angs</td> 
      <td class="title">Sisa<br>Pokok</td> 
      <td class="title">Sisa<br>Margin</td> 

      <td class="title">Jml</td>
      <td class="title">Angs<br>ke</td> 
      <td class="title"> s.d </td>
      <td class="title">Nominal</td>

      <td class="title">Jml</td>
      <td class="title">Angs<br>ke</td> 
      <td class="title"> s.d </td>
      <td class="title">Nominal</td>
    </tr>
    
  </thead> 
  <tbody>
	<?php
    $no = 1; 
    
    $total_pokok = 0;
    $total_margin = 0;
    $total_saldo_pokok = 0;
    $total_saldo_margin = 0;
    #$total_margin = 0;
    #$total_catab = 0;


    foreach($result as $data){
		$rekening         = $data['account_financing_no'];
		$nama             = $data['nama'];
		$majelis          = $data['cm_name'];
		$pokok            = $data['pokok'];
		$margin           = $data['margin'];
		$jangka_waktu     = $data['jangka_waktu'];
		$angsuran_pokok   = $data['angsuran_pokok'];
		$angsuran_margin  = $data['angsuran_margin'];
    $angsuran_catab   = $data['angsuran_catab'];
    $total_angsuran   = $angsuran_pokok+$angsuran_margin+$angsuran_catab;
    $counter_angsuran   = $data['counter_angsuran'];
    $saldo_pokok        = $data['saldo_pokok'];
    $saldo_margin       = $data['saldo_margin'];
    $proyeksi_count     = $data['proyeksi_count']-$data['hari_libur1'];
    if ($proyeksi_count>$jangka_waktu) {$proyeksi_count=$jangka_waktu;};
    $proyeksi_count2    = $data['proyeksi_count2']-$data['hari_libur2'];
    $proyeksi_nominal   =($proyeksi_count2-$proyeksi_count+1)*$total_angsuran; 

    if ($counter_angsuran>=$jangka_waktu) {
        $proyeksi_bayar=0; $real_count=0; $real_count2=0; $real_nominal=0; 
    } else {
        $proyeksi_bayar=$data['proyeksi_bayar']; 
        $counter_lebih=$counter_angsuran+$proyeksi_bayar-$jangka_waktu;
        if ($counter_lebih>0) {$proyeksi_bayar=$proyeksi_bayar-$counter_lebih;};        
        $real_count=$counter_angsuran+1; 
        $real_count2=$counter_angsuran+$proyeksi_bayar; 
        $real_nominal=$proyeksi_bayar*$total_angsuran ;
    }  

		$total_pokok += $pokok;
    $total_margin += $margin;
    $total_saldo_pokok += $saldo_pokok;
    $total_saldo_margin += $saldo_margin;
    
    ?>
  	<tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten" style="text-align:left;"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $jangka_waktu; ?></td>
      <td class="nominal"><?php echo number_format($total_angsuran,0,',','.'); ?></td>
      <td class="konten"><?php echo $counter_angsuran; ?></td>
      <td class="konten"><?php echo $jangka_waktu-$counter_angsuran; ?></td>
      <td class="nominal"><?php echo number_format($saldo_pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($saldo_margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $proyeksi_count2-$proyeksi_count+1; ?></td>
      <td class="konten"><?php echo $proyeksi_count; ?></td>
      <td class="konten"><?php echo $proyeksi_count2; ?></td>
      <td class="nominal"><?php echo number_format($proyeksi_nominal,0,',','.'); ?></td>
      <!---<td class="konten"><?php echo $real_count2-$real_count+1; ?></td>
        -->
      <td class="konten"><?php echo $proyeksi_bayar; ?></td>
      <td class="konten"><?php echo $real_count; ?></td>
      <td class="konten"><?php echo $real_count2; ?></td>
      <td class="nominal"><?php echo number_format($real_nominal,0,',','.'); ?></td>

    </tr>
    <?php } ?>
    <tr>
      <td colspan="4" class="title"><strong>Total</strong></td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_margin,0,',','.');?></td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <!---
      <td class="total_saldo"><?php echo number_format($$total_saldo_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($$total_saldo_margin,0,',','.');?></td>
      -->
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
      <td class="konten">&nbsp;</td>
    </tr>
  </tbody>
</table>
