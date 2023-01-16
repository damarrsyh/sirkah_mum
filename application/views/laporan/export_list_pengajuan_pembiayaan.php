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

#hor-minimalist-b .total_saldo {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 10px;
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
    Laporan List Pengajuan Pembiayaan
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    Tanggal : <?php echo $CI->format_date_detail($from,'id',false,'/');?> s.d <?php echo $CI->format_date_detail($thru,'id',false,'/'); ?>
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    Petugas : <?php echo $petugas; ?>
    </div>
    <hr>
  </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="title" rowspan="2">No</td>
            <td class="title" rowspan="2">Nomor<br />
            Registrasi</td>
            <td colspan="2" class="title">Anggota</td>
            <td rowspan="2" class="title">Pembiayaan</td>
            <td class="title" colspan="2">Tanggal</td>
            <td class="title" rowspan="2">Jumlah</td>
            <td class="title" rowspan="2">Status</td>
      </tr>
      <tr>
            <td class="title">Nama</td>
            <td class="title">Majelis</td>
            <td class="title">Pengajuan</td>
            <td class="title">Rencana<br />
            Cair</td>
      </tr>
      <?php 
	  $no=1;
      $total_amount    = 0;
      $total_jumlah_dicairkan = 0;

      foreach ($result as $data){
		  $amount = $data['amount'];
		  $stat = $data['status'];
		  $financing = $data['financing_type'];
		  $registration_no = $data['registration_no'];
		  $nama = $data['nama'];
		  $cm_name = $data['cm_name'];

		  $tanggal_pengajuan = $data['tanggal_pengajuan'];
		  $tanggal_pengajuan = $CI->format_date_detail($tanggal_pengajuan,'id',false,'/');
		  $rencana_droping = $data['rencana_droping'];
		  $rencana_droping = $CI->format_date_detail($rencana_droping,'id',false,'/');

		  $total_amount += $amount;

		  if($stat == 0){
			  $status = 'Registrasi';
          } else if($stat == 1){
			  $status = 'Aktivasi';
          } else if($stat == 2){
			  $status = 'Ditolak';
          } else if($stat == 3){
			  $status = 'Batal';
          }

		  if($financing == 0){
			  $jenis = 'Kelompok';
		  } else {
			  $jenis = 'Individu';
		  }
      ?>
      <tr>
            <td class="konten"><?php echo $no++; ?></td>
            <td class="konten"><?php echo $registration_no; ?></td>
            <td class="konten"><?php echo $nama; ?></td>
            <td class="konten"><?php echo $cm_name; ?></td>
            <td class="konten"><?php echo $jenis; ?></td>
            <td class="konten"><?php echo $tanggal_pengajuan; ?></td>
            <td class="konten"><?php echo $rencana_droping; ?></td>
            <td class="nominal"><?php echo number_format($amount,0,',','.');?></td>
            <td class="konten"><?php echo $status;?></td>
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
            <td class="total_saldo"><?php echo number_format($total_amount,0,',','.');?></td>
            <td>&nbsp;</td>
      </tr>
    </tbody>
</table>
