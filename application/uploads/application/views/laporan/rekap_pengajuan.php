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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Laporan <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kantor Cabang</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekap Pengajuan Pembiayaan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
     <form id="form1" name="form1" method="post" action="javascript:;">
         <!-- BEGIN FILTER-->
         <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>" />
         <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>" />
         <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>" />
         <table>
           <tr>
             <td width="100">Cabang</td>
             <td><input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" value="<?php echo $this->session->userdata('branch_name'); ?>" readonly="readonly" style="background:#EEE"/>
               <?php
              if($this->session->userdata('flag_all_branch')=="1"){
              ?>
               <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_kantor_cabang">...</a>
               <?php } ?></td>
           </tr>
           <tr>
             <td>Pembiayaan</td>
             <td><select name="financing_type" id="financing_type" class="chosen m-wrap">
                <option value="" selected="selected">Pilih</option>
                <option value="9">Semua</option>
                <option value="0">Kelompok</option>
                <option value="1">Individu</option>
             </select></td>
           </tr>
           <tr>
             <td>Kategori</td>
             <td><select name="filter" id="filter" class="chosen m-wrap">
               <option value="" selected="selected">Pilih</option>
               <option value="1">Rembug</option>
               <option value="2">Petugas</option>
               <option value="3">Peruntukan</option>
             </select></td>
           </tr>
           <tr>
             <td>Tanggal</td>
             <td><input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:90px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
                        sd
                        <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:90px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;"></td>
           </tr>
           <tr>
             <td>&nbsp;</td>
             <td><button class="green btn" id="previewpdf">PDF</button>
               <button class="green btn" id="previewxls">Excel</button>
               <button class="green btn" id="previewcsv">CSV</button></td>
           </tr>
         </table>
         <!-- END FILTER-->
     </form>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

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
	/* BEGIN DIALOG ACTION BRANCH */
	$("a#browse_branch").click(function(){
	   keyword = $("#keyword","#dialog_kantor_cabang").val();
	   $.ajax({
			 type: "POST",
			 url: site_url+"cif/get_branch_by_keyword",
			 dataType: "json",
			 data: {keyword:keyword},
			 success: function(response){
				html = '';
				// html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				   html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				$("#result","#dialog_kantor_cabang").html(html);
			 }
		  })
	});
	
	  $("#keyword","#dialog_kantor_cabang").on('keypress',function(e){
		  if(e.which==13){
			$.ajax({
			  type: "POST",
			  url: site_url+"cif/search_cabang",
			  data: {keyword:$(this).val()},
			  dataType: "json",
			  success: function(response){
				var option = '';
				for(i = 0 ; i < response.length ; i++){
				   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'"  branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				// console.log(option);
				$("#result").html(option);
			  }
			});
		  }
	  });
	
	$("#select","#dialog_kantor_cabang").click(function(){
	  $(".close","#dialog_kantor_cabang").trigger('click');
	  branch_code = $("#result","#dialog_kantor_cabang").val();
	  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
	  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
	  $("#branch_code").val(branch_code);
	  $("#branch_name").val(branch_name);
	  $("#branch_id").val(branch_id);
	});
	
	$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
	  $("#select","#dialog_kantor_cabang").trigger('click');
	});
   /* END DIALOG ACTION BRANCH */

      $('#previewpdf').click(function(){
		  var cabang = $('#branch_code').val();
		  var pembiayaan = $('#financing_type').val();
		  var kategori = $('#filter').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var site = '<?php echo site_url('laporan_to_pdf/export_rekap_pengajuan_pembiayaan'); ?>';
		  var conf = true;
		  
		  if(pembiayaan == ''){
			  alert('Pembiayaan belum dipilih');
			  var conf = false;
		  }

		  if(kategori == ''){
			  alert('Kategori belum dipilih');
			  var conf = false;
		  }

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+cabang+'/'+pembiayaan+'/'+kategori+'/'+tanggal+'/'+tanggal2);
		  }
      });

      $('#previewxls').click(function(){
		  var cabang = $('#branch_code').val();
		  var pembiayaan = $('#financing_type').val();
		  var kategori = $('#filter').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var site = '<?php echo site_url('laporan_to_excel/export_rekap_pengajuan_pembiayaan'); ?>';
		  var conf = true;
		  
		  if(pembiayaan == ''){
			  alert('Pembiayaan belum dipilih');
			  var conf = false;
		  }

		  if(kategori == ''){
			  alert('Kategori belum dipilih');
			  var conf = false;
		  }

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+cabang+'/'+pembiayaan+'/'+kategori+'/'+tanggal+'/'+tanggal2);
		  }
      });

      $('#previewcsv').click(function(){
		  var cabang = $('#branch_code').val();
		  var pembiayaan = $('#financing_type').val();
		  var kategori = $('#filter').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var site = '<?php echo site_url('laporan_to_csv/export_rekap_pengajuan_pembiayaan'); ?>';
		  var conf = true;
		  
		  if(pembiayaan == ''){
			  alert('Pembiayaan belum dipilih');
			  var conf = false;
		  }

		  if(kategori == ''){
			  alert('Kategori belum dipilih');
			  var conf = false;
		  }

		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }

		  if(conf == true){
			  window.open(site+'/'+cabang+'/'+pembiayaan+'/'+kategori+'/'+tanggal+'/'+tanggal2);
		  }
      });
</script>
<!-- END JAVASCRIPTS -->

