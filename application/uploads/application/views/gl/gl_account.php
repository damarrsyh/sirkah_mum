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
      <hr style="margin:0;">
      <div class="clearfix" style="background:#EEE" id="form-filter">
        <label style="line-height:44px;float:left;margin-bottom:0;padding:0 5px 0 10px">Account Type</label>
        <div style="padding:5px;float:left;">
          <select id="account_type" name="account_type" class="small m-wrap chosen" data-required="1" style="margin:0 5px;">
            <option value="">PILIH</option>
            <?php foreach($account_type as $data): ?>
              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
            <?php endforeach?>
          </select>
        </div>
        <label style="margin-bottom:0;line-height:44px;float:left;">Account Group</label>
        <div style="padding:5px;float:left;">
          <select id="account_group" name="account_group" class="large m-wrap chosen" data-required="1" style="margin:0 5px;">
              <option value="">PILIH</option>
          </select>
        </div>
        <div style="padding:5px;float:left;">
          <button class="btn blue" id="btn-filter">Filter</button>
        </div>
      </div>
      <hr style="margin:0 0 10px;">
      <table class="table table-striped table-bordered table-hover" id="gl_account_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#gl_account_table .checkboxes" /></th>
               <th width="15%">Account Code</th>
               <th width="46%">Account Name</th>
               <th width="20%">Account Type</th>
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
<div id="add" style="display:none;">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Setup GL Account</div>
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
               Setup GL Account Berhasil Diproses !
            </div>                 
                    <div class="control-group">
                       <label class="control-label">Account Type<span class="required">*</span></label>
                       <div class="controls">
                         <select name="account_type" class="small m-wrap  chosen" data-required="1">                     
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
                         <select name="account_group" class="large m-wrap chosen" data-required="1">                     
                              <option value="">PILIH</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Default Saldo<span class="required">*</span></label>
                       <div class="controls">
                         <select id="default_saldo" name="default_saldo" class="small m-wrap chosen" data-required="1">                     
                            <option value="" selected="selected">PILIH</option>
                            <option value="D">D</option>
                            <option value="C">C</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Flag Akses<span class="required">*</span></label>
                       <div class="controls">
                         <select id="flag_akses" name="flag_akses" class="small m-wrap chosen" data-required="1">                     
                            <option value="S">SEMUA</option>
                            <option value="P">PUSAT</option>
                            <option value="C">CABANG</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Account Code<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_code" id="account_code" data-required="1" class="medium m-wrap" maxlength="7" />
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Account Name<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_name" id="account_name" data-required="1" class="medium m-wrap"/>
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
                                     <table>
                                        <tr>
                                            <td><h4>Tahun</h4></td>
                                            <td>
                                            <input type="text" style="width:50px;" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="4" name="tahun" id="tahun" tabindex="1" value="0" class="m-wrap">
                                            </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4"><hr></td>
                                        </tr>
                                        <tr>
                                            <td>Januari</td>
                                            <td style="padding-right:60px;">
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="2" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="januari" id="januari" value="0" class="m-wrap mask-money">
                                            </td>

                                            <td>Juli</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="8" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juli" id="juli" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td width="200px">Februari</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="3" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="februari" id="februari" value="0" class="m-wrap mask-money">
                                            </td>

                                            <td>Agustus</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="9" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="agustus" id="agustus" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Maret</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="4" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="maret" id="maret" value="0" class="m-wrap mask-money">
                                            </td>

                                            <td>September</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="10" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="september" id="september" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>
                                          </td>
                                          <td>
                                            <tr>
                                            <td>April</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="5" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="april" id="april" value="0" class="m-wrap mask-money">
                                            </td>

                                            <td>Oktober</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="11" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="oktober" id="oktober" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Mei</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="6" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="mei" id="mei" value="0" class="m-wrap mask-money">
                                            </td>

                                            <td>November</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="12" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="november" id="november" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Juni</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="7" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juni" id="juni" value="0" class=" m-wrap mask-money">
                                            </td>

                                            <td width="200px">Desember</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="13" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="desember" id="desember" value="0" class="m-wrap mask-money">
                                            </td>
                                            </tr>
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
        <!--  </div>
      </div> -->
