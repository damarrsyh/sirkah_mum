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
  /*width: 100px;*/
}
#hor-minimalist-b .title {
  font-size: 11px;
  font-weight: bold;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: center;
  width: 50px;
}

#hor-minimalist-b .konten {
  font-size: 11px;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: center;
}

#hor-minimalist-b .nominal {
  font-size: 11px;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: right;
}

#hor-minimalist-b .total_saldo {
  font-size: 9px;
  font-weight: bold;
  color: #000;
  padding: 8px;
  border: 1px solid #262626;
  text-align: right;
}

#hor-minimalist-b .zero {
  font-size: 9px;
  font-weight: bold;
  color: #000;
  padding: 8px;
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
  Laporan Wakalah
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Petugas : <?php echo $petugas; ?>
  </div>
  <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
  Jenis Pembiayaan : <?php echo $pembiayaan; ?>
  </div>
  <div style="text-align:right;padding-top:10px;font-family:Arial;font-size:13px;margin-top: -50px;">
  Produk : <?php echo $produk; ?>
  </div>
  <div style="text-align:right;padding-top:10px;font-family:Arial;font-size:13px;">
  Majelis : <?php echo $majelis; ?>
  </div>
  <hr>
</div>
<table id="hor-minimalist-b" align="center">
  <tbody>
  	<tr>
      <td class="title">No</td>
      <td class="title">Tanggal<br/>Wakalah</td>
      <td class="title">Nomor<br/>Rekening</td>
      <td class="title">Nama</td>
      <td class="title">Majelis</td>
      <td class="title">Produk</td>
      <td class="title">jumlah Wakalah</td>
      <td class="title">Petugas</td>
      <td class="title">Status</td>
    </tr>

    <?php 
	$no = 1;

	foreach($result as $data){
		$tanggal_wakalah    = $data['tanggal_wakalah'];
    $rekening           = $data['account_financing_no'];
    $nama               = $data['nama'];
    $majelis            = $data['cm_name'];
		$product            = $data['product_name'];
    $pokok              = $data['jumlah_wakalah'];
    $petugas            = $data['fa_name'];
    $status_wakalah     = $data['status_wakalah'];

		if($status_wakalah == 0){
	   $status = 'Registrer';
    } else{
     $status = 'Reverse';
    }

    ?>
    <tr>
      <td class="konten"><?php echo $no++; ?></td>
      <td class="konten"><?php echo $tanggal_wakalah; ?></td>
      <td class="konten"><?php echo $rekening; ?></td>
      <td class="konten"><?php echo $nama; ?></td>
      <td class="konten"><?php echo $majelis; ?></td>
      <td class="konten"><?php echo $product; ?></td>
      <td class="nominal"><?php echo number_format($pokok,0,',','.'); ?></td>
      <td class="konten"><?php echo $petugas; ?></td>
      <td class="konten"><?php echo $status; ?></td>
      
    </tr>      
    <?php } ?>
  </tbody>
</table>
