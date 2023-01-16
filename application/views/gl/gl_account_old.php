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
      GL Setup <small>Setup GL Account</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">GL Setup</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Setup GL Account</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->


<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>GL Account Setup</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
         <a href="#portlet-config" data-toggle="modal" class="config"></a>
         <a href="javascript:;" class="reload"></a>
         <a href="javascript:;" class="remove"></a>
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
      <table class="table table-striped table-bordered table-hover" id="gl_account_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#gl_account_table .checkboxes" /></th>
               <th width="23%">Account Code</th>
               <th width="23%">Account Name</th>
               <th width="30%">Account Type</th>
               <th>Export PDF</th>
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
         <div class="caption"><i class="icon-reorder"></i>Setup GL Account</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
            <a href="#portlet-config" data-toggle="modal" class="config"></a>
            <a href="javascript:;" class="reload"></a>
            <a href="javascript:;" class="remove"></a>
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
               Setup GL Account Berhasil Diproses !
            </div>      
                    <div class="control-group">
                       <label class="control-label">Account Code<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_code" id="account_code" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Account Name<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_name" id="account_name" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>           
                    <div class="control-group">
                       <label class="control-label">Account Type<span class="required">*</span></label>
                       <div class="controls">
                         <select name="account_type" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <?php foreach($account_type as $data): ?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>
                          </select>
                        </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Account Group<span class="required">*</span></label>
                       <div class="controls">
                        <!-- <input type="hidden" id="group_code" name="group_code"> -->
                         <select name="account_group" class="small m-wrap" data-required="1">                     
                              <option>PILIH</option>
                          </select>
                        </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Default Saldo<span class="required">*</span></label>
                       <div class="controls">
                         <select id="default_saldo" name="default_saldo" class="small m-wrap" data-required="1">                     
                            <option value="">PILIH</option>
                            <option value="D">D</option>
                            <option value="C">C</option>
                          </select>
                        </div>
                    </div>   
                     <div id="dialog_budget" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>BUDGET</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Tahun</h4>
                                      <p><input type="text" name="tahun" id="tahun" tabindex="1" value="0" class="small m-wrap"></p>
                                      <table>
                                        <tr>
                                          <td>
                                            <h5>Januari</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="2" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="januari" id="januari" value="0" class="m-wrap">
                                            <span style="margin-right:60px;"></span>
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Maret</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="4" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="maret" id="maret" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Mei</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="6" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="mei" id="mei" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Juli</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="8" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juli" id="juli" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>September</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="10" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="september" id="september" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>November</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="12" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="november" id="november" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                          </td>
                                          <td>
                                            <h5>Februari</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="3" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="februari" id="februari" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>April</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="5" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="april" id="april" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Juni</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="7" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juni" id="juni" value="0" class=" m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Agustus</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="9" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="agustus" id="agustus" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Oktober</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="11" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="oktober" id="oktober" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                            <h5>Desember</h5>
                                            <div class="input-prepend input-append">
                                            <span class="add-on">Rp</span>
                                            <input type="text" style="margin-bottom:7px;width:150px;" tabindex="13" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="desember" id="desember" value="0" class="m-wrap">
                                            <span class="add-on">,00</span>
                                            </div>
                                          </td>
                                        </tr>
                                      </table>
                                   </div>
                                </div>
                             </div>
                             <div class="modal-footer">
                                <button type="button" id="close" data-dismiss="modal" class="btn" tabindex="15">Close</button>
                                <button type="button" id="save" class="btn blue" tabindex="14">Save</button>
                             </div>
                             </div>

                        <a id="browse_rembug" style="margin-left:60px; margin-bottom:20px;" class="btn blue" data-toggle="modal" href="#dialog_budget">Budget</a>
                    
                    <div class="form-actions">
                   <button type="submit" class="btn green">Save</button>
                   <button type="button" class="btn" id="cancel">Back</button>
                </div>
               </div> 
              </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>
