<!-- BEGIN PAGE HEADER-->
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
      SMK Setup <small>Sertifikat Modal Koperasi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Modal Koperasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">SMK</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_detail" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Sertifikat Modal Koperasi</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <table border="1" cellpadding="5">
               <tr>
                 <td width="30" align="center">No</td>
                 <td width="330" align="center">Nama Pemegang Sertifikat</td>
                 <td width="270" align="center">No Sertifikat</td>
                 <td width="100" align="center">Print</td>
               </tr>
               <tr>
                 <td><div id="modal_no"></div></td>
                 <td><div id="modal_nama"></div></td>
                 <td><div id="modal_sertifikat_no"></div></td>
                 <td><div id="modal_print" align="center"></div></td>
               </tr>
            </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Sertifikat Modal Koperasi</div>
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
            <button id="btn_pelepasan" class="btn purple">
              Pelepasan <i class="icon-ok-sign"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete <i class="icon-remove"></i>
            </button>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="registrasi_smk_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#registrasi_smk_table .checkboxes" /></th>
               <th width="20%">No CIF</th>
               <th width="20%">Nama</th>
               <th width="12%">Pembayaran</th>
               <th width="15%">Tanggal Setor</th>
               <th width="17%">Nominal</th>
               <th width="20%">Jumlah</th>
               <!-- <th>Edit</th> -->
               <th>Detail</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD PROGRAN -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Sertifikat Modal Koperasi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Sertifikat Modal Koperasi Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No Sertifikat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="sertifikat_no" id="sertifikat_no" data-required="1" class="medium m-wrap"/>
               </div>
            </div>    
            <div class="control-group">
               <label class="control-label">Status Keanggotaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="status_anggota" id="status_anggota" class="small m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="1">Anggota</option>
                     <option value="0">Non Anggota</option>
                  </select>
               </div>
            </div>

            <div class="control-group" id="r_cif_no">
               <label class="control-label">CIF No<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" /><input type="hidden" id="branch_code" name="branch_code">
                  
                  <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Cari CIF NO</h3>
                     </div>
                     <div class="modal-body">
                        <div class="row-fluid">
                           <div class="span12">
                              <h4>Masukan Kata Kunci</h4>
                              <?php
                              if($this->session->userdata('cif_type')==0){
                              ?>
                                <input type="hidden" id="cif_type" name="cif_type" value="0">
                                <p id="pcm"><select id="cm" class="span12 m-wrap">
                                <option value="">Pilih Rembug</option>
                                <?php foreach($rembugs as $rembug): ?>
                                <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                <?php endforeach; ?>;
                                </select></p>
                              <?php
                              }else if($this->session->userdata('cif_type')==1){
                                echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                              }else{
                              ?>
                                <p>
                                <select name="cif_type" id="cif_type" class="span12 m-wrap">
                                <option value="">Pilih Tipe CIF</option>
                                <option value="">All</option>
                                <option value="1">Individu</option>
                                <option value="0">Kelompok</option>
                                </select>
                                </p>
                                <p class="hide" id="pcm"><select id="cm" class="span12 m-wrap">
                                <option value="">Pilih Rembug</option>
                                <?php foreach($rembugs as $rembug): ?>
                                <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                <?php endforeach; ?>;
                                </select></p>
                              <?php
                              }
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
               <label class="control-label">Nama Pemilik SMK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap" value="<?php echo number_format($nominal,0,',','.') ?>" readonly style="text-align:right" name="nominal" id="nominal" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>           
            <div class="control-group">
               <label class="control-label">Pembayaran<span class="required">*</span></label>
               <div class="controls">
                 <select name="status_option" id="status_option" class="small m-wrap" data-required="1">    
                     <option value="">PILIH</option>
                     <option value="1">Tunai</option>
                     <option value="0">Pinbuk</option>
                 </select>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
               <div class="controls">
                 <select name="account_cash_code" id="account_cash_code" class="medium m-wrap" data-required="1">    
                     <option value="">PILIH</option>
                     <?php foreach($kas_petugas as $data): ?>
                     <option value="<?php echo $data['account_cash_code'];?>"><?php echo $data['account_cash_name'];?></option> 
                     <?php endforeach;?>
                 </select>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Setoran Tunai<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="setoran_tunai" id="setoran_tunai" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Tabungan Wajib<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="tabungan_wajib" id="tabungan_wajib" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Tabungan Kelompok<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="tabungan_kelompok" id="tabungan_kelompok" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Total</label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="total" id="total" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Tanggal Setor<span class="required">*</span></label>
               <div class="controls">
               <input type="text" name="date_issued" id="date_issued" tabindex="2" placeholder="dd/mm/yyyy" class="small m-wrap mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" >
                  <!-- <input type="text" name="date_issued" id="date_issued" data-required="1" class="medium m-wrap" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>"/> -->
               </div>
            </div> 
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit SMK</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="smk_id" name="smk_id">
          <input type="hidden" id="trx_smk_id" name="trx_smk_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Sertifikat Modal Koperasi Berhasil Di Edit !
            </div>
          </br>
          <div class="control-group">
               <label class="control-label">No Sertifikat<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="sertifikat_no2" id="sertifikat_no2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status Keanggotaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="status_anggota2" id="status_anggota2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="1">Anggota</option>
                     <option value="0">Non Anggota</option>
                  </select>
               </div>
            </div>
            <div class="control-group" id="r_cif_no2">
             <label class="control-label">CIF No<span class="required">*</span></label>
             <div class="controls">
                <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap"/><input type="hidden" id="branch_code" name="branch_code">
                
                <div id="dialog_rembug2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                   <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                      <h3>Cari CIF NO</h3>
                   </div>
                   <div class="modal-body">
                      <div class="row-fluid">
                         <div class="span12">
                            <h4>Masukan Kata Kunci</h4>
                            <?php
                            if($this->session->userdata('cif_type')==0){
                            ?>
                              <input type="hidden" id="cif_type2" name="cif_type2" value="0">
                              <p id="pcm2">
                              <select id="cm2" class="span12 m-wrap">
                              <option value="">Pilih Rembug</option>
                              <?php foreach($rembugs as $rembug): ?>
                              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                              <?php endforeach; ?>;
                              </select></p>
                            <?php
                            }else if($this->session->userdata('cif_type')==1){
                              echo '<input type="hidden" id="cif_type2" name="cif_type2" value="1">';
                            }else{
                            ?>
                              <p><select name="cif_type2" id="cif_type2" class="span12 m-wrap">
                              <option value="">Pilih Tipe CIF</option>
                              <option value="">All</option>
                              <option value="1">Individu</option>
                              <option value="0">Kelompok</option>
                              </select></p>
                              <p class="hide" id="pcm2">
                              <select id="cm2" class="span12 m-wrap">
                              <option value="">Pilih Rembug</option>
                              <?php foreach($rembugs as $rembug): ?>
                              <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                              <?php endforeach; ?>;
                              </select></p>
                            <?php
                            }
                            ?>
                            <p><input type="text" name="keyword2" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p>
                            <p><select name="result2" id="result2" size="7" class="span12 m-wrap"></select></p>
                         </div>
                      </div>
                   </div>
                   <div class="modal-footer">
                      <button type="button" id="close2" data-dismiss="modal" class="btn">Close</button>
                      <button type="button" id="select2" class="btn blue">Select</button>
                   </div>
                </div>

              <a id="browse_rembug2" class="btn blue" data-toggle="modal" href="#dialog_rembug2">...</a>
             </div>
          </div>
            <div class="control-group">
               <label class="control-label">Nama Pemilik SMK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama2" id="nama2" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="nominal2" id="nominal2" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div> 

            <div class="control-group">
               <label class="control-label">Pembayaran<span class="required">*</span></label>
               <div class="controls">
                 <select name="status_option2" id="status_option2" class="small m-wrap" data-required="1">    
                     <option value="">PILIH</option>
                     <option value="1">Tunai</option>
                     <option value="0">Pinbuk</option>
                 </select>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
               <div class="controls">
                 <select name="account_cash_code2" id="account_cash_code2" class="medium m-wrap" data-required="1">    
                     <option value="">PILIH</option>
                     <?php foreach($kas_petugas as $data): ?>
                     <option value="<?php echo $data['account_cash_code'];?>"><?php echo $data['account_cash_name'];?></option> 
                     <?php endforeach;?>
                 </select>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Setoran Tunai<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="setoran_tunai2" id="setoran_tunai2" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Tabungan Wajib<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="tabungan_wajib2" id="tabungan_wajib2" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Tabungan Kelompok<span class="required">*</span></label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="tabungan_kelompok2" id="tabungan_kelompok2" maxlength="12">
                       <span class="add-on">,00</span>
                    </div>
               </div>
            </div>       
            <div class="control-group">
               <label class="control-label">Total</label>
               <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="small m-wrap mask-money" name="total2" id="total2" maxlength="12">
                       <span class="add-on">,00</span>
                          <!-- <input type="hidden" name="total2_hide" id="total2_hide"> -->
                    </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Setor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="date_issued2" id="date_issued2" tabindex="2" placeholder="dd/mm/yyyy" class="small m-wrap mask_date date-picker" maxlength="10" >
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->


