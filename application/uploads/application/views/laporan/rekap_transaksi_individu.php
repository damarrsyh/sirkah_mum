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
        Laporan <small>Rekap Transaksi Individu</small>
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

<!-- DIALOG CM -->
<div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Rembug Pusat</h3>
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

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kas Petugas</h3>
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

<!-- BEGIN FORM-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Laporan Rekap Transaksi Individu</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
    <div class="portlet-body form">
       <!-- BEGIN FILTER FORM -->
          <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name'); ?>">
          <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code'); ?>">
          <input type="hidden" name="branch_class" id="branch_class" value="<?php echo $this->session->userdata('branch_class'); ?>">
          <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id'); ?>">
          <input type="hidden" name="fa_code" id="fa_code" />
          <input type="hidden" name="cm_code" id="cm_code" />
          <table id="filter-form">
             <tr>
                <td style="padding-bottom:10px;" width="100">Cabang</td>
                <td>
                   <input type="text" name="branch" readonly class="m-wrap mfi-textfield" style="background:#EEE;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                   <?php if($this->session->userdata('flag_all_branch')=="1"){ ?>
                   <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
                   <?php } ?>
                </td>
             </tr>
             <tr>
               <td style="padding-bottom:10px;"  width="100">Majelis </td>
                <td>
                  <input type="text" name="cm" readonly="readonly" class="m-wrap mfi-textfield" style="background:#EEE;" >
                  <a id="browse_cm" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_cm">...</a>
                </td>
             </tr>
             <tr>
               <td style="padding-bottom:10px;"  width="100">Petugas </td>
                <td>
                  <input type="text" name="fa" readonly="readonly" class="m-wrap mfi-textfield" style="background:#EEE;" >
                  <a id="browse_fa" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_fa">...</a>
                </td>
             </tr>
             <tr>
               <td style="padding-bottom:10px;"  width="100">Tanggal </td>
                <td><input type="text" name="from_date" id="from_date" tabindex="2" placeholder="From Date" class="m-wrap small mask_date date-picker" maxlength="10"> <input type="text" name="thru_date" id="thru_date" tabindex="3" placeholder="To Date" class="m-wrap small mask_date date-picker" maxlength="10"></td>
             </tr>
          </table>
          <br>
          <div class="form-actions" style="padding-left:115px;">
           <button class="green btn" id="preview_pdf">Preview</button>
           <button class="green btn hidden" id="preview_xls">Preview Excel</button>
          </div>
       <!-- END FILTER FORM -->
       <!-- <hr size="1"> -->
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
               html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'" branch_class="'+response[i].branch_class+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
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
                  html += '<option value="'+response[i].branch_id+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'" branch_class="'+response[i].branch_class+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
               }
               $("#result","#dialog_branch").html(html);
            }
         })
      }
   });

   $("#select","#dialog_branch").click(function(){
      branch_code = $("#result option:selected","#dialog_branch").attr('branch_code');
      branch_name = $("#result option:selected","#dialog_branch").attr('branch_name');
      branch_class = $("#result option:selected","#dialog_branch").attr('branch_class');
      branch_id = $("#result","#dialog_branch").val();
      if(result!=null)
      {
         $("input[name='branch']").val(branch_name);
         $("input[name='branch_code']").val(branch_code);
         $("input[name='branch_class']").val(branch_class);
         $("input[name='branch_id']").val(branch_id);
         $("#close","#dialog_branch").trigger('click');
      }
   });
   $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
   })
   /* END DIALOG ACTION BRANCH */

  $("#browse_cm").click(function(){
    cm = $("input[name='cm']").val();
    $("#keyword","#dialog_cm").val(cm)
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword',"#dialog_cm").trigger(e);
    },300)
  });

  $("#keyword","#dialog_cm").keypress(function(e){
    keyword = $(this).val();
    branch_id = $("input[name='branch_id']").val();
    branch_code=$("input[name='branch_code']").val();
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_id:branch_id,branch_code:branch_code},
         success: function(response){
            html = '<option value="00000" cm_name="SEMUA">00000 - SEMUA</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_cm").html(html).focus();
            $("#result option:first-child","#dialog_cm").attr('selected',true);
         }
      });
    }
  });

  $("#select","#dialog_cm").click(function(){
    result_name = $("#result option:selected","#dialog_cm").attr('cm_name');
    result_code = $("#result","#dialog_cm").val();
    if(result!=null)
    {
      $("input[name='cm']").val(result_name);
      $("input[name='cm_code']").val(result_code);
      $("#close","#dialog_cm").trigger('click');
    }
  });

  $("#result option","#dialog_cm").livequery('dblclick',function(){
    $("#select","#dialog_cm").trigger('click');
    window.scrollTo(0,0)
  });

  $("input[name='cm']").keypress(function(e){
    if(e.keyCode==13){
      $(this).blur();
      e.preventDefault();
      $("#browse_cm").trigger('click');
    }
  });

  $("#result","#dialog_cm").keypress(function(e){
    e.preventDefault();
    if(e.keyCode==13){
      $("#select","#dialog_cm").trigger('click');
    }
  });

  /* begin cari kas petugas */
  $("#browse_fa").click(function(){

    fa = $("input[name='fa']").val();
    $("#keyword","#dialog_fa").val(fa)
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword',"#dialog_fa").trigger(e);
    },300)
  })

  $("#keyword","#dialog_fa").keypress(function(e){
    keyword = $(this).val();
    branch_code = $("input[name='branch_code']").val();
    branch_class = $("input[name='branch_class']").val();
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"transaction/ajax_get_gl_account_cash_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_code:branch_code},
         success: function(response){
            html = '<option value="00000" fa_name="SEMUA">00000 - SEMUA</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
              html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_code+' | '+response[i].fa_name+'</option>';
            }
            $("#result","#dialog_fa").html(html).focus();
            $("#result option:first-child","#dialog_fa").attr('selected',true);
         }
      })
    }
  });

  $("#select","#dialog_fa").click(function(){
    result_name = $("#result option:selected","#dialog_fa").attr('fa_name');
    account_cash_code = $("#result option:selected","#dialog_fa").attr('account_cash_code');
    result_code = $("#result","#dialog_fa").val();
    if(result!=null)
    {
      $("input[name='fa']").val(result_name);
      $("input[name='fa_name']").val(result_name);
      $("input[name='fa_code']").val(result_code);
      $("input[name='account_cash_code']").val(account_cash_code);
      $("#close","#dialog_fa").trigger('click');
    }
  });

  $("#result option","#dialog_fa").livequery('dblclick',function(){
    $("#select","#dialog_fa").trigger('click');
    window.scrollTo(0,0)
  });

  $("input[name='fa']").keypress(function(e){
    if(e.keyCode==13){
      $(this).blur();
      e.preventDefault();
      $("#browse_fa").trigger('click');
    }
  });

  $("#result","#dialog_fa").keypress(function(e){
    e.preventDefault();
    if(e.keyCode==13){
      $("#select","#dialog_fa").trigger('click');
    }
  });
  /* end cari kas petugas */

   $("#preview_pdf").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var cm_code = $("#cm_code").val();
      var fa_code = $("#fa_code").val();
	  var from = $("#from_date").val().replace(/\//g,'');
	  var thru = $("#thru_date").val().replace(/\//g,'');
	  var valid = true;
	  
	  if(cm_code == ''){
		  alert('Majelis belum dipilih');
		  valid = false;
	  }
	  
	  if(fa_code == ''){
		  alert('Petugas belum dipilih');
		  valid = false;
	  }
	  
	  if(valid == true){
		  window.open('<?php echo site_url();?>laporan_to_pdf/export_rekap_transaksi_individu/'+branch_code+'/'+cm_code+'/'+fa_code+'/'+from+'/'+thru);
	  }
   });

   $("#preview_xls").click(function(e){
      e.preventDefault();
      var branch_code = $("#branch_code").val();
      var branch_class = $("#branch_class").val();
      var fa_code = $("#fa_code").val();
	  window.open('<?php echo site_url();?>laporan_to_excel/export_rekapitulasi_npl/'+branch_code+'/'+tanggal_hitung);
   });

/* END SCRIPT */
})
</script>