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

#hor-minimalist-b .total {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: center;
}

#hor-minimalist-b .total_saldo {
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 10px;
	border: 1px solid #262626;
	text-align: right;
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
    LAPORAN SALDO TABUNGAN
    </div>
    <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:13px;">
    PRODUK : <?php echo $product_name;?>  
    </div>
    <hr>
</div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="title">No</td>
            <td class="title">No Rekening</td>
            <td class="title">Majlis</td>
            <td class="title">Nama</td>
            <td class="title">Produk</td>
            <td class="title">Status</td>
            <td class="title">Saldo</td>
      </tr>
      <?php
      $no = 1; 
      $total_pokok = 0;
        foreach ($saldo_tabungan as $data):     
        $total_pokok+=$data['saldo_memo'];    
        if($data['status_rekening']==0)
        {
          $status_rekening = "Tidak Aktif";
        } 
        else{
          $status_rekening = "Aktif";
        }
      ?>
      <tr class="value">
            <td class="konten"><?php echo $no++;?></td>
            <td class="konten"><?php echo $data['account_saving_no'];?></td>
            <td class="konten"><?php echo $data['cm_name'];?></td>
            <td class="konten"><?php echo $data['nama'];?></td>
            <td class="konten"><?php echo $data['product_name'];?></td>
            <td class="konten"><?php echo $status_rekening;?></td>
            <td class="nominal"><?php echo number_format($data['saldo_memo'],0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>    
      <tr class="value">
            <td class="total" colspan="6">TOTAL</td>
            <td class="total_saldo"><?php echo number_format($total_pokok,0,',','.');?></td>
      </tr>
    </tbody>
</table>
