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
      Program Setup <small>Program Penyaluran Dana</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">CIF</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Program Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Program Penyaluran Dana</div>
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
        <!--  <div class="btn-group pull-right">
            <button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="icon-angle-down"></i>
            </button>
            <ul class="dropdown-menu pull-right">
               <li><a href="#">Print</a></li>
               <li><a href="#">Save as PDF</a></li>
               <li><a href="#">Export to Excel</a></li>
            </ul> 
         </div>-->
      </div>
      <table class="table table-striped table-bordered table-hover" id="program_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#program_table .checkboxes" /></th>
               <th width="23%">ID</th>
               <th width="23%">Nama Program</th>
               <th width="23%">Nama Lembaga</th>
               <th width="23%">Sifat Dana</th>
               <th>Edit</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->




<!-- BEGIN ADD PROGRAN -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Program Penyalura Dana</div>
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
               Program Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Program<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="program_code" id="program_code" maxlength="2"  data-required="1" style="width:30px;" class="m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Program<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="program_name" id="program_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lembaga<span class="required">*</span></label>
               <div class="controls">
                  <select name="program_owner" id="program_owner" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php foreach($kreditur as $lembaga): ?>
                     <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Sifat Dana<span class="required">*</span></label>
               <div class="controls">
                  <select name="sifat_dana" id="sifat_dana" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Hibah</option>
                     <option value="1">Dana Bergulir</option>
                     <option value="2">Pembiayaan</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Target Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="target_customer" id="target_customer" data-required="1" style="width:50px;" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Target Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                        <input type="text" name="target_pembiayaan" id="target_pembiayaan" data-required="1" class="medium m-wrap mask-money" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Periode Kerjasama<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_mulai" id="tanggal_mulai" data-required="1" class="date-picker medium m-wrap"/>&nbsp;sd &nbsp;<input type="text" name="tanggal_berakhir" id="tanggal_berakhir" data-required="1" class="date-picker medium m-wrap"/>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Branch</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="financing_program_id" name="financing_program_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Program Berhasil Di Edit !
            </div>
          </br>
            
            <div class="control-group">
               <label class="control-label">Kode Program<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="program_code2" id="program_code2" maxlength="2"  data-required="1" style="width:30px;" class="m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Program<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="program_name2" id="program_name2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Lembaga<span class="required">*</span></label>
               <div class="controls">
                  <select name="program_owner2" id="program_owner2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php foreach($kreditur as $lembaga): ?>
                     <option value="<?php echo $lembaga['code_value'] ?>"><?php echo $lembaga['display_text'] ?></option>
                     <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Sifat Dana<span class="required">*</span></label>
               <div class="controls">
                  <select name="sifat_dana2" id="sifat_dana2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Hibah</option>
                     <option value="1">Dana Bergulir</option>
                     <option value="2">Pembiayaan</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Target Customer<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="target_customer2" id="target_customer2" data-required="1" style="width:50px;" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Target Pembiayaan<span class="required">*</span></label>
               <div class="controls">
                  <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" name="target_pembiayaan2" id="target_pembiayaan2" data-required="1" class="medium m-wrap mask-money" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')"/>
                     <span class="add-on">,00</span>
                  </div>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Periode Kerjasama<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="tanggal_mulai2" id="tanggal_mulai2" data-required="1" class="date-picker medium m-wrap"/>&nbsp;sd &nbsp;<input type="text" name="tanggal_berakhir2" id="tanggal_berakhir2" data-required="1" class="date-picker medium m-wrap"/>
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
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->  

<script>
   jQuery(document).ready(function() {    
      App.init(); // initlayout and core plugins
    
      $("#tanggal_mulai").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_berakhir").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_mulai2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
      $("#tanggal_berakhir2").inputmask("d/m/y", {autoUnmask: true});  //direct mask
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
        var tbl_id = 'program_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#program_table .group-checkable').live('change',function () {
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

      $("#program_table .checkboxes").livequery(function(){
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
              program_code: {
                  required: true
              },
              program_name: {
                  required: true
              },
              program_owner: {
                  required: true
              },
              sifat_dana: {
                  required: true
              },
              target_customer: {
                  required: true
              },
              target_pembiayaan: {
                  required: true
              },
              tanggal_mulai: {
                  required: true
              },
              tanggal_berakhir: {
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
              url: site_url+"cif/add_program",
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
        var financing_program_id = $(this).attr('financing_program_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {financing_program_id:financing_program_id},
          url: site_url+"cif/get_program_by_financing_program_id",
          success: function(response)
          {
            $("#form_edit input[name='financing_program_id']").val(response.financing_program_id);
            $("#form_edit input[name='program_code2']").val(response.program_code);
            $("#form_edit input[name='program_name2']").val(response.program_name);
            $("#form_edit select[name='program_owner2']").val(response.program_owner_code);
            $("#form_edit select[name='sifat_dana2']").val(response.sifat_dana); 
            $("#form_edit input[name='target_customer2']").val(response.target_customer);
            $("#form_edit input[name='target_pembiayaan2']").val(response.target_pembiayaan); 

            var tanggal_mulai = response.tanggal_mulai;
            var tgl = tanggal_mulai.substring(8,10);
            var bln = tanggal_mulai.substring(5,7);
            var thn = tanggal_mulai.substring(0,4);
            var tgl_mulai = tgl+""+bln+""+thn;  
            $("#form_edit input[name='tanggal_mulai2']").val(tgl_mulai);

            var tanggal_berakhir = response.tanggal_berakhir;
            var tgl2 = tanggal_berakhir.substring(8,10);
            var bln2 = tanggal_berakhir.substring(5,7);
            var thn2 = tanggal_berakhir.substring(0,4);
            var tgl_berakhir = tgl2+""+bln2+""+thn2;  

            $("#form_edit input[name='tanggal_berakhir2']").val(tgl_berakhir); 
                    
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
              program_code2: {
                  required: true
              },
              program_name2: {
                  required: true
              },
              program_owner2: {
                  required: true
              },
              sifat_dana2: {
                  required: true
              },
              target_customer2: {
                  required: true
              },
              target_pembiayaan2: {
                  required: true
              },
              tanggal_mulai2: {
                  required: true
              },
              tanggal_berakhir2: {
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


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"cif/edit_program",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#program_table_filter input").val('');
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





      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var financing_program_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          financing_program_id[$i] = $(this).val();

          $i++;

        });

        if(financing_program_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"cif/delete_program",
              dataType: "json",
              data: {financing_program_id:financing_program_id},
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
      $('#program_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"cif/datatable_program_setup",
          "aoColumns": [
            {"bSearchable": false},
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


      jQuery('#program_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#program_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