<!-- BEGIN PELEPASAN -->
<div id="pelepasan" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pelepasan Sertifikat Modal Koperasi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_pelepasan" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Pelepasan SMK berhasil !
            </div>
            <br>
            <input type="hidden" name="smk_id3" id="smk_id3"/>
            <div class="control-group">
                       <label class="control-label">No Sertifikat<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="sertifikat_no3" id="sertifikat_no3" readonly="" data-required="1" class="medium m-wrap"/><input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug3" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF NO</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <p><input type="text" name="keyword3" id="keyword3" placeholder="Search..." class="span12 m-wrap"></p>
                                      <p><select name="result3" id="result3" size="7" class="span12 m-wrap"></select></p>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close3" data-dismiss="modal" class="btn">Close</button>
                                <button type="button" id="select3" class="btn blue">Select</button>
                             </div>
                          </div>

                        <a id="browse_rembug3" class="btn blue" data-toggle="modal" href="#dialog_rembug3">...</a>
                       </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Pemilik SMK<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama3" id="nama3" data-required="1" class="medium m-wrap" readonly=""/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nominal3" id="nominal3" data-required="1" readonly="" class="small m-wrap"/>
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Status Keanggotaan<span class="required">*</span></label>
               <div class="controls">
                  <select name="status_anggota3" id="status_anggota3" class="medium m-wrap" readonly="" data-required="1">
                     <option value="">PILIH</option>
                     <option value="1">Anggota</option>
                     <option value="0">Non Anggota</option>
                  </select>
               </div>
            </div>
            <div class="control-group" id="r_cif_no3">
               <label class="control-label">CIF No<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="cif_no3" id="cif_no3" data-required="1" readonly="" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pelepasan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="date_close3" id="date_close3" data-required="1" readonly="" class="medium m-wrap"/>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END PELEPASAN -->




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
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      // $("#date_issued").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      // $("#date_issued2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      // $("#date_close3").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#date_issued").inputmask("d/m/y");
      $("#date_issued2").inputmask("d/m/y");
      $("#date_close3").inputmask("d/m/y");
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'registrasi_smk_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#registrasi_smk_table .group-checkable').live('change',function () {
          var set = jQuery(this).attr("data-set");
          var checked = jQuery(this).is(":checked");
          jQuery(set).each(function () {
              if (checked) {
                  $(this).attr("checked", true);
              } else {
                  $(this).attr("checked", false);
              }
          });
          jQuery.uniform.update(set);
      });

      $("#registrasi_smk_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
        var branch_code = '<?php echo $branch_code; ?>' ;
        //mendapatkan jumlah maksimal
        $.ajax({
          url: site_url+"cif/count_no_sertifikat_by_branch_code",
          type: "POST",
          dataType: "html",
          data: {branch_code:branch_code},
          success: function(response)
          {
            $("#sertifikat_no").val(response);
          }
        })

      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              sertifikat_no: {
                  required: true
              },
              nama: {
                  required: true
              },
              nominal: {
                  required: true
              },
              status_anggota: {
                  required: true
              },
              date_issued: {
                  required: true
              },
              account_cash_code: {
                  required: true
              },
              status_option: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            var nominal = $("#nominal",form_add).val();
            var total   = $("#total",form_add).val();

            if(total%nominal!=0){
              alert("Total Tabungan Harus Kelipatan Nominal SMK Yang Dianjurkan !");
            }else{

              $.ajax({
                type: "POST",
                url: site_url+"cif/add_registrasi_smk",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                  if(response.success==true){
                    success1.show();
                    error1.hide();
                    form1.trigger('reset');
                    form1.children('div').removeClass('success');
                    $("#cancel",form_add).trigger('click')
                    alert('Successfully Saved Data');
                  }else{
                    success1.hide();
                    error1.show();
                  }
                  App.scrollTo(form1, -200);
                },
                error:function(){
                    success1.hide();
                    error1.show();
                }
              });
            }
          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var trx_smk_id = $(this).attr('trx_smk_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {trx_smk_id:trx_smk_id},
          url: site_url+"cif/get_smk_by_smk_id",
          success: function(response)
          {
            $("#form_edit input[name='smk_id']").val(response.smk_id);
            $("#form_edit input[name='trx_smk_id']").val(response.trx_smk_id);
            $("#form_edit input[name='sertifikat_no2']").val(response.sertifikat_no);
            $("#form_edit input[name='nama2']").val(response.nama);
            $("#form_edit input[name='nominal2']").val(response.nominal);
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
            $("#form_edit select[name='status_anggota2']").val(response.status_anggota);             
            $("#form_edit select[name='account_cash_code2']").val(response.account_cash_code);             
  
            var status_anggota = $("#form_edit select[name='status_anggota2']").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no2").hide();
            }
            else
            {
              $("#r_cif_no2").show();
            }

            var tanggal_mulai = response.date_issued;
            var tgl = tanggal_mulai.substring(8,10);
            var bln = tanggal_mulai.substring(5,7);
            var thn = tanggal_mulai.substring(0,4);
            var tgl_mulai = tgl+""+bln+""+thn;  
            $("#form_edit input[name='date_issued2']").val(tgl_mulai);

            var status_option = response.trx_type;  
            if(status_option=='1'){
              $("#tabungan_wajib2").attr("readonly",true);
              $("#tabungan_kelompok2").attr("readonly",true);
              $("#total2").attr("readonly",true);
              $("#account_cash_code2").attr("readonly",true);
              $("#setoran_tunai2").attr("readonly",true);
              $("#tabungan_wajib2").addClass('bg-readonly');
              $("#tabungan_kelompok2").addClass('bg-readonly');
              $("#total2").addClass('bg-readonly');
              $("#account_cash_code2").addClass('bg-readonly');
              $("#setoran_tunai2").addClass('bg-readonly');
            }else{
              $("#account_cash_code2").attr("disabled",true);
              $("#setoran_tunai2").attr("readonly",true);
              $("#tabungan_wajib2").attr("readonly",true);
              $("#tabungan_kelompok2").attr("readonly",true);
              $("#total2").attr("readonly",true);
              $("#tabungan_wajib2").addClass('bg-readonly');
              $("#tabungan_kelompok2").addClass('bg-readonly');
              $("#total2").addClass('bg-readonly');
              $("#account_cash_code2").addClass('bg-readonly');
              $("#setoran_tunai2").addClass('bg-readonly');
            }

            $("#form_edit select[name='status_option2']").val(response.trx_type);
            $("#form_edit input[name='setoran_tunai2']").val(number_format(response.setor_tunai,0,',','.'));
            $("#form_edit input[name='tabungan_wajib2']").val(number_format(response.tabungan_wajib,0,',','.'));
            $("#form_edit input[name='tabungan_kelompok2']").val(number_format(response.tabungan_kelompok,0,',','.'));
            $("#form_edit input[name='total2']").val(number_format(response.total,0,',','.'));;
            // $("#form_edit input[name='total2_hide']").val(response.total);
                    
          }
        })

      });

      //FUNGSI UNTUK MENJUMLAHKAN TOTAL
      $("#tabungan_wajib2,#tabungan_kelompok2",form_edit).live('keyup',function(){

        var tabungan_wajib    = 0;
        var tabungan_kelompok = 0;

          $("#tabungan_wajib2",form_edit).each(function(){
            var tabungan_wajib             = parseFloat(convert_numeric($("#tabungan_wajib2").val()));
            if(isNaN(tabungan_wajib)===true){
              tabungan_wajib = 0;
            }
            var tabungan_kelompok          = parseFloat(convert_numeric($("#tabungan_kelompok2").val())); 
            if(isNaN(tabungan_kelompok)===true){
              tabungan_kelompok = 0;
            }
            var total = tabungan_wajib+tabungan_kelompok;
            if(isNaN(total)===true){
              total = 0;
            }
            $("#total2",form_edit).val(number_format(total,0,',','.'));
            $("#total2",form_edit).attr("readonly",true);
        });
      });

      //FUNGSI UNTUK MENJUMLAHKAN TOTAL
      $("#setoran_tunai2",form_edit).live('keyup',function(){

        var setoran_tunai    = 0;

          $("#setoran_tunai2",form_edit).each(function(){
            var setoran_tunai             = parseFloat(convert_numeric($("#setoran_tunai2").val()));
            if(isNaN(setoran_tunai)===true){
              setoran_tunai = 0;
            }
            $("#total2",form_edit).val(number_format(setoran_tunai,0,',','.'));
            $("#total2",form_edit).attr("readonly",true);
        });
      });

      $("#status_option2").change(function(){
        var status_option = $("#status_option2").val();  
        if(status_option=='1'){
          $("#tabungan_wajib2").val('');
          $("#tabungan_kelompok2").val('');
          $("#tabungan_wajib2").attr("readonly",true);
          $("#tabungan_kelompok2").attr("readonly",true);
          $("#total2").attr("readonly",false);
          $("#account_cash_code2").attr("disabled",false);
          $("#setoran_tunai2").attr("readonly",false);
          $("#tabungan_wajib2").addClass('bg-readonly');
          $("#tabungan_kelompok2").addClass('bg-readonly');
          $("#total2").removeClass('bg-readonly');
          $("#account_cash_code2").removeClass('bg-readonly');
          $("#setoran_tunai2").removeClass('bg-readonly');
        }else if(status_option=='0'){
          $("#account_cash_code2").val('');
          $("#setoran_tunai2").val('');
          $("#account_cash_code2").attr("disabled",true);
          $("#setoran_tunai2").attr("readonly",true);
          $("#tabungan_wajib2").attr("readonly",false);
          $("#tabungan_kelompok2").attr("readonly",false);
          $("#total2").attr("readonly",false);
          $("#tabungan_wajib2").removeClass('bg-readonly');
          $("#tabungan_kelompok2").removeClass('bg-readonly');
          $("#total2").removeClass('bg-readonly');
          $("#account_cash_code2").addClass('bg-readonly');
          $("#setoran_tunai2").addClass('bg-readonly');
        }else{
          $("#account_cash_code2").attr("disabled",true);
          $("#setoran_tunai2").attr("readonly",true);
          $("#tabungan_wajib2").attr("readonly",true);
          $("#tabungan_kelompok2").attr("readonly",true);
          $("#total2").attr("readonly",true);
          $("#tabungan_wajib2").addClass('bg-readonly');
          $("#tabungan_kelompok2").addClass('bg-readonly');
          $("#total2").addClass('bg-readonly');
          $("#account_cash_code2").addClass('bg-readonly');
          $("#setoran_tunai2").addClass('bg-readonly');
          $("#total2").val('');
        }
      });  

      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              sertifikat_no: {
                  required: true
              },
              nama: {
                  required: true
              },
              nominal: {
                  required: true
              },
              status_anggota: {
                  required: true
              },
              date_issued: {
                  required: true
              },
              account_cash_code: {
                  required: true
              },
              status_option: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"cif/edit_registrasi_smk",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Saved Data');
                }else{
                  success1.hide();
                  error1.show();
                }
                App.scrollTo(form1, -200);
              },
              error:function(){
                  success2.hide();
                  error2.show();
              }
            });

          }
      });
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });



      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var trx_smk_code = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          trx_smk_code[$i] = $(this).val();

          $i++;

        });

        if(trx_smk_code.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_registrasi_smk",
              dataType: "json",
              data: {trx_smk_code:trx_smk_code},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      // begin first table
      $('#registrasi_smk_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_registrasi_smk_setup",
          "aoColumns": [
            {"bSearchable": false},
            null,
            null,
            null,
            null,
            null,
            null,
            // { "bSortable": false, "bSearchable": false },
            { "bSortable": false, "bSearchable": false }
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
              }
          ]
      });

