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
         Role Setup <small>Pengaturan Role</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">User Administrator</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Role Setup</a></li> 
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->





<!-- BEGIN EXAMPLE TABLE PORTLET -->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Role Table</div>
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
              Delete Role <i class="icon-remove"></i>
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

      <!-- TABLE DISINI -->
      <!-- ELEMENT : role_table -->
      <table class="table table-striped table-bordered table-hover" id="role_table"> 
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#role_table .checkboxes" /></th>
               <th width="30%">Role Name</th>
               <th width="50%" class="hidden-480">Role Description</th>
               <th width="5%" style="text-align:center;">Edit</th>
               <th style="text-align:center;">Priviledge</th>
            </tr>
         </thead>
         <tbody>
         </tbody>
      </table>

   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET -->




<!-- BEGIN ADD -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Add New Role</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal">

            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Role has been Created !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Role Name<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="role_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Role Description<span class="required">*</span></label>
               <div class="controls">
                  <textarea name="role_desc" data-required="1" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Day Access<span class="required">*</span></label>
               <div class="controls">
                  <input type="checkbox" name="day_access1" data-required="1" class="medium m-wrap" value="1" />Senin
                  <input type="checkbox" name="day_access2" data-required="1" class="medium m-wrap" value="2" />Selasa
                  <input type="checkbox" name="day_access3" data-required="1" class="medium m-wrap" value="3" />Rabu
                  <input type="checkbox" name="day_access4" data-required="1" class="medium m-wrap" value="4" />Kamis
                  <input type="checkbox" name="day_access5" data-required="1" class="medium m-wrap" value="5" />Jumat
                  <input type="checkbox" name="day_access6" data-required="1" class="medium m-wrap" value="6" />Sabtu
                  <input type="checkbox" name="day_access7" data-required="1" class="medium m-wrap" value="7" />Minggu
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Time Access<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="time_access_start" data-required="1" class="medium m-wrap" placeholder="JJ:MM:DD" />
                  <input type="text" name="time_access_end" data-required="1" class="medium m-wrap" placeholder="JJ:MM:DD" />
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
<!-- END ADD -->





<!-- BEGIN EDIT -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Role</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="role_id" name="role_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Role Successful!
            </div>

            <div class="control-group">
               <label class="control-label">Role Name<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="role_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Role Description<span class="required">*</span></label>
               <div class="controls">
                  <textarea id="role_desc" name="role_desc" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Day Access<span class="required">*</span></label>
               <div class="controls">
                      <input type="checkbox" name="day_access1" value="1" id="day_access1" />Senin
                      <input type="checkbox" name="day_access2" value="2" id="day_access2" />Selasa
                      <input type="checkbox" name="day_access3" value="3" id="day_access3" />Rabu
                      <input type="checkbox" name="day_access4" value="4" id="day_access4" />Kamis
                      <input type="checkbox" name="day_access5" value="5" id="day_access5" />Jumat
                      <input type="checkbox" name="day_access6" value="6" id="day_access6" />Sabtu
                      <input type="checkbox" name="day_access7" value="7" id="day_access7" />Minggu
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Time Access<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="time_access_start" data-required="1" class="medium m-wrap" placeholder="JJ:MM:DD" />
                  <input type="text" name="time_access_end" data-required="1" class="medium m-wrap" placeholder="JJ:MM:DD" />
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
<!-- END EDIT -->





