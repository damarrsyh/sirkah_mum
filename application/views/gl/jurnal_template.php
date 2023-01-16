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
      Recuring <small>Setup Recuring</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Recuring</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Setup Recuring</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Setup Recuring</div>
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
      </div>
      <table class="table table-striped table-bordered table-hover" id="rak_recuring">
         <thead>
            <tr>
               <th width="1%"><input type="checkbox" class="group-checkable" data-set="#rak_recuring .checkboxes" /></th>
               <th>Recuring Name</th>
               <th>Recuring Code</th>
               <th>Debet Account</th>
               <th>Credit Account</th>
               <th width="5%">Edit</th>
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
         <div class="caption"><i class="icon-reorder"></i>Setup Recuring</div>
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
               Setup Recuring Berhasil Diproses !
            </div>      
            <div class="control-group">
               <label class="control-label">Recuring Name<span class="required">*</span></label>
               <div class="controls">
                 <input name="template_name" type="text" class="medium m-wrap" id="template_name" />
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Recuring Code<span class="required">*</span></label>
               <div class="controls">
                 <input name="template_code" type="text" class="medium m-wrap" id="template_code" />
               </div>
            </div>  
            <div class="control-group">
               <label class="control-label">Debet Account<span class="required">*</span></label>
               <div class="controls">
                 <select name="debet_account" id="debet_account" class="chosen" style="width:400px;">                     
                    <option value="">PILIH</option>
                    <?php foreach($account_name as $data): ?>
                      <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>           
            <div class="control-group">
               <label class="control-label">Credit Account<span class="required">*</span></label>
               <div class="controls">
                 <select name="credit_account" id="credit_account" class="chosen" style="width:400px;">                     
                    <option value="">PILIH</option>
                    <?php foreach($account_name as $data): ?>
                      <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>           
            <div class="form-actions">
              <button type="submit" class="btn green">Save</button>
              <button type="button" class="btn" id="cancel">Back</button>
            </div>
          </div> 
        </div>
      </form>

         <!-- DIALOG USER ADD -->
        <div id="dialog_user" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari User</h3>
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

         <!-- END FORM-->
            </div>
        <!--  </div>
      </div> -->
<!-- END ADD USER -->

      <!-- BEGIN EDIT USER -->
      <div id="edit" class="hide">
        

         <!-- DIALOG USER EDIT -->
        <div id="dialog_user_edit" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
           <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h3>Cari User</h3>
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


         <div class="portlet box purple">
            <div class="portlet-title">
               <div class="caption"><i class="icon-reorder"></i>Edit RAK</div>
               <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
                  <a href="#portlet-config" data-toggle="modal" class="config"></a>
                  <a href="javascript:;" class="reload"></a>
                  <a href="javascript:;" class="remove"></a>
               </div>
            </div>
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="#" id="form_edit" class="form-horizontal">
                  <input type="hidden" id="template_id" name="template_id">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  <div class="alert alert-success hide">
                     <button class="close" data-dismiss="alert"></button>
                     Edit RAK Successful!
                  </div>

                  <br>  
                    <div class="control-group">
                       <label class="control-label">Recuring Name<span class="required">*</span></label>
                       <div class="controls">
                         <input name="template_name" type="text" class="medium m-wrap" id="template_name" />
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Recuring Code<span class="required">*</span></label>
                       <div class="controls">
                         <input name="template_code" type="text" class="medium m-wrap" id="template_code" />
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Debet Account<span class="required">*</span></label>
                       <div class="controls">
                         <select name="debet_account" id="debet_account2" class="chosen" style="width:400px;">                     
                            <option value="">PILIH</option>
                            <?php foreach($account_name as $data): ?>
                              <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Credit Account<span class="required">*</span></label>
                       <div class="controls">
                         <select name="credit_account" id="credit_account2" class="chosen" style="width:400px;">                     
                            <option value="">PILIH</option>
                            <?php foreach($account_name as $data): ?>
                              <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                            <?php endforeach?>
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

<!-- END EDIT REMBUG -->





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

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
     
      $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">

