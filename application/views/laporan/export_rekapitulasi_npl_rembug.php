<?php 
  $CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 11px;
  background: #fff;
  margin: 10px 10px 10px 5px;
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 12px;
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
  font-size: 12px;
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
  font-weight: bold;
  text-align: center;
  padding: 4px 4px;
}
#hor-minimalist-b .no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  text-align: center;
  padding: 6px 8px;
}


/*value*/
.value
{
  font-size: 10px;
}
#hor-minimalist-b .val_no_bold
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  font-size: 9px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 8px;
  font-size: 9px;
}
</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        <?php echo $cabang; ?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        Laporan Rekapitulasi NPL Tanggal <?php echo $tanggal;?>
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" >
    <tbody>
      <tr>
            <td class="no_bold" rowspan="2">No.</td>
            <td class="ket_bold" rowspan="2" style="width:80px;">Rembug</td>
            <td class="ket_bold" colspan="3">PAR (1 - 30)</td>
            <td class="ket_bold" colspan="3">PAR (31 - 60)</td>
            <td class="ket_bold" colspan="3">PAR (61 - 90)</td>
            <td class="ket_bold" colspan="3">PAR (91 - 120)</td>
            <td class="ket_bold" colspan="3">PAR (> 120)</td>
            <td class="ket_bold" colspan="3">Total</td>
      </tr>
      <tr>
            <td class="ket_bold" style="width:15px; border-left:solid 1px transparent;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
            <td class="ket_bold" style="width:15px;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
            <td class="ket_bold" style="width:15px;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
            <td class="ket_bold" style="width:15px;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
            <td class="ket_bold" style="width:15px;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
            <td class="ket_bold" style="width:15px;">Jml</td>
            <td class="ket_bold" style="width:40px;">Saldo Pokok</td>
            <td class="ket_bold" style="width:30px;">CPP</td>
      </tr>
      <?php 
        $no=1;
        $total = 0;
        $total_saldo = 0;
        $total_cpp = 0;
        $total_jumlah1 = 0;
        $total_jumlah2 = 0;
        $total_jumlah3 = 0;
        $total_jumlah4 = 0;
        $total_jumlah5 = 0;
        $total_jumlah6 = 0;
        $total_saldo1 = 0;
        $total_saldo2 = 0;
        $total_saldo3 = 0;
        $total_saldo4 = 0;
        $total_saldo5 = 0;
        $total_saldo6 = 0;
        $total_cpp1 = 0;
        $total_cpp2 = 0;
        $total_cpp3 = 0;
        $total_cpp4 = 0;
        $total_cpp5 = 0;
        $total_cpp6 = 0;
        foreach($result as $data):
        $total = $data['jml1']+$data['jml2']+$data['jml3']+$data['jml4']+$data['jml5'];
        $total_saldo = $data['saldo_pokok1']+$data['saldo_pokok2']+$data['saldo_pokok3']+$data['saldo_pokok4']+$data['saldo_pokok5'];
        $total_cpp = $data['cpp1']+$data['cpp2']+$data['cpp3']+$data['cpp4']+$data['cpp5'];
        $total_jumlah1 += $data['jml1'];
        $total_jumlah2 += $data['jml2'];
        $total_jumlah3 += $data['jml3'];
        $total_jumlah4 += $data['jml4'];
        $total_jumlah5 += $data['jml5'];
        $total_jumlah6 += $total;
        $total_saldo1 += $data['saldo_pokok1'];
        $total_saldo2 += $data['saldo_pokok2'];
        $total_saldo3 += $data['saldo_pokok3'];
        $total_saldo4 += $data['saldo_pokok4'];
        $total_saldo5 += $data['saldo_pokok5'];
        $total_saldo6 += $total_saldo;
        $total_cpp1 += $data['cpp1'];
        $total_cpp2 += $data['cpp2'];
        $total_cpp3 += $data['cpp3'];
        $total_cpp4 += $data['cpp4'];
        $total_cpp5 += $data['cpp5'];
        $total_cpp6 += $total_cpp;
		
		if($total > 0){
      ?>
      <tr class="value">
        <td class="val_no_bold" align="center" style="font-size:9px;"><?php echo $no++;?></td>
        <td class="val_anggota" style="font-size:9px;white-space:nowrap;"><?php echo $data['branch_name'];?> | <?php echo $data['cm_name'];?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php if($data['jml1']==""){ echo "0";} else { echo $data['jml1'];}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['saldo_pokok1']==""){ echo "0";} else { echo number_format($data['saldo_pokok1'],0,',','.');}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['cpp1']==""){ echo "0";} else { echo number_format($data['cpp1'],0,',','.');}?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php if($data['jml2']==""){ echo "0";} else { echo $data['jml2'];}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['saldo_pokok2']==""){ echo "0";} else { echo number_format($data['saldo_pokok2'],0,',','.');}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['cpp2']==""){ echo "0";} else { echo number_format($data['cpp2'],0,',','.');}?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php if($data['jml3']==""){ echo "0";} else { echo $data['jml3'];}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['saldo_pokok3']==""){ echo "0";} else { echo number_format($data['saldo_pokok3'],0,',','.');}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['cpp3']==""){ echo "0";} else { echo number_format($data['cpp3'],0,',','.');}?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php if($data['jml4']==""){ echo "0";} else { echo $data['jml4'];}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['saldo_pokok4']==""){ echo "0";} else { echo number_format($data['saldo_pokok4'],0,',','.');}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['cpp4']==""){ echo "0";} else { echo number_format($data['cpp4'],0,',','.');}?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php if($data['jml5']==""){ echo "0";} else { echo $data['jml5'];}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['saldo_pokok5']==""){ echo "0";} else { echo number_format($data['saldo_pokok5'],0,',','.');}?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php if($data['cpp5']==""){ echo "0";} else { echo number_format($data['cpp5'],0,',','.');}?></td>
        <td class="val_anggota" align="center" style="font-size:9px;"><?php echo number_format($total,0,',','.');?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php echo number_format($total_saldo,0,',','.');?></td>
        <td class="val_anggota" align="right" style="font-size:9px;"><?php echo number_format($total_cpp,0,',','.');?></td>
      </tr>
      <?php 
		} endforeach
      ?>
      <tr class="value">
            <td style="font-size:9px;" class="no_bold">&nbsp;</td>
            <td style="font-size:9px;" class="ket_bold">Total</td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah1;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo1,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp1,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah2;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo2,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp2,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah3;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo3,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp3,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah4;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo4,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp4,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah5;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo5,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp5,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold"><?php echo $total_jumlah6;?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_saldo6,0,',','.');?></td>
            <td style="font-size:9px;" class="ket_bold" align="right"><?php echo number_format($total_cpp6,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>