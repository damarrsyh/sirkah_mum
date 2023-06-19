<?php
$CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 8px;
  background: #fff;
  margin-top: 10px;
  border-collapse: collapse;
  /*text-align: left;*/
}
#hor-minimalist-b td {
  font-size: 8px;
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
  width: 9%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 14%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 2%;
  font-weight: bold;
  /*text-align: center;*/
  padding: 3px 4px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 7%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .anggota2
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 4%;
  font-weight: bold;
  padding: 6px 8px;
  /*text-align: center;*/
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
  /*text-align: center;*/
}
#hor-minimalist-b .anggota-luhur
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 20%;
  font-weight: bold;
  padding: 3px 4px;
  /*text-align: center;*/
}
#hor-minimalist-b th .nominal
{
  border-bottom: 1px solid #262626;
  border-top: 1px solid #262626;
  border-right: 1px solid #262626;
  color: #000;
  width: 20%;
  /*text-align: right;*/
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
  /*text-align: right;*/
  padding: 6px 8px;
}

/*value*/
.value
{
  /*font-size: 11px;*/
}

#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 3px 4px;
}
#hor-minimalist-b .val_tanggal_droping
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_no_rekening
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  /*text-align: center;*/
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val_ke
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  /*text-align: center;*/
}
#hor-minimalist-b .val
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  color: #000;
  padding: 5px 0 5px 0;
  /*text-align: center;*/
}

-->
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:6px;font-family:Arial;font-size:18px;">        
        <?php echo $cabang;?> 
        </div>
        <div style="text-align:center;padding-top:6px;font-family:Arial;font-size:18px;">
        Laporan List kolektibilitas
        </div>
        <div style="text-align:center;padding-top:6px;padding-bottom:6px;font-family:Arial;font-size:16px;">
        Tanggal : <?php echo $tanggal;?>
        </div>
        <hr>
      </div>
      <table id="hor-minimalist-b" align="center">
          <tbody>
              <tr>
                <td rowspan="2" align="center" class="anggota-luhur" style="width:5px;" >No</td>
                <td colspan="3" align="center" class="anggota-luhur">Anggota</td>
                <td colspan="4" align="center" class="anggota-luhur" >Pembiayaan</td>
                <td colspan="2" align="center" class="anggota-luhur"  style="width:100px;">Outsanding</td>
                <td colspan="2" align="center" class="anggota-luhur"  style="width:70px;">Angsuran</td>
                <td rowspan="2" align="center" class="anggota-luhur" style="width:20px;" >PAR</td>
                <td colspan="3" align="center" class="anggota-luhur"  style="width:150px;">Tunggakan</td>
                <td rowspan="2" align="center" class="anggota-luhur" style="width:50px;" >Petugas</td>
              </tr>
              <tr>
                <td align="center" class="no_bold" style="width:75px;">No rekening</td>
                <td align="center" class="no_bold" style="width:75px;">Nama</td>
                <td align="center" class="no_bold" style="width:75px;">Rembug</td>  
                <td align="center" class="no_bold" style="width:20px;">Pokok</td>
                <td align="center" class="no_bold" style="width:20px;">Margin</td>
                <td align="center" class="no_bold" style="width:5px;">Jwt</td>
                <td align="center" class="no_bold" style="width:20px;">TglCair</td>
                <td align="center" class="no_bold" style="width:20px;">Pokok</td>
                <td align="center" class="no_bold" style="width:20px;">Margin</td>
                <td align="center" class="no_bold" style="width:5px;">Terbyr</td>
                <td align="center" class="no_bold" style="width:5px;">Hrsnya</td>
                <td align="center" class="no_bold" style="width:5px;">Ctr</td>
                <td align="center" class="no_bold" style="width:20px;">Tgk Pokok</td>
                <td align="center" class="no_bold" style="width:20px;">Tgk Margin</td>

              </tr>

              <?php 
                $no=0;
                $total_pokok = 0;
                $total_margin = 0;
                $total_saldo_pokok = 0;
                $total_saldo_margin = 0;
                $total_tgk_pokok = 0;
                $total_tgk_margin = 0;
                foreach ($PAR as $data):
                  $no += 1;
                  $total_pokok += $data['pokok'];
                  $total_margin += $data['margin'];
                  $total_saldo_pokok += $data['saldo_pokok'];
                  $total_saldo_margin += $data['saldo_margin'];
                  $total_tgk_pokok += $data['tunggakan_pokok'];
                  $total_tgk_margin += $data['tunggakan_margin'];
                  // $cnt = $data['saldo_pokok']/$data['angsuran_pokok'];
              ?>              
                  <tr class="value">
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;"><?php echo $no;?></td> 
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['account_financing_no'];?></td> 
                    <td align="left" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['nama'];?></td>
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['cm_name'];?></td> 
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['pokok'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['margin'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['jangka_waktu'],0,',','.');?></td>
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['droping_date'];?></td> 
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['terbayar'],0,',','.');?></td> 
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['seharusnya'],0,',','.');?></td> 
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['par_desc'];?></td> 
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['freq_tunggakan'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tunggakan_pokok'],0,',','.');?></td>
                    <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo number_format($data['tunggakan_margin'],0,',','.');?></td>
                    <td align="center" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999;"><?php echo $data['fa_name'];?></td>
                  </tr>
              <?php 
                endforeach;
              ?>

            <tr class="value">
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-left:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; border-left:solid 1px #999;" colspan="3">Total :</td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_pokok,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_margin,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_saldo_pokok,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_saldo_margin,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_tgk_pokok,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;"><?php echo number_format($total_tgk_margin,0,',','.');?></td>
              <td align="right" valign="middle" style=" padding: 3px 2px; border-bottom:solid 1px #999; border-right:solid 1px #999; font-weight: bold;">&nbsp;</td> 
            </tr>            
          </tbody>
      </table>
</page>