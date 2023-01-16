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
      Verifikasi <small>Verifikasi Rekening Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Verifikasi</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Verifikasi Rekening Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Rekening Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <hr style="margin:0;">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="margin-bottom:0;line-height:44px;float:left;padding-left:10px;">CABANG</label>
        <div style="padding:5px;float:left;">
          <select id="param_branch_code" style="width:100px;padding:4px;margin-top:2px;margin-left:5px;margin-bottom:5px;box-shadow:0 0 0;">
            <?php foreach($branchs as $branch): ?>
            <option value="<?php echo $branch['branch_code'] ?>"><?php echo $branch['branch_name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <label style="margin-bottom:0;line-height:44px;float:left;padding-left:10px;">Tanggal</label>
        <div style="padding:5px;float:left;">
          <input id="param_tanggal_akad" name="param_tanggal_akad" class="mask_date date-picker mask_date" type="text" style="width:100px;padding:4px;margin-top:2px;margin-left:5px;margin-bottom:5px;box-shadow:0 0 0;" value="<?php echo date('d/m/Y',strtotime($trx_date)); ?>" maxlength="10" placeholder="dd/mm/yyyy" tabindex="2">
        </div>
        <div style="padding:5px;float:left;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <p>
      <table class="table table-striped table-bordered table-hover" id="rekening_pembiayaan_table">
         <thead>
            <tr>
               <!-- <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rekening_pembiayaan_table .checkboxes" /></th> -->
               <th width="25%">No. Rekening</th>
               <th width="20%">Nama</th>
               <th width="20%">Akad</th>
               <th width="20%">Pembiayaan</th>
               <!-- <th width="15%">Rembug</th> -->
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
      
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Rekening Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_id" name="account_financing_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Successful!
            </div>
          </br>      
                   <div class="control-group">
                       <label class="control-label">No Pengajuan</label>
                       <div class="controls">
                          <input type="text" name="registration_no2" id="registration_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">No Customer</label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code2" name="branch_code2">
                       </div>
                    </div>            
                              
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap (sesuai KTP)</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
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
                        Tanggal Lahir
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir"  style="background-color:#eee;width:100px;"  readonly=""/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" style="background-color:#eee;width:30px;"  readonly=""/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">No.Telp/HP Pribadi</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="no_hp" id="no_hp" readonly="readonly" style="background-color:#eee; width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">No.Telp/HP Pasangan</label>
                        <div class="controls">
                           <input type="text" class=" medium m-wrap" name="p_no_hp" id="p_no_hp" readonly="readonly" style="background-color:#eee; width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                    <div class="control-group" style="display:none">
                       <label class="control-label">Rembug </label>
                       <div class="controls">
                          <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr>               
                    <div id="saving2" style="display:none;"> 
                    <div class="control-group">
                       <label class="control-label">Account Saving No<span class="required">*</span></label>
                       <div class="controls">
                          <select id="account_saving2" name="account_saving" class="medium m-wrap" disabled style="background-color:#eee;">                     
                          </select>
                          <input type="text" class=" m-wrap" name="pro_name" id="pro_name"  style="background-color:#eee;"  readonly=""/>
                       </div>
                    </div>                   
                    </div>                  
                    <div class="control-group">
                       <label class="control-label">Produk</label>
                       <div class="controls">
                          <input name="product2" type="text" id="product2" class="medium m-wrap" disabled="disabled" style="background-color:#eee" />
                          <input name="pro_code" type="hidden" id="pro_code" />
                          <input name="financing_type" type="hidden" id="financing_type" />
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">No. Rekening</label>
                       <div class="controls">
                          <input type="text" name="account_financing_no" id="account_financing_no2" class="medium m-wrap" readonly=""  style="background-color:#eee;"/>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Akad</label>
                       <div class="controls">
                          <select id="akad2" name="akad" class="medium m-wrap" disabled style="background-color:#eee;">                     
                            <option value="">PILIH</option>
                            <?php foreach($akad as $data): ?>
                              <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Nilai Pembiayaan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="nilai_pembiayaan" id="nilai_pembiayaan2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>        
                    <div class="control-group">
                       <label class="control-label">Margin Pembiayaan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="margin_pembiayaan" id="margin_pembiayaan2">
                             <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div> 
                  <div id="nisbah2">     
                    <div class="control-group">
                       <label class="control-label">Nisbah Bagi Hasil</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap" readonly="" style="background-color:#eee;width:60px" name="nisbah_bagihasil" id="nisbah_bagihasil" maxlength="5">
                             <span class="add-on">%</span>
                           </div>
                         </div>
                    </div>  
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Periode Angsuran</label>
                       <div class="controls">
                          <select id="periode_angsuran" disabled style="background-color:#eee;" name="periode_angsuran" class="medium m-wrap">                     
                            <option value="">PILIH</option>                    
                            <option value="0">Harian</option>                    
                            <option value="1">Mingguan</option>                    
                            <option value="2">Bulanan</option>                    
                            <option value="3">Jatuh Tempo</option>
                          </select>
                       </div>
                    </div>         
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Angsuran</label>
                       <div class="controls">
                        &nbsp;
                        <input type="text" value="0"  class=" m-wrap" readonly="" name="jangka_waktu" id="jangka_waktu2" maxlength="3" style="background-color:#eee;width:30px;"/>
                        <span class="help-inline"></span></div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan</label>
                       <div class="controls">
                          <input type="text" readonly="" name="tgl_pengajuan" id="mask_date" class="small m-wrap" style="background-color:#eee;"/>
                       </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Tanggal Registrasi<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tgl_registrasi" id="mask_date" class="small m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Tanggal Akad</label>
                       <div class="controls">
                          <input type="text" readonly="" name="tgl_akad" id="mask_date" class="small m-wrap" style="background-color:#eee;"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Tanggal Angsuran Ke-1</label>
                       <div class="controls">
                          <input type="text" readonly="" name="angsuranke1" id="mask_date" class="small m-wrap" style="background-color:#eee;"/>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Tanggal Jatuh Tempo</label>
                       <div class="controls">
                          <input type="text" readonly="" name="tgl_jtempo" id="mask_date" class="small m-wrap" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr>
                    <div id="j_angsuran">
                    <div class="control-group">
                       <label class="control-label">Jadwal Angsuran</label>
                       <div class="controls">
                          <select id="jadwal_angsuran2" disabled name="jadwal_angsuran" class="medium m-wrap" style="background-color:#eee;">                     
                            <option value="">PILIH</option>                    
                            <option value="1">Reguler</option>                    
                            <option value="0">Non Reguler</option> 
                          </select>
                       </div> 
                    </div>
                    </div>

                    <div id="reg2" style="display:none;">
                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="20%" style="text-align:center;">Tanggal (dd/mm/yyyy)</th>
                               <th width="20%" style="text-align:center;">Angsuran Pokok</th>
                               <th width="20%" style="text-align:center;">Angsuran Margin</th>
                               <th width="20%" style="text-align:center;">Angsuran Tabungan</th>
                            </tr>
                         </thead>
                         <tbody>
                            <tr>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask_date mask-money" id="angs_tanggal" name="angs_tanggal[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_pokok" name="angs_pokok[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_margin" name="angs_margin[]">
                              </td>
                              <td style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="angs_tabungan" name="angs_tabungan[]">
                              </td>
                            </tr>
                         </tbody>
                      </table>



                      <table class="table table-striped table-bordered table-hover" id="additional_schedule">
                         <thead>
                            <tr>
                               <th width="20%" style="vertical-align:middle;text-align:center;">Total Angsuran</th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_pokok" name="total_angs_pokok[]">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_margin" name="total_angs_margin[]">
                               </th>
                               <th width="10%" style="text-align:center;">
                                <input type="text" style="background-color:#eee;width:190px;" readonly="" class="m-wrap mask-money" id="total_angs_tabungan" name="total_angs_tabungan[]">
                               </th>
                               <th width="14%" style="text-align:center;">
                               </th>
                            </tr>
                         </thead>
                      </table>

                    </div>
                    <div id="non_reg2">
                    <div class="control-group">
                       <label class="control-label">Angsuran Pokok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_pokok" id="angsuran_pokok2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Angsuran Margin</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_margin" id="angsuran_margin2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Tabungan Cadangan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="angsuran_tabungan" id="angsuran_tabungan2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>               
                    <div class="control-group" id="div_tabungan_wajib">
                       <label class="control-label">Tabungan Wajib</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  name="tabungan_wajib" id="tabungan_wajib2">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>        
                    <div class="control-group" id="div_tabungan_kelompok">
                       <label class="control-label">Tabungan Kelompok</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;" readonly="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"  name="tabungan_kelompok" id="tabungan_kelompok2">
                             <span class="add-on">,00</span>
                           </div>
                      </div> 
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Total Angsuran</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  name="total_angsuran" readonly="" id="total_angsuran2">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    </div>
                    <hr>     
                    <div class="control-group">
                         <label class="control-label">Cadangan Resiko</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="cadangan_resiko" id="cadangan_resiko">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Dana Kebajikan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="dana_kebajikan" id="dana_kebajikan">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Biaya Administrasi</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="biaya_administrasi" id="biaya_administrasi">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>      
                    <div class="control-group">
                       <label class="control-label">Biaya Notaris</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="biaya_notaris" id="biaya_notaris">
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
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="p_asuransi_jiwa" id="p_asuransi_jiwa">
                             <span class="add-on">,00</span>
                           </div>
                           <label class="checkbox">
                           	<input name="flag_double_premi" type="checkbox" id="flag_double_premi" value="1" disabled="disabled" /> Dobel Premi
                           </label>
                         </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Nama Peserta Asuransi</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="peserta_asuransi" id="peserta_asuransi" readonly="readonly" style="background-color:#eee;">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">KTP Peserta</label>
                       <div class="controls">
                         <input type="text" class="m-wrap" name="ktp_asuransi" id="ktp_asuransi" readonly="readonly" style="background-color:#eee;">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Tanggal Lahir Peserta</label>
                       <div class="controls">
                         <input type="text" class="small m-wrap" name="tanggal_peserta_asuransi" id="mask_date" placeholder="dd/mm/yy" readonly="readonly" style="background-color:#eee;">
                       </div>
                    </div>      
                    <div class="control-group" id="e_anggota_asuransi">
                       <label class="control-label">Hubungan Peserta</label>
                       <div class="controls">
                          <select id="hubungan_peserta_asuransi" name="hubungan_peserta_asuransi" class="medium m-wrap" disabled="disabled" style="background-color:#eee;">                     
                            <option value="">PILIH</option>
                            <option value="1">Suami</option>
                            <option value="2">Orang Tua</option>
                            <option value="3">Anak</option>
                          </select>
                       </div>
                    </div>
                    <hr />
                    <div class="control-group">
                       <label class="control-label">Premi Asuransi Jaminan</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="p_asuransi_jaminan" id="p_asuransi_jaminan">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>
                    <div id="id_jaminan"> 
                    <hr>    
                    <div class="control-group">
                       <label class="control-label">Jaminan <span class="required">*</span></label>
                       <div class="controls">
                          <select id="jaminan2" name="jaminan" class="medium m-wrap" disabled="disabled" style="background-color:#eee"> 
                            <option value="">PILIH</option>
                            <?php foreach ($jaminan as $data):?>
                            <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Keterangan Jaminan <span class="required">*</span></label>
                       <div class="controls">
                          <textarea class="medium m-wrap" style="background-color:#eee" name="keterangan_jaminan" id="keterangan_jaminan2" disabled="disabled"></textarea>
                       </div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Taksasi <span class="required">*</span></label>
                       <div class="controls">
                         <div class="input-prepend input-append">
                           <span class="add-on">Rp</span>
                            <input type="text" class="m-wrap mask-money" disabled="disabled" style="width:120px;background-color:#eee" name="nominal_taksasi" id="nominal_taksasi" value="0">
                           <span class="add-on">,00</span>
                         </div>
                       </div>
                    </div>  
                    </div> 
                    <!-- <hr>      -->
                    <div class="control-group hide">
                       <label class="control-label">Sumber Dana Pembiayaan</label>
                       <div class="controls">
                          <select id="sumber_dana_pembiayaan2" disabled name="sumber_dana_pembiayaan" class="medium m-wrap" style="background-color:#eee;">                     
                            <option value="">PILIH</option>
                            <option value="0">Sendiri</option>
                            <option value="1">Kreditur</option>
                            <option value="2">Campuran</option>
                          </select>
                       </div>
                    </div>    
                    <div id="sendiri2" class="hide">
                    <div class="control-group hide">
                       <label class="control-label">Dana Sendiri</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="dana_sendiri" id="dana_sendiri">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    </div>  
                    <div id="kreditur2">
                    <div class="control-group">
                       <label class="control-label">Dana Kreditur</label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="background-color:#eee;width:120px;"  readonly="" name="dana_kreditur" id="dana_kreditur">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Ujroh Kreditur</label>
                       <div class="controls">
                        <input type="text" class=" m-wrap" readonly="" name="keuntungan" id="keuntungan" style="background-color:#eee;width:30px;" /> % Keuntungan
                        &nbsp;
                        <input type="text" class=" m-wrap" name="angsuran" readonly="" id="angsuran" style="background-color:#eee;width:30px;" /> / Angsuran
                        <span class="help-inline"></span></div>
                    </div>    
                    <div class="control-group">
                       <label class="control-label">Pembayaran Kreditur</label>
                       <div class="controls">
                          <select id="pembayaran_kreditur" style="background-color:#eee;" readonly="" name="pembayaran_kreditur" class="medium m-wrap">                     
                            <option value="">PILIH</option>                     
                            <option value="0">Sesuai Angsuran</option>                     
                            <option value="1">Sekaligus</option>
                          </select>
                       </div>
                    </div>    
                  </div>
                    <hr>  
                    <div class="control-group">
                       <label class="control-label">Program  Khusus</label>
                       <div class="controls">
                          <select id="program_khusus2" style="background-color:#eee;" disabled name="program_khusus" class="medium m-wrap">                     
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
                          <select id="jenis_program" style="background-color:#eee;" disabled name="jenis_program" class="medium m-wrap">                     
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
                        <select id="sektor_ekonomi" style="background-color:#eee;" disabled name="sektor_ekonomi" class="medium m-wrap">                     
                            <option value="">PILIH</option> 
                            <?php foreach ($sektor as $data):?>
                            <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Peruntukan</label>
                       <div class="controls">
                        <select id="peruntukan_pembiayaan" name="peruntukan_pembiayaan" disabled class="medium m-wrap" style="background-color:#eee;">                     
                            <option value="">PILIH</option> 
                            <?php foreach ($peruntukan as $data):?>
                            <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                        </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium" readonly="" style="background-color:#eee;"></textarea>
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
                       </div>
                    </div>
                    </div>
                    <div id="m_wakalah">
                    <div class="control-group">
                       <label class="control-label">Menggunakan Wakalah?</label>
                       <div class="controls">
                        <select id="flag_wakalah" disabled="disabled" name="flag_wakalah" class="medium m-wrap" style="background-color:#eee;">                     
                          <option value="">Pilih</option>
                          <option value="0">Tidak</option>
                          <option value="1">Ya</option>
                        </select>
                       </div>
                    </div>
                    </div>
            <div class="form-actions">
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->

  

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<!--<script src="<?php //echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>-->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.1.10.4.min.js" type="text/javascript"></script>
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
      $("input#mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("input.mask_date").inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

    $(function(){
      $("#rekening_pembiayaan_table_length").parent().parent().hide();
    })

    $("#btn-filter").click(function(){
      table.fnReloadAjax();
    })

	var e_anggota_asuransi = $('div#e_anggota_asuransi');

    var dTreload = function()
    {
      var tbl_id = 'rekening_pembiayaan_table';
      $("select[name='"+tbl_id+"_length']").trigger('change');
      // $(".paging_bootstrap li:first a").trigger('click');
      // $("#"+tbl_id+"_filter input").val('').trigger('keyup');
    }

     $("#select").click(function(){
         result = $("#result").val();
         if(result != null)
         {
            $("#add_cm_code").val(result);
            $("#edit_cm_code").val(result);
            $("#cm_code").val(result);
            $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
            $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
            $("#close","#dialog_rembug").trigger('click');
         }
         else
         {
            alert("Please select row first !");
         }

      });

      $("#result option:selected").live('dblclick',function(){
        $("#select").trigger('click');
      });

      $("#result option").live('dblclick',function(){
         $("#select").trigger('click');
      });
   
      $("select[name='branch']","#dialog_rembug").change(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         var branch = $("select[name='branch']","#dialog_rembug").val();
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_rembug_by_keyword",
            dataType: "json",
            data: {keyword:keyword,branch_id:branch},
            success: function(response){
               html = '';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
               }
               $("#result").html(html);
            }
         })
      })

      $("#keyword","#dialog_rembug").keypress(function(e){
         keyword = $(this).val();
         if(e.which==13){
            var branch = $("select[name='branch']","#dialog_rembug").val();
            $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
         }
      });

      $("#browse_rembug").click(function(){
         keyword = $("#keyword","#dialog_rembug").val();
         branch = $("select[name='branch']","#dialog_rembug").val();
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword,branch_id:branch},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
                  }
                  $("#result").html(html);
               }
            })
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
      // jQuery('#rekening_pembiayaan_table .group-checkable').live('change',function () {
      //     var set = jQuery(this).attr("data-set");
      //     var checked = jQuery(this).is(":checked");
      //     jQuery(set).each(function () {
      //         if (checked) {
      //             $(this).attr("checked", true);
      //         } else {
      //             $(this).attr("checked", false);
      //         }
      //     });
      //     jQuery.uniform.update(set);
      // });

      // $("#rekening_pembiayaan_table .checkboxes").livequery(function(){
      //   $(this).uniform();
      // });


   
       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_no = $(this).attr('account_financing_no');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"transaction/get_account_financing_by_account_financing_id",
          success: function(response)
          {
			var jpmb = response.financing_type;
			$('#financing_type').val(jpmb);
			$('#branch_code2').val(response.branch_code);
			if(jpmb == 0){
				$('#fa_petugas').hide();
				$('#m_wakalah').hide();
				$('#j_angsuran').hide();
			} else {
				$('#fa_petugas').show();
				$('#m_wakalah').hide();
				$('#j_angsuran').show();
			}
			$('#pro_code').val(response.product_code);
            $.ajax({
               type: "POST",
               url: site_url+"transaction/get_ajax_produk_by_product_code",
               dataType: "json",
               async:false,
               data: {product_code:response.product_code},
               success: function(response){
                  html = '';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option jenispembiayaan="'+response[i].jenis_pembiayaan+'" insuranceproductcode="'+response[i].insurance_product_code+'" flagmanfaatasuransi="'+response[i].flag_manfaat_asuransi+'" value="'+response[i].product_code+'">'+response[i].product_name+'</option>';
                  }
                  $("#product2","#form_edit").val(response.product_name);
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
				  var tanggal_peserta_asuransi = tgl_peserta+"/"+bln_peserta+"/"+thn_peserta;  

				  $('#form_edit #peserta_asuransi').val(response.peserta_asuransi);
				  $('#form_edit #ktp_asuransi').val(response.ktp_asuransi);
				  $("#form_edit input[name='tanggal_peserta_asuransi']").val(tanggal_peserta_asuransi);
				  $("#form_edit select[name='hubungan_peserta_asuransi']").val(response.hubungan_peserta_asuransi);
			  } else {
				  $("#form_edit #flag_double_premi").attr('checked',false);
				  e_anggota_asuransi.fadeOut();
              }

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
                     html += '<option value="'+response[i].account_saving_no+'">'+response[i].account_saving_no+'</option>';
                  }
                  $("#account_saving2","#form_edit").html(html);
               }
            });   

            $("#form_edit #pydke").val(response.pembiayaan_ke);
            $("#form_edit #keterangan").val(response.description);
            $("#form_edit input[name='registration_no2']").val(response.registration_no);
            $("#form_edit input[name='account_financing_id']").val(response.account_financing_id);
            $("#form_edit input[name='branch_code']").val(response.branch_code);
            $("#form_edit input[name='cif_no']").val(response.cif_no);
			$("#form_edit input[name='fa']").val(response.fa_name);
            $("#form_edit input[name='nama']").val(response.nama);
            $("#form_edit input[name='panggilan']").val(response.panggilan);
            $("#form_edit input[name='ibu_kandung']").val(response.ibu_kandung);
            $("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
            $("#form_edit input[name='no_hp']").val(response.no_hp);
            $("#form_edit input[name='p_no_hp']").val(response.p_no_hp);

            var tgl_lhr_ = response.tgl_lahir.substring(8,10);
            var bln_lhr_ = response.tgl_lahir.substring(5,7);
            var thn_lhr_ = response.tgl_lahir.substring(0,4);
            var tgl_lahir = tgl_lhr_+"/"+bln_lhr_+"/"+thn_lhr_;  
            $("#form_edit input[name='tgl_lahir']").val(tgl_lahir);
            $("#form_edit input[name='usia']").val(response.usia);
            if(response.cm_name!=null){
              $("#form_edit input[name='cm_name']").closest('.control-group').show();
              $("#form_edit input[name='cm_name']").val(response.cm_name);
            }else{
              $("#form_edit input[name='cm_name']").closest('.control-group').hide();
              $("#form_edit input[name='cm_name']").val('');
            }

            $("#form_edit input[name='account_financing_no']").val(response.account_financing_no);
            $("#form_edit input[name='nilai_pembiayaan']").val(number_format(response.pokok,0,',','.'));
            $("#form_edit input[name='margin_pembiayaan']").val(number_format(response.margin,0,',','.'));
            $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
            $("#form_edit select[name='periode_angsuran']").val(response.periode_jangka_waktu);
            $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
            $("#form_edit input[name='angsuran_pokok']").val(number_format(response.angsuran_pokok,0,',','.'));
            $("#form_edit input[name='angsuran_margin']").val(number_format(response.angsuran_margin,0,',','.'));
            $("#form_edit input[name='angsuran_tabungan']").val(number_format(response.angsuran_catab,0,',','.'));
            var cif_type = response.cif_type
            if(cif_type=='1'){
              $("#id_jaminan","#form_edit").show();
              $("#div_tabungan_wajib").hide();
              $("#div_tabungan_kelompok").hide();
              $("#form_edit input[name='tabungan_wajib']").val(0);
              $("#form_edit input[name='tabungan_kelompok']").val(0);
              $("#form_edit select[name='jaminan']").val(response.jenis_jaminan);
              $("#form_edit textarea[name='keterangan_jaminan']").val(response.keterangan_jaminan);
              $("#form_edit input[name='nominal_taksasi']").val(number_format(response.nominal_taksasi,0,',','.'));
            }else{
              $("#id_jaminan","#form_edit").hide();
              $("#div_tabungan_wajib").show();
              $("#div_tabungan_kelompok").show();
              $("#form_edit input[name='tabungan_wajib']").val(number_format(response.angsuran_tab_wajib,0,',','.'));
              $("#form_edit input[name='tabungan_kelompok']").val(number_format(response.angsuran_tab_kelompok,0,',','.'));
            }

            a_1 = parseFloat(response.angsuran_pokok);
            a_2 = parseFloat(response.angsuran_margin);
            a_3 = parseFloat(response.angsuran_catab);
            a_4 = parseFloat(response.angsuran_tab_wajib);
            a_5 = parseFloat(response.angsuran_tab_kelompok);
            total_angsuran  = a_1+a_2+a_3+a_4+a_5;

            $("#form_edit input[name='total_angsuran']").val(number_format(total_angsuran,0,',','.'));
            $("#form_edit input[name='cadangan_resiko']").val(number_format(response.cadangan_resiko,0,',','.'));
            $("#form_edit input[name='dana_kebajikan']").val(number_format(response.dana_kebajikan,0,',','.'));
            $("#form_edit input[name='biaya_administrasi']").val(number_format(response.biaya_administrasi,0,',','.'));
            $("#form_edit input[name='biaya_notaris']").val(number_format(response.biaya_notaris,0,',','.'));
            $("#form_edit input[name='p_asuransi_jiwa']").val(number_format(response.biaya_asuransi_jiwa,0,',','.'));
            $("#form_edit input[name='p_asuransi_jaminan']").val(number_format(response.biaya_asuransi_jaminan,0,',','.'));
            $("#form_edit select[name='sumber_dana_pembiayaan']").val(response.sumber_dana);
            $("#form_edit input[name='dana_sendiri']").val(number_format(response.dana_sendiri,0,',','.'));
            $("#form_edit input[name='dana_kreditur']").val(number_format(response.dana_kreditur,0,',','.'));
            $("#form_edit input[name='keuntungan']").val(response.ujroh_kreditur_persen);
            $("#form_edit input[name='angsuran']").val(response.ujroh_kreditur);
            $("#form_edit select[name='pembayaran_kreditur']").val(response.ujroh_kreditur_carabayar);
            $("#form_edit select[name='peruntukan_pembiayaan']").val(response.peruntukan);
            $("#form_edit select[name='flag_wakalah']").val(response.flag_wakalah);
            var account_saving = response.account_saving_no
            if(account_saving==""){
                $("#saving2").hide();
            }else{
                $("#form_edit select[name='account_saving']").val(account_saving);
				$("#pro_name","#form_edit").val(pro_name);
                $("#saving2").hide();
            }

			$.ajax({
				type: 'POST',
				url: site_url+'transaction/set_saving_by_saving_no',
				dataType: 'json',
				async: false,
				data: {account_saving_no:account_saving},
				success: function(keputusan){
					var hasil = keputusan.success;
					var product = keputusan.product_name;
					
					if(hasil == true){
						$('#pro_name').val(product);
					}
				}
			});

            var program_code = response.program_code;
            $("#form_edit select[name='jenis_program']").val(program_code);
            if(program_code!=null)
            {
                $("#form_edit select[name='program_khusus']").val(0);
            }
            else
            {
                $("#form_edit select[name='program_khusus']").val(1);
            }
            var akadddd = response.akad_code;
            $("#form_edit select[name='akad']").val(akadddd);
            $("#form_edit select[name='jadwal_angsuran']").val(response.flag_jadwal_angsuran);
            $("#form_edit select[name='product']").val(response.product_code);

            var tanggal_pengajuan = response.tanggal_pengajuan;
            if(tanggal_pengajuan==undefined)
            {
              tanggal_pengajuan='';
            }
            var tgl_pengajuan = tanggal_pengajuan.substring(8,10);
            var bln_pengajuan = tanggal_pengajuan.substring(5,7);
            var thn_pengajuan = tanggal_pengajuan.substring(0,4);
            var tgl_akhir_pengajuan = tgl_pengajuan+"/"+bln_pengajuan+"/"+thn_pengajuan;  
            $("#form_edit input[name='tgl_pengajuan']").val(tgl_akhir_pengajuan);

            var tanggal_registrasi = response.tanggal_registrasi;
            if(tanggal_registrasi==undefined)
            {
              tanggal_registrasi='';
            }
            var tgl_registrasi = tanggal_registrasi.substring(8,10);
            var bln_registrasi = tanggal_registrasi.substring(5,7);
            var thn_registrasi = tanggal_registrasi.substring(0,4);
            var tgl_akhir_registrasi = tgl_registrasi+"/"+bln_registrasi+"/"+thn_registrasi;  
            $("#form_edit input[name='tgl_registrasi']").val(tgl_akhir_registrasi);

            var tanggal_mulai_angsur = response.tanggal_mulai_angsur;
            if(tanggal_mulai_angsur==undefined)
            {
              tanggal_mulai_angsur='';
            }
            var tgl_mulai_angsur = tanggal_mulai_angsur.substring(8,10);
            var bln_mulai_angsur = tanggal_mulai_angsur.substring(5,7);
            var thn_mulai_angsur = tanggal_mulai_angsur.substring(0,4);
            var tgl_akhir_angsur = tgl_mulai_angsur+"/"+bln_mulai_angsur+"/"+thn_mulai_angsur;
            $("#form_edit input[name='angsuranke1']").val(tgl_akhir_angsur);

            var tanggal_akad = response.tanggal_akad;
            if(tanggal_akad==undefined)
            {
              tanggal_akad='';
            }
            var tgl_akad = tanggal_akad.substring(8,10);
            var bln_akad = tanggal_akad.substring(5,7);
            var thn_akad = tanggal_akad.substring(0,4);
            var tgl_akhir_akad = tgl_akad+"/"+bln_akad+"/"+thn_akad;
            $("#form_edit input[name='tgl_akad']").val(tgl_akhir_akad);

            var tanggal_jtempo = response.tanggal_jtempo;
            if(tanggal_jtempo==undefined)
            {
              tanggal_jtempo='';
            }
            var tgl_jtempo = tanggal_jtempo.substring(8,10);
            var bln_jtempo = tanggal_jtempo.substring(5,7);
            var thn_jtempo = tanggal_jtempo.substring(0,4);
            var tgl_akhir_jtempo = tgl_jtempo+"/"+bln_jtempo+"/"+thn_jtempo;
            $("#form_edit input[name='tgl_jtempo']").val(tgl_akhir_jtempo);
            $("#sektor_ekonomi").val(response.sektor_ekonomi);

            
     /* var jenis_and_code_product = response.jenis_pembiayaan+''+response.product_code;
      $("#form_edit select[name='product']").val(jenis_and_code_product);*/
      
       //fungsi untuk menyembunyikan input jadwal angsuran jika value=0
        var jadwal_angsuran = response.flag_jadwal_angsuran;   
        if(jadwal_angsuran=='0')
        {
            $("#non_reg2").hide();
            $("#reg2").show();
        }
        else
        {
            $("#non_reg2").show();
            $("#reg2").hide();
        }

       //fungsi untuk menyembunyikan input sumber dana pembiayaan jika value=1
        var sumber_dana_pembiayaan = response.sumber_dana;  
        if(sumber_dana_pembiayaan=='0')
        {
          $("#dana_sendiri").val(number_format(response.pokok,0,',','.'));
          $("#sendiri2").show();
          $("#kreditur2").hide();
        }
        else if (sumber_dana_pembiayaan=='1') 
        {
          $("#kreditur2").show();
          $("#sendiri2").hide();
        }
        else if (sumber_dana_pembiayaan=='2') 
        {
          $("#dana_sendiri").val(number_format(response.pokok,0,',','.'));
          $("#sendiri2").show();
          $("#kreditur2").show();
        }
        else
        {
          $("#sendiri2").hide();
          $("#kreditur2").hide();
        }

         //fungsi untuk menyembunyikan input nisbah bagi hasil
        var nisbah = response.nisbah_bagihasil;   
        if(nisbah==null)
        {
          $("#nisbah2").hide();
        }
        else
        {
          $("#nisbah2").show();
        }

        //fungsi untuk menyembunyikan input Jenis Program
        var jenis_program = response.program_code;   
        if(jenis_program==null)
        {
          $("#program2").hide();
        }
        else
        {
          $("#program2").show();
        }

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
                var tg_jtempo = tangga_jtempo.substring(8,10);
                var bl_jtempo = tangga_jtempo.substring(5,7);
                var th_jtempo = tangga_jtempo.substring(0,4);
                
                var tg_akhir_jtempo = tg_jtempo+"/"+bl_jtempo+"/"+th_jtempo;
                console.log(tg_akhir_jtempo);
                total_angsuran_pokok += parseFloat(response[i].angsuran_pokok);
                total_angsuran_margin += parseFloat(response[i].angsuran_margin);
                total_angsuran_tabungan += parseFloat(response[i].angsuran_tabungan);
                html += ' \
                <tr> \
                  <td style="text-align:center;"> \
                    <input type="hidden" id="account_financing_schedulle_id" name="account_financing_schedulle_id[]" value="'+response[i].account_financing_schedulle_id+'"> \
                    <input type="text" style="width:190px;" class="m-wrap mask_date" readonly="" id="angs_tanggal" value="'+tg_akhir_jtempo+'" name="angs_tanggal[]"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" style="width:190px;" maxlength="12" readonly="" class="m-wrap mask-money" id="angs_pokok" value="'+number_format(response[i].angsuran_pokok,0,',','.')+'" name="angs_pokok[]"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" style="width:190px;" maxlength="12" readonly="" class="m-wrap mask-money" id="angs_margin" value="'+number_format(response[i].angsuran_margin,0,',','.')+'" name="angs_margin[]"> \
                  </td> \
                  <td style="text-align:center;"> \
                    <input type="text" style="width:190px;" maxlength="12" readonly="" class="m-wrap mask-money" id="angs_tabungan" value="'+number_format(response[i].angsuran_tabungan,0,',','.')+'" name="angs_tabungan[]"> \
                  </td> \
                  <td style="vertical-align:middle;text-align:center;"> \
                    <a href="javascript:void(0);" id="angs_add">Tambah</a> \
                  </td> \
                  <td style="vertical-align:middle;text-align:center;"> \
                    <a href="javascript:void(0);" id="angs_delete">Hapus</a> \
                  </td> \
                </tr> \
              ';
            }

            if(jadwal_angsuran==0){
              $("#additional_schedule","#form_edit").find('tbody').html(html);
              $("#additional_schedule","#form_edit").find('tbody').html(html);
              $("#total_angs_pokok","#form_edit").val(number_format(total_angsuran_pokok,0,',','.'));
              $("#total_angs_margin","#form_edit").val(number_format(total_angsuran_margin,0,',','.'));
              $("#total_angs_tabungan","#form_edit").val(number_format(total_angsuran_tabungan,0,',','.'));
            }
          }
        })

        }
        });

      });
        
    
    // fungsi untuk mencari CIF_NO pada form EDIT
      $(function(){

        $("#dialog2").dialog({
          width: 270,
          height: 320,
          autoOpen: false,
          buttons: {
            'OK': function(){
              $("#dialog2").dialog('close');
              var customer_no = $("#result2").val();
              //alert(customer_no);
              $("#cif_no2").val(customer_no);
            }
          }
        });
    $("#button-dialog2").click(function(){
          $("#dialog2").dialog('open');
        });
   });
   
 //fungsi untuk menggenerate NO REKENING
    $(function(){
    
      $("#product2").change(function(){
        var product = $("#product2").val();
          product_code = product.substring(1,5);
        var cif_no = $("#cif_no2").val();  
        //mendapatkan jumlah maksimal sesuai product_code yang dipilih
        $.ajax({
          url: site_url+"transaction/count_cif_by_product_code_financing",
          type: "POST",
          dataType: "json",
          data: {product_code:product_code},
          success: function(response)
          {
            var data = response.jumlah;
            if(data==null)
            {
              var total = 0;
            }
            else
            {
              var total = data;
            }
            var jumlah = parseFloat(total); 
            var no_urut = jumlah+1;
            //fungsi untuk menggabungkan semua variabel (menggenerate NO REKENING)
            $("#account_financing_no2").val(cif_no+''+product_code+''+no_urut);
          }
        })         
        
          });
    
    });

