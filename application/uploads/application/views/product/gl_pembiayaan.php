<?php 
  $CI = get_instance();
?>
<style type="text/css">
.table th, .table td {
    border-top: 1px solid #fff;
    border-bottom: 1px solid #ddd;
    line-height: 12px;
    padding: 5px;
    text-align: left;
    vertical-align: top;
    font: 12px Tahoma;
}
</style>
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
      Product Setup <small>GL Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">GL Pembiayaan Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>GL Pembiayaan</div>
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
      <table class="table table-striped table-bordered table-hover" id="produk_tabungan">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#produk_tabungan .checkboxes" /></th>
               <th width="25%">Kode Produk</th>
               <th width="40%">Deskripsi</th>
               <th>Detail</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Tambah GL Pembiayaan</div>
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
               Produk Tabungan Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Jenis GL</label>
               <div class="controls">
                  <select name="jenis_gl" id="jenis_gl" class="chosen medium m-wrap" data-required="1">
                     <option value="0">Kelompok</option>
                     <option value="1">Individu</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_financing_gl_code" id="product_financing_gl_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Description<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="description" id="description" data-required="1" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">GL Saldo Pokok</label>
               <div class="controls">
                  <select name="gl_saldo_pokok" id="gl_saldo_pokok" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Margin</label>
               <div class="controls">
                  <select name="gl_saldo_margin" id="gl_saldo_margin" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Catab</label>
               <div class="controls">
                  <select name="gl_saldo_catab" id="gl_saldo_catab" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Wajib</label>
               <div class="controls">
                  <select name="gl_saldo_tab_wajib" id="gl_saldo_tab_wajib" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Kelompok</label>
               <div class="controls">
                  <select name="gl_saldo_tab_kelompok" id="gl_saldo_tab_kelompok" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Sukarela</label>
               <div class="controls">
                  <select name="gl_saldo_tab_sukarela" id="gl_saldo_tab_sukarela" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Cadangan Resiko</label>
               <div class="controls">
                  <select name="gl_saldo_cad_resiko" id="gl_saldo_cad_resiko" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pendapatan Pembiayaan</label>
               <div class="controls">
                  <select name="gl_pendapatan_margin" id="gl_pendapatan_margin" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pendapatan Admin</label>
               <div class="controls">
                  <select name="gl_pendapatan_adm" id="gl_pendapatan_adm" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Asuransi Jiwa</label>
               <div class="controls">
                  <select name="gl_asuransi_jiwa" id="gl_asuransi_jiwa" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Asuransi Jaminan</label>
               <div class="controls">
                  <select name="gl_asuransi_jaminan" id="gl_asuransi_jaminan" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Biaya CPP</label>
               <div class="controls">
                  <select name="gl_biaya_cpp" id="gl_biaya_cpp" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL CPP</label>
               <div class="controls">
                  <select name="gl_cpp" id="gl_cpp" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Biaya Notaris</label>
               <div class="controls">
                  <select name="gl_biaya_notaris" id="gl_biaya_notaris" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Titipan Wakalah</label>
               <div class="controls">
                  <select name="gl_titipan_wakalah" id="gl_titipan_wakalah" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Persediaan MBA</label>
               <div class="controls">
                  <select name="gl_persediaan_mba" id="gl_persediaan_mba" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Uang Muka</label>
               <div class="controls">
                  <select name="gl_uangmuka" id="gl_uangmuka" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Mukasah</label>
               <div class="controls">
                  <select name="gl_mukasah" id="gl_mukasah" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Simpanan Wajib Pinjam</label>
               <div class="controls">
                  <select name="gl_simpanan_wajib_pinjam" id="gl_simpanan_wajib_pinjam" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Denda</label>
               <div class="controls">
                  <select name="gl_denda" id="gl_denda" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
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


<!-- DIALOG DETAIL -->
<div id="dialog_detail" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-250px;">
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Detail GL Pembiayaan</h3>
 </div>
 <div class="modal-body">
    <div class="row-fluid">
       <div class="span12">
          <label id="gl_detail"></label> 
       </div>
    </div>
 </div>
 <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
 </div>
