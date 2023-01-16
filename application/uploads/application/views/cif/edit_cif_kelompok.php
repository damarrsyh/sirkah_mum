<?php $CI = get_instance(); ?>
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
      Customer Information File (CIF) <small>Pembaharuan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Customer Information File (CIF)</a></li>  
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<input type="hidden" id="default_setoran_lwk" value="<?php echo $default_setoran_lwk; ?>">
<input type="hidden" id="default_minggon" value="<?php echo $default_minggon; ?>">



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pembaharuan Customer Information File</div>
      <div class="tools">
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">

         <label>
            Rembug Pusat &nbsp; : &nbsp;
            <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled>
            <input type="hidden" name="cm_code" id="cm_code">
            <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         </label>
      </div>

      <!-- END EDIT USER -->
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Rembug</h3>
         </div>
         <div class="modal-body">
            <div class="row-fluid">
               <div class="span12">
                  <h4>Masukan Kata Kunci</h4>
                  <input type="hidden" name="branch" value="<?php echo $branch; ?>">
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"><br><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      

      <table class="table table-striped table-bordered table-hover" id="user_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#user_table .checkboxes" /></th>
               <th width="15%">NO. CIF</th>
               <th width="20%">Nama Lengkap</th>
               <th width="20%">Rembug</th>
               <th width="20%">No. Urut Kelompok</th>
               <th>Status</th>
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
   
   <div class="portlet box green" id="wizard_add_participant">
      <div class="portlet-title">
         <div class="caption">
            <i class="icon-reorder"></i> Add CIF <span class="rembug"></span> - <span class="step-title">Step 1 of 4</span>
         </div>
         <div class="tools hidden-phone">
            <a href="javascript:;" id="back" style="color:white;font-size:15px;"> < Back </a>
         </div>
      </div>
      <div class="portlet-body form">
         <form action="<?php echo site_url('cif/add_cif_kelompok'); ?>" method="post" id="form_add" class="form-horizontal">
            <input type="hidden" id="add_cm_code" name="add_cm_code">
            <div class="form-wizard">
               <div class="navbar steps">
                  <div class="navbar-inner">
                     <ul class="row-fluid">
                        <li class="span3">
                           <a href="#tab1" style="cursor:default;" data-toggle="tab" class="step active">
                           <span class="number">1</span>
                           <span class="desc"><i class="icon-ok"></i> Step 1</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#tab2" style="cursor:default;" data-toggle="tab" class="step">
                           <span class="number">2</span>
                           <span class="desc"><i class="icon-ok"></i> Step 2</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#tab3" style="cursor:default;" data-toggle="tab" class="step">
                           <span class="number">3</span>
                           <span class="desc"><i class="icon-ok"></i> Step 3</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#tab4" style="cursor:default;" data-toggle="tab" class="step">
                           <span class="number">4</span>
                           <span class="desc"><i class="icon-ok"></i> Finish</span>   
                           </a> 
                        </li>
                     </ul>
                  </div>
               </div>
               <div id="bar" class="progress progress-success progress-striped">
                  <div class="bar"></div>
               </div>
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <div class="alert alert-success hide">
                  <button class="close" data-dismiss="alert"></button>
                  New CIF Has Been Created !
               </div>
               <div class="tab-content">
                  <div class="tab-pane active" id="tab1">
                     <!-- <h3 class="block">Provide your account details</h3> -->
                     <!-- <div class="control-group">
                        <label class="control-label">No. Costumer</label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_cif_no" id="step1_cif_no" />
                           <span class="help-inline"></span>
                        </div>
                     </div> -->
                     <div class="control-group">
                        <label class="control-label">Tanggal Gabung <span class="required">*</span></label>
                        <div class="controls">
                           <input type="text" class="small m-wrap date-picker" name="step1_tanggal_gabung" id="mask_date" maxlength="10" value="<?php echo $CI->format_date_detail($current_date,'id',false,'/'); ?>" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Lengkap <span class="required">*</span><br><small>(Sesuai KTP)</small></label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_nama" id="step1_nama" maxlength="50" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Panggilan <span class="required">*</span></label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_panggilan" id="step1_panggilan" maxlength="30" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">No. Urut Kelompok <span class="required">*</span></label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step1_kelompok" id="step1_kelompok" style="width:50px;" maxlength="10" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Setoran LWK <span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step1_setoran_lwk" id="step1_setoran_lwk" maxlength="7" value="0">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Setoran Mingguan <span class="required">*</span></label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step1_setoran_mingguan" id="step1_setoran_mingguan" maxlength="7" value="0">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab2">
                     <h3 class="block">Data Pribadi</h3>
                     <div class="control-group">
                        <label class="control-label">Jenis Kelamin <span class="required">*</span></label>
                        <div class="controls">
                           <label class="radio">
                             <input type="radio" name="step2_pribadi_jenis_kelamin" id="step2_pribadi_jenis_kelamin1" value="P" />
                             Pria
                           </label>
                           <div class="clearfix"></div>
                           <label class="radio">
                             <input type="radio" name="step2_pribadi_jenis_kelamin" id="step2_pribadi_jenis_kelamin2" value="W" checked />
                             Wanita
                           </label>  
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Ibu Kandung</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step2_pribadi_ibu_kandung" id="step2_pribadi_ibu_kandung" maxlength="50" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tempat Lahir</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_tmp_lahir" id="step2_pribadi_tmp_lahir" maxlength="30" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tanggal Lahir/Usia <span class="required">*</span><br><small>(dd/mm/yyyy)</small></label>
                        <div class="controls">
                           <input type="text" class="small m-wrap date-picker" name="step2_pribadi_tgl_lahir" id="mask_date" />
                           &nbsp;
                           <input type="text" class=" m-wrap" name="step2_pribadi_usia" id="step2_pribadi_usia" maxlength="3" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <h5>:: Alamat Rumah</h5>
                     <div class="control-group">
                        <label class="control-label">Alamat<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <textarea name="step2_pribadi_alamat" id="step2_pribadi_alamat" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">RT / RW<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" name="step2_pribadi_rt" id="step2_pribadi_rt" class="m-wrap" maxlength="4" style="width:30px;">
                           &nbsp;
                           <input type="text" name="step2_pribadi_rw" id="step2_pribadi_rw" class="m-wrap" maxlength="4" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Desa<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_desa" id="step2_pribadi_desa" maxlength="30" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kecamatan<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kecamatan" id="step2_pribadi_kecamatan" maxlength="30" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kabupaten/Kota<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kabupaten" id="step2_pribadi_kabupaten" maxlength="30" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kode Pos<br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kodepos" id="step2_pribadi_kodepos" maxlength="6" />
                        </div>
                     </div>
                     <h5>:: Alamat Surat Menyurat <br><small><input type="checkbox" id="sama" name="sama">Sama dengan Alamat Rumah</small></h5>
                     <div class="control-group">
                        <label class="control-label">Alamat<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <textarea name="step2_pribadi_koresponden_alamat" id="step2_pribadi_koresponden_alamat" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">RT / RW<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" name="step2_pribadi_koresponden_rt" id="step2_pribadi_koresponden_rt" maxlength="4" class="m-wrap" style="width:30px;">
                           &nbsp;
                           <input type="text" name="step2_pribadi_koresponden_rw" id="step2_pribadi_koresponden_rw" maxlength="4" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Desa<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_desa" id="step2_pribadi_koresponden_desa" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kecamatan<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kecamatan" maxlength="30" id="step2_pribadi_koresponden_kecamatan" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kabupaten/Kota<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kabupaten" maxlength="30" id="step2_pribadi_koresponden_kabupaten" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kode Pos<br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kodepos" maxlength="6" id="step2_pribadi_koresponden_kodepos" />
                        </div>
                     </div>

                     <div class="control-group">
                        <label class="control-label">Pendidikan</label>
                        <div class="controls">
                           <select name="step2_pribadi_pendidikan" id="step2_pribadi_pendidikan">
                             <option value="">Silahkan Pilih</option>
                             <option>Tdk Sekolah</option>
                             <option>SD</option>
                             <option>SMP</option>
                             <option>SMA</option>
                             <option>D1</option>
                             <option>D2</option>
                             <option>D3</option>
                             <option>S1</option>
                             <option>S2</option>
                             <option>S3</option>
                           </select>
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekerjaan</label>
                        <div class="controls">
                           <select name="step2_pribadi_pekerjaan" id="step2_pribadi_pekerjaan">
                             <option value="">Silahkan Pilih</option>
                             <option>IRT</option>
                             <option>BURUH</option>
                             <option>Petani</option>
                             <option>Pedagang</option>
                             <option>Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendapatan (perhari)</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step2_pribadi_pendapatan" id="step2_pribadi_pendapatan" maxlength="10" value="0">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Keterangan Pekerjaan</label>
                        <div class="controls">
                           <textarea name="step2_pribadi_ket_pekerjaan" id="step2_pribadi_ket_pekerjaan" maxlength="50" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Literasi </label>
                        <div class="controls">
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pribadi_literasi_latin" id="step2_pribadi_literasi_latin" value="1" /> Baca Tulis Latin
                           </label>
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pribadi_literasia_arab" id="step2_pribadi_literasia_arab" value="1" /> Baca Tulis arab
                           </label>
                        </div>
                     </div>
                     <!-- Data Pasangan -->
                     <h3 class="block">Data Pasangan</h3>
                     <div class="control-group">
                        <label class="control-label">Nama</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pasangan_nama" id="step2_pasangan_nama" maxlength="50" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tempat Lahir</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pasangan_tmplahir" id="step2_pasangan_tmplahir" maxlength="30" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tanggal Lahir/Usia <br><small>(dd/mm/yyyy)</small></label>
                        <div class="controls">
                           <input type="text" class="small m-wrap date-picker" name="step2_pasangan_tglahir" id="mask_date" />
                           &nbsp;
                           <input type="text" class=" m-wrap" name="step2_pasangan_usia" id="step2_pasangan_usia" maxlength="3" style="width:30px;" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendidikan</label>
                        <div class="controls">
                           <select name="step2_pasangan_pendidikan" id="step2_pasangan_pendidikan">
                             <option value="">Silahkan Pilih</option>
                             <option>Tdk Sekolah</option>
                             <option>SD</option>
                             <option>SMP</option>
                             <option>SMA</option>
                             <option>D1</option>
                             <option>D2</option>
                             <option>D3</option>
                             <option>S1</option>
                             <option>S2</option>
                             <option>S3</option>
                           </select>
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekerjaan</label>
                        <div class="controls">
                           <select name="step2_pasangan_pekerjaan" id="step2_pasangan_pekerjaan">
                             <option value="">Silahkan Pilih</option>
                             <option>IRT</option>
                             <option>BURUH</option>
                             <option>Petani</option>
                             <option>Pedagang</option>
                             <option>Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendapatan (perhari)</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step2_pasangan_pendapatan" id="step2_pasangan_pendapatan" maxlength="10">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Keterangan Pekerjaan</label>
                        <div class="controls">
                           <textarea name="step2_pasangan_ketpekerjaan" id="step2_pasangan_ketpekerjaan" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Literasi</label>
                        <div class="controls">
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pasangan_literasi_latin" id="step2_pasangan_literasi_latin" value="1" /> Baca Tulis Latin
                           </label>
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pasangan_literasi_arab" id="step2_pasangan_literasi_arab" value="1" /> Baca Tulis arab
                           </label>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jumlah Keluarga</label>
                        <div class="controls">
                           <input type="text" name="step2_pasangan_jmlkeluarga" id="step2_pasangan_jmlkeluarga" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jumlah Tanggungan</label>
                        <div class="controls">
                           <input type="text" name="step2_pasangan_jmltanggungan" id="step2_pasangan_jmltanggungan" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                  </div>
                  <!-- Step 3 asset rumah tangga -->
                  <div class="tab-pane" id="tab3">
                     <h3 class="block">Aset Rumah Tangga</h3>
                     <h3>Rumah</h3>
                     <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls">
                           <select id="step3_rmhstatus" name="step3_rmhstatus">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Rumah Sendiri</option>
                             <option value="1">Sewa</option>
                             <option value="2">Numpang</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Ukuran</label>
                        <div class="controls">
                           <select id="step3_rmhukuran" name="step3_rmhukuran">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Kecil</option>
                             <option value="1">Besar</option>
                             <option value="2">Sedang</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Dinding</label>
                        <div class="controls">
                           <select id="step3_rmhdinding" name="step3_rmhdinding">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Tembok</option>
                             <option value="1">Semi Tembok</option>
                             <option value="2">Papan</option>
                             <option value="3">Bambu</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Atap</label>
                        <div class="controls">
                           <select id="step3_rmhatap" name="step3_rmhatap">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Genteng</option>
                             <option value="1">Asbes</option>
                             <option value="2">Rumbia</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lantai</label>
                        <div class="controls">
                           <select id="step3_rmhlantai" name="step3_rmhlantai">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Tanah</option>
                             <option value="1">Semen</option>
                             <option value="2">Keramik</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jamban</label>
                        <div class="controls">
                           <select id="step3_rmhjamban" name="step3_rmhjamban">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Sungai</option>
                             <option value="1">Jamban Terbuka</option>
                             <option value="2">WC</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Sumber Air</label>
                        <div class="controls">
                           <select id="step3_rmhair" name="step3_rmhair">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Sumur Sendiri</option>
                             <option value="1">Sumur Bersama</option>
                             <option value="2">Sungai</option>
                           </select>
                        </div>
                     </div>
                     <h3>Lahan</h3>
                     <div class="control-group">
                        <label class="control-label">Sawah</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahansawah" id="step3_lahansawah" value="0" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kebun</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahankebun" id="step3_lahankebun" value="0" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekarangan</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahanpekarangan" id="step3_lahanpekarangan" value="0" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <h3>Ternak</h3>
                     <div class="control-group">
                        <label class="control-label">Unggas</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_ternakunggas" id="step3_ternakunggas" value="0" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kambing</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_ternakdomba" id="step3_ternakdomba" value="0" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Sapi/Kerbau</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_sapi_ternakkerbau" id="step3_sapi_ternakkerbau" value="0" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <h3>Kendaraan</h3>
                     <div class="control-group">
                        <label class="control-label">Sepeda</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step3_kendsepeda" id="step3_kendsepeda" maxlength="2" style="width:20px;" value="0" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Motor</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step3_kendmotor" id="step3_kendmotor" maxlength="2" style="width:20px;" value="0" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <h3>Elektronik</h3>
                     <div class="control-group">
                        <label class="control-label">Elektronik</label>
                        <div class="controls">
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elektape" id="step3_elektape" value="1" />
                             Radio/Tape
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elekplayer" id="step3_elekplayer" value="1" />
                             VCD/DVD
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elektv" id="step3_elektv" value="1" />
                             TV
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elekkulkas" id="step3_elekkulkas" value="1" />
                             Kulkas
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="tab4">
                     <h3 class="block">Usaha Rumah Tangga</h3>
                     <div class="control-group">
                        <label class="control-label">Jenis Usaha</label>
                        <div class="controls">
                           <select id="step4_ushrumahtangga" name="step4_ushrumahtangga">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">IRT</option>
                             <option value="1">Buruh</option>
                             <option value="2">Petani</option>
                             <option value="3">Pedagang</option>
                             <option value="4">Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Komoditi</label>
                        <div class="controls">
                           <input type="text" class="large m-wrap" name="step4_ushkomoditi" id="step4_ushkomoditi" maxlength="50" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lokasi</label>
                        <div class="controls">
                           <input type="text" class="large m-wrap" name="step4_ushlokasi" id="step4_ushlokasi" maxlength="50" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Omset</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_ushomset" id="step4_ushomset" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <h3 class="block">Pengeluaran Rumah Tangga</h3>
                     <div class="control-group">
                        <label class="control-label">Konsumsi Beras</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step4_byaberas" id="step4_byaberas" style="width:30px;" value="0" />
                           <span class="help-inline">liter perhari</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Belanja Dapur</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byadapur" id="step4_byadapur" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perhari</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Rekening Listrik</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byalistrik" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Biaya Telpon</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byatelpon" id="step4_byatelpon" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Biaya Pendidikan</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byasekolah" id="step4_byasekolah" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lain-lain</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byalain" id="step4_byalain" maxlength="10" value="0" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-actions clearfix">
                  <!-- <a href="javascript:;" class="btn button-cancel red">
                  <i class="m-icon-swapleft"></i> Cancel 
                  </a> -->
                  <a href="javascript:;" class="btn button-previous">
                  <i class="m-icon-swapleft"></i> Back 
                  </a>
                  <a href="javascript:;" class="btn blue button-next">
                  Continue <i class="m-icon-swapright m-icon-white"></i>
                  </a>
                  <a href="javascript:;" class="btn green button-submit">
                  Submit <i class="m-icon-swapright m-icon-white"></i>
                  </a>
               </div>
            </div>
         </form>
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box green" id="wizard_edit_participant">
      <div class="portlet-title">
         <div class="caption">
            <i class="icon-reorder"></i> Edit CIF <span id="rembug"></span> - <span class="step-title">Step 1 of 4</span>
         </div>
         <div class="tools hidden-phone">
            <a href="javascript:;" id="back" style="color:white;font-size:15px;"> < Back </a>
         </div>
      </div>
      <div class="portlet-body form">
         <form action="<?php echo site_url('cif/edit_cif_kelompok'); ?>" method="post" id="form_edit" class="form-horizontal">
            <input type="hidden" id="edit_cm_code" name="edit_cm_code">
            <input type="hidden" name="cif_id" id="cif_id">
            <div class="form-wizard">
               <div class="navbar steps">
                  <div class="navbar-inner">
                     <ul class="row-fluid">
                        <li class="span3">
                           <a href="#etab1" data-toggle="tab" class="step active">
                           <span class="number">1</span>
                           <span class="desc"><i class="icon-ok"></i> Step 1</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#etab2" data-toggle="tab" class="step">
                           <span class="number">2</span>
                           <span class="desc"><i class="icon-ok"></i> Step 2</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#etab3" data-toggle="tab" class="step">
                           <span class="number">3</span>
                           <span class="desc"><i class="icon-ok"></i> Step 3</span>   
                           </a>
                        </li>
                        <li class="span3">
                           <a href="#etab4" data-toggle="tab" class="step">
                           <span class="number">4</span>
                           <span class="desc"><i class="icon-ok"></i> Finish</span>   
                           </a> 
                        </li>
                     </ul>
                  </div>
               </div>
               <div id="bar" class="progress progress-success progress-striped">
                  <div class="bar"></div>
               </div>
               <div class="alert alert-error hide">
                  <button class="close" data-dismiss="alert"></button>
                  You have some form errors. Please check below.
               </div>
               <div class="alert alert-success hide">
                  <button class="close" data-dismiss="alert"></button>
                  Edit CIF Successed !
               </div>
               <div class="tab-content">
                  <div class="tab-pane active" id="etab1">
                     <!-- <h3 class="block">Provide your account details</h3> -->
                     <!-- <div class="control-group">
                        <label class="control-label">No. Costumer</label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_cif_no" id="step1_cif_no" />
                           <span class="help-inline"></span>
                        </div>
                     </div> -->
                     <div class="control-group">
                        <label class="control-label">Tanggal Gabung</label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap date-picker" name="step1_tanggal_gabung" id="mask_date" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Lengkap <br><small>(Sesuai KTP)</small></label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_nama" id="step1_nama" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Panggilan</label>
                        <div class="controls">
                           <input type="text" class="medium m-wrap" name="step1_panggilan" id="step1_panggilan" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">No. Urut Kelompok</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step1_kelompok" id="step1_kelompok" style="width:50px;" maxlength="2" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Setoran LWK</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step1_setoran_lwk" id="step1_setoran_lwk" maxlength="22">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Setoran Mingguan</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step1_setoran_mingguan" id="step1_setoran_mingguan" maxlength="22">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="etab2">
                     <h3 class="block">Data Pribadi</h3>
                     <div class="control-group">
                        <label class="control-label">Jenis Kelamin</label>
                        <div class="controls">
                           <label class="radio">
                             <input type="radio" name="step2_pribadi_jenis_kelamin" id="step2_pribadi_jenis_kelamin1" value="P" checked />
                             Pria
                           </label>
                           <div class="clearfix"></div>
                           <label class="radio">
                             <input type="radio" name="step2_pribadi_jenis_kelamin" id="step2_pribadi_jenis_kelamin2" value="W" />
                             Wanita
                           </label>  
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Nama Ibu Kandung</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step2_pribadi_ibu_kandung" id="step2_pribadi_ibu_kandung" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tempat Lahir</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_tmp_lahir" id="step2_pribadi_tmp_lahir" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tanggal Lahir/Usia <br><small>(dd/mm/yyyy)</small></label>
                        <div class="controls">
                           <input type="text" class="small m-wrap date-picker" name="step2_pribadi_tgl_lahir" id="mask_date" />
                           &nbsp;
                           <input type="text" class=" m-wrap" name="step2_pribadi_usia" id="step2_pribadi_usia" maxlength="3" style="width:30px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <h5>:: Alamat Rumah</h5>
                     <div class="control-group">
                        <label class="control-label">Alamat <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <textarea name="step2_pribadi_alamat" id="step2_pribadi_alamat" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">RT / RW <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" name="step2_pribadi_rt" id="step2_pribadi_rt" class="m-wrap" style="width:30px;">
                           &nbsp;
                           <input type="text" name="step2_pribadi_rw" id="step2_pribadi_rw" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Desa <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_desa" id="step2_pribadi_desa" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kecamatan <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kecamatan" id="step2_pribadi_kecamatan" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kabupaten/Kota <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kabupaten" id="step2_pribadi_kabupaten" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kode Pos <br><small>(Rumah)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_kodepos" id="step2_pribadi_kodepos" />
                        </div>
                     </div>
                     <h5>:: Alamat Surat Menyurat <br><small><input type="checkbox" id="sama" name="sama">Sama dengan Alamat Rumah</small></h5>
                     <div class="control-group">
                        <label class="control-label">Alamat <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <textarea name="step2_pribadi_koresponden_alamat" id="step2_pribadi_koresponden_alamat" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">RT / RW <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" name="step2_pribadi_koresponden_rt" id="step2_pribadi_koresponden_rt" class="m-wrap" style="width:30px;">
                           &nbsp;
                           <input type="text" name="step2_pribadi_koresponden_rw" id="step2_pribadi_koresponden_rw" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Desa <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_desa" id="step2_pribadi_koresponden_desa" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kecamatan <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kecamatan" id="step2_pribadi_koresponden_kecamatan" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kabupaten/Kota <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kabupaten" id="step2_pribadi_koresponden_kabupaten" />
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kode Pos <br><small>(Surat Menyurat)</small></label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pribadi_koresponden_kodepos" id="step2_pribadi_koresponden_kodepos" />
                        </div>
                     </div>

                     <div class="control-group">
                        <label class="control-label">Pendidikan</label>
                        <div class="controls">
                           <select name="step2_pribadi_pendidikan" id="step2_pribadi_pendidikan">
                             <option value="">Silahkan Pilih</option>
                             <option>Tdk Sekolah</option>
                             <option>Kelas 1</option>
                             <option>Kelas 2</option>
                             <option>Kelas 3</option>
                             <option>Kelas 4</option>
                             <option>Kelas 5</option>
                             <option>Kelas 6</option>
                             <option>Kelas 7</option>
                             <option>Kelas 8</option>
                             <option>Kelas 9</option>
                             <option>Kelas 10</option>
                             <option>Kelas 11</option>
                             <option>Kelas 12</option>
                             <option>Kelas 13</option>
                           </select>
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekerjaan</label>
                        <div class="controls">
                           <select name="step2_pribadi_pekerjaan" id="step2_pribadi_pekerjaan">
                             <option value="">Silahkan Pilih</option>
                             <option>IRT</option>
                             <option>BURUH</option>
                             <option>Petani</option>
                             <option>Pedagang</option>
                             <option>Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendapatan (perhari)</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step2_pribadi_pendapatan" id="step2_pribadi_pendapatan" maxlength="22">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Keterangan Pekerjaan</label>
                        <div class="controls">
                           <textarea name="step2_pribadi_ket_pekerjaan" id="step2_pribadi_ket_pekerjaan" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Literasi</label>
                        <div class="controls">
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pribadi_literasi_latin" id="step2_pribadi_literasi_latin" value="1" /> Baca Tulis Latin
                           </label>
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pribadi_literasia_arab" id="step2_pribadi_literasia_arab" value="1" /> Baca Tulis arab
                           </label>
                        </div>
                     </div>
                     <!-- Data Pasangan -->
                     <h3 class="block">Data Pasangan</h3>
                     <div class="control-group">
                        <label class="control-label">Nama</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pasangan_nama" id="step2_pasangan_nama" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tempat Lahir</label>
                        <div class="controls">
                           <input type="text" class=" m-wrap" name="step2_pasangan_tmplahir" id="step2_pasangan_tmplahir" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Tanggal Lahir/Usia <br><small>(dd/mm/yyyy)</small></label>
                        <div class="controls">
                           <input type="text" class="small m-wrap date-picker" name="step2_pasangan_tglahir" id="mask_date" />
                           &nbsp;
                           <input type="text" class=" m-wrap" name="step2_pasangan_usia" id="step2_pasangan_usia" maxlength="3" style="width:30px;" />
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendidikan</label>
                        <div class="controls">
                           <select name="step2_pasangan_pendidikan" id="step2_pasangan_pendidikan">
                             <option value="">Silahkan Pilih</option>
                             <option>Tdk Sekolah</option>
                             <option>Kelas 1</option>
                             <option>Kelas 2</option>
                             <option>Kelas 3</option>
                             <option>Kelas 4</option>
                             <option>Kelas 5</option>
                             <option>Kelas 6</option>
                             <option>Kelas 7</option>
                             <option>Kelas 8</option>
                             <option>Kelas 9</option>
                             <option>Kelas 10</option>
                             <option>Kelas 11</option>
                             <option>Kelas 12</option>
                             <option>Kelas 13</option>
                           </select>
                           <!-- <span class="help-inline">Provide your phone number</span> -->
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekerjaan</label>
                        <div class="controls">
                           <select name="step2_pasangan_pekerjaan" id="step2_pasangan_pekerjaan">
                             <option value="">Silahkan Pilih</option>
                             <option>IRT</option>
                             <option>BURUH</option>
                             <option>Petani</option>
                             <option>Pedagang</option>
                             <option>Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pendapatan (perhari)</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" name="step2_pasangan_pendapatan" id="step2_pasangan_pendapatan" maxlength="22">
                             <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Keterangan Pekerjaan</label>
                        <div class="controls">
                           <textarea name="step2_pasangan_ketpekerjaan" id="step2_pasangan_ketpekerjaan" class="large m-wrap"></textarea>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Literasi</label>
                        <div class="controls">
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pasangan_literasi_latin" id="step2_pasangan_literasi_latin" value="1" /> Baca Tulis Latin
                           </label>
                           <label class="checkbox line">
                           <input type="checkbox" name="step2_pasangan_literasi_arab" id="step2_pasangan_literasi_arab" value="1" /> Baca Tulis arab
                           </label>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jumlah Keluarga</label>
                        <div class="controls">
                           <input type="text" name="step2_pasangan_jmlkeluarga" id="step2_pasangan_jmlkeluarga" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jumlah Tanggungan</label>
                        <div class="controls">
                           <input type="text" name="step2_pasangan_jmltanggungan" id="step2_pasangan_jmltanggungan" class="m-wrap" style="width:30px;">
                        </div>
                     </div>
                  </div>
                  <!-- Step 3 asset rumah tangga -->
                  <div class="tab-pane" id="etab3">
                     <h3 class="block">Aset Rumah Tangga</h3>
                     <h3>Rumah</h3>
                     <div class="control-group">
                        <label class="control-label">Status</label>
                        <div class="controls">
                           <select id="step3_rmhstatus" name="step3_rmhstatus">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Rumah Sendiri</option>
                             <option value="1">Sewa</option>
                             <option value="2">Numpang</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Ukuran</label>
                        <div class="controls">
                           <select id="step3_rmhukuran" name="step3_rmhukuran">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Kecil</option>
                             <option value="1">Besar</option>
                             <option value="2">Sedang</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Dinding</label>
                        <div class="controls">
                           <select id="step3_rmhdinding" name="step3_rmhdinding">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Tembok</option>
                             <option value="1">Semi Tembok</option>
                             <option value="2">Papan</option>
                             <option value="3">Bambu</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Atap</label>
                        <div class="controls">
                           <select id="step3_rmhatap" name="step3_rmhatap">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Genteng</option>
                             <option value="1">Asbes</option>
                             <option value="2">Rumbia</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lantai</label>
                        <div class="controls">
                           <select id="step3_rmhlantai" name="step3_rmhlantai">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Tanah</option>
                             <option value="1">Semen</option>
                             <option value="2">Keramik</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Jamban</label>
                        <div class="controls">
                           <select id="step3_rmhjamban" name="step3_rmhjamban">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Sungai</option>
                             <option value="1">Jamban Terbuka</option>
                             <option value="2">WC</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Sumber Air</label>
                        <div class="controls">
                           <select id="step3_rmhair" name="step3_rmhair">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">Sumur Sendiri</option>
                             <option value="1">Sumur Bersama</option>
                             <option value="2">Sungai</option>
                           </select>
                        </div>
                     </div>
                     <h3>Lahan</h3>
                     <div class="control-group">
                        <label class="control-label">Sawah</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahansawah" id="step3_lahansawah" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kebun</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahankebun" id="step3_lahankebun" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Pekarangan</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_lahanpekarangan" id="step3_lahanpekarangan" />
                           <span class="help-inline">meter</span>
                        </div>
                     </div>
                     <h3>Ternak</h3>
                     <div class="control-group">
                        <label class="control-label">Unggas</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_ternakunggas" id="step3_ternakunggas" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Kambing</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_ternakdomba" id="step3_ternakdomba" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Sapi/Kerbau</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap" name="step3_sapi_ternakkerbau" id="step3_sapi_ternakkerbau" />
                           <span class="help-inline">ekor</span>
                        </div>
                     </div>
                     <h3>Kendaraan</h3>
                     <div class="control-group">
                        <label class="control-label">Sepeda</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step3_kendsepeda" id="step3_kendsepeda" maxlength="2" style="width:20px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Motor</label>
                        <div class="controls">
                           <input type="text" class="m-wrap" name="step3_kendmotor" id="step3_kendmotor" maxlength="2" style="width:20px;" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <h3>Elektronik</h3>
                     <div class="control-group">
                        <label class="control-label">Elektronik</label>
                        <div class="controls">
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elektape" id="step3_elektape" value="1" />
                             Radio/Tape
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elekplayer" id="step3_elekplayer" value="1" />
                             VCD/DVD
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elektv" id="step3_elektv" value="1" />
                             TV
                           </label>
                           <div class="clearfix"></div>
                           <label class="checkbox">
                             <input type="checkbox" name="step3_elekkulkas" id="step3_elekkulkas" value="1" />
                             Kulkas
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane" id="etab4">
                     <h3 class="block">Usaha Rumah Tangga</h3>
                     <div class="control-group">
                        <label class="control-label">Jenis Usaha</label>
                        <div class="controls">
                           <select id="step4_ushrumahtangga" name="step4_ushrumahtangga">
                             <option value="">Silahkan Pilih</option>
                             <option value="0">IRT</option>
                             <option value="1">Buruh</option>
                             <option value="2">Petani</option>
                             <option value="3">Pedagang</option>
                             <option value="4">Wiraswasta</option>
                           </select>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Komoditi</label>
                        <div class="controls">
                           <input type="text" class="large m-wrap" name="step4_ushkomoditi" id="step4_ushkomoditi" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lokasi</label>
                        <div class="controls">
                           <input type="text" class="large m-wrap" name="step4_ushlokasi" id="step4_ushlokasi" />
                           <span class="help-inline"></span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Omset</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_ushomset" id="step4_ushomset" />
                              <span class="add-on">,00</span>
                           </div>
                        </div>
                     </div>
                     <h3 class="block">Pengeluaran Rumah Tangga</h3>
                     <div class="control-group">
                        <label class="control-label">Konsumsi Beras</label>
                        <div class="controls">
                           <input type="text" class="small m-wrap mask-money" name="step4_byaberas" id="step4_byaberas" style="width:30px;" />
                           <span class="help-inline">liter perhari</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Belanja Dapur</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byadapur" id="step4_byadapur" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perhari</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Rekening Listrik</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byalistrik" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Biaya Telpon</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byatelpon" id="step4_byatelpon" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Biaya Pendidikan</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byasekolah" id="step4_byasekolah" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                     <div class="control-group">
                        <label class="control-label">Lain-lain</label>
                        <div class="controls">
                           <div class="input-prepend input-append">
                              <span class="add-on">Rp</span>
                              <input type="text" class="medium m-wrap mask-money" name="step4_byalain" id="step4_byalain" />
                              <span class="add-on">,00</span>
                           </div>
                           <span class="help-inline">perbulan</span>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-actions clearfix">
                  <!-- <a href="javascript:;" class="btn button-cancel red">
                  <i class="m-icon-swapleft"></i> Cancel 
                  </a> -->
                  <a href="javascript:;" class="btn button-previous cancel">
                  <i class="m-icon-swapleft"></i> Back 
                  </a>
                  <a href="javascript:;" class="btn blue button-next">
                  Continue <i class="m-icon-swapright m-icon-white"></i>
                  </a>
                  <a href="javascript:;" class="btn green button-submit">
                  Submit <i class="m-icon-swapright m-icon-white"></i>
                  </a>
               </div>
            </div>
         </form>
      </div>
   </div>

