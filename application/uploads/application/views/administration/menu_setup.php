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
         Menu Setup <small>Pengaturan Menu</small>
      </h3>
      <ul class="breadcrumb">
         <li>
            <i class="icon-home"></i>
            <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
            <i class="icon-angle-right"></i>
         </li>
         <li><a href="#">User Administrator</a><i class="icon-angle-right"></i></li>  
         <li><a href="#">Menu Setup</a></li> 
      </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<div class="row-fluid">
 <div class="span12">
  <div class="tabbable tabbable-custom boxless">
     <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Manage</a></li>
        <li><a class="" href="#tab_2" data-toggle="tab">Change Position</a></li>
     </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">

        <!-- BEGIN EXAMPLE TABLE PORTLET -->
        <div class="portlet box blue" id="wrapper-table">
           <div class="portlet-title">
              <div class="caption"><i class="icon-globe"></i>Menu Table</div>
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
                      Delete Menu <i class="icon-remove"></i>
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
              <!-- ELEMENT : menu_table -->
              <table class="table table-striped table-bordered table-hover" id="menu_table"> 
                 <thead>
                    <tr>
                       <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#menu_table .checkboxes" /></th>
                       <th width="15%">Menu ID</th>
                       <th width="15%">Menu Parent</th>
                       <th width="15%" class="hidden-480">Menu Title</th>
                       <th width="15%" class="hidden-480">Menu URL</th>
                       <th width="15%" class="hidden-480">Menu Flag Link</th>
                       <th class="hidden-480">Menu Icon Parent</th>
                       <th>Edit</th>
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
                 <div class="caption"><i class="icon-reorder"></i>Add New Menu</div>
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
                       New Menu has been Created !
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Parent<span class="required">*</span></label>
                       <div class="controls">
                          <select name="menu_parent" class="medium m-wrap" data-required="1">
                             <option value="">Is Parent</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Title<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_title" data-required="1" class="large m-wrap">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Flag Link<span class="required">*</span></label>
                       <div class="controls">
                          <select name="menu_flag_link" class="medium m-wrap" data-required="1">
                             <option value="">Select...</option>
                             <option value="0">Tidak Mempunyai Link</option>
                             <option value="1">Mempunyai Link</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu URL<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_url" data-required="1" class="medium m-wrap">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Icon Parent<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_icon_parent" data-required="1" class="medium m-wrap">
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
                 <div class="caption"><i class="icon-reorder"></i>Edit Menu</div>
                 <div class="tools">
                    <a href="javascript:;" class="collapse"></a>
                 </div>
              </div>
              <div class="portlet-body form">
                 <!-- BEGIN FORM-->
                 <form action="#" id="form_edit" class="form-horizontal">
                    <input type="hidden" id="menu_id" name="menu_id">
                    <div class="alert alert-error hide">
                       <button class="close" data-dismiss="alert"></button>
                       You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success hide">
                       <button class="close" data-dismiss="alert"></button>
                       Edit Menu Successful!
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Parent<span class="required">*</span></label>
                       <div class="controls">
                          <select name="menu_parent" class="medium m-wrap" data-required="1">
                             <option value="">Select...</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Title<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_title" data-required="1" class="large m-wrap">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu URL<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_url" data-required="1" class="medium m-wrap">
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Flag Link<span class="required">*</span></label>
                       <div class="controls">
                          <select name="menu_flag_link" class="medium m-wrap" data-required="1">
                             <option value="">Is Parent</option>
                             <option value="0">Tidak Mempunyai Link</option>
                             <option value="1">Mempunyai Link</option>
                          </select>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Menu Icon Parent<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="menu_icon_parent" data-required="1" class="medium m-wrap">
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

      </div>
      <!-- end tab 1 -->

      <!-- start tab 2 -->
      <div class="tab-pane" id="tab_2">
        Edit Posisi Menu

        <div class="portlet-body" id="change-position">
            <!-- content goes here -->
         </div>
      </div>
      <!-- end tab 2 -->

    </div>
  </div>
 </div>
