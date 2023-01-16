<?php 
  $CI = get_instance();
?>
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
#hor-minimalist-b .no
{
  border: 1px solid #262626;
  color: #000;
  width: 4%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jangka_waktu
{
  border: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .tanggal_buka
{
  border: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .tanggal_jto
{
  border: 1px solid #262626;
  color: #000;
  width: 8%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .status
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 15%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 5%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 12%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
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

/*value*/
.value
{
  font-size: 11px;
}
#hor-minimalist-b .val_no
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_anggota
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_status
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-left: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
  width: 10px;
}
#hor-minimalist-b .val_jumlah
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_tgl_jto
{
  border: 1px solid #262626;
  color: #000;
  text-align: center;
  padding: 6px 8px;
}
#hor-minimalist-b .val_pokok
{
  border-bottom: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  padding: 6px 20px;
  text-align: right;
}
#hor-minimalist-b .val_kosong
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #fff;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
  text-align: center;
}
#hor-minimalist-b .val_kosong2
{
  border-bottom: 1px solid #fff;
  border-right: 1px solid #262626;
  border-top: 1px solid #fff;
  color: #000;
  padding: 6px 8px;
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
        <?php echo $cabang; ?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        LAPORAN PEMBUKAAN TABUNGAN
        </div>
        <div style="text-align:left;padding-top:20px;font-family:Arial;font-size:12px;">
        PRODUK : <?php if($product_name!=null){ echo $product_name; } else { echo "SEMUA PRODUK"; };?> 
        </div>
        <div style="text-align:left;padding-top:5px;font-family:Arial;font-size:12px;">
        Tanggal Pembukaan : <?php echo $CI->format_date_detail($tanggal1_view,'id',false,'-');?> s/d <?php echo $CI->format_date_detail($tanggal2_view,'id',false,'-');?> 
        </div>
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no">No</td>
            <td class="anggota">No Rekening</td>
            <td class="jumlah">Nama</td>
            <td class="anggota">Majelis</td>
            <td class="pokok">Produk</td>
            <td class="tanggal_buka">Tgl Buka</td>
            <td class="jangka_waktu">Jangka<br />Waktu</td>
            <td class="tanggal_jto">Tgl JTO</td>
            <td class="jangka_waktu">Setoran</td>
            <td class="status">Status</td>
            <td class="pokok">Saldo</td>
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
            <td style="font-size:9px;" class="val_anggota"><?php echo $no++;?></td>
            <td style="font-size:9px;" class="val_anggota"><?php echo $data['account_saving_no'];?></td>
            <td style="font-size:9px;" class="val_jumlah"><?php echo $data['nama'];?></td>
            <td style="font-size:9px;" class="val_tgl_jto"><?php echo $data['cm_name'];?></td>
            <td style="font-size:9px;" class="val_anggota"><?php echo $data['product_name'];?></td>
            <td style="font-size:9px;" class="val_status"><?php echo $CI->format_date_detail($data['tanggal_buka'],'id',false,'-');?></td>
            <td style="font-size:9px;" class="val_anggota"><?php echo $data['rencana_jangka_waktu'];?></td>
            <td style="font-size:9px;" class="val_tgl_jto"><?php echo $data['tanggal_jtempo'];?></td>
            <td style="font-size:9px;" class="val_anggota"><?php echo number_format($data['rencana_setoran']);?></td>
            <td style="font-size:9px;" class="val_status"><?php echo $status_rekening;?></td>
            <td style="font-size:9px;" class="val_pokok"><?php echo number_format($data['saldo_memo'],0,',','.');?></td>
      </tr>
    <?php 
        endforeach;
    ?>    
      <tr class="value">
            <td class="val_pokok" style="border-left:1px;" colspan="10">Total</td>
            <td class="val_pokok"><?php echo number_format($total_pokok,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>