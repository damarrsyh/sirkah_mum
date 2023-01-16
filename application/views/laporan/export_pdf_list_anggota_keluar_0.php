<?php
$CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  background: #fff;
  margin-top: 10px;
  border-collapse: collapse;
  font-family: Arial, Helvetica, sans-serif;
  /*text-align: left;*/
}
#hor-minimalist-b .title
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 9px;
  padding: 5px 7px;
  text-align: center;
  /*text-align: center;*/
}
#hor-minimalist-b .konten
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-size: 8px;
  padding: 5px 7px;
  text-align: center;
  /*text-align: center;*/
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-size: 8px;
  padding: 5px 7px;
  text-align: right;
  /*text-align: center;*/
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
  List Anggota Keluar 
  </div>
  <hr>
</div>
<table id="hor-minimalist-b" align="center">
    <tbody>
        <tr>
          <td colspan="2" class="title">Anggota</td>
          <td rowspan="2" class="title">Rembug Pusat</td>
          <td rowspan="2" class="title">Tanggal<br /> 
            Gabung</td>
		      <td rowspan="2" class="title">Tanggal<br />
	         Keluar</td>
		      <td colspan="3" class="title">Saldo Pembiayan </td>
          <td colspan="7" class="title">Saldo Simpanan </td>
		      <td colspan="4" class="title">Pembiayaan Terakhir</td>
          <td rowspan="2" class="title">Alasan Keluar</td>
          <td rowspan="2" class="title">Keterangan Keluar</td>
        </tr>
        <tr>
          <td class="title">ID</td>
          <td class="title">Nama</td>
          <td class="title">Pokok</td>
          <td class="title">Margin</td>
          <td class="title">Catab</td>
          <td class="title">Wajib</td>
          <td class="title">Kelompok</td>
          <td class="title">Sukarela</td> 
          <td class="title">Tab.Ber</td> 
          <td class="title">Simpok</td>  
          <td class="title">SMK</td>
          <td class="title">LWK</td>           
		      <td class="title">PYD Ke</td>
          <td class="title">Tgl Droping</td>
          <td class="title">Plafon</td>
          <td class="title">Margin</td>         
        </tr>
        <?php 
          $no=1;
          $total_pokok = 0;
  		    $total_saldo_pembiayaan_pokok = 0;
  		    $total_saldo_pembiayaan_margin = 0;
  		    $total_saldo_pembiayaan_catab = 0;
      		$total_saldo_tab_wajib = 0;
      		$total_saldo_tab_kelompok = 0;
      		$total_saldo_tab_sukarela = 0; 
          $total_saldo_tab_berencana = 0; 
          $total_saldo_simpanan_pokok = 0;
          $total_saldo_smk = 0; 
          $total_saldo_lwk = 0;
        
          foreach ($list_anggota_keluar as $data):
          
          $total_pokok += $data['pokok_last'];
    		  $total_saldo_pembiayaan_pokok += $data['saldo_pembiayaan_pokok'];
    		  $total_saldo_pembiayaan_margin += $data['saldo_pembiayaan_margin'];
          $total_saldo_pembiayaan_catab += $data['saldo_pembiayaan_catab'];
    		  $total_saldo_tab_wajib += $data['saldo_tab_wajib'];
    		  $total_saldo_tab_kelompok += $data['saldo_tab_kelompok'];
    		  $total_saldo_tab_sukarela += $data['saldo_tab_sukarela']; 
          $total_saldo_tab_berencana += $data['saldo_tab_berencana']; 
          $total_saldo_simpanan_pokok += $data['saldo_simpanan_pokok']; 
          $total_saldo_smk += $data['saldo_smk']; 
          $total_saldo_lwk += $data['saldo_lwk'];  
        ?>

      <tr class="value">
        <td class="konten"><?php echo $data['cif_no'];?></td>
        <td class="konten"><?php echo $data['nama'];?></td>
        <td class="konten"><?php echo $data['cm_name'];?></td>
        <td class="konten"><?php echo @$CI->format_date_detail($data['tgl_gabung'],'id',false,'-');?></td>
        <td class="konten"><?php echo @$CI->format_date_detail($data['tanggal_mutasi'],'id',false,'-');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_pembiayaan_pokok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_pembiayaan_margin'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_pembiayaan_catab'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_tab_wajib'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_tab_kelompok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_tab_sukarela'],0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($data['saldo_tab_berencana'],0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($data['saldo_simpanan_pokok'],0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($data['saldo_smk'],0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($data['saldo_lwk'],0,',','.');?></td> 
        <td class="konten"><?php echo number_format($data['pembiayaan_ke_last'],0,',','.');?></td>
        <td class="konten"><?php echo @$CI->format_date_detail($data['tanggal_akad_last'],'id',false,'-');?></td>
        <td class="konten"><?php echo number_format($data['pokok_last'],0,',','.');?></td>
        <td class="konten"><?php echo number_format($data['margin_last'],0,',','.');?></td>
        <td class="konten"><?php echo $data['alasan_keluar'];?></td>
        <td class="konten"><?php echo $data['alasan'];?></td>
   	  </tr>
      <?php 
          endforeach;
      ?>
      <tr class="value">
        <td colspan="10" class="title">TOTAL</td>
        <td class="nominal"><?php echo number_format($total_saldo_pembiayaan_pokok,0,',','.');?></td>
        <td class="nominal"><?php echo number_format($total_saldo_pembiayaan_margin,0,',','.');?></td>
        <td class="nominal"><?php echo number_format($total_saldo_pembiayaan_catab,0,',','.');?></td>
        <td class="nominal"><?php echo number_format($total_saldo_tab_wajib,0,',','.');?></td>
        <td class="nominal"><?php echo number_format($total_saldo_tab_kelompok,0,',','.');?></td>
        <td class="nominal"><?php echo number_format($total_saldo_tab_sukarela,0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($total_saldo_tab_berencana,0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($total_saldo_simpanan_pokok,0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($total_saldo_smk,0,',','.');?></td> 
        <td class="nominal"><?php echo number_format($total_saldo_lwk,0,',','.');?></td>
        <td class="konten">&nbsp;</td>
        <td class="konten">&nbsp;</td>
        <td class="konten">&nbsp;</td>
        <td class="konten">&nbsp;</td>
      </tr>

      <!-- <tr class="value">
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;" colspan="5">Total :</td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_pokok,0,',','.');?></td>
      </tr> -->
    </tbody>
</table>
</page>