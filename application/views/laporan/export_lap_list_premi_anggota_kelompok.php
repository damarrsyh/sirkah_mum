<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 10px;
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
  width: 12%;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
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
  font-size: 10px;
  padding: 6px 8px;
}
.no_
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  text-align: center;
  font-size: 10px;
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-size: 10px;
  font-weight: bold;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .rek_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 9%;
  font-size: 10px;
  font-weight: bold;
  padding: 6px 1px;
  text-align: center;
}
#hor-minimalist-b .tgl_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 5%;
  font-size: 10px;
  font-weight: bold;
  padding: 6px 1px;
  text-align: center;
}
#hor-minimalist-b .anggota_
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-size: 9px;
  padding: 6px 1px;
  text-align: center;
}
#hor-minimalist-b .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
  font-size: 10px;
  /*font-weight: bold;*/
  /*padding: 6px 8px;*/
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
  font-size: 10px;
  width: 20%;
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
.val{
  font-weight: normal;
  font-size: 8px;
}

.val .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
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
        <?php echo $data_cabang; ?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        Laporan List Biaya Asuransi Anggota 
        </div>

        <div style="text-align:left;padding-top:10px;font-family:Arial;font-size:13px;">
        <table>
          
          <tr>
            <td>Produk</td>
            <td>: <?php echo $product_name; ?></td>
          </tr>
        </table>
        </div>
        <hr>
      </div>
      <br>
    <table cellspacing="0" cellpadding="0" align="center">
    <thead>
      <tr>
        <th style="text-align:center; font-size:9px; padding:5px; border:solid 1px #555; width:10px;" rowspan="1">No.</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:80px;" rowspan="1">No. Rekening</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:70px;" rowspan="1">Nama Aggota</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:80px;" rowspan="1">Rembug Pusat</th>
		<th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Tgl Lahir</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:30px;" rowspan="1">Usia</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:70px;" rowspan="1">Nama Pasangan</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Tgl.Lahir<br>Pasangan</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:30px;" rowspan="1">Usia<br>Pasangan</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Pokok</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:30px;" rowspan="1">Tgl. Droping</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:20px;" rowspan="1">Jangka Waktu</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Tgl.<br>JTempo</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Saldo<br>Pokok</th>
        <th style="text-align:center; font-size:9px; padding:5px; border-bottom:solid 1px #555; border-right: solid 1px #555; border-top:solid 1px #555; width:40px;" rowspan="1">Biaya<br>Asuransi</th>
      </tr> 
    </thead>
    <tbody> 
	  
      <tr>	  
	  </tr>	 
	  
      <?php 
        $no=1;
        $total_pokok            = 0;
        $total_margin           = 0;
        $total_saldo_pokok      = 0;
        $total_saldo_margin     = 0;
		$total_biaya_premi     = 0;
        foreach ($result as $data):
        $total_pokok                  += $data['pokok'];
        $total_margin                 += $data['margin'];
        $total_saldo_pokok            += $data['saldo_pokok'];
        $total_saldo_margin           += $data['saldo_margin'];
		$total_biaya_premi           += $data['biaya_asuransi_jiwa'];
		
		if($data['usia']!=''){
			$a = explode(' ',$data['usia']);
			$usia = $a[0].' Tahun '.@$a[2].' Bulan ';
		}else{
			$usia = ' ';
		}

		if($data['p_usia']!=''){
			$b= explode(' ',$data['p_usia']);
			$p_usia = $b[0].' Tahun '.$b[2].' Bulan ';
		}else{
			$p_usia = ' ';
		}
      ?>    
      <tr>
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;"><?php echo $no++;?></td>
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['account_financing_no'];?></td>
        <td style="padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;white-space:normal;"><?php echo $data['nama'];?></td>
		<td style="padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;white-space:normal;"><?php echo $data['cm_name'];?></td>
  		<td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['tgl_lahir'];?></td>
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $usia;?></td>
  		<td style="padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;white-space:normal;"><?php echo $data['p_nama'];?></td>
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['tanggal_peserta_asuransi'];?></td>      
  		<td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $p_usia;?></td>			
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo number_format($data['pokok'],0,',','.');?></td>
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['droping_date'];?></td>			
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['jangka_waktu'];?></td>			
        <td style="text-align:center; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo $data['tanggal_jtempo'];?></td>
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>			
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;"><?php echo number_format($data['biaya_asuransi_jiwa'],0,',','.');?></td>	
      </tr>
    <?php endforeach?>    
      <tr>
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555; border-left: solid 1px #555;" colspan="9">Total :</td>
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555; font-weight: bold;"><?php echo number_format($total_pokok,0,',','.');?></td>
  		<td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555;" colspan="3"></td>
        <td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555; font-weight: bold;"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
  		<td style="text-align:right; padding:5px; font-size:8px; border-bottom: solid 1px #555; border-right: solid 1px #555; font-weight: bold;"><?php echo number_format($total_biaya_premi,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>