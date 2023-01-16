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
        Download File Backup <small>Download untuk akses lokal Anda</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Download File Backup</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="form1" method="post" action="<?php echo site_url('sys/do_download_file_backup'); ?>">
            <div class="control-group">
              <label class="control-label">Dari<span class="required">*</span></label>
              <div class="controls">
                <input type="text" id="from" name="from" class="m-wrap small date-picker mask_date" value="<?php echo date('d/m/Y',strtotime($from_date)); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Sampai<span class="required">*</span></label>
              <div class="controls">
                <input type="text" id="thru" name="thru" class="m-wrap small date-picker mask_date" value="<?php echo date('d/m/Y',strtotime($from_date)); ?>">
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
              	<button type="button" id="proses" class="btn green">Proses</button>
              </div>
            </div>
            <div class="control-group">
              <div class="scroller" style="height: 150px;" data-always-visible="1" data-rail-visible="0">
                <ul class="feeds" id="hasilnya">
                </ul>
              </div>
            </div>
         </form>
          <!-- END FILTER-->
      </div>
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
<script type="text/javascript">
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
	  
	  $('#proses').click(function(){
		  var from = $('#from').val();
		  var thru = $('#thru').val();
		  
		  $.ajax({
			  type: 'POST',
			  dataType: 'json',
			  data: {from:from,thru:thru},
			  url: site_url+'sys/show_list_backup/',
			  success: function(response){
				  var hasil = response.hasil;
				  var html = '';
				  for ( i in hasil ) {
					  html += '<li><div class="col1"><div class="cont-col2"><div class="desc"><i class="fa fa-check"></i> '+hasil[i]+'</div></div></div><div class="col2"><div class="date"><a href="<?php echo site_url('sys/proses_download_backup'); ?>/'+hasil[i]+'">Download</a></div></div></li>';
				  }

				  $('#hasilnya').html(html);
			  }
		  });
	  });
   });
</script>
<!-- END JAVASCRIPTS -->
