<?php 
  $CI = get_instance();
?>
<style type="text/css">

</style>
<page>
      <div style="width:100%;">
        <h1>
            <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
            <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
            </div>
            <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
            <?php echo $branch_code;?>
            </div>
            <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
            Laporan Cash Flow Transaksi Majelis
            </div>
        </h1>
        <div style="font-family:Arial; font-size:12px;">
        	Majelis : <?php echo $cm_name; ?>
        </div>
        <div style="font-family:Arial; font-size:12px;">
        	Petugas : <?php echo $fa_name; ?>
        </div>
        <div style="font-family:Arial; font-size:12px;">
        	Tanggal : <?php echo $CI->format_date_detail($from_trx_date,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($thru_trx_date,'id',false,'-');?>
        </div>
      </div>
        <hr>
  
  <table cellspacing="0" cellpadding="0" align="center" style="margin-top:20px;">
    <tbody>
      <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >Cash In </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">&nbsp;</td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Angs Pokok </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['angsuran_pokok'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Angs Margin </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['angsuran_margin'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Angs Catab </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['angsuran_catab'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Wajib </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['tab_wajib_cr'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Kelompok </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['tab_kelompok_cr'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Sukarela </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['tab_sukarela_cr'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Infaq </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['infaq_kelompok'],0,',','.');?> </td>
	  </tr>
	  <tr>
	    <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Administrasi</td>
	    <td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($data['administrasi'],0,',','.');?></td>
      </tr>
	  <tr>
	    <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Asuransi</td>
	    <td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($data['asuransi'],0,',','.');?></td>
      </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Total Cash In  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['cash_in'],0,',','.');?> </td>
	  </tr>
	  
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >Cash Out </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Kelompok</td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($data['tab_kelompok_db'],0,',','.');?></td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Wajib </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['tab_wajib_db'],0,',','.');?> </td>
	  </tr>
	  
	  <tr>
	    <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Catab</td>
	    <td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($data['saldo_catab'],0,',','.');?></td>
      </tr>
	  <tr>
	    <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Tab Sukarela </td>
	    <td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($data['tab_sukarela'],0,',','.');?></td>
      </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Droping </td>
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['droping'],0,',','.');?> </td>
	  </tr>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Total Cash Out  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($data['cash_out'],0,',','.');?> </td>
	  </tr>	
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	  <!--droping by produk--> 
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " > Droping by Produk </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	  <?php 
		$total_drop_byproduk = 0 ;
		foreach($datadropingbyproduk as $dropingbyproduk): 
		$total_drop_byproduk +=$dropingbyproduk['amount'];		
		?>			
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " ><?php echo $dropingbyproduk['product_name'] ?> </td>
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($dropingbyproduk['amount'],0,',','.');?> </td>
	  </tr>
	  <?php endforeach; ?>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Total Droping  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($total_drop_byproduk,0,',','.');?> </td> 
	 </tr>	
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	    <!--droping by Peruntukan--> 
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " > Droping by Peruntukan </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	  <?php 
		$total_drop_byperuntukan = 0 ;
		foreach($datadropingbyperuntukan as $dropingbyperuntukan): 
		$total_drop_byperuntukan +=$dropingbyperuntukan['amount'];		
		?>			
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " ><?php echo $dropingbyperuntukan['tujuan_pembiayaan'] ?> </td>
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($dropingbyperuntukan['amount'],0,',','.');?> </td>
	  </tr>
	  <?php endforeach; ?>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Total Droping  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($total_drop_byperuntukan,0,',','.');?> </td> 
	 </tr>	
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	  
	    <!--droping by Sektor Ekonomi--> 
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " > Droping by Sektor Usaha </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
	  
	  <?php 
		$total_drop_bysektor = 0 ;
		foreach($datadropingbysektor as $dropingbysektor): 
		$total_drop_bysektor +=$dropingbysektor['amount'];		
		?>			
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " ><?php echo $dropingbysektor['sektor_usaha'] ?> </td>
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "> <?php echo number_format($dropingbysektor['amount'],0,',','.');?> </td>
	  </tr>
	  <?php endforeach; ?>
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555;   border-right: solid 1px #555; border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:80px; heigh :10px " >Total Droping  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;   border-right: solid 1px #555; font-size:8px; width:80px "><?php echo number_format($total_drop_bysektor,0,',','.');?> </td> 
	 </tr>	
	  <tr>            
        <td style="padding:5px; text-align: left; border-bottom:solid 1px #555; border-top: solid 1px #555;  border-left: solid 1px #555; font-weight: bold; font-size: 9px; width:160px; heigh :10px " >  </td>  
		<td style="padding:5px; text-align: right;  border-bottom:solid 1px #555;  border-top: solid 1px #555; border-right: solid 1px #555; font-size:8px; width:80px ">  </td>
	  </tr>
		
    </tbody>
</table>
</page>