//fungsi untuk menampilkan input CIF NO JIKA STATUS ANGGOTA = 1
      $(function(){
  
          $("#r_cif_no").hide();
          
          $("#status_anggota").change(function(){
            var status_anggota = $("#status_anggota").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no").hide();
            }
            else
            {
              $("#r_cif_no").show();
            }
            
          });     
          
      });

      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
          var customer_no = $("#result").val();
          $("#close","#dialog_rembug").trigger('click');
          $("#cif_no").val(customer_no);
            //fungsi untuk mendapatkan value untuk field-field yang diperlukan
            var cif_no = customer_no;
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {cif_no:cif_no},
              url: site_url+"transaction/ajax_get_value_from_cif_no",
              success: function(response)
              {
                $("#nama").val(response.nama.toUpperCase());
              }                 
            });
        });
        $("#result option").live('dblclick',function(){
          $("#select").trigger('click');
        });
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });

        });

        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                $("#result").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      
        $("#keyword").keypress(function(e){

          if(e.which==13){

          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              async: false,
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });
        });

     
      //fungsi untuk menampilkan input CIF NO JIKA STATUS ANGGOTA = 1 pada form edit
      $(function(){
          
          $("#status_anggota2").change(function(){
            var status_anggota = $("#status_anggota2").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no2").hide();
            }
            else
            {
              $("#r_cif_no2").show();
            }
            
          });     
          
      });

      // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

       $("#select2").click(function(){
         result = $("#result2").val();
              var customer_no = $("#result2").val();
              $("#close2","#dialog_rembug2").trigger('click');
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var cif_no = customer_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {cif_no:cif_no},
                      url: site_url+"transaction/ajax_get_value_from_cif_no",
                      success: function(response)
                      {
                        $("#cif_no2").val(response.cif_no);
                        $("#nama").val(response.nama);
                      }                 
                    });
            
        });
        $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });

        $("#cif_type2","#form_edit").change(function(){
          type = $("#cif_type2","#form_edit").val();
          cm_code = $("select#cm2").val();
          if(type=="0"){
            $("p#pcm2").show();
          }else{
            $("p#pcm2").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            });

        });

        $("select#cm2").on('change',function(e){
          type = $("#cif_type2","#form_edit").val();
          cm_code = $(this).val();

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                $("#result2").html(option);
              }
            });

          if(cm_code=="")
          {
            $("#result2").html('');
          }
        });

        $("#keyword2").keypress(function(e){

          if(e.which==13){

          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              async: false,
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            });
            return false;
          }
        });
        });

