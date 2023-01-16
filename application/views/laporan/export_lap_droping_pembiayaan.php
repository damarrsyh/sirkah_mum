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
	padding: 7px;
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
  Laporan Pencairan Pembiayaan
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" rowspan="2">Tanggal</td>
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Pembiayaan</td>
      <td class="title" rowspan="2">Sumber Dana</td>
      <td class="title" rowspan="2">Majelis</td>
      <td class="title" rowspan="2">PYD </td>
      <td class="title" rowspan="2">Produk </td>
      <td class="title" rowspan="2">Plafon</td>
      <td class="title" rowspan="2">Margin</td>
      <td class="title" rowspan="2">Periode</td>
      <td class="title" rowspan="2">Jangka<br />Waktu</td>
      <td class="title" rowspan="2">T. Jatuh<br />Tempo</td>
      <td class="title" rowspan="2">Biaya<br />Admin</td> 
      <td class="title" rowspan="2">Dana<br />Pendidikan</td>
      <td class="title" rowspan="2">Biaya<br />Asuransi</td>
      <td class="title" rowspan="2">Plafon<br />Sebelumnya</td>
      <td class="title" rowspan="2">Keterangan</td>
      <td class="title" rowspan="2">Pengguna Dana</td>
      <td class="title" rowspan="2">Peruntukan</td>
      <td class="title" rowspan="2">Sektor</td>
      <td class="title" rowspan="2">No Hp</td>
      
    </tr>
    <tr>
      <td class="title">No. Rekening</td>
      <td class="title">Nama</td>
    </tr>
    <?php 
    $no = 1;
    $total_pokok = 0;
	  $total_margin = 0;
	  $total_pokok_persen = 0;

	foreach ($result as $data){
		$pokok = $data['pokok'];
		$margin = $data['margin'];
		$periode = $data['periode_jangka_waktu'];
		$pyd = $data['pembiayaan_ke'];
		$s_pokok = $data['pokok_sebelum'];
		$pembiayaan = $data['financing_type'];
		$droping_date = $data['droping_date'];
		$rekening = $data['account_financing_no'];
		$nama = $data['nama'];
		$majelis = $data['cm_name'];
		$nick = $data['nick_name'];
		$jangka_waktu = $data['jangka_waktu'];
		$dtp = $data['dtp'];
		$dts = $data['dts'];
		$description = $data['description'];
    $pengguna_dana = $data['pengguna_dana'];
    $no_hp = $data['no_hp'];
    $biaya_administrasi = $data['biaya_administrasi'];
    $cadangan_resiko = $data['cadangan_resiko'];
    $biaya_asuransi_jiwa = $data['biaya_asuransi_jiwa'];
    $sumber_dana = $data['krd'];
    $tgl_jtempo = $data['tanggal_jtempo'];

		$total_pokok += $pokok;
        $total_margin += $margin;

        $total_pokok_persen += 0.05 * $pokok;

		if($periode == 0){
			$periode_jangka_waktu = 'Harian';
        } else if($periode == 1){
			$periode_jangka_waktu = 'Mingguan';
        } else if($periode == 2){
			$periode_jangka_waktu = 'Bulanan';
        } else{
			$periode_jangka_waktu = 'Jatuh Tempo';
        }

		if($pyd == 1){
			$keterangan = 'Droping Baru';
        } else if($pokok == $s_pokok){
			$keterangan = 'Droping Tetap';
		} else if($pokok > $s_pokok){
			$keterangan = 'Droping Naik';
		} else {
			$keterangan = 'Droping Turun';
		}
		
		if($pembiayaan == 0){
			$jenis = 'Kelompok';
		} else {
			$jenis = 'Individu';
		}

    if($pengguna_dana == 1){
      $pengguna_dana = 'Anggota';
    } else if ($pengguna_dana == 2 ) {
      $pengguna_dana = 'Suami';
    } else {
      $pengguna_dana = 'Anak';
    }

    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($droping_date,'id',false,'/'); ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $jenis; ?></td>
      <td class="konten"><?php echo $sumber_dana; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $pyd; ?></td>
      <td class="konten"><?php echo $nick; ?></td>      	
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($margin,0,',','.'); ?></td>
      <td class="konten"><?php echo $periode_jangka_waktu; ?></td>
      <td class="konten"><?php echo $jangka_waktu; ?></td>
      <td class="konten"><?php echo $tgl_jtempo; ?></td>
      <td class="konten"><?php echo number_format($biaya_administrasi,0,',','.'); ?></td>
      <td class="konten"><?php echo number_format($cadangan_resiko,0,',','.'); ?></td> 
      <td class="konten"><?php echo number_format($biaya_asuransi_jiwa,0,',','.'); ?></td>
      <td class="nominal"><?php echo number_format($s_pokok,0,',','.'); ?></td>
      <td class="konten"><?php echo $keterangan; ?></td>
      <td class="konten"><?php echo $pengguna_dana; ?></td>
      <td class="konten"><?php echo $dtp.'<br>'.$description; ?></td>
      <td class="konten"><?php echo $dts; ?></td>
      <td class="konten"><?php echo $no_hp; ?></td>
    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td> 
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_margin,0,',','.');?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td> 
      
    </tr>
  </tbody>
</table>
