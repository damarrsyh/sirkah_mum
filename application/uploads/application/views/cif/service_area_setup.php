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
      Service Area Setup <small>Pengaturan Wilayah Layanan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Service Area Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- 
***********************************************************************************
***********************************************************************************
Kabupaten
***********************************************************************************
***********************************************************************************
-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Kabupaten</div>
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
              Delete <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="kantor_cabang">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#kantor_cabang .checkboxes" /></th>
               <th width="30%">ID</th>
               <th width="50%">Kabupaten</th>
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
         <div class="caption"><i class="icon-reorder"></i>Tambah Kabupaten</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/add_news'); ?>" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">

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
               <label class="control-label">ID<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_kantor" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nama_kantor" data-required="1" class="medium m-wrap"/>
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
         <div class="caption"><i class="icon-reorder"></i>Edit News</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/edit_news'); ?>" method="post" enctype="multipart/form-data" id="form_edit" class="form-horizontal">
            <input type="hidden" id="news_id" name="news_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit User Successful!
            </div>

            <div class="control-group">
               <label class="control-label">Title<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="title" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Detail</label>
               <div class="controls">
                  <textarea id="news_detail" name="detail" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Photo</label>
               <div class="controls">
                  <div id="photo"></div>
               </div>
            </div>
            <div class="control-group">
               <div class="controls">
                  <input name="photo_lama" type="hidden" id="photo_lama"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Ganti Photo</label>
               <div class="controls">
                  <input type="file" name="userfile" multiple>
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
        var tbl_id = 'kantor_cabang';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#kantor_cabang .group-checkable').live('change',function () {
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

      $("#kantor_cabang .checkboxes").livequery(function(){
        $(this).uniform();
      });




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
              title: {
                  minlength: 4,
                  required: true
              },
              detail: {
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





      // BEGIN FORM EDIT NEWS VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var news_id = $(this).attr('news_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {news_id:news_id},
          url: site_url+"administration/get_news_by_news_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='news_id']").val(response.news_id);
            $("#form_edit input[name='title']").val(response.news_title);
            $("#form_edit textarea[name='detail']").val(response.news_detail);
            $("#form_edit input[name='photo_lama']").val(response.news_img);
            $("#photo").html('<img src="'+base_url+'assets/img/news/thumb/'+response.news_img+'">');
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              title: {
                  minlength: 4,
                  required: true
              },
              detail: {
                  minlength: 3,
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
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#form_edit input[name='photo_lama']").val(response.photo);
                  $("#photo").html('<img src="'+base_url+'assets/img/news/thumb/'+response.photo+'">');
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





      $("#btn_delete").click(function(){

        var news_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          news_id[$i] = $(this).val();

          $i++;

        });

        if(news_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_news",
              dataType: "json",
              data: {news_id:news_id},
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


      // begin first table
      $('#kantor_cabang').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_news_setup",
          "aoColumns": [
            null,
            null,
            null,
            { "bSortable": false },
            { "bSortable": false }
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
              }
          ]
      });

      jQuery('#kantor_cabang_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#nkantor_cabang_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->

<!-- 
***********************************************************************************
***********************************************************************************
END KANTOR CABANG
***********************************************************************************
***********************************************************************************
-->




<!-- 
***********************************************************************************
***********************************************************************************
BEGIN PETUGAS LAPANGAN
***********************************************************************************
***********************************************************************************
-->
<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table-petugas">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Kecamatan</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
         <div class="btn-group">
            <button id="btn_add_petugas" class="btn green">
            Add New <i class="icon-plus"></i>
            </button>
         </div>
         <div class="btn-group">
            <button id="btn_delete" class="btn red">
              Delete  <i class="icon-remove"></i>
            </button>
         </div>
         <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul>
         </div>
      </div>
      <table class="table table-striped table-bordered table-hover" id="news_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#news_table .checkboxes" /></th>
               <th width="10%">ID</th>
               <th width="30%">Kecamatan</th>
               <th width="40%">Kabupaten</th>
               <th width="10%" class="hidden-480">Kantor</th>
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
<div id="add_petugas" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Tambah Kecamatan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="" method="post" enctype="multipart/form-data" id="form_add_petugas" class="form-horizontal">

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
               <label class="control-label">ID<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="title" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kecamatan<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_cabang" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Cabang</option>
                     <option value="1">Kantor Kas</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kabupaten<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_cabang" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Cabang</option>
                     <option value="1">Kantor Kas</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kantor<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="title" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn green">Save</button>
               <button type="button" class="btn" id="cancel_petugas">Back</button>
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
         <div class="caption"><i class="icon-reorder"></i>Edit News</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="<?php echo site_url('administration/edit_news'); ?>" method="post" enctype="multipart/form-data" id="form_edit_petugas" class="form-horizontal">
            <input type="hidden" id="news_id" name="news_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit User Successful!
            </div>

            <div class="control-group">
               <label class="control-label">Title<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="title" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Detail</label>
               <div class="controls">
                  <textarea id="news_detail" name="detail" class="large m-wrap" rows="4"></textarea>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Photo</label>
               <div class="controls">
                  <div id="photo"></div>
               </div>
            </div>
            <div class="control-group">
               <div class="controls">
                  <input name="photo_lama" type="hidden" id="photo_lama"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Ganti Photo</label>
               <div class="controls">
                  <input type="file" name="userfile" multiple>
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
      Index.init();
      Index.initCalendar(); // init index page's custom scripts
      Index.initChat();
      Index.initDashboardDaterange();
      Index.initIntro();
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
        var tbl_id = 'news_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#news_table .group-checkable').live('change',function () {
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

      $("#news_table .checkboxes").livequery(function(){
        $(this).uniform();
      });




      // BEGIN FORM ADD USER VALIDATION
      var form3 = $('#form_add_petugas');
      var error3 = $('.alert-error', form3);
      var success3 = $('.alert-success', form3);
      
      $("#btn_add_petugas").click(function(){
        $("#wrapper-table-petugas").hide();
        $("#add_petugas").show();
        form3.trigger('reset');
      });

      form3.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              title: {
                  minlength: 4,
                  required: true
              },
              detail: {
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


      $("button[type=submit]","#form_add_petugas").click(function(e){

        if($(this).valid()==true)
        {
          form3.ajaxForm({
              data: form3.serialize(),
              dataType: "json",
              success: function(response) {
                if(response.success==true){
                  success3.show();
                  error3.hide();
                  form3.trigger('reset');
                  form3.children('div').removeClass('success');
                }else{
                  success3.hide();
                  error3.show();
                }
              },
              error:function(){
                  success3.hide();
                  error3.show();
              }
          });
        }
        else
        {
          alert('Please fill the empty field before.');
        }

      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel_petugas","#form_add_petugas").click(function(){
        success3.hide();
        error3.hide();
        $("#wrapper-table-petugas").show();
        $("#add_petugas").hide();
        dTreload();
      });





      // BEGIN FORM EDIT NEWS VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var news_id = $(this).attr('news_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {news_id:news_id},
          url: site_url+"administration/get_news_by_news_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='news_id']").val(response.news_id);
            $("#form_edit input[name='title']").val(response.news_title);
            $("#form_edit textarea[name='detail']").val(response.news_detail);
            $("#form_edit input[name='photo_lama']").val(response.news_img);
            $("#photo").html('<img src="'+base_url+'assets/img/news/thumb/'+response.news_img+'">');
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              title: {
                  minlength: 4,
                  required: true
              },
              detail: {
                  minlength: 3,
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
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#form_edit input[name='photo_lama']").val(response.photo);
                  $("#photo").html('<img src="'+base_url+'assets/img/news/thumb/'+response.photo+'">');
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





      $("#btn_delete").click(function(){

        var news_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          news_id[$i] = $(this).val();

          $i++;

        });

        if(news_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"administration/delete_news",
              dataType: "json",
              data: {news_id:news_id},
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


      // begin first table
      $('#news_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"administration/datatable_news_setup",
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
              }
          ]
      });

      jQuery('#petugas_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#petugas_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

<!-- 
***********************************************************************************
***********************************************************************************
END PETUGAS LAPANGAN
***********************************************************************************
***********************************************************************************
-->


<?php $this->load->view('cif/service_area_setup_desa')?>