</div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/additional-methods.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-components.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>           
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script>   
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modal.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-modal/js/bootstrap-modalmanager.js" type="text/javascript" ></script>
<script src="<?php echo base_url(); ?>assets/scripts/ui-modals.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      Index.init();
      $("input#mask_date").inputmask("d/m/y");  //direct mask    
      // FormComponents.init();
      
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

window.status_added = 0;

$(function(){

      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      $(".button-cancel","#add").click(function(){
         window.location.reload();
         /*$(".bar",".progress").width('25%');
         $(".steps").find('li.span3').removeClass('active').removeClass('done');
         $(".steps").find('li.span3:first-child').addClass('active');
         $(".tab-content","#add").children('.tab-pane').removeClass('active');
         $("#tab1","#add .tab-content").addClass('active');
         success1.hide();
         error1.hide();
         form1.trigger('reset');
         form1.find('div.control-group').removeClass('error');
         form1.find('div.control-group').removeClass('success');
         $("#add").hide();
         $("#wrapper-table").show();
         App.scrollTo($('.page-title'));*/
      });

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

            // begin first table
            $('#user_table').dataTable({
               "bDestroy":true,
               "bProcessing": true,
               "bServerSide": true,
               "sAjaxSource": site_url+"cif/datatable_cif_kelompok",
               "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
                },
               "aoColumns": [
                 null,
                 null,
                 null,
                 null,
                 null,
                 null,
                 { "bSortable": false }
               ],
               "aLengthMenu": [
                   [5, 15, 20, -1],
                   [5, 15, 20, "All"] // change per page values here
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
               "sZeroRecords" : "Data Pada Rembug ini Kosong",
               "aoColumnDefs": [{
                       'bSortable': false,
                       'aTargets': [0]
                   }
               ]
            });
            $(".dataTables_length,.dataTables_filter").parent().hide();


         }
         else
         {
            alert("Please select row first !");
         }

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
      });

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
         $.ajax({
               type: "POST",
               url: site_url+"cif/get_rembug_by_keyword",
               dataType: "json",
               data: {keyword:keyword},
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

      // -------------------------------------------------------------
      // BEGIN FORM WIZARD
      // -------------------------------------------------------------
      if (!jQuery().bootstrapWizard) {
          return;
      }

      // default form wizard
      $('#wizard_add_participant').bootstrapWizard({
          'nextSelector': '.button-next',
          'previousSelector': '.button-previous',
          onTabClick: function (tab, navigation, index) {
              // alert('on tab click disabled');
              return false;
              // console.log(tab);
              // console.log(navigation);
              // console.log(index);
          },
          onNext: function (tab, navigation, index) {
              tabelement = tab.find('a').attr('href');
              if($(tabelement).find('input,textarea,select').valid()==0){
               alert("You have some form errors. Please check again! ");
               return false;
              }
              var total = navigation.find('li').length;
              var current = index + 1;
              // set wizard title
              $('.step-title', $('#wizard_add_participant')).text('Step ' + (index + 1) + ' of ' + total);
              // set done steps
              jQuery('li', $('#wizard_add_participant')).removeClass("done");
              var li_list = navigation.find('li');
              for (var i = 0; i < index; i++) {
                  jQuery(li_list[i]).addClass("done");
              }

              if (current == 1) {
                  $('#wizard_add_participant').find('.button-previous').hide();
              } else {
                  $('#wizard_add_participant').find('.button-previous').show();
              }

              if (current >= total) {
                  $('#wizard_add_participant').find('.button-next').hide();
                  $('#wizard_add_participant').find('.button-submit').show();
              } else {
                  $('#wizard_add_participant').find('.button-next').show();
                  $('#wizard_add_participant').find('.button-submit').hide();
              }
              App.scrollTo($('.page-title'));
          },
          onPrevious: function (tab, navigation, index) {
              tabelement = tab.find('a').attr('href');
              if($(tabelement).find('input,textarea,select').valid()==0){
               return false;
              }
              var total = navigation.find('li').length;
              var current = index + 1;
              // set wizard title
              $('.step-title', $('#wizard_add_participant')).text('Step ' + (index + 1) + ' of ' + total);
              // set done steps
              jQuery('li', $('#wizard_add_participant')).removeClass("done");
              var li_list = navigation.find('li');
              for (var i = 0; i < index; i++) {
                  jQuery(li_list[i]).addClass("done");
              }

              if (current == 1) {
                  $('#wizard_add_participant').find('.button-previous').hide();
              } else {
                  $('#wizard_add_participant').find('.button-previous').show();
              }

              if (current >= total) {
                  $('#wizard_add_participant').find('.button-next').hide();
                  $('#wizard_add_participant').find('.button-submit').show();
              } else {
                  $('#wizard_add_participant').find('.button-next').show();
                  $('#wizard_add_participant').find('.button-submit').hide();
              }

              App.scrollTo($('.page-title'));
          },
          onTabShow: function (tab, navigation, index) {
              var total = navigation.find('li').length;
              var current = index + 1;
              var $percent = (current / total) * 100;
              $('#wizard_add_participant').find('.bar').css({
                  width: $percent + '%'
              });
          }
      });

      $('#wizard_add_participant').find('.button-previous').hide();
      $('#wizard_add_participant .button-submit').click(function () {
          // alert('Finished! Hope you like it :)');
      }).hide();

      // default form wizard
      $('#wizard_edit_participant').bootstrapWizard({
          'nextSelector': '.button-next',
          'previousSelector': '.button-previous',
          onTabClick: function (tab, navigation, index) {
              // alert('on tab click disabled');
              return false;
          },
          onNext: function (tab, navigation, index) {
              tabelement = tab.find('a').attr('href');
              if($(tabelement).find('input,textarea,select').valid()==0){
               alert("You have some form errors. Please check again! ");
               return false;
              }
              var total = navigation.find('li').length;
              var current = index + 1;
              // set wizard title
              $('.step-title', $('#wizard_edit_participant')).text('Step ' + (index + 1) + ' of ' + total);
              // set done steps
              jQuery('li', $('#wizard_edit_participant')).removeClass("done");
              var li_list = navigation.find('li');
              for (var i = 0; i < index; i++) {
                  jQuery(li_list[i]).addClass("done");
              }

              if (current == 1) {
                  $('#wizard_edit_participant').find('.button-previous').hide();
              } else {
                  $('#wizard_edit_participant').find('.button-previous').show();
              }

              if (current >= total) {
                  $('#wizard_edit_participant').find('.button-next').hide();
                  $('#wizard_edit_participant').find('.button-submit').show();
              } else {
                  $('#wizard_edit_participant').find('.button-next').show();
                  $('#wizard_edit_participant').find('.button-submit').hide();
              }
              App.scrollTo($('.page-title'));
          },
          onPrevious: function (tab, navigation, index) {

              var total = navigation.find('li').length;
              var current = index + 1;
              // set wizard title
              $('.step-title', $('#wizard_edit_participant')).text('Step ' + (index + 1) + ' of ' + total);
              // set done steps
              jQuery('li', $('#wizard_edit_participant')).removeClass("done");
              var li_list = navigation.find('li');
              for (var i = 0; i < index; i++) {
                  jQuery(li_list[i]).addClass("done");
              }

              if (current == 1) {
                  $('#wizard_edit_participant').find('.button-previous').hide();
              } else {
                  $('#wizard_edit_participant').find('.button-previous').show();
              }

              if (current >= total) {
                  $('#wizard_edit_participant').find('.button-next').hide();
                  $('#wizard_edit_participant').find('.button-submit').show();
              } else {
                  $('#wizard_edit_participant').find('.button-next').show();
                  $('#wizard_edit_participant').find('.button-submit').hide();
              }

              App.scrollTo($('.page-title'));
          },
          onTabShow: function (tab, navigation, index) {
              var total = navigation.find('li').length;
              var current = index + 1;
              var $percent = (current / total) * 100;
              $('#wizard_edit_participant').find('.bar').css({
                  width: $percent + '%'
              });
          }
      });

      $('#wizard_edit_participant').find('.button-previous').hide();
      $('#wizard_edit_participant .button-submit').click(function () {
          // alert('Finished! Hope you like it :)');
      }).hide();
      // -------------------------------------------------------------
      // END FORM WIZARD
      // -------------------------------------------------------------

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        // begin first table
         $('#user_table').dataTable({
            "bDestroy":true,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": site_url+"cif/datatable_cif_kelompok",
            "fnServerParams": function ( aoData ) {
                 aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
             },
            "aoColumns": [
              null,
              null,
              null,
              null,
              null,
              null,
              { "bSortable": false }
            ],
            "aLengthMenu": [
                [5, 15, 20, -1],
                [5, 15, 20, "All"] // change per page values here
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
            "sZeroRecords" : "Data Pada Rembug ini Kosong",
            "aoColumnDefs": [{
                    'bSortable': false,
                    'aTargets': [0]
                }
            ]
         });
         $(".dataTables_length,.dataTables_filter").parent().hide();
      }

      // fungsi untuk check all
      jQuery('#user_table .group-checkable').live('change',function () {
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

      $("#user_table .checkboxes").livequery(function(){
        $(this).uniform();
      });


      /*$("input[name='step2_pribadi_tgl_lahir']").keydown(function(e){

        if(e.keyCode==9){
          $("input[name='step2_pribadi_tgl_lahir']").trigger('change');
        }

      });*/


      $("input[name='step2_pribadi_tgl_lahir']").keyup(function(e){
         $("input[name='step2_pribadi_tgl_lahir']").trigger('change');
      });

      $("input[name='step2_pribadi_tgl_lahir']").change(function(){
         // if($(this).val().length==10){
            date = $(this).val().replace(/\//g,'');
            date = date.replace(/\_/g,'');
            if(date!="--" && date.length==8)
            {
               console.log(date);
               day = date.substring(0,2);
               month = date.substring(2,4);
               year = date.substring(4,8);
               date = year+'-'+month+'-'+day;

               $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: site_url+"cif/get_age_by_ajax",
                  data: {date:date},
                  success:function(response){
                     $("#step2_pribadi_usia").val(response.age);
                  }
               })
            }
            else
            {
               $("#step2_pribadi_usia").val('');
            }
         // }else{
         //    $("#step2_pribadi_usia").val('');
         // }
      });

      $("input[name='step2_pasangan_tglahir']").keyup(function(e){
         $("input[name='step2_pasangan_tglahir']").trigger('change');
      });
      $("input[name='step2_pasangan_tglahir']").live('change',function(){
         
            date = $(this).val().replace(/\//g,'');
            date = date.replace(/\_/g,'');
            if(date.length==8)
            {

               day = date.substring(0,2);
               month = date.substring(2,4);
               year = date.substring(4,8);
               date = year+'-'+month+'-'+day;

               $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: site_url+"cif/get_age_by_ajax",
                  data: {date:date},
                  success:function(response){
                     $("#step2_pasangan_usia").val(response.age);
                  }
               });
            }else{
               $("#step2_pasangan_usia").val('');
            }
      });

      // adding validator method (confirmpassword)
      $.validator.addMethod("confirmpassword", function(value, element) { 

        password = $("#form_add input[name='password']").val();
        if(password!=value){
          return false;
        }else{
          return true;
        }

      }, "This field must same with Password");

      // adding validator method (confirmpassword2)
      $.validator.addMethod("confirmpassword2", function(value, element) { 

        password = $("#form_edit input[name='password']").val();
        if(password!=value){
          return false;
        }else{
          return true;
        }

      }, "This field must same with Password");


      // BEGIN FORM ADD USER VALIDATION
      
      $("a#back","#add").click(function(){
         $("#add").hide();
         $("#wrapper-table").show();
      });

      $("#btn_add").click(function(){
         if($("#cm_code").val()!=""){

            $("#wrapper-table").hide();
            $("#add").show();
            form1.trigger('reset');
            $("span.rembug").text('"'+$("#rembug_pusat").val()+'"');
            $("#form-wizard li.span3",form1).removeClass('done');
            $("#tab-content",form1).children('div.tab-pane').removeClass('active');
            $("#tab-content",form1).children('#tab1').addClass('active');
            result = $("#cm_code").val();
            $("#add_cm_code").val(result);
            $("#edit_cm_code").val(result);
            $("input[type='checkbox']","#form_add").removeAttr('checked');
            $("input[type='checkbox']","#form_add").closest('span').removeAttr('class');
            // if(window.status_added==1)
            // {
               var settings = $('#form_add').validate().settings;
               // delete settings.rules.rightform_input1;
               // delete settings.rules.step1_nama;
               // delete settings.rules.step1_panggilan;
               // delete settings.rules.step1_kelompok;
               // delete settings.rules.step1_setoran_lwk;
               // delete settings.rules.step1_setoran_mingguan;
               $('#step1_nama').val('0');
               $('#step1_panggilan').val('0');
               $('#step1_kelompok').val('0');
               $('#step1_setoran_lwk').val('0');
               $('#step1_setoran_mingguan').val('0');
               delete settings.rules.step2_pribadi_usia;

               // $(".button-previous").click();
               if($("#tab1").is(':visible')==true){
                  // no back
               }else if($("#tab2").is(':visible')==true){

               $(".button-previous").click();
               }else if($("#tab3").is(':visible')==true){

               $(".button-previous").click();
               $(".button-previous").click();
               }else if($("#tab4").is(':visible')==true){

               $(".button-previous").click();
               $(".button-previous").click();
               $(".button-previous").click();
               }
               // $(".button-previous").click();

               // settings.rules.rightform_input1;
               // settings.rules.step1_nama = 'required';
               // settings.rules.step1_panggilan = 'required';
               // settings.rules.step1_kelompok = 'required';
               // settings.rules.step1_setoran_lwk = {
               //     required: true,
               //     number: true
               // },
               // settings.rules.step1_setoran_mingguan = {
               //     required: true,
               //     number: true
               // },
               $('#step1_nama').val('');
               $('#step1_panggilan').val('');
               $('#step1_kelompok').val('');
               $('#step1_setoran_lwk').val('');
               $('#step1_setoran_mingguan').val('');
               settings.rules.step2_pribadi_usia = "required";
            // }

            success1.hide();
            error1.hide();
            form1.trigger('reset');
            form1.find('div.control-group').removeClass('success');
            $("#step1_setoran_lwk","#form_add").val($("#default_setoran_lwk").val());
            $("#step1_setoran_mingguan","#form_add").val($("#default_minggon").val());
         }
         else
         {
            alert("Pilih Rembug Terlebih Dahulu!")
         }
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: true, // do not focus the last invalid input
          // ignore: "",
          rules: {
              step1_nama: 'required',
              step1_panggilan: 'required',
              step1_kelompok: 'required',
              step1_setoran_lwk: {
                  required: true,
                  number: true
              },
              step1_setoran_mingguan: {
                  required: true,
                  number: true
              },
              step2_pribadi_usia: {
                  required: true,
                  number: true
              },
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

          submitHandler: false
      });


      $(".button-submit",form1).click(function(e){
        if(form1.valid()==true)
        {
          $.ajax({
              url: "<?php echo site_url('cif/add_cif_kelompok'); ?>",
              type: "POST",
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  alert(response.message);
                  $("input[type='checkbox']","#form_add").removeAttr('checked');
                  $("input[type='checkbox']","#form_add").closest('span').removeAttr('class');
                  success1.hide();
                  error1.hide();
                  form1.trigger('reset');
                  form1.find('div.control-group').removeClass('success');
                  $("#add").hide();
                  $("#wrapper-table").show();
                  // $(".bar","#add .progress").width('25%');
                  // $(".steps","#add").find('li.span3').removeClass('active').removeClass('done');
                  // $(".steps","#add").find('li.span3:first-child').addClass('active');
                  // $(".tab-content","#add").children('.tab-pane').removeClass('active');
                  // $("#tab1","#add .tab-content").addClass('active');
                  // $(".button-submit",form1).hide();
                  // $(".button-next",form1).show();
                  dTreload();
                  // $('.step-title', $('#wizard_add_participant')).text('Step 1 of 4');
                  App.scrollTo($('.page-title'));
                  form1.removeAttr('novalidate');
                  window.status_added=1;
                  // window.location.reload();
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
                }else{
                  success1.hide();
                  error1.show();
                  App.scrollTo($('.page-title'));
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo($('.page-title'));
              }
          });
        }
        else
        {
          alert('Please fill the empty field before.');
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

      $("#sama",form1).click(function(){

         if($(this).is(':checked')==true){
            $("#step2_pribadi_koresponden_alamat",form1).val($("#step2_pribadi_alamat",form1).val());
            $("#step2_pribadi_koresponden_rt",form1).val($("#step2_pribadi_rt",form1).val());
            $("#step2_pribadi_koresponden_rw",form1).val($("#step2_pribadi_rw",form1).val());
            $("#step2_pribadi_koresponden_desa",form1).val($("#step2_pribadi_desa",form1).val());
            $("#step2_pribadi_koresponden_kecamatan",form1).val($("#step2_pribadi_kecamatan",form1).val());
            $("#step2_pribadi_koresponden_kabupaten",form1).val($("#step2_pribadi_kabupaten",form1).val());
            $("#step2_pribadi_koresponden_kodepos",form1).val($("#step2_pribadi_kodepos",form1).val());
         }else{
            $("#step2_pribadi_koresponden_alamat",form1).val('');
            $("#step2_pribadi_koresponden_rt",form1).val('');
            $("#step2_pribadi_koresponden_rw",form1).val('');
            $("#step2_pribadi_koresponden_desa",form1).val('');
            $("#step2_pribadi_koresponden_kecamatan",form1).val('');
            $("#step2_pribadi_koresponden_kabupaten",form1).val('');
            $("#step2_pribadi_koresponden_kodepos",form1).val('');
         }

      });


      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);


      $(".button-cancel","#edit").click(function(){

         window.location.reload();
         
         // $(".bar",".progress").width('25%');
         // $(".steps","#edit").find('li.span3').removeClass('active').removeClass('done');
         // $(".steps","#edit").find('li.span3:first-child').addClass('active');
         // $(".tab-content","#edit").children('.tab-pane').removeClass('active');
         // $("#etab1","#edit .tab-content").addClass('active');
         // success2.hide();
         // error2.hide();
         // form2.trigger('reset');
         // form2.find('div.control-group').removeClass('error');
         // form2.find('div.control-group').removeClass('success');
         // $("#edit").hide();
         // $("#wrapper-table").show();
         // App.scrollTo($('.page-title'));

      });

      $("a#back","#edit").click(function(){
         $("#edit").hide();
         $("#wrapper-table").show();
      });

      $("a#link-edit").live('click',function(){

         result = $("#cm_code").val();
         $("#add_cm_code").val(result);
         $("#edit_cm_code").val(result);
        success2.hide();
        error2.hide();
        $("#wrapper-table").hide();
        $("#edit").show();
        var cif_id = $(this).attr('cif_id');
        $("#form-wizard li.span3",form2).removeClass('done');
        $("#tab-content",form2).children('div.tab-pane').removeClass('active');
        $("#tab-content",form2).children('#tab1').addClass('active');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {cif_id:cif_id},
          url: site_url+"cif/get_cif_kelompok",
          success: function(response){
            form2.trigger('reset');
            $("#rembug","#edit").text('"'+response.cm_name+'"');
            $("#cif_id",form2).val(response.cif_id);

            s1 = response.tgl_gabung.split('-');
            tgl_gabung = s1[2]+'/'+s1[1]+'/'+s1[0];
            
            $("input[name='step1_tanggal_gabung']",form2).val(tgl_gabung);
            $("#step1_cif_no",form2).val(response.cif_no);
            $("#step1_nama",form2).val(response.nama);
            $("#step1_panggilan",form2).val(response.panggilan);
            $("#step1_kelompok",form2).val(response.kelompok);
            $("#step1_setoran_lwk",form2).val(response.setoran_lwk);
            $("#step1_setoran_mingguan",form2).val(response.setoran_mingguan);
            $("#step2_pribadi_jenis_kelamin[value='"+response.jenis_kelamin+"']",form2).attr('checked',true);
            // $("#step2_pribadi_jenis_kelamin",form2).val(response.step2_pribadi_jenis_kelamin);
            $("#step2_pribadi_ibu_kandung",form2).val(response.ibu_kandung);
            $("#step2_pribadi_tmp_lahir",form2).val(response.tmp_lahir);

            s2 = response.tgl_lahir.split('-');
            tgl_lahir = s2[2]+s2[1]+s2[0];

            $("input[name='step2_pribadi_tgl_lahir']",form2).val(tgl_lahir);
            $("#step2_pribadi_usia",form2).val(response.usia);
            $("#step2_pribadi_alamat",form2).val(response.alamat);
            srtrw = response.rt_rw.split('/');
            rt = srtrw[0];
            rw = srtrw[1];
            $("#step2_pribadi_rt",form2).val(rt);
            $("#step2_pribadi_rw",form2).val(rw);
            $("#step2_pribadi_desa",form2).val(response.desa);
            $("#step2_pribadi_kecamatan",form2).val(response.kecamatan);
            $("#step2_pribadi_kabupaten",form2).val(response.kabupaten);
            $("#step2_pribadi_kodepos",form2).val(response.kodepos);
            $("#step2_pribadi_koresponden_alamat",form2).val(response.koresponden_alamat);
            skrtrw = response.koresponden_rt_rw.split('/');
            krt = skrtrw[0];
            krw = skrtrw[1];
            $("#step2_pribadi_koresponden_rt",form2).val(krt);
            $("#step2_pribadi_koresponden_rw",form2).val(krw);
            $("#step2_pribadi_koresponden_desa",form2).val(response.koresponden_desa);
            $("#step2_pribadi_koresponden_kecamatan",form2).val(response.koresponden_kecamatan);
            $("#step2_pribadi_koresponden_kabupaten",form2).val(response.koresponden_kabupaten);
            $("#step2_pribadi_koresponden_kodepos",form2).val(response.koresponden_kodepos);
            $("#step2_pribadi_pendidikan",form2).val(response.pendidikan);
            $("#step2_pribadi_pekerjaan",form2).val(response.pekerjaan);
            $("#step2_pribadi_pendapatan",form2).val(response.pendapatan);
            $("#step2_pribadi_ket_pekerjaan",form2).val(response.ket_pekerjaan);
            // $("#step2_pribadi_literasi_latin",form2).val(response.literasi_latin);
            // $("#step2_pribadi_literasia_arab",form2).val(response.literasia_arab);
            
            var sama = true;
            if ( rt != krt )
               sama = false;
            else if ( krw != rw )
               sama = false;
            else if ( response.desa != response.koresponden_desa )
               sama = false;
            else if ( response.kecamatan != response.koresponden_kecamatan )
               sama = false;
            else if ( response.kabupaten != response.koresponden_kabupaten )
               sama = false;
            else if ( response.kodepos != response.kodepos )
               sama = false;

            if ( sama == true )
               $("#sama",form2).attr('checked',true);
            else
               $("#sama",form2).attr('checked',false);

            if(response.literasi_latin=="1"){
               $("#step2_pribadi_literasi_latin",form2).attr('checked',true);
               $("#step2_pribadi_literasi_latin",form2).closest('span').attr('class','checked');
            }else{
               $("#step2_pribadi_literasi_latin",form2).attr('checked',false);
               $("#step2_pribadi_literasi_latin",form2).closest('span').attr('class','checked');
            }

            if(response.literasi_arab=="1"){
               $("#step2_pribadi_literasi_arab",form2).attr('checked',true);
               $("#step2_pribadi_literasi_arab",form2).closest('span').attr('class','checked');
            }else{
               $("#step2_pribadi_literasi_arab",form2).attr('checked',false);
               $("#step2_pribadi_literasi_arab",form2).closest('span').attr('class','checked');
            }

            $("#step2_pasangan_nama",form2).val(response.p_nama);
            $("#step2_pasangan_tmplahir",form2).val(response.p_tmplahir);
            p_tglahir = '';
            if(response.p_tglahir!=null){
               s = response.p_tglahir.split('-');
               p_tglahir = s[2]+'/'+s[1]+"/"+s[0];
            }
            $("input[name='step2_pasangan_tglahir']",form2).val(p_tglahir);
            $("#step2_pasangan_usia",form2).val(response.p_usia);
            $("#step2_pasangan_pendidikan",form2).val(response.p_pendidikan);
            $("#step2_pasangan_pekerjaan",form2).val(response.p_pekerjaan);
            $("#step2_pasangan_pendapatan",form2).val(response.p_pendapatan);
            $("#step2_pasangan_ketpekerjaan",form2).val(response.p_ketpekerjaan);

            if(response.p_literasi_latin=="1"){
               $("#step2_pasangan_literasi_latin",form2).attr('checked',true);
               $("#step2_pasangan_literasi_latin",form2).closest('span').attr('class','checked');
            }else{
               $("#step2_pasangan_literasi_latin",form2).attr('checked',false);
               $("#step2_pasangan_literasi_latin",form2).closest('span').attr('checked',false);
            }

            if(response.p_literasi_arab=="1"){
               $("#step2_pasangan_literasi_arab",form2).attr('checked',true);
               $("#step2_pasangan_literasi_arab",form2).closest('span').attr('class','checked');
            }else{
               $("#step2_pasangan_literasi_arab",form2).attr('checked',false);
               $("#step2_pasangan_literasi_arab",form2).closest('span').attr('checked',false);
            }

            $("#step2_pasangan_jmlkeluarga",form2).val(response.p_jmlkeluarga);
            $("#step2_pasangan_jmltanggungan",form2).val(response.p_jmltanggungan);
            $("#step3_rmhstatus",form2).val(response.rmhstatus);
            $("#step3_rmhukuran",form2).val(response.rmhukuran);
            $("#step3_rmhdinding",form2).val(response.rmhdinding);
            $("#step3_rmhatap",form2).val(response.rmhatap);
            $("#step3_rmhlantai",form2).val(response.rmhlantai);
            $("#step3_rmhjamban",form2).val(response.rmhjamban);
            $("#step3_rmhair",form2).val(response.rmhair);
            $("#step3_lahansawah",form2).val(response.lahansawah);
            $("#step3_lahankebun",form2).val(response.lahankebun);
            $("#step3_lahanpekarangan",form2).val(response.lahanpekarangan);
            $("#step3_ternakunggas",form2).val(response.ternakunggas);
            $("#step3_ternakdomba",form2).val(response.ternakdomba);
            $("#step3_sapi_ternakkerbau",form2).val(response.ternakkerbau);
            $("#step3_kendsepeda",form2).val(response.kendsepeda);
            $("#step3_kendmotor",form2).val(response.kendmotor);

            if ( response.elektape != null ){
               $("#step3_elektape",form2).attr('checked',true);
               $("#step3_elektape",form2).closest('span').attr('class','checked');
            }else{
               $("#step3_elektape",form2).attr('checked',false);
            }
            if ( response.elekplayer != null ){
               $("#step3_elekplayer",form2).attr('checked',true);
               $("#step3_elekplayer",form2).closest('span').attr('class','checked');
            }else{
               $("#step3_elekplayer",form2).attr('checked',false);
            }
            if ( response.elektv != null ){
               $("#step3_elektv",form2).attr('checked',true);
               $("#step3_elektv",form2).closest('span').attr('class','checked');
            }else{
               $("#step3_elektv",form2).attr('checked',false);
            }
            if ( response.elekkulkas != null ){
               $("#step3_elekkulkas",form2).attr('checked',true);
               $("#step3_elekkulkas",form2).closest('span').attr('class','checked');
            }else{
               $("#step3_elekkulkas",form2).attr('checked',false);
            }
            $("#step4_ushrumahtangga",form2).val(response.ushrumahtangga);
            $("#step4_ushkomoditi",form2).val(response.ushkomoditi);
            $("#step4_ushlokasi",form2).val(response.ushlokasi);
            $("#step4_ushomset",form2).val(response.ushomset);
            $("#step4_byaberas",form2).val(response.byaberas);
            $("#step4_byadapur",form2).val(response.byadapur);
            $("input[name='step4_byalistrik']",form2).val(response.byalistrik);
            $("#step4_byatelpon",form2).val(response.byatelpon);
            $("#step4_byasekolah",form2).val(response.byasekolah);
            $("#step4_byalain",form2).val(response.byalain);
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              step1_nama: 'required',
              step1_panggilan: 'required',
              step1_kelompok: 'required',
              step1_setoran_lwk: {
                  required: true,
                  number: true
              },
              step1_setoran_mingguan: {
                  required: true,
                  number: true
              },
              step2_pribadi_usia: {
                  required: true,
                  number: true
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

          submitHandler: false
            
      });
      
      $(".button-submit",form2).click(function(e){

        if(form2.valid()==true)
        {
          $.ajax({
           type: "POST",
           url: site_url+"cif/update_cif_kelompok",
           dataType: "json",
           data: form2.serialize(),
           success: function(response){
             if(response.success==true){
               alert(response.message);
               $("input[type='checkbox']","#form_edit").removeAttr('checked');
               $("input[type='checkbox']","#form_edit").closest('span').removeAttr('class');
               App.scrollTo($('.page-title'));
               window.location.reload();
               $("#menu_table_filter input").val('');
               dTreload();
               $("#cancel",form_edit).trigger('click')
               alert('Successfully Updated Data');
               /*success2.show();
               error2.hide();
               form2.find('div.control-group').removeClass('error');
               form2.find('div.control-group').removeClass('success');
               form2.trigger('reset');
               $("#edit").hide();
               $("#wrapper-table").show();
               dTreload();
               $(".bar",".progress").width('25%');
               $(".steps").find('li.span3').removeClass('active').removeClass('done');
               $(".steps").find('li.span3:first-child').addClass('active');
               $(".tab-content","#edit").children('.tab-pane').removeClass('active');
               $("#tab1","#edit .tab-content").addClass('active');
               App.scrollTo($('.page-title'));
               $(".button-submit",form2).hide();
               $(".button-next",form2).show();
               $(".button-previous",form2).hide();*/
             }else{
               success2.hide();
               error2.show();
               App.scrollTo($('.page-title'));
             }
           },
           error:function(){
               success2.hide();
               error2.show();
               App.scrollTo($('.page-title'));
           }
         });
        }
        else
        {
          alert('Please fill the empty field before.');
        }

      });


      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){

        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();

      });


      $("#sama",form2).click(function(){

         if($(this).is(':checked')==true){
            $("#step2_pribadi_koresponden_alamat",form2).val($("#step2_pribadi_alamat",form2).val());
            $("#step2_pribadi_koresponden_rt",form2).val($("#step2_pribadi_rt",form2).val());
            $("#step2_pribadi_koresponden_rw",form2).val($("#step2_pribadi_rw",form2).val());
            $("#step2_pribadi_koresponden_desa",form2).val($("#step2_pribadi_desa",form2).val());
            $("#step2_pribadi_koresponden_kecamatan",form2).val($("#step2_pribadi_kecamatan",form2).val());
            $("#step2_pribadi_koresponden_kabupaten",form2).val($("#step2_pribadi_kabupaten",form2).val());
            $("#step2_pribadi_koresponden_kodepos",form2).val($("#step2_pribadi_kodepos",form2).val());
         }else{
            $("#step2_pribadi_koresponden_alamat",form2).val('');
            $("#step2_pribadi_koresponden_rt",form2).val('');
            $("#step2_pribadi_koresponden_rw",form2).val('');
            $("#step2_pribadi_koresponden_desa",form2).val('');
            $("#step2_pribadi_koresponden_kecamatan",form2).val('');
            $("#step2_pribadi_koresponden_kabupaten",form2).val('');
            $("#step2_pribadi_koresponden_kodepos",form2).val('');
         }

      });


      $("#btn_delete").click(function(){

        var cif = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          cif[$i] = $(this).val();

          $i++;

        });

        if(cif.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_cif_kelompok",
              dataType: "json",
              data: {cif:cif},
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


      $("#btn_activate").click(function(){

        var user_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          user_id[$i] = $(this).val();

          $i++;

        });

        if(user_id.length==0){
          alert("Please select some row to Activate !");
        }else{
          var conf = confirm('Are you sure to Activate this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/activate_user",
              dataType: "json",
              data: {user_id:user_id},
              success: function(response){
                if(response.success==true){
                  alert("Activated!");
                  dTreload();
                }else{
                  alert("Activate Failed!");
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

        var user_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          user_id[$i] = $(this).val();

          $i++;

        });

        if(user_id.length==0){
          alert("Please select some row to Inactivate !");
        }else{
          var conf = confirm('Are you sure to Inactivate this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/inactivate_user",
              dataType: "json",
              data: {user_id:user_id},
              success: function(response){
                if(response.success==true){
                  alert("Inactivated!");
                  dTreload();
                }else{
                  alert("Inactivate Failed!");
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
      $('#user_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_cif_kelompok",
          "fnServerParams": function ( aoData ) {
              aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
          },
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
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
          "sZeroRecords" : "Data Pada Rembug ini Kosong",
          "aoColumnDefs": [{
                  'bSortable': false,
                  'aTargets': [0]
              }
          ]
      });
      $(".dataTables_length,.dataTables_filter").parent().hide();
      

      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
