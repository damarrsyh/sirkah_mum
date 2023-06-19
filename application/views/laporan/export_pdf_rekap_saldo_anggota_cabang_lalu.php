<style type="text/css">
<!--
#hor-minimalist-b
{
  
  font-size: 12px;
  background: #fff;
  /*margin: 10px;*/
  margin-top: 10px;
  border-collapse: collapse;
  text-align: left;
}
#hor-minimalist-b th
{
  font-size: 12px;
  font-weight: normal;
  color: #000;
  padding: 5px 3px;
  border-top: 2px solid #6678b1;
  border-bottom: 2px solid #6678b1;
}
#hor-minimalist-b .no
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
  /*width: 20%;*/
  padding: 10px;
  font-weight: bold;
  text-align: left;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: auto;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 14%;
  padding: 5px;
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
#hor-minimalist-b .val_jumlah
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
        <?php echo $cabang;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
        Rekap Saldo Anggota Bulan Lalu Berdasarkan Cabang 
        </div>  
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:14px;">
        Tanggal : <?php echo $tanggal;?> 
        </div> 
        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no" style="width:50px;">Kode</td>
            <td class="anggota" style="width:80px;">Keterangan</td>
            <td class="jumlah" style="width:50px;">Jumlah</td>
            <td class="pokok" style="width:50px;">Simpok</td>
            <td class="pokok" style="width:50px;">Simwa</td>
            <td class="pokok" style="width:50px;">Sukarela</td>
            <td class="pokok" style="width:50px;">Pokok</td>
            <td class="pokok" style="width:50px;">Margin</td>
      </tr>
      <?php
      $no = 1; 
      $total_anggota  = 0;
      $total_simpok   = 0;
      $total_simwa   = 0;
      $total_sukarela   = 0;
      $total_pokok =0;
      $total_margin =0; 
        foreach ($result as $data):     
        $total_anggota    +=  $data['jumlah_anggota'];   
         $total_simpok    +=$data['setoran_lwk']; 
         $total_simwa     +=$data['tabungan_minggon']; 
         $total_sukarela  +=$data['tabungan_sukarela']; 
         $total_pokok     +=$data['saldo_pokok'];
         $total_margin    +=$data['saldo_margin'];
      ?>
      <tr class="value">
            <td class="val_anggota"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $data['branch_name'];?></td>
            <td class="val_jumlah"><?php echo number_format($data['jumlah_anggota'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['setoran_lwk'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['tabungan_minggon'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['tabungan_sukarela'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['saldo_pokok'],0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($data['saldo_margin'],0,',','.');?></td>

      </tr>
    <?php 
        endforeach;
    ?>      
      <tr class="value">
            <td class="val_kosong">&nbsp;</td>
            <td class="val_kosong2">&nbsp;</td>
            <td class="val_jumlah"><?php echo number_format($total_anggota,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_simpok,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_simwa,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_sukarela,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($total_pokok,0,',','.');?></td>
            <td class="val_pokok"><?php echo number_format($toal_margin,0,',','.');?></td>
      </tr>
    </tbody>
</table>
</page>