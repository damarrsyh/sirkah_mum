<style type="text/css">
<!--
.smk{
  /*background:url(<?php echo base_url();?>assets/img/smk.png);*/
  font-size:14px;
  width:1122;
  height:735;
}
.text{
  font-size:40px;
  font-weight:bold;
  color: #074093;
  margin-top:0;
  padding-top: 10px;
  padding-bottom: 20px;
  text-align: center;
  text-transform: capitalize;
}
.nominal{
  font-size:50px;
  font-weight:bold;
  color: #7a601e;
  padding-top: 50px;
  text-align: center;
  text-transform: capitalize;
}
.sertifikat{
  font-size:20px;
  padding-bottom: 15px;
  font-weight:bold;
  color: #074093;
  text-align: center;
}
-->
</style>
<table>
  <tr>
    <?php foreach ($sertifikat as $data):?>
    <td align="center" class="smk">
      <p class="sertifikat">
        NO : <?php echo $data['sertifikat_no'];?>
      </p>
      <p class="text">
        <?php echo $data['nama'];?>
        <br><span style="font-size:13px;">
        <?php echo $data['cif_no'];?></span>
      </p>
      <p class="nominal"><?php echo $data['nominal'];?></p>
    </td>
  <?php endforeach?>
  </tr>
</table>