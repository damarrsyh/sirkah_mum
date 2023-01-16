<?php
$CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin-top: 10px;
  border-collapse: collapse;
  /*text-align: left;*/
}
#hor-minimalist-b td {
  font-size: 12px;
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
  width: 9%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 14%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 2%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
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
  /*text-align: center;*/
}
#hor-minimalist-b .anggota-luhur
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 20%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b th .nominal
{
  border-bottom: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  /*text-align: right;*/
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
  /*text-align: right;*/
  padding: 6px 8px;
}

/*value*/
.value
{
  /*font-size: 11px;*/
}

#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val_ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  padding: 5px 0 5px 0;
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
        Daftar  Simpanan Pokok
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
        <tr>
          <td colspan="2" align="center" valign="middle" class="anggota-luhur">Anggota</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:50px;">Rembug Pusat</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:50px;">Tabungan Wajib</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:20px;">Tabungan Kelompok</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:30px;">Simpanan Pokok</td>
          <td rowspan="2" align="center" valign="middle" class="anggota2" style="width:30px;">SMK</td>
        </tr>
        <tr>
          <td align="center" valign="middle" class="no_bold" style="wiidth:85px;">ID</td>
          <td align="center" valign="middle" class="no_bold" style="width:45px;">Nama</td>
        </tr>
     <?php 
        $no=1;
        $total_tabungan_wajib = 0;
        $total_tabungan_kelompok = 0;
        $total_simpanan_pokok = 0;
        $total_smk = 0;
        foreach ($simpanan_pokok as $data):
          $total_tabungan_wajib += $data['tabungan_wajib'];
          $total_tabungan_kelompok += $data['tabungan_kelompok'];
          $total_simpanan_pokok += $data['simpanan_pokok'];
          $total_smk += $data['smk'];
      ?>

      <tr class="value">
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;"><?php echo $data['cif_no'];?></td>
        <td align="left" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['nama'];?></td>
        <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['cm_name'];?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tabungan_wajib'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tabungan_kelompok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['simpanan_pokok'],0,',','.');?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['smk'],0,',','.');?></td>
      </tr>
     <?php 
          endforeach;
      ?>
      <tr class="value">
        <td colspan="3" align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;"><strong>Total</strong></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($total_tabungan_wajib);?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($total_tabungan_kelompok);?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($total_simpanan_pokok);?></td>
        <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($total_smk);?></td>
      </tr>
    </tbody>
</table>
</page>