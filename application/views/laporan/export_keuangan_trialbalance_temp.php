<page backbottom="10mm">
<page_footer><div style="text-align:center;width:100%;">([[page_cu]])</div></page_footer>
<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 30px 30px 30px 20px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}

#hor-minimalist-b .konten {
  font-size: 10px;
  color: #000;
  padding: 8px;
  border-right: 1px solid #262626;
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
#hor-minimalist-b tr .nototal
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 50%;
  padding: 10px 8px;
  border: 1px solid #262626;

}
#hor-minimalist-b tr .end
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b tr .no_total
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  text-align: right;
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
}
#hor-minimalist-b tr .no_total_end
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  padding: 10px 8px;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b tr .total
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 20px;
  text-align: right;
  font-weight: bold;
  padding: 10px 8px;
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
}
#hor-minimalist-b .ket
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  padding-left: 35px;
}
#hor-minimalist-b .ket_NaN
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .th_ket
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 12.5px;
  width: 50%;
  padding: 6px 8px;
  padding-left: 5px;
}
#hor-minimalist-b .ket_bold_th
{
  /*border-bottom: 1px solid #262626;*/
  font-weight: bold;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 20px;
}
#hor-minimalist-b .ket_bold
{
  /*border-bottom: 1px solid #262626;*/
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 20px;
}
#hor-minimalist-b .center_bold
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 50%;
  padding: 6px 8px;
  text-align: center;
  font-weight: bold;
}
#hor-minimalist-b th .nominal
{
  /*border-bottom: 1px solid #262626;*/
  /*border-top: 1px solid #262626;*/
  /*border-right: 1px solid #262626;*/
  color: #000;
  width: 15%;
  text-align: right;
  padding: 6px 8px;
  font-size:12px;
}
#hor-minimalist-b .nominal
{
  /*border-bottom: 1px solid #262626;*/
  border-left: 1px solid #262626;
  /*border-top: 1px solid #262626;*/
  border-right: 1px solid #262626;
  color: #000;
  width: 15%;
  text-align: right;
  padding: 6px 8px;
  font-size:12px;
}


-->
</style>

    <h1>
        <div style="text-align:center;width:100%;font-size:17px;line-height:25px">
          <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
          <br/>
          <?php echo $cabang;?>
          <br/>
          <?php echo $judul;?>
        </div>
      <!-- <div style="border-bottom:solid 1px #000"></div> -->
    </h1>
    <div style="padding-left:20px;font-size:12px;font-weight:bold;padding-bottom:5px;">Per Tanggal : <?php echo $CI->format_date_detail($tanggal,'id',false,'-');?></div>
<table id="hor-minimalist-b" style="padding-left:2px;border:solid 1px #262626 !important;">
    <thead>
      <tr>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Acc. Code</th>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Acc. Name</th>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Saldo Awal</th>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Debet</th>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Credit</th>
            <th style="font-size:10px;border: 1px solid #262626;padding-top:7px;padding-bottom:5px;text-align:center;font-weight:bold;">Saldo</th>
      </tr>
    </thead>
    <tbody>
    <?php
      $num_data=count($datas);
      $i = 0;
      foreach($datas as $datas):
        $i++;
        $saldo = $datas['saldo_awal'] + $datas['total_mutasi_debet'] - $datas['total_mutasi_credit'];
      ?>
            <tr>
                  <td class="nominal"><?php echo $datas['account_code'];?></td>
                  <td class="konten"><?php echo $datas['account_name'];?></td>
                  <td class="nominal"><?php echo number_format($datas['saldo_awal'],0,',','.');?></td>
                  <td class="nominal"><?php echo number_format($datas['total_mutasi_debet'],0,',','.');?></td>
                  <td class="nominal"><?php echo number_format($datas['total_mutasi_credit'],0,',','.');?></td>
                  <td class="nominal"><?php echo number_format($saldo,0,',','.');?></td>
            </tr>
      <?php endforeach; ?>
    </tbody>
</table>

<p>&nbsp;</p>
<p>&nbsp;</p>
<table style="margin-left:30px;">
  <tr>
    <td style="width:335px;text-align:center;font-size:12px;">
      <br>
      Mengetahui
      <br>
      &nbsp;
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php echo $branch_officer_name; ?>
    </td>
    <td style="width:335px;text-align:center;font-size:12px;">
      <table align="center" style="width:auto;">
        <tr>
          <td style="text-align:center;">
            <?php echo $cabang.', '.date('d-m-Y'); ?>
            <br>
            membuat
          </td>
        </tr>
      </table>
            <br>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <?php echo $this->session->userdata('fullname'); ?>
    </td>
  </tr>
</table>
</page>