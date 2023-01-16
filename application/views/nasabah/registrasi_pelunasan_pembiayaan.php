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
			Pelunasan Pembiayaan<small> Pengaturan Pembiayaan</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
			<li><a href="#">Pembiayaan Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Registrasi Pelunasan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('rekening_nasabah/proses_reg_pelunasan_pembayaran'); ?>" method="post" id="form_add" class="form-horizontal">
            <input type="hidden" id="account_financing_id" name="account_financing_id">
            <input type="hidden" id="account_financing_schedulle_id" name="account_financing_schedulle_id">
            <input type="hidden" id="periode_jangka_waktu" name="periode_jangka_waktu">
            <input type="hidden" id="jtempo_angsuran_next" name="jtempo_angsuran_next">
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Registrasi Pelunasan Pembiayaan Berhasil Diproses !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="no_pembiayaan" id="no_pembiayaan" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <!-- <input type="hidden" id="branch_code" name="branch_code"> -->
                     <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                     <!-- <input type="submit" id="filter" value="Filter" class="btn blue"> -->
                  </div>
            </div>

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
                  <input name="tanggal_lahir" id="tgl_lahir" type="text" class="m-wrap" readonly="" style="background-color:#eee;"/>
                  &nbsp;
                  <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" style="background-color:#eee;width:30px;" /> Tahun
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
                  <input name="pokok_pembiayaan" id="pokok_pembiayaan" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="angsuran_pokok" type="hidden" id="angsuran_pokok" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Margin Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <input name="margin_pembiayaan" id="margin_pembiayaan" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="angsuran_margin" type="hidden" id="angsuran_margin" />
                  <input name="angsuran_catab" type="hidden" id="angsuran_catab" />
                  <input name="angsuran_tab_wajib" type="hidden" id="angsuran_tab_wajib" />
                  <input name="angsuran_tab_kelompok" type="hidden" id="angsuran_tab_kelompok" />
                  Nisbah Bagi Hasil
                  &nbsp;
                  <span class="help-inline"></span>
                   <input name="nisbah_bagihasil" id="nisbah_bagihasil" data-required="1" style="background-color:#eee;width:50px;" type="text" class="m-wrap" readonly="readonly"/> %
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jangka Waktu Angsuran<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" class=" m-wrap" id="jangka_waktu" name="jangka_waktu" readonly=""  style="background-color:#eee;width:30px;"  maxlength="3" /> Bulan/Minggu/Hari
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
                  <input name="tanggal_jtempo" id="tanggal_jtempo" data-required="1" type="text" class="m-wrap" readonly="readonly" style="background-color:#eee;"/>
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
                  <input name="saldo_tabungan" type="hidden" id="saldo_tabungan" />
                  <span class="add-on">,00</span>
                </div> 
                <label class="checkbox">
                  <input name="calculate_saldo_catab" type="checkbox" class="form-control" id="calculate_saldo_catab" value="1" /> Tidak Dibayar
                </label>
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
                  <input name="calculate_saldo_wajib" type="checkbox" class="form-control" id="calculate_saldo_wajib" value="1" /> Tidak Dibayar
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
                  <input name="calculate_saldo_kelompok" type="checkbox" class="form-control" id="calculate_saldo_kelompok" value="1" /> Tidak Dibayar
                </label>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Potongan Margin<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="potongan_margin" id="potongan_margin" data-required="1" type="text" class="m-wrap mask-money" style="width:120px;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Total Pembayaran<span class="required">*</span></label>
               <div class="controls">
                <div class="input-prepend input-append">
                   <span class="add-on">Rp</span>
                  <input name="total_pembayaran" id="total_pembayaran" data-required="1" type="text" class="mask-money m-wrap" readonly="" style="background-color:#eee;width:120px;"/>
                  <span class="add-on">,00</span>
                </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tanggal Lunas<span class="required">*</span></label>
               <div class="controls">
                <input name="tanggal_lunas" id="tanggal_lunas" data-required="1" type="text" class="date-picker m-wrap" readonly="" style="background-color:#eee;width:120px;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe Kas<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium" id="cash_type" name="cash_type">
                    <option value="" selected="selected">PILIH TIPE KAS</option>
                    <option value="0">Cash</option>
                    <option value="1">Pinbuk</option>
                  </select>
               </div>
            </div>
            <div id="t_cash">
            <div class="control-group">
               <label class="control-label">Kas Petugas<span class="required">*</span></label>
               <div class="controls">
                  <select class="m-wrap medium chosen" id="account_cash_code" name="account_cash_code">
                    <option value="">PILIH KAS/BANK</option>
                    <?php foreach($account_cash as $kas){ ?>
                    <option value="<?php echo $kas['account_cash_code'] ?>"><?php echo $kas['account_cash_name'] ?></option>
                    <?php } ?>
                  </select>
               </div>
            </div>
            </div>
            <div id="t_pinbuk">
            <div class="control-group">
               <label class="control-label">No. Rekening Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <input name="no_rek_tabungan" id="no_rek_tabungan" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="saldo_memo" id="saldo_memo" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD REMBUG -->

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

