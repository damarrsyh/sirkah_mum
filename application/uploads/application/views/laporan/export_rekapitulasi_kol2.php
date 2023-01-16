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
	font-size: 11px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .konten {
	font-size: 10px;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .nominal {
	font-size: 10px;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .total_saldo {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
}

#hor-minimalist-b .zero {
	font-size: 10px;
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
        Rekap Rekapitulasi NPL
      </div>
      <hr>
    </div>
    <table id="hor-minimalist-b" align="center">
      <thead>  
        <tr>
          <th class="title" rowspan="2">No</th>
          <th class="title" rowspan="2">Portfolio at Risk</th>
          <th class="title" rowspan="2">Jumlah<br />
          Anggota</th>
          <th class="title" rowspan="2">Pokok</th>
          <th class="title" rowspan="2">Margin</th>
          <th class="title" rowspan="2">Pokok<br />
          Terbayar</th>
          <th class="title" rowspan="2">Margin<br />
          Terbayar</th>
          <th class="title" rowspan="2">Saldo<br />
          Pokok</th>
          <th class="title" rowspan="2">Saldo<br />
          Margin</th>
          <th class="title" rowspan="2">Tunggakan<br />
          Pokok</th>
          <th class="title" rowspan="2">Tunggakan<br />
            Margin</th>
          <th class="title" colspan="2">Cad. Resiko</th>
        </tr>
        <tr>
          <th class="title">%</th>
          <th class="title">Jumlah</th>
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
      $total_cadangan = 0;
      $total_pokok = 0;
	  $total_margin = 0;
	  $total_pokok_terbayar = 0;
	  $total_margin_terbayar = 0;
	  $total_saldo_pokok = 0;
	  $total_saldo_margin = 0;
	  $total_tunggakan_pokok = 0;
	  $total_tunggakan_margin = 0;
      $total_resiko = 0;
      $par = 0;
      foreach ($result as $data):     
        $total+=$data['jumlah'];     
        $total_cadangan+=$data['cadangan_piutang'];     
        $total_pokok+=$data['pokok'];
		$total_margin+=$data['margin'];
		$total_pokok_terbayar += $data['pokok'] - $data['saldo_pokok'];
		$total_margin_terbayar += $data['margin'] - $data['saldo_margin'];
		$total_saldo_pokok+=$data['saldo_pokok'];
		$total_saldo_margin+=$data['saldo_margin'];
		$total_tunggakan_pokok+=$data['tunggakan_pokok'];
		$total_tunggakan_margin+=$data['tunggakan_margin'];
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
      <tr>
        <td class="konten"><?php echo $no++;?></td>
        <td class="konten"><?php echo $data['par_desc'];?></td>
        <td class="konten"><?php echo number_format($data['jumlah'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['pokok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['margin'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['pokok'] - $data['saldo_pokok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['margin'] - $data['saldo_margin'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['tunggakan_pokok'],0,',','.');?></td>
        <td class="nominal"><?php echo number_format($data['tunggakan_margin'],0,',','.');?></td>
        <td class="nominal"><?php echo (int) $data['cpp'];?>%</td>
        <td class="nominal"><?php echo number_format($data['cadangan_piutang'],0,',','.');?></td>
      </tr>
      <?php 
        endforeach;
      ?>      
      <tr class="value">
        <td class="konten">&nbsp;</td>
        <td class="konten">&nbsp;</td>
        <td class="konten"><strong><?php echo number_format($total,0,',','.');?></strong></td>
        <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_margin,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_pokok_terbayar,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_margin_terbayar,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_saldo_margin,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_tunggakan_pokok,0,',','.');?></td>
        <td class="total_saldo"><?php echo number_format($total_tunggakan_margin,0,',','.');?></td>
        <td class="nominal">&nbsp;</td>
        <td class="total_saldo"><?php echo number_format($total_cadangan,0,',','.');?></td>
      </tr>
      </tbody>
</table>