</div>
<!-- END ADD USER -->

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
      Index.init();
      Index.initCalendar(); // init index page's custom scripts
      Index.initChat();
      Index.initDashboardDaterange();
      Index.initIntro();
      $("input#mask_date,.mask_date").livequery(function(){
      $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
   });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$(function(){
        $("select[name='account_type']").change(function(){
          var code_value = $("select[name='account_type']").val();
          $.ajax({
            type: "POST",
            url: site_url+"gl/search_account_group",
            async: false,
            dataType: "json",
            data: {code_value:code_value},
            success: function(response)
            {
              html = '<option>PILIH</option>';
              for(i=0;i<response.length;i++){
                html+='<option value="'+response[i].group_code+'">'+response[i].group_name+'</option>';
              }
              $("select[name='account_group']").html(html);
            }
          });         
        
        });   


     // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'gl_account_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#gl_account_table .group-checkable').live('change',function () {
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

      $("#gl_account_table .checkboxes").livequery(function(){
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
              account_code: {
                  required: true
              },
              account_name: {
                  required: true
              },
              account_type: {
                  required: true
              },
              default_saldo: {
                required: true
              },
              januari: {
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
              url: site_url+"gl/proses_input_setup_gl_account",
              dataType: "json",
              data: form1.serialize(),
              success: function(response){
                if(response.success==true){
                  success1.show();
                  error1.hide();
                  form1.trigger('reset');
                  form1.children('div').removeClass('success');
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

      $("#save").click(function(){
              var code_account  = $("input[name='account_code']").val();
              var tahun         = $("input[name='tahun']").val();
              var januari       = $("input[name='januari']").val();
              var februari      = $("input[name='februari']").val();
              var maret         = $("input[name='maret']").val();
              var april         = $("input[name='april']").val();
              var mei           = $("input[name='mei']").val();
              var juni          = $("input[name='juni']").val();
              var juli          = $("input[name='juli']").val();
              var agustus       = $("input[name='agustus']").val();
              var september     = $("input[name='september']").val();
              var oktober       = $("input[name='oktober']").val();
              var november      = $("input[name='november']").val();
              var desember      = $("input[name='desember']").val();

              if(code_account=="")
              {
                  alert('Account Code Belum Diisi');    
              }
              else
              {

         $.ajax({
              type: "POST",
              url: site_url+"gl/proses_input_setup_gl_account_budget",
              data: {
                code_account:code_account,
                tahun:tahun,
                januari:januari,
                februari:februari,
                maret:maret,
                april:april,
                mei:mei,
                juni:juni,
                juli:juli,
                agustus:agustus,
                september:september,
                oktober:oktober,
                november:november,
                desember:desember
              },
              dataType: "json",

              success: function(response){
                if(response.success==true)
                {
                  alert('Budget Berhasil Disimpan');
                  $(".close","#dialog_budget").trigger('click');
                }
                else if(response.success==false)
                {
                  alert('Budget Gagal Disimpan');
                }
              }

            });
     
              }


     
        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

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
        var account_deposit_id = $(this).attr('account_deposit_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_deposit_id:account_deposit_id},
          url: site_url+"transaction/get_deposit_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='account_deposit_id']").val(response.account_deposit_id);
            $("#form_edit input[name='no_customer']").val(response.cif_no);
            $("#form_edit input[name='nama_lengkap']").val(response.nama);
            $("#form_edit input[name='nama_panggilan']").val(response.panggilan);
            $("#form_edit input[name='nama_ibu']").val(response.ibu_kandung);
            $("#form_edit input[name='tempat_lahir']").val(response.tmp_lahir);
            $("#form_edit input[name='tanggal_lahir']").val(response.tgl_lahir);
            $("#form_edit input[name='usia']").val(response.usia);
            $("#form_edit textarea[name='alamat']").val(response.alamat);
            var rt = response.rt_rw;
            var rt_ok = rt.substring(0,2);
                        
               $("#form_edit input[name='rt']").val(rt_ok);

            var rw = response.rt_rw;
            var rw_ok = rw.substring(5,3);

            $("#form_edit input[name='rw']").val(rw_ok);

            $("#form_edit input[name='desa']").val(response.desa);
            $("#form_edit input[name='kecamatan']").val(response.kecamatan);
            $("#form_edit input[name='kabupaten']").val(response.kabupaten);
            $("#form_edit input[name='kode_pos']").val(response.kodepos);
            $("#form_edit input[name='no_telp']").val(response.telpon_rumah);
            $("#form_edit input[name='telp_seluler']").val(response.telpon_seluler);
            $("#form_edit input[name='no_rekening']").val(response.account_deposit_no);
            $("#form_edit input[name='jangka_waktu']").val(response.jangka_waktu);
            $("#form_edit input[name='nisbah_bagihasil']").val(response.nisbah_bagihasil);
            $("#form_edit input[name='nominal']").val(response.nominal);
            $("#form_edit input[name='rek_bagi_hasil']").val(response.account_saving_no);
           $("#form_edit select[name='product']").val(response.product_code);
            var aro = response.automatic_roll_over;
                      if(aro=='1'){
                        $("input[name='ya'][value='1']").attr('checked');
                        $("input[name='ya'][value='1']").closest('span').addClass('checked');
                        $("input[name='ya'][value='0']").closest('span').removeClass('checked');
                      }
                      else
                      {
                        $("input[name='ya'][value='0']").attr('checked');
                        $("input[name='ya'][value='0']").closest('span').addClass('checked');
                        $("input[name='ya'][value='1']").closest('span').removeClass('checked');
                      }
      
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              no_customer: {
                  required: true
              },
              product: {
                  required: true
              },
              jangka_waktu: {
                  required: true
              },
              nominal: {
                  required: true
              },
        nisbah_bagihasil: {
      required:true
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
              url: site_url+"transaction/edit_deposit",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
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

        var account_deposit_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_deposit_id[$i] = $(this).val();

          $i++;

        });

        if(account_deposit_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"transaction/delete_deposit",
              dataType: "json",
              data: {account_deposit_id:account_deposit_id},
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
      $('#gl_account_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"gl/datatable_gl_account_setup",
          "aoColumns": [
            null,
            null,
            null,
            null,
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

      
      jQuery('#gl_account_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#gl_account_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

  });
});

</script>
<!-- END JAVASCRIPTS -->

