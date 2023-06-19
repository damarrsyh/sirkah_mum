<style type="text/css">

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
  font-size: 12px;
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
  width: 5%;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .anggota
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .jumlah
{
  border: 1px solid #262626;
  color: #000;
  width: 10%;
  padding: 10px;
  font-weight: bold;
  text-align: center;
}
#hor-minimalist-b .pokok
{
  border: 1px solid #262626;
  color: #000;
  width: 20%;
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
  font-size: 10px;
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
  padding: 3px 4px;
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

</style>
<page>
      <div style="width:100%;">
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:20px;">
        <?php echo strtoupper($this->session->userdata('institution_name')) ;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
         Cabang  : <?php echo $branch_name;?>
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
         Laporan Rekap Target vs Realisasi 
        </div>
        <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
         Tahun  : <?php echo $tahuntarget;?> 
        </div>

        <hr>
      </div>
<table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
            <td class="no" style="width:30px;">No</td>
            <td class="no" style="width:30px;">Kode</td>
            <td class="anggota" style="width:100px;">Keterangan</td>
            <td class="jumlah" style="width:50px;">Jan</td>
            <td class="jumlah" style="width:50px;">Feb</td>
            <td class="jumlah" style="width:50px;">Mar</td> 
            <td class="jumlah" style="width:50px;">Apr</td>
            <td class="jumlah" style="width:50px;">Mei</td>
            <td class="jumlah" style="width:50px;">Jun</td> 
            <td class="jumlah" style="width:50px;">Jul</td>
            <td class="jumlah" style="width:50px;">Agt</td>
            <td class="jumlah" style="width:50px;">Sep</td> 
            <td class="jumlah" style="width:50px;">Okt</td>
            <td class="jumlah" style="width:50px;">Nov</td>
            <td class="jumlah" style="width:50px;">Des</td> 
      </tr>
        
      <?php
      $no = 1; 
        foreach ($result as $data):     
      ?>
      <tr class="value">
            <td class="val_anggota"><?php echo $no++;?></td>
            <td class="val_anggota"><?php echo $data['kode'];?></td>
            <td class="val_anggota"><?php echo $data['keterangan'];?></td>
            <td class="val_jumlah"><?php echo number_format($data['b1'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b2'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b3'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b4'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b5'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b6'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b7'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b8'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b9'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b10'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b11'],0,',','.');?></td>
            <td class="val_jumlah"><?php echo number_format($data['b12'],0,',','.');?></td>

      </tr>
    <?php 
        endforeach;
    ?>      
    </tbody>
</table>
</page>