<!-- END ADD USER -->

      <!-- BEGIN EDIT USER -->
      <div id="edit" class="hide">
         
         <div class="portlet box purple">
            <div class="portlet-title">
               <div class="caption"><i class="icon-reorder"></i>Edit GL Account</div>
               <div class="tools">
                  <a href="javascript:;" class="collapse"></a>
               </div>
            </div>
            <div class="portlet-body form">
               <!-- BEGIN FORM-->
               <form action="#" id="form_edit" class="form-horizontal">
                  <input type="hidden" id="gl_account_id" name="gl_account_id">
                  <div class="alert alert-error hide">
                     <button class="close" data-dismiss="alert"></button>
                     You have some form errors. Please check below.
                  </div>
                  <div class="alert alert-success hide">
                     <button class="close" data-dismiss="alert"></button>
                     Edit GL Account Successful!
                  </div>

                  <br>  
                    <div class="control-group">
                       <label class="control-label">Account Type<span class="required">*</span></label>
                       <div class="controls">
                         <select name="account_type" class="small m-wrap chosen" data-required="1">                     
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
                         <select name="account_group" class="large m-wrap chosen" data-required="1">                     
                              <option value="">PILIH</option>
                          </select>
                        </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Default Saldo<span class="required">*</span></label>
                       <div class="controls">
                         <select id="default_saldo" name="default_saldo" class="small m-wrap" data-required="1">                     
                            <option value="" selected="selected">PILIH</option>
                            <option value="D">D</option>
                            <option value="C">C</option>
                          </select>
                        </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Flag Akses<span class="required">*</span></label>
                       <div class="controls">
                         <select id="flag_akses" name="flag_akses" class="small m-wrap" data-required="1">                     
                            <option value="S">SEMUA</option>
                            <option value="P">PUSAT</option>
                            <option value="C">CABANG</option>
                          </select>
                        </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Account Code<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_code2" id="account_code" data-required="1" class="medium m-wrap" maxlength="7" />
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Account Name<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="account_name" id="account_name" data-required="1" class="medium m-wrap"/>
                       </div>
                    </div>           
                     <div id="dialog_budget2" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>BUDGET</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <input type="hidden" id="gl_account_budget_id" name="gl_account_budget_id">
                                      <table>
                                        <tr>
                                            <td><h4>Tahun</h4></td>
                                            <td>
                                            <input type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" style="width:50px;" maxlength="4" name="tahun2" id="tahun" tabindex="1" value="0" class="m-wrap">
                                            </td>
                                        </tr>
                                        <tr>
                                          <td colspan="4"><hr></td>
                                        </tr>
                                        <tr>
                                            <td>Januari</td>
                                            <td style="padding-right:60px;">
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="2" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="januari2" id="januari" value="0" class="m-wrap">
                                            </td>

                                            <td>Juli</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="8" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juli2" id="juli" value="0" class="m-wrap">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td width="200px">Februari</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="3" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="februari2" id="februari" value="0" class="m-wrap">
                                            </td>

                                            <td>Agustus</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="9" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="agustus2" id="agustus" value="0" class="m-wrap">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Maret</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="4" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="maret2" id="maret" value="0" class="m-wrap">
                                            </td>

                                            <td>September</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="10" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="september2" id="september" value="0" class="m-wrap">
                                            </td>
                                            </tr>
                                          </td>
                                          <td>
                                            <tr>
                                            <td>April</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="5" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="april2" id="april" value="0" class="m-wrap">
                                            </td>

                                            <td>Oktober</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="11" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="oktober2" id="oktober" value="0" class="m-wrap">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Mei</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="6" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="mei2" id="mei" value="0" class="m-wrap">
                                            </td>

                                            <td>November</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="12" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="november2" id="november" value="0" class="m-wrap">
                                            </td>
                                            </tr>

                                            <tr>
                                            <td>Juni</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="7" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="juni2" id="juni" value="0" class=" m-wrap">
                                            </td>

                                            <td width="200px">Desember</td>
                                            <td>
                                            <input type="text" style="margin-bottom:7px;width:140px;" tabindex="13" maxlength="12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" name="desember2" id="desember" value="0" class="m-wrap">
                                            </td>
                                            </tr>
                                          </td>
                                        </tr>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                             <div class="modal-footer">
                                <button type="button" id="close" data-dismiss="modal" class="btn" tabindex="15">Close</button>
                                <button type="button" id="save2" class="btn blue" tabindex="14">Save</button>
                             </div>
                             </div>
                        <a id="browse_budget" style="margin-left:60px; margin-bottom:20px;" class="btn blue" data-toggle="modal" href="#dialog_budget2">Budget</a>
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

    $("#btn-filter").click(function(){
      dTreload();
    })

     $("select[name='account_type']","#form_add").change(function(){
        var code_value = $(this).val();
        $.ajax({
          type: "POST",
          url: site_url+"gl/search_account_group",
          async: false,
          dataType: "json",
          data: {code_value:code_value},
          success: function(response)
          {
            html = '<option value="">PILIH</option>';
            for(i=0;i<response.length;i++){
              html+='<option value="'+response[i].group_code+'">'+response[i].group_code+' - '+response[i].group_name+'</option>';
            }
            $("select[name='account_group']","#form_add").html('');
            $("select[name='account_group']","#form_add").html(html);
            $("select[name='account_group']","#form_add").trigger('liszt:updated');
          }
        });         
      
      });   

     $("select[name='account_type']","#form_edit").change(function(){
        var code_value = $(this).val();
        $.ajax({
          type: "POST",
          url: site_url+"gl/search_account_group",
          async: false,
          dataType: "json",
          data: {code_value:code_value},
          success: function(response)
          {
            html = '<option value="">PILIH</option>';
            for(i=0;i<response.length;i++){
              html+='<option value="'+response[i].group_code+'">'+response[i].group_code+' - '+response[i].group_name+'</option>';
            }
            $("select[name='account_group']","#form_edit").html('');
            $("select[name='account_group']","#form_edit").html(html);
            $("select[name='account_group']","#form_edit").trigger('liszt:updated');
          }
        });         
      
      });    

     $("select[name='account_type']","#form-filter").change(function(){
        var code_value = $(this).val();
        $.ajax({
          type: "POST",
          url: site_url+"gl/search_account_group",
          async: false,
          dataType: "json",
          data: {code_value:code_value},
          success: function(response)
          {
            html = '<option value="">PILIH</option>';
            for(i=0;i<response.length;i++){
              html+='<option value="'+response[i].group_code+'">'+response[i].group_code+' - '+response[i].group_name+'</option>';
            }

            $("select[name='account_group']","#form-filter").html('');
            $("select[name='account_group']","#form-filter").html(html);
            $("select[name='account_group']","#form-filter").trigger('liszt:updated');
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
        // $(".paging_bootstrap li:first a").trigger('click');
        // $("#"+tbl_id+"_filter input").val('').trigger('keyup');
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
      var form1     = $('#form_add');
      var error1    = $('.alert-error', form1);
      var success1  = $('.alert-success', form1);

      
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
                  $("#cancel",form_add).trigger('click')
                  alert('Successfully Updated Data');
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
        var gl_account_id = $(this).attr('gl_account_id');
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {gl_account_id:gl_account_id},
          url: site_url+"gl/get_gl_account_by_id",
          success: function(response){
            console.log(response);
            form2.trigger('reset');
            $("#form_edit input[name='gl_account_id']").val(response.gl_account_id);
            $("#form_edit input[name='account_code2']").val(response.account_code);
            $("#form_edit input[name='account_name']").val(response.account_name);
            $("#form_edit select[name='account_type']").val(response.account_type);
            $("#form_edit select[name='account_type']").trigger('change');
            $("#form_edit select[name='account_group']").delay(1000).val(response.account_group_code);
            $("#form_edit select[name='default_saldo']").val(response.transaction_flag_default);
            $("#form_edit select[name='flag_akses']").val(response.flag_akses);
            $("#form_edit select[name='flag_akses']").trigger('liszt:updated');
            $("#form_edit select[name='account_type']").trigger('liszt:updated');
            $("#form_edit select[name='account_group']").trigger('liszt:updated');
            $("#form_edit select[name='default_saldo']").trigger('liszt:updated');
          }
        })

      });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
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
              url: site_url+"gl/proses_edit_setup_gl_account",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  alert(response.message);
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

      $("#browse_budget").live('click',function(){
        var account_code = $("#form_edit input[name='account_code2']").val();
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {account_code:account_code},
          url: site_url+"gl/get_gl_account_budget_by_id",
          success: function(response){
            console.log(response);
            if(response.length>0)
            {
              response = response[0];
              $("#form_edit input[name='account_code2']").val(response.account_code);
              $("#form_edit input[name='tahun2']").val(response.budget_year);
              $("#form_edit input[name='januari2']").val(response.m1);
              $("#form_edit input[name='februari2']").val(response.m2);
              $("#form_edit input[name='maret2']").val(response.m3);
              $("#form_edit input[name='april2']").val(response.m4);
              $("#form_edit input[name='mei2']").val(response.m5);
              $("#form_edit input[name='juni2']").val(response.m6);
              $("#form_edit input[name='juli2']").val(response.m7);
              $("#form_edit input[name='agustus2']").val(response.m8);
              $("#form_edit input[name='september2']").val(response.m9);
              $("#form_edit input[name='oktober2']").val(response.m10);
              $("#form_edit input[name='november2']").val(response.m11);
              $("#form_edit input[name='desember2']").val(response.m12);
            }
            
          }
        })

      });

      $("#save2").click(function(){
              //var gl_account_budget_id  = $("input[name='gl_account_budget_id']").val();
              var code_account          = $("input[name='account_code2']").val();
              var tahun                 = $("input[name='tahun2']").val();
              var januari               = $("input[name='januari2']").val();
              var februari              = $("input[name='februari2']").val();
              var maret                 = $("input[name='maret2']").val();
              var april                 = $("input[name='april2']").val();
              var mei                   = $("input[name='mei2']").val();
              var juni                  = $("input[name='juni2']").val();
              var juli                  = $("input[name='juli2']").val();
              var agustus               = $("input[name='agustus2']").val();
              var september             = $("input[name='september2']").val();
              var oktober               = $("input[name='oktober2']").val();
              var november              = $("input[name='november2']").val();
              var desember              = $("input[name='desember2']").val();

              if(code_account=="")
              {
                  alert('Account Code Belum Diisi');    
              }
              else
              {

         $.ajax({
              type: "POST",
              url: site_url+"gl/proses_edit_setup_gl_account_budget",
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
                  $(".close","#dialog_budget2").trigger('click');
                }
                else if(response.success==false)
                {
                  alert('Budget Gagal Disimpan');
                }
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

        var gl_account_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          gl_account_id[$i] = $(this).val();

          $i++;

        });

        if(gl_account_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"gl/delete_gl_account",
              dataType: "json",
              data: {gl_account_id:gl_account_id},
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
          "fnServerParams": function ( aoData ) {
               aoData.push( { "name": "account_type", "value": $("#account_type","#form-filter").val() } );
               aoData.push( { "name": "account_group", "value": $("#account_group","#form-filter").val() } );
           },
          "aoColumns": [
            null,
            null,
            null,
            null,
            { "bSortable": false, "bSearchable": false },
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
      $(".dataTables_length,.dataTables_filter").parent().hide();

      jQuery('#gl_account_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#gl_account_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>

<!-- END JAVASCRIPTS -->
