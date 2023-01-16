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
			Re-Scheduling
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li>
			   <li><a href="#">Re-Scheduling</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<div id="dialog_src_account_financing_no" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- BEGIN ADD DEPOSITO -->
<div id="add">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Re-Scheduling</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_act" class="form-horizontal">
            <input type="hidden" id="cif_type">
            <input type="hidden" id="cif_no" name="cif_no">
            <input type="hidden" name="product_code" id="product_code"/>
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Droping telah dikoreksi!
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">No. Pembiayaan<span class="required">*</span></label>
                  <div class="controls">
                     <input type="text" name="account_financing_no" id="account_financing_no" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                     <a id="browse_account_financing_no" class="btn blue" data-toggle="modal" href="#dialog_src_account_financing_no">...</a>
                  </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lengkap</label>
               <div class="controls">
                  <input name="nama" id="nama" type="text" data-required="1" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Ibu Kandung</label>
               <div class="controls">
                  <input name="nama_ibukandung" id="nama_ibukandung" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tempat Lahir</label>
               <div class="controls">
                  <input name="tempatlahir" id="tempatlahir" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <span style="line-height:33px;">Tanggal Lahir&nbsp;</span>
                  <input name="tanggallahir" id="tanggallahir" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                  <input name="usia" id="usia" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background-color:#eee;"/>
               </div>
            </div>
            <div class="control-group" id="wrap_cm_name" style="display:none;">
               <label class="control-label">Majelis</label>
               <div class="controls">
                  <input name="cm_name" id="cm_name" data-required="1" type="text" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
               </div>
            </div>
            <hr size="1">
            <div class="row-fluid">
              <div class="span6" id="datasebelumnya">
                <h3>Data Sebelum Pembaharuan</h3>
                <div class="control-group">
                   <label class="control-label">Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="pokok_o" id="pokok_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="margin_o" id="margin_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldopokok_o" id="saldopokok_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldomargin_o" id="saldomargin_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldocatab_o" id="saldocatab_o" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Jangka Waktu</label>
                   <div class="controls">
                     <input name="jangkawaktu_o" id="jangkawaktu_o" data-required="1" type="text" class="m-wrap" readonly="readonly" style="width:30px;background-color:#eee;"/>
                     <select class="m-wrap medium" style="background-color:#eee;" disabled="disabled" id="pjw_o">
                       <option value="">PILIH</option>
                       <option value="0">Harian</option>
                       <option value="1">Mingguan</option>
                       <option value="2">Bulanan</option>
                       <option value="3">Jatuh Tempo</option>
                     </select>
                     <input type="hidden" name="periodejangkawaktu_o" id="periodejangkawaktu_o">
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranpokok_o" id="angsuranpokok_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranmargin_o" id="angsuranmargin_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurancatab_o" id="angsurancatab_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Wajib</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabwajib_o" id="angsurantabwajib_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Kelompok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabkelompok_o" id="angsurantabkelompok_o" data-required="1" type="text" class="small mask-money m-wrap" readonly="readonly" style="background-color:#eee;"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Akad</label>
                   <div class="controls">
                      <input name="tanggalakad_o" id="tanggalakad_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Mulai Angsur</label>
                   <div class="controls">
                      <input name="tanggalmulaiangsur_o" id="tanggalmulaiangsur_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Jtempo</label>
                   <div class="controls">
                      <input name="tanggaljtempo_o" id="tanggaljtempo_o" data-required="1" type="text" class="small m-wrap" readonly="readonly" style="background-color:#eee;"/>
                   </div>
                </div>
              </div>
              <div class="span6" id="datasetelahnya">
              <h3>Data Setelah Pembaharuan</h3>
                <div class="control-group">
                   <label class="control-label">Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldopokok_n" id="saldopokok_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldomargin_n" id="saldomargin_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="saldocatab_n" id="saldocatab_n" data-required="1" type="text" class="small m-wrap mask-money" readonly="readonly" style="background:#EEE"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Saldo Jangka Waktu</label>
                   <div class="controls">
                     <input name="jangkawaktu_n" id="jangkawaktu_n" data-required="1" type="text" class="m-wrap" style="width:30px;"/>
                     <select class="m-wrap medium" id="periodejangkawaktu_n" name="periodejangkawaktu_n">
                      <option value="">PILIH</option>
                      <option value="0">Harian</option>
                      <option value="1">Mingguan</option>
                      <option value="2">Bulanan</option>
                      <option value="3">Jatuh Tempo</option>
                     </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Pokok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranpokok_n" id="angsuranpokok_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Margin</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsuranmargin_n" id="angsuranmargin_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Angsuran Catab</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurancatab_n" id="angsurancatab_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Wajib</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabwajib_n" id="angsurantabwajib_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tabungan Kelompok</label>
                   <div class="controls">
                      <div class="input-prepend input-append">
                        <span class="add-on">Rp</span>
                          <input name="angsurantabkelompok_n" id="angsurantabkelompok_n" data-required="1" type="text" class="small m-wrap mask-money"/>
                        <span class="add-on">.00</span>
                      </div>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Pembaharuan Ke</label>
                   <div class="controls">
                      <input name="reschedule_ke" id="reschedule_ke" data-required="1" type="text" class="m-wrap" style="width:30px;"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tgl. Pembaharuan/Akad</label>
                   <div class="controls">
                      <input name="tanggal_reschedule" id="tanggal_reschedule" data-required="1" type="text" placeholder="dd/mm/yyyy" class="date-picker date-mask small m-wrap"/>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Mulai Angsur</label>
                   <div class="controls">
                      <input name="tanggalmulaiangsur_n" id="tanggalmulaiangsur_n" data-required="1" type="text" placeholder="dd/mm/yyyy" class="date-picker date-mask small m-wrap" />
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Tanggal Jtempo</label>
                   <div class="controls">
                      <input name="tanggaljtempo_n" id="tanggaljtempo_n" data-required="1" type="text" placeholder="dd/mm/yyyy" class="date-picker date-mask small m-wrap" />
                   </div>
                </div>
              </div>
            </div>
            <div class="form-actions">
               <button type="button" class="btn green" id="koreksi">Proses Re-Scheduling</button>
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
    
      $(".date-mask").inputmask("d/m/y");  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
  
  $("#browse_account_financing_no").click(function(e){
    e.preventDefault();
    setTimeout(function(){
      $("#keyword","#dialog_src_account_financing_no").focus();
    },600)
  });

  $("#keyword","#dialog_src_account_financing_no").keypress(function(e){
    if(e.keyCode==13){
      e.preventDefault();
	  type = $("#cif_type").val();
      $.ajax({
        type:"POST",
        dataType:"json",
        data:{keyword:$(this).val(),status_rekening:1,cm_code:$('#cm option:selected').val(),cif_type:type},
        url:site_url+"rekening_nasabah/search_account_financing_no",
        success:function(response){
          var opt = '';
          for(i=0;i<response.length;i++){
            txt_cm_name='';
            if(response[i].cm_name!=""){
              txt_cm_name=' - '+response[i].cm_name;
            }
            opt += '<option value="'+response[i].account_financing_no+'" cm_name="'+response[i].cm_name+'" cif_type="'+response[i].cif_type+'" nama="'+response[i].nama+'" ibu_kandung="'+response[i].ibu_kandung+'" tmp_lahir="'+response[i].tmp_lahir+'" tgl_lahir="'+response[i].tgl_lahir+'" usia="'+response[i].usia+'" pokok="'+response[i].pokok+'" margin="'+response[i].margin+'" saldo_pokok="'+response[i].saldo_pokok+'" saldo_margin="'+response[i].saldo_margin+'" saldo_catab="'+response[i].saldo_catab+'" jangka_waktu="'+response[i].jangka_waktu+'" periode_jangka_waktu="'+response[i].periode_jangka_waktu+'" angsuran_pokok="'+response[i].angsuran_pokok+'" angsuran_margin="'+response[i].angsuran_margin+'" angsuran_catab="'+response[i].angsuran_catab+'" tanggal_akad="'+response[i].tanggal_akad+'" tanggal_jtempo="'+response[i].tanggal_jtempo+'" product_name="'+response[i].product_name+'" pembaharuan_ke="'+response[i].pembaharuan_ke+'" cif_no="'+response[i].cif_no+'" product_code="'+response[i].product_code+'" tanggal_mulai_angsur="'+response[i].tanggal_mulai_angsur+'" angsuran_tab_wajib="'+response[i].angsuran_tab_wajib+'" angsuran_tab_kelompok="'+response[i].angsuran_tab_kelompok+'">'+response[i].account_financing_no+' - '+response[i].nama+txt_cm_name+'</option>';
          }
          $("#result","#dialog_src_account_financing_no").html(opt);
        },
        error:function(){
          alert("Something wrong when searching account. Please contact administrator!");
        }
      });
    }
  });

  $("#result","#dialog_src_account_financing_no").dblclick(function(e){
    if($(this).val()!=""){
      $("#select","#dialog_src_account_financing_no").trigger('click');
    }
  })

	  $('#browse_account_financing_no').click(function(){
		  $("select#cif_type").trigger('change');
	  });

        $("#cif_type").change(function(){
          type = $("#cif_type").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/search_account_financing_no",
              data: {keyword:$("#keyword").val(),status_rekening:1,cm_code:'',cif_type:type},
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

  $("#select","#dialog_src_account_financing_no").click(function(e){
    e.preventDefault();
    $("#close","#dialog_src_account_financing_no").trigger('click');
    res = $("#result","#dialog_src_account_financing_no");
    opt_res = res.find('option:selected');
    account_financing_no=res.val();
    cif_type=opt_res.attr('cif_type');
    cm_name=opt_res.attr('cm_name');
    nama=opt_res.attr('nama');
    ibu_kandung=(opt_res.attr('ibu_kandung')=='null')?'':opt_res.attr('ibu_kandung');
    tmp_lahir=(opt_res.attr('tmp_lahir')=='null')?'':opt_res.attr('tmp_lahir');
    tgl_lahir=opt_res.attr('tgl_lahir');
    usia=opt_res.attr('usia');
    pokok=opt_res.attr('pokok');
    margin=opt_res.attr('margin');
    saldo_pokok=opt_res.attr('saldo_pokok');
    saldo_margin=opt_res.attr('saldo_margin');
    saldo_catab=opt_res.attr('saldo_catab');
    jangka_waktu=opt_res.attr('jangka_waktu');
    periode_jangka_waktu=opt_res.attr('periode_jangka_waktu');
    angsuran_pokok=opt_res.attr('angsuran_pokok');
    angsuran_margin=opt_res.attr('angsuran_margin');
    angsuran_catab=opt_res.attr('angsuran_catab');
    tanggal_akad=opt_res.attr('tanggal_akad');
    tanggal_jtempo=opt_res.attr('tanggal_jtempo');
    pembaharuan_ke=opt_res.attr('pembaharuan_ke');
    cif_no=opt_res.attr('cif_no');
    product_code=opt_res.attr('product_code');
    tanggal_mulai_angsur=opt_res.attr('tanggal_mulai_angsur');
    angsuran_tab_wajib=opt_res.attr('angsuran_tab_wajib');
    angsuran_tab_kelompok=opt_res.attr('angsuran_tab_kelompok');

    /*tgl_lahir*/
    tl=tgl_lahir.split('-');
    tgl_lahir=tl[2]+'/'+tl[1]+'/'+tl[0];
    /*convert_tanggal_akad*/
    ta=tanggal_akad.split('-');
    tanggal_akad=ta[2]+'/'+ta[1]+'/'+ta[0];
    /*convert_tanggal_mulai_angsur*/
    tma=tanggal_mulai_angsur.split('-');
    tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0];
    /*convert_tanggal_jtempo*/
    tjt=tanggal_jtempo.split('-');
    tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];

    if(cm_name!=""){
      $("#wrap_cm_name").show();
      $("#cm_name").val(cm_name);
    }else{
      $("#wrap_cm_name").hide();
      $("#cm_name").val('');
    }


    $("#account_financing_no").val(account_financing_no);
    $("#cif_no").val(cif_no);
    $("#product_code").val(product_code);
    $("#cif_type").val(cif_type);
    $("#nama").val(nama);
    $("#nama_ibukandung").val(ibu_kandung);
    $("#tempatlahir").val(tmp_lahir);
    $("#tanggallahir").val(tgl_lahir);
    $("#usia").val(usia);
    
    $("#pokok_o").val(number_format(pokok,0,',','.'));
    $("#margin_o").val(number_format(margin,0,',','.'));
    
    $("#saldopokok_o,#saldopokok_n").val(number_format(saldo_pokok,0,',','.'));
    $("#saldomargin_o,#saldomargin_n").val(number_format(saldo_margin,0,',','.'));
    $("#saldocatab_o,#saldocatab_n").val(number_format(saldo_catab,0,',','.'));

    $("#jangkawaktu_o").val(jangka_waktu);
    var counterangsuran=saldo_pokok/angsuran_pokok;
    $("#jangkawaktu_n").val(counterangsuran);
    $("#pjw_o").val(opt_res.attr('periode_jangka_waktu'));
    $("#periodejangkawaktu_o,#periodejangkawaktu_n").val(opt_res.attr('periode_jangka_waktu'));
    
    $("#angsuranpokok_o,#angsuranpokok_n").val(number_format(angsuran_pokok,0,',','.'));
    $("#angsuranmargin_o,#angsuranmargin_n").val(number_format(angsuran_margin,0,',','.'));
    $("#angsurancatab_o,#angsurancatab_n").val(number_format(angsuran_catab,0,',','.'));
    $("#angsurantabwajib_o,#angsurantabwajib_n").val(number_format(angsuran_tab_wajib,0,',','.'));
    $("#angsurantabkelompok_o,#angsurantabkelompok_n").val(number_format(angsuran_tab_kelompok,0,',','.'));

    $("#tanggalakad_o").val(tanggal_akad);
    $("#tanggalmulaiangsur_o").val(tanggal_mulai_angsur);
    $("#tanggaljtempo_o").val(tanggal_jtempo);
    $("#tanggal_reschedule").val('');
    $("#tanggalmulaiangsur_n").val('');
    $("#tanggaljtempo_n").val('');
    
    $("#reschedule_ke").val(parseFloat(pembaharuan_ke)+1);
  });

  /*change saldo margin*/
  $("#saldomargin_n").change(function(){
    saldomargin=convert_numeric($("#saldomargin_n").val());
    jangkawaktu=$("#jangkawaktu_n").val();
    angsuranmargin=parseFloat(saldomargin)/parseFloat(jangkawaktu);
    $("#angsuranmargin_n").val(number_format(angsuranmargin,0,',','.'));
  });

  /*change periode jangka waktu*/
  $("#periodejangkawaktu_n").change(function(){
    $("#jangkawaktu_n").trigger('change');
  })

  /*change jangka waktu*/
  $("#jangkawaktu_n").change(function(){
    jangkawaktu=$("#jangkawaktu_n").val();
    saldopokok=convert_numeric($("#saldopokok_n").val());
    angsuranpokok=parseFloat(saldopokok)/parseFloat(jangkawaktu);
    $("#angsuranpokok_n").val(number_format(angsuranpokok,0,',','.'));

    saldomargin=convert_numeric($("#saldomargin_n").val());
    angsuranmargin=parseFloat(saldomargin)/parseFloat(jangkawaktu);
    $("#angsuranmargin_n").val(number_format(angsuranmargin,0,',','.'));

    /*hitung tanggal mulai angsur & jtempo*/
    var cif_type=$("#cif_type").val();
    var tanggal_reschedule=$("#tanggal_reschedule").val();
    var periodejangkawaktu_n=$("#periodejangkawaktu_n").val();
    // var jangkawaktuterbayar=parseFloat($("#jangkawaktu_o").val())-parseFloat(parseFloat(convert_numeric($("#saldopokok_o").val()))/parseFloat(convert_numeric($("#angsuranpokok_o").val())));
    // var ttljangkawaktu=parseFloat(jangkawaktu)+parseFloat(jangkawaktuterbayar);
    if(tanggal_reschedule.replace(/\//g,'')!="")
    {
      /*mulai angsur*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_mulai_angsur_for_rescheduling",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0];
          }
          $("#tanggalmulaiangsur_n").val(response.tanggal_mulai_angsur);
        }
      })

      /*jtempo*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          jangka_waktu:jangkawaktu,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_jatuh_tempo_for_rescheduling",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("#tanggaljtempo_n").val(response.tanggal_jtempo);
        }
      })
    }
  });
  
  /*change angsuran pokok*/
  $("#angsuranpokok_n").change(function(){
    angsuranpokok=convert_numeric($("#angsuranpokok_n").val());
    saldopokok=convert_numeric($("#saldopokok_n").val());
    jangkawaktu=parseFloat(saldopokok)/parseFloat(angsuranpokok);
    if(jangkawaktu==Infinity){
      $("#jangkawaktu_n").val(0);
    }else{
      $("#jangkawaktu_n").val(jangkawaktu);
    }

    saldomargin=convert_numeric($("#saldomargin_n").val());
    angsuranmargin=parseFloat(saldomargin)/parseFloat(jangkawaktu);
    $("#angsuranmargin_n").val(number_format(angsuranmargin,0,',','.'));

    /*hitung tanggal jtempo*/
    var cif_type=$("#cif_type").val();
    var tanggal_reschedule=$("#tanggal_reschedule").val();
    var periodejangkawaktu_n=$("#periodejangkawaktu_n").val();
    // var jangkawaktuterbayar=parseFloat($("#jangkawaktu_o").val())-parseFloat(parseFloat(convert_numeric($("#saldopokok_o").val()))/parseFloat(convert_numeric($("#angsuranpokok_o").val())));
    // var ttljangkawaktu=parseFloat(jangkawaktu)+parseFloat(jangkawaktuterbayar);
    if(tanggal_reschedule.replace(/\//g,'')!="")
    {
      /*mulai angsur*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_mulai_angsur_for_rescheduling",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0];
          }
          $("#tanggalmulaiangsur_n").val(response.tanggal_mulai_angsur);
        }
      })

      /*jtempo*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          jangka_waktu:jangkawaktu,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_jatuh_tempo_for_rescheduling",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("#tanggaljtempo_n").val(response.tanggal_jtempo);
        }
      })
    }
  })
  
  /*change angsuran margin*/
  $("#angsuranmargin_n").change(function(){
    angsuranmargin=convert_numeric($("#angsuranmargin_n").val());
    saldomargin=convert_numeric($("#saldomargin_n").val());
    jangkawaktu=parseFloat(saldomargin)/parseFloat(angsuranmargin);
    if(jangkawaktu==Infinity){
      $("#jangkawaktu_n").val(0);
    }else{
      $("#jangkawaktu_n").val(jangkawaktu);
    }

    saldopokok=convert_numeric($("#saldopokok_n").val());
    angsuranpokok=parseFloat(saldopokok)/parseFloat(jangkawaktu);
    $("#angsuranpokok_n").val(number_format(angsuranpokok,0,',','.'));

    /*hitung tanggal jtempo*/
    var cif_type=$("#cif_type").val();
    var tanggal_reschedule=$("#tanggal_reschedule").val();
    var periodejangkawaktu_n=$("#periodejangkawaktu_n").val();
    // var jangkawaktuterbayar=parseFloat($("#jangkawaktu_o").val())-parseFloat(parseFloat(convert_numeric($("#saldopokok_o").val()))/parseFloat(convert_numeric($("#angsuranpokok_o").val())));
    // var ttljangkawaktu=parseFloat(jangkawaktu)+parseFloat(jangkawaktuterbayar);
    if(tanggal_reschedule.replace(/\//g,'')!="")
    {
      /*mulai angsur*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_mulai_angsur_for_rescheduling",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0];
          }
          $("#tanggalmulaiangsur_n").val(response.tanggal_mulai_angsur);
        }
      })
      /*jtempo*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          jangka_waktu:jangkawaktu,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_jatuh_tempo_for_rescheduling",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("#tanggaljtempo_n").val(response.tanggal_jtempo);
        }
      })
    }
  })

  $("#tanggal_reschedule").change(function(){
    /*hitung tanggal jtempo*/
    var cif_type=$("#cif_type").val();
    var tanggal_reschedule=$("#tanggal_reschedule").val();
    var jangkawaktu=$("#jangkawaktu_n").val();
    var periodejangkawaktu_n=$("#periodejangkawaktu_n").val();
    // var jangkawaktuterbayar=parseFloat($("#jangkawaktu_o").val())-parseFloat(parseFloat(convert_numeric($("#saldopokok_o").val()))/parseFloat(convert_numeric($("#angsuranpokok_o").val())));
    // var ttljangkawaktu=parseFloat(jangkawaktu)+parseFloat(jangkawaktuterbayar);
    if(tanggal_reschedule.replace(/\//g,'')!="")
    {
      /*mulai angsur*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_mulai_angsur_for_rescheduling",
        success:function(response){
          if(response.tanggal_mulai_angsur!=''){
            tma=response.tanggal_mulai_angsur.split('-');
            response.tanggal_mulai_angsur=tma[2]+'/'+tma[1]+'/'+tma[0];
          }
          $("#tanggalmulaiangsur_n").val(response.tanggal_mulai_angsur);
        }
      })
      /*jtempo*/
      $.ajax({
        type:"POST",
        dataType:"json",data:{
          tgl_akad:tanggal_reschedule,
          jangka_waktu:jangkawaktu,
          periode_jangka_waktu:periodejangkawaktu_n,
          cif_type:cif_type
        },
        async:false,
        url:site_url+"/rekening_nasabah/get_tanggal_jatuh_tempo_for_rescheduling",
        success:function(response){
          if(response.tanggal_jtempo!=''){
            tjt=response.tanggal_jtempo.split('-');
            response.tanggal_jtempo=tjt[2]+'/'+tjt[1]+'/'+tjt[0];
          }
          $("#tanggaljtempo_n").val(response.tanggal_jtempo);
        }
      })
    }
  })

  /*UP UNTUK FUNGSI ADD ENTER*/
  $("input,select").live('keypress',function(e){

    if(e.keyCode==13)
    {
     e.preventDefault();
      if($(this).next().prop('tagName')=='SELECT' || $(this).next().prop('tagName')=='INPUT')
      {
        $(this).next().focus();
      }
      else
      {

        if($(this).closest('.control-group').next('.form-actions').length==1){
          $(this).closest('.control-group').next('.form-actions').find('button:first').focus();
        }else{
          if(typeof($(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').attr('readonly'))!='undefined'){
            $(this).closest('.control-group').nextAll('.control-group2:visible').filter(':first').find('input,select').focus();
          }else{
            $(this).closest('.control-group').nextAll('.control-group:visible').filter(':first').find('input,select').focus();
          }
        }
        
      }
    }
    
  });

  /* FORM ACTION */
  form=$("#form_act");
  $("#koreksi").click(function(e){
    e.preventDefault();
    account_financing_no=$("#account_financing_no");
    saldomargin_n=$("#saldomargin_n").val();
    jangkawaktu_n=$("#jangkawaktu_n").val();
    periodejangkawaktu_n=$("#periodejangkawaktu_n").val();
    angsuranpokok_n=$("#angsuranpokok_n").val();
    angsuranmargin_n=$("#angsuranmargin_n").val();
    angsurancatab_n=$("#angsurancatab_n").val();
    angsurantabwajib_n=$("#angsurantabwajib_n").val();
    angsurantabkelompok_n=$("#angsurantabkelompok_n").val();
    reschedule_ke=$("#reschedule_ke").val();
    tanggal_reschedule=$("#tanggal_reschedule").val().replace(/\_/g,'').replace(/\//g,'');
    bValid=true;

    if(account_financing_no.val()==""){
      alert("Mohon pilih No.Pembiayaan terlebih dahulu!")
      bValid=false;
    }else if(saldomargin_n=="" || jangkawaktu_n=="" || periodejangkawaktu_n=="" || angsuranpokok_n=="" || angsuranmargin_n=="" || angsurancatab_n=="" || reschedule_ke=="" || tanggal_reschedule=="" || angsurantabwajib_n=="" || angsurantabkelompok_n==""){
      alert("Mohon isi Field yang Kosong!");
      bValid=false;
    }

    if(bValid==true){

      var conf = confirm("Memproses Re-Scheduling. Apakah Anda yakin?");

      if(conf)
      {

        $.ajax({
          type:"POST",
          dataType:"json",
          data:form.serialize(),
          url:site_url+"rekening_nasabah/proses_rescheduling",
          async: false,
          success: function(response){
            if(response.success===true){
              alert("Re-Scheduling SUKSES!");
            }else{
              alert("Something wrong when processing. Please contact your Adminstrator!");
            }
            window.location.reload(true);
          },
          error: function(){
            alert("Something wrong when processing. Please contact your Adminstrator!");
          }
        });
          
      }

    }

  })


});
</script>
<!-- END JAVASCRIPTS -->
