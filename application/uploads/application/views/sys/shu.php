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
        Import
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Proses SHU Tahunan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
    <form action="<?php echo site_url('sys/proses_shu'); ?>" method="post" enctype="multipart/form-data" id="FormAdd" class="form-horizontal">
        <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert"></button>
            You have some form errors. Please check below.
        </div>
        <div class="control-group">
          <label class="control-label">Tanggal Transaksi</label>
          <div class="controls">
             <input type="text" name="trx_date" id="trx_date" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
          </div>
        </div>
        <div class="control-group">
            <label class="control-label">File <span class="required">*</span></label>
            <div class="controls">
                <input type="file" id="userfile" name="userfile"/>
                <p class="help-block"></p>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls">
                <button type="submit" id="upload" class="btn green"><i class="icon-upload"></i> <span>Upload</span></button>
            </div>
        </div>
    </form>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>   
<!-- END PAGE LEVEL SCRIPTS -->  
<script type="text/javascript">
jQuery(document).ready(function() {    
  App.init(); // initlayout and core plugins

  /*start script*/
var FormAdd = $("#FormAdd"), alert_error = $('.alert-error')
    progress = $('.progress'), 
    bar = $('.bar'), 
    percent = $('.percent');
    // status = $('#status');

/*BEGIN EDIT*/
FormAdd.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
        userfile:{required:true}
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        alert_error.show();
        App.scrollTo(alert_error, -200);
    },
    highlight: function (element) { // hightlight error inputs
        $(element).closest('.form-group').removeClass('success').addClass('error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).closest('.form-group').removeClass('error'); // set error class to the control group
    },
    submitHandler: false,
    submitHandler: function (form) {
        $('#upload').attr('disabled',true);
        dontBlock = true
        FormAdd.ajaxSubmit({
            dataType: 'json', 
            beforeSend: function() {
                $('#upload').html('<i class="icon-spinner icon-spin"></i> <span>0%</span>');
            },
            uploadProgress: function(event, position, total, percentComplete) {
                console.log(percentComplete);
                if (percentComplete>99) {
                    percentComplete=99;
                }
                $('#upload span').html(''+percentComplete+'%');
            },
            cache:false,
            success: function(response) {
                $('#upload').html('<i class="icon-upload"></i> Upload');
                $('#upload').attr('disabled',false);
                if (response.success==true) {
                    $.alert({
                        title:'Upload Success',icon:'icon-check',backgroundDismiss:false,
                        content:'Import SHU SUKSES.',
                        confirmButtonClass:'btn green',
                        confirm:function(){
                            $('#userfile').val('');
                        }
                    })
                } else {
                    App.WarningAlert(response.error);
                }

            },
            error: function(){
                App.WarningAlert("Failed to Connect into Databases, Please Contact Your Administrator!");
                // var percentVal = '100%';
                // percent.html(percentVal);
                $('#upload').html('<i class="icon-upload"></i> Upload');
                $('#upload').attr('disabled',false);
            }
        });
    }
});
});
</script>


<!-- END JAVASCRIPTS -->