//fungsi untuk menggenerate Nama Akad
    $(function(){

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
            if(data>2)
            {
              $("#nisbah2").show();
            }
            else
            {
              $("#nisbah2").hide();
            }
          }
        })         
        
          });

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
              cif_no: {
                  required: true
              },
          },


          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"transaction/verifikasi_rek_pembiayaan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.trigger('reset');
                  form2.find('.control-group').removeClass('success');
                  $("#cancel",form_edit).trigger('click');
				  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo(form2, -200);
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
        App.scrollTo(0, -200);
        $("#edit").hide();
        $("#wrapper-table").show();
        table.fnReloadAjax();
        success2.hide();
        error2.hide();
      });





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var account_financing_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_rekening_pembiayaan",
              dataType: "json",
              data: {account_financing_id:account_financing_id},
              success: function(response){
                if(response.success==true){
                  $("#cancel",form_edit).trigger('click')
                  alert("Deleted!");
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

      $("#btn_reject").click(function(){

        var account_financing_id = $("#account_financing_id").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"transaction/delete_rek_pembiayaan",
              type: "POST",
              dataType: "json",
              data: {account_financing_id:account_financing_id},
              success: function(response){
                if(response.success==true){
                  alert("Reject Success!");
                }else{
                  alert("Reject Failed!");
                }
                $("#cancel").trigger('click');
                App.scrollTo(0,0);
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          
        }

      });






      $("#btn_activate").click(function(){

        var account_financing_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_id.length==0){
          alert("Please select some row to Approve !");
        }else{
          var conf = confirm('Are you sure to Approve this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/verifikasi_rekening_pembiayaan",
              dataType: "json",
              data: {account_financing_id:account_financing_id},
              success: function(response){
                if(response.success==true){
                  alert("Approve!");
                  table.fnReloadAjax();
                }else{
                  alert("Approve Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      $("#btn_inactivate").click(function(){

        var account_financing_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_id.length==0){
          alert("Please select some row to Inapprove !");
        }else{
          var conf = confirm('Are you sure to Inapprove this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/in_verifikasi_rekening_pembiayaan",
              dataType: "json",
              data: {account_financing_id:account_financing_id},
              success: function(response){
                if(response.success==true){
                  alert("Inapprove!");
                  table.fnReloadAjax();
                }else{
                  alert("Inapprove Failed!");
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
      table=$('#rekening_pembiayaan_table').dataTable({
          "bDestroy":true,
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_rekening_ver_pembiayaan_setup",
          "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "param_tanggal_akad", "value": datepicker_replace($("#param_tanggal_akad").val()) } );
              aoData.push( { "name": "param_branch_code", "value": $("#param_branch_code").val() } );
          },
          "aoColumns": [
			      // null,
            null,
            null,
            null,
            null,
            // null,
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [30, 45, -1],
              [30, 45, "All"] // change per page values here
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
      // $(".dataTables_length,.dataTables_filter").parent().hide();

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
</script>
<!-- END JAVASCRIPTS -->

