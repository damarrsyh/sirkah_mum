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
      Pembiayaan <small>Pengajuan Pembiayaan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Pengajuan Rekening Pembiayaan</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Pengajuan Pembiayaan</div>
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
      <table class="table table-striped table-bordered table-hover" id="pengajuan_pembiayaan_table">
         <thead>
            <tr>
               <th width="3%"><input type="checkbox" class="group-checkable" data-set="#pengajuan_pembiayaan_table .checkboxes" /></th>
               <th width="11%">No. Pengajuan</th>
               <th width="13%">Nama Lengkap</th>
               <th width="10%">Tgl Pengajuan</th>
               <th width="12%">Rencana Droping</th>
               <th width="10%">Amount</th>
               <th width="10%">Peruntukan</th>
               <th width="9%">Pembiayaan</th>
               <th width="4%">Edit</th>
               <th width="4%">Batalkan</th>
               <th width="4%">Tolak</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<div id="dialog_history" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:150px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>History Outstanding Pembiayaan</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <table>
               <tr>
                 <td width="150">No. Pembiayaan</td>
                 <td><div id="history_no_pembiayaan"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Pokok</td>
                 <td><div id="history_sisa_pokok"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Margin</td>
                 <td><div id="history_sisa_margin"></div></td>
               </tr>
               <tr>
                 <td width="150">Sisa Saldo Catab</td>
                 <td><div id="history_sisa_catab"></div></td>
               </tr>
            </table> 
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
   </div>
</div>


<!-- BEGIN ADD  -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_add" class="form-horizontal"> 
          <input type="hidden" id="no_cif" name="no_cif">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               <span id="span_message">You have some form errors. Please check below.</span>
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Account Financing has been Created !
            </div>
            </br>
                    <div class="control-group">
                      <input type="hidden" id="cif_type_hidden" name="cif_type_hidden">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no" id="cif_no" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          <input type="hidden" id="branch_code" name="branch_code">
                          
                          <div id="dialog_rembug" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
                             <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Cari CIF</h3>
                             </div>
                             <div class="modal-body">
                                <div class="row-fluid">
                                   <div class="span12">
                                      <h4>Masukan Kata Kunci</h4>
                                      <?php
                                      if($this->session->userdata('cif_type')==0){
                                      ?>
                                        <input type="hidden" id="cif_type" name="cif_type" value="0">
                                        <p id="pcm" style="height:32px;margin-bottom:15px;">
                                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                        <option value="">Pilih Rembug</option>
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
                                      <?php
                                      }else if($this->session->userdata('cif_type')==1){
                                        echo '<input type="hidden" id="cif_type" name="cif_type" value="1">';
                                      }else{
                                      ?>
                                        <p style="margin-bottom:15px;"><select name="cif_type" id="cif_type" class="span12 m-wrap">
                                        <option value="">Pilih Tipe CIF</option>
                                        <option value="">All</option>
                                        <option value="1">Individu</option>
                                        <option value="0">Kelompok</option>
                                        </select></p>
                                        <p class="hide" id="pcm" style="height:32px;margin-bottom:15px;">
                                        <select id="cm" class="span12 m-wrap chosen" style="width:530px !important;">
                                        <option value="">Pilih Rembug</option>
                                        <?php foreach($rembugs as $rembug): ?>
                                        <option value="<?php echo $rembug['cm_code']; ?>"><?php echo $rembug['cm_name']; ?></option>
                                        <?php endforeach; ?>;
                                        </select></p>
                                      <?php
                                      }
                                      ?>
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

                        <a id="browse_rembug" class="btn blue" data-toggle="modal" href="#dialog_rembug">...</a>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tempat_lahir" id="tmp_lahir" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:30px;">Tanggal Lahir</span>
                        <input type="text" class=" m-wrap" name="tgl_lahir" id="tgl_lahir" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia" id="usia" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group" style="display:none">
                       <label class="control-label">Rembug </label>
                       <div class="controls">
                          <input type="text" name="cm_name" id="cm_name" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <hr>                 
                    <div class="control-group">
                       <label class="control-label">Jenis Pembiyaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="financing_type" id="financing_type" class="medium m-wrap" data-required="1">    
                              <option value="">-- Pilih --</option>
                              <option value="0">Kelompok</option>
                              <option value="1">Individu</option>
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="pyd" id="pyd" maxlength="3">
                        </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input name="uang_muka" type="text" class="m-wrap mask-money" id="uang_muka" style="width:120px;" value="0" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>                            
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan" id="peruntukan" class="medium m-wrap" data-required="1">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan" id="mask_date" value="<?php echo $date;?>" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <div id="plan_droping" style="display:none;">
                      <div class="control-group">
                         <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
                         <div class="controls">
                            <input type="text" name="rencana_droping" id="mask_date" value="<?php echo $tanggal_pencairan;?>" class="date-picker small m-wrap"/>
                         </div>
                      </div>  
                    </div>
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan" name="keterangan" class="m-wrap medium"></textarea>
                       </div>
                    </div>  
                    <div class="control-group">
                       <div class="controls">
                          <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
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
<!-- END ADD  -->

