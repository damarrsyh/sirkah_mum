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
			User Setup <small>Pengaturan User</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">User Administrator</a><i class="icon-angle-right"></i></li>  
			<li><a href="#">User Setup</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>User Table</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete Users <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_activate" class="btn green">
              Activate Users <i class="icon-ok-sign"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_inactivate" class="btn red">
              Inactivate Users <i class="icon-lock"></i>
            </button>
         </div>
         <!-- <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div> -->
      </div>
      <table class="table table-striped table-bordered table-hover" id="user_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#user_table .checkboxes" /></th>
               <th style="white-space:nowrap;">User ID</th>
               <th width="30%">User Name</th>
               <th width="25%">Full Name</th>
               <th width="25%">Role Name</th>
               <th width="25%">Branch</th>
               <th></th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD USER -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Add New Users</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/add_user'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New User has been Created !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Username<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="username" data-required="1" onkeyup="this.value=this.value.toLowerCase()" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Password<span class="required">*</span></label>
               <div class="controls">
                  <input name="password" type="password" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Confirmation<span class="required">*</span></label>
               <div class="controls">
                  <input name="re_password" type="password" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Fullname<span class="required">*</span></label>
               <div class="controls">
                  <input name="fullname" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Photo<span class="required">*</span></label>
               <div class="controls">
                  <input type="file" name="userfile" multiple>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Role Name<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="role">
                     <option value="">Select...</option>
                     <?php
                     foreach($roles as $role):
                     ?>
                     <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                     <?php
                     endforeach;
                     ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Flag Branch Access<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="flag_all_branch" id="flag_all_branch">
                     <option value="">Select...</option>
                     <option value="0">Selected Branch</option>
                     <option value="1">All Branch</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Branch<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="branch_code">
                     <option value="">Select...</option>
                     <?php
                     foreach($branchs as $branch):
                     ?>
                     <option value="<?php echo $branch['branch_code']; ?>"><?php echo $branch['branch_name']; ?></option>
                     <?php
                     endforeach;
                     ?>
                  </select>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END ADD USER -->




<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Users</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="user_id" name="user_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit User Successful!
            </div>

            <div class="control-group">
               <label class="control-label">Username<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="username" data-required="1" onkeyup="this.value=this.value.toLowerCase()" class="medium m-wrap"/>
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
                  <input name="fullname" type="text" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Role Name<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="role">
                     <option value="">Select...</option>
                     <?php
                     foreach($roles as $role):
                     ?>
                     <option value="<?php echo $role['role_id']; ?>"><?php echo $role['role_name']; ?></option>
                     <?php
                     endforeach;
                     ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Flag Branch Access<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="flag_all_branch" id="flag_all_branch">
                     <option value="">Select...</option>
                     <option value="0">Selected Branch</option>
                     <option value="1">All Branch</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Branch<span class="required">*</span></label>
               <div class="controls">
                  <select class="medium m-wrap" name="branch_code">
                     <option value="">Select...</option>
                     <?php
                     foreach($branchs as $branch):
                     ?>
                     <option value="<?php echo $branch['branch_code']; ?>"><?php echo $branch['branch_name']; ?></option>
                     <?php
                     endforeach;
                     ?>
                  </select>
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
      // Index.init();
      // Index.initCalendar(); // init index page's custom scripts
      // Index.initChat();
      // Index.initDashboardDaterange();
      // Index.initIntro();
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





      // BEGIN FORM ADD USER VALIDATION
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
              username: {
                  minlength: 4,
                  required: true
              },
              password: {
                  required: true
              },
              re_password: {
                  required: true,
                  confirmpassword: true
              },
              fullname: {
                  required: true
              },
              role: {
                  required: true
              },
              flag_all_branch: {
                  required: true
              },
              branch_code: {
                  required: true
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
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
          },

          submitHandler: false
      });


      $("button[type=submit]","#form_add").click(function(e){

        if($(this).valid()==true)
        {
          form1.ajaxForm({
              data: form1.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Saved Data');
                }else{
                  success1.hide();
                  error1.show();
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
              }
          });
        }
        else
        {
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





      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var user_id = $(this).attr('user_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {user_id:user_id},
          url: site_url+"administration/get_user_by_user_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='user_id']").val(response.user_id);
            $("#form_edit input[name='username']").val(response.username);
            $("#form_edit input[name='password']").val('');
            $("#form_edit input[name='re_password']").val('');
            $("#form_edit input[name='fullname']").val(response.fullname);
            $("#form_edit select[name='role']").val(response.role_id);
            $("#form_edit select[name='flag_all_branch']").val(response.flag_all_branch);
            $("#form_edit select[name='branch_code']").val(response.branch_code);
          }
        })

      });

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
              flag_all_branch: {
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

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"administration/edit_user",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("input[name='password']",form2).val('');
                  $("input[name='re_password']",form2).val('');
                  form2.children('div').removeClass('success');
                  $("#menu_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
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
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });





      $("#btn_delete").click(function(){

        var user_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          user_id[$i] = $(this).val();

          $i++;

        });

        if(user_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_user",
              dataType: "json",
              data: {user_id:user_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload();
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      $("#btn_activate").click(function(){

        var user_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          user_id[$i] = $(this).val();

          $i++;

        });

        if(user_id.length==0){
          alert("Please select some row to Activate !");
        }else{
          var conf = confirm('Are you sure to Activate this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/activate_user",
              dataType: "json",
              data: {user_id:user_id},
              success: function(response){
                if(response.success==true){
                  alert("Activated!");
                  dTreload();
                }else{
                  alert("Activate Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      $("#btn_inactivate").click(function(){

        var user_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          user_id[$i] = $(this).val();

          $i++;

        });

        if(user_id.length==0){
          alert("Please select some row to Inactivate !");
        }else{
          var conf = confirm('Are you sure to Inactivate this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/inactivate_user",
              dataType: "json",
              data: {user_id:user_id},
              success: function(response){
                if(response.success==true){
                  alert("Inactivated!");
                  dTreload();
                }else{
                  alert("Inactivate Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }
        }

      });


      // begin first table
      $('#user_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_user_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            { "bSortable": false },
            { "bSortable": false }
          ],
          "aLengthMenu": [
              [15, 30, 45, -1],
              [15, 30, 45, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 15,
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

      jQuery('#user_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#user_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
