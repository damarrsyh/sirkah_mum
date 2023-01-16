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
      Branch Setup <small>Regis Proyeksi Droping</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Group</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Regis Proyeksi Droping</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Proyeksi Droping</div>
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
      <table class="table table-striped table-bordered table-hover" id="proyeksi_droping_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#proyeksi_droping_table .checkboxes" /></th>
               <th width="23%">Kantor Cabang</th>
               <th width="30%">Periode</th>
               <th width="23%">Proyeksi Anggota</th>
               <th width="30%">Proyeksi Nominal</th>
               <th width="10%">Action</th>
               <!-- <th>Edit</th> -->
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->



<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Regis Proyeksi Droping</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_add" class="form-horizontal">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Proyeksi Droping has been Created !
            </div>
            <br>

            <div class="control-group">
               <label class="control-label">Kantor Cabang<span class="required">*</span></label>
               <div class="controls">
                    <input type="text" name="branch_name" id="branch_name" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="<?php echo $this->session->userdata('branch_name'); ?>" />
                    <input type="hidden" id="cabang" name="cabang" value="<?php echo $this->session->userdata('branch_code'); ?>">
                    <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_cabang" class="btn blue" data-toggle="modal" href="#dialog_cabang">...</a><?php } ?>
                    <div id="dialog_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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
                          <button type="button" id="select_cabang" class="btn blue">Select</button>
                       </div>
                    </div>   
      
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Tahun<span class="required">*</span></label>
               <div class="controls">
                  <input name="year" id="year" type="text" class="medium m-wrap" maxlength="4" placeholder="YYYY" />
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Bulan<span class="required">*</span></label>
               <div class="controls">
                  <select name="month" id="month" class="medium m-wrap" data-required="1">                     
                    <option value="">Pilih</option>                  
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
               </div>
            </div>

            <div class="control-group">
              <label class="control-label">Proyeksi Anggota<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-append">
                          <input type="text" class="m-wrap mask-money" style="width:125px;"  name="account_target">
                       <span class="add-on">Orang</span>
                    </div>
                 </div>
            </div>

            <div class="control-group">
              <label class="control-label">Proyeksi Nominal<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="m-wrap mask-money" style="width:120px;"  name="amount_target" id="nominal">
                       <span class="add-on">,00</span>
                    </div>
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

