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
        Laporan Keuangan Sementara <small>untuk melihat laporan keuangan</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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
<div id="dialog_popup" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
     <h3>Konfirmasi</h3>
  </div>
  <div class="modal-body">
     <div class="row-fluid">
        <div class="span12">
           <h4>Apakah Anda ingin menggunakan breakdown?</h4>
           <p><label><input type="radio" name="breakdown" value="T" id="breakdown" checked="checked" />Tidak</label>
           <label><input type="radio" name="breakdown" value="Y" id="breakdown" />Ya (Memerlukan waktu sedikit lebih lama)</label></p>
        </div>
     </div>
  </div>
  <div class="modal-footer">
     <button type="button" id="close" data-dismiss="modal" class="btn">Tutup</button>
     <button type="button" id="select" class="btn blue">Proses</button>
  </div>
</div>

<!-- BEGIN FORM-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Keuangan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
    <div class="portlet-body form">
       <!-- BEGIN FILTER FORM -->
       <form>
          <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
          <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
          <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
          <table id="filter-form">
             <tr>
                <td width="100">Cabang</td>
                <td>
                   <input type="text" name="branch" readonly class="m-wrap medium" style="background:#EEE;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                   <?php if($this->session->userdata('flag_all_branch')=="1"){ ?>
                   <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
                   <?php } ?>

                </td>
             </tr>
             <tr>
               <td>Jenis</td>
               <td><select name="jenis" class="m-wrap chosen" id="jenis">
                 <option value="" selected="selected">-- Pilih --</option>
                 <option value="10">Neraca</option>
                 <option value="11">Neraca Rinci</option>
                 <option value="20">Laba Rugi</option>
                 <option value="21">Laba Rugi Rinci</option>
                 <option value="30">Trial Balance</option>
               </select></td>
             </tr>
             <tr>
                <td>Tanggal</td>
                <td><input type="text" id="tanggal" name="tanggal" class="m-wrap small date-picker mask_date" value="<?php echo date('d/m/Y') ?>"></td>
             </tr>
             <tr>
                <td>&nbsp;</td>
                <td><button class="green btn" id="previewpdf">PDF</button>
                <button class="green btn hidden" id="previewxls">Excel</button>
                <a id="xlspopup" class="green btn" data-toggle="modal" href="#dialog_popup">Excel</a></td>
             </tr>
          </table>
       </form>
       <!-- END FILTER FORM -->
       <hr size="1">
    </div>
</div>

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>   
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:$("#keyword","#dialog_branch").val()},
         success: function(response){
              html = '';
            // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   })

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
            dataType: "json",
            data: {keyword:keyword},
            success: function(response){
              html = '';
               // html = '<option value="0000" branch_code="0000" branch_name="Semua Branch">Semua Branch</option>';
               for ( i = 0 ; i < response.length ; i++ )
               {
                  html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_popup").click(function(){
     $('#previewxls').trigger('click');
	 $('#close','#dialog_popup').trigger('click');
   });

   $("#select","#dialog_branch").click(function(){
      branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
      branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      branch_id = $("#result","#dialog_branch").val();
      if(result!=null)
      {
         $("input[name='branch']").val(branch_name);
         $("input[name='branch_code']").val(branch_code);
         $("input[name='branch_id']").val(branch_id);
         $("#close","#dialog_branch").trigger('click');
      }
   });

   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })

   /* END DIALOG ACTION BRANCH */

   $("#previewpdf").click(function(e){
        e.preventDefault();
        var branch_code = $("#branch_code").val();
		var jenis = $("#jenis").val();
		var tanggal = $('#tanggal').val();
		var tanggal = datepicker_replace(tanggal);
		var conf = true;

		if(jenis == ''){
			alert('Jenis harus dipilih');
			conf = false;
		} else if(jenis == '10' || jenis == '11' || jenis == '12'){
			var url = '<?php echo site_url('laporan_to_pdf/export_neraca_temp_2');?>';
		} else if(jenis == '20' || jenis == '21' || jenis == '22'){
			var url = '<?php echo site_url('laporan_to_pdf/export_lr_temp_2');?>';
		} else if(jenis == '30'){
      		var url = '<?php echo site_url('laporan_to_pdf/neraca_saldo_gl2');?>';
    	}
		
		if(conf == true){
			if(jenis != '30'){
				window.open(url+'/'+branch_code+'/'+tanggal+'/'+jenis);
			} else {
				window.open(url+'/'+branch_code+'/'+tanggal+'/BB');
			}
		}
   });

   $("#previewxls").click(function(e){
        e.preventDefault();
        var branch_code = $("#branch_code").val();
		var jenis = $("#jenis").val();
		var tanggal = $('#tanggal').val();
		var breakdown = $('#breakdown:checked').val();
		var tanggal = datepicker_replace(tanggal);
		var conf = true;
		
		if(jenis == ''){
			alert('Jenis harus dipilih');
			conf = false;
		} else if(jenis == '10' || jenis == '11' || jenis == '12'){
			var url = '<?php echo site_url('laporan_to_excel/export_neraca_temp');?>';
		} else if(jenis == '20' || jenis == '21' || jenis == '22'){
			var url = '<?php echo site_url('laporan_to_excel/export_lr_temp');?>';
		} else if(jenis == '30'){
      		var url = '<?php echo site_url('laporan_to_excel/neraca_saldo_gl2');?>';
    	}
		
		if(conf == true){
			if(jenis != '30'){
				window.open(url+'/'+branch_code+'/'+tanggal+'/'+jenis+'/'+breakdown);
			} else {
				window.open(url+'/'+branch_code+'/'+tanggal+'/BB/'+breakdown);
			}
		}
   });
/* END SCRIPT */
})
</script>