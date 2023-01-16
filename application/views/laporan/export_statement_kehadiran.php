<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 11px;
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
#hor-minimalist-b .ket_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 10%;
  font-weight: bold;
  text-align: center;
  padding: 3px 5px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}

/*value*/
.value
{
  font-size: 10px;
}
#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  padding: 6px 5px;
  text-align: center;
}
</style>
<page>
<div style="width:100%;">
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
  <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
  </div>
  <div style="text-align:center;padding-top:8px;font-family:Arial;font-size:18px;">
  <?php echo $branch['branch_name']; ?>  
  </div>
  <div style="text-align:center;padding-top:8px;font-family:Arial;font-size:18px;">
    History Kehadiran Anggota 
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:13px;">
  <?php echo  $anggota['cif'];?>   ( <?php echo  $anggota['cabang'];?> ) 
  </div> 
  <div style="text-align:center;padding-top:5px;font-family:Arial;font-size:13px;">
    Tanggal : <?php echo $from_date; ?> s/d <?php echo $thru_date; ?>
  </div>
  <hr>
</div>
<table id="hor-minimalist-b" style="margin:0;" align="center">
  <thead>
    <tr>
      <th style="padding:5px; text-align: center; border:solid 1px #555; font-weight: bold; font-size: 11px; width:20px;">No.</th>
      <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:70px;">Tanggal </th>
      <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-weight: bold; font-size: 11px; width:70px;">Keterangan</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $no=1;
      ///$saldo = $saldo_awal;
      foreach ($datas as $data):
      ///$saldo += $data['amount_credit']-$data['amount_debit'];
    ?>
    <tr class="value">
      <td style="padding:5px; font-size:11px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
      <td style="padding:5px; font-size:11px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo date('d/m/Y',strtotime($data['trx_date']));?></td>
      <td style="padding:5px; font-size:10px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center; white-space:normal; "><?php echo $data['absen'] ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>

</table>
</page>