<div id="edit" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Regis Proyeksi Droping</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" method="post" enctype="multipart/form-data" id="form_edit" class="form-horizontal">
            <div class="alert alert-error2 hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success2 hide">
               <button class="close" data-dismiss="alert"></button>
               Proyeksi Droping has been Created !
            </div>
            <br>

            <div class="control-group">
               <label class="control-label">Kantor Cabang<span class="required">*</span></label>
               <div class="controls">
                    <input type="text" name="branch_name2" id="branch_name2" data-required="1" class="medium m-wrap" style="background-color:#eee;" readonly="" value="<?php echo $this->session->userdata('branch_name'); ?>" />
                    <input type="hidden" id="branch_code2" name="branch_code2" value="<?php echo $this->session->userdata('branch_code'); ?>">
                    <?php if($this->session->userdata('flag_all_branch')=='1'){ ?><a id="browse_cabang2"  class="btn blue" data-toggle="modal">...</a><?php } ?>
                    <div id="dialog_cabang2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                       <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                          <h3>Cari Kantor Cabang</h3>
                       </div>
                       <div class="modal-body">
                          <div class="row-fluid">
                             <div class="span12">
                                <h4>Masukan Kata Kunci</h4>
                                <p><input type="text" name="keyword2" id="keyword2" placeholder="Search..." class="span12 m-wrap"></p> 
                                <p><select name="result2" id="result2" size="7" class="span12 m-wrap"></select></p>
                             </div>
                          </div>
                       </div>
                       <div class="modal-footer">
                          <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
                          <button type="button" id="select_cabang2" class="btn blue">Select</button>
                       </div>
                    </div>   
      
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Tahun<span class="required">*</span></label>
               <div class="controls">
                  <input name="year" type="text" class="medium m-wrap" maxlength="4" placeholder="YYYY" style="background-color:#eee;" disabled="disabled"/>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label">Bulan<span class="required">*</span></label>
               <div class="controls">
                  <select name="month" class="medium m-wrap" data-required="1" style="background-color:#eee;" disabled="disabled">                     
                    <option value="">Pilih</option>                  
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
               </div>
            </div>

            <div class="control-group">
              <label class="control-label">Proyeksi Anggota<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-append">
                          <input type="text" class="m-wrap mask-money" style="width:125px;"  name="account_target">
                       <span class="add-on">Orang</span>
                    </div>
                 </div>
            </div>

            <div class="control-group">
              <label class="control-label">Proyeksi Nominal<span class="required">*</span></label>
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                          <input type="text" class="m-wrap mask-money" style="width:120px;"  name="amount_target" id="nominal">
                          <input type="text" class="m-wrap hide" style="width:120px;"  name="proyeksi_droping_id">
                          <input type="text" class="m-wrap hide" style="width:120px;"  name="year2">
                          <input type="text" class="m-wrap hide" style="width:120px;"  name="month2">
                       <span class="add-on">,00</span>
                    </div>
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
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'proyeksi_droping_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
    

      // fungsi untuk check all
      jQuery('#proyeksi_droping_table .group-checkable').live('change',function () {
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

      $("#proyeksi_droping_table .checkboxes").livequery(function(){
        $(this).uniform();
      });

      $("#browse_cabang").click(function(){
        $.ajax({
          type: "POST",
          url: site_url+"cif/search_cabang",
          data: {keyword:$(this).val()},
          dataType: "json",
          success: function(response){
            var option = '';
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            // console.log(option);
            $("#result").html(option);
          }
        });
      });

      $("#keyword").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cabang",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          }
      });

      $("#select_cabang").click(function(){
        $("#close","#dialog_cabang").trigger('click');
        branch_code = $("#result option:selected","#dialog_cabang").attr('branch_code');
        branch_name = $("#result option:selected","#dialog_cabang").attr('branch_name');
        $("#cabang").val(branch_code);
        $("#branch_name").val(branch_name);
                    
      });

      $("#result option:selected").live('dblclick',function(){
        $("#select_cabang").trigger('click');
      })

      $("#browse_cabang2").click(function(){
        $.ajax({
          type: "POST",
          url: site_url+"cif/search_cabang",
          data: {keyword:$(this).val()},
          dataType: "json",
          success: function(response){
            var option = '';
            for(i = 0 ; i < response.length ; i++){
               option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            // console.log(option);
            $("#result2").html(option);
          }
        });
      });

      $("#keyword2").on('keypress',function(e){
          if(e.which==13){
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cabang",
              data: {keyword:$(this).val()},
              dataType: "json",
              success: function(response){
                var option = '';
                for(i = 0 ; i < response.length ; i++){
                   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
                }
                // console.log(option);
                $("#result2").html(option);
              }
            });
          }
      });

      $("#select_cabang2").click(function(){
        $("#close","#dialog_cabang2").trigger('click');
        branch_code = $("#result2 option:selected","#dialog_cabang2").attr('branch_code');
        branch_name = $("#result2 option:selected","#dialog_cabang2").attr('branch_name');
        $("#branch_code2").val(branch_code);
        $("#branch_name2").val(branch_name);
                    
      });

      $("#result2 option:selected").live('dblclick',function(){
        $("#select_cabang2").trigger('click');
      })

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_add").click(function(){
        success1.hide();
        error1.hide();
        $("#add").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      // event untuk kembali ke tampilan data table (ADD FORM)
      $("#cancel","#form_edit").click(function(){
        success1.hide();
        error1.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });

      $("#btn_add").click(function(){
        $("#wrapper-table").hide();
        $("#add").show();
        form1.trigger('reset');
      });

      // BEGIN FORM ADD USER VALIDATION
      var form1 = $('#form_add');
      var error1 = $('.alert-error', form1);
      var success1 = $('.alert-success', form1);
      
      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              branch_name: {
                  required: true
              },
              year: {
                  required: true
              },
              month: {
                  required: true
              },
              account_target: {
                  required: true
              },
              amount_target: {
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
            var branch_code = $("#result option:selected",form1).val();
            var year = $("#year",form1).val();
            var month = $("#month option:selected",form1).val();
            $.ajax({
              type:"POST",
              dataType:"json",
              data:{branch_code:branch_code,year:year,month:month},
              url:site_url+"kantor_layanan/get_proyeksi_by_branch",
              success: function(response){
                  if(response.valid===false){
                      alert(response.message);
                  }else{
                    $.ajax({
                      type: "POST",
                      url: site_url+"kantor_layanan/action_regis_proyeksi_droping",
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
                        App.scrollTo(error2, -200);
                      },
                      error:function(){
                          success1.hide();
                          error1.show();
                          App.scrollTo(error2, -200);
                      }
                    });
                  }
              },
              error: function(){
                  alert("Failed to Connect into Database, Please Contact Your Administrator!")
              }
            })

          }
      });

      // BEGIN FORM ADD USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error2', form2);
      var success2 = $('.alert-success2', form2);
      
      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          errorPlacement: function(error, element) {
            element.closest('.controls').append(error);
          },
          rules: {
              branch_name: {
                  required: true
              },
              year: {
                  required: true
              },
              month: {
                  required: true
              },
              account_target: {
                  required: true
              },
              amount_target: {
                  required: true
              }
          },

          invalidHandler: function (event, validator) { //display error alert on form submit              
              success2.hide();
              error2.show();
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
              url: site_url+"kantor_layanan/action_update_proyeksi_droping",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.trigger('reset');
                  form2.children('div').removeClass('success');
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Saved Data');
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

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var proyeksi_droping_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          proyeksi_droping_id[$i] = $(this).val();

          $i++;

        });

        if(proyeksi_droping_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"kantor_layanan/action_delete_proyeksi",
              dataType: "json",
              data: {proyeksi_droping_id:proyeksi_droping_id},
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
      $('#proyeksi_droping_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"kantor_layanan/datatable_proyeksi_droping",
          "aoColumns": [
            null,
            null,
            null,
            null,
            null,
            null
            // { "bSortable": false, "bSearchable": false }
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

      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var proyeksi_droping_id = $(this).attr('proyeksi_droping_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {proyeksi_droping_id:proyeksi_droping_id},
          url: site_url+"kantor_layanan/get_proyeksi_by_id",
          success: function(response){
            $("#form_edit input[name='proyeksi_droping_id']").val(response.proyeksi_droping_id);
            $("#form_edit input[name='branch_name2']").val(response.branch_name);
            $("#form_edit input[name='branch_code2']").val(response.branch_code);
            $("#form_edit input[name='year']").val(response.year);
            $("#form_edit select[name='month']").val(response.month);
            $("#form_edit input[name='year2']").val(response.year);
            $("#form_edit input[name='month2']").val(response.month);
            $("#form_edit input[name='account_target']").val(response.account_target);
            $("#form_edit input[name='amount_target']").val(response.amount_target);

          }
        })


      });


</script>
<!-- END JAVASCRIPTS -->