<!-- BEGIN EDIT  -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Pengajuan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="account_financing_reg_id" name="account_financing_reg_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit PEngajuan PEmbiayaan Berhasil!
            </div>
          </br>      

                    <div class="control-group">
                       <label class="control-label">No Customer<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="cif_no2" id="cif_no2" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/><input type="hidden" id="branch_code" name="branch_code">
                          
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama2" id="nama2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>            
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan2" id="panggilan2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung2" id="ibu_kandung2" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                        <input name="tmp_lahir2" id="tmp_lahir2" type="text" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                        &nbsp;
                        <span style="line-height:30px">Tanggal Lahir</span>
                        <input type="text" class=" m-wrap" name="tgl_lahir2" id="tgl_lahir2" readonly="" style="background-color:#eee;width:100px;"/>
                        <span class="help-inline"></span>&nbsp;
                        <input type="text" class=" m-wrap" name="usia2" id="usia2" maxlength="3" readonly="" style="background-color:#eee;width:30px;"/> Tahun
                        <span class="help-inline"></span>
                      </div>
                    </div>
                    <div class="control-group" style="display:none">
                       <label class="control-label">Rembug </label>
                       <div class="controls">
                          <input type="text" name="cm_name2" id="cm_name2" class="medium m-wrap" readonly="readonly" style="background-color:#eee;"/>
                       </div>
                    </div>  
                    <hr>            
                    <div class="control-group">
                       <label class="control-label">Jenis Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="financing_type2" id="financing_type2" class="medium m-wrap" data-required="1">    
                              <option value="">-- Pilih --</option>
                              <option value="0">Kelompok</option>
                              <option value="1">Individu</option>
                          </select>
                       </div>
                    </div> 
                     <div class="control-group">
                       <label class="control-label">Pembiayaan Ke<span class="required">*</span></label>
                       <div class="controls">
                           <input type="text" class="m-wrap" style="width:50px;" name="pyd2" id="pyd2" maxlength="3">
                        </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Uang Muka<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input name="uang_muka2" type="text" class="m-wrap mask-money" id="uang_muka2" style="width:120px;" value="0" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Jumlah Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                           <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount2" id="amount2" maxlength="12">
                             <span class="add-on">,00</span>
                           </div>
                         </div>
                    </div>                            
                    <div class="control-group">
                       <label class="control-label">Peruntukan Pembiayaan<span class="required">*</span></label>
                       <div class="controls">
                         <select name="peruntukan2" id="peruntukan2" class="medium m-wrap" data-required="1">    
                            <?php foreach ($peruntukan as $data):?>
                              <option value="<?php echo $data['code_value'];?>"><?php echo $data['display_text'];?></option>
                            <?php endforeach?>  
                          </select>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pengajuan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="tanggal_pengajuan2" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Rencana Pencairan<span class="required">*</span></label>
                       <div class="controls">
                          <input type="text" name="rencana_droping2" id="mask_date" class="date-picker small m-wrap"/>
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Keterangan<span class="required">*</span></label>
                       <div class="controls">
                          <textarea id="keterangan2" name="keterangan2" class="m-wrap medium"></textarea>
                       </div>
                    </div>  
                    <div class="control-group">
                       <div class="controls">
                          <a id="browse_history" class="btn blue" data-toggle="modal" href="#dialog_history">Lihat History Outstanding</a>
                       </div>
                    </div>             
            <div class="form-actions">
               <button type="submit" class="btn purple">Update</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT  -->

  

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
    
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
      
      
      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
           var dTreload = function()
      {
        var tbl_id = 'pengajuan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }
	  

      // fungsi untuk check all
      jQuery('#pengajuan_pembiayaan_table .group-checkable').live('change',function () {
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

      $("#pengajuan_pembiayaan_table .checkboxes").livequery(function(){
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
        $("#span_message",form1).html("You have some form errors. Please check below.");
      });

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          // ignore: "",
          rules: {
              cif_no: {
                  required: true
              },
              financing_type: {
                  required: true,
                  number: true
              },
              pyd: {
                  required: true,
                  number: true
              },
              uang_muka: {
                  required: true
              },
              amount: {
                  required: true
              },
              peruntukan: {
                  required: true
              },
              rencana_droping: {
                  required: true
              },
              tanggal_pengajuan: {
                  required: true
              },
              keterangan: {
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
                  .closest('.help-inline').removeClass('ok').html(''); // display OK icon
              $(element)
                  .closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group

          },

          unhighlight: function (element) { // revert the change dony by hightlight
              $(element)
                  .closest('.control-group').removeClass('error'); // set error class to the control group
          },

          success: function (label) {
            // if(label.closest('.input-append').length==0)
            // {
            //   label
            //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
            //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            // }
            // else
            // {
            //    label.closest('.control-group').removeClass('error').addClass('success')
            //    label.remove();
            // }
          },

          submitHandler: function (form) 
          {
            bValid = true;
			var ftype = $('#financing_type','#form_add').val();
			
			if(ftype == 0){
				$.ajax({
				  url: site_url+"rekening_nasabah/cek_aktif_pengajuan",
				  type: "POST",
				  dataType: "html",
				  async:false,
				  data: {cif_no:$("#cif_no",form1).val()},
				  success: function(response)
				  {
					if(response=='1'){
					  bValid = false;
					  error_message = "Tidak Dapat Dilanjutkan. Anggota Masih Memiliki Pengajuan Yang Belum Diproses";
					}
				  },
				  error: function(){
					bValid = false;
					error_message = "Kesalahan database, harap hubungi IT Support";
				  }
				});
	
				$.ajax({
				  url: site_url+"rekening_nasabah/cek_aktif_pembiayaan",
				  type: "POST",
				  dataType: "html",
				  async:false,
				  data: {cif_no:$("#cif_no",form1).val()},
				  success: function(response)
				  {
					if(response=='1'){
					  bValid = false;
					  error_message = "Tidak Dapat Dilanjutkan. Anggota Masih Memiliki Pembiayaan Yang Belum Lunas";
					}
				  },
				  error: function(){
					bValid = false;
					error_message = "Kesalahan database, harap hubungi IT Support";
				  }
				});
			}

            if(bValid==true){
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/add_pengajuan_pembiayaan",
                dataType: "json",
                data: form1.serialize(),
                success: function(response){
                  if(response.success==true){
                    success1.show();
                    error1.hide();
                    form1.trigger('reset');
                    form1.find('.control-group').removeClass('success');
                    $("#cancel",form_add).trigger('click')
                    alert('Successfully Saved Data');
                  }else{
                    success1.hide();
                    error1.show();
                  }
                  App.scrollTo(form1, -200);
                },
                error:function(){
                    success1.hide();
                    error1.show();
                    App.scrollTo(form1, -200);
                }
              });
            }else{

              success1.hide();
              error1.show();
              $("#span_message",form1).html(error_message);
              App.scrollTo(form1, -200);
            }

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


      // BEGIN FORM EDIT VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){        
        form2.trigger('reset');
        $("#wrapper-table").hide();
        $("#edit").show();
        var account_financing_reg_id = $(this).attr('account_financing_reg_id');
        $.ajax({
          type: "POST",
          async: false,
          dataType: "json",
          data: {account_financing_reg_id:account_financing_reg_id},
          url: site_url+"rekening_nasabah/get_pengajuan_pembiayaan_by_account_financing_reg_id",
          success: function(response)
          {
            var finan_type = response.financing_type;
            $("#form_edit input[name='account_financing_reg_id']").val(response.account_financing_reg_id);
              $.ajax({
                type: "POST",
                dataType: "json",
                async:false,
                data: {cif_no:response.cif_no},
                url: site_url+"transaction/get_ajax_value_from_cif_no",
                success: function(response)
                {
                  $("#nama2","#form_edit").val(response.nama);
                  $("#panggilan2","#form_edit").val(response.panggilan);
                  $("#ibu_kandung2","#form_edit").val(response.ibu_kandung);
                  $("#tmp_lahir2","#form_edit").val(response.tmp_lahir2);
                  var tanggal_lahir = response.tgl_lahir;
                  if(tanggal_lahir!=null){
                    var tgl_lahir = tanggal_lahir.substr(8,2);
                    var bln_lahir = tanggal_lahir.substr(5,2);
                    var thn_lahir = tanggal_lahir.substr(0,4);
                    var tgl_lahir_ = tgl_lahir+"-"+bln_lahir+"-"+thn_lahir;
                  }else{
                    tgl_lahir_ = "";
                  }
                  $("#tgl_lahir2","#form_edit").val(tgl_lahir_);
                  $("#usia2","#form_edit").val(response.usia);
                  if(response.cm_name!=null){
                    $("#cm_name2","#form_edit").closest('.control-group').show();
                    $("#cm_name2","#form_edit").val(response.cm_name);
                  }else{
                    $("#cm_name2","#form_edit").closest('.control-group').hide();
                    $("#cm_name2","#form_edit").val('');
                  }
                }                 
              });
            $("#form_edit input[name='cif_no2']").val(response.cif_no);
			$("#form_edit select[name='financing_type2']").val(response.financing_type);
            $("#form_edit input[name='pyd2']").val(response.pembiayaan_ke);
            $("#form_edit input[name='uang_muka2']").val(response.uang_muka);
            $("#form_edit input[name='amount2']").val(response.amount);
            $("#form_edit select[name='peruntukan2']").val(response.peruntukan);
            $("#form_edit textarea[name='keterangan2']").val(response.description);            
            tgl_droping = response.rencana_droping.substring(8,12)+''+response.rencana_droping.substring(5,7)+''+response.rencana_droping.substring(0,4);
            $("#form_edit input[name='rencana_droping2']").val(tgl_droping);
            
            tgl_pengajuan = response.tanggal_pengajuan.substring(8,12)+''+response.tanggal_pengajuan.substring(5,7)+''+response.tanggal_pengajuan.substring(0,4);
            $("#form_edit input[name='tanggal_pengajuan2']").val(tgl_pengajuan);
          }
        });

      });
        

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          errorPlacement: function(error,element){},
          // ignore: "",
          rules: {
              amount2: {
                  required: true
              },
              uang_muka2: {
                  required: true
              },
              peruntukan2: {
                  required: true
              },
              rencana_droping2: {
                  required: true
              },
              tanggal_pengajuan2: {
                  required: true
              },
              pyd2: {
                  required: true,
                  number: true
              },
              keterangan2: {
                  required: true
              },
              financing_type2: {
                  required: true,
                  number: true
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
            // if(label.closest('.input-append').length==0)
            // {
            //   label
            //       .addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
            //   .closest('.control-group').removeClass('error').addClass('success'); // set success class to the control group
            // }
            // else
            // {
            //    label.closest('.control-group').removeClass('error').addClass('success')
            //    label.remove();
            // }
          },

          submitHandler: function (form) {


            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/edit_pengajuan_pembiayaan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#pengajuan_pembiayaan_table_filter input").val('');
                  dTreload();
                  $("#cancel",form_edit).trigger('click')
                  alert('Successfully Updated Data');
                }else{
                  success2.hide();
                  error2.show();
                }
                App.scrollTo(form2, -200);
              },
              error:function(){
                  success2.hide();
                  form2.show();
                  App.scrollTo(error2, -200);
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

        var account_financing_reg_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          account_financing_reg_id[$i] = $(this).val();

          $i++;

        });

        if(account_financing_reg_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/delete_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
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

      // fungsi untuk BATAL PENGAJUAN
      $("a#link_batal").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var conf = confirm('Batalkan Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/batal_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Dibatalkan!");
                  dTreload();
                }else{
                  alert("Gagal Dibatalkan!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });

      // fungsi untuk TOLAK PENGAJUAN
      $("a#link_tolak").live('click',function(){

          var account_financing_reg_id = $(this).attr('account_financing_reg_id');
          var conf = confirm('Tolak Pengajuan ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"rekening_nasabah/tolak_pengajuan_pembiayaan",
              dataType: "json",
              data: {account_financing_reg_id:account_financing_reg_id},
              success: function(response){
                if(response.success==true){
                  alert("Berhasil Ditolak!");
                  dTreload();
                }else{
                  alert("Gagal Ditolak!");
                }
              },
              error: function(){
                alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
              }
            })
          }        

      });


      // begin first table
      $('#pengajuan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"rekening_nasabah/datatable_pengajuan_pembiayaan_setup",
          "aoColumns": [			      
            { "bSortable": false },
            null,
            null,
            null,
            null,
            null,
            null,
			null,
            { "bSortable": false },
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


      // fungsi untuk mencari CIF_NO
      $(function(){

       $("#select").click(function(){
         result = $("#result").val();
          var customer_no = $("#result").val();
          $("#close","#dialog_rembug").trigger('click');
          //alert(customer_no);
          $("#cif_no").val(customer_no);
          //fungsi untuk mendapatkan value untuk field-field yang diperlukan
          var cif_no = customer_no;
          $.ajax({
            type: "POST",
            dataType: "json",
            async:false,
            data: {cif_no:cif_no},
            url: site_url+"transaction/get_ajax_value_from_cif_no",
            success: function(response)
            {
              $("#branch_code","#form_add").val(response.branch_code);
              $("#no_cif","#form_add").val(response.cif_no);
              $("#nama","#form_add").val(response.nama);
              $("#panggilan","#form_add").val(response.panggilan);
              $("#ibu_kandung","#form_add").val(response.ibu_kandung);
              $("#tmp_lahir","#form_add").val(response.tmp_lahir);
              if(response.cm_name!=null){
                $("#cm_name","#form_add").closest('.control-group').show();
                $("#cm_name","#form_add").val(response.cm_name);
              }else{
                $("#cm_name","#form_add").closest('.control-group').hide();
                $("#cm_name","#form_add").val('');
              }
              var tanggal_lahir = response.tgl_lahir;
              if(tanggal_lahir!=null){
                var tgl_lahir = tanggal_lahir.substr(8,2);
                var bln_lahir = tanggal_lahir.substr(5,2);
                var thn_lahir = tanggal_lahir.substr(0,4);
                var tgl_lahir_ = tgl_lahir+"-"+bln_lahir+"-"+thn_lahir;
              }else{
                tgl_lahir_ = "";
              }
              $("#tgl_lahir","#form_add").val(tgl_lahir_);
              $("#usia","#form_add").val(response.usia);
              $("#cif_type_hidden","#form_add").val(response.cif_type);
              var cif_type = response.cif_type;
              if(cif_type==1){
                 $("#plan_droping","#form_add").hide();
              }else{
                 $("#plan_droping","#form_add").show();
              }
              $.ajax({
                url: site_url+"rekening_nasabah/get_pyd_ke",
                type: "POST",
                dataType: "html",
                data: {cif_no:response.cif_no},
                success: function(response)
                {
                  $("#pyd","#form_add").val(response);
                }
              })
            }                 
          });  
        });

        $("#result option").live('dblclick',function(){
          $("#select").trigger('click');
        });

        $("#button-dialog").click(function(){
          $("#dialog").dialog('open');
        });

        $("#cif_type","#form_add").change(function(){
          type = $("#cif_type","#form_add").val();
          cm_code = $("select#cm").val();
          if(type=="0"){
            $("p#pcm").show();
          }else{
            $("p#pcm").hide().val('');
          }

            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
        })

        $("#keyword").on('keypress',function(e){
          if(e.which==13){
            type = $("#cif_type","#form_add").val();
            cm_code = $("select#cm").val();
            if(type=="0"){
              $("p#pcm").show();
            }else{
              $("p#pcm").hide().val('');
            }
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$(this).val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              async: false,
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
            return false;
          }
        });
        
        $("select#cm").on('change',function(e){
          type = $("#cif_type","#form_add").val();
          cm_code = $(this).val();
            $.ajax({
              type: "POST",
              url: site_url+"cif/search_cif_no",
              data: {keyword:$("#keyword").val(),cif_type:type,cm_code:cm_code},
              dataType: "json",
              success: function(response){
                var option = '';
                if(type=="0"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+' - '+response[i].cm_name+'</option>';
                  }
                }else if(type=="1"){
                  for(i = 0 ; i < response.length ; i++){
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+'</option>';
                  }
                }else{
                  for(i = 0 ; i < response.length ; i++){
                    if(response[i].cm_name!=null){
                      cm_name = " - "+response[i].cm_name;   
                    }else{
                      cm_name = "";
                    }
                    option += '<option value="'+response[i].cif_no+'" nama="'+response[i].nama+'">'+response[i].nama+' - '+response[i].cif_no+''+cm_name+'</option>';
                  }
                }
                // console.log(option);
                $("#result").html(option);
              }
            });
          if(cm_code=="")
          {
            $("#result").html('');
          }
        });

        //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
        $("a#browse_history",form_add).live('click',function(){
            var cif_no = $("#no_cif").val();
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/history_outstanding_pembiayaan",
                dataType: "json",
                data: {cif_no:cif_no},
                success: function(response){
                  if(response.account_financing_no==undefined){
                    account_financing_no = "Data Terakhir Tidak Ditemukan";
                  }else{
                    account_financing_no = response.account_financing_no;
                  }

                  if(response.saldo_pokok==null){
                    saldo_pokok = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_pokok = response.saldo_pokok;
                  }

                  if(response.saldo_margin==null){
                    saldo_margin = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_margin = response.saldo_margin;
                  }

                  if(response.saldo_catab==null){
                    saldo_catab = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_catab = response.saldo_catab;
                  }
                  $("#history_no_pembiayaan").html(": "+account_financing_no);
                  $("#history_sisa_pokok").html(": Rp. "+number_format(saldo_pokok,0,',','.'));
                  $("#history_sisa_margin").html(": Rp. "+number_format(saldo_margin,0,',','.'));
                  $("#history_sisa_catab").html(": Rp. "+number_format(saldo_catab,0,',','.'));
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });
          
          //FUNGSI UNTUK MELIHAT HISTORI OUTSTANDING PEMBIAYAAN
          $("a#browse_history",form_edit).live('click',function(){
            var cif_no = $("#cif_no2").val();
              $.ajax({
                type: "POST",
                url: site_url+"rekening_nasabah/history_outstanding_pembiayaan",
                dataType: "json",
                data: {cif_no:cif_no},
                success: function(response){
                  if(response.account_financing_no==undefined){
                    account_financing_no = "Data Terakhir Tidak Ditemukan";
                  }else{
                    account_financing_no = response.account_financing_no;
                  }

                  if(response.saldo_pokok==null){
                    saldo_pokok = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_pokok = response.saldo_pokok;
                  }

                  if(response.saldo_margin==null){
                    saldo_margin = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_margin = response.saldo_margin;
                  }

                  if(response.saldo_catab==null){
                    saldo_catab = "Data Terakhir Tidak Ditemukan";
                  }else{
                    saldo_catab = response.saldo_catab;
                  }
                  $("#history_no_pembiayaan").html(": "+account_financing_no);
                  $("#history_sisa_pokok").html(": Rp. "+number_format(saldo_pokok,0,',','.'));
                  $("#history_sisa_margin").html(": Rp. "+number_format(saldo_margin,0,',','.'));
                  $("#history_sisa_catab").html(": Rp. "+number_format(saldo_catab,0,',','.'));
                },
                error: function(){
                  alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
                }
              })
          });

          $("input[name='tanggal_pengajuan']","#form_add").change(function(){
            var tgl_pengajuan = $(this).val();
            explode = tgl_pengajuan.split('/');
            var tanggal_pengajuan =  explode[2]+'-'+explode[1]+'-'+explode[0];
            // alert(tanggal_pengajuan);
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tanggal_pengajuan:tanggal_pengajuan},
              url: site_url+"transaction/get_plan_pencairan",
              success: function(response){
                $("input[name='rencana_droping']","#form_add").val(response.realisasi_pengajuan);
                // alert(response.realisasi_pengajuan);
              }
            });
          });

          $("input[name='tanggal_pengajuan2']","#form_edit").change(function(){
            var tgl_pengajuan = $(this).val();
            explode = tgl_pengajuan.split('/');
            var tanggal_pengajuan =  explode[2]+'-'+explode[1]+'-'+explode[0];
            // alert(tanggal_pengajuan);
            $.ajax({
              type: "POST",
              dataType: "json",
              data: {tanggal_pengajuan:tanggal_pengajuan},
              url: site_url+"transaction/get_plan_pencairan",
              success: function(response){
                $("input[name='rencana_droping2']","#form_edit").val(response.realisasi_pengajuan);
                // alert(response.realisasi_pengajuan);
              }
            });
          });

      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

