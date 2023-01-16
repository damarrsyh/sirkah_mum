<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
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
#hor-minimalist-b .no
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
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

/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #262626;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
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
        Laporan Rekap PAR Tanggal <?php echo $tanggal;?>
      </div>
      <hr>
    </div>
    <table id="hor-minimalist-b" align="center">
      <thead>  
        <tr>
          <th valign="middle" class="no" style="padding-top:5px;padding-bottom:5px;width:10px;font-size:11px;border:solid 1px #262626;" rowspan="2">NO</th>
          <th valign="middle" align="center" style="width:140px;padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" rowspan="2">PORTOFOLIO AT RISK</th>
          <th valign="middle" align="center" style="padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" rowspan="2">ANGGOTA</th> 
          <th valign="middle" align="center" style="padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" rowspan="2">AKUN</th> 
          <th valign="middle" align="center" style="width:85px;padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" rowspan="2">OUTSTANDING</th>
          <th valign="middle" align="center" style="padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" rowspan="2">RESIKO</th> 
          <th valign="middle" align="center" style="padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border:solid 1px #262626;" colspan="2">PENCADANGAN</th> 
        </tr>
        <tr>
          <th align="center" style="padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border-right:solid 1px #262626;border-bottom:solid 1px #262626;">%</th>
          <th align="center" style="width:85px;padding-top:5px;padding-bottom:5px;font-weight:bold;font-size:11px;border-right:solid 1px #262626;border-bottom:solid 1px #262626;">JUMLAH</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $total_outstanding=0;
      /*hitung total outstanding*/
      foreach($result as $data1){
        $total_outstanding += $data1['saldo_pokok'];
      }

      $no = 1; 
      $total = 0;
      $total_anggota = 0;
      $total_cadangan = 0;
      $total_saldo_pokok = 0;
      $total_resiko = 0;
      $par = 0;
      foreach ($result as $data):     
        $total+=$data['jumlah'];     
        $total_anggota+=$data['anggota'];  
        $total_cadangan+=$data['cadangan_piutang'];     
        $total_saldo_pokok+=$data['saldo_pokok'];   
        if ($data['saldo_pokok']>0) {
          $resiko=$data['saldo_pokok']/$total_outstanding*100;
        } else {
          $resiko=0;
        }
        if($data['cpp']>10){
          $par+=$resiko;
        }
        $total_resiko += $resiko;
      ?>
      <tr class="value">
        <td style="padding:5px;border:solid 1px #262626;text-align:center;"><?php echo $no++;?></td>
        <td style="padding:5px;border:solid 1px #262626;text-align:left;"><?php echo $data['par_desc'];?></td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($data['anggota'],0,',','.');?></td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($data['jumlah'],0,',','.');?></td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo round($resiko,2) ?>%</td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo (int) $data['cpp'];?>%</td>
        <td style="padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($data['cadangan_piutang'],0,',','.');?></td>
      </tr>
      <?php 
        endforeach;
      ?>      
      <tr class="value">
        <td>&nbsp;</td>
        <td style="border-right:solid 1px #262626;">&nbsp;</td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($total_anggota,0,',','.');?></td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($total,0,',','.');?></td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
        <td style="font-weight:bold;padding:5px;border-bottom:solid 1px #262626;border-right:solid 1px #262626;text-align:right;"><?php echo round($total_resiko,2); ?>%</td>
        <td style="font-weight:bold;border-bottom:solid 1px #262626;border-right:solid 1px #262626;">&nbsp;</td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;"><?php echo number_format($total_cadangan,0,',','.');?></td>
      </tr>
      <tr class="value">
        <td></td>
        <td></td>
        <td></td>
        <td style="border-right:solid 1px #262626;"></td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;">PAR</td>
        <td style="font-weight:bold;padding:5px;border:solid 1px #262626;text-align:right;"><?php echo round($par,2); ?>%</td>
        <td></td>
        <td></td>
      </tr>
    </tbody>
</table>
</page>