</div>  
<!-- END DIALOG DETAIL -->


<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit GL Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="product_financing_gl_id2" name="product_financing_gl_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk Tabungan Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Jenis GL</label>
               <div class="controls">
                  <select name="jenis_gl" id="jenis_gl2" class="chosen medium m-wrap" data-required="1">
                     <option value="0">Kelompok</option>
                     <option value="1">Individu</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_financing_gl_code" id="product_financing_gl_code2" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="5" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Description<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="description" id="description2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">GL Saldo Pokok</label>
               <div class="controls">
                  <select name="gl_saldo_pokok" id="gl_saldo_pokok2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Margin</label>
               <div class="controls">
                  <select name="gl_saldo_margin" id="gl_saldo_margin2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Catab</label>
               <div class="controls">
                  <select name="gl_saldo_catab" id="gl_saldo_catab2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Wajib</label>
               <div class="controls">
                  <select name="gl_saldo_tab_wajib" id="gl_saldo_tab_wajib2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Kelompok</label>
               <div class="controls">
                  <select name="gl_saldo_tab_kelompok" id="gl_saldo_tab_kelompok2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Tabungan Sukarela</label>
               <div class="controls">
                  <select name="gl_saldo_tab_sukarela" id="gl_saldo_tab_sukarela2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Saldo Cadangan Resiko</label>
               <div class="controls">
                  <select name="gl_saldo_cad_resiko" id="gl_saldo_cad_resiko2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pendapatan Pembiayaan</label>
               <div class="controls">
                  <select name="gl_pendapatan_margin" id="gl_pendapatan_margin2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Pendapatan Admin</label>
               <div class="controls">
                  <select name="gl_pendapatan_adm" id="gl_pendapatan_adm2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Asuransi Jiwa</label>
               <div class="controls">
                  <select name="gl_asuransi_jiwa" id="gl_asuransi_jiwa2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Asuransi Jaminan</label>
               <div class="controls">
                  <select name="gl_asuransi_jaminan" id="gl_asuransi_jaminan2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Biaya CPP</label>
               <div class="controls">
                  <select name="gl_biaya_cpp" id="gl_biaya_cpp2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL CPP</label>
               <div class="controls">
                  <select name="gl_cpp" id="gl_cpp2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Biaya Notaris</label>
               <div class="controls">
                  <select name="gl_biaya_notaris" id="gl_biaya_notaris2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Titipan Wakalah</label>
               <div class="controls">
                  <select name="gl_titipan_wakalah" id="gl_titipan_wakalah2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Persediaan MBA</label>
               <div class="controls">
                  <select name="gl_persediaan_mba" id="gl_persediaan_mba2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Uang Muka</label>
               <div class="controls">
                  <select name="gl_uangmuka" id="gl_uangmuka2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Mukasah</label>
               <div class="controls">
                  <select name="gl_mukasah" id="gl_mukasah2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Simpanan Wajib Pinjam</label>
               <div class="controls">
                  <select name="gl_simpanan_wajib_pinjam" id="gl_simpanan_wajib_pinjam2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Denda</label>
               <div class="controls">
                  <select name="gl_denda" id="gl_denda2" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
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
        var tbl_id = 'produk_tabungan';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#produk_tabungan .group-checkable').live('change',function () {
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

      $("#produk_tabungan .checkboxes").livequery(function(){
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
        $("#rencana").hide();
      });

      // UNTUK MENGHILANGKAN BEBERAPA FIELD GL
      $("#jenis_gl","#form_add").change(function()
      {
        var jenis_gl = $("#jenis_gl","#form_add").val();
          if (jenis_gl=='0')
          {
            $("#gl_saldo_tab_wajib","#form_add").parent().parent().show();
            $("#gl_saldo_tab_kelompok","#form_add").parent().parent().show();
            $("#gl_saldo_tab_sukarela","#form_add").parent().parent().show();
          }
          else
          {
            $("#gl_saldo_tab_wajib","#form_add").parent().parent().show();
            $("#gl_saldo_tab_kelompok","#form_add").parent().parent().show();
            $("#gl_saldo_tab_sukarela","#form_add").parent().parent().hide();
            $("#gl_saldo_tab_wajib","#form_add").val("");
            $("#gl_saldo_tab_kelompok","#form_add").val("");
            $("#gl_saldo_tab_sukarela","#form_add").val("");
          }
      });
      // UNTUK MENGHILANGKAN BEBERAPA FIELD GL
      $("#jenis_gl2","#form_edit").change(function()
      {
        var jenis_gl2 = $("#jenis_gl2","#form_edit").val();
          if (jenis_gl2=='0') 
          {
            $("#gl_saldo_tab_wajib2","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_kelompok2","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_sukarela2","#form_edit").parent().parent().show();
          }
          else
          {
            $("#gl_saldo_tab_wajib2","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_kelompok2","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_sukarela2","#form_edit").parent().parent().hide();
            $("#gl_saldo_tab_wajib2","#form_edit").val("");
            $("#gl_saldo_tab_kelompok2","#form_edit").val("");
            $("#gl_saldo_tab_sukarela2","#form_edit").val("");
          }
      });

      // if (true) 
      // {

      // } 
      // else
      // {

      // }
      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              product_financing_gl_code: {
                  required: true,
                  minlength: 4,
                  maxlength: 5
              },
              description: {
                  required: true
              }
              // ,
              // gl_saldo_pokok: {
              //     required: true
              // },
              // gl_saldo_margin: {
              //     required: true
              // },
              // gl_saldo_catab: {
              //     required: true
              // },
              // // gl_saldo_tab_wajib: {
              // //     required: true
              // // },
              // // gl_saldo_tab_kelompok: {
              // //     required: true
              // // },
              // // gl_saldo_tab_sukarela: {
              // //     required: true
              // // },
              // gl_saldo_cad_resiko: {
              //     required: true
              // },
              // gl_pendapatan_margin: {
              //     required: true
              // },
              // gl_pendapatan_adm: {
              //     required: true
              // },
              // gl_asuransi_jiwa: {
              //     required: true
              // },
              // gl_asuransi_jaminan: {
              //     required: true
              // },
              // gl_biaya_cpp: {
              //     required: true
              // },
              // gl_cpp: {
              //     required: true
              // },
              // gl_biaya_notaris: {
              //     required: true
              // }
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

            $.ajax({
              type: "POST",
              url: site_url+"product/add_produk_gl_pembiayaan",
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
              },
              error:function(){
                  success1.hide();
                  error1.show();
              }
            });

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


      // event button DETAIL ketika di tekan
      $("a#link-detail").live('click',function(){
        var product_financing_gl_id = $(this).attr('product_financing_gl_id');
        
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_financing_gl_id:product_financing_gl_id},
          url: site_url+"product/get_financing_gl_by_product_id_view",
          success: function(response)
          {
            var a = response.product_financing_gl_id;   
            var html = ' \
                        <table class="table"> \
                        <tr>  \
                          <td width="40%">Kode Produk</td> \
                          <td>:</td> \
                          <td>'+response.product_financing_gl_code+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Description</td> \
                          <td>:</td> \
                          <td>'+response.description+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Pokok</td> \
                          <td>:</td> \
                          <td>'+response.gl_saldo_pokok+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Margin</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_margin==null)?"-":response.gl_saldo_margin)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Catab</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_catab==null)?"-":response.gl_saldo_catab)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Tabungan Wajib</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_tab_wajib==null)?"-":response.gl_saldo_tab_wajib)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Tabungan Kelompok</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_tab_kelompok==null)?"-":response.gl_saldo_tab_kelompok)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Tabungan Sukarela</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_tab_sukarela==null)?"-":response.gl_saldo_tab_sukarela)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Saldo Cadangan Resiko</td> \
                          <td>:</td> \
                          <td>'+((response.gl_saldo_cad_resiko==null)?"-":response.gl_saldo_cad_resiko)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Pendapatan Pembiayaan</td> \
                          <td>:</td> \
                          <td>'+((response.gl_pendapatan_margin==null)?"-":response.gl_pendapatan_margin)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Pendapatan Admin</td> \
                          <td>:</td> \
                          <td>'+((response.gl_pendapatan_adm==null)?"-":response.gl_pendapatan_adm)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Asuransi Jiwa</td> \
                          <td>:</td> \
                          <td>'+((response.gl_asuransi_jiwa==null)?"-":response.gl_asuransi_jiwa)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Asuransi Jaminan</td> \
                          <td>:</td> \
                          <td>'+((response.gl_asuransi_jaminan==null)?"-":response.gl_asuransi_jaminan)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Biaya CPP</td> \
                          <td>:</td> \
                          <td>'+((response.gl_biaya_cpp==null)?"-":response.gl_biaya_cpp)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">CPP</td> \
                          <td>:</td> \
                          <td>'+((response.gl_cpp==null)?"-":response.gl_cpp)+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Biaya Notaris</td> \
                          <td>:</td> \
                          <td>'+((response.gl_biaya_notaris==null)?"-":response.gl_biaya_notaris)+'</td> \
                        </tr> \
                        </table> ';
            $("#gl_detail").html(html);     
          }
        });

      });


       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var product_financing_gl_id = $(this).attr('product_financing_gl_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_financing_gl_id:product_financing_gl_id},
          url: site_url+"product/get_financing_gl_by_product_id",
          success: function(response)
          {
            if (response.gl_saldo_tab_sukarela==null ) 
            {                
              $("#jenis_gl2, #form_edit").val("1").trigger('change').trigger('liszt:updated'); 
              $("#gl_saldo_tab_wajib2, #form_edit").closest('.control-group').show();
              $("#gl_saldo_tab_kelompok2, #form_edit").closest('.control-group').show();
              $("#gl_saldo_tab_sukarela2, #form_edit").closest('.control-group').hide();
            }
            else
            {
              $("#jenis_gl2, #form_edit").val("0").trigger('change').trigger('liszt:updated'); 
              $("#gl_saldo_tab_wajib2, #form_edit").closest('.control-group').show();
              $("#gl_saldo_tab_kelompok2, #form_edit").closest('.control-group').show();
              $("#gl_saldo_tab_sukarela2, #form_edit").closest('.control-group').show();             
            }
            $("#product_financing_gl_id2, #form_edit").val(response.product_financing_gl_id); 
            $("#product_financing_gl_code2, #form_edit").val(response.product_financing_gl_code); 
            $("#description2, #form_edit").val(response.description); 
            $("#gl_saldo_pokok2, #form_edit").val(response.gl_saldo_pokok).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_margin2, #form_edit").val(response.gl_saldo_margin).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_catab2, #form_edit").val(response.gl_saldo_catab).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_tab_wajib2, #form_edit").val(response.gl_saldo_tab_wajib).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_tab_kelompok2, #form_edit").val(response.gl_saldo_tab_kelompok).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_tab_sukarela2, #form_edit").val(response.gl_saldo_tab_sukarela).trigger('change').trigger('liszt:updated'); 
            $("#gl_saldo_cad_resiko2, #form_edit").val(response.gl_saldo_cad_resiko).trigger('change').trigger('liszt:updated'); 
            $("#gl_pendapatan_margin2, #form_edit").val(response.gl_pendapatan_margin).trigger('change').trigger('liszt:updated'); 
            $("#gl_pendapatan_adm2, #form_edit").val(response.gl_pendapatan_adm).trigger('change').trigger('liszt:updated'); 
            $("#gl_asuransi_jiwa2, #form_edit").val(response.gl_asuransi_jiwa).trigger('change').trigger('liszt:updated'); 
            $("#gl_asuransi_jaminan2, #form_edit").val(response.gl_asuransi_jaminan).trigger('change').trigger('liszt:updated'); 
            $("#gl_biaya_cpp2, #form_edit").val(response.gl_biaya_cpp).trigger('change').trigger('liszt:updated'); 
            $("#gl_cpp2, #form_edit").val(response.gl_cpp).trigger('change').trigger('liszt:updated'); 
            $("#gl_biaya_notaris2, #form_edit").val(response.gl_biaya_notaris).trigger('change').trigger('liszt:updated'); 
            $("#gl_titipan_wakalah2, #form_edit").val(response.gl_titipan_wakalah).trigger('change').trigger('liszt:updated'); 
            $("#gl_persediaan_mba2, #form_edit").val(response.gl_persediaan_mba).trigger('change').trigger('liszt:updated'); 
            $("#gl_uangmuka2, #form_edit").val(response.gl_uangmuka).trigger('change').trigger('liszt:updated'); 
            $("#gl_mukasah2, #form_edit").val(response.gl_mukasah).trigger('change').trigger('liszt:updated'); 
            $("#gl_simpanan_wajib_pinjam2, #form_edit").val(response.gl_simpanan_wajib_pinjam).trigger('change').trigger('liszt:updated'); 
            $("#gl_denda2, #form_edit").val(response.gl_denda).trigger('change').trigger('liszt:updated'); 
          }
        });

      });

      // UNTUK MENGHILANGKAN BEBERAPA FIELD GL
      $("#jenis_gl2","#form_edit").change(function()
      {
        var jenis_gl2 = $("#jenis_gl2","#form_edit").val();
          if (jenis_gl2=='0') 
          {
            $("#gl_saldo_tab_wajib","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_kelompok","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_sukarela","#form_edit").parent().parent().show();
          }
          else
          {
            $("#gl_saldo_tab_wajib","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_kelompok","#form_edit").parent().parent().show();
            $("#gl_saldo_tab_sukarela","#form_edit").parent().parent().hide();
            $("#gl_saldo_tab_wajib","#form_edit").val("");
            $("#gl_saldo_tab_kelompok","#form_edit").val("");
            $("#gl_saldo_tab_sukarela","#form_edit").val("");
          }
      });


      $("#jenis_tabungan2").change(function()
      {
        var jenis = $("#jenis_tabungan2").val();
          if (jenis=='1') 
          {
            $("#rencana2").show()
          }
          else
          {            
            $("#rencana2").hide();
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
              product_financing_gl_code: {
                  required: true,
                  minlength: 4,
                  maxlength: 5
              },
              description: {
                  required: true
              }
              // ,
              // gl_saldo_pokok: {
              //     required: true
              // },
              // gl_saldo_margin: {
              //     required: true
              // },
              // gl_saldo_catab: {
              //     required: true
              // },
              // // gl_saldo_tab_wajib: {
              // //     required: true
              // // },
              // // gl_saldo_tab_kelompok: {
              // //     required: true
              // // },
              // // gl_saldo_tab_sukarela: {
              // //     required: true
              // // },
              // gl_saldo_cad_resiko: {
              //     required: true
              // },
              // gl_pendapatan_margin: {
              //     required: true
              // },
              // gl_pendapatan_adm: {
              //     required: true
              // },
              // gl_asuransi_jiwa: {
              //     required: true
              // },
              // gl_asuransi_jaminan: {
              //     required: true
              // },
              // gl_biaya_cpp: {
              //     required: true
              // },
              // gl_cpp: {
              //     required: true
              // },
              // gl_biaya_notaris: {
              //     required: true
              // }
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

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"product/edit_produk_gl_pembiayaan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#produk_tabungan_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
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

        var product_financing_gl_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          product_financing_gl_id[$i] = $(this).val();

          $i++;

        });

        if(product_financing_gl_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"product/delete_produk_gl_pembiayaan",
              dataType: "json",
              data: {product_financing_gl_id:product_financing_gl_id},
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
      $('#produk_tabungan').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"product/datatable_produk_gl_pembiayaan",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false }
            ,null
            ,null
            ,{ "bSortable": false, "bSearchable": false }
            ,{ "bSortable": false, "bSearchable": false }
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

      


      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

