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
      Transaction <small>Registrasi Rekening Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Registrasi Rekening Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekening Pembiayaan</div>
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
      <table class="table table-striped table-bordered table-hover" id="rekening_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_pembiayaan_table .checkboxes" /></th>
               <th width="15%">No. Customer</th>
               <th>Nama Lengkap</th>
               <th>Pembiayaan</th>
               <th width="20%">Nomor Rekening</th>
               <th width="10%">Ket.</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Petugas</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword_fa" id="keyword_fa" placeholder="Search..." class="span12 m-wrap"></p>
            <p><select name="result_fa" id="result_fa" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close_fa" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select_fa" class="btn blue">Select</button>
   </div>
</div>
<div id="dialog_fa_edit" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Petugas</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword_fa_edit" id="keyword_fa_edit" placeholder="Search..." class="span12 m-wrap"></p>
            <p><select name="result_fa_edit" id="result_fa_edit" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close_fa_edit" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select_fa_edit" class="btn blue">Select</button>
   </div>
</div>

<!-- BEGIN ADD  -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Rekening Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal"><!-- 
          <input type="hidden" id="manfaat_asuransi" name="manfaat_asuransi">
          <input type="hidden" id="product_asuransi" name="product_asuransi"> -->
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>
                    <div class="control-group">
                      <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
                      <input type="hidden" id="cif_type_hidden" name="cif_type_hidden">
                       <label class="control-label">No Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <?php foreach ($grace as $data):?>
                          <input type="hidden" id="grace_kelompok" name="grace_kelompok" value="<?php echo $data['grace_period_kelompok'];?>">
                          <?php endforeach?>
                          <input type="text" name="registration_no" id="registration_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          
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
                                      if($this->session->userdata('cif_type')==0){
                                      ?>
                                        <input type="hidden" id="cif_type" name="cif_type" value="0">
                                        <p id="pcm" style="height:32px">
                                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                        <option value="">Pilih Rembug</option>
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
                                      <?php
                                      }else if($this->session->userdata('cif_type')==1){
                                        echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                                      }else{
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
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
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
                       <label class="control-label">No Anggota</label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code" name="branch_code">
                          <input type="hidden" id="cif_id" name="cif_id">
                       </div>
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group" >
                       <label class="control-label">Majelis </label>
                       <div class="controls">
                          <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>

                    <!--           
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>   
                    -->

                    <div class="control-group">
                       <label class="control-label">No KTP</label>
                       <div class="controls">
                          <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 

                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:35px;">Tanggal Lahir &nbsp;&nbsp; </span>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> <span style="line-height:35px;">Tahun</span>
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">No.Telp/HP Pribadi</label>
                       <div class="controls">
                        <input name="no_hp" id="no_hp" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:35px;">No.Telp/HP Pasangan &nbsp;&nbsp;</span>
                        <input type="text" class="medium m-wrap" name="p_no_hp" id="p_no_hp" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    <!--
                    <div class="control-group">
                        <label class="control-label">No.Telp/HP Pribadi</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="no_hp" id="no_hp" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">No.Telp/HP Pasangan</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="p_no_hp" id="p_no_hp" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>  
                     --> 
                    <hr>             
                    <div class="control-group">
                      <label class="control-label">Jenis Pembiayaan <span class="required">*</span></label>
                      <div class="controls">
                        <select class="medium m-wrap" id="jenis_pembiayaan" name="jenis_pembiayaan">  
                          <option value="">PILIH</option>
                          <option value="0">Kelompok</option>
                          <option value="1">Individu</option>
                        </select>
                      </div>
                    </div>
                    <div id="saving" style="display:none;"> 
                    <div class="control-group">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving" name="account_saving" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                          </select>
                       </div>
                    </div>                   
                    </div>                   
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product" name="product" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <div id="error_account"></div>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Akad<span class="required">*</span></label>
                       <div class="controls">
                        <select id="akad" name="akad" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                             <?php foreach($akad as $data):?>
                          <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                        <?php endforeach?>
                          </select>   
                       </div>
                    </div>          

                    <!-- <div class="control-group">
                       <label class="control-label">Periode Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="periode_angsuran" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Harian</option>                    
                            <option value="1">Mingguan</option>                    
                            <option value="2">Bulanan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>          -->
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" value="0"  class=" m-wrap" name="jangka_waktu" id="jangka_waktu" maxlength="3" style="width:30px;"/>
                        <select id="periode_angsuran" name="periode_angsuran" class="small m-wrap" data-required="1">                     
                          <option value="">PILIH</option>                    
                          <option value="0">Harian</option>                    
                          <option value="1" selected="selected">Mingguan</option>                    
                          <option value="2">Bulanan</option>                    
                          <option value="3">Jatuh Tempo</option>
                        </select>
                        <span class="help-inline"></span></div>
                    </div>      
                    <div class="control-group hidden">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka" id="uang_muka" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="nilai_pembiayaan" id="nilai_pembiayaan" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                  
                    <div class="control-group" id="margin_p">
                       <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan" value="0">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>    
                  
                  
                    <div class="control-group" id="nisbah">
                       <label class="control-label">Nisbah Bagi Hasil<span class="required">*</span></label>
                       <div class="controls">
                             <input type="text" class="m-wrap" style="width:30px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5"> %
                         </div>
                    </div>  
                  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_pengajuan" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy" value="<?php echo date('d/m/Y') ?>" />
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                       <div class="controls">
                          <!-- <input type="text" name="tgl_akad" id="mask_date" value="" class="small m-wrap"/> -->
                          <input type="text" name="tgl_akad" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="angsuranke1" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_jtempo" id="mask_date" class="small m-wrap" placeholder="dd/mm/yy"/>
                       </div>
                    </div>
                    <hr>  
                    <div id="j_angsuran">
                    <div class="control-group">
                       <label class="control-label">Jadwal Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="jadwal_angsuran" name="jadwal_angsuran" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="1">Reguler</option>                    
                            <option value="0">Non Reguler</option> 
                          </select>
                       </div> 
                    </div>
                    </div>
                    <div id="reg" style="display:none;">
                      <table class="table table-striped table-bordered table-hover" id="additional_schedule" style="max-width:60% !important">
                         <thead>
                            <tr>
                               <th width="22%" style="text-align:center;">Tanggal (dd/mm/yyyy)</th>
                               <th width="22%" style="text-align:center;">Angsuran Pokok</th>
                               <th width="22%" style="text-align:center;">Angsuran Margin</th>
                               <th width="22%" style="text-align:center;">Angsuran Tabungan</th>
                               <th width="6%" style="text-align:center;">Tambah</th>
                               <th width="6%" style="text-align:center;">Hapus</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" style="" class="m-wrap small mask_date date-picker" placeholder="dd/mm/yyyy" id="angs_tanggal" name="angs_tanggal[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="" value="0" maxlength="12" class="m-wrap small mask-money" id="angs_pokok" name="angs_pokok[]" value="0">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="" value="0" maxlength="12" class="m-wrap small mask-money" id="angs_margin" name="angs_margin[]" value="0">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="" value="0" maxlength="12" class="m-wrap small mask-money" id="angs_tabungan" name="angs_tabungan[]" value="0">
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_add" class="btn green">Tambah</a>
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_delete" class="btn red">Hapus</a>
                              </td>
                            </tr>
                         </tbody>
                         <tfoot>
                           <tr>
                               <td style="vertical-align:middle;text-align:center;font-weight:bold;font-size:13px;">Total Angsuran</td>
                               <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" value="0" id="total_angs_pokok" name="total_angs_pokok[]" readonly="" style="background-color:#eee;">
                               </td>
                               <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" value="0" id="total_angs_margin" name="total_angs_margin[]" readonly="" style="background-color:#eee;">
                               </td>
                               <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" value="0" id="total_angs_tabungan" name="total_angs_tabungan[]" readonly="" style="background-color:#eee;">
                               </td>
                               <td style="text-align:center;" colspan="2"></td>
                            </tr>
                         </tfoot>
                      </table>

                    </div>
                    <div class="control-group non_reg">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;" name="angsuran_pokok" id="angsuran_pokok" maxlength="12" readonly>
                             <span class="add-on">,00</span>
                             </div>
                           </div>
                         </div>    
                    <div class="control-group non_reg">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;" name="angsuran_margin" id="angsuran_margin" maxlength="12" readonly>
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group control-group2 non_reg">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="angsuran_tabungan" id="angsuran_tabungan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>
                    <div class="hidden">
                      <div class="control-group non_reg" id="div_tabungan_wajib">
                         <label class="control-label">Tabungan Wajib</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_wajib" id="tabungan_wajib" maxlength="12" value="0">
                               <span class="add-on">,00</span>
                             </div>
                        </div> 
                      </div>        
                      <div class="control-group non_reg" id="div_tabungan_kelompok">
                         <label class="control-label">Tabungan Kelompok</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_kelompok" id="tabungan_kelompok" maxlength="12" value="0">
                               <span class="add-on">,00</span>
                             </div>
                        </div> 
                      </div>
                    </div>
                      <div class="control-group non_reg">
                         <label class="control-label">Total Angsuran</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  name="total_angsuran" id="total_angsuran" maxlength="12" readonly="" value="0">
                               <span class="add-on">,00</span>
                             </div>
                           </div>
                      </div> 
                    <hr>     
                       
                    <div class="control-group hide">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="hidden" name="dana_kebajikan" id="dana_kebajikan" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_administrasi" id="biaya_administrasi" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">DTK 5%</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dtk" id="dtk" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hidden">
                       <label class="control-label">Dana Kegiatan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="cadangan_resiko" id="cadangan_resiko" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div> 
                         </div>
                    </div>  

                    <div class="control-group hide">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_notaris" id="biaya_notaris" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <hr />
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jiwa" id="p_asuransi_jiwa" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                           <label class="checkbox">
                           	<input name="flag_double_premi" type="checkbox" id="flag_double_premi" value="1" /> Dobel Premi
                           </label>
                      </div>
                    </div>      
                    <div class="control-group" id="anggota_asuransi">
                       <label class="control-label">Nama Peserta Asuransi</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="peserta_asuransi" id="peserta_asuransi">
                       </div>
                    </div>      
                    <div class="control-group" id="anggota_asuransi">
                       <label class="control-label">No. KTP Peserta</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="ktp_asuransi" id="ktp_asuransi">
                       </div>
                    </div>      
                    <div class="control-group" id="anggota_asuransi">
                       <label class="control-label">Tanggal Lahir Peserta</label>
                       <div class="controls">
                         <input type="text" class="small m-wrap" name="tanggal_peserta_asuransi" id="mask_date" placeholder="dd/mm/yy">
                       </div>
                    </div>      
                    <div class="control-group" id="anggota_asuransi">
                       <label class="control-label">Hubungan Peserta</label>
                       <div class="controls">
                          <select id="hubungan_peserta_asuransi" name="hubungan_peserta_asuransi" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <option value="1">Suami</option>
                            <option value="2">Orang Tua</option>
                            <option value="3">Anak</option>
                            <option value="9">Lainnya</option>
                          </select>
                       </div>
                    </div>
                    <hr />
                    <div class="control-group hidden">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jaminan" id="p_asuransi_jaminan" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div id="id_jaminan" style="display:none;"> 
                    <hr>    
                    <div class="control-group">
                       <label class="control-label">Jaminan </label>
                       <div class="controls">
                          <select id="jaminan" name="jaminan" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <?php foreach ($jaminan as $data):?>
                            <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Keterangan Jaminan </label>
                       <div class="controls">
                          <textarea class="medium m-wrap" name="keterangan_jaminan" id="keterangan_jaminan"></textarea>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Taksasi </label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" style="width:120px;" name="nominal_taksasi" id="nominal_taksasi" value="0">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>
                    </div> 
                    <hr class="hidden">     
                    <div class="control-group">
                       <label class="control-label">Sumber Dana <span class="required">*</span></label>
                       <div class="controls">
                          <select id="sumber_dana_pembiayaan" name="sumber_dana_pembiayaan" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <option value="0">Sendiri</option>
                            <option value="1">Kreditur</option>
                          </select>
                       </div>
                    </div>   
                    <!-- SENDIRI --> 
	                  <div id="sendiri">
	                    <div class="control-group">
	                       <label class="control-label">Dana Sendiri</label>
	                       <div class="controls">
	                           <div class="input-prepend input-append">
	                             <span class="add-on">Rp</span>
	                             <input type="text" class="m-wrap mask-money" readonly="" style="background-color:#eee;width:120px;width:120px;" name="dana_sendiri" id="dana_sendiri" maxlength="12">
	                             <span class="add-on">,00</span>
	                           </div>
	                         </div>
	                    </div> 
	                  </div>  
	                  <!-- SENDIRI CAMPURAN -->
	                  <div id="sendiri_campuran">
	                    <div class="control-group">
	                       <label class="control-label">Dana Sendiri</label>
	                       <div class="controls">
	                           <div class="input-prepend input-append">
	                             <span class="add-on">Rp</span>
	                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri_campuran" id="dana_sendiri_campuran" maxlength="12">
	                             <span class="add-on">,00</span>
	                           </div>
	                         </div>
	                    </div> 
	                  </div>
	                  <!-- KREDITUR -->
                  	<div id="kreditur"> 
	                    <div class="control-group">
	                      <label class="control-label">Dana Kreditur</label>
	                      <div class="controls">
	                        <div class="input-prepend input-append">
	                          <span class="add-on">Rp</span>
	                          <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
	                          <span class="add-on">,00</span>
	                        </div>
	                      </div>
	                    </div> 
	                    <div class="control-group">
	                      <label class="control-label">Kreditur</label>
	                      <div class="controls">
	                        <select id="kreditur_code1" name="kreditur_code1">
	                          <option value="">PILIH</option>
	                          <?php foreach($kreditur as $lembaga): ?>
	                          <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
	                          <?php endforeach; ?>
	                        </select>
	                      </div>
	                    </div> 
                      <div class="control-group">
                        <label class="control-label">Ujroh Kreditur</label>
                        <div class="controls">
                        <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> <span style="line-height:35px;">% Keuntungan</span>
                        &nbsp;
                        <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> <span style="line-height:35px;">/ Angsuran</span>
                        <span class="help-inline"></span></div>
                      </div>    
                      <div class="control-group">
                        <label class="control-label">Pembayaran Kreditur</label>
                        <div class="controls">
                          <select id="pembayaran_kreditur" name="pembayaran_kreditur" class="medium m-wrap">                     
                            <option value="">PILIH</option>                     
                            <option value="0">Sesuai Angsuran</option>                     
                            <option value="1">Sekaligus</option>
                          </select>
                        </div>
                    </div>    
                  </div>
                  <!-- KREDITUR CAMPURAN -->
                  <div id="kreditur_campuran"> 
                    <div class="control-group">
                      <label class="control-label">Dana Kreditur</label>
                      <div class="controls">
                        <div class="input-prepend input-append">
                          <span class="add-on">Rp</span>
                          <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur_campuran" id="dana_kreditur" maxlength="12">
                          <span class="add-on">,00</span>
                        </div>
                      </div>
                    </div> 
                    <div class="control-group">
                      <label class="control-label">Kreditur</label>
                      <div class="controls">
                        <select id="kreditur_code2" name="kreditur_code2">
                          <option value="">PILIH</option>
                          <?php foreach($kreditur as $lembaga): ?>
                          <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                    </div> 
                    <div class="control-group">
                      <label class="control-label">Ujroh Kreditur</label>
                      <div class="controls">
                      	<input type="text" class=" m-wrap" name="keuntungan_campuran" id="keuntungan" style="width:30px;" /> <span style="line-height:35px;">% Keuntungan</span>
                        &nbsp;
                        <input type="text" class=" m-wrap" name="angsuran_campuran" id="angsuran" style="width:30px;" /> <span style="line-height:35px;">/ Angsuran</span>
                        <span class="help-inline"></span>
                      </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Pembayaran Kreditur</label>
                       <div class="controls">
                          <select id="pembayaran_kreditur2" name="pembayaran_kreditur2" class="medium m-wrap">                     
                            <option value="">PILIH</option>                     
                            <option value="0">Sesuai Angsuran</option>                     
                            <option value="1">Sekaligus</option>
                          </select>
                       </div>
                    </div>    
                  </div>
                    <hr>  
                    <div class="control-group hidden">
                       <label class="control-label">Program  Khusus <span class="required">*</span></label>
                       <div class="controls">
                          <select id="program_khusus" name="program_khusus" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Ya</option>                    
                            <option value="1" selected="selected">Tidak</option>
                          </select>
                       </div>
                    </div> 
                    <div id="program">  
                    <div class="control-group">
                       <label class="control-label">Jenis Program</label>
                       <div class="controls">
                          <select id="jenis_program" name="jenis_program" class="medium m-wrap">                     
                            <option value="">PILIH</option> 
                            <?php foreach($jenis_program as $data): ?>
                              <option value="<?php echo $data['program_code'];?>"><?php echo $data['program_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektor_ekonomi" name="sektor_ekonomi" class="medium m-wrap">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Peruntukan</label>
                       <div class="controls">
                        <select id="peruntukan_pembiayaan" name="peruntukan_pembiayaan" class="medium m-wrap">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
                       </div>
                    </div>
                    <div class="control-group hidden">
                       <label class="control-label">Pengguna Dana</label>
                       <div class="controls">
                        <select id="pengguna_dana" name="pengguna_dana" class="medium m-wrap">                     
                              <?php foreach ($pengguna_data as $datas):?>
                              <option value="<?php echo $datas['code_value'];?>"><?php echo $datas['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" class="m-wrap" id="pydke" readonly="" style="width:50px;background-color:#eee;">
                       </div>
                    </div> 
                    <div id="fa_petugas">
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                        <input type="text" class="medium m-wrap" name="fa" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;background-color:#f5f5f5;" readonly="readonly">
                        <input type="hidden" name="fa_code" value="">
                        <a href="#dialog_fa" data-toggle="modal" class="btn blue" id="browse_fa">...</a>
                       </div>
                    </div>
                    </div>
                    <div id="m_wakalah">
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah?</label>
                       <div class="controls">
                        <!--
                        <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap">                     
                          <option value="">Pilih</option>
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                        -->
                        <input name="flag_wakalah" type="hidden" id="flag_wakalah" />
                       </div>
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
<!-- END ADD  -->




<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Data Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id2" name="account_financing_reg_id2">
          <input type="hidden" id="cif_type_hidden2" name="cif_type_hidden2">
          <input type="hidden" id="account_financing_id" name="account_financing_id">
          <input type="hidden" id="manfaat_asuransi" name="manfaat_asuransi">
          <input type="hidden" id="product_asuransi" name="product_asuransi">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Account Financing Successful!
            </div>
          </br>      
                    <?php foreach ($grace as $data):?>
                    <input type="hidden" id="grace_kelompok" name="grace_kelompok" value="<?php echo $data['grace_period_kelompok'];?>">
                    <?php endforeach?>
                   <div class="control-group">
                       <label class="control-label">No Pengajuan</label>
                       <div class="controls">
                          <input type="text" name="registration_no2" id="registration_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">No Anggota</label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code2" name="branch_code2">
                          <input type="hidden" id="cif_id" name="cif_id">
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <div class="control-group" >
                       <label class="control-label">Majelis </label>
                       <div class="controls">
                          <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">No KTP </label>
                       <div class="controls">
                          <input type="text" name="no_ktp" id="no_ktp" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:35px;">Tanggal Lahir &nbsp;&nbsp;</span>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> <span style="line-height:35px;">Tahun</span>
                        <span class="help-inline"></span>
                      </div>
                    </div> 

                    <div class="control-group">
                       <label class="control-label">No.Telp/HP Pribadi</label>
                       <div class="controls">
                        <input name="no_hp" id="no_hp" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:35px;">No.Telp/HP Pasangan &nbsp;&nbsp;</span>
                        <input type="text" class=" medium m-wrap" name="p_no_hp" id="p_no_hp" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>
                      </div>
                    </div> 
                    <!--
                    <div class="control-group">
                        <label class="control-label">No.Telp/HP Pribadi</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="no_hp" id="no_hp" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">No.Telp/HP Pasangan</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="p_no_hp" id="p_no_hp" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>    
                    -->
                    <hr>                
                    <div class="control-group">
                      <label class="control-label">Jenis Pembiayaan <span class="required">*</span></label>
                      <div class="controls">
                        <select class="m-wrap medium" id="jenis_pembiayaan" name="jenis_pembiayaan">  
                          <option value="">PILIH</option>
                          <option value="0">Kelompok</option>
                          <option value="1">Individu</option>
                        </select>
                      </div>
                    </div>
                    <div id="saving2" style="display:none;"> 
                    <div class="control-group">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving2" name="account_saving" class="medium m-wrap">                     
                          </select>
                       </div>
                    </div>                   
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk<span class="required">*</span></label>
                       <div class="controls">
                          <select id="product2" name="product" class="medium m-wrap">       
                          </select>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Akad<span class="required">*</span></label>
                       <div class="controls">
                          <select id="akad2" name="akad" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <?php foreach($akad as $data): ?>
                              <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>          
                    <!-- <div class="control-group">
                       <label class="control-label">Periode Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="periode_angsuran2" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Harian</option>                    
                            <option value="1">Mingguan</option>                    
                            <option value="2">Bulanan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div> -->         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" value="0" class=" m-wrap" name="jangka_waktu" id="jangka_waktu2" maxlength="3" style="width:30px;"/>
                        <select id="periode_angsuran2" name="periode_angsuran" class="medium m-wrap" data-required="1">                     
                          <option value="">PILIH</option>                    
                          <option value="0">Harian</option>                    
                          <option value="1" selected="selected">Mingguan</option>                    
                          <option value="2">Bulanan</option>                    
                          <option value="3">Jatuh Tempo</option>
                        </select>
                        <span class="help-inline"></span></div>
                    </div>      
                    <div class="control-group hidden">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="uang_muka" id="uang_muka2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="nilai_pembiayaan" id="nilai_pembiayaan2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>    
                  
                    <div class="control-group" id="margin_p2">
                       <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="margin_pembiayaan" id="margin_pembiayaan2">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>    
                  
                  
                    <div class="control-group" id="nisbah2">
                       <label class="control-label">Nisbah Bagi Hasil<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" style="width:60px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>  
                  
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_pengajuan_edit" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi_edit" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Akad<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_akad_edit" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Tanggal Angsuran Ke-1<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="angsuranke1_edit" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_jtempo_edit" id="mask_date" class="small m-wrap"/>
                       </div>
                    </div>
                    <hr>
                    <div id="j_angsuran2">
                    <div class="control-group">
                       <label class="control-label">Jadwal Angsuran<span class="required">*</span></label>
                       <div class="controls">
                          <select id="jadwal_angsuran2" name="jadwal_angsuran" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="1">Reguler</option>                    
                            <option value="0">Non Reguler</option> 
                          </select>
                       </div> 
                    </div>
                    </div>
                    <div id="reg2" style="display:none;">
                      <table class="table table-striped table-bordered table-hover" id="additional_schedule" style="max-width:60% !important">
                         <thead>
                            <tr>
                               <th width="22%" style="text-align:center;">Tanggal (dd/mm/yyyy)</th>
                               <th width="22%" style="text-align:center;">Angsuran Pokok</th>
                               <th width="22%" style="text-align:center;">Angsuran Margin</th>
                               <th width="22%" style="text-align:center;">Angsuran Tabungan</th>
                               <th width="6%" style="text-align:center;">Tambah</th>
                               <th width="6%" style="text-align:center;">Hapus</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" class="m-wrap mask_date date-picker small" id="angs_tanggal" name="angs_tanggal[]" placeholder="dd/mm/yyyy">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_pokok" name="angs_pokok[]" value="0">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_margin" name="angs_margin[]" value="0">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_tabungan" name="angs_tabungan[]" value="0">
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_add" class="btn green">Tambah</a>
                              </td>
                              <td style="vertical-align:middle;text-align:center;">
                                <a href="javascript:void(0);" id="angs_delete" class="btn red">Hapus</a>
                              </td>
                            </tr>
                         </tbody>
                         <tfoot>
                            <tr>
                               <td style="vertical-align:middle;text-align:center;font-weight:bold;font-size:13px;">Total Angsuran</td>
                               <td style="text-align:center;">
                                <input type="text"  style="background-color:#eee;" maxlength="12" class="m-wrap small mask-money" id="total_angs_pokok" name="total_angs_pokok[]" value="0">
                               </td>
                               <td style="text-align:center;">
                                <input type="text"  style="background-color:#eee;" maxlength="12" class="m-wrap small mask-money" id="total_angs_margin" name="total_angs_margin[]" value="0">
                               </td>
                               <td style="text-align:center;">
                                <input type="text"  style="background-color:#eee;" maxlength="12" class="m-wrap small mask-money" id="total_angs_tabungan" name="total_angs_tabungan[]" value="0">
                               </td>
                               <td style="text-align:center;" colspan="2"></td>
                            </tr>
                         </tfoot>
                      </table>
                    </div>
                    <div class="control-group non_reg2">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="angsuran_pokok" id="angsuran_pokok2" maxlength="12" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group non_reg2">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="angsuran_margin" id="angsuran_margin2" maxlength="12" readonly="">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group control-group2 non_reg2">
                       <label class="control-label">Cadangan Tabungan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="angsuran_tabungan" id="angsuran_tabungan2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="hidden">
                      <div class="control-group non_reg2" id="div_tabungan_wajib2">
                         <label class="control-label">Tabungan Wajib</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_wajib" id="tabungan_wajib2" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                        </div> 
                      </div>
                      <div class="control-group non_reg2" id="div_tabungan_kelompok2">
                         <label class="control-label">Tabungan Kelompok</label>
                         <div class="controls">
                             <div class="input-prepend input-append">
                               <span class="add-on">Rp</span>
                               <input type="text" class="m-wrap mask-money" style="width:120px;" name="tabungan_kelompok" id="tabungan_kelompok2" maxlength="12">
                               <span class="add-on">,00</span>
                             </div>
                        </div> 
                      </div>
                    </div>
                    <div class="control-group non_reg2">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money"  style="background-color:#eee;width:120px;"  name="total_angsuran" readonly="" id="total_angsuran2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    <hr>     
                         
                    <div class="control-group hide">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="hidden" name="dana_kebajikan" id="dana_kebajikan">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_administrasi" id="biaya_administrasi" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">DTK 5%</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dtk" id="dtk" maxlength="12" value="0">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div class="control-group hidden">
                       <label class="control-label">Dana Kegiatan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="cadangan_resiko" id="cadangan_resiko" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>

                    <div class="control-group hide">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="biaya_notaris" id="biaya_notaris" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <hr />
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jiwa</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jiwa" id="p_asuransi_jiwa" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                           <label class="checkbox">
                           	<input name="flag_double_premi" type="checkbox" id="flag_double_premi" value="1" /> Dobel Premi
                           </label>
                         </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Nama Peserta Asuransi</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="peserta_asuransi" id="peserta_asuransi">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">No. KTP Peserta</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="ktp_asuransi" id="ktp_asuransi">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Tanggal Lahir Peserta</label>
                       <div class="controls">
                         <input type="text" class="small m-wrap" name="tanggal_peserta_asuransi" id="mask_date" placeholder="dd/mm/yy">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Hubungan Peserta</label>
                       <div class="controls">
                          <select id="hubungan_peserta_asuransi" name="hubungan_peserta_asuransi" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <option value="1">Suami</option>
                            <option value="2">Orang Tua</option>
                            <option value="3">Anak</option>
                            <option value="9">Lainnya</option>
                          </select>
                       </div>
                    </div>
                    <hr />
                    <div class="control-group hidden">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="p_asuransi_jaminan" id="p_asuransi_jaminan" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div id="id_jaminan"> 
                    <hr>    
                    <div class="control-group">
                       <label class="control-label">Jaminan </label>
                       <div class="controls">
                          <select id="jaminan2" name="jaminan" class="medium m-wrap">                     
                            <option value="">PILIH</option>
                            <?php foreach ($jaminan as $data):?>
                            <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Keterangan Jaminan </label>
                       <div class="controls">
                          <textarea class="medium m-wrap" name="keterangan_jaminan" id="keterangan_jaminan2"></textarea>
                       </div>
                    </div>    
                    </div> 
                    <hr class="hidden">
                    <div class="control-group">
                       <label class="control-label">Sumber Dana<span class="required">*</span></label>
                       <div class="controls">
                          <select id="sumber_dana_pembiayaan2" name="sumber_dana_pembiayaan" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <option value="0">Sendiri</option>
                            <option value="1">Kreditur</option>
                          </select>
                       </div>
                    </div>    
                    <!-- SENDIRI -->
                    <div id="sendiri2">
                    <div class="control-group">
                       <label class="control-label">Dana Sendiri</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" readonly=""  style="background-color:#eee;width:120px;width:120px;" name="dana_sendiri" id="dana_sendiri" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                  </div> 
                  <!-- SENDIRI CAMPURAN -->
                    <div id="sendiri_campuran2">
                    <div class="control-group">
                       <label class="control-label">Dana Sendiri</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_sendiri_campuran" id="dana_sendiri_campuran" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                  </div>
                  <!-- KREDITUR -->
                  <div id="kreditur2">
                    <div class="control-group">
                       <label class="control-label">Dana Kreditur</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur" id="dana_kreditur" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Kreditur</label>
                       <div class="controls">
                             <select id="kreditur_code21" name="kreditur_code21">
                              <option value="">PILIH</option>
                              <?php foreach($kreditur as $lembaga): ?>
                               <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                              <?php endforeach; ?>
                             </select>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Ujroh Kreditur</label>
                       <div class="controls">
                        <input type="text" class=" m-wrap" name="keuntungan" id="keuntungan" style="width:30px;" /> <span style="line-height:35px;">% Keuntungan</span>
                        &nbsp;
                        <input type="text" class=" m-wrap" name="angsuran" id="angsuran" style="width:30px;" /> <span style="line-height:35px;">/ Angsuran</span>
                        <span class="help-inline"></span></div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Pembayaran Kreditur</label>
                       <div class="controls">
                          <select id="pembayaran_kreditur" name="pembayaran_kreditur" class="medium m-wrap">                     
                            <option value="">PILIH</option>                     
                            <option value="0">Sesuai Angsuran</option>                     
                            <option value="1">Sekaligus</option>
                          </select>
                       </div>
                    </div>    
                  </div>
                  <div id="kreditur2_campuran">
                    <div class="control-group">
                       <label class="control-label">Dana Kreditur</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="dana_kreditur_campuran" id="dana_kreditur" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Kreditur</label>
                       <div class="controls">
                             <select id="kreditur_code22" name="kreditur_code22">
                              <option value="">PILIH</option>
                              <?php foreach($kreditur as $lembaga): ?>
                               <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                              <?php endforeach; ?>
                             </select>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Ujroh Kreditur</label>
                       <div class="controls">
                        <input type="text" class=" m-wrap" name="keuntungan_campuran" id="keuntungan" style="width:30px;" /> <span style="line-height:35px;">% Keuntungan</span>
                        &nbsp;
                        <input type="text" class=" m-wrap" name="angsuran_campuran" id="angsuran" style="width:30px;" /> <span style="line-height:35px;">/ Angsuran</span>
                        <span class="help-inline"></span></div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Pembayaran Kreditur</label>
                       <div class="controls">
                          <select id="pembayaran_kreditur2" name="pembayaran_kreditur2" class="medium m-wrap">                     
                            <option value="">PILIH</option>                     
                            <option value="0">Sesuai Angsuran</option>                     
                            <option value="1">Sekaligus</option>
                          </select>
                       </div>
                    </div>    
                  </div>
                    <hr>  
                    <div class="control-group hidden">
                       <label class="control-label">Program  Khusus<span class="required">*</span></label>
                       <div class="controls">
                          <select id="program_khusus2" name="program_khusus" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Ya</option>                    
                            <option value="1">Tidak</option>
                          </select>
                       </div>
                    </div> 
                    <div id="program2">  
                    <div class="control-group">
                       <label class="control-label">Jenis Program</label>
                       <div class="controls">
                          <select id="jenis_program" name="jenis_program" class="medium m-wrap">                     
                            <option value="">PILIH</option> 
                            <?php foreach($jenis_program as $data): ?>
                              <option value="<?php echo $data['program_code'];?>"><?php echo $data['program_name'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Sektor Ekonomi</label>
                       <div class="controls">
                        <select id="sektor_ekonomi" name="sektor_ekonomi" class="medium m-wrap">                     
                              <?php foreach ($sektor as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Peruntukan</label>
                       <div class="controls">
                        <select id="peruntukan_pembiayaan" name="peruntukan_pembiayaan" class="medium m-wrap">                     
                              <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
                       </div>
                    </div> 
                    <div class="control-group hidden">
                       <label class="control-label">Pengguna Dana</label>
                       <div class="controls">
                        <select id="pengguna_dana" name="pengguna_dana" class="medium m-wrap">                     
                              <?php foreach ($pengguna_data as $datas):?>
                              <option value="<?php echo $datas['code_value'];?>"><?php echo $datas['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                        <input type="text" class="m-wrap" id="pydke" readonly="" style="width:50px;background-color:#eee;">
                       </div>
                    </div>
                    <div id="fa_petugas2"> 
                    <div class="control-group">
                       <label class="control-label">Petugas</label>
                       <div class="controls">
                        <input type="text" class="medium m-wrap" name="fa" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;background-color:#f5f5f5;" readonly="readonly">
                        <input type="hidden" name="fa_code" value="">
                        <a href="#dialog_fa_edit" data-toggle="modal" class="btn blue" id="browse_fa_edit">...</a>
                       </div>
                    </div>
                    </div>
                    <div id="m_wakalah2">
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah?</label>
                       <div class="controls">
                        <!--
                        <select id="flag_wakalah" name="flag_wakalah" class="medium m-wrap">                     
                          <option value="">Pilih</option>
                          <option value="1">Ya</option>
                          <option value="0">Tidak</option>
                        </select>
                        -->
                        <input name="flag_wakalah" type="hidden" id="flag_wakalah" />
                       </div>
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
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

  var form1 = $('#form_add');
  var error1 = $('.alert-error', form1);
  var success1 = $('.alert-success', form1);

  var form2 = $('#form_edit');
  var error2 = $('.alert-error', form2);
  var success2 = $('.alert-success', form2);
  
  var anggota_asuransi = $('div#anggota_asuransi');
  var e_anggota_asuransi = $('div#e_anggota_asuransi');

  $("#fa_petugas").hide();
  $("#m_wakalah").hide();
  $("#m_wakalah2").hide();
  $("#program").hide();
  $("#nisbah").hide();
  $("#margin_p").hide();
  $("#sendiri").hide();
  $("#kreditur").hide();
  $("#kreditur_campuran").hide();
  $("#sendiri_campuran").hide();
  $(".non_reg").hide();
  anggota_asuransi.hide();
  e_anggota_asuransi.hide();

  /*
  | EVENT : FOR ANGSURAN YANG DI COSTUM JADWALNYA
  */
  $("a#angs_add").live('click',function(){
    html = ' \
      <tr> \
        <td style="text-align:center;"> \
          <input type="text" style="width:190px;" class="m-wrap small mask mask_date date-picker" placeholder="dd/mm/yyyy" id="angs_tanggal" name="angs_tanggal[]"> \
        </td> \
        <td style="text-align:center;"> \
          <input type="text" style="width:190px;" maxlength="12" class="mask-money small m-wrap" id="angs_pokok" name="angs_pokok[]" value="0"> \
        </td> \
        <td style="text-align:center;"> \
          <input type="text" style="width:190px;" maxlength="12" class="mask-money small m-wrap" id="angs_margin" name="angs_margin[]" value="0"> \
        </td> \
        <td style="text-align:center;"> \
          <input type="text" style="width:190px;" maxlength="12" class="mask-money small m-wrap" id="angs_tabungan" name="angs_tabungan[]" value="0"> \
        </td> \
        <td style="vertical-align:middle;text-align:center;"> \
          <a href="javascript:void(0);" id="angs_add" class="btn green">Tambah</a> \
        </td> \
        <td style="vertical-align:middle;text-align:center;"> \
          <a href="javascript:void(0);" id="angs_delete" class="btn red">Hapus</a> \
        </td> \
      </tr> \
    ';
    $(this).closest('tr').after(html);
  });

  $("a#angs_delete",form1).live('click',function(){
    if($("#additional_schedule tbody tr",form1).length==1){
      alert("baris ini tidak boleh di hapus");
    }else{
      $(this).closest('tr').remove();
    }
  });
  
  $('#flag_double_premi', form1).click(function(){
	  var f_cek = $(this).is(':checked');
	  
	  if(f_cek){
		  anggota_asuransi.fadeIn();
	  } else {
		  anggota_asuransi.fadeOut();
	  }
  });

  $("a#angs_delete",form2).live('click',function(){
    if($("#additional_schedule tbody tr",form2).length==1){
      alert("baris ini tidak boleh di hapus");
    }else{
      $(this).closest('tr').remove();
    }
  });

  $('#flag_double_premi', form2).click(function(){
	  var e_f_cek = $(this).is(':checked');
	  
	  if(e_f_cek){
		  e_anggota_asuransi.fadeIn();
	  } else {
		  e_anggota_asuransi.fadeOut();
	  }
  });

  // fungsi untuk reload data table
  // di dalam fungsi ini ada variable tbl_id
  // gantilah value dari tbl_id ini sesuai dengan element nya
  var dTreload = function()
  {
    var tbl_id = 'rekening_pembiayaan_table';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  // fungsi untuk check all
  jQuery('#rekening_pembiayaan_table .group-checkable').live('change',function () {
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

  $("#rekening_pembiayaan_table .checkboxes").livequery(function(){
    $(this).uniform();
  });

  // begin first table
  $('#rekening_pembiayaan_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_rekening_pembiayaan_setup",
      "aoColumns": [
        null,
        null,
        null,
        null,
		null,
        { "bSortable": false }
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

  jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

  // fungsi untuk delete records
  $("#btn_delete").click(function(){
    var account_financing_no = [];
    var $i = 0;
    $("input#checkbox:checked").each(function(){
      account_financing_no[$i] = $(this).val();
      $i++;
    });
    $("input#checkbox:checked").each(function(){
      no_rek_pembiayaan = $(this).val();
    });
    if(account_financing_no.length==0){
      alert("Please select some row to delete !");
    }else{
      $.ajax({
        type: "POST",
        url: site_url+"transaction/get_status_rekening_from_account_financing",
        dataType: "json",
        async: false,
        data: {account_financing_no:no_rek_pembiayaan},
        success: function(response){
          if(response.status_rekening!=0){
            alert("Status Rekening Sudah Aktif !");
            dTreload();
          }else{
            var conf = confirm('Are you sure to delete this rows ?');
            if(conf){
              $.ajax({
                type: "POST",
                url: site_url+"transaction/delete_rekening_pembiayaan",
                dataType: "json",
                data: {account_financing_no:account_financing_no},
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
        },
        error: function(){
          alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
        }
      }) 
    }
  });

  /*
  | Event : kembali ke tampilan data table (EDIT FORM)
  */
  $("#cancel","#form_edit").click(function(){
    $("#edit").hide();
    $("#wrapper-table").show();
    dTreload();
    success2.hide();
    error2.hide();
  });

  /*
  |-------------------------------------------------------------------------------
  | BEGIN : Event For Add Form
  |-------------------------------------------------------------------------------
  */

  /*
  | CALCULATE TOTAL ANGSURAN POKOK NON REGULER
  | CALCULATE TOTAL ANGSURAN MARGIN NON REGULER
  | CALCULATE TOTAL ANGSURAN TABUNGAN NON REGULER
  */

  $("#additional_schedule input#angs_pokok",form1).live('keyup',function(e){
    var angs_pokok=0;
    $("#additional_schedule input#angs_pokok",form1).each(function(){
      angs_pokok+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_pokok",form1).val(number_format(angs_pokok,0,',','.'));
  });

  $("#additional_schedule input#angs_margin",form1).live('keyup',function(e){
    var angs_margin=0;
    $("#additional_schedule input#angs_margin",form1).each(function(){
      angs_margin+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_margin",form1).val(number_format(angs_margin,0,',','.'));
  });

  $("#additional_schedule input#angs_tabungan",form1).live('keyup',function(e){
    var angs_tabungan=0;
    $("#additional_schedule input#angs_tabungan",form1).each(function(){
      angs_tabungan+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_tabungan",form1).val(number_format(angs_tabungan,0,',','.'));
  });

  /*
  | Event : Kreditur
  */
  $("#kreditur_code1,#kreditur_code2","#form_add").change(function(){
    if($(this).val()!=""){
      $.ajax({
        url: site_url+"rekening_nasabah/get_program_khusus",
        type: "POST",
        dataType:"json",
        data: {
          program_owner_code:$(this).val()
        },
        success: function(response){
          html ='<option value="">PILIH</option>';
          for(i in response){
            html += '<option value="'+response[i].program_code+'">'+response[i].program_name+'</option>';
          }
          $("#jenis_program","#form_add").html(html);
        }
      })
    }
  });

  $("#periode_angsuran,#jangka_waktu","#form_add").change(function(){
    $("input[name='tgl_akad']").trigger('change');
  })

  $("#btn_add").click(function(){
    $("#wrapper-table").hide();
    $("#add").show();
    form1.trigger('reset');
  });

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
        registration_no:'required'
        ,product:'required'
        ,akad:'required'
        ,periode_angsuran:'required'
        ,jangka_waktu:'required'
        ,tgl_pengajuan:'required'
        ,tgl_registrasi:'required'
        ,tgl_akad:'required'
        ,angsuranke1:'required'
        ,tgl_jtempo:'required'
        ,jangka_waktu:'required'
        ,sumber_dana_pembiayaan:'required'
        ,kreditur_code1:'required'
        ,kreditur_code2:'required'
        ,program_khusus:'required'
        ,jadwal_angsuran:'required'
        ,jenis_pembiayaan:'required'
		,account_financing_no:'required'
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },
    highlight: function (element) { // hightlight error inputs
      $(element).closest('.help-inline').removeClass('ok'); // display OK icon
      $(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).closest('.control-group').removeClass('error'); // set error class to the control group
    },
    success: function (label) { },
    submitHandler: function (form) {

      var cif_type = $("#cif_type_hidden").val();
      var jaminan = $("#jaminan").val();
      var keterangan_jaminan = $("#keterangan_jaminan").val();
      var account_saving = $("#account_saving").val();

		  var t_regis = $('input[name="tgl_registrasi"]',form1).val();
		  var t_akad = $('input[name="tgl_akad"]',form1).val();

		  var split_t_regis = t_regis.split('/');
		  var split_t_akad = t_akad.split('/');

		  var tanggal_regis = split_t_regis[0];
		  var bulan_regis = split_t_regis[1];
		  var tahun_regis = split_t_regis[2];
		  var tanggal_registrasi = tahun_regis+'-'+bulan_regis+'-'+tanggal_regis;
		  var tanggal_registrasi = new Date(tahun_regis,bulan_regis - 1,tanggal_regis);

		  var tanggal_akad = split_t_akad[0];
		  var bulan_akad = split_t_akad[1];
		  var tahun_akad = split_t_akad[2];
		  var tanggal_pencairan = tahun_akad+'-'+bulan_akad+'-'+tanggal_akad;
		  var tanggal_pencairan = new Date(tahun_akad,bulan_akad - 1,tanggal_akad);

		  if(tanggal_registrasi > tanggal_pencairan){
			  var hasil = false;
		  } else {
			  var hasil = true;
		  }

		  if(hasil == false){
			  alert('Tanggal Registrasi maksimal sama dengan Tanggal Akad / Pencairan');
		  } else {
				$.ajax({
				  type: "POST",
				  url: site_url+"transaction/add_pembiayaan",
				  dataType: "json",
				  data: form1.serialize(),
				  success: function(response){
					if(response.success==true){
					  success1.show();
					  error1.hide();
					  form1.trigger('reset');
					  form1.find('.control-group').removeClass('success');
					  $("#cancel",form_add).trigger('click')
					  alert('Successfully Saved Data');
					  location.reload(false);
					}else{
						alert(response.message);
					  success1.hide();
					  error1.show();
					}
					App.scrollTo(form1, -200);
				  },
				  error:function(){
					  success1.hide();
					  error1.show();
					  App.scrollTo(form1, -200);
				  }
				});
		  }
    }
  });

  $("#cancel","#form_add").click(function(){
    success1.hide();
    error1.hide();
    $("#add").hide();
    $("#wrapper-table").show();
    dTreload();
  });

  /*
  | Event : Load Data Akad
  */
  $("#akad").change(function(){
    var akad = $("#akad").val();
    $.ajax({
      url: site_url+"transaction/get_ajax_jenis_keuntungan",
      type: "POST",
      dataType: "json",
      data: {akad:akad},
      success: function(response)
      {
        var data = response.jenis_keuntungan;
        if(data>=2)
        {
          $("#nisbah").show();
          $("#margin_p").hide();
        }
        else if(data==1)
        {
          $("#nisbah").hide();
          $("#margin_p").show();
        }
        else
        {
          $("#nisbah").hide();
          $("#margin_p").hide();
        }
      }
    });
  });
  


  /*
  | Event : Dialog Search No. Pengajuan
  */
  $("#select").click(function(){
    registration_no = $("#result").val();
    cif_no = $("#result option:selected").attr('cifno');
	fa_code = $("#result option:selected").attr('fa_code');
	petugas = $("#result option:selected").attr('petugas');
    $("#close","#dialog_rembug").trigger('click');
    $("#registration_no").val(registration_no);
	$('input[name="fa"]').val(petugas);
	$('input[name="fa_code"]').val(fa_code);
    //fungsi untuk mendapatkan value untuk field-field yang diperlukan
    $.ajax({
      type: "POST",
      dataType: "json",
      async:false,
      data: {no_reg:registration_no},
      url: site_url+"transaction/get_ajax_value_from_no_reg",
      success: function(response)
      {
		  var jpmb = response.financing_type;

        /* 
        | set value for header data 
        */
        $("#branch_code").val(response.branch_code);
        $("#cif_no").val(response.cif_no);
		    $("#cif_id").val(response.cif_id);
        $("#nama").val(response.nama);
        $("#panggilan").val(response.panggilan);
        $("#no_ktp").val(response.no_ktp);
        $("#ibu_kandung").val(response.ibu_kandung);
        $("#tmp_lahir").val(response.tmp_lahir);
        $("#tgl_lahir").val(response.tgl_lahir);
        $("#usia").val(response.usia);
        $("#no_hp").val(response.no_hp);
        $("#p_no_hp").val(response.p_no_hp);
    	  $("#form_add select[name='jenis_pembiayaan']").val(response.financing_type);
        $("#pydke","#add").val(response.pembiayaan_ke);
        $("#peruntukan_pembiayaan","#add").val(response.peruntukan);
        $("#keterangan","#add").val(response.description);
        if(response.cm_name!=null){
          $("#cm_name","#form_add").closest('.control-group').show();
          $("#cm_name","#form_add").val(response.cm_name);
        }else{
          $("#cm_name","#form_add").closest('.control-group').hide();
          $("#cm_name","#form_add").val('');
        }

        var cif_type = response.cif_type;

        $("#cif_type_hidden").val(cif_type);
        if(jpmb==1){
          $.ajax({
             type: "POST",
             url: site_url+"transaction/get_account_saving",
             dataType: "json",
             data: {cif_no:response.cif_no},
             success: function(response){
                html = '<option value="">PILIH</option>';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+' - '+response[i].product_name+'</option>';
                }
                $("#account_saving","#form_add").html(html);
             }
          });   
          $("#saving").hide();
          $("#id_jaminan","#form_add").hide();
          $("#div_tabungan_wajib").hide();
          $("#div_tabungan_kelompok").hide();
		  $("#fa_petugas").show();
		  $("#flag_wakalah","#form_add").val('1');
		  $(".non_reg").hide();
		  $("#reg").hide();
		  $("#j_angsuran").show();
        }else{
          $("#saving").hide();
          $("#id_jaminan","#form_add").hide();
          $("#div_tabungan_wajib").show();
          $("#div_tabungan_kelompok").show();
		  $("#fa_petugas").hide();
		  $("#flag_wakalah","#form_add").val('0');
		  $(".non_reg").show();
		  $("#reg").hide();
		  $("#j_angsuran").hide();
		  $("#jadwal_angsuran").val('1');
        }

        /*
        | set value for main data
        */
        $("#uang_muka").val(response.uang_muka);
        $("#nilai_pembiayaan").val(response.amount);
        $("#dtk").val(number_format(response.dtk,0,',','.'));
        $("#margin_pembiayaan").val(number_format(response.margin,0,',','.'));
        $("#account_financing_reg_id").val(response.account_financing_reg_id);
        $("#form_add select[name='peruntukan_pembiayaan']").val(response.peruntukan);
        var tanggal_pengajuan = response.tanggal_pengajuan;
        if(tanggal_pengajuan!=null){
          var tps = tanggal_pengajuan.split('-');
          var tanggal_pengajuan = tps[2]+"/"+tps[1]+"/"+tps[0];
        }
        var rencana_droping = response.rencana_droping;
        if(rencana_droping!=null){
          var tps = rencana_droping.split('-');
          var rencana_droping = tps[2]+"/"+tps[1]+"/"+tps[0];
        }

        $("#form_add input[name='tgl_pengajuan']").val(tanggal_pengajuan);
        $("#form_add input[name='tgl_akad']").val(rencana_droping);

        $.ajax({
           type: "POST",
           url: site_url+"transaction/ajax_get_product_financing_by_jenis_pembiayaan",
           dataType: "json",
           data: {jenis_pembiayaan:jpmb},
           success: function(response){
              html = '<option value="">PILIH</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
              }
              $("#product","#form_add").html(html);
           }
        });
      }                 
    });
  });
  
  $("#result option").live('dblclick',function(){
    $("#select").trigger('click');
  });

  $('#browse_rembug').click(function(){
	  $("select#cif_type").trigger('change');
  });

  $("#cif_type","#form_add").change(function(){
    type = $("#cif_type","#form_add").val();
    cm_code = $("select#cm").val();
    if(type=="0"){
      $("p#pcm").show();
    }else{
      $("p#pcm").hide().val('');
		$.ajax({
		  type: "POST",
		  url: site_url+"transaction/search_no_reg",
		  data: {keyword:$("#keyword").val(),cif_type:type,cm_code:''},
		  dataType: "json",
		  success: function(response){
			var option = '';
			if(type=="0"){
			  for(i = 0 ; i < response.length ; i++){
				 option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
			  }
			}else if(type=="1"){
			  for(i = 0 ; i < response.length ; i++){
				 option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
			  }
			}else{
			  for(i = 0 ; i < response.length ; i++){
				if(response[i].cm_name!=null){
				  cm_name = " - "+response[i].cm_name;   
				}else{
				  cm_name = "";
				}
				option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
			  }
			}
			$("#result").html(option);
		  }
		});
    }
  })

  $("#keyword").on('keypress',function(e){
    if(e.which==13){
      type = $("#cif_type","#form_add").val();
      cm_code = $("select#cm").val();
      if(type=="0"){
        $("p#pcm").show();
      }else{
        $("p#pcm").hide().val('');
      }
      $.ajax({
        type: "POST",
        url: site_url+"transaction/search_no_reg",
        data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
        dataType: "json",
        async: false,
        success: function(response){
          var option = '';
          if(type=="0"){
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
            }
          }else if(type=="1"){
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
            }
          }else{
            for(i = 0 ; i < response.length ; i++){
              if(response[i].cm_name!=null){
                cm_name = " - "+response[i].cm_name;   
              }else{
                cm_name = "";
              }
              option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
            }
          }
          $("#result").html(option);
        }
      });
      return false;
    }
  });
  
  $("select#cm").on('change',function(e){
    type = $("#cif_type","#form_add").val();
    cm_code = $(this).val();
    $.ajax({
      type: "POST",
      url: site_url+"transaction/search_no_reg",
      data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
      dataType: "json",
      success: function(response){
        var option = '';
        if(type=="0"){
          for(i = 0 ; i < response.length ; i++){
             option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+' - '+response[i].cm_name+'</option>';
          }
        }else if(type=="1"){
          for(i = 0 ; i < response.length ; i++){
             option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+'</option>';
          }
        }else{
          for(i = 0 ; i < response.length ; i++){
            if(response[i].cm_name!=null){
              cm_name = " - "+response[i].cm_name;   
            }else{
              cm_name = "";
            }
            option += '<option value="'+response[i].registration_no+'" cifno="'+response[i].cif_no+'" nama="'+response[i].nama+'" fa_code="'+response[i].fa_code+'" petugas="'+response[i].fa_name+'">'+response[i].nama+' - '+response[i].registration_no+''+cm_name+'</option>';
          }
        }
        $("#result").html(option);
      }
    });
    if(cm_code=="")
    {
      $("#result").html('');
    }
  });

  /*
  | Event : Jadwal Angsuran
  */
  $("#jadwal_angsuran").change(function(){
    var jadwal_angsuran = $("#jadwal_angsuran").val();    
    if(jadwal_angsuran=='1'){
      $(".non_reg").show();
      $("#reg").hide();
    }else if(jadwal_angsuran=="0"){
      $(".non_reg").hide();
      $("#reg").show();
    }else{
      $(".non_reg").hide();
      $("#reg").hide();
    }

    var nilai_pembiayaan = parseFloat(convert_numeric($("#nilai_pembiayaan").val()));  
    if(isNaN(nilai_pembiayaan)===true){ nilai_pembiayaan = 0}
    var jangka_waktu = $("#jangka_waktu").val(); 
    if(isNaN(jangka_waktu)===true){jangka_waktu = 0}
    var total_angsuran_pokok = nilai_pembiayaan/jangka_waktu;
    if(isNaN(total_angsuran_pokok)===true){
      total_angsuran_pokok = 0;
    }
    $("#angsuran_pokok").attr("readonly", true);
    $("#angsuran_pokok").val(number_format(total_angsuran_pokok,0,',','.'));

    var margin_pembiayaan = parseFloat(convert_numeric($("#margin_pembiayaan").val()));  
    if(isNaN(margin_pembiayaan)===true){
      margin_pembiayaan = 0;
    }

    var total_angsuran_margin = margin_pembiayaan/jangka_waktu;
    if(isNaN(total_angsuran_margin)===true){
      total_angsuran_margin = 0;
    }
    $("#angsuran_margin").attr("readonly", true);
    $("#angsuran_margin").val(number_format(total_angsuran_margin,0,',','.'));
   
  });

  /*
  | Event : Calculate Total Angsuran
  */  
  var calc_total_angsuran = function(){
    var angsuran_pokok = (isNaN(parseFloat(convert_numeric($("#angsuran_pokok").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_pokok").val()));
    var angsuran_margin = (isNaN(parseFloat(convert_numeric($("#angsuran_margin").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_margin").val()));
    var angsuran_tabungan = (isNaN(parseFloat(convert_numeric($("#angsuran_tabungan").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_tabungan").val()));
    var tabungan_wajib = (isNaN(parseFloat(convert_numeric($("#tabungan_wajib").val())))==true)?0:parseFloat(convert_numeric($("#tabungan_wajib").val()));
    var tabungan_kelompok = (isNaN(parseFloat(convert_numeric($("#tabungan_kelompok").val())))==true)?0:parseFloat(convert_numeric($("#tabungan_kelompok").val()));
    var total_angsuran = angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok;
    $("#total_angsuran").val(number_format(total_angsuran,0,',','.'));
  };

  /*
  | Event : Program Khusus
  */
  $("#program_khusus").change(function(){
    var program_khusus = convert_numeric($("#program_khusus").val());    
    if(program_khusus=='0'){
      $("#program").show();
    }else{
      $("#program").hide();
    }
  });

  /*
  | Event : Sumber Dana
  */
  $("#sumber_dana_pembiayaan").change(function(){
    var sumber_dana_pembiayaan = convert_numeric($("#sumber_dana_pembiayaan").val());
    var pokok = convert_numeric($("#nilai_pembiayaan").val());
    if(sumber_dana_pembiayaan=='0'){
      $("#dana_sendiri").val(number_format(pokok,0,',','.'));
      $("#sendiri").show();
      $("#sendiri_campuran").hide();
      $("#kreditur_campuran").hide();
      $("#kreditur").hide();
    }else if (sumber_dana_pembiayaan=='1'){
      $("#kreditur").show();
      $("#kreditur_campuran").hide();
      $("#sendiri").hide();
      $("#sendiri_campuran").hide();
    }else if (sumber_dana_pembiayaan=='2'){
      $("#dana_sendiri_campuran").val(number_format(pokok,0,',','.'));
      $("#kreditur").hide();
      $("#kreditur_campuran").show();
      $("#sendiri_campuran").show();
      $("#sendiri").hide();
    }else{
      $("#sendiri").hide();
      $("#kreditur").hide();
      $("#kreditur_campuran").hide();
      $("#sendiri_campuran").hide();
    }
  });

  /*
  | Event : GENERATE TANGGAL ANGSURAN KE-1
  */
  $("input[name='tgl_akad']",form1).change(function(e){
    tgl_akad=$(this).val().replace(/\_/g,'');
    periode_jangka_waktu=$("#periode_angsuran",form1).val();
    cif_type=$("#cif_type_hidden",form1).val();
    if(tgl_akad.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tgl_akad,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"rekening_nasabah/get_tanggal_mulai_angsur",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0]; 
          }
          $("input[name='angsuranke1']",form1).val(response.tanggal_mulai_angsur);
          $("input[name='angsuranke1']",form1).trigger('change');
        }
      })
    }
  });
  
  /*
  | Event : GENERATE TANGGAL JATUH TEMPO
  */
  $("input[name='angsuranke1']",form1).change(function(e){
    tgl_akad=$("input[name='tgl_akad']",form1).val().replace(/\_/g,'');
	tgl_mulai_angsur=$("input[name='angsuranke1']",form1).val().replace(/\_/g,'');
    jangka_waktu=$("#jangka_waktu",form1).val();
    periode_jangka_waktu=$("#periode_angsuran",form1).val();
    if(tgl_akad.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tgl_akad,
          jangka_waktu:jangka_waktu,
		  tgl_mulai_angsur:tgl_mulai_angsur,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"rekening_nasabah/get_tanggal_jatuh_tempo",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("input[name='tgl_jtempo']",form1).val(response.tanggal_jtempo);
        }
      })
    }
  });

  /*
  | Event : Generate No.Rekening Pembiayaan
  */
  $("#product",form1).change(function(){
    cif_no=$("#cif_no",form1).val();
    product_code=$(this).val();
    if(cif_no!="" && product_code!=""){
      $.ajax({
        type:"POST",dataType:"json",
        data:{cif_no:cif_no,product_code:product_code},async:false,
        url:site_url+"rekening_nasabah/get_seq_account_financing_no",
        success:function(response){
          $("#account_financing_no",form1).val(cif_no+product_code+response.newseq);
        }
      });
    }
  });

  /*
  | Event : GET Biaya Administrasi & Biaya Premi Asuransi Jiwa
  */
  $("#product,#nilai_pembiayaan,#tgl_akad,#tgl_jtempo",form1).change(function(){
    var product_code=$("#product",form1).val();
    var flagmanfaatasuransi=$("#product option:selected",form1).val();
    var pokok=(isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan",form1).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan",form1).val()));
    var margin=(isNaN(parseFloat(convert_numeric($("#margin_pembiayaan",form1).val())))==true)?0:parseFloat(convert_numeric($("#margin_pembiayaan",form1).val()));
    var tgl_akad=$("#tgl_akad",form1).val();
    var tgl_jtempo=$("#tgl_jtempo",form1).val();
    var usia=$("#usia",form1).val();
    var margin = (pokok * 30) / 100;
    var dtk = (pokok * 5) / 100;
    var manfaat=(flagmanfaatasuransi==0)?pokok+margin:pokok;
    get_biaya_administrasi(product_code,pokok,tgl_akad,tgl_jtempo,'add');
    get_biaya_premi_asuransi_jiwa(product_code,manfaat,usia,tgl_akad,tgl_jtempo,'add');
    $("#margin_pembiayaan",form1).val(number_format(margin,0,',','.'));
    $("#dtk",form1).val(number_format(dtk,0,',','.'));
  });

  /*
  | Event : Calc Total Angsuran
  */
  $("#nilai_pembiayaan,#margin_pembiayaan,#jangka_waktu",form1).change(function(){
    var nilai_pembiayaan=(isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan",form1).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan",form1).val()));
    var margin_pembiayaan=(isNaN(parseFloat(convert_numeric($("#margin_pembiayaan",form1).val())))==true)?0:parseFloat(convert_numeric($("#margin_pembiayaan",form1).val()));
    var jangka_waktu=(isNaN(parseFloat(convert_numeric($("#jangka_waktu",form1).val())))==true)?0:parseFloat(convert_numeric($("#jangka_waktu",form1).val()));
    var angsuran_pokok=nilai_pembiayaan/jangka_waktu;
    var angsuran_margin=margin_pembiayaan/jangka_waktu;
    $("#angsuran_pokok",form1).val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin",form1).val(number_format(angsuran_margin,0,',','.'));
    calc_total_angsuran();
    /* set sumber dana (sendiri) */
    $("#dana_sendiri",form1).val(number_format(nilai_pembiayaan,0,',','.'))
  });
  $("#angsuran_tabungan,#tabungan_wajib,#tabungan_kelompok",form1).change(function(){
    calc_total_angsuran();
  });
  
  /*
  |-------------------------------------------------------------------------------
  | END : Event For Add Form
  |-------------------------------------------------------------------------------
  */  

  /*
  |-------------------------------------------------------------------------------
  | BEGIN : Event For Add & Edit Form
  |-------------------------------------------------------------------------------
  */

  /*
  | Event : Function for GET Biaya Administrasi
  */
  var get_biaya_administrasi = function(product_code,pokok,tanggal_akad,tanggal_jtempo,form){
    if(product_code!="" && pokok!="" && tanggal_akad!="" && tanggal_jtempo!=""){
      $.ajax({
        type:"POST",dataType:"json",async:false,
        data:{product_code:product_code,pokok:pokok,tanggal_akad:tanggal_akad,tanggal_jtempo:tanggal_jtempo},
        url:site_url+"rekening_nasabah/get_biaya_administrasi",
        success:function(response){
          if(form=="add"){
            $("#biaya_administrasi",form1).val(response.biaya_administrasi);
          }else{
            $("#biaya_administrasi",form2).val(response.biaya_administrasi);
          }
        }
      });
    }
  }

  /*
  | Event : Function for GET Biaya Premi Asuransi Jiwa
  */
  var get_biaya_premi_asuransi_jiwa = function(product_code,manfaat,usia,tanggal_akad,tanggal_jtempo,form){
    if(product_code!="" && manfaat!="" && tanggal_akad!="" && tanggal_jtempo!=""){
      $.ajax({
        type:"POST",dataType:"json",async:false,
        data:{
           product_code:product_code
          ,manfaat:manfaat
          ,usia:usia
          ,tanggal_akad:tanggal_akad
          ,tanggal_jtempo:tanggal_jtempo
        },
        url:site_url+"rekening_nasabah/get_biaya_premi_asuransi_jiwa",
        success:function(response){
          if(form=="add"){
            $("#p_asuransi_jiwa",form1).val(response.biaya_premi_asuransi_jiwa);
          }else{
            $("#p_asuransi_jiwa",form2).val(response.biaya_premi_asuransi_jiwa);
          }
        }
      });
    }
  }

  /*
  |-------------------------------------------------------------------------------
  | END : Event For Add & Edit Form
  |-------------------------------------------------------------------------------
  */


  /*
  |-------------------------------------------------------------------------------
  | BEGIN : Event For Edit Form
  |-------------------------------------------------------------------------------
  */

  /*
  | CALCULATE TOTAL ANGSURAN POKOK NON REGULER
  | CALCULATE TOTAL ANGSURAN MARGIN NON REGULER
  | CALCULATE TOTAL ANGSURAN TABUNGAN NON REGULER
  */

  $("#additional_schedule input#angs_pokok",form2).live('keyup',function(e){
    var angs_pokok=0;
    $("#additional_schedule input#angs_pokok",form2).each(function(){
      angs_pokok+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_pokok",form2).val(number_format(angs_pokok,0,',','.'));
  });

  $("#additional_schedule input#angs_margin",form2).live('keyup',function(e){
    var angs_margin=0;
    $("#additional_schedule input#angs_margin",form2).each(function(){
      angs_margin+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_margin",form2).val(number_format(angs_margin,0,',','.'));
  });

  $("#additional_schedule input#angs_tabungan",form2).live('keyup',function(e){
    var angs_tabungan=0;
    $("#additional_schedule input#angs_tabungan",form2).each(function(){
      angs_tabungan+=(isNaN(parseFloat(convert_numeric($(this).val())))==true)?0:parseFloat(convert_numeric($(this).val()));
    });

    $("#additional_schedule input#total_angs_tabungan",form2).val(number_format(angs_tabungan,0,',','.'));
  });

  /*
  | Event : Kreditur
  */

  $("#kreditur_code21,#kreditur_code22","#form_edit").change(function(){
    if($(this).val()!=""){
      $.ajax({
        url: site_url+"rekening_nasabah/get_program_khusus",
        type: "POST",
        dataType:"json",
        data: {
          program_owner_code:$(this).val()
        },
        success: function(response){
          html ='<option value="">PILIH</option>';
          for(i in response){
            html += '<option value="'+response[i].program_code+'">'+response[i].program_name+'</option>';
          }
          $("#jenis_program","#form_edit").html(html);
        }
      })
    }
  });


  $("#periode_angsuran2,#jangka_waktu2",form2).change(function(){
    $("input[name='tgl_akad_edit']").trigger('change');
  })

  /*
  | Event : Load Data Akad
  */
  $("#akad2").change(function(){
    var akad = $("#akad2").val();
    $.ajax({
      url: site_url+"transaction/get_ajax_jenis_keuntungan",
      type: "POST",
      dataType: "json",
      data: {akad:akad},
      success: function(response)
      {
        var data = response.jenis_keuntungan;
        if(data>=2)
        {
          $("#nisbah2").show();
          $("#margin_p2").hide();
        }
        else if(data==1)
        {
          $("#nisbah2").hide();
          $("#margin_p2").show();
        }
        else
        {
          $("#nisbah2").hide();
          $("#margin_p2").hide();
        }
      }
    });
  });

  /*
  | Event : Show Jadwal Angsuran
  */
  $("#jadwal_angsuran2").change(function(){
    var jadwal_angsuran = $("#jadwal_angsuran2").val();    
    if(jadwal_angsuran=='1'){
      $(".non_reg2").show();
      $("#reg2").hide();
    }else{
      $(".non_reg2").hide();
      $("#reg2").show();
    }
  });

  /*
  | Event : Calculate Total Angsuran
  */
  var calc_total_angsuran2 = function(){
    var angsuran_pokok = (isNaN(parseFloat(convert_numeric($("#angsuran_pokok2").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_pokok2").val()));
    var angsuran_margin = (isNaN(parseFloat(convert_numeric($("#angsuran_margin2").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_margin2").val()));
    var angsuran_tabungan = (isNaN(parseFloat(convert_numeric($("#angsuran_tabungan2").val())))==true)?0:parseFloat(convert_numeric($("#angsuran_tabungan2").val()));
    var tabungan_wajib = (isNaN(parseFloat(convert_numeric($("#tabungan_wajib2").val())))==true)?0:parseFloat(convert_numeric($("#tabungan_wajib2").val()));
    var tabungan_kelompok = (isNaN(parseFloat(convert_numeric($("#tabungan_kelompok2").val())))==true)?0:parseFloat(convert_numeric($("#tabungan_kelompok2").val()));
    var total_angsuran = parseFloat(angsuran_pokok+angsuran_margin+angsuran_tabungan+tabungan_wajib+tabungan_kelompok);
    $("#total_angsuran2").val(number_format(total_angsuran,0,',','.'));
  };

  /*
  | Event : Program Khusus
  */
  $("#program_khusus2").change(function(){
    var program_khusus = $("#program_khusus2").val();    
    if(program_khusus=='0'){
      $("#program2").show();
    }else{
      $("#jenis_program","#form_edit").val('');
      $("#program2").hide();
    }
  });

  // /*
  // | Event : Sumber Dana
  // */
  // $("#nilai_pembiayaan2").change(function(){
  //   var nilai_pembiayaan2 = convert_numeric($(this).val());  
  //   $("#dana_sendiri","#form_edit").val(nilai_pembiayaan2);
  // });

  
  /*
  | Event : Sumber Dana
  */
  $("#sumber_dana_pembiayaan2").change(function(){
    var sumber_dana2 = $("#sumber_dana_pembiayaan2").val(); 

    if(sumber_dana2=='0'){
      $("#sendiri2").show();
      $("#sendiri_campuran2").hide();
      $("#kreditur2").hide();
      $("#kreditur2_campuran").hide();
    }else if(sumber_dana2=='1'){
      $("#kreditur2").show();
      $("#kreditur2_campuran").hide();
      $("#sendiri2").hide();
      $("#sendiri_campuran2").hide();
    }else if (sumber_dana2=='2'){
      $("#sendiri_campuran2").show();
      $("#kreditur2").hide();
      $("#kreditur2_campuran").show();
      $("#sendiri2").hide();
    }else{
      $("#kreditur2").hide();
      $("#sendiri2").hide();
      $("#sendiri_campuran2").hide();
    }
  });

  /*
  | Event : GENERATE TANGGAL ANGSURAN KE-1
  */
  $("input[name='tgl_akad_edit']",form2).change(function(e){
    tgl_akad=$(this).val().replace(/\_/g,'');
    periode_jangka_waktu=$("#periode_angsuran2",form2).val();
    cif_type=$("#cif_type_hidden2",form2).val();
    if(tgl_akad.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tgl_akad,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"rekening_nasabah/get_tanggal_mulai_angsur",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0]; 
          }
          $("input[name='angsuranke1_edit']",form2).val(response.tanggal_mulai_angsur);
          $("input[name='angsuranke1_edit']",form2).trigger('change');
        }
      })
    }
  });
  
  /*
  | Event : GENERATE TANGGAL JATUH TEMPO
  */
  $("input[name='angsuranke1_edit']",form2).change(function(e){
    tgl_akad=$("input[name='tgl_akad_edit']",form2).val().replace(/\_/g,'');
	tgl_mulai_angsur=$("input[name='angsuranke1_edit']",form2).val().replace(/\_/g,'');
    jangka_waktu=$("#jangka_waktu2",form2).val();
    periode_jangka_waktu=$("#periode_angsuran2",form2).val();
    if(tgl_akad.length==10){
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tgl_akad,
		  tgl_mulai_angsur:tgl_mulai_angsur,
          jangka_waktu:jangka_waktu,
          periode_jangka_waktu:periode_jangka_waktu
        },
        async:false,
        url:site_url+"rekening_nasabah/get_tanggal_jatuh_tempo",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("input[name='tgl_jtempo_edit']",form2).val(response.tanggal_jtempo);
        }
      })
    }
  });

  /*
  | Event : Generate No.Rekening Pembiayaan
  */
  $("#product2",form2).change(function(){
    cif_no=$("#cif_no2",form2).val();
    product_code=$(this).val();
    if(cif_no!="" && product_code!=""){
      $.ajax({
        type:"POST",dataType:"json",
        data:{cif_no:cif_no,product_code:product_code},async:false,
        url:site_url+"rekening_nasabah/get_seq_account_financing_no",
        success:function(response){
          $("#account_financing_no2",form2).val(cif_no+product_code+response.newseq);
        }
      });
    }
  });

  /*
  | Event : GET Biaya Administrasi & Biaya Premi Asuransi Jiwa
  */
  $("#product2,#nilai_pembiayaan2,#tgl_akad_edit,#tgl_jtempo_edit",form2).change(function(){
    var product_code=$("#product2",form2).val();
    var flagmanfaatasuransi=$("#product2 option:selected",form2).val();
    var pokok=(isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan2",form2).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan2",form2).val()));
    var margin=(isNaN(parseFloat(convert_numeric($("#margin_pembiayaan2",form2).val())))==true)?0:parseFloat(convert_numeric($("#margin_pembiayaan2",form2).val()));
    var tgl_akad=$("#tgl_akad_edit",form2).val();
    var tgl_jtempo=$("#tgl_jtempo_edit",form2).val();
    var usia=$("#usia",form2).val();
    var manfaat=(flagmanfaatasuransi==0)?pokok+margin:pokok;
    alert(pokok);
    var margin = (pokok * 30) / 100;
    var dtk = (pokok * 5) / 100;
    get_biaya_administrasi(product_code,pokok,tgl_akad,tgl_jtempo,'edit');
    get_biaya_premi_asuransi_jiwa(product_code,manfaat,usia,tgl_akad,tgl_jtempo,'edit');
    $("#margin_pembiayaan2",form2).val(number_format(margin,0,',','.'));
    $("#dtk",form2).val(number_format(dtk,0,',','.'));
  });

  /*
  | Event : Calc Total Angsuran
  */
  $("#nilai_pembiayaan2,#margin_pembiayaan2,#jangka_waktu2",form2).change(function(){
    var nilai_pembiayaan=(isNaN(parseFloat(convert_numeric($("#nilai_pembiayaan2",form2).val())))==true)?0:parseFloat(convert_numeric($("#nilai_pembiayaan2",form2).val()));
    var margin_pembiayaan=(isNaN(parseFloat(convert_numeric($("#margin_pembiayaan2",form2).val())))==true)?0:parseFloat(convert_numeric($("#margin_pembiayaan2",form2).val()));
    var jangka_waktu=(isNaN(parseFloat(convert_numeric($("#jangka_waktu2",form2).val())))==true)?0:parseFloat(convert_numeric($("#jangka_waktu2",form2).val()));
    var angsuran_pokok=nilai_pembiayaan/jangka_waktu;
    var angsuran_margin=margin_pembiayaan/jangka_waktu;
    $("#angsuran_pokok2",form2).val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuran_margin2",form2).val(number_format(angsuran_margin,0,',','.'));
    calc_total_angsuran2();
    /* set sumber dana (sendiri) */
    $("#dana_sendiri",form2).val(number_format(nilai_pembiayaan,0,',','.'))
  });
  $("#angsuran_tabungan2,#tabungan_wajib2,#tabungan_kelompok2",form2).change(function(){
    calc_total_angsuran2();
  });  

  /*
  | Event : Form Edit Validation
  */

  form2.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
        product:'required'
        ,akad:'required'
        ,periode_angsuran:'required'
        ,jangka_waktu:'required'
        ,tgl_pengajuan_edit:'required'
        ,tgl_registrasi_edit:'required'
        ,tgl_akad_edit:'required'
        ,angsuranke1_edit:'required'
        ,tgl_jtempo_edit:'required'
        ,sumber_dana_pembiayaan:'required'
        ,kreditur_code1:'required'
        ,kreditur_code2:'required'
        ,program_khusus:'required'
        ,jadwal_angsuran:'required'
		,jenis_pembiayaan:'required'
		,account_financing_no:'required'
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
    success: function (label) { },
    submitHandler: function (form) {
	  var t_regis = $('input[name="tgl_registrasi_edit"]',form2).val();
	  var t_akad = $('input[name="tgl_akad_edit"]',form2).val();

	  var split_t_regis = t_regis.split('/');
	  var split_t_akad = t_akad.split('/');

	  var tanggal_regis = split_t_regis[0];
	  var bulan_regis = split_t_regis[1];
	  var tahun_regis = split_t_regis[2];
	  var tanggal_registrasi = tahun_regis+'-'+bulan_regis+'-'+tanggal_regis;
	  var tanggal_registrasi = new Date(tahun_regis,bulan_regis - 1,tanggal_regis);

	  var tanggal_akad = split_t_akad[0];
	  var bulan_akad = split_t_akad[1];
	  var tahun_akad = split_t_akad[2];
	  var tanggal_pencairan = tahun_akad+'-'+bulan_akad+'-'+tanggal_akad;
	  var tanggal_pencairan = new Date(tahun_akad,bulan_akad - 1,tanggal_akad);

	  if(tanggal_registrasi > tanggal_pencairan){
		  var hasil = false;
	  } else {
		  var hasil = true;
	  }

	  if(hasil == false){
		  alert('Tanggal Registrasi maksimal sama dengan Tanggal Akad / Pencairan');
	  } else {
		  // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
		  $.ajax({
			type: "POST",
			url: site_url+"transaction/edit_rekening_pembiayaan",
			dataType: "json",
			data: form2.serialize(),
			success: function(response){
			  if(response.success==true){
				success2.show();
				error2.hide();
				form2.children('div').removeClass('success');
				$("#rekening_pembiayaan_table_filter input").val('');
				dTreload();
				$("#cancel",form_edit).trigger('click')
				alert('Successfully Updated Data');
			  }else{
				alert(response.message);
				success2.hide();
				error2.show();
			  }
			  App.scrollTo(form2, -200);
			},
			error:function(){
				success2.hide();
				error2.show();
				App.scrollTo(error2, -200);
			}
		  });
	  }
    }
  });
  
  /*
  | Event : Edit Link pada Table Grid
  */
  $("a#link-edit").live('click',function(){
    var account_financing_no = $(this).attr('account_financing_no');
    $.ajax({
      type: "POST",
      url: site_url+"transaction/get_status_rekening_from_account_financing",
      dataType: "json",
      async:false,
      data: {account_financing_no:account_financing_no},
      success: function(response)
      {
        if (response.status_rekening!=0)
        {
          alert('Status Rekening Sudah Aktif');
        }
        else
        {

          $("#wrapper-table").hide();
          $("#edit").show();
          $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            data: {account_financing_no:account_financing_no},
            url: site_url+"transaction/get_account_financing_by_account_financing_no",
            success: function(response)
            {

			  var financing_t = response.financing_type;
			  var fa_name = response.fa_name;
			  var fa_code = response.fa_code;
			  var b_code = response.branch_code;
			  
			  if(financing_t == '0'){
				  $('#saving2').hide();
				  $("#div_tabungan_wajib2").show();
				  $("#div_tabungan_kelompok2").show();
				  $('#fa_petugas2').hide();
				  $('#flag_wakalah','#form_edit').val('0');
				  $(".non_reg2").show();
				  $("#reg2").hide();
				  $("#j_angsuran2").hide();
				  $("#jadwal_angsuran2").val('1');
			  } else {
				  $('#saving2').show();
				  $("#div_tabungan_wajib2").hide();
				  $("#div_tabungan_kelompok2").hide();
				  $('#fa_petugas2').show();
				  $('#flag_wakalah','#form_edit').val('1');
				  $(".non_reg2").hide();
				  $("#reg2").show();
				  $("#j_angsuran2").show();
			  }
              /*
              | load data produk
              */
              $.ajax({
                 type: "POST",
                 url: site_url+"transaction/ajax_get_product_financing_by_jenis_pembiayaan",
                 dataType: "json",
                 async:false,
                 data: {jenis_pembiayaan:response.financing_type},
                 success: function(response){
                    html = '<option value="">PILIH</option>';
                    for ( i = 0 ; i < response.length ; i++ )
                    {
                       // html += '<option value="'+response[i].jenis_tabungan+''+response[i].product_code+'">'+response[i].product_name+'</option>';
                       html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
                    }
                    $("#product2","#form_edit").html(html);
                 }
              });  
              
              /*
              | load data rekening tabungan
              */
              $.ajax({
                 type: "POST",
                 url: site_url+"transaction/get_account_saving",
                 dataType: "json",
                 async:false,
                 data: {cif_no:response.cif_no},
                 success: function(response){
                    html = '<option value="">PILIH</option>';
                    for ( i = 0 ; i < response.length ; i++ )
                    {
                       html += '<option value="'+response[i].account_saving_no+'" selected="selected">'+response[i].account_saving_no+' - '+response[i].product_name+'</option>';
                    }
                    $("#account_saving2","#form_edit").html(html);
                 }
              });  

              var fdp = response.flag_double_premi;
			  
			  if(fdp == 1){
				  $("#form_edit #flag_double_premi").attr('checked',true);
				  $("#form_edit #flag_double_premi").closest('span').attr('class','checked');

				  e_anggota_asuransi.fadeIn();

				  var tgl_peserta = response.tanggal_peserta_asuransi.substring(8,10);
				  var bln_peserta = response.tanggal_peserta_asuransi.substring(5,7);
				  var thn_peserta = response.tanggal_peserta_asuransi.substring(0,4);
				  var tanggal_peserta_asuransi = tgl_peserta+""+bln_peserta+""+thn_peserta;  

				  $('#form_edit #peserta_asuransi').val(response.peserta_asuransi);
				  $('#form_edit #ktp_asuransi').val(response.ktp_asuransi);
				  $("#form_edit input[name='tanggal_peserta_asuransi']").val(tanggal_peserta_asuransi);
				  $("#form_edit select[name='hubungan_peserta_asuransi']").val(response.hubungan_peserta_asuransi);
			  } else {
				  $("#form_edit #flag_double_premi").attr('checked',false);
				  e_anggota_asuransi.fadeOut();
              }

			    $("#pydke","#edit").val(response.pembiayaan_ke);
          $("#keterangan","#edit").val(response.description);
          $("#form_edit input[name='account_financing_reg_id2']").val(response.account_financing_reg_id);
          $("#form_edit select[name='jenis_pembiayaan']").val(response.financing_type);
          $("#form_edit input[name='registration_no2']").val(response.registration_no);
          $("#form_edit input[name='cif_type_hidden2']").val(response.cif_type);
          $("#form_edit input[name='account_financing_id']").val(response.account_financing_id);
          $("#form_edit input[name='branch_code']").val(response.branch_code);
			    $("#form_edit input[name='cif_id']").val(response.cif_id);
          $("#form_edit input[name='cif_no']").val(response.cif_no);
			    $("#form_edit input[name='branch_code2']").val(b_code);
          $("#form_edit input[name='nama']").val(response.nama);
          $("#form_edit input[name='panggilan']").val(response.panggilan);
          $("#form_edit input[name='no_ktp']").val(response.no_ktp);
          $("#form_edit input[name='ibu_kandung']").val(response.ibu_kandung);
          $("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
          $("#form_edit input[name='tgl_lahir']").val(response.tgl_lahir);
          $("#form_edit input[name='no_hp']").val(response.no_hp);
          $("#form_edit input[name='p_no_hp']").val(response.p_no_hp);
          $("#form_edit input[name='usia']").val(response.usia);
              /*
              | State Untuk Rembug/Majlis
              | apabila kelompok maka muncul info Nama Rembug/Majlis
              | sebaliknya jika individu tidak ada info Nama Rembug/Majlis
              */
          if(response.cm_name!=null){
            $("#form_edit input[name='cm_name']").closest('.control-group').show();
            $("#form_edit input[name='cm_name']").val(response.cm_name);
          }else{
            $("#form_edit input[name='cm_name']").closest('.control-group').hide();
            $("#form_edit input[name='cm_name']").val('');
          }
          $("#form_edit input[name='account_financing_no']").val(response.account_financing_no);
          $("#form_edit input[name='uang_muka']").val(response.uang_muka);
          $("#form_edit input[name='nilai_pembiayaan']").val(response.pokok);
          $("#form_edit input[name='dtk']").val(response.simpanan_wajib_pinjam);
          $("#form_edit input[name='margin_pembiayaan']").val(response.margin);
          $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
          $("#form_edit select[name='periode_angsuran']").val(response.periode_jangka_waktu);
          $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
          $("#form_edit input[name='angsuran_pokok']").val(number_format(response.angsuran_pokok,0,',','.'));
          $("#form_edit input[name='angsuran_margin']").val(number_format(response.angsuran_margin,0,',','.'));
          $("#form_edit input[name='angsuran_tabungan']").val(response.angsuran_catab);
          var cif_type = response.cif_type
          if(cif_type=='1'){
            $("#id_jaminan","#form_edit").show();
            $("#div_tabungan_wajib2").hide();
            $("#div_tabungan_kelompok2").hide();
            $("#form_edit input[name='tabungan_wajib']").val(0);
            $("#form_edit input[name='tabungan_kelompok']").val(0);
            $("#form_edit select[name='jaminan']").val(response.jenis_jaminan);
            $("#form_edit textarea[name='keterangan_jaminan']").val(response.keterangan_jaminan);
          }else{
            $("#id_jaminan","#form_edit").hide();
            $("#div_tabungan_wajib2").show();
            $("#div_tabungan_kelompok2").show();
            $("#form_edit input[name='tabungan_wajib']").val(number_format(response.angsuran_tab_wajib,0,',','.'));
            $("#form_edit input[name='tabungan_kelompok']").val(number_format(response.angsuran_tab_kelompok,0,',','.'));
          }

              /*
              | Hitung Total Angsuran
              */
              a_1 = parseFloat(response.angsuran_pokok);
              a_2 = parseFloat(response.angsuran_margin);
              a_3 = parseFloat(response.angsuran_catab);
              a_4 = parseFloat(response.angsuran_tab_wajib);
              a_5 = parseFloat(response.angsuran_tab_kelompok);
              total_angsuran  = a_1+a_2+a_3+a_4+a_5;

              $("#form_edit input[name='total_angsuran']").val(number_format(total_angsuran,0,',','.'));
              $("#form_edit input[name='cadangan_resiko']").val(response.cadangan_resiko);
              $("#form_edit input[name='dana_kebajikan']").val(response.dana_kebajikan);
              $("#form_edit input[name='biaya_administrasi']").val(response.biaya_administrasi);
              $("#form_edit input[name='biaya_notaris']").val(response.biaya_notaris);
              $("#form_edit input[name='p_asuransi_jiwa']").val(response.biaya_asuransi_jiwa);
              $("#form_edit input[name='p_asuransi_jaminan']").val(response.biaya_asuransi_jaminan);
              $("#form_edit select[name='sumber_dana_pembiayaan']").val(response.sumber_dana);
              $("#form_edit input[name='dana_sendiri']").val(number_format(response.dana_sendiri,0,',','.'));
              $("#form_edit input[name='dana_sendiri_campuran']").val(number_format(response.dana_sendiri,0,',','.'));
              $("#form_edit input[name='dana_kreditur']").val(response.dana_kreditur);
              $("#form_edit input[name='dana_kreditur_campuran']").val(response.dana_kreditur);
      			  $("#form_edit input[name='fa']").val(fa_name);
      			  $("#form_edit input[name='fa_code']").val(fa_code);
              /*
              | Cek Sumber Dana
              */
              if(response.sumber_dana=='1'){
	              $("#form_edit #kreditur_code21").val(response.kreditur_code);
	              $("#form_edit input[name='keuntungan']").val(response.ujroh_kreditur_persen);
	              $("#form_edit input[name='angsuran']").val(response.ujroh_kreditur);
	              $("#form_edit select[name='pembayaran_kreditur']").val(response.ujroh_kreditur_carabayar);
              }else if(response.sumber_dana=='2'){
                $("#form_edit #kreditur_code22").val(response.kreditur_code);
              	$("#form_edit input[name='keuntungan_campuran']").val(response.ujroh_kreditur_persen);
              	$("#form_edit input[name='angsuran_campuran']").val(response.ujroh_kreditur);
              	$("#form_edit select[name='pembayaran_kreditur2']").val(response.ujroh_kreditur_carabayar);
              }
              $("#form_edit select[name='product']").val(response.product_code);
              /*
              | State Untuk No.Rekening Tabungan
              | apabila kelompok gak pake Rekening Tabungan
              | sebaliknya kalo individu pake Rekening Tabungan
              */
              var account_saving = response.account_saving_no
              if(account_saving==""){
                  $("#saving2").hide();
              }else{
                  $("#form_edit select[name='account_saving']").val(account_saving);
                  $("#saving2").show();
              }
             
              var producttt = response.program_code;
              $("#form_edit select[name='jenis_program']").val(producttt);
              var akadddd = response.akad_code;
              $("#form_edit select[name='akad']").val(akadddd);
              $("#akad2","#form_edit").trigger('change');
              $("#form_edit select[name='sektor_ekonomi']").val(response.sektor_ekonomi);
              $("#form_edit select[name='peruntukan_pembiayaan']").val(response.peruntukan);

              $("#form_edit select[name='jadwal_angsuran']").val(response.flag_jadwal_angsuran);

              /*
              | Load Tanggal Pengajuan
              */
              var tanggal_pengajuan = response.tanggal_pengajuan;
              if(typeof(tanggal_pengajuan)=='undefined'){
                tanggal_pengajuan='';
              }
              var tgl_pengajuan = tanggal_pengajuan.substring(8,10);
              var bln_pengajuan = tanggal_pengajuan.substring(5,7);
              var thn_pengajuan = tanggal_pengajuan.substring(0,4);
              var tgl_akhir_pengajuan = tgl_pengajuan+""+bln_pengajuan+""+thn_pengajuan;  
              $("#form_edit input[name='tgl_pengajuan_edit']").val(tgl_akhir_pengajuan);

              /*
              | Load Tanggal Registrasi
              */
              var tanggal_registrasi = response.tanggal_registrasi;
              if(typeof(tanggal_registrasi)=='undefined'){
                tanggal_registrasi='';
              }
              var tgl_registrasi = tanggal_registrasi.substring(8,10);
              var bln_registrasi = tanggal_registrasi.substring(5,7);
              var thn_registrasi = tanggal_registrasi.substring(0,4);
              var tgl_akhir_registrasi = tgl_registrasi+""+bln_registrasi+""+thn_registrasi;  
              $("#form_edit input[name='tgl_registrasi_edit']").val(tgl_akhir_registrasi);

              /*
              | Load Tanggal Mulai Angsur
              */
              var tanggal_mulai_angsur = response.tanggal_mulai_angsur;
              if(typeof(tanggal_mulai_angsur)=='undefined'){
                tanggal_mulai_angsur='';
              }
              var tgl_mulai_angsur = tanggal_mulai_angsur.substring(8,10);
              var bln_mulai_angsur = tanggal_mulai_angsur.substring(5,7);
              var thn_mulai_angsur = tanggal_mulai_angsur.substring(0,4);
              var tgl_akhir_angsur = tgl_mulai_angsur+"/"+bln_mulai_angsur+"/"+thn_mulai_angsur;
              $("#form_edit input[name='angsuranke1_edit']").val(tgl_akhir_angsur);

              /*
              | Load Tanggal Akad
              */
              var tanggal_akad = response.tanggal_akad;
              if(typeof(tanggal_akad)=='undefined'){
                tanggal_akad='';
              }
              var tgl_akad = tanggal_akad.substring(8,10);
              var bln_akad = tanggal_akad.substring(5,7);
              var thn_akad = tanggal_akad.substring(0,4);
              var tgl_akhir_akad = tgl_akad+""+bln_akad+""+thn_akad;
              $("#form_edit input[name='tgl_akad_edit']").val(tgl_akhir_akad);

              /*
              | Load Tanggal Jatuh Tempo
              */
              var tanggal_jtempo = response.tanggal_jtempo;
              if(typeof(tanggal_jtempo)=='undefined'){
                tanggal_jtempo='';
              }
              var tgl_jtempo = tanggal_jtempo.substring(8,10);
              var bln_jtempo = tanggal_jtempo.substring(5,7);
              var thn_jtempo = tanggal_jtempo.substring(0,4);
              var tgl_akhir_jtempo = tgl_jtempo+"/"+bln_jtempo+"/"+thn_jtempo;
              $("#form_edit input[name='tgl_jtempo_edit']").val(tgl_akhir_jtempo);

              /*
              | fungsi untuk menyembunyikan input jadwal angsuran jika value=0
              */
              var jadwal_angsuran = response.flag_jadwal_angsuran;   
              if(jadwal_angsuran=='0'){
                $(".non_reg2").hide();
                $("#reg2").show();
              }else{
                $(".non_reg2").show();
                $("#reg2").hide();
              }

              /*
              | fungsi untuk menyembunyikan input sumber dana pembiayaan jika value=1
              */
              var sumber_dana_pembiayaan = response.sumber_dana;  
              if(sumber_dana_pembiayaan=='0')
              {
                $("#sendiri2","#form_edit").show();
                $("#sendiri_campuran2","#form_edit").hide();
                $("#kreditur2","#form_edit").hide();
                $("#kreditur2_campuran","#form_edit").hide();
              }
              else if (sumber_dana_pembiayaan=='1') 
              {
                $("#kreditur2","#form_edit").show();
                $("#kreditur2_campuran","#form_edit").hide();
                $("#sendiri2","#form_edit").hide();
                $("#sendiri_campuran2","#form_edit").hide();
              }
              else if (sumber_dana_pembiayaan=='2') 
              {
                $("#sendiri2","#form_edit").hide();
                $("#kreditur2","#form_edit").hide();
                $("#kreditur2_campuran","#form_edit").show();
              }
              else
              {
                $("#sendiri2","#form_edit").hide();
                $("#sendiri_campuran2","#form_edit").hide();
                $("#kreditur2","#form_edit").hide();
                $("#kreditur2_campuran","#form_edit").hide();
              }

              /*
              | fungsi untuk menyembunyikan input nisbah bagi hasil
              */
              var nisbah = response.nisbah_bagihasil;   
              if(nisbah==null)
              {
                $("#nisbah2","#form_edit").hide();
              }
              else
              {
                $("#nisbah2","#form_edit").show();
              }

              /*
              | fungsi untuk menyembunyikan input Jenis Program
              */
              var jenis_program = response.program_code;   
              if(jenis_program==null){
                $("#program2","#form_edit").hide();
                $("#program_khusus2","#form_edit").val('1');
              }else{
                $("#program2","#form_edit").show();
                $("#program_khusus2","#form_edit").val('0');
              }

              /*
              | State untuk Jenis Angsuran (Jadwal Angsuran)
              | kalo Jenis Angsuran Non Reguler maka Load Data Schedul di Table
              */
              $.ajax({
                type: "POST",
                dataType: "json",
                data: {account_financing_no:response.account_financing_no},
                url: site_url+"transaction/get_account_financing_schedulle_by_no_account",
                success: function(response)
                {
                  html = '';
                  total_angsuran_pokok=0;
                  total_angsuran_margin=0;
                  total_angsuran_tabungan=0;
                  for(i = 0 ; i < response.length ; i++)
                  {
                    var tangga_jtempo = response[i].tangga_jtempo;
                    if(tangga_jtempo==undefined)
                    {
                      tangga_jtempo='';
                    }
                    var tg_jtempo = tangga_jtempo.substring(8,10);
                    var bl_jtempo = tangga_jtempo.substring(5,7);
                    var th_jtempo = tangga_jtempo.substring(0,4);
                    
                    var tg_akhir_jtempo = tg_jtempo+"/"+bl_jtempo+"/"+th_jtempo;
                    // console.log(tg_akhir_jtempo);
                    total_angsuran_pokok += parseFloat(response[i].angsuran_pokok);
                    total_angsuran_margin += parseFloat(response[i].angsuran_margin);
                    total_angsuran_tabungan += parseFloat(response[i].angsuran_tabungan);
                    html += ' \
                    <tr> \
                      <td style="text-align:center;"> \
                        <input type="hidden" id="account_financing_schedulle_id" name="account_financing_schedulle_id[]" value="'+response[i].account_financing_schedulle_id+'"> \
                        <input type="text" class="m-wrap small date-picker mask_date" id="angs_tanggal" value="'+tg_akhir_jtempo+'" name="angs_tanggal[]"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_pokok" value="'+number_format(response[i].angsuran_pokok,0,',','.')+'" name="angs_pokok[]"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_margin" value="'+number_format(response[i].angsuran_margin,0,',','.')+'" name="angs_margin[]"> \
                      </td> \
                      <td style="text-align:center;"> \
                        <input type="text" maxlength="12" class="m-wrap small mask-money" id="angs_tabungan" value="'+number_format(response[i].angsuran_tabungan,0,',','.')+'" name="angs_tabungan[]"> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <a href="javascript:void(0);" id="angs_add" class="btn green">Tambah</a> \
                      </td> \
                      <td style="vertical-align:middle;text-align:center;"> \
                        <a href="javascript:void(0);" id="angs_delete" class="btn red">Hapus</a> \
                      </td> \
                    </tr> \
                    ';
                  }
                  if(jadwal_angsuran==0){
                    $("#additional_schedule","#form_edit").find('tbody').html(html);
                    $("#total_angs_pokok","#form_edit").val(number_format(total_angsuran_pokok,0,',','.'));
                    $("#total_angs_margin","#form_edit").val(number_format(total_angsuran_margin,0,',','.'));
                    $("#total_angs_tabungan","#form_edit").val(number_format(total_angsuran_tabungan,0,',','.'));
                  }
                }
              });
            }
          });
        }
      }
    });
  });

  /*
  |-------------------------------------------------------------------------------
  | END : Event For Edit Form
  |-------------------------------------------------------------------------------
  */

  $('#jenis_pembiayaan','#form_add').change(function(){
    var jenis_pembiayaan = $(this).val();
    if (jenis_pembiayaan=='0') {
      $('#saving').hide();
	  $("#div_tabungan_wajib").show();
	  $("#div_tabungan_kelompok").show();
	  $('#fa_petugas').hide();
	  $('#flag_wakalah','#form_add').val('0');
      $(".non_reg").show();
      $("#reg").hide();
	  $("#j_angsuran").hide();
	  $("#jadwal_angsuran").val('1');
    } else {
      $('#saving').hide();
	  $("#div_tabungan_wajib").hide();
	  $("#div_tabungan_kelompok").hide();
	  $('#fa_petugas').show();
	  $('#flag_wakalah','#form_add').val('1');
      $(".non_reg").show();
      $("#reg").hide();
	  $("#j_angsuran").show();
    }
    if (jenis_pembiayaan!="") {
      $.ajax({
         type: "POST",
         url: site_url+"transaction/ajax_get_product_financing_by_jenis_pembiayaan",
         dataType: "json",
         data: {jenis_pembiayaan:jenis_pembiayaan},
         success: function(response){
            html = '<option value="">PILIH</option>';
            for ( i = 0 ; i < response.length ; i++ ) {
               html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
            }
            $("#product","#form_add").html(html);
         }
      });
    } else {
      $("#product","#form_add").html('');
    }
    $('#account_saving').val('');
    $('#account_financing_no').val('');
  })

  $('#jenis_pembiayaan','#form_edit').change(function(){
    var jenis_pembiayaan = $(this).val();
    if (jenis_pembiayaan=='0') {
      $('#saving2').hide();
	  $("#div_tabungan_wajib2").show();
	  $("#div_tabungan_kelompok2").show();
	  $('#fa_petugas2').hide();
	  $('#flag_wakalah','#form_edit').val('0');
      $(".non_reg2").show();
      $("#reg2").hide();
	  $("#j_angsuran2").hide();
	  $("#jadwal_angsuran2").val('1');
    } else {
      $('#saving2').hide();
	  $("#div_tabungan_wajib2").hide();
	  $("#div_tabungan_kelompok2").hide();
	  $('#fa_petugas2').show();
	  $('#flag_wakalah','#form_edit').val('1');
      $(".non_reg2").show();
      $("#reg2").hide();
	  $("#j_angsuran2").show();
    }
    if (jenis_pembiayaan!="") {
      $.ajax({
        type: "POST",
        url: site_url+"transaction/ajax_get_product_financing_by_jenis_pembiayaan",
        dataType: "json",
        async:false,
        data: {jenis_pembiayaan:jenis_pembiayaan},
        success: function(response){
          html = '<option value="">PILIH</option>';
          for ( i = 0 ; i < response.length ; i++ ) {
            html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
          }
          $("#product2","#form_edit").html(html);
        }
      });
    } else {
      $("#product2","#form_edit").html('');
    }
    $('#account_saving2').val('');
    $('#account_financing_no2').val('');
  })

  /* begin cari kas petugas */
  $("#form_add #browse_fa").click(function(){

    fa = $("input[name='fa']","#form_process").val();
    $("#keyword_fa","#dialog_fa").val(fa)
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword_fa',"#dialog_fa").trigger(e);
    },300)
  })
  $("#form_edit #browse_fa_edit").click(function(){

    fa = $("input[name='fa']","#form_edit").val();
	bc2 = $("input[name='branch_code2']","#form_process").val();
    $("#keyword_fa_edit","#dialog_fa_edit").val(fa)
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword_fa_edit',"#dialog_fa_edit").trigger(e);
    },300)
  })

  $("#keyword_fa","#dialog_fa").keypress(function(e){
    keyword = $(this).val();
	branch_code = $('#branch_code').val()
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"transaction/search_fa",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch:branch_code},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
              html += '<option value="'+response[i].fa_code+'" nama="'+response[i].fa_name+'">'+response[i].fa_name+'</option>';
            }
            $("#result_fa","#dialog_fa").html(html).focus();
            $("#result_fa option:first-child","#dialog_fa").attr('selected',true);
         }
      })
    }
  });

  $("#keyword_fa_edit","#dialog_fa_edit").keypress(function(e){
    keyword = $(this).val();
	branch_code = $('#branch_code2').val()
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"transaction/search_fa",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch:branch_code},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
              html += '<option value="'+response[i].fa_code+'" nama="'+response[i].fa_name+'">'+response[i].fa_name+'</option>';
            }
            $("#result_fa_edit","#dialog_fa_edit").html(html).focus();
            $("#result_fa_edit option:first-child","#dialog_fa_edit").attr('selected',true);
         }
      })
    }
  });

  $("#select_fa","#dialog_fa").click(function(){
    result_code = $("#result_fa","#dialog_fa").val();
  result_nama = $("#result_fa option:selected","#dialog_fa").attr('nama');
    if(result!=null)
    {
      $("input[name='fa_code']").val(result_code);
    $("input[name='fa']").val(result_nama);
      $("#close_fa","#dialog_fa").trigger('click');
    }
  });

  $("#select_fa_edit","#dialog_fa_edit").click(function(){
    result_code = $("#result_fa_edit","#dialog_fa_edit").val();
  result_nama = $("#result_fa_edit option:selected","#dialog_fa_edit").attr('nama');
    if(result!=null)
    {
      $("input[name='fa_code']").val(result_code);
    $("input[name='fa']").val(result_nama);
      $("#close_fa_edit","#dialog_fa_edit").trigger('click');
    }
  });

  $("#result_fa option","#dialog_fa").livequery('dblclick',function(){
    $("#select_fa","#dialog_fa").trigger('click');
    window.scrollTo(0,0)
  });

  $("#result_fa_edit option","#dialog_fa_edit").livequery('dblclick',function(){
    $("#select_fa_edit","#dialog_fa_edit").trigger('click');
    window.scrollTo(0,0)
  });

  $("input[name='fa']","#form_process").keypress(function(e){
    if(e.keyCode==13){
      $(this).blur();
      e.preventDefault();
      $("#browse_fa").trigger('click');
    }
  });


  $("#result_fa_edit","#dialog_fa_edit").keypress(function(e){
    e.preventDefault();
    if(e.keyCode==13){
      $("#select_fa_edit","#dialog_fa_edit").trigger('click');
    }
  });
  /* end cari kas petugas */

});
</script>
<!-- END JAVASCRIPTS -->