//PELEPASAN
// BEGIN FORM ADD PELEPASAN VALIDATION
      var form3 = $('#form_pelepasan');
      var error3 = $('.alert-error', form3);
      var success3 = $('.alert-success', form3);

      
      $("#btn_pelepasan").click(function(){
        $("#wrapper-table").hide();
        $("#pelepasan").show();
        form3.trigger('reset');

      });

      form3.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              sertifikat_no3: {
                  required: true
              },
              nama: {
                  required: true
              },
              nominal: {
                  required: true
              },
              status_anggota: {
                  required: true
              },
              date_issued: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success1.hide();
              error1.show();
              App.scrollTo(error1, -200);
          },

          highlight: function (element) { // hightlight error inputs
              $(element)
                  .closest('.help-inline').removeClass('ok'); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"cif/add_pelepasan_smk",
              dataType: "json",
              data: form3.serialize(),
              success: function(response){
                if(response.success==true){
                  success3.show();
                  error3.hide();
                  form3.trigger('reset');
                  form3.children('div').removeClass('success');
                }else{
                  success3.hide();
                  error3.show();
                }
              },
              error:function(){
                  success3.hide();
                  error3.show();
              }
            });

          }
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_pelepasan").click(function(){
        success1.hide();
        error1.hide();
        $("#pelepasan").hide();
        $("#wrapper-table").show();
        dTreload();
      });

