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
  width: 14%;
  font-size:11px;
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
  font-size:11px;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 12%;
  font-size:11px;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .tanggal
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  width: 8%;
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
  width: 26%;
  font-size: 11px;
  padding: 6px 8px 6px 8px;
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


-->
</style>
<page>
<br>
  <div style="width:100%;border-bottom:solid 1px #555; padding-bottom:20px;" align="center">
    <h4 style="margin:3px 0;">MITRA USAHA MANDIRI </h4>
    <h4 style="margin:3px 0;"><?php echo $branch_name; ?></h4>
    <h4 style="margin:3px 0;">AGING REPORT</h4>
    <h4 style="margin:3px 000;">Tanggal : <?php echo $date; ?></h4>
  </div>

<table id="hor-minimalist-b">
<?php
$total_freq_tunggakan = 0;
$total_saldo_pokok = 0;
$total_cadangan_piutang = 0;
$group_day = $par[0]['par_desc'];
$no=0;
for ( $i = 0 ; $i < count($par) ; $i++ )
{
?>
    <?php
    if($i==0){

    ?>
    <tr>
      <td colspan="8" style="border-bottom:solid 1px #000;">
        <p style="font-size:15px;font-weight:bold;padding-bottom:5px;">
          <?php echo $par[$i]['par_desc']; ?> &nbsp;
        </p>
      </td>
    </tr>
    <tr>
          <td style="font-weight:bold;padding-right:13px" class="no_bold" rowspan="2">No.</td>
          <td style="font-weight:bold;padding-right:13px" class="anggota-luhur" colspan="3">Anggota</td>
          <td style="font-weight:bold;padding-right:13px" class="ket_bold" rowspan="2">Outstanding</td>
          <td style="font-weight:bold;padding-right:13px" class="ket_bold" rowspan="2">Portofolio Beresiko</td>
          <td style="font-weight:bold;padding-right:13px" class="anggota-luhur" colspan="2">Cadangan Pinjaman Tak Tertagih</td>
    </tr>
    <tr>
          <td style="font-weight:bold;padding-right:13px;" class="anggota">Nama</td>
          <td style="font-weight:bold;padding-right:13px;" class="anggota">Rembug</td>
          <td style="font-weight:bold;padding-right:13px;" class="anggota">Jumlah</td>
          <td style="font-weight:bold;padding-right:13px;" class="anggota">%</td>
          <td style="font-weight:bold;padding-right:13px;" class="anggota">Nominal</td>
    </tr>
    <?php 
    }
    else
    { 

      if($group_day != $par[$i]['par_desc'])
      {
      ?>
      <tr>
        <td></td>
        <td></td>
        <td style="border-right:solid 1px #000;"></td>
        <td class="anggota" align="right"><?php echo $total_freq_tunggakan; ?></td>
        <td class="anggota" align="right"><?php echo number_format($total_saldo_pokok,2,',','.'); ?></td>
        <td class="anggota" align="right"><?php echo number_format($total_cadangan_piutang,2,',','.'); ?></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="8" style="border-bottom:solid 1px #000;">
          <p style="font-size:15px;font-weight:bold;padding-bottom:5px;">
            <?php echo $par[$i]['par_desc']; ?> &nbsp;
          </p>
        </td>
      </tr>
      <tr>
            <td style="font-weight:bold;padding-right:13px;" class="no_bold" rowspan="2">No.</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota-luhur" colspan="3">Anggota</td>
            <td style="font-weight:bold;padding-right:13px;" class="ket_bold" rowspan="2">Outstanding</td>
            <td style="font-weight:bold;padding-right:13px;" class="ket_bold" rowspan="2">Portofolio Beresiko</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota-luhur" colspan="2">Cadangan Pinjaman Tak Tertagih</td>
      </tr>
      <tr>
            <td style="font-weight:bold;padding-right:13px;" class="anggota">Nama</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota">Rembug</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota">Jumlah</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota">%</td>
            <td style="font-weight:bold;padding-right:13px;" class="anggota">Nominal</td>
      </tr>
      <?php
      $total_freq_tunggakan = 0;
      $total_saldo_pokok = 0;
      $total_cadangan_piutang = 0;
      $group_day = $par[$i]['par_desc'];
      $no=0;
      }
      else
      {
        $total_freq_tunggakan += $par[$i]['freq_tunggakan'];
        $total_saldo_pokok += $par[$i]['saldo_pokok'];
        $total_cadangan_piutang += $par[$i]['cadangan_piutang'];
        $no++; 
        ?>
        <tr>
              <td class="no_bold"><?php echo $no; ?></td>
              <td class="ket_bold"><?php echo $par[$i]['nama']; ?></td>
              <td class="ket_bold"><?php echo $par[$i]['cm_name']; ?></td>
              <td class="anggota" align="right"><?php echo $par[$i]['freq_tunggakan']; ?></td>
              <td class="anggota" align="right"><?php echo number_format($par[$i]['saldo_pokok'],2,',','.'); ?></td>
              <td class="anggota" align="right"><?php echo number_format($par[$i]['cadangan_piutang'],2,',','.'); ?></td>
              <td class="anggota" align="right"><?php echo number_format($par[$i]['par'],2,',','.'); ?></td>
              <td class="anggota" align="right"><?php echo number_format($par[$i]['tunggakan_pokok'],2,',','.'); ?></td>
        </tr>
        <?php
        if($i+1==count($par))
        {
          ?>
          <tr>
            <td></td>
            <td></td>
            <td style="border-right:solid 1px #000;"></td>
            <td class="anggota" align="right"><?php echo $total_freq_tunggakan; ?></td>
            <td class="anggota" align="right"><?php echo number_format($total_saldo_pokok,2,',','.'); ?></td>
            <td class="anggota" align="right"><?php echo number_format($total_cadangan_piutang,2,',','.'); ?></td>
            <td></td>
            <td></td>
          </tr>
          <?php
        }

      } // end if($group_day != $par[$i]['par_desc'])
    } // end if($i==0)
    ?>
<?php 
} // end for
?>
</table>
</page>
