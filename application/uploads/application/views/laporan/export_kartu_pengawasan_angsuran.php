<?php 
  $CI = get_instance();
?>
<div style="font-size:11px;">
<table align="center" cellspacing="0" cellpadding="0">
  <tr style="background-color:#eee;">
    <td width="249" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-left:1px solid #ddd;">
      <table>
        <tr>
          <td style="width:70px;padding:5px 1px 5px 1px;">Nama</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['nama']))echo $data['nama'];?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Rembug</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['cm_name']))echo $data['cm_name'];?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Desa</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['desa']))echo $data['desa'];?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Produk</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['product_name']))echo $data['product_name'];?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Untuk</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['untuk']))echo $data['untuk'];?></td>
        </tr>
      </table>
    </td>
    <td width="249" style="border-top:1px solid #ddd;border-bottom:1px solid #ddd;border-right:1px solid #ddd;">
      <table>
        <tr>
          <td style="width:70px;padding:5px 1px 5px 1px;">Plafon</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['pokok']))echo number_format($data['pokok'],0,',','.');?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Margin</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['margin']))echo number_format($data['margin'],0,',','.');?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Tgl Cair</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['droping_date']))echo date("d-m-Y", strtotime($data['droping_date']));?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">Tgl. J tempo</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['tanggal_jtempo']))echo date("d-m-Y", strtotime($data['tanggal_jtempo']));?></td>
        </tr>
        <tr>
          <td style="padding:5px 1px 5px 1px;">PYD ke</td>
          <td style="padding:5px 1px 5px 1px;">:</td>
          <td style="padding:5px 1px 5px 1px;"><?php if(isset($data['pydke']))echo $data['pydke'];?></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table align="center" cellpadding="0" cellspacing="0">    
  <thead>
  <tr>
      <th colspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;">Tanggal</th>
      <th colspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;">Angsuran</th>
      <th rowspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;padding-top:20px;" width="80">Saldo Pokok</th>
      <th rowspan="2" style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;padding-top:20px;" width="70">Validasi</th>
  </tr>
  <tr>
      <th style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="60">Angsur</th>
      <th style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="60">Bayar</th>
      <th style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="15">Ke</th>
      <th style="background-color:#eee;padding:5px;text-align:center;border:1px solid #ddd;border-bottom:2px solid #ddd;" width="80">Jumlah</th>
  </tr>
  </thead>        
  <tbody>
    <?php echo $row_angsuran;?>
  </tbody>
</table>
</div>