<style type="text/css">
  <!--
  #hor-minimalist-b {

    background: #fff;
    margin: 10px;
    margin-top: 10px;
    border-collapse: collapse;
    text-align: left;
  }

  #hor-minimalist-b .title {
    font-size: 14px;
    font-weight: bold;
    color: #000;
    padding: 10px;
    border: 1px solid #262626;
    text-align: center;
  }

  #hor-minimalist-b .konten {
    font-size: 12px;
    color: #000;
    padding: 10px;
    border: 1px solid #262626;
    text-align: center;
  }

  #hor-minimalist-b .nominal {
    font-size: 12px;
    color: #000;
    padding: 10px;
    border: 1px solid #262626;
    text-align: right;
  }

  #hor-minimalist-b .total_saldo {
    font-size: 12px;
    font-weight: bold;
    color: #000;
    padding: 10px;
    border: 1px solid #262626;
    text-align: right;
  }

  #hor-minimalist-b .zero {
    font-size: 12px;
    font-weight: bold;
    color: #000;
    padding: 10px;
    border-right: 1px solid #262626;
    text-align: center;
  }
  -->
</style>
<page>
  <div style="width:100%;">
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:20px;">
      <?php echo strtoupper($this->session->userdata('institution_name')); ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
      Cabang : <?php echo $branch_name; ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
      Laporan Rekap Target vs Realisasi
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:16px;">
      Tahun : <?php echo $tahuntarget; ?>
    </div>
    <hr>
  </div>
  <table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
        <td class="title">No</td>
        <td class="title">Kode</td>
        <td class="title">Keterangan</td>
        <td class="title">Jan</td>
        <td class="title">Feb</td>
        <td class="title">Mar</td>
        <td class="title">Apr</td>
        <td class="title">Mei</td>
        <td class="title">Jun</td>
        <td class="title">Jul</td>
        <td class="title">Agt</td>
        <td class="title">Sep</td>
        <td class="title">Okt</td>
        <td class="title">Nov</td>
        <td class="title">Des</td>
      </tr>
      <?php
      $no = 1;
      foreach ($result as $data) {
      ?>
        <tr>
          <td class="konten"><?php echo $no++; ?></td>
          <td class="konten"><?php echo $data['kode']; ?></td>
          <td class="konten"><?php echo $data['keterangan']; ?></td>
          <td class="konten"><?php echo number_format($data['b1'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b2'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b3'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b4'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b5'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b6'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b7'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b8'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b9'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b10'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b11'], 0, ',', '.'); ?></td>
          <td class="konten"><?php echo number_format($data['b12'], 0, ',', '.'); ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
  <div style="padding-top: 5px;" align="center">
    <img src="<?php echo base_url('grafik/rekap_target_realisasi_line.php?branch_code=' . $branch_code . '&jenistarget=' . $jenistarget . '&tahuntarget=' . $tahuntarget) ?>">
  </div>
</page>