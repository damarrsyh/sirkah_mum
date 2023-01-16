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
        LAPORAN <small>TRANSAKSI JURNAL</small>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-list"></i>FILTER</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="filter-form">
            <div class="control-group">
               <label class="control-label">Cabang</label>
               <div class="controls">
                  <input type="text" class="m-wrap medium" id="branch_name" readonly="readonly" style="background-color:#eee;" value="<?php echo $this->session->userdata('branch_name') ?>">
                  <input type="hidden" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
                  <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_branch" class="btn blue" style="margin-top:0px;padding:7px 12px;" data-toggle="modal" href="#dialog_branch">...</a><?php } ?>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Voucher Date <small>(dd/mm/yyyy)</small></label>
               <div class="controls">
                  <input type="text" name="from_date" id="from_date" tabindex="2" placeholder="From Date" class="m-wrap small mask_date date-picker" maxlength="10">
                  <input type="text" name="thru_date" id="thru_date" tabindex="3" placeholder="To Date" class="m-wrap small mask_date date-picker" maxlength="10">
               </div>
            </div>                   
            <div class="form-actions">
               <button type="submit" class="btn green" id="previewpdf">Preview</button>
               <button type="button" class="btn green" id="previewxls">Preview Excel</button>
            </div>
         </form>
         <!-- END FILTER-->
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

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
  
$("#browse_branch").click(function(){
   $.ajax({
      type: "POST",
      url: site_url+"cif/get_branch_by_keyword",
      dataType: "json",
      data: {keyword:$("#keyword","#dialog_branch").val()},
      success: function(response){
         html = '';
         for ( i = 0 ; i < response.length ; i++ )
         {
            html += '<option value="'+response[i].branch_code+'" data-branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
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
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" data-branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
   }
});

$("#select","#dialog_branch").click(function(){
   branch_name = $("#result option:selected","#dialog_branch").data('branch_name');
   branch_code = $("#result","#dialog_branch").val();
   if(result!=null)
   {
      $("#branch_name").val(branch_name);
      $("#branch_code").val(branch_code);
      $("#close","#dialog_branch").trigger('click');
   }
});

$("#result option:selected","#dialog_branch").live('dblclick',function(){
   $("#select","#dialog_branch").trigger('click');
})

$("#previewxls").click(function(e){
   e.preventDefault();
   branch_code = $("#branch_code").val();
   from_date = $("#from_date").val().replace(/\//g,'');
   thru_date = $("#thru_date").val().replace(/\//g,'');
   bValid = true;
   if (branch_code=="") bValid=false;
   if (from_date=="") bValid=false;
   if (thru_date=="") bValid=false;
   if (bValid==false) {
      alert("Please fill an empty field.")
   } else {
      window.open(site_url+"laporan_to_excel/laporan_jurnal_transaksi/"+branch_code+"/"+from_date+"/"+thru_date,'_blank');
   }
})

$("#previewpdf").click(function(e){
   e.preventDefault();
   branch_code = $("#branch_code").val();
   from_date = $("#from_date").val().replace(/\//g,'');
   thru_date = $("#thru_date").val().replace(/\//g,'');
   bValid = true;
   if (branch_code=="") bValid=false;
   if (from_date=="") bValid=false;
   if (thru_date=="") bValid=false;
   if (bValid==false) {
      alert("Please fill an empty field.")
   } else {
      window.open(site_url+"laporan_to_pdf/laporan_jurnal_transaksi/"+branch_code+"/"+from_date+"/"+thru_date,'_blank');
   }
})

});
</script>
<!-- END JAVASCRIPTS -->