//fungsi untuk menampilkan input CIF NO JIKA STATUS ANGGOTA = 1
      $(function(){
  
          $("#r_cif_no3").hide();
          
          $("#status_anggota3").change(function(){
            var status_anggota = $("#status_anggota3").val();  
            if(status_anggota=='0')
            {
              $("#r_cif_no3").hide();
            }
            else
            {
              $("#r_cif_no3").show();
            }
            
          });     
          
      });

      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select3").click(function(){
         result = $("#result3").val();
              var sertifikat_no = $("#result3").val();
              $("#close3","#dialog_rembug3").trigger('click');
              //alert(customer_no);
              $("#sertifikat_no3").val(sertifikat_no);
                    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
                    var sertifikat_no = sertifikat_no;
                    $.ajax({
                      type: "POST",
                      dataType: "json",
                      data: {sertifikat_no:sertifikat_no},
                      url: site_url+"cif/ajax_get_value_from_sertifikat_no",
                      success: function(response)
                      {
                        $("#smk_id3").val(response.smk_id);
                        $("#sertifikat_no3").val(response.sertifikat_no);
                        $("#nama3").val(response.nama);
                        $("#nominal3").val(response.nominal);
                        $("#status_anggota3").val(response.status_anggota);
                        var status_anggota = $("#status_anggota3").val();
                          if(status_anggota=='0')
                          {
                            $("#r_cif_no3").hide();
                          }
                          else
                          {
                            $("#r_cif_no3").show();
                          }

                        $("#cif_no3").val(response.cif_no);
                        var date = '<?php echo $tanggal ?>';
                        $("#date_close3").val(date);
                      }                 
                    });
            
        });
        $("#button-dialog3").click(function(){
          $("#dialog3").dialog('open');
        });

        $("#keyword3").keypress(function(e){

          if(e.which==13){

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_sertifikat_no",
              data: {keyword:$(this).val()},
              async: false,
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                  option += '<option value="'+response[i].sertifikat_no+'">'+response[i].sertifikat_no+' - '+response[i].nama+'</option>';
                }
                // console.log(option);
                $("#result3").html(option);
              }
            });
            return false;
          }
        });
        });

        $("#result3 option").live('dblclick',function(){
          $("#select3").trigger('click');
        });


      //END PELEPASAN

      //PINBUK ATAU TUNAI
      $("#tabungan_wajib").attr("readonly",true);
      $("#tabungan_kelompok").attr("readonly",true);
      $("#total").attr("readonly",true);
      $("#account_cash_code").attr("disabled",true);
      $("#setoran_tunai").attr("readonly",true);

      $("#tabungan_wajib").addClass('bg-readonly');
      $("#tabungan_kelompok").addClass('bg-readonly');
      $("#total").addClass('bg-readonly');
      $("#account_cash_code").addClass('bg-readonly');
      $("#setoran_tunai").addClass('bg-readonly');

      $("#status_option").change(function(){
        var status_option = $("#status_option").val();  
        if(status_option=='1'){
          $("#tabungan_wajib").attr("readonly",true);
          $("#tabungan_kelompok").attr("readonly",true);
          $("#total").attr("readonly",false);
          $("#account_cash_code").attr("disabled",false);
          $("#setoran_tunai").attr("readonly",false);
          $("#tabungan_wajib").addClass('bg-readonly');
          $("#tabungan_kelompok").addClass('bg-readonly');
          $("#total").removeClass('bg-readonly');
          $("#account_cash_code").removeClass('bg-readonly');
          $("#setoran_tunai").removeClass('bg-readonly');
        }else if(status_option=='0'){
          $("#account_cash_code").attr("disabled",true);
          $("#setoran_tunai").attr("readonly",true);
          $("#tabungan_wajib").attr("readonly",false);
          $("#tabungan_kelompok").attr("readonly",false);
          $("#total").attr("readonly",false);
          $("#tabungan_wajib").removeClass('bg-readonly');
          $("#tabungan_kelompok").removeClass('bg-readonly');
          $("#total").removeClass('bg-readonly');
          $("#account_cash_code").addClass('bg-readonly');
          $("#setoran_tunai").addClass('bg-readonly');
        }else{
          $("#account_cash_code").attr("disabled",true);
          $("#setoran_tunai").attr("readonly",true);
          $("#tabungan_wajib").attr("readonly",true);
          $("#tabungan_kelompok").attr("readonly",true);
          $("#total").attr("readonly",true);
          $("#tabungan_wajib").addClass('bg-readonly');
          $("#tabungan_kelompok").addClass('bg-readonly');
          $("#total").addClass('bg-readonly');
          $("#account_cash_code").addClass('bg-readonly');
          $("#setoran_tunai").addClass('bg-readonly');
        }
      });  

      //FUNGSI UNTUK MENJUMLAHKAN TOTAL
      $("#tabungan_wajib,#tabungan_kelompok",form_add).live('keyup',function(){

        var tabungan_wajib    = 0;
        var tabungan_kelompok = 0;

          $("#tabungan_wajib",form_add).each(function(){
            var tabungan_wajib             = parseFloat(convert_numeric($("#tabungan_wajib").val()));
            if(isNaN(tabungan_wajib)===true){
              tabungan_wajib = 0;
            }
            var tabungan_kelompok          = parseFloat(convert_numeric($("#tabungan_kelompok").val())); 
            if(isNaN(tabungan_kelompok)===true){
              tabungan_kelompok = 0;
            }
            var total = tabungan_wajib+tabungan_kelompok;
            if(isNaN(total)===true){
              total = 0;
            }
            $("#total",form_add).val(number_format(total,0,',','.'));
            $("#total",form_add).attr("readonly",true);
        });
      });

      //FUNGSI UNTUK MENJUMLAHKAN TOTAL
      $("#setoran_tunai",form_add).live('keyup',function(){

        var setoran_tunai    = 0;

          $("#setoran_tunai",form_add).each(function(){
            var setoran_tunai             = parseFloat(convert_numeric($("#setoran_tunai").val()));
            if(isNaN(setoran_tunai)===true){
              setoran_tunai = 0;
            }
            $("#total",form_add).val(number_format(setoran_tunai,0,',','.'));
            $("#total",form_add).attr("readonly",true);
        });
      });

      //FUNGSI DETAIL SMK
          $("a#link-detail").live('click',function(){
            var trx_smk_id = $(this).attr('trx_smk_id');
              $.ajax({
                type: "POST",
                url: site_url+"cif/detail_registrasi_smk",
                dataType: "json",
                data: {trx_smk_id:trx_smk_id},
                success: function(response){
                  nomer       = 1;
                  html_nomer  = '';
                  html_nama   = '';
                  html_no     = '';
                  html_print  = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html_nomer += "<p align='center'>"+nomer+++"</p>";
                     html_nama  += "<p>"+response[i].nama+"</p>";
                     html_no    += "<p>"+response[i].sertifikat_no+"</p>";
                     html_print += '<p><a href="'+site_url+"cif/export_smk/"+response[i].smk_id+"/"+response[i].stat+'" target="_blank">Print</a></p>';
                  }
                  $("#modal_no").html(html_nomer);
                  $("#modal_nama").html(html_nama);
                  $("#modal_sertifikat_no").html(html_no);
                  $("#modal_print").html(html_print);
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });
        
      jQuery('#registrasi_smk_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#registrasi_smk_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

