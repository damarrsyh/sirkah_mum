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
      Kas Petugas <small>Setup Kas Petugas</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Kas Petugas</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Setup Kas Petugas</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Setup Kas Petugas</div>
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
      <table class="table table-striped table-bordered table-hover" id="kas_petugas_table">
         <thead>
            <tr>
               <th width="1%"><input type="checkbox" class="group-checkable" data-set="#kas_petugas_table .checkboxes" /></th>
               <th width="15%">Kode Kas</th>
               <th width="30%">Nama Kas</th>
               <th width="24%">Pemegang Kas</th>
               <th width="25%">User</th>
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
         <div class="caption"><i class="icon-reorder"></i>Setup Kas Petugas</div>
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
               Setup Kas Petugas Berhasil Diproses !
            </div>      
                    <div class="control-group">
                       <label class="control-label">Cabang<span class="required">*</span></label>
                       <div class="controls">
                         <select name="cabang" id="cabang" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($branch as $data): ?>
                              <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Petugas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="petugas" id="petugas" class="small m-wrap" data-required="1">                     
                            
                          </select>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">GL Account<span class="required">*</span></label>
                       <div class="controls">
                         <select name="account_name" id="account_name" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($account_name as $data): ?>
                              <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Nama Kas<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_kas" id="nama_kas" readonly="" data-required="1" class="medium m-wrap"/>
                        </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Kas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_kas" id="jenis_kas" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="0">Kas Petugas</option>
                              <option value="1">Kas Teller</option>
                          </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Kode Kas<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="kode_kas" id="kode_kas" readonly="" data-required="1" class="medium m-wrap"/>
                        </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">User<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="fullname" id="fullname" readonly data-required="1" class="medium m-wrap" style="background:#EEE" />
                          <input type="hidden" name="user_id" id="user_id"/>
                          <a id="browse_user" class="btn blue" tabindex="4" style="padding:4px 10px;" data-toggle="modal" href="#dialog_user">...</a>
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
               <div class="caption"><i class="icon-reorder"></i>Edit Kas Petugas</div>
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
                  <input type="hidden" id="account_cash_id" name="account_cash_id">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  <div class="alert alert-success hide">
                     <button class="close" data-dismiss="alert"></button>
                     Edit Kas Petugas Successful!
                  </div>

                  <br>  
                    <div class="control-group">
                       <label class="control-label">Cabang<span class="required">*</span></label>
                       <div class="controls">
                         <select name="cabang2" id="cabang2" class="medium m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($branch as $data): ?>
                              <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Petugas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="petugas2" id="petugas2" class="small m-wrap" data-required="1">                     
                            
                          </select>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">GL Account<span class="required">*</span></label>
                       <div class="controls">
                         <select name="account_name2" id="account_name2" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($account_name as $data): ?>
                              <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_name'];?></option>
                            <?php endforeach?>
                          </select>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Nama Kas<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="nama_kas2" id="nama_kas2" readonly="" data-required="1" class="medium m-wrap"/>
                        </div>
                    </div>             
                    <div class="control-group">
                       <label class="control-label">Jenis Kas<span class="required">*</span></label>
                       <div class="controls">
                         <select name="jenis_kas2" id="jenis_kas2" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                              <option value="0">Kas Petugas</option>
                              <option value="1">Kas Teller</option>
                          </select>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Kode Kas<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="kode_kas2" id="kode_kas2" readonly="" data-required="1" class="medium m-wrap"/>
                        </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">User<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="fullname" id="fullname" readonly data-required="1" class="medium m-wrap" style="background:#EEE" />
                          <input type="hidden" name="user_id" id="user_id"/>
                          <a id="browse_user" class="btn blue" tabindex="4" style="padding:4px 10px;" data-toggle="modal" href="#dialog_user_edit">...</a>
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

      //BEGIN baru 03-09-2013
      $("select[name='cabang']").change(function(){
          var branch_code = $(this).val();
         $.ajax({
           type: "POST",
           url: site_url+"gl/get_fa_by_branch_code",
           dataType: "json",
           data: {branch_code:branch_code},
           success: function(response){
              html = '<option value="">PILIH</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_name+'</option>';
              }
              $("#petugas").html(html);
           }
        });        
      });

      //BEGIN baru 03-09-2013
      $("select[name='cabang']").change(function(){
          var branch_code = $(this).val();
         $.ajax({
           type: "POST",
           url: site_url+"gl/get_fa_by_branch_code",
           dataType: "json",
           data: {branch_code:branch_code},
           success: function(response){
              html = '<option value="">PILIH</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_name+'</option>';
              }
              $("#petugas").html(html);
           }
        });        
      });


      $("select[name='cabang2']").change(function(){ //UNTUK FORM EDIT
          var branch_code = $(this).val();
         $.ajax({
           type: "POST",
           url: site_url+"gl/get_fa_by_branch_code",
           dataType: "json",
           async:false,
           data: {branch_code:branch_code},
           success: function(response){
              html = '<option value="">PILIH</option>';
              for ( i = 0 ; i < response.length ; i++ )
              {
                 html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_name+'</option>';
              }
              $("#petugas2").html(html);
           }
        });        
      }); 
      //END baru 03-09-2013

     $("select[name='petugas']").change(function(){
          var fa_code = $(this).val();
         $.ajax({
          url: site_url+"gl/get_ajax_fa_code",
          type: "POST",
          dataType: "html",
          data: {fa_code:fa_code},
          success: function(response)
          {
            $("#kode_kas").val(response);
          }
        });       
        
        if($("select[name='account_name']").val()!="")
          $("select[name='account_name']").trigger('change');

        });   

     $("select[name='account_name']").change(function(){
          var fa_code  = $("#petugas").val();
          var account_code = $(this).val();
         $.ajax({
          url: site_url+"gl/get_ajax_nama_kas",
          type: "POST",
          dataType: "html",
          data: {account_code:account_code,fa_code:fa_code},
          success: function(response)
          {
            $("#nama_kas").val(response);
          }
        });       
        
        });   

     $("select[name='petugas2']").change(function(){
          var fa_code = $(this).val();
         $.ajax({
          url: site_url+"gl/get_ajax_fa_code",
          type: "POST",
          dataType: "html",
          data: {fa_code:fa_code},
          success: function(response)
          {
            $("#kode_kas2").val(response);
          }
        });       
        $("select[name='account_name2']").trigger('change');
        });   

     $("select[name='account_name2']").change(function(){
          var fa_code  = $("#petugas2").val();
          var account_code = $(this).val();
         $.ajax({
          url: site_url+"gl/get_ajax_nama_kas",
          type: "POST",
          dataType: "html",
          data: {account_code:account_code,fa_code:fa_code},
          success: function(response)
          {
            $("#nama_kas2").val(response);
          }
        });       
        
        }); 
		

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'kas_petugas_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#kas_petugas_table .group-checkable').live('change',function () {
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

      $("#kas_petugas_table .checkboxes").livequery(function(){
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
              cabang: {
                  required: true
              },
              jenis_kas: {
                  required: true
              },
              petugas: {
                  required: true
              },
              account_name: {
                  required: true
              },
              nama_kas: {
                  required: true
              },
              jenis_kas: {
                  required: true
              },
              kode_kas: {
                  required: true
              },
              fullname: {
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
              url: site_url+"gl/proses_input_setup_kas_petugas",
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
        var account_cash_id = $(this).attr('account_cash_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_cash_id:account_cash_id},
          url: site_url+"gl/get_gl_account_cash_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='account_cash_id']").val(response.account_cash_id);
            $("#form_edit select[name='cabang2']").val(response.branch_code);
            $("#form_edit select[name='cabang2']").trigger('change');
            $("#form_edit select[name='petugas2']").val(response.fa_code);
            $("#form_edit select[name='account_name2']").val(response.gl_account_code);
            $("#form_edit select[name='jenis_kas2']").val(response.account_cash_type);
            $("#form_edit input[name='nama_kas2']").val(response.account_cash_name);
            $("#form_edit input[name='kode_kas2']").val(response.account_cash_code);
            if(response.user_id!=null){
              $("#form_edit input[name='user_id']").val(response.user_id);
              $("#form_edit input[name='fullname']").val(response.user_id+' - '+response.fullname);
            }else{
              $("#form_edit input[name='user_id']").val('');
              $("#form_edit input[name='fullname']").val('');
            }
             // html = '';
             //     html += '<option value="'+response.fa_code+'">'+response.fa_name+'</option>';
             
             //  $("#petugas2").html(html);
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              petugas2: {
                  required: true
              },
              account_name2: {
                  required: true
              },
              nama_kas2: {
                  required: true
              },
              jenis_kas2: {
                  required: true
              },
              kode_kas2: {
                  required: true
              },
              fullname: {
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
              url: site_url+"gl/proses_edit_setup_kas_petugas",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#kas_petugas_table_filter input").val('');
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

        var account_cash_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_cash_id[$i] = $(this).val();

          $i++;

        });

        if(account_cash_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"gl/delete_gl_account_cash",
              dataType: "json",
              data: {account_cash_id:account_cash_id},
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
      $('#kas_petugas_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"gl/datatable_setup_kas_petugas",
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

      jQuery('#kas_petugas_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kas_petugas_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