$(function(){

      // dialog cari user (add form)
      $("#browse_user","#form_add").click(function(){
        branch_code = $("#cabang","#form_add").val();

        if($("#keyword","#dialog_user").val()==""){
          $.ajax({
             type: "POST",
             url: site_url+"administration/ajax_get_user_by_keyword",
             dataType: "json",
             async: false,
             data: {keyword:'',branch_code:branch_code},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].user_id+'">'+response[i].user_id+' - '+response[i].fullname+'</option>';
                }
                $("#result","#dialog_user").html(html);
             }
          })
        }
      });

      $("#keyword","#dialog_user").keyup(function(e){
        e.preventDefault();
        keyword = $(this).val();
        branch_code = $("#cabang","#form_add").val();
        if(e.which==13){
          $.ajax({
             type: "POST",
             url: site_url+"administration/ajax_get_user_by_keyword",
             dataType: "json",
             async: false,
             data: {keyword:keyword,branch_code:branch_code},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].user_id+'">'+response[i].user_id+' - '+response[i].fullname+'</option>';
                }
                $("#result","#dialog_user").html(html);
             }
          })
        }
      });

      $("#select","#dialog_user").click(function(){
        fullname = $("#result","#dialog_user").find('option:selected').text();
        user_id = $("#result","#dialog_user").val();

        $("#fullname","#form_add").val(fullname);
        $("#user_id","#form_add").val(user_id);
        $(".close","#dialog_user").trigger('click');
      });

      $("#result option","#dialog_user").live('dblclick',function(){
        $("#select","#dialog_user").trigger('click');
      });


      // dialog cari user (edit form)
      $("#browse_user","#form_edit").click(function(){
        branch_code = $("#cabang2","#form_edit").val();

        if($("#keyword","#dialog_user_edit").val()==""){
          $.ajax({
             type: "POST",
             url: site_url+"administration/ajax_get_user_by_keyword",
             dataType: "json",
             async: false,
             data: {keyword:'',branch_code:branch_code},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].user_id+'">'+response[i].user_id+' - '+response[i].fullname+'</option>';
                }
                $("#result","#dialog_user_edit").html(html);
             }
          })
        }
      });

      $("#keyword","#dialog_user_edit").keyup(function(e){
        e.preventDefault();
        keyword = $(this).val();
        branch_code = $("#cabang2","#form_edit").val();
        if(e.which==13){
          $.ajax({
             type: "POST",
             url: site_url+"administration/ajax_get_user_by_keyword",
             dataType: "json",
             async: false,
             data: {keyword:keyword,branch_code:branch_code},
             success: function(response){
                html = '';
                for ( i = 0 ; i < response.length ; i++ )
                {
                   html += '<option value="'+response[i].user_id+'">'+response[i].user_id+' - '+response[i].fullname+'</option>';
                }
                $("#result","#dialog_user_edit").html(html);
             }
          })
        }
      });

      $("#select","#dialog_user_edit").click(function(){
        fullname = $("#result","#dialog_user_edit").find('option:selected').text();
        user_id = $("#result","#dialog_user_edit").val();

        $("#fullname","#form_edit").val(fullname);
        $("#user_id","#form_edit").val(user_id);
        $(".close","#dialog_user_edit").trigger('click');
      });

      $("#result option","#dialog_user_edit").live('dblclick',function(){
        $("#select","#dialog_user_edit").trigger('click');
      });

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'rak_recuring';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#rak_recuring .group-checkable').live('change',function () {
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

      $("#rak_recuring .checkboxes").livequery(function(){
        $(this).uniform();
      });


      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);

      
      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        $('select.chosen').val('').trigger('liszt:updated');
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              template_name: {
                  required: true
              },
              template_code: {
                  required: true
              },
              debet_account: {
                  required: true
              },
              credit_account: {
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
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"gl/proses_input_setup_recuring",
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
                }else if(response.success==false){
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





      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var template_id = $(this).attr('template_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {template_id:template_id},
          url: site_url+"gl/get_gl_recuring_by_id",
          success: function(response){
            console.log(response);
            $('#template_id').val(response.template_id);
			$('#template_name','#form_edit').val(response.template_name);
			$('#template_code','#form_edit').val(response.template_code);
			$('#debet_account2').val(response.debet_account).trigger('liszt:updated');
			$('#credit_account2').val(response.credit_account).trigger('liszt:updated');
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              template_id: {
                  required: true
              },
              template_name: {
                  required: true
              },
              template_code: {
                  required: true
              },
              debet_account: {
                  required: true
              },
              credit_account: {
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
            if(label.closest('.input-append').length==0)
            {
              label
                  .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
              .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            }
            else
            {
               label.closest('.control-group').removeClass('error').addClass('success')
               label.remove();
            }
          },

          submitHandler: function (form) {

            $.ajax({
              type: "POST",
              url: site_url+"gl/proses_edit_setup_recuring",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#rak_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo(success1, -200);
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo(success1, -200);
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

        var template_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          template_id[$i] = $(this).val();

          $i++;

        });

        if(template_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"gl/delete_gl_recuring",
              dataType: "json",
              data: {template_id:template_id},
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
      $('#rak_recuring').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"gl/datatable_setup_recuring",
          "aoColumns": [
            null,
            null,
			null,
            null,
			null,
            { "bSortable": false, "bSearchable": false }
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

      jQuery('#rak_recuring_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rak_recuring_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
