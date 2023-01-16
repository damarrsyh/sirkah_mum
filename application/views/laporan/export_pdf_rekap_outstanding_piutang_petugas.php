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
  <?php echo $cabang;?>
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
  Rekap Outstanding Piutang Berdasarkan Petugas
  </div>
  <hr>
</div>
<table id="hor-minimalist-b" align="center">
  <thead>
    <tr>
      <td class="title">Kode</td>
      <td class="title">Keterangan</td>
      <td class="title">Jumlah</td>
      <td class="title">Pokok</td>
      <td class="title">Margin</td>
      <td class="title">Catab</td>
      <td class="title">% Jumlah</td>
      <td class="title">% Pokok</td>
    </tr>
  </thead>
  <tbody>
    <?php
    $sum_anggota = 0;
    $sum_pokok = 0;

    foreach($result as $data){
      $sum_anggota += $data['jumlah'];
      $sum_pokok += $data['saldo_pokok'];
    }

    $no = 1;
    $total_anggota = 0;
    $total_pokok = 0;
    $total_margin = 0;
    $total_catab = 0;

    foreach($result as $data){
      $total_anggota += $data['jumlah'];
      $total_pokok += $data['saldo_pokok'];
      $total_margin += $data['saldo_margin'];
      $total_catab += $data['saldo_catab'];

      $persen_jumlah = $data['jumlah'] / $sum_anggota * 100;
      $persen_nominal = $data['saldo_pokok'] / $sum_pokok * 100;
    ?>
    <tr>
      <td class="konten"><?php echo $no++;?></td>
      <td class="konten"><?php echo $data['fa_name'];?></td>
      <td class="konten"><?php echo $data['jumlah'];?></td>
      <td class="nominal"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
      <td class="nominal"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
      <td class="nominal"><?php echo number_format($data['saldo_catab'],0,',','.');?></td>
      <td class="nominal"><?php echo number_format($persen_jumlah,2,',','.');?></td>
      <td class="nominal"><?php echo number_format($persen_nominal,2,',','.');?></td>
    </tr>
    <?php } ?>      
    <tr>
      <td>&nbsp;</td>
      <td class="zero">&nbsp;</td>
      <td class="konten"><?php echo $total_anggota;?></td>
      <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_margin,0,',','.');?></td>
      <td class="total_saldo"><?php echo number_format($total_catab,0,',','.');?></td>
    </tr>
  </tbody>
</table>
