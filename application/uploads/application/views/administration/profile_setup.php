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
			Profile Setup <small>Pengaturan Profile</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Profile Administrator</a><i class="icon-angle-right"></i></li>  
			<li><a href="#">Profile Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EDIT USER -->
<div id="edit">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Profile</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/edit_profile'); ?>" method="POST" enctype="multipart/form-data" id="form_edit" class="form-horizontal">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Profile Successful!
            </div>
            
            <input type="hidden" id="user_id" name="user_id" value="<?php echo $user_id;?>">
            <div class="control-group">
               <label class="control-label">Username<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="username" value="<?php echo $username?>" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Password</label>
               <div class="controls">
                  <input name="password" type="password" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Confirmation</label>
               <div class="controls">
                  <input name="re_password" type="password" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Fullname<span class="required">*</span></label>
               <div class="controls">
                  <input name="fullname" type="text" value="<?php echo $fullname?>" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Photo<span class="required">*</span></label>
               <div class="controls">
                  <img src="<?php echo base_url();?>assets/img/profile/thumb/<?php echo $photo?>" height="80">
                  <input type="hidden" name="foto" id="foto" value="<?php echo $photo?>" />
                  <br /><br />
                  <input type="file" name="userfile" id="userfile" />
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT USER -->






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
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'user_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#user_table .group-checkable').live('change',function () {
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

      $("#user_table .checkboxes").livequery(function(){
        $(this).uniform();
      });





      // adding validator method (confirmpassword)
      $.validator.addMethod("confirmpassword", function(value, element) { 

        password = $("#form_add input[name='password']").val();
        if(password!=value){
          return false;
        }else{
          return true;
        }

      }, "This field must same with Password");

      // adding validator method (confirmpassword2)
      $.validator.addMethod("confirmpassword2", function(value, element) { 

        password = $("#form_edit input[name='password']").val();
        if(password!=value){
          return false;
        }else{
          return true;
        }

      }, "This field must same with Password");



      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);


      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              username: {
                  minlength: 4,
                  required: true
              },
              re_password: {
                confirmpassword2: true
              },
              role: {
                  required: true
              },
              branch_code: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
              App.scrollTo(error2, -200);
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

      });

       $("button[type=submit]","#form_edit").click(function(e){

        if($(this).valid()==true)
        {
          form2.ajaxForm({
              data: form2.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  alert("Edit Profile SUccessed!");
                  window.location.reload();
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
        else
        {
          alert('Please fill the empty field before.');
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






      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
