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
			Verifikasi Pelunasan Pembiayaan<small> Verifikasi Pelunasan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Verifikasi Pelunasan Pembiayaan</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Pelunasan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <!-- <label> -->
            <!-- Rembug Pusat &nbsp; : &nbsp; -->
            <!-- <input type="text" name="rembug_pusat" id="rembug_pusat" class="medium m-wrap" disabled> -->
            <!-- <input type="hidden" name="cm_code" id="cm_code"> -->
            <!-- <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a> -->
            <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
         <!-- </label> -->
      </div>

      <?php
      /*
      <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Rembug</h3>
         </div>
         <div class="modal-body">
            <div class="row-fluid">
               <div class="span12">
                  <h4>Masukan Kata Kunci</h4>
                  <p><input type="text" name="keyword" id="keyword" placeholder="Search..." class="span12 m-wrap"></p>
                  <p><select name="branch" id="branch" class="span12 m-wrap">
                     <option value="">Pilih Kantor Cabang</option>
                     <option value="">All</option>
                     <?php
                     if($this->session->userdata('flag_all_branch')=='1'){
                     ?>
                     <?php
                     foreach($branch as $dtbranch):
                        if($this->session->userdata('branch_id')==$dtbranch['branch_id']){
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>" selected><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }else{
                     ?>
                     <option value="<?php echo $dtbranch['branch_id']; ?>"><?php echo $dtbranch['branch_name']; ?></option>
                     <?php
                        }
                     endforeach; 
                     ?>
                     <?php }else{ ?>
                     <option value="<?php echo $this->session->userdata('branch_id'); ?>"><?php echo $this->session->userdata('branch_name'); ?></option>
                     <?php } ?>
                  </select></p>
                  <p><select name="result" id="result" size="7" class="span12 m-wrap"></select></p>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
            <button type="button" id="select" class="btn blue">Select</button>
         </div>
      </div>
      */
      ?>
      <p>
      <table class="table table-striped table-bordered table-hover" id="pelunasan_pembiayaan_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#pelunasan_pembiayaan_table .checkboxes" /></th>
               <th width="25%">No. Rekening</th>
               <th width="20%">Nama</th>
               <th width="20%">Akad</th>
               <th width="15%">Jangka Waktu</th>
               <!-- <th width="25%">Pembiayaan</th>
               <th width="25%">Pembayaran</th> -->
               <th>Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Data Pelunasan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_financing_lunas_id" name="account_financing_lunas_id">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
            <input type="hidden" id="trx_account_financing_id" name="trx_account_financing_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Pelunasan Pembiayaan Berhasil Di Proses !
            </div>

            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_lengkap" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Panggilan<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_panggilan" id="panggilan" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung<span class="required">*</span></label>
               <div class="controls">
                  <input name="nama_ibu" id="ibu_kandung" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tempat_lahir" id="tmp_lahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lahir<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_lahir" id="tgl_lahir" readonly="readonly" type="text" class="medium m-wrap" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" readonly="readonly" maxlength="3" style="background-color:#eee;width:30px;" /> Tahun
                  <span class="help-inline"></span>&nbsp;
               </div>
            </div>
            <p>
            <div class="control-group">
               <label class="control-label">Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="produk" id="produk" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Akad<span class="required">*</span></label>
               <div class="controls">
                  <input name="akad" id="akad" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pokok Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="pokok_pembiayaan" id="pokok_pembiayaan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <input name="saldo_catab" type="hidden" id="saldo_catab" />
                  <span class="add-on">,00</span>
                </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div>   
                  Nisbah Bagi Hasil
                  &nbsp;
                  <span class="help-inline"></span>
                   <input name="nisbah_bagihasil" id="nisbah_bagihasil" data-required="1" style="background-color:#eee;width:50px;" type="text" class="m-wrap" readonly="readonly"/> %
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" id="jangka_waktu" readonly="readonly" name="jangka_waktu" style="background-color:#eee;width:30px;"  maxlength="3" /> Bulan/Minggu/Hari
                  <span class="help-inline"></span>
               </div>
            </div> 
            <div class="control-group">
               <label class="control-label">Angsuran Terbayar<span class="required">*</span></label>
               <div class="controls">
                  <input name="counter_angsuran" id="counter_angsuran" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee; width:30px;"/> Angsuran
                  <input name="freq" type="hidden" id="freq" />
                  <span class="help-inline"></span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Jatuh Tempo<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Pokok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_pokok" id="saldo_pokok" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div>  
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                     <input name="saldo_margin" id="saldo_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                   <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Catab<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_tabungan_trx" id="saldo_tabungan_trx" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <input name="saldo_tabungan" id="saldo_tabungan" type="hidden"/>
                  <span class="add-on">,00</span>
                  </div> 
                    <label class="checkbox">
                      <input name="calculate_saldo_catab" type="checkbox" class="form-control" id="calculate_saldo_catab" disabled="disabled" /> Tidak Dibayar
                    </label>
                    <input name="flag_catab" type="hidden" id="flag_catab" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Wajib<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_wajib_trx" id="saldo_wajib_trx" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <input name="saldo_wajib" type="hidden" id="saldo_wajib" />
                  <span class="add-on">,00</span>
                </div> 
                <label class="checkbox">
                  <input name="calculate_saldo_wajib" type="checkbox" class="form-control" id="calculate_saldo_wajib" disabled="disabled" /> Tidak Dibayar
                </label>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Angsuran Kelompok<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="saldo_kelompok_trx" id="saldo_kelompok_trx" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <input name="saldo_kelompok" type="hidden" id="saldo_kelompok" />
                  <span class="add-on">,00</span>
                </div> 
                <label class="checkbox">
                  <input name="calculate_saldo_kelompok" type="checkbox" class="form-control" id="calculate_saldo_kelompok" disabled="disabled" /> Tidak Dibayar
                </label>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Potongan Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
               <span class="add-on">Rp</span>
                  <input name="potongan_margin" id="potongan_margin" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                  </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Pembayaran<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
               <span class="add-on">Rp</span>
                  <input name="total_pembayaran" id="total_pembayaran" data-required="1" type="text" class="m-wrap mask-money" readonly="readonly" style="background-color:#eee;width:120px;"/>
               <span class="add-on">,00</span>
               </div> 
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Pelunasan<span class="required">*</span></label>
               <div class="controls">
                  <input name="tanggal_lunas" id="tanggal_lunas" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe KAS<span class="required">*</span></label>
               <div class="controls">
               	  <select name="cash_type2" id="cash_type2" disabled="disabled">
                  	<option value="">-- Pilih --</option>
                    <option value="0">Cash</option>
                    <option value="1">Pinbuk</option>
                  </select>
                  <input name="cash_type" type="hidden" id="cash_type" />
               </div>
            </div>
            <div class="control-group" id="t_cash">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
              <div class="controls">
                  <select id="account_cash_code2" name="account_cash_code2" disabled="disabled">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas){ ?>
                    <option value="<?php echo $kas['account_cash_code'] ?>"><?php echo $kas['account_cash_name'] ?></option>
                    <?php } ?>
                  </select>
                  <input name="account_cash_code" type="hidden" id="account_cash_code" />
               </div>
            </div>
            <div class="control-group" id="t_pinbuk">
               <label class="control-label">No. Rekening Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <input name="no_rek_tabungan" id="no_rek_tabungan" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="saldo_memo" id="saldo_memo" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
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
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
     
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$('#t_cash').hide();
$('#t_pinbuk').hide();

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#pelunasan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pelunasan_pembiayaan_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $('a#link-edit').live('click',function(){
		  $('#wrapper-table').hide();
		  $('#edit').show();

		  var account_financing_lunas_id = $(this).attr('account_financing_lunas_id');
		  var trx_account_financing_id = $(this).attr('trx_account_financing_id');

		  $.ajax({
			  type: 'POST',
			  dataType: 'json',
			  data: {account_financing_lunas_id:account_financing_lunas_id},
			  url: site_url+'rekening_nasabah/get_financing_by_id',
			  success: function(response){
				  var account_financing_id = response.account_financing_id;
				  var account_financing_no = response.account_financing_no;
				  var nama = response.nama;
				  var panggilan = response.panggilan;
				  var ibu_kandung = response.ibu_kandung;
				  var tmp_lahir = response.tmp_lahir;
				  var tgl_lahir = response.tgl_lahir;
				  var usia = response.usia;
				  var product_name = response.product_name;
				  var akad_name = response.akad_name;
				  var pokok = response.pokok;
				  var margin = response.margin;
				  var angsuran_pokok = response.angsuran_pokok;
				  var angsuran_margin = response.angsuran_margin;
				  var nisbah_bagihasil = response.nisbah_bagihasil;
				  var jangka_waktu = response.jangka_waktu;
				  var counter_angsuran = response.counter_angsuran;
				  var tanggal_jtempo = response.tanggal_jtempo;
				  var saldo_pokok = response.saldo_pokok;
				  var saldo_margin = response.saldo_margin;
				  var angsuran_catab = response.angsuran_catab;
				  var angsuran_tab_wajib = response.angsuran_tab_wajib;
				  var angsuran_tab_kelompok = response.angsuran_tab_kelompok;
				  var potongan_margin = response.potongan_margin;
				  var account_saving_no = response.account_saving_no;
				  var jenis_pembayaran = response.jenis_pembayaran;
				  var tanggal_lunas = response.tanggal_lunas;
				  var saldo_memo = response.saldo_memo;
				  var account_cash_code = response.account_cash_code;
				  var flag_catab = response.flag_catab;
				  var flag_wajib = response.flag_wajib;
				  var flag_kelompok = response.flag_kelompok;

				  var freq = response.jangka_waktu - response.counter_angsuran;
				  var catab_financing_lunas = counter_angsuran * angsuran_catab;
				  var wajib_financing_lunas = counter_angsuran * angsuran_tab_wajib;
				  var kelompok_financing_lunas = counter_angsuran * angsuran_tab_kelompok;
				  var catab_trx_financing = freq * angsuran_catab;
				  var wajib_trx_financing = freq * angsuran_tab_wajib;
				  var kelompok_trx_financing = freq * response.angsuran_tab_kelompok;
	
				  var saldo_hutang_pokok = angsuran_pokok * freq;
				  var saldo_hutang_margin = angsuran_margin * freq;
	
				  //var total_pembayaran = (parseFloat(saldo_hutang_pokok) + parseFloat(saldo_hutang_margin) + parseFloat(catab_trx_financing) + parseFloat(wajib_trx_financing) + parseFloat(kelompok_trx_financing)) - parseFloat(potongan_margin);
				  var total_pembayaran = parseFloat(saldo_hutang_pokok) + parseFloat(saldo_hutang_margin);

				  pokok = number_format(pokok,0,',','.');
				  margin = number_format(margin,0,',','.');
				  saldo_hutang_pokok = number_format(saldo_hutang_pokok,0,',','.');
				  saldo_hutang_margin = number_format(saldo_hutang_margin,0,',','.');
				  catab_trx_financing = number_format(catab_trx_financing,0,',','.');
				  saldo_memo = number_format(saldo_memo,0,',','.');
				  wajib_trx_financing = number_format(wajib_trx_financing,0,',','.');
				  kelompok_trx_financing = number_format(kelompok_trx_financing,0,',','.');
				  potongan_margin = number_format(potongan_margin,0,',','.');

				  $("#account_financing_lunas_id").val(account_financing_lunas_id);
				  $("#account_financing_id").val(account_financing_id);
				  $("#trx_account_financing_id").val(trx_account_financing_id);
				  $("#no_pembiayaan").val(account_financing_no);
				  $("#nama").val(nama);
				  $("#panggilan").val(panggilan);
				  $("#ibu_kandung").val(ibu_kandung);
				  $("#tmp_lahir").val(tmp_lahir);
				  $("#tgl_lahir").val(tgl_lahir);
				  $("#usia").val(usia);
				  $("#produk").val(product_name);
				  $("#akad").val(akad_name);
				  $("#pokok_pembiayaan").val(pokok);
				  $("#margin_pembiayaan").val(margin);
				  $("#nisbah_bagihasil").val(nisbah_bagihasil);
				  $("#jangka_waktu").val(jangka_waktu);
				  $("#counter_angsuran").val(counter_angsuran);
				  $("#freq").val(freq);
				  $("#tanggal_jtempo").val(tanggal_jtempo);
				  $("#saldo_pokok").val(saldo_hutang_pokok);
				  $("#saldo_margin").val(saldo_hutang_margin);
				  $("#saldo_tabungan").val(catab_financing_lunas);
				  $("#saldo_tabungan_trx").val(catab_trx_financing);
				  $("#saldo_wajib").val(wajib_financing_lunas);
				  $("#saldo_wajib_trx").val(wajib_trx_financing);
				  $("#saldo_kelompok").val(kelompok_financing_lunas);
				  $("#saldo_kelompok_trx").val(kelompok_trx_financing);
				  $("#debet_rekening").val(account_saving_no);
				  $("#saldo_catab").val(saldo_memo);
				  $("#potongan_margin").val(potongan_margin);
				  $("#tanggal_lunas").val(tanggal_lunas);
				  $("#flag_catab").val(flag_catab);
				  $("#flag_wajib").val(flag_wajib);
				  $("#flag_kelompok").val(flag_kelompok);

				  if(jenis_pembayaran == 0){
					  $('#t_cash').show();
					  $('#t_pinbuk').hide();
				  } else {
					  $('#t_cash').hide();
					  $('#t_pinbuk').show();
				  }

				  if(flag_catab == 1){
					  $('#calculate_saldo_catab').attr('checked',true);
					  $('#calculate_saldo_catab').closest('span').attr('class','checked');
					  angsuran_catab = 0;
				  } else {
					  $('#calculate_saldo_catab').attr('checked',false);
					  $('#calculate_saldo_catab').closest('span').attr('class','unchecked');
					  angsuran_catab = convert_numeric(catab_trx_financing);
				  }

				  if(flag_wajib == 1){
					  $('#calculate_saldo_wajib').attr('checked',true);
					  $('#calculate_saldo_wajib').closest('span').attr('class','checked');
					  angsuran_wajib = 0;
				  } else {
					  $('#calculate_saldo_wajib').attr('checked',false);
					  $('#calculate_saldo_wajib').closest('span').attr('class','unchecked');
					  angsuran_wajib = convert_numeric(wajib_trx_financing);
				  }

				  if(flag_kelompok == 1){
					  $('#calculate_saldo_kelompok').attr('checked',true);
					  $('#calculate_saldo_kelompok').closest('span').attr('class','checked');
					  angsuran_kelompok = 0;
				  } else {
					  $('#calculate_saldo_kelompok').attr('checked',false);
					  $('#calculate_saldo_kelompok').closest('span').attr('class','unchecked');
					  angsuran_kelompok = convert_numeric(kelompok_trx_financing);
				  }

				  potongan_margin = convert_numeric(potongan_margin);

				  total_pembayaran += parseFloat(angsuran_catab) + parseFloat(angsuran_wajib) + parseFloat(angsuran_kelompok) - parseFloat(potongan_margin);

				  total_pembayaran = number_format(total_pembayaran,0,',','.');

				  $("#total_pembayaran","#form_edit").val(total_pembayaran);
				  
				  $('#cash_type2').val(jenis_pembayaran).attr('selected',true);
				  $('#cash_type').val(jenis_pembayaran);
				  $('#account_cash_code2').val(account_cash_code).attr('selected',true);
				  $('#account_cash_code').val(account_cash_code);
				  $('#no_rek_tabungan').val(account_saving_no);
				  $('#saldo_memo').val(saldo_memo);
			  }
		  });

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              potongan_margin: {
                  required: true
              }
          },
         submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/proses_verifikasi_pelunasan_pembayaran_new",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#pelunasan_pembiayaan_table_filter input").val('');
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

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      $("#btn_reject").click(function(){

        var account_financing_lunas_id = $("#account_financing_lunas_id").val();
		var no_pembiayaan = $("#no_pembiayaan").val();
       
          var conf = confirm('Are you sure to Reject ?');
          if(conf){
            $.ajax({
              url: site_url+"rekening_nasabah/reject_data_pelunasan_pembiayaan",
              type: "POST",
              dataType: "json",
              data: {account_financing_lunas_id:account_financing_lunas_id,account_financing_no:no_pembiayaan},
              success: function(response){
                if(response.success==true){
                  alert("Reject!");
                  $("#cancel","#form_edit").trigger('click');
                }else{
                  alert("Reject Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          
        }

      });


      // begin first table
      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pelunasan_pembiayaan",
          // "fnServerParams": function ( aoData ) {
              // aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
          // },
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
            $('#pelunasan_pembiayaan_table').dataTable({
               "bDestroy":true,
               "bProcessing": true,
               "bServerSide": true,
               "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pelunasan_pembiayaan",
               "fnServerParams": function ( aoData ) {
                    aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
                },
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
               "sZeroRecords" : "Data Pada Rembug ini Kosong",
               "aoColumnDefs": [{
                       'bSortable': false,
                       'aTargets': [0]
                   }
               ]
            });
            // $(".dataTables_length,.dataTables_filter").parent().hide();


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


      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>

<!-- END JAVASCRIPTS -->
