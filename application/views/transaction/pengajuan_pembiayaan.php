<style>
   .canvas-container {
      margin: 0 auto;
   }

   .img-thumbnail {
      border: 1px solid #ddd;
      border-radius: 4px;
      padding: 5px;
      width: 150px;
   }
</style><!-- BEGIN PAGE HEADER-->
<div class="row-fluid">
   <div class="span12">
      <!-- BEGIN STYLE CUSTOMIZER -->
      <div class="color-panel hidden-phone">
         <div class="color-mode-icons icon-color"></div>
         <div class="color-mode-icons icon-color-close"></div>
         <div class="color-mode">
            <p>THEME COLOR</p>
            <ul class="inline">
               <li class="color-black current color-default" data-style="default"></li>
               <li class="color-blue" data-style="blue"></li>
               <li class="color-brown" data-style="brown"></li>
               <li class="color-purple" data-style="purple"></li>
               <li class="color-white color-light" data-style="light"></li>
            </ul>
            <label class="hidden-phone">
               <input type="checkbox" class="header" checked value="" />
               <span class="color-mode-label">Fixed Header</span>
            </label>
         </div>
      </div>
      <!-- END BEGIN STYLE CUSTOMIZER -->
      <!-- BEGIN PAGE TITLE & BREADCRUMB-->
      <h3 class="page-title">
         Pembiayaan <small>Pengajuan Pembiayaan</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a>
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pengajuan Pembiayaan</a></li>
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pengajuan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
               Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
               Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <th width="3%"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th>
               <th width="11%">No. Pengajuan</th>
               <th width="13%">Nama Lengkap</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="12%">Rencana Droping</th>
               <th width="10%">Amount</th>
               <th width="10%">Peruntukan</th>
               <th width="9%">Pembiayaan</th>
               <th width="4%">Edit</th>
               <th width="4%">Batalkan</th>
               <th width="4%">Tolak</th>
            </tr>
         </thead>
         <tbody>

         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog_history" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:150px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>History Outstanding Pembiayaan</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <table>
               <tr>
                  <td width="150">No. Pembiayaan</td>
                  <td>
                     <div id="history_no_pembiayaan"></div>
                  </td>
               </tr>
               <tr>
                  <td width="150">Sisa Saldo Pokok</td>
                  <td>
                     <div id="history_sisa_pokok"></div>
                  </td>
               </tr>
               <tr>
                  <td width="150">Sisa Saldo Margin</td>
                  <td>
                     <div id="history_sisa_margin"></div>
                  </td>
               </tr>
               <tr>
                  <td width="150">Sisa Saldo Catab</td>
                  <td>
                     <div id="history_sisa_catab"></div>
                  </td>
               </tr>
            </table>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>


