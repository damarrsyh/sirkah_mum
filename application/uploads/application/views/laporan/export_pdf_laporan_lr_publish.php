<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  margin: 20px;
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
#hor-minimalist-b tr .nototal
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  width: 55%;
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
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 55%;
  padding: 6px 8px;
  padding-left: 20px;
}
#hor-minimalist-b .ket_NaN
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 55%;
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
  width: 55%;
  padding: 6px 8px;
  padding-left: 2px;
}
#hor-minimalist-b .ket_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  font-weight: bold;
  width: 55%;
  padding: 6px 8px;
}
#hor-minimalist-b .judul
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .center_bold
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  width: 55%;
  padding: 6px 8px;
  text-align: center;
  font-weight: bold;
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


-->
</style>

<br>
  <br>
    <h1>
      <div style="border-bottom:solid 1px #000;padding-left:190px;width:76%;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        <br>
        <div style="padding-left:115px;padding-bottom:10px;padding-top:10px;">
        LABA RUGI
        </div>
      </div>
    </h1>
<!-- <div style="padding-left:22px;font-size:15px;font-weight:bold;padding-bottom:5px;">Per  : 31 Oktober 2013</div> -->
<!-- Per  : <?php echo $tanggal;?> --> 
<div style="padding-left:22px;font-size:15px;font-weight:bold;">Cabang  : <?php echo $cabang;?></div>
<table id="hor-minimalist-b">
    <tbody>
      <tr>
            <td class="judul">URAIAN</td>
            <td class="judul">2012</td>
            <td class="judul">2013</td>
      </tr>
      <?php 
        foreach ($report_item as $data):
          if($data['posisi']=="0")
          {
            $class = "th_ket";
          }
          else if($data['posisi']=="1")
          {
            $class = "ket_bold";
          }
          else if($data['posisi']=="2")
          {
            $class = "ket";
          }
      ?>
      <tr>
            <td class="<?php echo $class?>"><?php echo $data['item_name'];?></td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
      <?php 
          endforeach;
      ?>
      <tr>
            <td colspan="3" class="ket">&nbsp;</td>
      </tr>
      <tr>
            <td class="ket_bold"> LABA (RUGI) SEBELUM ZAKAT</td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
      <tr>
            <td class="ket_bold"> ZAKAT</td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
      <tr>
            <td class="ket_bold"> LABA (RUGI) SEBELUM PAJAK</td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
      <tr>
            <td class="ket_bold"> PAJAK PENGHASILAN</td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
      <tr>
            <td class="ket_bold"> LABA SETELAH PAJAK</td>
            <td class="nominal">1000000000000</td>
            <td class="nominal">1000000000000</td>
      </tr>
    </tbody>
</table>