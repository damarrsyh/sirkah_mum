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
    Laporan Proyeksi Droping
    </div>
    <hr>
  </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="title">No</td>
            <td class="title">Cabang</td>
            <td class="title">Periode</td>
            <td class="title">Proyeksi Anggota</td>
            <td class="title">Proyeksi Nominal</td>
            <td class="title">Realisasi Anggota</td>
            <td class="title">Realisasi Nominal</td>
      </tr>
      <?php 
	  $no=1;

      foreach ($result as $data){
            $account_target = $data['account_target'];
            $amount_target = $data['amount_target'];
            $account_real = $data['account_real'];
            $amount_real = $data['amount_real'];
            $year = $data['year'];
            $month = $data['month'];

            if($cabang == 'Kantor Pusat')
            {
              $branch_name = 'Pusat';
            }else
            {
              $branch_name = $data['branch_name'];
            }
            
            if($month == '1'){$mont_ = 'Januari';}else
            if($month == '2'){$mont_ = 'Februari';}else
            if($month == '3'){$mont_ = 'Maret';}else
            if($month == '4'){$mont_ = 'April';}else
            if($month == '5'){$mont_ = 'Mei';}else
            if($month == '6'){$mont_ = 'Juni';}else
            if($month == '7'){$mont_ = 'Juli';}else
            if($month == '8'){$mont_ = 'Agustus';}else
            if($month == '9'){$mont_ = 'September';}else
            if($month == '10'){$mont_ = 'Oktober';}else
            if($month == '11'){$mont_ = 'November';}else
            if($month == '12'){$mont_ = 'Desember';}

      ?>
      <tr>
            <td class="konten"><?php echo $no++; ?></td>
            <td class="konten"><?php echo $branch_name; ?></td>
            <td class="konten"><?php echo $mont_.' '.$year; ?></td>
            <td class="konten"><?php echo number_format($account_target,0,',','.'); ?></td>
            <td class="konten"><?php echo number_format($amount_target,2,',','.'); ?></td>
            <td class="konten"><?php echo number_format($account_real,0,',','.'); ?></td>
            <td class="konten"><?php echo number_format($amount_real,2,',','.'); ?></td>
      </tr>
      <?php } ?>
      <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
      </tr>
    </tbody>
</table>