</div>







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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-nestable/jquery.nestable.js"></script>    
<script src="<?php echo base_url(); ?>assets/scripts/ui-nestable.js"></script>      
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
        var tbl_id = 'menu_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").trigger('keyup');
      }

      $.ajax({
        type: "POST",
        url: site_url+"administration/get_menu_position",
        dataType: "html",
        success: function(response){
          $("#change-position").html(response);
        }
      });

      $("#menu").livequery(function(){
        $(this).nestable({
          group: 1,
          maxDepth: 3
        }).on('change',function(e){
          var list = e.length ? e : $(e.target);
          
          $.ajax({
            type: "POST",
            dataType: "json",
            url: site_url+"administration/change_position_menu",
            data: {data:list.nestable('serialize')},
            success: function(response){
              
            }
          })
        })
      });

      // fungsi untuk check all
      jQuery('#menu_table .group-checkable').live('change',function () {
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

      $("#menu_table .checkboxes").livequery(function(){
        $(this).uniform();
      });





      // begin dataTable script
      //
      // fungsi untuk generate data pada table
      // dalam kasus ini element #menu_table akan tergenerate datanya secara otomatis
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

      $('#menu_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_menu_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            {bSortable:false}
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
              },
              {
                  'bSortable': false,
                  'aTargets': [6]
              }
          ]
      });

      jQuery('#menu_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#menu_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

      // end dataTable script





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var menu_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          menu_id[$i] = $(this).val();

          $i++;

        });

        if(menu_id.length==0){

          alert("Please select some row to delete !");

        }else{

          var conf = confirm('Are you sure to delete this rows ?');

          if(conf){

            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_menu",
              dataType: "json",
              data: {menu_id:menu_id},
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

        $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"administration/get_menu_parent",
         success: function(response)
         {
            var html = '<option value="">Is Parent</option>';

            for ( i = 0 ; i < response.length ; i++ )
            {
              if(response[i]['menu_parent_title']==null){
                 html += '<option value="'+response[i].menu_id+'">'+response[i].menu_title+'</option>';  
               }else{
                 if(response[i]['menu_parent_parent_title']==null){
                   html += '<option value="'+response[i].menu_id+'">'+response[i].menu_parent_title+' | '+response[i].menu_title+'</option>';  
                 }else{
                   html += '<option value="'+response[i].menu_id+'">'+response[i].menu_parent_parent_title+' | '+response[i].menu_parent_title+' | '+response[i].menu_title+'</option>';  
                 }
               }
            }

            $("select[name='menu_parent']").html(html);
         }
        });

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
              menu_title: {
                  required: true
              },
              menu_url: {
                  required: true
              },
              menu_flag_link: {
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
              url: site_url+"administration/add_menu",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
                  $("#btn_add").trigger('click');
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
        var menu_id = $(this).attr('menu_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {menu_id:menu_id},
          url: site_url+"administration/get_menu_by_menu_id",
          success: function(response){

            $.ajax({
             type: "POST",
             dataType: "json",
             url: site_url+"administration/get_menu_parent",
             async: false,
             success: function(response)
             {
                var html = '<option value="">Is Parent</option>';

                for ( i = 0 ; i < response.length ; i++ )
                {
                   if(response[i]['menu_parent_title']==null){
                     html += '<option value="'+response[i].menu_id+'">'+response[i].menu_title+'</option>';  
                   }else{
                     if(response[i]['menu_parent_parent_title']==null){
                       html += '<option value="'+response[i].menu_id+'">'+response[i].menu_parent_title+' | '+response[i].menu_title+'</option>';  
                     }else{
                       html += '<option value="'+response[i].menu_id+'">'+response[i].menu_parent_parent_title+' | '+response[i].menu_parent_title+' | '+response[i].menu_title+'</option>';  
                     }
                   }
                }

                $("select[name='menu_parent']").html(html);
             }
            });

            $("#form_edit input[name='menu_id']").val(response.menu_id);
            $("#form_edit select[name='menu_parent']").val(response.menu_parent);
            $("#form_edit input[name='menu_title']").val(response.menu_title);
            $("#form_edit input[name='menu_url']").val(response.menu_url);
            $("#form_edit select[name='menu_flag_link']").val(response.menu_flag_link);
            $("#form_edit input[name='menu_icon_parent']").val(response.menu_icon_parent);


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
              menu_title: {
                  required: true
              },
              menu_url: {
                  required: true
              },
              menu_flag_link: {
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
              url: site_url+"administration/edit_menu",
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
      })


});
</script>

<!-- END JAVASCRIPTS -->