$(function(){
	$('#t_cash').fadeOut();
	$('#t_pinbuk').fadeOut();

	  $('#browse_rembug').click(function(){
		  $("select#cif_type").trigger('change');
	  });

	$('#cash_type').change(function(){
		var cash_type = $(this).val();
		if(cash_type == '0'){
			$('#t_cash').fadeIn();
			$('#t_pinbuk').fadeOut();
		} else if(cash_type == '1'){
			$('#t_cash').fadeOut();
			$('#t_pinbuk').fadeIn();
		} else {
			$('#t_cash').fadeOut();
			$('#t_pinbuk').fadeOut();
		}
	});

    $("#select").click(function(){
        var no_pembiayaan = $("#result").val();
	     $("#close","#dialog_rembug").trigger('click');
        $("#no_pembiayaan").val(no_pembiayaan);
        var account_financing_no = no_pembiayaan;
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_financing_no:account_financing_no},
          url: site_url+"rekening_nasabah/get_cif_by_account_financing_no",
          success: function(response){
			  var account_financing_id = response.account_financing_id;
			  var account_financing_schedulle_id = response.account_financing_schedulle_id;
			  var periode_jangka_waktu = response.periode_jangka_waktu;
			  var jtempo_angsuran_next = response.jtempo_angsuran_next;
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
			  var potongan_margin = '0';
			  var account_saving_no = response.account_saving_no;
			  var saldo_memo = response.saldo_memo;

			  var freq = response.jangka_waktu - response.counter_angsuran;
			  var catab_financing_lunas = counter_angsuran * angsuran_catab;
			  var catab_trx_financing = freq * angsuran_catab;
			  var wajib_trx_financing = freq * angsuran_tab_wajib;
			  var kelompok_trx_financing = freq * response.angsuran_tab_kelompok;

			  var saldo_hutang_pokok = angsuran_pokok * freq;
			  var saldo_hutang_margin = angsuran_margin * freq;

			  var total_pembayaran = (parseFloat(saldo_hutang_pokok) + parseFloat(saldo_hutang_margin) + parseFloat(catab_trx_financing) + parseFloat(wajib_trx_financing) + parseFloat(kelompok_trx_financing)) - parseFloat(potongan_margin);

			  pokok = number_format(pokok,0,',','.');
			  margin = number_format(margin,0,',','.');
			  saldo_hutang_pokok = number_format(saldo_hutang_pokok,0,',','.');
			  saldo_hutang_margin = number_format(saldo_hutang_margin,0,',','.');
			  catab_trx_financing = number_format(catab_trx_financing,0,',','.');
			  saldo_memo = number_format(saldo_memo,0,',','.');
			  wajib_trx_financing = number_format(wajib_trx_financing,0,',','.');
			  kelompok_trx_financing = number_format(kelompok_trx_financing,0,',','.');
			  total_pembayaran = number_format(total_pembayaran,0,',','.');

            $("#account_financing_id").val(account_financing_id);
            $("#account_financing_schedulle_id").val(account_financing_schedulle_id);
            $("#periode_jangka_waktu").val(periode_jangka_waktu);
            $("#jtempo_angsuran_next").val(jtempo_angsuran_next);
            $("#nama").val(nama);
            $("#panggilan").val(panggilan);
            $("#ibu_kandung").val(ibu_kandung);
            $("#tmp_lahir").val(tmp_lahir);
            $("#tgl_lahir").val(tgl_lahir);
            $("#usia").val(usia);
            $("#produk").val(product_name);
            $("#akad").val(akad_name);
            $("#pokok_pembiayaan").val(pokok);
  	        $("#angsuran_pokok").val(angsuran_pokok);
            $("#margin_pembiayaan").val(margin);
    			  $("#angsuran_margin").val(angsuran_margin);
    			  $("#angsuran_catab").val(angsuran_catab);
    			  $("#angsuran_tab_wajib").val(angsuran_tab_wajib);
    			  $("#angsuran_tab_kelompok").val(angsuran_tab_kelompok);
            $("#jangka_waktu").val(jangka_waktu);
  	        $("#counter_angsuran").val(counter_angsuran);
            $("#nisbah_bagihasil").val(nisbah_bagihasil);
            $("#tanggal_jtempo").val(tanggal_jtempo);
            $("#saldo_pokok").val(saldo_hutang_pokok);
            $("#saldo_margin").val(saldo_hutang_margin);
            $("#saldo_tabungan").val(catab_financing_lunas);
  	        $("#saldo_tabungan_trx").val(catab_trx_financing);
            $("#no_rek_tabungan").val(account_saving_no);
    			  $("#saldo_memo").val(saldo_memo);
    			  $('#potongan_margin').val(potongan_margin);
    			  $('#freq').val(freq);
    			  $('#counter_angsuran').val(counter_angsuran);
    			  $("#saldo_wajib").val(wajib_trx_financing);
    			  $("#saldo_wajib_trx").val(wajib_trx_financing);
    			  $("#saldo_kelompok").val(kelompok_trx_financing);
    			  $("#saldo_kelompok_trx").val(kelompok_trx_financing);
    			  $('#total_pembayaran').val(total_pembayaran);
		  }
		});
  });

         $("#result option").live('dblclick',function(){
          $("#select").trigger('click');
         });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });
		
		  $('#calculate_saldo_catab,#calculate_saldo_wajib,#calculate_saldo_kelompok').click(function(){
			  var f_cek = $('#calculate_saldo_catab').is(':checked');
			  var f_cek_wajib = $('#calculate_saldo_wajib').is(':checked');
			  var f_cek_kelompok = $('#calculate_saldo_kelompok').is(':checked');
			  var saldo_pokok = parseFloat(convert_numeric($("#saldo_pokok").val()));
			  var saldo_margin = parseFloat(convert_numeric($("#saldo_margin").val()));
			  var saldo_tabungan = parseFloat($("#saldo_tabungan").val());
			  var saldo_tabungan_trx = parseFloat(convert_numeric($("#saldo_tabungan_trx").val()));
			  var saldo_wajib = parseFloat($("#saldo_wajib").val());
			  var saldo_wajib_trx = parseFloat(convert_numeric($("#saldo_wajib_trx").val()));
			  var saldo_kelompok = parseFloat($("#saldo_kelompok").val());
			  var saldo_kelompok_trx = parseFloat(convert_numeric($("#saldo_kelompok_trx").val()));

			  if(f_cek){
				  saldo_tabungan = 0;
			  } else {
				  saldo_tabungan = saldo_tabungan_trx;
			  }

			  if(f_cek_wajib){
				  saldo_wajib = 0;
			  } else {
				  saldo_wajib = saldo_wajib_trx;
			  }

			  if(f_cek_kelompok){
				  saldo_kelompok = 0;
			  } else {
				  saldo_kelompok = saldo_kelompok_trx;
			  }

			  var total_pembayaran = (saldo_pokok + saldo_margin + saldo_tabungan + saldo_wajib + saldo_kelompok) - parseFloat(convert_numeric($('#potongan_margin').val()));

			  $('#total_pembayaran').val(number_format(total_pembayaran,0,',','.'));
		  });

       $("#potongan_margin","#form_add").change(function(){
		   var margin = parseFloat(convert_numeric($(this).val()));
		   var f_cek_catab = $('#calculate_saldo_catab').is(':checked');
		   var f_cek_wajib = $('#calculate_saldo_wajib').is(':checked');
		   var f_cek_kelompok = $('#calculate_saldo_kelompok').is(':checked');
		   var saldo_pokok = parseFloat(convert_numeric($("#saldo_pokok").val()));
		   var saldo_margin = parseFloat(convert_numeric($("#saldo_margin").val()));
		   var saldo_tabungan = parseFloat($("#saldo_tabungan").val());
		   var saldo_tabungan_trx = parseFloat(convert_numeric($("#saldo_tabungan_trx").val()));
		   var saldo_wajib = parseFloat($("#saldo_wajib").val());
		   var saldo_wajib_trx = parseFloat(convert_numeric($("#saldo_wajib_trx").val()));
		   var saldo_kelompok = parseFloat($("#saldo_kelompok").val());
		   var saldo_kelompok_trx = parseFloat(convert_numeric($("#saldo_kelompok_trx").val()));

			  if(f_cek_catab){
				  saldo_tabungan = 0;
			  } else {
				  saldo_tabungan = saldo_tabungan_trx;
			  }

			  if(f_cek_wajib){
				  saldo_wajib = 0;
			  } else {
				  saldo_wajib = saldo_wajib_trx;
			  }

			  if(f_cek_kelompok){
				  saldo_kelompok = 0;
			  } else {
				  saldo_kelompok = saldo_kelompok_trx;
			  }

			  var total_pembayaran = (saldo_pokok + saldo_margin + saldo_tabungan + saldo_wajib + saldo_kelompok) - parseFloat(convert_numeric($('#potongan_margin').val()));

		   $("#total_pembayaran","#form_add").val(number_format(total_pembayaran,0,',','.')).attr("readonly",true);
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
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:''},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
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
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
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
              url: site_url+"cif/search_cif_for_pelunasan_pembiayaan",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].account_financing_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].account_financing_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          if(cm_code=="")
          {
            $("#result").html('');
          }
        });
      
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

      // BEGIN FORM ADD REMBUG VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
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
              no_pembiayaan: {
                  required: true
              },
              potongan_margin: {
                  required: true
              },
              tanggal_lunas: {
                  required: true,
                  cek_trx_kontrol_periode: true
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

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true){
			form1.ajaxForm({
				data: form1.serialize(),
				dataType: "json",
				success: function(response) {
					if(response.success==true){
						success1.show();
						error1.hide();
						form1.trigger('reset');
						form1.children('div.control-group').removeClass('success');
                	}else{
						success1.hide();
						error1.show();
						alert(response.message);
                	}
                	App.scrollTo(success1, -200);
              	},
              	error:function(){
					success1.hide();
					error1.show();
					App.scrollTo(success1, -200);
              	}
          	});
        } else {
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

      // begin first table
      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pelunasan_pembiayaan_setup",
          "aoColumns": [
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
          "iDisplayLength": 5,
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

      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
