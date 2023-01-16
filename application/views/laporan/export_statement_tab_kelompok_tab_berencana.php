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
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
    <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
    <?php echo $nama['cabang']; ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
      Statement Tabungan Berencana
    </div>
    <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
      Nama : <?php echo $nama['cif'];?>
    </div>
    <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:13px;">
      No Rekening : <?php echo $no_rekening;?>
    </div>
    <div style="text-align:right;margin-top:-35px;font-family:Arial;font-size:13px;">
      Tabungan : Tabungan Berencana
    </div>
    <div style="text-align:right;padding-top:5px;font-family:Arial;font-size:13px;">
      Tanggal : <?php echo $from_date; ?> s/d <?php echo $thru_date; ?>
    </div>
    <hr>
  </div>
  <table id="hor-minimalist-b" style="margin:0;" align="center">
    <thead>
      <tr>
        <th style="padding:5px; text-align: center; border:solid 1px #555; font-size:11px; font-weight: bold; width:20px;">No.</th>
        <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-size:11px; font-weight: bold; width:70px;">Tanggal </th>
        <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-size:11px; font-weight: bold; width:100px;">Keterangan</th>
        <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-size:11px; font-weight: bold; width:90px;">Debit</th>
        <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-size:11px; font-weight: bold; width:90px;">Credit</th>
        <th style="padding:5px; text-align: center; border-bottom:solid 1px #555; border-top: solid 1px #555; border-right: solid 1px #555; font-size:11px; font-weight: bold; width:100px;">Saldo</th>
      </tr>
    </thead>
    <tbody>
      <tr class="value">
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;">1</td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;">-</td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;">Saldo Awal</td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;">-</td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;">-</td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($saldo_awal,0,',','.');?></td>
      </tr>
      <?php 
        $no=2;
        $saldo = $saldo_awal;
        foreach ($datas as $data):
        $saldo += $data['amount_credit']-$data['amount_debit'];
      ?>
      <tr class="value">
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555; text-align: center;"><?php echo $no++;?></td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center;"><?php echo date('d/m/Y',strtotime($data['trx_date']));?></td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:center; white-space:normal; width:200px;"><?php echo $data['description'] ?></td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:left;" align="right"><?php echo number_format($data['amount_debit'],0,',','.');?></td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:left;" align="right"><?php echo number_format($data['amount_credit'],0,',','.');?></td>
        <td style="padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; text-align:right;"><?php echo number_format($saldo,0,',','.');?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</page>