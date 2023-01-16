<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 9px;
  background: #fff;
  margin: 10px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 15px;
  font-weight: normal;
  color: #000;
  padding: 10px 8px;
  border-top: 2px solid #6678b1;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b .ket
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 70%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .ket_NaN
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 70%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .th_ket
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 12.5px;
  width: 70%;
  padding: 6px 8px;
  padding-left: 2px;
}
#hor-minimalist-b .ket_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: center;
  padding: 4px 3px;
}
#hor-minimalist-b .ket_bold_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
  padding: 6px 3px;
}
.ket_bold_total
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: right;
  padding: 6px 3px;
}
.val{
  font-weight: normal;
  font-size: 9px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 3%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .tanggal
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .anggota-luhur
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 26%;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b th .nominal
{
  border-bottom: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  text-align: right;
  padding: 6px 8px;
}
.val .ket_bold, .val .no_bold{
  text-align: center;
  font-weight: normal;
}.val_bold .no_bold{
  font-size: 9px;
  text-align: right;
  font-weight: bold;
}
.val_bold .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
.anggka
{
  width: 8.5%;
  text-align: right;
}


-->
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        Laporan Pencairan Tabungan Berencana
        </div>
        <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:12px;">
        Tanggal : <?php echo $CI->format_date_detail($tanggal1_,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_,'id',false,'-');?>
        </div>
        <hr>
      </div>
  
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:10px;">
    <tbody>
      <tr>
        <td style="text-align: center; border:solid 1px #555; font-weight: bold; font-size: 9px; width:20px;">No.</td>
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:70px;">ID Anggota</td>
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:80px;">Nama</td>
  			<td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:80px;">Majelis</td>
  			<td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:100px;">Produk</td>
  			<td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:30px;">Tgl Buka</td>			
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:30px;">Jk Waktu</td>
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:30px;">Tgl Cair</td>
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:50px;">Pencairan</td>
        <td style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 9px; width:30px;">Verifikasi</td>
      </tr>
      <?php 
        $no=1;
        $total_pencairan = 0;
        foreach ($result as $data):
        $total_pencairan += $data['pencairan'];
		$status = $data['trx_status'];
		
		if($status == 1){
			$verif = 'Ya';
		} else {
			$verif = 'Tidak';
		}
      ?>
      <tr>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $data['id_anggota'];?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nama'];?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['majelis'];?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555;"><?php echo $data['nick_name'];?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['tanggal_buka'],'id',false,'-');?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $data['jangka_waktu'];?> Minggu</td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align: center;"><?php echo $CI->format_date_detail($data['tanggal_cair'],'id',false,'-');?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($data['pencairan'],0,',','.');?></td>
        <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo $verif;?></td>
      </tr>
      <?php endforeach?>
      <tr>
        <td colspan="8" style="text-align: right; padding:5px; font-size:10px; border-bottom:solid 1px #555; border-left: solid 1px #555;">Total</td>
        <td style="text-align: right; padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;"><?php echo number_format($total_pencairan,0,',','.');?></td>
        <td style="text-align: right; padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;">&nbsp;</td>
      </tr>
    </tbody>
</table>
</page>