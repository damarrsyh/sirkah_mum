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
  Laporan Calon Debitur 
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
  </div>

</div>
<hr />
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title" rowspan="2">No.</td>
      <td class="title" rowspan="2">Tanggal</td>
      <td class="title" colspan="2">Anggota</td>
      <td class="title" rowspan="2">Sumber Dana</td>
      <td class="title" rowspan="2">Majelis</td>
      <td class="title" rowspan="2">Produk </td>
      <td class="title" rowspan="2">Plafon</td>      
      <td class="title" rowspan="2">NIK</td>  
      <td class="title" rowspan="2">Mariage</td> 
      <td class="title" rowspan="2">Pendidikan</td> 
      <td class="title" rowspan="2">Pekerjaan</td>   

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
		$pembiayaan = $data['financing_type'];
		$droping_date = $data['droping_date'];
		$rekening = $data['account_financing_no'];
		$nama = $data['nama'];
		$majelis = $data['cm_name'];
		$nick = $data['nick_name'];
		$dtp = $data['dtp'];
		$dts = $data['dts'];
    $pengguna_dana = $data['pengguna_dana'];
    $no_hp = $data['no_hp'];
    $sumber_dana = $data['krd']; 
    $no_ktp = $data['no_ktp']; 
    $status_perkawinan = $data['status_perkawinan']; 
    

		$total_pokok += $pokok;
        $total_margin += $margin;

        $total_pokok_persen += 0.05 * $pokok;

    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $CI->format_date_detail($droping_date,'id',false,'/'); ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $sumber_dana; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $nick; ?></td>      	
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td> 
      <td class="konten"><?php echo $no_ktp; ?></td>  
      <td class="konten"><?php echo $status_perkawinan; ?></td>   
       


    </tr>
    <?php } ?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td> 
      <td>&nbsp;</td> 
      <td>&nbsp;</td>


    </tr>
  </tbody>
</table>
