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


/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_status
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
  width: 10px;
}
#hor-minimalist-b .val_jumlah
{
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
-->
</style>
<page>
<table id="hor-minimalist-b" align="left">
    <tbody>
      <?php
      $no = 1; 
      foreach ($cetak_buku as $data):  

      if($data['flag_debit_credit']=="D"){
        $debet = $data['amount'];
      }else{
        $debet = "0";
      }   
      if($data['flag_debit_credit']=="C"){
        $credit = $data['amount'];
      }else{
        $credit = "0";
      }
      
      $CI = get_instance();

      ?>
      <tr class="value">
            <td style="padding:<?php echo $margin['0']['top_margin']; ?>px <?php echo $margin['0']['right_margin']; ?>px <?php echo $margin['0']['bottom_margin']; ?>px <?php echo $margin['0']['left_margin']; ?>px"><?php echo $no++;?></td>
            <td style="padding:<?php echo $margin['1']['top_margin']; ?>px <?php echo $margin['1']['right_margin']; ?>px <?php echo $margin['1']['bottom_margin']; ?>px <?php echo $margin['1']['left_margin']; ?>px"><?php echo  $CI->format_date_detail($data['trx_date'],'id',false,'-');?></td>
            <td style="padding:<?php echo $margin['2']['top_margin']; ?>px <?php echo $margin['2']['right_margin']; ?>px <?php echo $margin['2']['bottom_margin']; ?>px <?php echo $margin['2']['left_margin']; ?>px"><?php echo $data['trx_saving_type'];?></td>
            <td style="padding:<?php echo $margin['3']['top_margin']; ?>px <?php echo $margin['3']['right_margin']; ?>px <?php echo $margin['3']['bottom_margin']; ?>px <?php echo $margin['3']['left_margin']; ?>px"><?php echo number_format($debet,0,',','.');?></td>
            <td style="padding:<?php echo $margin['4']['top_margin']; ?>px <?php echo $margin['4']['right_margin']; ?>px <?php echo $margin['4']['bottom_margin']; ?>px <?php echo $margin['4']['left_margin']; ?>px"><?php echo number_format($credit,0,',','.');?></td>
            <td style="padding:<?php echo $margin['5']['top_margin']; ?>px <?php echo $margin['5']['right_margin']; ?>px <?php echo $margin['5']['bottom_margin']; ?>px <?php echo $margin['5']['left_margin']; ?>px"><?php echo number_format($data['saldo_riil'],0,',','.');?></td>
            <td style="padding:<?php echo $margin['6']['top_margin']; ?>px <?php echo $margin['6']['right_margin']; ?>px <?php echo $margin['6']['bottom_margin']; ?>px <?php echo $margin['6']['left_margin']; ?>px"><?php echo $this->session->userdata('username');;?></td>
      </tr>
    <?php 
        endforeach;
    ?>  
    </tbody>
</table>
</page>