<?php
$CI = get_instance();
?>
<style type="text/css">
  <!--
  #hor-minimalist-b {
    background: #fff;
    margin-top: 10px;
    border-collapse: collapse;
    font-family: Arial, Helvetica, sans-serif;
    /*text-align: left;*/
  }

  #hor-minimalist-b .title {
    border-bottom: 1px solid #262626;
    border-left: 1px solid #262626;
    border-right: 1px solid #262626;
    border-top: 1px solid #262626;
    color: #000;
    font-weight: bold;
    font-size: 10px;
    padding: 5px 7px;
    text-align: center;
    /*text-align: center;*/
  }

  #hor-minimalist-b .konten {
    border-bottom: 1px solid #262626;
    border-left: 1px solid #262626;
    border-right: 1px solid #262626;
    border-top: 1px solid #262626;
    color: #000;
    font-size: 9px;
    padding: 5px 7px;
    text-align: center;
    /*text-align: center;*/
  }

  #hor-minimalist-b .nominal {
    border-bottom: 1px solid #262626;
    border-left: 1px solid #262626;
    border-right: 1px solid #262626;
    border-top: 1px solid #262626;
    color: #000;
    font-size: 9px;
    padding: 5px 7px;
    text-align: right;
    /*text-align: center;*/
  }
  -->
</style>
<page>
  <div style="width:100%;">
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:22px;">
      <?php echo strtoupper($this->session->userdata('institution_name')); ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
      <?php echo $cabang; ?>
    </div>
    <div style="text-align:center;padding-top:10px;font-family:Arial;font-size:18px;">
      List Anggota Masuk
    </div>
    <hr>
  </div>
  <table id="hor-minimalist-b" align="center">
    <tbody>
      <tr>
        <td colspan="2" class="title">Anggota</td>
        <td rowspan="2" class="title">Majelis</td>
        <td rowspan="2" class="title">Tanggal<br />
          Gabung</td>
        <td rowspan="2" class="title">Jenis Kelamin</td>
        <td rowspan="2" class="title">Ibu Kandung</td>
        <td rowspan="2" class="title">Tempat Lahir</td>
        <td rowspan="2" class="title">Tanggal Lahir</td>
        <td rowspan="2" class="title">Usia</td>
        <td rowspan="2" class="title">Alamat</td>
        <td rowspan="2" class="title">Petugas</td>
      </tr>
      <tr>
        <td class="title">ID</td>
        <td class="title">Nama</td>
      </tr>
      <?php
      $no = 1;

      foreach ($list_anggota_masuk as $data) {
        if ($data['jenis_kelamin'] == 'L') {
          $kelamin = 'Laki-laki';
        } else {
          $kelamin = 'Perempuan';
        }
      ?>

        <tr class="value">
          <td class="konten"><?php echo $data['cif_no']; ?></td>
          <td class="konten"><?php echo $data['nama']; ?></td>
          <td class="konten"><?php echo $data['cm_name']; ?></td>
          <td class="konten"><?php echo @$CI->format_date_detail($data['tgl_gabung'], 'id', false, '-'); ?></td>
          <td class="konten"><?php echo $kelamin; ?></td>
          <td class="konten"><?php echo $data['ibu_kandung']; ?></td>
          <td class="konten"><?php echo $data['tmp_lahir']; ?></td>
          <td class="konten"><?php echo @$CI->format_date_detail($data['tgl_lahir'], 'id', false, '-'); ?></td>
          <td class="konten"><?php echo $data['usia']; ?></td>
          <td class="konten"><?php echo $data['alamat']; ?></td>
          <td class="konten"><?php echo $data['fa_name']; ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</page>