<!-- BEGIN EDIT ROLE PRIVILEDGE -->
<div id="edit_role_priviledge" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Role Priviledge</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit_role_priviledge" class="form-horizontal">
            <input type="hidden" id="role_id" name="role_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               Something wrong, please contact your administrator for this problem.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Role Priviledge Successful!
            </div>

            <input type="checkbox" id="select_all"> Select All
            <hr size="1">
            <div id="menu-role"></div>

            <div class="form-actions" style="padding-left:20px">
               <button type="submit" class="btn purple">Save</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT ROLE PRIVILEDGE -->







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
        var tbl_id = 'role_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }




      // fungsi untuk check all
      jQuery('#role_table .group-checkable').live('change',function () {
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

      $("#role_table .checkboxes").livequery(function(){
        $(this).uniform();
      });





      // begin dataTable script
      //
      // fungsi untuk generate data pada table
      // dalam kasus ini element #role_table akan tergenerate datanya secara otomatis
      // ---------------------------------------------------------------------------------
      // di bawah ada method aoColumns : []
      // isikan nilai "null" pada setiap array. dan jumlah array harus sama dengan -
      // jumlah kolom yang akan ditampilkan
      //
      // dan juga terdapat method aoColumnDefs : []
      // berfungsi sebagai penentuan sorting pada table
      // 
      // didalam nya juga terdapat method lain dan memiliki fungsi sbb :
      // bSortable : false      #keadaan hide/show,
      // aTargets : [0]         #menentukan kolom ke berapakah yang akan di hide
      // 
      // penomoran pada kolom dimulai dari 0 dst

      $('#role_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_user_role_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null
          ],
          "aLengthMenu": [
              [5, 15, 20, -1],
              [5, 15, 20, "All"] // change per page values here
          ],
          // set the initial value
          "iDisplayLength": 5,
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
              },
              {
                  'bSortable': false,
                  'aTargets': [3]
              }
          ]
      });

      jQuery('#role_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#role_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

      // end dataTable script





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var role_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          role_id[$i] = $(this).val();

          $i++;

        });

        if(role_id.length==0){

          alert("Please select some row to delete !");

        }else{

          var conf = confirm('Are you sure to delete this rows ?');

          if(conf){

            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_role",
              dataType: "json",
              data: {role_id:role_id},
              success: function(response){
                if(response.success==true){
                  alert("Deleted!");
                  dTreload(); // memanggil fungsi reload
                }else{
                  alert("Delete Failed!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            });

          }

        }

      });
      





      // event button Add New ketika di tekan
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
      });

      // BEGIN FORM ADD VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              role_name: {
                  required: true
              },
              role_desc: {
                  required: true
              },
              day_access: {
                  required: true
              },
              time_access_start: {
                  required: true
              },
              time_access_end: {
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

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"administration/add_role",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
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
      });



      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });



      // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var role_id = $(this).attr('role_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {role_id:role_id},
          url: site_url+"administration/get_role_by_role_id",
          success: function(response){
            $("#form_edit input[name='role_id']").val(response.role_id);
            $("#form_edit input[name='role_name']").val(response.role_name);
            $("#form_edit textarea[name='role_desc']").val(response.role_desc);

            if(response.day_access1 == 1){
              $("#form_edit input[name='day_access1']").attr('checked', true);
              $("#form_edit input[name='day_access1']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access1']").attr('checked', false);
              $("#form_edit input[name='day_access1']").closest('span').attr('class','unchecked');
            }

            if(response.day_access2 == '2'){
              $("#form_edit input[name='day_access2']").attr('checked', true);
              $("#form_edit input[name='day_access2']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access2']").attr('checked', false);
              $("#form_edit input[name='day_access2']").closest('span').attr('class','unchecked');
            }

            if(response.day_access3 == '3'){
              $("#form_edit input[name='day_access3']").attr('checked', true);
              $("#form_edit input[name='day_access3']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access3']").attr('checked', false);
              $("#form_edit input[name='day_access3']").closest('span').attr('class','unchecked');
            }

            if(response.day_access4 == '4'){
              $("#form_edit input[name='day_access4']").attr('checked', true);
              $("#form_edit input[name='day_access4']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access4']").attr('checked', false);
              $("#form_edit input[name='day_access4']").closest('span').attr('class','unchecked');
            }

            if(response.day_access5 == '5'){
              $("#form_edit input[name='day_access5']").attr('checked', true);
              $("#form_edit input[name='day_access5']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access5']").attr('checked', false);
              $("#form_edit input[name='day_access5']").closest('span').attr('class','unchecked');
            }

            if(response.day_access6 == '6'){
              $("#form_edit input[name='day_access6']").attr('checked', true);
              $("#form_edit input[name='day_access6']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access6']").attr('checked', false);
              $("#form_edit input[name='day_access6']").closest('span').attr('class','unchecked');
            }

            if(response.day_access7 == '7'){
              $("#form_edit input[name='day_access7']").attr('checked', true);
              $("#form_edit input[name='day_access7']").closest('span').attr('class','checked');
            } else {
              $("#form_edit input[name='day_access7']").attr('checked', false);
              $("#form_edit input[name='day_access7']").closest('span').attr('class','unchecked');
            }

            $("#form_edit input[name='time_access_start']").val(response.time_access_start);
            $("#form_edit input[name='time_access_end']").val(response.time_access_end);

          }
        })


      });



      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              role_name: {
                  required: true
              },
              role_desc: {
                required: true
              },
              day_access: {
                required: true
              },
              time_access_start: {
                required: true
              },
              time_access_end: {
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


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"administration/edit_role",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
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
      //  END FORM EDIT VALIDATION

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
        success2.hide();
        error2.hide();
      });





      var form3 = $('#form_edit_role_priviledge');
      var error3 = $('.alert-error', form3);
      var success3 = $('.alert-success', form3);

      // event button Edit Priviledge ketika di tekan
      $("a#link-edit-priviledge").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit_role_priviledge").show();
        var role_id = $(this).attr('role_id');
        $.ajax({
          type: "POST",
          dataType: "html",
          data: {role_id:role_id},
          url: site_url+"administration/get_menu_by_role",
          success: function(response){
            $("input[name='role_id']",form3).val(role_id);
            $("#menu-role",form3).html(response);
          }
        });
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel",form3).click(function(){
        $("#edit_role_priviledge").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      $("#menu-role input#parent",form3).live('click',function(){
        if($(this).is(':checked')==true){
          $(this).parent().find('input[type="checkbox"]').attr('checked',true);
        }else{
          $(this).parent().find('input[type="checkbox"]').attr('checked',false);
        }
      });

      $("#menu-role input#child",form3).live('click',function(){
        if($(this).is(':checked')==true){
          $(this).parent().find('input#grandchild').attr('checked',true);
        }else{
          $(this).parent().find('input#grandchild').attr('checked',false);
        }
      });

      $(form3).submit(function(e){
        e.preventDefault();
        $.ajax({
          type: "POST",
          url: site_url+"administration/edit_role_priviledge",
          dataType: "json",
          data: form3.serialize(),
          success: function(response){
            if(response.success==true){
              success3.show();
              error3.hide();
              alert("Save Successfuly!")
            }else{
              error3.show();
              success3.hide();
            }
          },
          error: function(){
            error3.show();
            success3.hide();
          }
        })
      });

      //select all
      $("#select_all").click(function(){
        if($(this).is(':checked')==true)
        {
          $("#menu-role input[type='checkbox']").attr('checked',true);
        }
        else
        {
          $("#menu-role input[type='checkbox']").attr('checked',false);
        }
      })


});
</script>

<!-- END JAVASCRIPTS -->
