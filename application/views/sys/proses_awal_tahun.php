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
        Proses Bonus <small>Pembagian Bonus dari Titipan Bagi Hasil</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Proses Bonus</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form class="form-horizontal" id="do_proses_awal_tahun" method="post" action="<?php echo site_url('sys/do_proses_awal_tahun'); ?>">
            <div class="control-group">
              <label class="control-label">Periode<span class="required">*</span></label>
              <div class="controls">
                <input type="text" id="from_date" name="from_date" class="m-wrap small date-picker mask_date" value="<?php echo date('d/m/Y',strtotime($from_date)); ?>">
                <input type="text" id="thru_date" name="thru_date" class="m-wrap small date-picker mask_date" value="<?php echo date('d/m/Y',strtotime($thru_date)); ?>">
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Branch<span class="required">*</span></label>
              <div class="controls">
                <select class="m-wrap medium" id="branch_code" name="branch_code">
                  <option value="">Pilih Cabang</option>
                  <?php foreach($branchs as $branch): ?>
                    <option value="<?php echo $branch['branch_code'] ?>"><?php echo $branch['branch_name'] ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-actions">
              <button type="submit" id="proses" class="btn green">Proses Sekarang</button>
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
    
      $(".mask_date").inputmask("d/m/y");

      var form = $('#do_proses_awal_tahun');
      form.validate({
        errorElement:"span",errorClass:"help-inline",focusInvalid:false,
        errorPlacement:function(error,element){},
        rules:{
          date1:{required:true},
          date2:{required:true}
        },
        highlight: function (element) {
            $(element).closest('.help-inline').removeClass('ok');
            $(element).closest('.control-group').removeClass('success').addClass('error');
        },
        unhighlight: function (element) {
            $(element).closest('.control-group').removeClass('error');
        },
        submitHandler: function(form){
          action = $(form).attr('action');
          $.ajax({
            type:"POST",data:$(form).serialize(),
            url:action,
            dataType:'json',
            success:function(response) {
              if (response.success==true){
                alert('Proses Selesai!');
                window.location.reload(true);
              } else {
                alert('Failed to connect into database. please check your connection.')
              }
            },
            error:function(response, textStatus){
              alert(textStatus);
              // write log
              url='sys/do_proses_awal_tahun';
              status=response.status;
              statusText=response.statusText;
              responseText=response.responseText;
              App.write_error_log(url,status,statusText,responseText);
            }
          })
        }
      });
   });

</script>
<!-- END JAVASCRIPTS -->

<?php //echo $akhir;?>
<?php //echo date("d/m/Y",strtotime($akhir));?>
<?php //echo $day_periode_akhir.'/'.$month_periode_akhir.'/'.$year_periode_akhir; ?>