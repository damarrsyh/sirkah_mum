<?php
$CI = get_instance();
?>
<style type="text/css">
<!--
#hor-minimalist-b
{
  background: #fff;
  margin-top: 10px;
  border-collapse: collapse;
  font-family: Arial, Helvetica, sans-serif;
  /*text-align: left;*/
}
#hor-minimalist-b .title
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-weight: bold;
  font-size: 9px;
  padding: 3px 5px;
  text-align: center;
  /*text-align: center;*/
}
#hor-minimalist-b .konten
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-size: 8px;
  padding: 3px 5px;
  text-align: center;
  /*text-align: center;*/
}
#hor-minimalist-b .nominal
{
  border-bottom: 1px solid #262626;
  border-left: 1px solid #262626;
  border-right: 1px solid #262626;
  border-top: 1px solid #262626;
  color: #000;
  font-size: 8px;
  padding: 3px 5px;
  text-align: right;
  /*text-align: center;*/
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
  Lembar Absensi Anggota  
  </div>
  <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:14px;">
  Tahun <?php echo $this->uri->segment(5);?> 
  </div>
  <hr>  
</div>
<table id="hor-minimalist-b" align="center">
    <tbody>
       <tr>
          <td colspan="2" class="title">Anggota</td> 
          <td colspan="5" class="title">Januari</td>  
          <td colspan="5" class="title">Februari</td>  
          <td colspan="5" class="title">Maret</td> 
          <td colspan="5" class="title">April</td> 
          <td colspan="5" class="title">Mei</td> 
          <td colspan="5" class="title">Juni</td> 
          <td colspan="5" class="title">Juli</td>
          <td colspan="5" class="title">Agust</td>
          <td colspan="5" class="title">Sept</td>
          <td colspan="5" class="title">Okt</td> 
          <td colspan="5" class="title">Nov</td>
          <td colspan="5" class="title">Des</td>
	     </tr>
       <tr>
          <td class="title">ID</td>
          <td class="title">Nama</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
          <td class="title">1</td>
          <td class="title">2</td>
          <td class="title">3</td>
          <td class="title">3</td>
          <td class="title">5</td>
      </tr>
     <?php 
        $no=1;
        
        foreach ($lembar_absen_anggota as $data){
      ?>

      <tr class="value">
        <td class="konten"><?php echo $data['cif_no'];?></td>
        <td class="konten" align="left" ><?php echo $data['nama'];?></td>  
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td> 
        <td class="konten" align="left" ></td>

      </tr>
     <?php } ?>
    </tbody>
</table>
</page>