<!-- BEGIN ADD  -->
<div id="add" class="hide">

   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Aplikasi Pengajuan Pembiayaan (APP) </div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <input type="hidden" id="no_cif" name="no_cif">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message">You have some form errors. Please check below.</span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>
            <div class="control-group">
               <input type="hidden" id="cif_type_hidden" name="cif_type_hidden">
               <label class="control-label">No Anggota<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" tabindex="1" readonly="" style="background-color:#eee;" />
                  <input type="hidden" id="branch_code" name="branch_code">

                  <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Cari CIF</h3>
                     </div>
                     <div class="modal-body">
                        <div class="row-fluid">
                           <div class="span12">
                              <h4>Masukan Kata Kunci</h4>
                              <?php /*
                                          */
                              ?>
                              <p><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                    <option value="">Pilih Tipe CIF</option>
                                    <option value="" class="hidden">All</option>
                                    <option value="1">Individu</option>
                                    <option value="0" selected="selected">Kelompok</option>
                                 </select></p>
                              <p class="hide" id="pcm" style="height:32px">
                                 <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                    <option value="">Pilih Rembug</option>
                                    <?php foreach ($rembugs as $rembug) : ?>
                                       <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                       <?php endforeach; ?>;
                                 </select>
                              </p>
                              <?php
                              //}
                              ?>
                              <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                              <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
                           </div>
                        </div>
                     </div>
                     <div class="modal-footer">
                        <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                        <button type="button" id="select" class="btn blue">Select</button>
                     </div>
                  </div>

                  <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" class="medium m-wrap" tabindex="2" readonly="" style="background-color:#eee;" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No KTP</label>
               <div class="controls">
                  <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" tabindex="3" maxlength="16" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat</label>
               <div class="controls">
                  <input type="text" name="alamat_lengkap" id="alamat_lengkap" class="medium m-wrap " tabindex="4" readonly="" style="background-color:#eee;width:300px;" />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Rembug </label>
               <div class="controls">
                  <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" tabindex="5" readonly="readonly" style="background-color:#eee;" />
               </div>
            </div>

            <hr>

            <div class="control-group">
               <label class="control-label">Jenis Pembiyaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="financing_type" id="financing_type" class="medium m-wrap" data-required="1" tabindex="6">
                     <option value="">-- Pilih --</option>
                     <option value="0">Kelompok</option>
                     <option value="1">Individu</option>
                  </select>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class="m-wrap" style="width:50px;" name="pyd" id="pyd" tabindex="7" maxlength="3">
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Jumlah Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" tabindex="8" style="width:120px;" name="amount" id="amount" maxlength="12">
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Peruntukan<span class="required">*</span></label>
               <div class="controls">
                  <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1" tabindex="9">
                     <?php foreach ($peruntukan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_pengajuan" id="mask_date" value="<?php echo $date; ?>" class="date-picker small m-wrap" tabindex="10" ; />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_droping" id="mask_date" value="<?php echo $tanggal_pencairan; ?>" t class="date-picker small m-wrap" tabindex="11" ; />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan" name="keterangan" class="m-wrap medium" tabindex="12"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload KTP</label>
               <div class="controls">
                  <input type="file" name="doc_ktp" id="doc_ktp" />
                  <input name="new_ktp" type="hidden" id="new_ktp"><br />
                  <img id="img_ktp" class="img-thumbnail">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload KK</label>
               <div class="controls">
                  <input type="file" name="doc_kk" id="doc_kk" />
                  <input name="new_kk" type="hidden" id="new_kk"><br />
                  <img id="img_kk" class="img-thumbnail">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload Dokumen Pendukung</label>
               <div class="controls">
                  <input type="file" name="doc_pendukung" id="doc_pendukung" />
                  <input name="new_pendukung" type="hidden" id="new_pendukung"><br />
                  <img id="img_pendukung" class="img-thumbnail">
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label" style="background: #35aa47; color: white; text-align: center; font-style: bold; font-size: 16px;  width: 1060px;  height: 25px; ">MEMORANDUM ANALISIS PEMBIAYAAN</label>
            </div>

            <div class="control-group">
               <button type="button" class="btn blue" id="map_data">Gunakan MAP terakhir</button>
            </div>

            <div class="control-group">
               <label class="control-label">No Telp Anggota</label>
               <div class="controls">
                  <input type="text" name="telp_no" id="telp_no" class="medium m-wrap" tabindex="13" ; />

                  <span style="line-height:30px; padding-left: 167px; padding-right: 10px;">No Telp Suami</span>
                  <input type="text" name="psg_telp" id="psg_telp" class="medium m-wrap" tabindex="15" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pekerjaan Anggota<span class="required">*</span></label>
               <div class="controls">
                  <select name="pekerjaan" id="pekerjaan" class="medium m-wrap" data-required="1" tabindex="14">
                     <?php foreach ($pekerjaan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>

                  <span style="line-height:30px; padding-left: 155px; padding-right: 10px;">Pekerjaan Suami</span>

                  <select name="psg_pekerjaan" id="psg_pekerjaan" class="medium m-wrap" data-required="1" tabindex="16">
                     <?php foreach ($pekerjaan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>

               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Pendapatan Gaji</label>
               <div class="controls">
                  <input type="text" name="pend_gaji" id="pend_gaji" class="medium m-wrap mask-money" tabindex="17" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 135px; padding-right: 10px;">Jumlah Tanggungan</span>
                  <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="medium m-wrap" tabindex="21" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pendapatan Usaha</label>
               <div class="controls">
                  <input type="text" name="pend_usaha" id="pend_usaha" class="medium m-wrap mask-money" tabindex="18" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 185px; padding-right: 10px;">Keterangan</span>
                  <input type="text" name="ket_tanggungan" id="ket_tanggungan" class="medium m-wrap" tabindex="22" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pendapatan Lainya</label>
               <div class="controls">
                  <input type="text" name="pend_lainya" id="pend_lainya" class="medium m-wrap mask-money" tabindex="19" value="0" style="text-align: right" ; />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Total Pendapatan</label>
               <div class="controls">
                  <input type="text" name="pend_total" id="pend_total" class="medium m-wrap mask-money" tabindex="20" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Biaya Dapur</label>
               <div class="controls">
                  <input type="text" name="by_dapur" id="by_dapur" class="medium m-wrap mask-money" tabindex="23" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 157px; padding-right: 10px;">Biaya Kontrakan</span>

                  <input type="text" name="by_sewa_rumah" id="by_sewa_rumah" class="medium m-wrap mask-money" tabindex="28" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya BBM/Gas</label>
               <div class="controls">
                  <input type="text" name="by_gas" id="by_gas" class="medium m-wrap mask-money" tabindex="24" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 169px; padding-right: 10px;">Biaya Kreditan</span>

                  <input type="text" name="by_kredit" id="by_kredit" class="medium m-wrap mask-money" tabindex="29" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Listrik</label>
               <div class="controls">
                  <input type="text" name="by_listrik" id="by_listrik" class="medium m-wrap mask-money" tabindex="25" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 182px; padding-right: 10px;">Biaya Arisan</span>

                  <input type="text" name="by_arisan" id="by_arisan" class="medium m-wrap mask-money" tabindex="30" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Telp</label>
               <div class="controls">
                  <input type="text" name="by_pulsa" id="by_pulsa" class="medium m-wrap mask-money" tabindex="26" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 191px; padding-right: 10px;">Biaya Jajan</span>

                  <input type="text" name="by_jajan" id="by_jajan" class="medium m-wrap mask-money" tabindex="31" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Air /PDAM</label>
               <div class="controls">
                  <input type="text" name="by_air" id="by_air" class="medium m-wrap mask-money" tabindex="27" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 173px; padding-right: 10px;">Hutang lainya</span>

                  <input type="text" name="by_hutang_ph3" id="by_hutang_ph3" class="medium m-wrap mask-money" tabindex="32" value="0" style="text-align: right" ; />

               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">SPP/Pendidikan Anak</label>
               <div class="controls">
                  <input type="text" name="by_spp_anak" id="by_spp_anak" class="medium m-wrap mask-money" tabindex="33" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 133px; padding-right: 10px;">Biaya Transpot Anak</span>

                  <input type="text" name="by_transport_anak" id="by_transport_anak" class="medium m-wrap mask-money" tabindex="35" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Biaya Jajan Anak</label>
               <div class="controls">
                  <input type="text" name="by_jajan_anak" id="by_jajan_anak" class="medium m-wrap mask-money" tabindex="34" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 148px; padding-right: 10px;">Biaya Anak Lainya</span>

                  <input type="text" name="by_lainya_anak" id="by_lainya_anak" class="medium m-wrap mask-money" tabindex="36" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label" style="padding-left: 506px;  padding-right: 13px" ;>Total Biaya</label>
               <div class="controls">
                  <input type="text" name="by_total" id="by_total" class="medium m-wrap" tabindex="37" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>

            <div class="control-group">
               <label class="control-label">Saving Power</label>
               <div class="controls">
                  <input type="text" name="saving_power" id="saving_power" class="medium m-wrap" tabindex="38" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />

                  <span style="line-height:30px; padding-left: 134px; padding-right: 10px;">Repayment Capacity</span>

                  <input type="text" name="repayment_capacity" id="repayment_capacity" class="medium m-wrap" tabindex="39" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Rumah</label>
               <div class="controls">
                  <input type="text" name="rumah_jml" id="rumah_jml" class="medium m-wrap" style="max-width: 30px; text-align: right; " tabindex="40" value="0" ; />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="rumah_nom" id="rumah_nom" class="m-wrap mask-money" value="0" tabindex="41" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="rumah_ket" id="rumah_ket" class="medium m-wrap" tabindex="42" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanah</label>
               <div class="controls">
                  <input type="text" name="tanah_jml" id="tanah_jml" class="medium m-wrap" value="0" tabindex="43" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="tanah_nom" id="tanah_nom" class="m-wrap mask-money" value="0" tabindex="44" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="tanah_ket" id="tanah_ket" class="medium m-wrap" tabindex="45" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Mobil</label>
               <div class="controls">
                  <input type="text" name="mobil_jml" id="mobil_jml" class="medium m-wrap" value="0" tabindex="46" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="mobil_nom" id="mobil_nom" class="m-wrap mask-money" value="0" tabindex="47" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="mobil_ket" id="mobil_ket" class="medium m-wrap" tabindex="48" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Motor</label>
               <div class="controls">
                  <input type="text" name="motor_jml" id="motor_jml" class="medium m-wrap" value="0" tabindex="49" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="motor_nom" id="motor_nom" class="m-wrap mask-money" value="0" tabindex="50" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="motor_ket" id="motor_ket" class="medium m-wrap" tabindex="51" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Sepeda</label>
               <div class="controls">
                  <input type="text" name="sepeda_jml" id="sepeda_jml" class="medium m-wrap" value="0" tabindex="52" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="sepeda_nom" id="sepeda_nom" class="m-wrap mask-money" value="0" tabindex="53" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="sepeda_ket" id="sepeda_ket" class="medium m-wrap" tabindex="54" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">TV</label>
               <div class="controls">
                  <input type="text" name="tv_jml" id="tv_jml" class="medium m-wrap" value="0" tabindex="55" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="tv_nom" id="tv_nom" class="m-wrap mask-money" value="0" tabindex="56" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="tv_ket" id="tv_ket" class="medium m-wrap" tabindex="57" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">DVD</label>
               <div class="controls">
                  <input type="text" name="dvd_jml" id="dvd_jml" class="medium m-wrap" value="0" tabindex="58" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="dvd_nom" id="dvd_nom" class="m-wrap mask-money" value="0" tabindex="59" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="dvd_ket" id="dvd_ket" class="medium m-wrap" tabindex="60" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Kulkas</label>
               <div class="controls">
                  <input type="text" name="kulkas_jml" id="kulkas_jml" class="medium m-wrap" value="0" tabindex="61" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="kulkas_nom" id="kulkas_nom" class="m-wrap mask-money" value="0" tabindex="62" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="kulkas_ket" id="kulkas_ket" class="medium m-wrap" tabindex="63" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">M Cuci</label>
               <div class="controls">
                  <input type="text" name="mcuci_jml" id="mcuci_jml" class="medium m-wrap" value="0" tabindex="64" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="mcuci_nom" id="mcuci_nom" class="m-wrap mask-money" value="0" tabindex="65" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="mcuci_ket" id="mcuci_ket" class="medium m-wrap" tabindex="66" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Ternak</label>
               <div class="controls">
                  <input type="text" name="ternak_jml" id="ternak_jml" class="medium m-wrap" value="0" tabindex="67" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="ternak_nom" id="ternak_nom" class="m-wrap mask-money" value="0" tabindex="68" style="max-width: 160px; text-align: right; " />
                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="ternak_ket" id="ternak_ket" class="medium m-wrap" tabindex="69" ; />

               </div>
            </div>


            <hr>

            <div class="control-group">
               <label class="control-label">Jenis Usaha</label>
               <div class="controls">
                  <input type="text" name="jenis_usaha" id="jenis_usaha" class="medium m-wrap" tabindex="70" ; />

                  <span style="line-height:30px; padding-left: 176px; padding-right: 12px;">Lokasi Usaha</span>
                  <input type="text" name="lokasi_usaha" id="lokasi_usaha" class="medium m-wrap" tabindex="73" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Komoditi</label>
               <div class="controls">
                  <input type="text" name="komoditi" id="komoditi" class="medium m-wrap" tabindex="71" ; />

                  <span style="line-height:30px; padding-left: 190px; padding-right: 12px;">Aset usaha</span>
                  <input type="text" name="aset_usaha_desc" id="aset_usaha_desc" class="medium m-wrap" tabindex="74" style="text-align: left" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Lama Usaha (Th) </label>
               <div class="controls">
                  <input type="text" name="lama_usaha" id="lama_usaha" class="medium m-wrap" value="0" tabindex="72" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 180px; padding-right: 12px;">Nilai Aset Rp</span>

                  <input type="text" name="aset_usaha_nom" id="aset_usaha_nom" class="medium m-wrap mask-money" value="0" tabindex="75" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Surat Ijin Usaha</label>
               <div class="controls">
                  <input type="text" name="no_izin_usaha" id="no_izin_usaha" class="medium m-wrap" tabindex="71" ; />

               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Modal Awal</label>
               <div class="controls">
                  <input type="text" name="modal_awal" id="modal_awal" class="medium m-wrap mask-money" value="0" tabindex="76" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 160px; padding-right: 12px;">Biaya Transport</span>

                  <input type="text" name="by_usaha_transport" id="by_usaha_transport" class="medium m-wrap mask-money" value="0" tabindex="83" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Omset</label>
               <div class="controls">
                  <input type="text" name="omset_usaha" id="omset_usaha" class="medium m-wrap mask-money" value="0" tabindex="77" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 167px; padding-right: 12px;">By Pengiriman</span>

                  <input type="text" name="by_usaha_kirim" id="by_usaha_kirim" class="medium m-wrap mask-money" value="0" tabindex="84" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">HPP</label>
               <div class="controls">
                  <input type="text" name="hpp_usaha" id="hpp_usaha" class="medium m-wrap mask-money" value="0" tabindex="78" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 177px; padding-right: 12px;">By Karyawan</span>

                  <input type="text" name="by_usaha_karyawan" id="by_usaha_karyawan" class="medium m-wrap mask-money" value="0" tabindex="85" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Persediaan</label>
               <div class="controls">
                  <input type="text" name="persediaan_usaha" id="persediaan_usaha" class="medium m-wrap mask-money" value="0" tabindex="79" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 172px; padding-right: 12px;">By Perawatan</span>

                  <input type="text" name="by_usaha_perawatan" id="by_usaha_perawatan" class="medium m-wrap mask-money" value="0" tabindex="86" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Piutang</label>
               <div class="controls">
                  <input type="text" name="piutang_usaha" id="piutang_usaha" class="medium m-wrap mask-money" value="0" tabindex="80" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 177px; padding-right: 12px;">By Konsumsi</span>

                  <input type="text" name="by_usaha_konsumsi" id="by_usaha_konsumsi" class="medium m-wrap mask-money" value="0" tabindex="87" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Freq Belanja</label>
               <div class="controls">
                  <input type="text" name="frek_belanja" id="frek_belanja" class="medium m-wrap" value="0" tabindex="81" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 174px; padding-right: 12px;">Sewa Tempat</span>

                  <input type="text" name="by_usaha_sewa" id="by_usaha_sewa" class="medium m-wrap mask-money" value="0" tabindex="88" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Laba Kotor</label>
               <div class="controls">
                  <input type="text" name="laba_kotor" id="laba_kotor" class="medium m-wrap mask-money" value="0" tabindex="82" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 148px; padding-right: 12px;">Total Biaya Usaha</span>

                  <input type="text" name="by_usaha_total" id="by_usaha_total" class="medium m-wrap" value="0" tabindex="89" readonly="" style="text-align: right; background-color:#eee; " ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label" style="padding-left: 504px;  padding-right: 15px" ;>Keuntungan Usaha</label>
               <div class="controls">
                  <input type="text" name="laba_bersih" id="laba_bersih" class="medium m-wrap" value="0" tabindex="90" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label" style="background: #35aa47; color: white; text-align: center; font-style: bold; font-size: 16px;  width: 1060px;  height: 25px; ">TANDA TANGAN</label>
            </div>

            <div class="row-fluid">
               <div class="span12 text-center">
                  <canvas id="ttd_anggota" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p style="margin-top: 10px;">
                     Anggota <br>
                     <button type="button" class="btn blue" onclick="resetCanvasAnggota('add');">Reset Tanda Tangan</button>
                  </p>
                  <hr>
               </div>
            </div>

            <div class="row-fluid" id="ketua_majelis">
               <div class="span12 text-center">
                  <canvas id="ttd_ketua_majelis" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p style="margin-top: 10px;">
                     Ketua Majelis <br>
                     <button type="button" class="btn blue" onclick="resetCanvasKetuaMajelis('add');">Reset Tanda Tangan</button>
                  </p>
                  <hr>
               </div>
            </div>

            <div class="row-fluid" id="pasangan">
               <div class="span12 text-center">
                  <canvas id="ttd_pasangan" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p style="margin-top: 10px;">
                     Pasangan <br>
                     <button type="button" class="btn blue" onclick="resetCanvasPasangan('add');">Reset Tanda Tangan</button>
                  </p>
                  <hr>
               </div>
            </div>

            <div class="row-fluid">
               <div class="span12 text-center">
                  <canvas id="ttd_tpl" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p style="margin-top: 10px;">
                     TPL <br>
                     <button type="button" class="btn blue" onclick="resetCanvasTPL('add');">Reset Tanda Tangan</button>
                  </p>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
               <span style="line-height:30px; padding-left: 400px; padding-right: 10px;"></span>
               <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
            </div>

            <!-- END FORM-->
      </div>
      </form>
   </div>
</div>
<!-- END ADD  -->

<!-- BEGIN EDIT  -->
<div id="edit" class="hide">

   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Aplikasi Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal" enctype="multipart/form-data" method="POST">
            <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <input type="hidden" id="registration_no" name="registration_no">
            <input type="hidden" id="map_no" name="map_no">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Pengajuan Pembiayaan Berhasil!
            </div>
            </br>

            <div class="control-group">
               <label class="control-label">No Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;" /><input type="hidden" id="branch_code" name="branch_code">

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input type="text" name="nama2" id="nama2" class="medium m-wrap" readonly="" style="background-color:#eee;" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No KTP</label>
               <div class="controls">
                  <input type="text" name="no_ktp2" id="no_ktp2" class="medium m-wrap" readonly="" style="background-color:#eee;" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Alamat</label>
               <div class="controls">
                  <input type="text" name="alamat_lengkap2" id="alamat_lengkap2" class="medium m-wrap" readonly="" style="background-color:#eee;" />
               </div>
            </div>
            <!--
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tmp_lahir2" id="tmp_lahir2" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:30px">Tanggal Lahir</span>

                        <input type="text" class=" m-wrap" name="tgl_lahir2" id="tgl_lahir2" readonly="" style="background-color:#eee;width:100px;"/>

                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia2" id="usia2" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    -->
            <div class="control-group">
               <label class="control-label">Rembug </label>
               <div class="controls">
                  <input type="text" name="cm_name2" id="cm_name2" class="medium m-wrap" readonly="readonly" style="background-color:#eee;" />
               </div>
            </div>
            <hr>
            <div class="control-group">
               <label class="control-label">Jenis Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="financing_type2" id="financing_type2" class="medium m-wrap" data-required="1">
                     <option value="">-- Pilih --</option>
                     <option value="0">Kelompok</option>
                     <option value="1">Individu</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class="m-wrap" style="width:50px;" name="pyd2" id="pyd2" maxlength="3">
               </div>
            </div>
            <!---
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input name="uang_muka2" type="text" class="m-wrap mask-money" id="uang_muka2" style="width:120px;" value="0" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    -->
            <div class="control-group">
               <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount2" id="amount2" maxlength="12">
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="peruntukan2" id="peruntukan2" class="medium m-wrap" data-required="1">
                     <?php foreach ($peruntukan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_pengajuan2" id="mask_date" class="date-picker small m-wrap" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="rencana_droping2" id="mask_date" class="date-picker small m-wrap" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="keterangan2" name="keterangan2" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload KTP</label>
               <div class="controls">
                  <input type="file" name="doc_ktp" id="doc_ktp" />
                  <input name="old_ktp" type="hidden" id="old_ktp"><br />
                  <img id="img_ktp" class="img-thumbnail">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload KK</label>
               <div class="controls">
                  <input type="file" name="doc_kk" id="doc_kk" />
                  <input name="old_kk" type="hidden" id="old_kk"><br />
                  <img id="img_kk" class="img-thumbnail">
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Upload Dokumen Pendukung</label>
               <div class="controls">
                  <input type="file" name="doc_pendukung" id="doc_pendukung" />
                  <input name="old_pendukung" type="hidden" id="old_pendukung"><br />
                  <img id="img_pendukung" class="img-thumbnail">
               </div>
            </div>
            <hr>
            <div class="control-group">
               <label class="control-label" style="background: #852b99; color: white; text-align: center; font-style: bold; font-size: 16px;  width: 1060px;  height: 25px; ">MEMORANDUM ANALISIS PEMBIAYAAN</label>
            </div>

            <div class="control-group">
               <label class="control-label">No Telp Anggota</label>
               <div class="controls">
                  <input type="text" name="telp_no2" id="telp_no2" class="medium m-wrap" ; />

                  <span style="line-height:30px; padding-left: 167px; padding-right: 10px;">No Telp Suami</span>
                  <input type="text" name="psg_telp2" id="psg_telp2" class="medium m-wrap" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pekerjaan Anggota<span class="required">*</span></label>
               <div class="controls">
                  <select name="pekerjaan2" id="pekerjaan2" class="medium m-wrap" data-required="1">
                     <?php foreach ($pekerjaan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>

                  <span style="line-height:30px; padding-left: 155px; padding-right: 10px;">Pekerjaan Suami</span>

                  <select name="psg_pekerjaan2" id="psg_pekerjaan2" class="medium m-wrap" data-required="1">
                     <?php foreach ($pekerjaan as $data) : ?>
                        <option value="<?php echo $data['code_value']; ?>"><?php echo $data['display_text']; ?></option>
                     <?php endforeach ?>
                  </select>

               </div>
            </div>

            <hr>

            <div class="control-group">
               <label class="control-label">Pendapatan Gaji</label>
               <div class="controls">
                  <input type="text" name="pend_gaji2" id="pend_gaji2" class="medium m-wrap mask-money" tabindex="17" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 135px; padding-right: 10px;">Jumlah Tanggungan</span>
                  <input type="text" name="jumlah_tanggungan2" id="jumlah_tanggungan2" class="medium m-wrap" tabindex="21" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pendapatan Usaha</label>
               <div class="controls">
                  <input type="text" name="pend_usaha2" id="pend_usaha2" class="medium m-wrap mask-money" tabindex="18" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 185px; padding-right: 10px;">Keterangan</span>
                  <input type="text" name="ket_tanggungan2" id="ket_tanggungan2" class="medium m-wrap" tabindex="22" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Pendapatan Lainya</label>
               <div class="controls">
                  <input type="text" name="pend_lainya2" id="pend_lainya2" class="medium m-wrap mask-money" tabindex="19" value="0" style="text-align: right" ; />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Total Pendapatan</label>
               <div class="controls">
                  <input type="text" name="pend_total2" id="pend_total2" class="medium m-wrap mask-money" tabindex="20" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Biaya Dapur</label>
               <div class="controls">
                  <input type="text" name="by_dapur2" id="by_dapur2" class="medium m-wrap mask-money" tabindex="23" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 157px; padding-right: 10px;">Biaya Kontrakan</span>

                  <input type="text" name="by_sewa_rumah2" id="by_sewa_rumah2" class="medium m-wrap mask-money" tabindex="28" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya BBM/Gas</label>
               <div class="controls">
                  <input type="text" name="by_gas2" id="by_gas2" class="medium m-wrap mask-money" tabindex="24" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 169px; padding-right: 10px;">Biaya Kreditan</span>

                  <input type="text" name="by_kredit2" id="by_kredit2" class="medium m-wrap mask-money" tabindex="29" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Listrik</label>
               <div class="controls">
                  <input type="text" name="by_listrik2" id="by_listrik2" class="medium m-wrap mask-money" tabindex="25" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 182px; padding-right: 10px;">Biaya Arisan</span>

                  <input type="text" name="by_arisan2" id="by_arisan2" class="medium m-wrap mask-money" tabindex="30" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Telp</label>
               <div class="controls">
                  <input type="text" name="by_pulsa2" id="by_pulsa2" class="medium m-wrap mask-money" tabindex="26" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 191px; padding-right: 10px;">Biaya Jajan</span>

                  <input type="text" name="by_jajan2" id="by_jajan2" class="medium m-wrap mask-money" tabindex="31" value="0" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Air /PDAM</label>
               <div class="controls">
                  <input type="text" name="by_air2" id="by_air2" class="medium m-wrap mask-money" tabindex="27" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 173px; padding-right: 10px;">Hutang lainya</span>

                  <input type="text" name="by_hutang_ph32" id="by_hutang_ph32" class="medium m-wrap mask-money" tabindex="32" value="0" style="text-align: right" ; />

               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">SPP/Pendidikan</label>
               <div class="controls">
                  <input type="text" name="by_spp_anak2" id="by_spp_anak2" class="medium m-wrap mask-money" tabindex="33" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 133px; padding-right: 10px;">Biaya Transpot Anak</span>

                  <input type="text" name="by_transport_anak2" id="by_transport_anak2" class="medium m-wrap mask-money" tabindex="35" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Biaya Jajan Anak</label>
               <div class="controls">
                  <input type="text" name="by_jajan_anak2" id="by_jajan_anak2" class="medium m-wrap mask-money" tabindex="34" value="0" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 148px; padding-right: 10px;">Biaya Anak Lainya</span>

                  <input type="text" name="by_lainya_anak2" id="by_lainya_anak2" class="medium m-wrap mask-money" tabindex="36" value="0" style="text-align: right" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label" style="padding-left: 506px;  padding-right: 13px" ;>Total Biaya</label>
               <div class="controls">
                  <input type="text" name="by_total2" id="by_total2" class="medium m-wrap mask-money" tabindex="37" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>

            <div class="control-group">
               <label class="control-label">Saving Power</label>
               <div class="controls">
                  <input type="text" name="saving_power2" id="saving_power2" class="medium m-wrap mask-money" tabindex="38" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />

                  <span style="line-height:30px; padding-left: 134px; padding-right: 10px;">Repayment Capacity</span>

                  <input type="text" name="repayment_capacity2" id="repayment_capacity2" class="medium m-wrap mask-money" tabindex="39" value="0" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Rumah</label>
               <div class="controls">
                  <input type="text" name="rumah_jml2" id="rumah_jml2" class="medium m-wrap" style="max-width: 30px; text-align: right; " tabindex="40" value="0" ; />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="rumah_nom2" id="rumah_nom2" class="m-wrap mask-money" value="0" tabindex="41" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="rumah_ket2" id="rumah_ket2" class="medium m-wrap" tabindex="42" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanah</label>
               <div class="controls">
                  <input type="text" name="tanah_jml2" id="tanah_jml2" class="medium m-wrap" value="0" tabindex="43" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="tanah_nom2" id="tanah_nom2" class="m-wrap mask-money" value="0" tabindex="44" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="tanah_ket2" id="tanah_ket2" class="medium m-wrap" tabindex="45" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Mobil</label>
               <div class="controls">
                  <input type="text" name="mobil_jml2" id="mobil_jml2" class="medium m-wrap" value="0" tabindex="46" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="mobil_nom2" id="mobil_nom2" class="m-wrap mask-money" value="0" tabindex="47" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="mobil_ket2" id="mobil_ket2" class="medium m-wrap" tabindex="48" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Motor</label>
               <div class="controls">
                  <input type="text" name="motor_jml2" id="motor_jml2" class="medium m-wrap" value="0" tabindex="49" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="motor_nom2" id="motor_nom2" class="m-wrap mask-money" value="0" tabindex="50" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="motor_ket2" id="motor_ket2" class="medium m-wrap" tabindex="51" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Sepeda</label>
               <div class="controls">
                  <input type="text" name="sepeda_jml2" id="sepeda_jml2" class="medium m-wrap" value="0" tabindex="52" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="sepeda_nom2" id="sepeda_nom2" class="m-wrap mask-money" value="0" tabindex="53" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="sepeda_ket2" id="sepeda_ket2" class="medium m-wrap" tabindex="54" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">TV</label>
               <div class="controls">
                  <input type="text" name="tv_jml2" id="tv_jml2" class="medium m-wrap" value="0" tabindex="55" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="tv_nom2" id="tv_nom2" class="m-wrap mask-money" value="0" tabindex="56" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="tv_ket2" id="tv_ket2" class="medium m-wrap" tabindex="57" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">DVD</label>
               <div class="controls">
                  <input type="text" name="dvd_jml2" id="dvd_jml2" class="medium m-wrap" value="0" tabindex="58" style="max-width: 30px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="dvd_nom2" id="dvd_nom2" class="m-wrap mask-money" value="0" tabindex="59" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="dvd_ket2" id="dvd_ket2" class="medium m-wrap" tabindex="60" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Kulkas</label>
               <div class="controls">
                  <input type="text" name="kulkas_jml2" id="kulkas_jml2" class="medium m-wrap" value="0" tabindex="61" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="kulkas_nom2" id="kulkas_nom2" class="m-wrap mask-money" value="0" tabindex="62" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="kulkas_ket2" id="kulkas_ket2" class="medium m-wrap" tabindex="63" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">M Cuci</label>
               <div class="controls">
                  <input type="text" name="mcuci_jml2" id="mcuci_jml2" class="medium m-wrap" value="0" tabindex="64" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="mcuci_nom2" id="mcuci_nom2" class="m-wrap mask-money" value="0" tabindex="65" style="max-width: 160px; text-align: right; " />

                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="mcuci_ket2" id="mcuci_ket2" class="medium m-wrap" tabindex="66" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Ternak</label>
               <div class="controls">
                  <input type="text" name="ternak_jml2" id="ternak_jml2" class="medium m-wrap" value="0" tabindex="67" style="max-width: 30px;  text-align: right; " />

                  <span style="line-height:30px; padding-left: 74px; padding-right: 10px;">Nilai Rp</span>

                  <input type="text" name="ternak_nom2" id="ternak_nom2" class="m-wrap mask-money" value="0" tabindex="68" style="max-width: 160px; text-align: right; " />
                  <span style="line-height:30px; padding-left: 60px; padding-right: 10px;">Keterangan</span>

                  <input type="text" name="ternak_ket2" id="ternak_ket2" class="medium m-wrap" tabindex="69" ; />

               </div>
            </div>


            <hr>

            <div class="control-group">
               <label class="control-label">Jenis Usaha</label>
               <div class="controls">
                  <input type="text" name="jenis_usaha2" id="jenis_usaha2" class="medium m-wrap" tabindex="70" ; />

                  <span style="line-height:30px; padding-left: 176px; padding-right: 12px;">Lokasi Usaha</span>
                  <input type="text" name="lokasi_usaha2" id="lokasi_usaha2" class="medium m-wrap" tabindex="73" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Komoditi</label>
               <div class="controls">
                  <input type="text" name="komoditi2" id="komoditi2" class="medium m-wrap" tabindex="71" ; />

                  <span style="line-height:30px; padding-left: 190px; padding-right: 12px;">Aset usaha</span>
                  <input type="text" name="aset_usaha_desc2" id="aset_usaha_desc2" class="medium m-wrap" tabindex="74" style="text-align: left" ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Lama Usaha (Th)</label>
               <div class="controls">
                  <input type="text" name="lama_usaha2" id="lama_usaha2" class="medium m-wrap" value="0" tabindex="72" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 180px; padding-right: 12px;">Nilai Aset Rp</span>

                  <input type="text" name="aset_usaha_nom2" id="aset_usaha_nom2" class="medium m-wrap mask-money" value="0" tabindex="75" style="text-align: right" ; />

               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label">Modal Awal</label>
               <div class="controls">
                  <input type="text" name="modal_awal2" id="modal_awal2" class="medium m-wrap mask-money" value="0" tabindex="76" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 160px; padding-right: 12px;">Biaya Transport</span>

                  <input type="text" name="by_usaha_transport2" id="by_usaha_transport2" class="medium m-wrap mask-money" value="0" tabindex="83" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Omset</label>
               <div class="controls">
                  <input type="text" name="omset_usaha2" id="omset_usaha2" class="medium m-wrap mask-money" value="0" tabindex="77" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 167px; padding-right: 12px;">By Pengiriman</span>

                  <input type="text" name="by_usaha_kirim2" id="by_usaha_kirim2" class="medium m-wrap mask-money" value="0" tabindex="84" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">HPP</label>
               <div class="controls">
                  <input type="text" name="hpp_usaha2" id="hpp_usaha2" class="medium m-wrap mask-money" value="0" tabindex="78" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 177px; padding-right: 12px;">By Karyawan</span>

                  <input type="text" name="by_usaha_karyawan2" id="by_usaha_karyawan2" class="medium m-wrap mask-money" value="0" tabindex="85" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Persediaan</label>
               <div class="controls">
                  <input type="text" name="persediaan_usaha2" id="persediaan_usaha2" class="medium m-wrap mask-money" value="0" tabindex="79" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 172px; padding-right: 12px;">By Perawatan</span>

                  <input type="text" name="by_usaha_perawatan2" id="by_usaha_perawatan2" class="medium m-wrap mask-money" value="0" tabindex="86" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Piutang</label>
               <div class="controls">
                  <input type="text" name="piutang_usaha2" id="piutang_usaha2" class="medium m-wrap mask-money" value="0" tabindex="80" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 177px; padding-right: 12px;">By Konsumsi</span>

                  <input type="text" name="by_usaha_konsumsi2" id="by_usaha_konsumsi2" class="medium m-wrap mask-money" value="0" tabindex="87" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Freq Belanja</label>
               <div class="controls">
                  <input type="text" name="frek_belanja2" id="frek_belanja2" class="medium m-wrap" value="0" tabindex="81" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 174px; padding-right: 12px;">Sewa Tempat</span>

                  <input type="text" name="by_usaha_sewa2" id="by_usaha_sewa2" class="medium m-wrap mask-money" value="0" tabindex="88" style="text-align: right" ; />

               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Laba Kotor</label>
               <div class="controls">
                  <input type="text" name="laba_kotor2" id="laba_kotor2" class="medium m-wrap mask-money" value="0" tabindex="82" style="text-align: right" ; />

                  <span style="line-height:30px; padding-left: 149px; padding-right: 12px;">Total Biaya usaha</span>

                  <input type="text" name="by_usaha_total2" id="by_usaha_total2" class="medium m-wrap mask-money" value="0" tabindex="89" readonly="" style="text-align: right; background-color:#eee; " ; />

               </div>
            </div>

            <div class="control-group">
               <label class="control-label" style="padding-left: 504px;  padding-right: 15px" ;>Keuntungan Usaha</label>
               <div class="controls">
                  <input type="text" name="laba_bersih2" id="laba_bersih2" class="medium m-wrap mask-money" value="0" tabindex="90" readonly="" style="text-align: right; background-color:#eee; " ; />
               </div>
            </div>

            <hr>
            <div class="control-group">
               <label class="control-label" style="background: #852b99; color: white; text-align: center; font-style: bold; font-size: 16px;  width: 1060px;  height: 25px; ">TANDA TANGAN</label>
            </div>

            <div class="row-fluid">
               <div id="gambar_ttd_edit" class="span12 text-center" style="margin-bottom:10px; margin-top: 10px;">
                  <img id="ttd_anggota_gambar" src="" alt="ttd_anggota" class="img-thumbnail" />
                  <p>Tanda Tangan Anggota</p>
                  <button type="button" class="btn blue" onclick="editCanvasAnggota();">Edit Tanda Tangan</button>
               </div>
               <div id="canvas_ttd_edit" class="span12 text-center" style="display:none; margin-bottom:10px; margin-top: 10px;">
                  <canvas id="ttd_anggota_edit" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p>Tanda Tangan Anggota</p>
                  <button type="button" class="btn blue" onclick="resetCanvasAnggota('edit');">Reset Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="saveCanvasAnggota();">Simpan Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="cancelCanvasAnggota();">Cancel</button>
               </div>
            </div>

            <div class="row-fluid" id="ketua_majelis">
               <div id="gambar_ttd_ketua_majelis_edit" class="span12 text-center" style="margin-bottom:10px; margin-top: 10px;">
                  <img id="ttd_ketua_majelis_gambar" src="" alt="ttd_ketua_majelis" class="img-thumbnail" />
                  <p>Tanda Tangan Ketua Majelis</p>
                  <button type="button" class="btn blue" onclick="editCanvasKetuaMajelis();">Edit Tanda Tangan</button>
               </div>
               <div id="canvas_ttd_ketua_majelis_edit" class="span12 text-center" style="display:none; margin-bottom:10px; margin-top: 10px;">
                  <canvas id="ttd_ketua_majelis_edit" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p>Tanda Tangan Ketua Majelis</p>
                  <button type="button" class="btn blue" onclick="resetCanvasKetuaMajelis('edit');">Reset Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="saveCanvasKetuaMajelis();">Simpan Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="cancelCanvasKetuaMajelis();">Cancel</button>
               </div>
            </div>

            <div class="row-fluid" id="pasangan">
               <div id="gambar_ttd_pasangan_edit" class="span12 text-center" style="margin-bottom:10px; margin-top: 10px;">
                  <img id="ttd_pasangan_gambar" src="" alt="ttd_pasangan" class="img-thumbnail" />
                  <p>Tanda Tangan Pasangan</p>
                  <button type="button" class="btn blue" onclick="editCanvasPasangan();">Edit Tanda Tangan</button>
               </div>
               <div id="canvas_ttd_pasangan_edit" class="span12 text-center" style="display:none; margin-bottom:10px; margin-top: 10px;">
                  <canvas id="ttd_pasangan_edit" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p>Tanda Tangan Pasangan</p>
                  <button type="button" class="btn blue" onclick="resetCanvasPasangan('edit');">Reset Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="saveCanvasPasangan();">Simpan Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="cancelCanvasPasangan();">Cancel</button>
               </div>
            </div>

            <div class="row-fluid">
               <div id="gambar_ttd_tpl_edit" class="span12 text-center" style="margin-bottom:10px; margin-top: 10px;">
                  <img id="ttd_tpl_gambar" src="" alt="ttd_tpl" class="img-thumbnail" />
                  <p>Tanda Tangan TPL</p>
                  <button type="button" class="btn blue" onclick="editCanvasTPL();">Edit Tanda Tangan</button>
               </div>
               <div id="canvas_ttd_tpl_edit" class="span12 text-center" style="display:none; margin-bottom:10px; margin-top: 10px;">
                  <canvas id="ttd_tpl_edit" width="500" height="200" style="border:1px solid black;">
                  </canvas>
                  <p>Tanda Tangan TPL</p>
                  <button type="button" class="btn blue" onclick="resetCanvasTPL('edit');">Reset Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="saveCanvasTPL();">Simpan Tanda Tangan</button>
                  <button type="button" class="btn blue" onclick="cancelCanvasTPL();">Cancel</button>
               </div>
            </div>

            <div class="form-actions">
               <button type="submit" class="btn purple">Update</button>
               <button type="button" class="btn" id="cancel">Back</button>

               <div class="pull-right">
                     <a class="btn green" href="javascript:;" onclick="printMAP();">Print Pengajuan</a>
                     <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
               </div>

            </div>
         </form>
         <!-- END FORM-->
      </div>


      <!-- END FORM-->
   </div>
</div>
</div>
<!-- END EDIT  -->



<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/fabric.min.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   var canvas = new fabric.Canvas("ttd_anggota");
   canvas.isDrawingMode = true;
   canvas.freeDrawingBrush.width = 2;

   var canvasKetuaMajelis = new fabric.Canvas("ttd_ketua_majelis");
   canvasKetuaMajelis.isDrawingMode = true;
   canvasKetuaMajelis.freeDrawingBrush.width = 2;

   var canvasPasangan = new fabric.Canvas("ttd_pasangan");
   canvasPasangan.isDrawingMode = true;
   canvasPasangan.freeDrawingBrush.width = 2;

   var canvasTPL = new fabric.Canvas("ttd_tpl");
   canvasTPL.isDrawingMode = true;
   canvasTPL.freeDrawingBrush.width = 2;

   var canvas2 = new fabric.Canvas("ttd_anggota_edit");
   canvas2.isDrawingMode = true;
   canvas2.freeDrawingBrush.width = 2;

   var canvasKetuaMajelisEdit = new fabric.Canvas("ttd_ketua_majelis_edit");
   canvasKetuaMajelisEdit.isDrawingMode = true;
   canvasKetuaMajelisEdit.freeDrawingBrush.width = 2;

   var canvasPasanganEdit = new fabric.Canvas("ttd_pasangan_edit");
   canvasPasanganEdit.isDrawingMode = true;
   canvasPasanganEdit.freeDrawingBrush.width = 2;

   var canvasTPLEdit = new fabric.Canvas("ttd_tpl_edit");
   canvasTPLEdit.isDrawingMode = true;
   canvasTPLEdit.freeDrawingBrush.width = 2;

   function resetCanvasAnggota(tipe) {
      if (tipe == 'add') {
         canvas.clear();
      } else {
         canvas2.clear();
      }
   }

   function resetCanvasKetuaMajelis(tipe) {
      if (tipe == 'add') {
         canvasKetuaMajelis.clear();
      } else {
         canvasKetuaMajelisEdit.clear();
      }
   }

   function resetCanvasPasangan(tipe) {
      if (tipe == 'add') {
         canvasPasangan.clear();
      } else {
         canvasPasanganEdit.clear();
      }
   }

   function resetCanvasTPL(tipe) {
      if (tipe == 'add') {
         canvasTPL.clear();
      } else {
         canvasTPLEdit.clear();
      }
   }

   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins

      $("input#mask_date,.mask_date").livequery(function() {
         $(this).inputmask("d/m/y"); //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
   // fungsi untuk reload data table
   // di dalam fungsi ini ada variable tbl_id
   // gantilah value dari tbl_id ini sesuai dengan element nya
   var dTreload = function() {
      var tbl_id = 'pengajuan_pembiayaan_table';
      $("select[name='" + tbl_id + "_length']").trigger('change');
      $(".paging_bootstrap li:first a").trigger('click');
      $("#" + tbl_id + "_filter input").val('').trigger('keyup');
   }


   // fungsi untuk check all
   jQuery('#pengajuan_pembiayaan_table .group-checkable').live('change', function() {
      var set = jQuery(this).attr("data-set");
      var checked = jQuery(this).is(":checked");
      jQuery(set).each(function() {
         if (checked) {
            $(this).attr("checked", true);
         } else {
            $(this).attr("checked", false);
         }
      });
      jQuery.uniform.update(set);
   });

   $("#pengajuan_pembiayaan_table .checkboxes").livequery(function() {
      $(this).uniform();
   });

   // BEGIN FORM ADD USER VALIDATION
   var form1 = $('#form_add');
   var error1 = $('.alert-error', form1);
   var success1 = $('.alert-success', form1);


   $("#btn_add").click(function() {
      $("#wrapper-table").hide();
      resetCanvasAnggota('add');
      $("#add").show();
      form1.trigger('reset');
      $("#span_message", form1).html("You have some form errors. Please check below.");
   });

   form1.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      errorPlacement: function(error, element) {},
      // ignore: "",
      rules: {
         no_ktp: {
            required: true,
            number: true,
            minlength: 16,
            maxlength: 16
         },
         cif_no: {
            required: true
         },
         financing_type: {
            required: true,
            number: true
         },
         pyd: {
            required: true,
            number: true
         },
         uang_muka: {
            required: true
         },
         amount: {
            required: true
         },
         peruntukan: {
            required: true
         },
         rencana_droping: {
            required: true
         },
         tanggal_pengajuan: {
            required: true
         },
         keterangan: {
            required: true
         }
      },

      invalidHandler: function(event, validator) { //display error alert on form submit              
         success1.hide();
         error1.show();
         App.scrollTo(error1, -200);
      },

      highlight: function(element) { // hightlight error inputs

         $(element)
            .closest('.help-inline').removeClass('ok').html(''); // display OK icon
         $(element)
            .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group

      },

      unhighlight: function(element) { // revert the change dony by hightlight
         $(element)
            .closest('.control-group').removeClass('error'); // set error class to the control group
      },

      success: function(label) {
         // if(label.closest('.input-append').length==0)
         // {
         //   label
         //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
         //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
         // }
         // else
         // {
         //    label.closest('.control-group').removeClass('error').addClass('success')
         //    label.remove();
         // }
      },

      submitHandler: function(form) {
         bValid = true;
         var ftype = $('#financing_type', '#form_add').val();

         if (ftype == 0) {
            $.ajax({
               url: site_url + "rekening_nasabah/cek_aktif_pengajuan",
               type: "POST",
               dataType: "html",
               async: false,
               data: {
                  cif_no: $("#cif_no", form1).val()
               },
               success: function(response) {
                  if (response == '1') {
                     bValid = false;
                     error_message = "Tidak Dapat Dilanjutkan. Anggota Masih Memiliki Pengajuan Yang Belum Diproses";
                  }
               },
               error: function() {
                  bValid = false;
                  error_message = "Kesalahan database, harap hubungi IT Support";
               }
            });

            $.ajax({
               url: site_url + "rekening_nasabah/cek_aktif_pembiayaan",
               type: "POST",
               dataType: "html",
               async: false,
               data: {
                  cif_no: $("#cif_no", form1).val()
               },
               success: function(response) {
                  if (response == '1') {
                     bValid = false;
                     error_message = "Tidak Dapat Dilanjutkan. Anggota Masih Memiliki Pembiayaan Yang Belum Lunas";
                  }
               },
               error: function() {
                  bValid = false;
                  error_message = "Kesalahan database, harap hubungi IT Support";
               }
            });
         }

         if (bValid == true) {
            let data = form1.serializeArray();
            console.log(data);
            console.log($.param(data));

            if (canvas.isEmpty() === true) {
               error_message = 'tanda tangan anggota tidak boleh kosong';
               bValid = false;
            } else if (canvasTPL.isEmpty() === true) {
               error_message = 'tanda tangan TPL tidak boleh kosong';
               bValid = false;
            } else {
               let ttd1 = canvas.toDataURL("png");
               data.push({
                  'name': 'ttd_anggota',
                  'value': ttd1,
               });

               let ttd2 = canvasKetuaMajelis.toDataURL("png");
               data.push({
                  'name': 'ttd_ketua_majelis',
                  'value': ttd2,
               });

               let ttd4 = canvasPasangan.toDataURL("png");
               data.push({
                  'name': 'ttd_pasangan',
                  'value': ttd4,
               });

               let ttd3 = canvasTPL.toDataURL("png");
               data.push({
                  'name': 'ttd_tpl',
                  'value': ttd3,
               });

               $.ajax({
                  type: "POST",
                  url: site_url + "rekening_nasabah/add_pengajuan_pembiayaan",
                  dataType: "json",
                  data: $.param(data),
                  success: function(response) {
                     if (response.success == true) {
                        form1.ajaxSubmit({
                           url: '<?= site_url('rekening_nasabah/upload_document'); ?>',
                           data: 'POST',
                           dataType: "json",
                           success: function(response) {
                              if (response.success == true) {
                                 success1.show();
                                 error1.hide();
                                 form1.trigger('reset');
                                 form1.find('.control-group').removeClass('success');
                                 $("#cancel", form_add).trigger('click')
                                 alert('Successfully Saved Data');
                                 window.location.reload();
                              }
                           },
                           error: function() {
                              success1.hide();
                              error1.show();
                           }
                        });
                     } else {
                        success1.hide();
                        error1.show();
                     }
                     App.scrollTo(form1, -200);
                  },
                  error: function() {
                     success1.hide();
                     error1.show();
                     App.scrollTo(form1, -200);
                  }
               });
            }
         }
      }
   });

   // event untuk kembali ke tampilan data table (ADD FORM)
   $("#cancel", "#form_add").click(function() {
      success1.hide();
      error1.hide();
      $("#add").hide();
      $("#wrapper-table").show();
      dTreload();
   });




   // fn Calculate Total Pendapatan 
   var calc_pendapatan_total = function() {
      var pend_gaji = (isNaN(parseFloat(convert_numeric($("#pend_gaji").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_gaji").val()));
      var pend_usaha = (isNaN(parseFloat(convert_numeric($("#pend_usaha").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_usaha").val()));
      var pend_lainya = (isNaN(parseFloat(convert_numeric($("#pend_lainya").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_lainya").val()));
      var pend_total = pend_gaji + pend_usaha + pend_lainya;

      var by_total = (isNaN(parseFloat(convert_numeric($("#by_total").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_total").val()));
      var saving_power = pend_total - by_total;
      var repayment_capacity = (75 / 100) * saving_power;
      $("#pend_total").val(number_format(pend_total, 0, ',', '.'));
      $("#saving_power").val(number_format(saving_power, 0, ',', '.'));
      $("#repayment_capacity").val(number_format(repayment_capacity, 0, ',', '.'));
   };

   // Event : Calc Total Pendapatan       
   $("#pend_gaji,#pend_usaha,#pend_lainya", form1).change(function() {
      calc_pendapatan_total();
   });


   // fn Calculate Total Pendapatan edit 
   var calc_pendapatan_total_edit = function() {
      var pend_gaji2 = (isNaN(parseFloat(convert_numeric($("#pend_gaji2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_gaji2").val()));
      var pend_usaha2 = (isNaN(parseFloat(convert_numeric($("#pend_usaha2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_usaha2").val()));
      var pend_lainya2 = (isNaN(parseFloat(convert_numeric($("#pend_lainya2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_lainya2").val()));
      var pend_total2 = pend_gaji2 + pend_usaha2 + pend_lainya2;

      var by_total2 = (isNaN(parseFloat(convert_numeric($("#by_total2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_total2").val()));
      var saving_power2 = pend_total2 - by_total2;
      var repayment_capacity2 = (75 / 100) * saving_power2;
      $("#pend_total2").val(number_format(pend_total2, 0, ',', '.'));
      $("#saving_power2").val(number_format(saving_power2, 0, ',', '.'));
      $("#repayment_capacity2").val(number_format(repayment_capacity2, 0, ',', '.'));
   };

   // Event : Calc Total Pendapatan edit      
   $("#pend_gaji2,#pend_usaha2,#pend_lainya2", form2).change(function() {
      calc_pendapatan_total_edit();
   });


   // fn Calculate Total Biaya  
   var calc_Biaya_total = function() {
      var by_dapur = (isNaN(parseFloat(convert_numeric($("#by_dapur").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_dapur").val()));
      var by_gas = (isNaN(parseFloat(convert_numeric($("#by_gas").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_gas").val()));
      var by_listrik = (isNaN(parseFloat(convert_numeric($("#by_listrik").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_listrik").val()));
      var by_pulsa = (isNaN(parseFloat(convert_numeric($("#by_pulsa").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_pulsa").val()));
      var by_air = (isNaN(parseFloat(convert_numeric($("#by_air").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_air").val()));
      var by_sewa_rumah = (isNaN(parseFloat(convert_numeric($("#by_sewa_rumah").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_sewa_rumah").val()));
      var by_kredit = (isNaN(parseFloat(convert_numeric($("#by_kredit").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_kredit").val()));
      var by_arisan = (isNaN(parseFloat(convert_numeric($("#by_arisan").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_arisan").val()));
      var by_jajan = (isNaN(parseFloat(convert_numeric($("#by_jajan").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_jajan").val()));
      var by_hutang_ph3 = (isNaN(parseFloat(convert_numeric($("#by_hutang_ph3").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_hutang_ph3").val()));
      var by_spp_anak = (isNaN(parseFloat(convert_numeric($("#by_spp_anak").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_spp_anak").val()));
      var by_jajan_anak = (isNaN(parseFloat(convert_numeric($("#by_jajan_anak").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_jajan_anak").val()));
      var by_transport_anak = (isNaN(parseFloat(convert_numeric($("#by_transport_anak").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_transport_anak").val()));
      var by_lainya_anak = (isNaN(parseFloat(convert_numeric($("#by_lainya_anak").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_lainya_anak").val()));

      var by_total = by_dapur + by_gas + by_listrik + by_pulsa + by_air + by_sewa_rumah + by_kredit + by_arisan + by_jajan + by_hutang_ph3 + by_spp_anak + by_jajan_anak + by_transport_anak + by_lainya_anak;
      var pend_total = (isNaN(parseFloat(convert_numeric($("#pend_total").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_total").val()));
      var saving_power = pend_total - by_total;
      var repayment_capacity = (75 / 100) * saving_power;

      $("#by_total").val(number_format(by_total, 0, ',', '.'));
      $("#saving_power").val(number_format(saving_power, 0, ',', '.'));
      $("#repayment_capacity").val(number_format(repayment_capacity, 0, ',', '.'));

   };

   // Event : Calc Total Biaya        
   $("#by_dapur, #by_gas, #by_listrik, #by_pulsa, #by_air, #by_sewa_rumah, #by_kredit, #by_arisan, #by_jajan, #by_hutang_ph3, #by_spp_anak, #by_jajan_anak, #by_transport_anak, #by_lainya_anak", form1).change(function() {
      calc_Biaya_total();
   });



   // fn Calculate Total Biaya  edit
   var calc_Biaya_total_edit = function() {
      var by_dapur2 = (isNaN(parseFloat(convert_numeric($("#by_dapur2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_dapur2").val()));
      var by_gas2 = (isNaN(parseFloat(convert_numeric($("#by_gas2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_gas2").val()));
      var by_listrik2 = (isNaN(parseFloat(convert_numeric($("#by_listrik2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_listrik2").val()));
      var by_pulsa2 = (isNaN(parseFloat(convert_numeric($("#by_pulsa2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_pulsa2").val()));
      var by_air2 = (isNaN(parseFloat(convert_numeric($("#by_air2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_air2").val()));
      var by_sewa_rumah2 = (isNaN(parseFloat(convert_numeric($("#by_sewa_rumah2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_sewa_rumah2").val()));
      var by_kredit2 = (isNaN(parseFloat(convert_numeric($("#by_kredit2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_kredit2").val()));
      var by_arisan2 = (isNaN(parseFloat(convert_numeric($("#by_arisan2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_arisan2").val()));
      var by_jajan2 = (isNaN(parseFloat(convert_numeric($("#by_jajan2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_jajan2").val()));
      var by_hutang_ph32 = (isNaN(parseFloat(convert_numeric($("#by_hutang_ph32").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_hutang_ph32").val()));
      var by_spp_anak2 = (isNaN(parseFloat(convert_numeric($("#by_spp_anak2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_spp_anak2").val()));
      var by_jajan_anak2 = (isNaN(parseFloat(convert_numeric($("#by_jajan_anak2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_jajan_anak2").val()));
      var by_transport_anak2 = (isNaN(parseFloat(convert_numeric($("#by_transport_anak2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_transport_anak2").val()));
      var by_lainya_anak2 = (isNaN(parseFloat(convert_numeric($("#by_lainya_anak2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_lainya_anak2").val()));

      var by_total2 = by_dapur2 + by_gas2 + by_listrik2 + by_pulsa2 + by_air2 + by_sewa_rumah2 + by_kredit2 + by_arisan2 + by_jajan2 + by_hutang_ph32 + by_spp_anak2 + by_jajan_anak2 + by_transport_anak2 + by_lainya_anak2;
      var pend_total2 = (isNaN(parseFloat(convert_numeric($("#pend_total2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#pend_total2").val()));
      var saving_power2 = pend_total2 - by_total2;
      var repayment_capacity2 = (75 / 100) * saving_power2;

      $("#by_total2").val(number_format(by_total2, 0, ',', '.'));
      $("#saving_power2").val(number_format(saving_power2, 0, ',', '.'));
      $("#repayment_capacity2").val(number_format(repayment_capacity2, 0, ',', '.'));

   };

   // Event : Calc Total Biaya edit        
   $("#by_dapur2, #by_gas2, #by_listrik2, #by_pulsa2, #by_air2, #by_sewa_rumah2, #by_kredit2, #by_arisan2, #by_jajan2, #by_hutang_ph32, #by_spp_anak2, #by_jajan_anak2, #by_transport_anak2, #by_lainya_anak2", form2).change(function() {
      calc_Biaya_total_edit();
   });


   // fn Calculate Total Biaya Usaha  
   var calc_Biaya_usaha_total = function() {
      var by_usaha_transport = (isNaN(parseFloat(convert_numeric($("#by_usaha_transport").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_transport").val()));
      var by_usaha_kirim = (isNaN(parseFloat(convert_numeric($("#by_usaha_kirim").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_kirim").val()));
      var by_usaha_karyawan = (isNaN(parseFloat(convert_numeric($("#by_usaha_karyawan").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_karyawan").val()));
      var by_usaha_perawatan = (isNaN(parseFloat(convert_numeric($("#by_usaha_perawatan").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_perawatan").val()));
      var by_usaha_konsumsi = (isNaN(parseFloat(convert_numeric($("#by_usaha_konsumsi").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_konsumsi").val()));
      var by_usaha_sewa = (isNaN(parseFloat(convert_numeric($("#by_usaha_sewa").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_sewa").val()));

      var by_usaha_total = by_usaha_transport + by_usaha_kirim + by_usaha_karyawan + by_usaha_perawatan + by_usaha_konsumsi + by_usaha_sewa;
      var laba_kotor = (isNaN(parseFloat(convert_numeric($("#laba_kotor").val()))) == true) ? 0 : parseFloat(convert_numeric($("#laba_kotor").val()));
      var laba_bersih = laba_kotor - by_usaha_total;

      $("#by_usaha_total").val(number_format(by_usaha_total, 0, ',', '.'));
      $("#laba_bersih").val(number_format(laba_bersih, 0, ',', '.'));
   };

   // Event : Calc Total Biaya Usaha      
   $("#by_usaha_transport, #by_usaha_kirim, #by_usaha_karyawan, #by_usaha_perawatan, #by_usaha_konsumsi, #by_usaha_sewa", form1).change(function() {
      calc_Biaya_usaha_total();
   });


   // fn Calculate Total Biaya Usaha  Edit 
   var calc_Biaya_usaha_total_edit = function() {
      var by_usaha_transport2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_transport2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_transport2").val()));
      var by_usaha_kirim2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_kirim2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_kirim2").val()));
      var by_usaha_karyawan2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_karyawan2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_karyawan2").val()));
      var by_usaha_perawatan2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_perawatan2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_perawatan2").val()));
      var by_usaha_konsumsi2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_konsumsi2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_konsumsi2").val()));
      var by_usaha_sewa2 = (isNaN(parseFloat(convert_numeric($("#by_usaha_sewa2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#by_usaha_sewa2").val()));

      var by_usaha_total2 = by_usaha_transport2 + by_usaha_kirim2 + by_usaha_karyawan2 + by_usaha_perawatan2 + by_usaha_konsumsi2 + by_usaha_sewa2;
      var laba_kotor2 = (isNaN(parseFloat(convert_numeric($("#laba_kotor2").val()))) == true) ? 0 : parseFloat(convert_numeric($("#laba_kotor2").val()));
      var laba_bersih2 = laba_kotor2 - by_usaha_total2;

      $("#by_usaha_total2").val(number_format(by_usaha_total2, 0, ',', '.'));
      $("#laba_bersih2").val(number_format(laba_bersih2, 0, ',', '.'));
   };

   // Event : Calc Total Biaya Usaha      
   $("#by_usaha_transport2, #by_usaha_kirim2, #by_usaha_karyawan2, #by_usaha_perawatan2, #by_usaha_konsumsi2, #by_usaha_sewa2", form2).change(function() {
      calc_Biaya_usaha_total_edit();
   });



   // BEGIN FORM EDIT VALIDATION
   var form2 = $('#form_edit');
   var error2 = $('.alert-error', form2);
   var success2 = $('.alert-success', form2);

   // event button Edit ketika di tekan
   $("a#link-edit").live('click', function() {
      form2.trigger('reset');
      $("#wrapper-table").hide();
      $("#edit").show();
      var account_financing_reg_id = $(this).attr('account_financing_reg_id');
      var registration_no = $(this).attr('registration_no');
      $.ajax({
         type: "POST",
         async: false,
         dataType: "json",
         data: {
            account_financing_reg_id: account_financing_reg_id,
            registration_no: registration_no
         },
         url: site_url + "rekening_nasabah/get_pengajuan_pembiayaan_by_account_financing_reg_id",
         success: function(response) {
            var finan_type = response.financing_type;
            $("#form_edit input[name='account_financing_reg_id']").val(response.account_financing_reg_id);
            $.ajax({
               type: "POST",
               dataType: "json",
               async: false,
               data: {
                  cif_no: response.cif_no
               },
               url: site_url + "transaction/get_ajax_value_from_cif_no",
               success: function(response) {
                  $("#nama2", "#form_edit").val(response.nama);
                  $("#panggilan2", "#form_edit").val(response.panggilan);
                  $("#ibu_kandung2", "#form_edit").val(response.ibu_kandung);
                  $("#tmp_lahir2", "#form_edit").val(response.tmp_lahir2);
                  $("#no_ktp2", "#form_edit").val(response.no_ktp);

                  var v_alamat2 = response.alamat;
                  var v_rt_rw2 = response.rt_rw;
                  var v_desa2 = response.desa;
                  var v_kecamatan2 = response.kecamatan;
                  var v_kabupaten2 = response.kabupaten;

                  var alamat_lengkap2 = v_alamat2 + " " + v_rt_rw2 + " " + v_desa2 + " " + v_kecamatan2 + " " + v_kabupaten2;
                  $("#alamat_lengkap2", "#form_edit").val(alamat_lengkap2);

                  var tanggal_lahir = response.tgl_lahir;
                  if (tanggal_lahir != null) {
                     var tgl_lahir = tanggal_lahir.substr(8, 2);
                     var bln_lahir = tanggal_lahir.substr(5, 2);
                     var thn_lahir = tanggal_lahir.substr(0, 4);
                     var tgl_lahir_ = tgl_lahir + "-" + bln_lahir + "-" + thn_lahir;
                  } else {
                     tgl_lahir_ = "";
                  }
                  $("#tgl_lahir2", "#form_edit").val(tgl_lahir_);
                  $("#usia2", "#form_edit").val(response.usia);

                  if (response.cm_name != null) {
                     $("#cm_name2", "#form_edit").closest('.control-group').show();
                     $("#cm_name2", "#form_edit").val(response.cm_name);
                  } else {
                     $("#cm_name2", "#form_edit").closest('.control-group').hide();
                     $("#cm_name2", "#form_edit").val('');
                  }
               }
            });
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit select[name='financing_type2']").val(response.financing_type);
            $("#form_edit input[name='pyd2']").val(response.pembiayaan_ke);
            $("#form_edit input[name='amount2']").val(response.amount);
            $("#form_edit select[name='peruntukan2']").val(response.peruntukan);
            $("#form_edit textarea[name='keterangan2']").val(response.description);
            tgl_droping = response.rencana_droping.substring(8, 12) + '' + response.rencana_droping.substring(5, 7) + '' + response.rencana_droping.substring(0, 4);
            $("#form_edit input[name='rencana_droping2']").val(tgl_droping);

            tgl_pengajuan = response.tanggal_pengajuan.substring(8, 12) + '' + response.tanggal_pengajuan.substring(5, 7) + '' + response.tanggal_pengajuan.substring(0, 4);
            $("#form_edit input[name='tanggal_pengajuan2']").val(tgl_pengajuan);

            $("#form_edit input[name='registration_no']").val(response.registration_no);
            $("#form_edit input[name='map_no']").val(response.map_no);
            $("#form_edit input[name='telp_no2']").val(response.telp_no);
            $("#form_edit select[name='pekerjaan2']").val(response.pekerjaan);
            $("#form_edit input[name='psg_telp2']").val(response.psg_telp);
            $("#form_edit select[name='psg_pekerjaan2']").val(response.psg_pekerjaan);
            $("#form_edit input[name='pend_gaji2']").val(response.pend_gaji);
            $("#form_edit input[name='pend_usaha2']").val(response.pend_usaha);
            $("#form_edit input[name='pend_lainya2']").val(response.pend_lainya);
            $("#form_edit input[name='pend_total2']").val(response.pend_total);
            $("#form_edit input[name='jumlah_tanggungan2']").val(response.jumlah_tanggungan);
            $("#form_edit input[name='ket_tanggungan2']").val(response.ket_tanggungan);
            $("#form_edit input[name='by_dapur2']").val(response.by_dapur);
            $("#form_edit input[name='by_gas2']").val(response.by_gas);
            $("#form_edit input[name='by_listrik2']").val(response.by_listrik);
            $("#form_edit input[name='by_pulsa2']").val(response.by_pulsa);
            $("#form_edit input[name='by_air2']").val(response.by_air);
            $("#form_edit input[name='by_sewa_rumah2']").val(response.by_sewa_rumah);
            $("#form_edit input[name='by_kredit2']").val(response.by_kredit);
            $("#form_edit input[name='by_arisan2']").val(response.by_arisan);
            $("#form_edit input[name='by_jajan2']").val(response.by_jajan);
            $("#form_edit input[name='by_hutang_ph32']").val(response.by_hutang_ph3);
            $("#form_edit input[name='by_spp_anak2']").val(response.by_spp_anak);
            $("#form_edit input[name='by_jajan_anak2']").val(response.by_jajan_anak);
            $("#form_edit input[name='by_transport_anak2']").val(response.by_transport_anak);
            $("#form_edit input[name='by_lainya_anak2']").val(response.by_lainya_anak);
            $("#form_edit input[name='by_total2']").val(response.by_total);
            $("#form_edit input[name='saving_power2']").val(response.saving_power);
            $("#form_edit input[name='repayment_capacity2']").val(response.repayment_capacity);
            $("#form_edit input[name='rumah_jml2']").val(response.rumah_jml);
            $("#form_edit input[name='rumah_nom2']").val(response.rumah_nom);
            $("#form_edit input[name='rumah_ket2']").val(response.rumah_ket);
            $("#form_edit input[name='tanah_jml2']").val(response.tanah_jml);
            $("#form_edit input[name='tanah_nom2']").val(response.tanah_nom);
            $("#form_edit input[name='tanah_ket2']").val(response.tanah_ket);
            $("#form_edit input[name='mobil_jml2']").val(response.mobil_jml);
            $("#form_edit input[name='mobil_nom2']").val(response.mobil_nom);
            $("#form_edit input[name='mobil_ket2']").val(response.mobil_ket);
            $("#form_edit input[name='motor_jml2']").val(response.motor_jml);
            $("#form_edit input[name='motor_nom2']").val(response.motor_nom);
            $("#form_edit input[name='motor_ket2']").val(response.motor_ket);
            $("#form_edit input[name='sepeda_jml2']").val(response.sepeda_jml);
            $("#form_edit input[name='sepeda_nom2']").val(response.sepeda_nom);
            $("#form_edit input[name='sepeda_ket2']").val(response.sepeda_ket);
            $("#form_edit input[name='tv_jml2']").val(response.tv_jml);
            $("#form_edit input[name='tv_nom2']").val(response.tv_nom);
            $("#form_edit input[name='tv_ket2']").val(response.tv_ket);
            $("#form_edit input[name='dvd_jml2']").val(response.dvd_jml);
            $("#form_edit input[name='dvd_nom2']").val(response.dvd_nom);
            $("#form_edit input[name='dvd_ket2']").val(response.dvd_ket);
            $("#form_edit input[name='kulkas_jml2']").val(response.kulkas_jml);
            $("#form_edit input[name='kulkas_nom2']").val(response.kulkas_nom);
            $("#form_edit input[name='kulkas_ket2']").val(response.kulkas_ket);
            $("#form_edit input[name='mcuci_jml2']").val(response.mcuci_jml);
            $("#form_edit input[name='mcuci_nom2']").val(response.mcuci_nom);
            $("#form_edit input[name='mcuci_ket2']").val(response.mcuci_ket);
            $("#form_edit input[name='ternak_jml2']").val(response.ternak_jml);
            $("#form_edit input[name='ternak_nom2']").val(response.ternak_nom);
            $("#form_edit input[name='ternak_ket2']").val(response.ternak_ket);
            $("#form_edit input[name='jenis_usaha2']").val(response.jenis_usaha);
            $("#form_edit input[name='komoditi2']").val(response.jenis_komoditi);
            $("#form_edit input[name='lama_usaha2']").val(response.lama_usaha);
            $("#form_edit input[name='lokasi_usaha2']").val(response.lokasi_usaha);
            $("#form_edit input[name='aset_usaha_desc2']").val(response.aset_usaha_desc);
            $("#form_edit input[name='aset_usaha_nom2']").val(response.aset_usaha_nom);
            $("#form_edit input[name='modal_awal2']").val(response.modal_awal);
            $("#form_edit input[name='omset_usaha2']").val(response.omset_usaha);
            $("#form_edit input[name='hpp_usaha2']").val(response.hpp_usaha);
            $("#form_edit input[name='persediaan_usaha2']").val(response.persediaan_usaha);
            $("#form_edit input[name='piutang_usaha2']").val(response.piutang_usaha);
            $("#form_edit input[name='frek_belanja2']").val(response.frek_belanja);
            $("#form_edit input[name='laba_kotor2']").val(response.laba_kotor);
            $("#form_edit input[name='by_usaha_transport2']").val(response.by_usaha_transport);
            $("#form_edit input[name='by_usaha_kirim2']").val(response.by_usaha_kirim);
            $("#form_edit input[name='by_usaha_karyawan2']").val(response.by_usaha_karyawan);
            $("#form_edit input[name='by_usaha_perawatan2']").val(response.by_usaha_perawatan);
            $("#form_edit input[name='by_usaha_konsumsi2']").val(response.by_usaha_konsumsi);
            $("#form_edit input[name='by_usaha_sewa2']").val(response.by_usaha_sewa);
            $("#form_edit input[name='by_usaha_total2']").val(response.by_usaha_total);
            $("#form_edit input[name='laba_bersih2']").val(response.laba_bersih);

            $.ajax({
               type: 'POST',
               url: '<?php echo site_url('rekening_nasabah/get_document'); ?>',
               dataType: 'json',
               data: {
                  cif_no: response.cif_no
               },
               success: function(responze) {
                  var base64_ktp = responze.base64_ktp;
                  var file_ktp = responze.file_ktp;
                  var base64_kk = responze.base64_kk;
                  var file_kk = responze.file_kk;
                  var base64_pendukung = responze.base64_pendukung;
                  var file_pendukung = responze.file_pendukung;

                  $("#img_ktp", "#form_edit").attr('src', base64_ktp);
                  $("#old_ktp", "#form_edit").val(file_ktp);
                  $("#img_kk", "#form_edit").attr('src', base64_kk);
                  $("#old_kk", "#form_edit").val(file_kk);
                  $("#img_pendukung", "#form_edit").attr('src', base64_pendukung);
                  $("#old_pendukung", "#form_edit").val(file_pendukung);
               }
            });

            $("#ttd_anggota_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + response.ttd_anggota);
            $("#ttd_ketua_majelis_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + response.ttd_ketua_majelis);
            $("#ttd_pasangan_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + response.ttd_suami);
            $("#ttd_tpl_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + response.ttd_tpl);
            $("#ttd_anggota_edit_prev").val(response.ttd_anggota);
            $("#ttd_ketua_majelis_edit_prev").val(response.ttd_ketua_majelis);
            $("#ttd_pasangan_edit_prev").val(response.ttd_suami);
            $("#ttd_tpl_edit_prev").val(response.ttd_tpl);
         }
      });

   });


   form2.validate({
      errorElement: 'span', //default input error message container
      errorClass: 'help-inline', // default input error message class
      focusInvalid: false, // do not focus the last invalid input
      errorPlacement: function(error, element) {},
      // ignore: "",
      rules: {
         amount2: {
            required: true
         },
         uang_muka2: {
            required: true
         },
         peruntukan2: {
            required: true
         },
         rencana_droping2: {
            required: true
         },
         tanggal_pengajuan2: {
            required: true
         },
         pyd2: {
            required: true,
            number: true
         },
         keterangan2: {
            required: true
         },
         financing_type2: {
            required: true,
            number: true
         }
      },

      invalidHandler: function(event, validator) { // error alert on ofrm submit              
         success2.hide();
         error2.show();
         App.scrollTo(error2, -200);
      },

      highlight: function(element) { // hightlight error inputs

         $(element)
            .closest('.help-inline').removeClass('ok'); // display OK icon
         $(element)
            .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group

      },


      unhighlight: function(element) { // revert the change dony by hightlight
         $(element)
            .closest('.control-group').removeClass('error'); // set error class to the control group
      },


      success: function(label) {
         // if(label.closest('.input-append').length==0)
         // {
         //   label
         //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
         //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
         // }
         // else
         // {
         //    label.closest('.control-group').removeClass('error').addClass('success')
         //    label.remove();
         // }
      },

      submitHandler: function(form) {

         let data2 = form2.serializeArray();

         if (canvas2.isEmpty() === false) {
            let ttd2 = canvas2.toDataURL("png");
            data2.push({
               'name': 'ttd_anggota',
               'value': ttd2,
            });
         }
         // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/edit_pengajuan_pembiayaan",
            dataType: "json",
            data: data2,
            success: function(response) {
               if (response.success == true) {
                  form2.ajaxSubmit({
                     url: '<?= site_url('rekening_nasabah/upload_document_edit'); ?>',
                     data: 'POST',
                     dataType: "json",
                     success: function(response) {
                        if (response.success == true) {
                           success2.show();
                           error2.hide();
                           form2.children('div').removeClass('success');
                           $("#pengajuan_pembiayaan_table_filter input").val('');
                           dTreload();
                           $("#cancel", form_edit).trigger('click')
                           alert('Successfully Updated Data');
                           window.location.reload();
                        }
                     },
                     error: function() {
                        success2.hide();
                        error2.show();
                     }
                  });
               } else {
                  success2.hide();
                  error2.show();
               }
               App.scrollTo(form2, -200);
            },
            error: function() {
               success2.hide();
               form2.show();
               App.scrollTo(error2, -200);
            }
         });

      }
   });
   //  END FORM EDIT VALIDATION


   // event untuk kembali ke tampilan data table (EDIT FORM)
   $("#cancel", "#form_edit").click(function() {
      $("#edit").hide();
      $("#wrapper-table").show();
      dTreload();
      success2.hide();
      error2.hide();
   });

   // fungsi untuk delete records
   $("#btn_delete").click(function() {

      var account_financing_reg_id = [];
      var registration_no = [];
      var $i = 0;
      $("input#checkbox:checked").each(function() {

         account_financing_reg_id[$i] = $(this).val();
         registration_no[$i] = $(this).val();

         $i++;

      });

      if (account_financing_reg_id.length == 0) {
         alert("Please select some row to delete !");
      } else {
         var conf = confirm('Are you sure to delete this rows ?');
         if (conf) {
            $.ajax({
               type: "POST",
               url: site_url + "rekening_nasabah/delete_pengajuan_pembiayaan",
               dataType: "json",
               data: {
                  account_financing_reg_id: account_financing_reg_id
               },
               success: function(response) {
                  if (response.success == true) {
                     alert("Deleted!");
                     dTreload();
                  } else {
                     alert("Delete Failed!");
                  }
               },
               error: function() {
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
               }
            })
         }
      }

   });


   // fungsi untuk BATAL PENGAJUAN
   $("a#link_batal").live('click', function() {

      var account_financing_reg_id = $(this).attr('account_financing_reg_id');
      var conf = confirm('Batalkan Pengajuan ?');
      if (conf) {
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/batal_pengajuan_pembiayaan",
            dataType: "json",
            data: {
               account_financing_reg_id: account_financing_reg_id
            },
            success: function(response) {
               if (response.success == true) {
                  alert("Berhasil Dibatalkan!");
                  dTreload();
               } else {
                  alert("Gagal Dibatalkan!");
               }
            },
            error: function() {
               alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
         })
      }

   });

   // fungsi untuk TOLAK PENGAJUAN
   $("a#link_tolak").live('click', function() {

      var account_financing_reg_id = $(this).attr('account_financing_reg_id');
      var conf = confirm('Tolak Pengajuan ?');
      if (conf) {
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/tolak_pengajuan_pembiayaan",
            dataType: "json",
            data: {
               account_financing_reg_id: account_financing_reg_id
            },
            success: function(response) {
               if (response.success == true) {
                  alert("Berhasil Ditolak!");
                  dTreload();
               } else {
                  alert("Gagal Ditolak!");
               }
            },
            error: function() {
               alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
         })
      }

   });


   // begin first table
   $('#pengajuan_pembiayaan_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url + "rekening_nasabah/datatable_pengajuan_pembiayaan_setup",
      "aoColumns": [{
            "bSortable": false
         },
         null,
         null,
         null,
         null,
         null,
         null,
         null,
         {
            "bSortable": false
         },
         {
            "bSortable": false
         },
         {
            "bSortable": false
         }
      ],
      "aLengthMenu": [
         [15, 30, 45, -1],
         [15, 30, 45, "All"] // change per page values here
      ],
      // set the initial value
      "iDisplayLength": 15,
      "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      "sPaginationType": "bootstrap",
      "oLanguage": {
         "sLengthMenu": "_MENU_ records per page",
         "oPaginate": {
            "sPrevious": "Prev",
            "sNext": "Next"
         }
      },
      "aoColumnDefs": [{
         'bSortable': false,
         'aTargets': [0]
      }]
   });


   // fungsi untuk mencari CIF_NO
   $(function() {

      $("#select").click(function() {
         result = $("#result").val();
         var customer_no = $("#result").val();
         $("#close", "#dialog_rembug").trigger('click');
         //alert(customer_no);
         $("#cif_no").val(customer_no);
         //fungsi untuk mendapatkan value untuk field-field yang diperlukan
         var cif_no = customer_no;
         $.ajax({
            type: "POST",
            dataType: "json",
            async: false,
            data: {
               cif_no: cif_no
            },
            url: site_url + "transaction/get_ajax_value_from_cif_no",
            success: function(response) {
               $("#branch_code", "#form_add").val(response.branch_code);
               $("#no_cif", "#form_add").val(response.cif_no);
               $("#nama", "#form_add").val(response.nama);
               $("#panggilan", "#form_add").val(response.panggilan);
               $("#ibu_kandung", "#form_add").val(response.ibu_kandung);
               $("#tmp_lahir", "#form_add").val(response.tmp_lahir);
               $("#no_ktp", "#form_add").val(response.no_ktp);
               $("#alamat", "#form_add").val(response.alamat);
               $("#rt_rw", "#form_add").val(response.rt_rw);
               $("#desa", "#form_add").val(response.desa);
               $("#kecamatan", "#form_add").val(response.kecamatan);
               $("#kabupaten", "#form_add").val(response.kabupaten);

               $.ajax({
                  type: 'POST',
                  url: '<?php echo site_url('rekening_nasabah/get_document'); ?>',
                  dataType: 'json',
                  data: {
                     cif_no: cif_no
                  },
                  success: function(responze) {
                     var base64_ktp = responze.base64_ktp;
                     var file_ktp = responze.file_ktp;
                     var base64_kk = responze.base64_kk;
                     var file_kk = responze.file_kk;
                     var base64_pendukung = responze.base64_pendukung;
                     var file_pendukung = responze.file_pendukung;

                     $("#img_ktp", "#form_add").attr('src', base64_ktp);
                     $("#new_ktp", "#form_add").val(file_ktp);
                     $("#img_kk", "#form_add").attr('src', base64_kk);
                     $("#new_kk", "#form_add").val(file_kk);
                     $("#img_pendukung", "#form_add").attr('src', base64_pendukung);
                     $("#new_pendukung", "#form_add").val(file_pendukung);
                  }
               });

               if (response.cm_name != null) {
                  $("#cm_name", "#form_add").closest('.control-group').show();
                  $("#cm_name", "#form_add").val(response.cm_name);
               } else {
                  $("#cm_name", "#form_add").closest('.control-group').hide();
                  $("#cm_name", "#form_add").val('');
               }

               var v_alamat = response.alamat;
               var v_rt_rw = response.rt_rw;
               var v_desa = response.desa;
               var v_kecamatan = response.kecamatan;
               var v_kabupaten = response.kabupaten;

               var alamat_lengkap = v_alamat + " " + v_rt_rw + " " + v_desa + " " + v_kecamatan + " " + v_kabupaten;
               $("#alamat_lengkap", "#form_add").val(alamat_lengkap);

               var tanggal_lahir = response.tgl_lahir;
               if (tanggal_lahir != null) {
                  var tgl_lahir = tanggal_lahir.substr(8, 2);
                  var bln_lahir = tanggal_lahir.substr(5, 2);
                  var thn_lahir = tanggal_lahir.substr(0, 4);
                  var tgl_lahir_ = tgl_lahir + "-" + bln_lahir + "-" + thn_lahir;
               } else {
                  tgl_lahir_ = "";
               }
               $("#tgl_lahir", "#form_add").val(tgl_lahir_);
               $("#usia", "#form_add").val(response.usia);
               $("#cif_type_hidden", "#form_add").val(response.cif_type);
               var cif_type = response.cif_type;
               if (cif_type == 1) {
                  $("#plan_droping", "#form_add").hide();
               } else {
                  $("#plan_droping", "#form_add").show();
               }
               $.ajax({
                  url: site_url + "rekening_nasabah/get_pyd_ke",
                  type: "POST",
                  dataType: "html",
                  data: {
                     cif_no: response.cif_no
                  },
                  success: function(response) {
                     $("#pyd", "#form_add").val(response);
                  }
               })
            }
         });
      });

      $("#result option").live('dblclick', function() {
         $("#select").trigger('click');
      });

      $("#button-dialog").click(function() {
         $("#dialog").dialog('open');
      });

      $('#browse_rembug').click(function() {
         $("select#cif_type").trigger('change');
      });

      $("#cif_type", "#form_add").change(function() {
         type = $("#cif_type", "#form_add").val();
         cm_code = $("select#cm").val();
         if (type == "0") {
            $("p#pcm").show();
         } else {
            $("p#pcm").hide().val('');

            $.ajax({
               type: "POST",
               url: site_url + "cif/search_cif_no_active",
               data: {
                  keyword: $("#keyword").val(),
                  cif_type: type,
                  cm_code: ''
               },
               dataType: "json",
               success: function(response) {
                  var option = '';
                  if (type == "0") {
                     for (i = 0; i < response.length; i++) {
                        option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + ' - ' + response[i].cm_name + '</option>';
                     }
                  } else if (type == "1") {
                     for (i = 0; i < response.length; i++) {
                        option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '</option>';
                     }
                  } else {
                     for (i = 0; i < response.length; i++) {
                        if (response[i].cm_name != null) {
                           cm_name = " - " + response[i].cm_name;
                        } else {
                           cm_name = "";
                        }
                        option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '' + cm_name + '</option>';
                     }
                  }
                  // console.log(option);
                  $("#result").html(option);
               }
            });
         }
      })

      $("#keyword").on('keypress', function(e) {
         if (e.which == 13) {
            type = $("#cif_type", "#form_add").val();
            cm_code = $("select#cm").val();
            if (type == "0") {
               $("p#pcm").show();
            } else {
               $("p#pcm").hide().val('');
               $.ajax({
                  type: "POST",
                  url: site_url + "cif/search_cif_no_active",
                  data: {
                     keyword: $(this).val(),
                     cif_type: type,
                     cm_code: ''
                  },
                  dataType: "json",
                  async: false,
                  success: function(response) {
                     var option = '';
                     if (type == "0") {
                        for (i = 0; i < response.length; i++) {
                           option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + ' - ' + response[i].cm_name + '</option>';
                        }
                     } else if (type == "1") {
                        for (i = 0; i < response.length; i++) {
                           option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '</option>';
                        }
                     } else {
                        for (i = 0; i < response.length; i++) {
                           if (response[i].cm_name != null) {
                              cm_name = " - " + response[i].cm_name;
                           } else {
                              cm_name = "";
                           }
                           option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '' + cm_name + '</option>';
                        }
                     }
                     // console.log(option);
                     $("#result").html(option);
                  }
               });
            }
            return false;
         }
      });

      $("select#cm").on('change', function(e) {
         type = $("#cif_type", "#form_add").val();
         cm_code = $(this).val();
         $.ajax({
            type: "POST",
            url: site_url + "cif/search_cif_no_active",
            data: {
               keyword: $("#keyword").val(),
               cif_type: type,
               cm_code: cm_code
            },
            dataType: "json",
            success: function(response) {
               var option = '';
               if (type == "0") {
                  for (i = 0; i < response.length; i++) {
                     option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + ' - ' + response[i].cm_name + '</option>';
                  }
               } else if (type == "1") {
                  for (i = 0; i < response.length; i++) {
                     option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '</option>';
                  }
               } else {
                  for (i = 0; i < response.length; i++) {
                     if (response[i].cm_name != null) {
                        cm_name = " - " + response[i].cm_name;
                     } else {
                        cm_name = "";
                     }
                     option += '<option value="' + response[i].cif_no + '" nama="' + response[i].nama + '">' + response[i].nama + ' - ' + response[i].cif_no + '' + cm_name + '</option>';
                  }
               }
               // console.log(option);
               $("#result").html(option);
            }
         });
         if (cm_code == "") {
            $("#result").html('');
         }
      });

      //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
      $("a#browse_history", form_add).live('click', function() {
         var cif_no = $("#no_cif").val();
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/history_outstanding_pembiayaan",
            dataType: "json",
            data: {
               cif_no: cif_no
            },
            success: function(response) {
               if (response.account_financing_no == undefined) {
                  account_financing_no = "Data Terakhir Tidak Ditemukan";
               } else {
                  account_financing_no = response.account_financing_no;
               }

               if (response.saldo_pokok == null) {
                  saldo_pokok = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_pokok = response.saldo_pokok;
               }

               if (response.saldo_margin == null) {
                  saldo_margin = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_margin = response.saldo_margin;
               }

               if (response.saldo_catab == null) {
                  saldo_catab = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_catab = response.saldo_catab;
               }
               $("#history_no_pembiayaan").html(": " + account_financing_no);
               $("#history_sisa_pokok").html(": Rp. " + number_format(saldo_pokok, 0, ',', '.'));
               $("#history_sisa_margin").html(": Rp. " + number_format(saldo_margin, 0, ',', '.'));
               $("#history_sisa_catab").html(": Rp. " + number_format(saldo_catab, 0, ',', '.'));
            },
            error: function() {
               alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
         })
      });

      //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
      $("a#browse_history", form_edit).live('click', function() {
         var cif_no = $("#cif_no2").val();
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/history_outstanding_pembiayaan",
            dataType: "json",
            data: {
               cif_no: cif_no
            },
            success: function(response) {
               if (response.account_financing_no == undefined) {
                  account_financing_no = "Data Terakhir Tidak Ditemukan";
               } else {
                  account_financing_no = response.account_financing_no;
               }

               if (response.saldo_pokok == null) {
                  saldo_pokok = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_pokok = response.saldo_pokok;
               }

               if (response.saldo_margin == null) {
                  saldo_margin = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_margin = response.saldo_margin;
               }

               if (response.saldo_catab == null) {
                  saldo_catab = "Data Terakhir Tidak Ditemukan";
               } else {
                  saldo_catab = response.saldo_catab;
               }
               $("#history_no_pembiayaan").html(": " + account_financing_no);
               $("#history_sisa_pokok").html(": Rp. " + number_format(saldo_pokok, 0, ',', '.'));
               $("#history_sisa_margin").html(": Rp. " + number_format(saldo_margin, 0, ',', '.'));
               $("#history_sisa_catab").html(": Rp. " + number_format(saldo_catab, 0, ',', '.'));
            },
            error: function() {
               alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
         })
      });


      $("#map_data", form_add).live('click', function() {
         var cif_no = $("#no_cif").val();
         $.ajax({
            type: "POST",
            url: site_url + "rekening_nasabah/map_data",
            dataType: "json",
            data: {
               cif_no: cif_no
            },
            success: function(response) {
               if (response.registration_no == undefined) {
                  registration_no = "Data Terakhir Tidak Ditemukan";
               } else {
                  registration_no = response.registration_no;
                  $("#form_add input[name='telp_no']").val(response.telp_no);
                  $("#form_add select[name='pekerjaan']").val(response.pekerjaan);
                  $("#form_add input[name='psg_telp']").val(response.psg_telp);
                  $("#form_add select[name='psg_pekerjaan']").val(response.psg_pekerjaan);
                  $("#form_add input[name='pend_gaji']").val(response.pend_gaji);
                  $("#form_add input[name='pend_usaha']").val(response.pend_usaha);
                  $("#form_add input[name='pend_lainya']").val(response.pend_lainya);
                  $("#form_add input[name='pend_total']").val(response.pend_total);
                  $("#form_add input[name='jumlah_tanggungan']").val(response.jumlah_tanggungan);
                  $("#form_add input[name='ket_tanggungan']").val(response.ket_tanggungan);
                  $("#form_add input[name='by_dapur']").val(response.by_dapur);
                  $("#form_add input[name='by_gas']").val(response.by_gas);
                  $("#form_add input[name='by_listrik']").val(response.by_listrik);
                  $("#form_add input[name='by_pulsa']").val(response.by_pulsa);
                  $("#form_add input[name='by_air']").val(response.by_air);
                  $("#form_add input[name='by_sewa_rumah']").val(response.by_sewa_rumah);
                  $("#form_add input[name='by_kredit']").val(response.by_kredit);
                  $("#form_add input[name='by_arisan']").val(response.by_arisan);
                  $("#form_add input[name='by_jajan']").val(response.by_jajan);
                  $("#form_add input[name='by_hutang_ph3']").val(response.by_hutang_ph3);
                  $("#form_add input[name='by_spp_anak']").val(response.by_spp_anak);
                  $("#form_add input[name='by_jajan_anak']").val(response.by_jajan_anak);
                  $("#form_add input[name='by_transport_anak']").val(response.by_transport_anak);
                  $("#form_add input[name='by_lainya_anak']").val(response.by_lainya_anak);
                  $("#form_add input[name='by_total']").val(response.by_total);
                  $("#form_add input[name='saving_power']").val(response.saving_power);
                  $("#form_add input[name='repayment_capacity']").val(response.repayment_capacity);
                  $("#form_add input[name='rumah_jml']").val(response.rumah_jml);
                  $("#form_add input[name='rumah_nom']").val(response.rumah_nom);
                  $("#form_add input[name='rumah_ket']").val(response.rumah_ket);
                  $("#form_add input[name='tanah_jml']").val(response.tanah_jml);
                  $("#form_add input[name='tanah_nom']").val(response.tanah_nom);
                  $("#form_add input[name='tanah_ket']").val(response.tanah_ket);
                  $("#form_add input[name='mobil_jml']").val(response.mobil_jml);
                  $("#form_add input[name='mobil_nom']").val(response.mobil_nom);
                  $("#form_add input[name='mobil_ket']").val(response.mobil_ket);
                  $("#form_add input[name='motor_jml']").val(response.motor_jml);
                  $("#form_add input[name='motor_nom']").val(response.motor_nom);
                  $("#form_add input[name='motor_ket']").val(response.motor_ket);
                  $("#form_add input[name='sepeda_jml']").val(response.sepeda_jml);
                  $("#form_add input[name='sepeda_nom']").val(response.sepeda_nom);
                  $("#form_add input[name='sepeda_ket']").val(response.sepeda_ket);
                  $("#form_add input[name='tv_jml']").val(response.tv_jml);
                  $("#form_add input[name='tv_nom']").val(response.tv_nom);
                  $("#form_add input[name='tv_ket']").val(response.tv_ket);
                  $("#form_add input[name='dvd_jml']").val(response.dvd_jml);
                  $("#form_add input[name='dvd_nom']").val(response.dvd_nom);
                  $("#form_add input[name='dvd_ket']").val(response.dvd_ket);
                  $("#form_add input[name='kulkas_jml']").val(response.kulkas_jml);
                  $("#form_add input[name='kulkas_nom']").val(response.kulkas_nom);
                  $("#form_add input[name='kulkas_ket']").val(response.kulkas_ket);
                  $("#form_add input[name='mcuci_jml']").val(response.mcuci_jml);
                  $("#form_add input[name='mcuci_nom']").val(response.mcuci_nom);
                  $("#form_add input[name='mcuci_ket']").val(response.mcuci_ket);
                  $("#form_add input[name='ternak_jml']").val(response.ternak_jml);
                  $("#form_add input[name='ternak_nom']").val(response.ternak_nom);
                  $("#form_add input[name='ternak_ket']").val(response.ternak_ket);
                  $("#form_add input[name='jenis_usaha']").val(response.jenis_usaha);
                  $("#form_add input[name='komoditi']").val(response.jenis_komoditi);
                  $("#form_add input[name='lama_usaha']").val(response.lama_usaha);
                  $("#form_add input[name='lokasi_usaha']").val(response.lokasi_usaha);
                  $("#form_add input[name='aset_usaha_desc']").val(response.aset_usaha_desc);
                  $("#form_add input[name='aset_usaha_nom']").val(response.aset_usaha_nom);
                  $("#form_add input[name='modal_awal']").val(response.modal_awal);
                  $("#form_add input[name='omset_usaha']").val(response.omset_usaha);
                  $("#form_add input[name='hpp_usaha']").val(response.hpp_usaha);
                  $("#form_add input[name='persediaan_usaha']").val(response.persediaan_usaha);
                  $("#form_add input[name='piutang_usaha']").val(response.piutang_usaha);
                  $("#form_add input[name='frek_belanja']").val(response.frek_belanja);
                  $("#form_add input[name='laba_kotor']").val(response.laba_kotor);
                  $("#form_add input[name='by_usaha_transport']").val(response.by_usaha_transport);
                  $("#form_add input[name='by_usaha_kirim']").val(response.by_usaha_kirim);
                  $("#form_add input[name='by_usaha_karyawan']").val(response.by_usaha_karyawan);
                  $("#form_add input[name='by_usaha_perawatan']").val(response.by_usaha_perawatan);
                  $("#form_add input[name='by_usaha_konsumsi']").val(response.by_usaha_konsumsi);
                  $("#form_add input[name='by_usaha_sewa']").val(response.by_usaha_sewa);
                  $("#form_add input[name='by_usaha_total']").val(response.by_usaha_total);
                  $("#form_add input[name='laba_bersih']").val(response.laba_bersih);
               }

            },
            error: function() {
               alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
            }
         })
      });


      $("input[name='tanggal_pengajuan']", "#form_add").change(function() {
         var tgl_pengajuan = $(this).val();
         explode = tgl_pengajuan.split('/');
         var tanggal_pengajuan = explode[2] + '-' + explode[1] + '-' + explode[0];
         // alert(tanggal_pengajuan);
         $.ajax({
            type: "POST",
            dataType: "json",
            data: {
               tanggal_pengajuan: tanggal_pengajuan
            },
            url: site_url + "transaction/get_plan_pencairan",
            success: function(response) {
               $("input[name='rencana_droping']", "#form_add").val(response.realisasi_pengajuan);
               // alert(response.realisasi_pengajuan);
            }
         });
      });

      $("input[name='tanggal_pengajuan2']", "#form_edit").change(function() {
         var tgl_pengajuan = $(this).val();
         explode = tgl_pengajuan.split('/');
         var tanggal_pengajuan = explode[2] + '-' + explode[1] + '-' + explode[0];
         // alert(tanggal_pengajuan);
         $.ajax({
            type: "POST",
            dataType: "json",
            data: {
               tanggal_pengajuan: tanggal_pengajuan
            },
            url: site_url + "transaction/get_plan_pencairan",
            success: function(response) {
               $("input[name='rencana_droping2']", "#form_edit").val(response.realisasi_pengajuan);
               // alert(response.realisasi_pengajuan);
            }
         });
      });

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
   });

   function editCanvasAnggota() {
      $('#gambar_ttd_edit').hide();
      $('#canvas_ttd_edit').show();
   }

   function editCanvasKetuaMajelis() {
      $('#gambar_ttd_ketua_majelis_edit').hide();
      $('#canvas_ttd_ketua_majelis_edit').show();
   }

   function editCanvasPasangan() {
      $('#gambar_ttd_pasangan_edit').hide();
      $('#canvas_ttd_pasangan_edit').show();
   }

   function editCanvasTPL() {
      $('#gambar_ttd_tpl_edit').hide();
      $('#canvas_ttd_tpl_edit').show();
   }

   function cancelCanvasAnggota() {
      resetCanvasAnggota('edit');
      $('#gambar_ttd_edit').show();
      $('#canvas_ttd_edit').hide();
   }

   function cancelCanvasKetuaMajelis() {
      resetCanvasKetuaMajelis('edit');
      $('#gambar_ttd_ketua_majelis_edit').show();
      $('#canvas_ttd_ketua_majelis_edit').hide();
   }

   function cancelCanvasPasangan() {
      resetCanvasPasangan('edit');
      $('#gambar_ttd_pasangan_edit').show();
      $('#canvas_ttd_pasangan_edit').hide();
   }

   function cancelCanvasTPL() {
      resetCanvasTPL('edit');
      $('#gambar_ttd_tpl_edit').show();
      $('#canvas_ttd_tpl_edit').hide();
   }

   function saveCanvasAnggota() {
      if (canvas2.isEmpty() === true) {
         alert('Tanda Tangan tidak boleh kosong');
         return false;
      }
      let ttd2 = canvas2.toDataURL("png");

      $.ajax({
         url: "<?= site_url('rekening_nasabah/edit_tanda_tangan2'); ?>",
         type: "POST",
         dataType: "json",
         data: {
            map_no: $("#map_no", "#form_edit").val(),
            ttd: ttd2,
            tipe: 'ttd_anggota',
         },
         statusCode: {
            404: () => alert('Page not Found'),
            500: () => alert('Cant connect to database'),
            503: () => alert('Connection Timeout'),
         }
      }).fail(function(res) {
         console.log(res);
         $.unblockUI();
         return false;
      }).done(function(res) {
         console.log(res);

         if (res.code = 200) {
            $("#ttd_anggota_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + res.new_image);
            $('#ttd_anggota_edit_prev').val(res.new_image);
            cancelCanvasAnggota();
         } else {
            alert('Proses simpan tanda tangan gagal, silahkan hubungi team IT');
            return false;
         }
      });
   }

   function saveCanvasKetuaMajelis() {
      let ttd3 = canvasKetuaMajelisEdit.toDataURL("png");

      $.ajax({
         url: "<?= site_url('rekening_nasabah/edit_tanda_tangan2'); ?>",
         type: "POST",
         dataType: "json",
         data: {
            map_no: $("#map_no", "#form_edit").val(),
            ttd: ttd3,
            tipe: 'ttd_ketua_majelis',
         },
         statusCode: {
            404: () => alert('Page not Found'),
            500: () => alert('Cant connect to database'),
            503: () => alert('Connection Timeout'),
         }
      }).fail(function(res) {
         console.log(res);
         $.unblockUI();
         return false;
      }).done(function(res) {
         console.log(res);

         if (res.code = 200) {
            $("#ttd_ketua_majelis_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + res.new_image);
            $('#ttd_ketua_majelis_edit_prev').val(res.new_image);
            cancelCanvasKetuaMajelis();
         } else {
            alert('Proses simpan tanda tangan gagal, silahkan hubungi team IT');
            return false;
         }
      });
   }

   function saveCanvasPasangan() {
      let ttd4 = canvasPasanganEdit.toDataURL("png");

      $.ajax({
         url: "<?= site_url('rekening_nasabah/edit_tanda_tangan2'); ?>",
         type: "POST",
         dataType: "json",
         data: {
            map_no: $("#map_no", "#form_edit").val(),
            ttd: ttd4,
            tipe: 'ttd_suami',
         },
         statusCode: {
            404: () => alert('Page not Found'),
            500: () => alert('Cant connect to database'),
            503: () => alert('Connection Timeout'),
         }
      }).fail(function(res) {
         console.log(res);
         $.unblockUI();
         return false;
      }).done(function(res) {
         console.log(res);

         if (res.code = 200) {
            $("#ttd_pasangan_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + res.new_image);
            $('#ttd_pasangan_edit_prev').val(res.new_image);
            cancelCanvasPasangan();
         } else {
            alert('Proses simpan tanda tangan gagal, silahkan hubungi team IT');
            return false;
         }
      });
   }

   function saveCanvasTPL() {
      if (canvasTPLEdit.isEmpty() === true) {
         alert('Tanda Tangan TPL tidak boleh kosong');
         return false;
      }
      let ttd4 = canvasTPLEdit.toDataURL("png");

      $.ajax({
         url: "<?= site_url('rekening_nasabah/edit_tanda_tangan2'); ?>",
         type: "POST",
         dataType: "json",
         data: {
            map_no: $("#map_no", "#form_edit").val(),
            ttd: ttd4,
            tipe: 'ttd_tpl',
         },
         statusCode: {
            404: () => alert('Page not Found'),
            500: () => alert('Cant connect to database'),
            503: () => alert('Connection Timeout'),
         }
      }).fail(function(res) {
         console.log(res);
         $.unblockUI();
         return false;
      }).done(function(res) {
         console.log(res);

         if (res.code = 200) {
            $("#ttd_tpl_gambar").attr('src', '<?= base_url(); ?>assets/img/ttd/' + res.new_image);
            $('#ttd_tpl_edit_prev').val(res.new_image);
            cancelCanvasTPL();
         } else {
            alert('Proses simpan tanda tangan gagal, silahkan hubungi team IT');
            return false;
         }
      });
   } 

   function printMAP() {

      console.log($('#account_financing_reg_id').val());
      let ttd_anggota_edit_prev = $('#ttd_anggota_edit_prev').val();
      let ttd_ketua_majelis_edit_prev = $('#ttd_ketua_majelis_edit_prev').val();
      let ttd_tpl_edit_prev = $('#ttd_tpl_edit_prev').val();
      let ttd_pasangan_edit_prev = $('#ttd_pasangan_edit_prev').val();

      let data = {
         type: 'edit',
         account_financing_reg_id: $('#account_financing_reg_id').val(),
         no_anggota: $('#cif_no2').val(),
         nama_lengkap: $('#nama2').val(),
         no_ktp: $('#no_ktp2').val(),
         alamat: $('#alamat_lengkap2').val(),
         rembug: $('#cm_name2').val(),
         jenis_pembiayaan: $('#financing_type2 option:selected').text(),
         pembiayaan_ke: $('#pyd2').val(),
         jumlah_pengajuan: $('#amount2').val(),
         jangka_waktu: $('#jangka_waktu2').val(),
         id_peruntukan: $('#peruntukan2').val(),
         peruntukan: $('#peruntukan2 option:selected').text(),
         sumber_pengembalian: $('#sumber_pengembalian2 option:selected').text(),
         tanggal_pengajuan: $('input[name="tanggal_pengajuan2"]').val(),
         rencana_pencairan: $('input[name="rencana_droping2"]').val(),
         keterangan: $('#keterangan2').val(),
         no_telp_anggota: $('#telp_no2').val(),
         no_telp_suami: $('#psg_telp2').val(),
         id_pekerjaan_anggota: $('#pekerjaan2').val(),
         pekerjaan_anggota: $('#pekerjaan2 option:selected').text(),
         id_pekerjaan_suami: $('#psg_pekerjaan2').val(),
         pekerjaan_suami: $('#psg_pekerjaan2 option:selected').text(),
         pendapatan_gaji: $('#pend_gaji2').val(),
         pendapatan_usaha: $('#pend_usaha2').val(),
         pendapatan_lainnya: $('#pend_lainya2').val(),
         total_pendapatan: $('#pend_total2').val(),
         jumlah_tanggungan: $('#jumlah_tanggungan2').val(),
         biaya_rumah_tangga: $('#by_dapur2').val(),
         biaya_rekening: $('#by_listrik2').val(),
         biaya_kontrakan: $('#by_sewa_rumah2').val(),
         biaya_pendidikan: $('#by_spp_anak2').val(),
         hutang_lainnya: $('#by_hutang_ph32').val(),
         total_biaya: $('#by_total2').val(),
         saving_power: $('#saving_power2').val(),
         repayment_capacity: $('#repayment_capacity2').val(),
         jenis_usaha: $('#jenis_usaha2').val(),
         komoditi: $('#komoditi2').val(),
         lama_usaha: $('#lama_usaha2').val(),
         lokasi_usaha: $('#lokasi_usaha2').val(),
         aset_usaha: $('#aset_usaha_desc2').val(),
         surat_ijin_usaha: $('#no_izin_usaha2').val(),
         nilai_aset: $('#aset_usaha_nom2').val(),
         modal: $('#modal_awal2').val(),
         omset: $('#omset_usaha2').val(),
         hpp: $('#hpp_usaha2').val(),
         persediaan: $('#persediaan_usaha2').val(),
         piutang: $('#piutang_usaha2').val(),
         laba_kotor: $('#laba_kotor2').val(),
         by_usaha: $('#by_usaha_karyawan2').val(),
         sewa_tempat: $('#by_usaha_sewa2').val(),
         total_biaya_usaha: $('#by_usaha_total2').val(),
         keuntungan_usaha: $('#laba_bersih2').val(),
         ttd: ttd_anggota_edit_prev,
         ttd_ketua_majelis: ttd_ketua_majelis_edit_prev,
         ttd_tpl: ttd_tpl_edit_prev,
         ttd_pasangan: ttd_pasangan_edit_prev,
         plafond_sebelumnya: $('#plafond_sebelumnya2').val(),
         prestasi_angsuran: $('#prestasi_angsuran2').val(),
         total_setoran: $('#total_setoran2').val(),
         count_total_setoran: $('#count_total_setoran2').val(),
         total_penarikan: $('#total_penarikan2').val(),
         count_total_penarikan: $('#count_total_penarikan2').val(),
         rataan_setoran: $('#rataan_setoran2').val(),
         count_rataan_setoran: $('#count_rataan_setoran2').val(),
         tabungan_sukarela: $('#tabungan_sukarela2').val(),
         taber_html: $('#taber_html2').val(),
         prestasi_kehadiran_anggota: $('#prestasi_kehadiran_anggota_edit').val(),
         pernah_tanggung_renteng: $('#pernah_tanggung_renteng_edit').val(),
         lama_majelis: $('#lama_majelis_edit').val(),
         rataan_kehadiran_majelis: $('#rataan_kehadiran_majelis_edit').val(),
         kekompakan: $('#kekompakan_edit').val(),
         cif_type: $('#cif_type2').val(),
      }
      $.redirect(`<?= site_url('rekening_nasabah/print_map'); ?>`, data, "POST", "_blank");
   }



</script>
<!-- END JAVASCRIPTS -->