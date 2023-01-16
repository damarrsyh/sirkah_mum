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
         Costumer Information File (CIF) <small>Add, Edit, Delet and more</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">Individu</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Customer Information File (CIF)</a></li>  
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Customer Information File</div>
      <div class="tools">
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
              Delete CIF <i class="icon-remove"></i>
            </button>
         </div>
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
      </div>
      <table class="table table-striped table-bordered table-hover" id="rembug_table">
         <thead>
            <tr>
               <th width="8"><input type="checkbox" class="group-checkable" data-set="#rembug_table .checkboxes" /></th>
               <th width="20%">Cif No</th>
               <th width="30%">Nama</th>
               <th width="15%">Jenis Kelamin</th>
               <th width="15%">Tanggal Lahir</th>
               <th width="10%">Usia</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD REMBUG -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Add New CIF</div>
         <div class="tools">
            <a href="javascript:;" id="back_add" style="color:white;font-size:15px;"> < Back </a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('cif/add_cif_individu'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               Terdapat beberapa form yang error. Mohon periksa kembali
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               CIF Baru berhasil di buat !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Tanggal Gabung <span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tgl_gabung" id="mask_date" data-required="1" class="small m-wrap date-picker"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap <span class="required">*</span><br><small>(Sesuai KTP)</small></label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan<span class="required">*</span></label>
               <div class="controls">
                  <input name="panggilan" id="panggilan" type="text" class="medium m-wrap" onkeyup="this.value=this.value.toUpperCase()"/>
               </div>
            </div>
            <hr size="1">
            <div class="control-group">
               <label class="control-label">Jenis Kelamin<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_kelamin" id="jenis_kelamin" class="medium m-wrap" data-required="1"> 
                    <option value="">Select...</option>
                      <option value="P">Pria</option>
                      <option value="W">Wanita</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="ibu_kandung" id="ibu_kandung" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tmp_lahir" id="tmp_lahir" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir/Usia<span class="required">*</span></label>
               <div class="controls">
                  <input name="tgl_lahir" id="mask_date" type="text" class="date-picker small m-wrap"/>
                  <input name="usia" id="usia" type="text" class="m-wrap" style="width:20px;"/>
               </div>
            </div>
            <h5>:: Alamat Rumah</h5>
            <div class="control-group">
               <label class="control-label">Alamat<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <textarea id="alamat" name="alamat" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">RT/RW<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="rt" id="rt" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
                  <input name="rw" id="rw" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa/Kelurahan<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="desa" id="desa" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kecamatan<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kecamatan" id="kecamatan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten/Kota<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kabupaten" id="kabupaten" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Pos<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kode_pos" id="kode_pos" type="text" class="small m-wrap"/>
               </div>
            </div>
            <h5>:: Alamat Surat Menyurat <br><small><input type="checkbox" id="sama" name="sama">Sama dengan Alamat Rumah</small></h5>
            <div class="control-group">
               <label class="control-label">Alamat<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <textarea id="koresponden_alamat" name="koresponden_alamat" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">RT/RW<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_rt" id="koresponden_rt" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
                  <input name="koresponden_rw" id="koresponden_rw" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa/Kelurahan<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_desa" id="koresponden_desa" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kecamatan<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kecamatan" id="koresponden_kecamatan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten/Kota<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kabupaten" id="koresponden_kabupaten" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Pos<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kode_pos" id="koresponden_kode_pos" type="text" class="small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. KTP</label>
               <div class="controls">
                  <input name="no_ktp" id="no_ktp" type="text" class="medium m-wrap" maxlength="16" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telpon Rumah</label>
               <div class="controls">
                  <input name="telpon_rumah" id="telpon_rumah" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. NPWP</label>
               <div class="controls">
                  <input name="no_npwp" id="no_npwp" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pendidikan Terakhir</label>
               <div class="controls">
                 <select name="pendidikan" id="pendidikan">
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
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status Perkawinan</label>
               <div class="controls">
                  <select name="status_perkawinan" id="status_perkawinan" class="medium m-wrap">
                    <option value="">Silahkan Pilih</option>
                    <option value="0">Menikah</option>
                    <option value="1">Tidak Menikah</option>
                    <option value="2">Duda</option>
                    <option value="3">Janda</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Identitas Pasangan</label>
               <div class="controls">
                  <input name="identitas_pasangan" id="identitas_pasangan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pekerjaan</label>
               <div class="controls">
                  <select name="pekerjaan" id="pekerjaan" class="medium m-wrap">
                    <option value="">Silahkan Pilih</option>
                    <option>IRT</option>
                    <option>Buruh</option>
                    <option>Petani</option>
                    <option>Pedagang</option>
                    <option>Wirausahawan</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pendapatan</label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input name="pendapatan" id="pendapatan" type="text" class="mask-money medium m-wrap"/>
                     <span class="add-on">,00</span>
                  </div>
                  &nbsp; Perbulan
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Pekerjaan</label>
               <div class="controls">
                  <textarea name="keterangan_pekerjaan" id="keterangan_pekerjaan" class="medium m-wrap"></textarea>
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
<!-- END ADD REMBUG -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Rembug</div>
         <div class="tools">
            <a href="javascript:;" id="back_edit" style="color:white;font-size:15px;"> < Back </a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="cif_id" name="cif_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               Terdapat beberapa form yang error. Mohon periksa kembali
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit CIF Berhasil !
            </div>

            <div class="control-group">
               <label class="control-label">Tanggal Gabung <span class="required">*</span><br><small>(Sesuai KTP)</small></label>
               <div class="controls">
                  <input type="text" name="tgl_gabung" id="mask_date" data-required="1" class="date-picker medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap <span class="required">*</span><br><small>(Sesuai KTP)</small></label>
               <div class="controls">
                  <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan<span class="required">*</span></label>
               <div class="controls">
                  <input name="panggilan" id="panggilan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <hr size="1">
            <div class="control-group">
               <label class="control-label">Jenis Kelamin<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_kelamin" id="jenis_kelamin" class="medium m-wrap" data-required="1"> 
                    <option value="">Select...</option>
                      <option value="P">Pria</option>
                      <option value="W">Wanita</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="ibu_kandung" id="ibu_kandung" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tmp_lahir" id="tmp_lahir" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir/Usia<span class="required">*</span></label>
               <div class="controls">
                  <input name="tgl_lahir" id="mask_date" type="text" class="date-picker small m-wrap"/>
                  <input name="usia" id="usia" type="text" class="m-wrap" style="width:20px;"/>
               </div>
            </div>
            <h5>:: Alamat Rumah</h5>
            <div class="control-group">
               <label class="control-label">Alamat<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <textarea id="alamat" name="alamat" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">RT/RW<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="rt" id="rt" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
                  <input name="rw" id="rw" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa/Kelurahan<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="desa" id="desa" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kecamatan<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kecamatan" id="kecamatan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten/Kota<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kabupaten" id="kabupaten" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Pos<br><small>(Alamat Rumah)</small></label>
               <div class="controls">
                  <input name="kode_pos" id="kode_pos" type="text" class="small m-wrap"/>
               </div>
            </div>
            <h5>:: Alamat Surat Menyurat <br><small><input type="checkbox" id="sama" name="sama">Sama dengan Alamat Rumah</small></h5>
            <div class="control-group">
               <label class="control-label">Alamat<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <textarea id="koresponden_alamat" name="koresponden_alamat" class="m-wrap medium"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">RT/RW<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_rt" id="koresponden_rt" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
                  <input name="koresponden_rw" id="koresponden_rw" type="text" class="m-wrap" maxlength="3" style="width:50px"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Desa/Kelurahan<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_desa" id="koresponden_desa" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kecamatan<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kecamatan" id="koresponden_kecamatan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten/Kota<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kabupaten" id="koresponden_kabupaten" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode Pos<br><small>(Alamat Surat Menyurat)</small></label>
               <div class="controls">
                  <input name="koresponden_kode_pos" id="koresponden_kode_pos" type="text" class="small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. KTP</label>
               <div class="controls">
                  <input name="no_ktp" id="no_ktp" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. Telpon Rumah</label>
               <div class="controls">
                  <input name="telpon_rumah" id="telpon_rumah" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">No. NPWP</label>
               <div class="controls">
                  <input name="no_npwp" id="no_npwp" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pendidikan Terakhir</label>
               <div class="controls">
                 <select name="pendidikan" id="pendidikan">
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
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Status Perkawinan</label>
               <div class="controls">
                  <select name="status_perkawinan" id="status_perkawinan" class="medium m-wrap">
                    <option value="">Silahkan Pilih</option>
                    <option value="0">Menikah</option>
                    <option value="1">Tidak Menikah</option>
                    <option value="2">Duda</option>
                    <option value="3">Janda</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Identitas Pasangan</label>
               <div class="controls">
                  <input name="identitas_pasangan" id="identitas_pasangan" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pekerjaan</label>
               <div class="controls">
                  <select name="pekerjaan" id="pekerjaan" class="medium m-wrap">
                    <option value="">Silahkan Pilih</option>
                    <option>IRT</option>
                    <option>Buruh</option>
                    <option>Petani</option>
                    <option>Pedagang</option>
                    <option>Wirausahawan</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pendapatan</label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input name="pendapatan" id="pendapatan" type="text" class="mask-money medium m-wrap"/>
                     <span class="add-on">,00</span>
                  </div>
                  &nbsp; Perbulan
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Keterangan Pekerjaan</label>
               <div class="controls">
                  <textarea name="keterangan_pekerjaan" id="keterangan_pekerjaan" class="medium m-wrap"></textarea>
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
<!-- END EDIT REMBUG -->






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
   $(function() {    
      App.init(); // initlayout and core plugins
      Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
      $("input#mask_date").inputmask("d/m/y");  //direct mask        
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
        var tbl_id = 'rembug_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#rembug_table .group-checkable').live('change',function () {
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

      $("#rembug_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      $("#back_add").click(function(){
        $("#add").hide();
        $("#wrapper-table").show();
      });

      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
               nama: 'required'
              ,panggilan: 'required'
              ,jenis_kelamin: 'required'
              // ,tgl_lahir: 'required'
              ,usia: 'required'
              ,no_ktp: {no_ktp_validate:true}
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


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  form1.find('div.control-group').removeClass('error');
                  form1.find('div.control-group').removeClass('success');
                  $("#add").hide();
                  $("#wrapper-table").show();
                  dTreload();
                  App.scrollTo($('.page-title'));
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
        form1.find('div.control-group').removeClass('error');
        form1.find('div.control-group').removeClass('success');
        $("#wrapper-table").show();
        form1.trigger('reset');
        form1.children('div').removeClass('success');
        $(".help-inline",form1).html('');
        dTreload();
      });

      $("#sama",form1).click(function(){
         if($(this).is(':checked')==true){
            $("#koresponden_alamat",form1).val($("#alamat",form1).val());
            $("#koresponden_rt",form1).val($("#rt",form1).val());
            $("#koresponden_rw",form1).val($("#rw",form1).val());
            $("#koresponden_desa",form1).val($("#desa",form1).val());
            $("#koresponden_kecamatan",form1).val($("#kecamatan",form1).val());
            $("#koresponden_kabupaten",form1).val($("#kabupaten",form1).val());
            $("#koresponden_kode_pos",form1).val($("#kode_pos",form1).val());
         }else{
            $("#koresponden_alamat",form1).val('');
            $("#koresponden_rt",form1).val('');
            $("#koresponden_rw",form1).val('');
            $("#koresponden_desa",form1).val('');
            $("#koresponden_kecamatan",form1).val('');
            $("#koresponden_kabupaten",form1).val('');
            $("#koresponden_kode_pos",form1).val('');
         }
      });




      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);


      $("#back_edit").click(function(){
        $("#wrapper-table").show();
        $("#edit").hide();
      });

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        form2.trigger('reset');
        form2.children('div').removeClass('success');
        form2.find('div.control-group').removeClass('error');
        form2.find('div.control-group').removeClass('success');
        $(".help-inline",form2).html('');
        var cif_id = $(this).attr('cif_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {cif_id:cif_id},
          url: site_url+"cif/get_cif_individu",
          success: function(response){
            form2.trigger('reset');
            $("input[name='cif_id']",form2).val(response.cif_id);
            $("input[name='nama']",form2).val(response.nama);
            s1 = response.tgl_gabung.split('-');
            tgl_gabung = s1[2]+''+s1[1]+''+s1[0];
            $("input[name='tgl_gabung']",form2).val(tgl_gabung);
            $("input[name='panggilan']",form2).val(response.panggilan);
            $("#jenis_kelamin",form2).val(response.jenis_kelamin);
            $("input[name='ibu_kandung']",form2).val(response.ibu_kandung);
            $("input[name='tmp_lahir']",form2).val(response.tmp_lahir);
            s = response.tgl_lahir.split('-');
            tgl_lahir = s[2]+''+s[1]+''+s[0];
            $("input[name='tgl_lahir']",form2).val(tgl_lahir);
            $("input[name='usia']",form2).val(response.usia);
            $("#alamat",form2).val(response.alamat);
            rt_rw = response.rt_rw.split('/');
            rt = rt_rw[0];
            rw = rt_rw[1];
            $("input[name='rt']",form2).val(rt);
            $("input[name='rw']",form2).val(rw);
            $("input[name='desa']",form2).val(response.desa);
            $("input[name='kecamatan']",form2).val(response.kecamatan);
            $("input[name='kabupaten']",form2).val(response.kabupaten);
            $("input[name='kode_pos']",form2).val(response.kodepos);
            $("#koresponden_alamat",form2).val(response.koresponden_alamat);
            koresponden_rtrw = response.koresponden_rt_rw.split('/');
            koresponden_rt = koresponden_rtrw[0];
            koresponden_rw = koresponden_rtrw[1];
            $("input[name='koresponden_rt']",form2).val(koresponden_rt);
            $("input[name='koresponden_rw']",form2).val(koresponden_rw);
            $("input[name='koresponden_desa']",form2).val(response.koresponden_desa);
            $("input[name='koresponden_kecamatan']",form2).val(response.koresponden_kecamatan);
            $("input[name='koresponden_kabupaten']",form2).val(response.koresponden_kabupaten);
            $("input[name='koresponden_kode_pos']",form2).val(response.koresponden_kodepos);
            $("input[name='no_ktp']",form2).val(response.no_ktp);
            $("input[name='telpon_rumah']",form2).val(response.telpon_rumah);
            $("input[name='no_npwp']",form2).val(response.no_npwp);
            $("#pendidikan",form2).val(response.pendidikan);
            $("#status_perkawinan",form2).val(response.status_perkawinan);
            $("#identitas_pasangan",form2).val(response.identitas_pasangan);
            $("#pekerjaan",form2).val(response.pekerjaan);
            $("#pendapatan",form2).val(response.pendapatan_perbulan);
            $("#keterangan_pekerjaan",form2).val(response.ket_pekerjaan);

            var sama = true;
            if ( rt != koresponden_rt )
               sama = false;
            else if ( koresponden_rw != rw )
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
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
               nama: 'required'
              ,panggilan: 'required'
              ,jenis_kelamin: 'required'
              // ,tgl_lahir: 'required'
              ,usia: 'required'
              ,no_ktp: {no_ktp_validate:true}
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

            $.ajax({
              type: "POST",
              url: site_url+"cif/update_cif_individu",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  form2.find('div.control-group').removeClass('error');
                  form2.find('div.control-group').removeClass('success');
                  $("#menu_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo($('.page-title'));
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo($('.page-title'));
              }
            });

          }
      });
   
      $("input[name='tgl_lahir']").keyup(function(e){
         date = $(this).val().replace(/\//g,'');
         date = date.replace(/\_/g,'');
         if(date.length==8){
            $(this).trigger('change');
         }
      });

      $("input[name='tgl_lahir']","#form_add").change(function(){
         if($(this).val().length==10){
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
                     $("#usia","#form_add").val(response.age);
                  }
               });
            }
         }else{
            $("#usia","#form_add").val('');
         }
      });

      $("input[name='tgl_lahir']","#form_edit").change(function(){
         if($(this).val().length==10){
            date = $(this).val().replace(/\//g,'');
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
                  $("#usia","#form_edit").val(response.age);
               }
            })
         }else{
            $("#usia","#form_edit").val('');
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
            $("#alamat",form2).val($("#koresponden_alamat",form2).val());
            $("#rt",form2).val($("#koresponden_rt",form2).val());
            $("#rw",form2).val($("#koresponden_rw",form2).val());
            $("#desa",form2).val($("#koresponden_desa",form2).val());
            $("#kecamatan",form2).val($("#koresponden_kecamatan",form2).val());
            $("#kabupaten",form2).val($("#koresponden_kabupaten",form2).val());
            $("#kodepos",form2).val($("#koresponden_kodepos",form2).val());
         }else{
            $("#koresponden_alamat",form2).val('');
            $("#koresponden_rt",form2).val('');
            $("#koresponden_rw",form2).val('');
            $("#koresponden_desa",form2).val('');
            $("#koresponden_kecamatan",form2).val('');
            $("#koresponden_kabupaten",form2).val('');
            $("#koresponden_kodepos",form2).val('');
         }
      });



      $("#btn_delete").click(function(){

        var cif_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          cif_id[$i] = $(this).val();

          $i++;

        });

        if(cif_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_cif_individu",
              dataType: "json",
              data: {cif_id:cif_id},
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
      $('#rembug_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_cif_individu",
          "aoColumns": [
            { "bSortable": false },
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

      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
