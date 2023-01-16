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
      Product Setup <small>Produk Tabungan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Tabungan Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Produk Tabungan</div>
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
      <table class="table table-striped table-bordered table-hover" id="produk_tabungan">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#produk_tabungan .checkboxes" /></th>
               <th width="13%">Kode Produk</th>
               <th width="20%">Nama Produk</th>
               <th width="17%">Saldo Minimal</th>
               <th width="17%">Jenis Tabungan</th>
               <th width="17%">Product Type</th>
               <th width="17%">GL Code</th>
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
         <div class="caption"><i class="icon-reorder"></i>Tambah Produk Tabungan</div>
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
               Produk Tabungan Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_code" id="product_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_name" id="product_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nick Name<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nick_name" id="nick_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Akad<span class="required">*</span></label>
               <div class="controls">
                  <select name="akad" id="akad" class="medium m-wrap">
                    <option value="">Pilih</option>
                    <?php foreach($akad as $data):?>
                    <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Minimal<span class="required">*</span></label>               
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="saldo_minimal" id="saldo_minimal" data-required="1" class="medium m-wrap  mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Administrasi<span class="required">*</span></label>             
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="biaya_administrasi" id="biaya_administrasi" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal Biaya Administrasi<span class="required">*</span></label>        
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="nominal_biaya_administrasi" id="nominal_biaya_administrasi" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pajak<span class="required">*</span></label>
               <div class="controls">
                  <select name="pajak" id="pajak" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="1">Ya</option>
                     <option value="0">Tidak</option>
                     <!-- <option value="0">Nol</option> -->
                     <!-- <option value="1">Satu</option> -->
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Persen Pajak<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="persen_pajak" id="persen_pajak" data-required="1" class="small m-wrap"/> %
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jenis Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_tabungan" id="jenis_tabungan" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Reguler</option>
                     <option value="1">Berencana</option>
                  </select>
               </div>
            </div>
            <div id="rencana">
                <div class="control-group">
                   <label class="control-label">Rencana Minimal Setoran<span class="required">*</span></label>    
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="rencana_minimal_setoran" id="rencana_minimal_setoran" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Rencana Periode Setoran<span class="required">*</span></label>
                   <div class="controls">                        
                    <select name="rencana_periode_setoran" id="rencana_periode_setoran" class="medium m-wrap" data-required="1">
                       <option value="">PILIH</option>
                       <option value="0">Hairan</option>
                       <option value="1">Mingguan</option>
                       <option value="2">Bulanan</option>
                    </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Rencana Minimal Kontrak<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="rencana_minimal_kontrak" id="rencana_minimal_kontrak" data-required="1" class="small m-wrap"/> Tahun
                   </div>
                </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk Type<span class="required">*</span></label>
               <div class="controls">
                  <select name="product_type" id="product_type" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Kelompok</option>
                     <option value="1">Individual</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Code<span class="required">*</span></label>
               <div class="controls">
                  <select name="product_saving_gl_code" id="product_saving_gl_code" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_code as $data): 
                     ?>
                     <option value="<?php echo $data['product_saving_gl_code'];?>"><?php echo $data['description'];?></option>
                   <?php endforeach; ?>
                  </select>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Produk Tabungan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="product_saving_id" name="product_saving_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk Tabungan Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_code2" id="product_code2" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" readonly="" style="background-color:#eee;" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nama Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="product_name2" id="product_name2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nick Name<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="nick_name2" id="nick_name2" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Akad<span class="required">*</span></label>
               <div class="controls">
                  <select name="akad2" id="akad2" class="medium m-wrap">
                    <option value="">Pilih</option>
                    <?php foreach($akad as $data):?>
                    <option value="<?php echo $data['akad_code'];?>"><?php echo $data['akad_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Saldo Minimal<span class="required">*</span></label>               
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="saldo_minimal2" id="saldo_minimal2" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Biaya Administrasi<span class="required">*</span></label>             
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="biaya_administrasi2" id="biaya_administrasi2" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Nominal Biaya Administrasi<span class="required">*</span></label>        
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="nominal_biaya_administrasi2" id="nominal_biaya_administrasi2" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pajak<span class="required">*</span></label>
               <div class="controls">
                  <select name="pajak2" id="pajak2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="1">Ya</option>
                     <option value="0">Tidak</option>
                     <!-- <option value="0">Nol</option> -->
                     <!-- <option value="1">Satu</option> -->
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Persen Pajak<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" name="persen_pajak2" id="persen_pajak2" data-required="1" class="small m-wrap"/> %
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Jenis Tabungan<span class="required">*</span></label>
               <div class="controls">
                  <select name="jenis_tabungan2" id="jenis_tabungan2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Reguler</option>
                     <option value="1">Berencana</option>
                  </select>
               </div>
            </div>
            <div id="rencana2">
                <div class="control-group">
                   <label class="control-label">Rencana Minimal Setoran<span class="required">*</span></label>    
                 <div class="controls">
                    <div class="input-prepend input-append">
                       <span class="add-on">Rp</span>
                       <input type="text" name="rencana_minimal_setoran2" id="rencana_minimal_setoran2" data-required="1" class="medium m-wrap mask-money"/>
                       <span class="add-on">,00</span>
                     </div>
                 </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Rencana Periode Setoran<span class="required">*</span></label>
                   <div class="controls">                        
                    <select name="rencana_periode_setoran2" id="rencana_periode_setoran2" class="medium m-wrap" data-required="1">
                       <option value="">PILIH</option>
                       <option value="0">Hairan</option>
                       <option value="1">Mingguan</option>
                       <option value="2">Bulanan</option>
                    </select>
                   </div>
                </div>
                <div class="control-group">
                   <label class="control-label">Rencana Minimal Kontrak<span class="required">*</span></label>
                   <div class="controls">
                      <input type="text" name="rencana_minimal_kontrak2" id="rencana_minimal_kontrak2" data-required="1" class="small m-wrap"/> Tahun
                   </div>
                </div>
            </div>
            <div class="control-group">
               <label class="control-label">Produk Type<span class="required">*</span></label>
               <div class="controls">
                  <select name="product_type2" id="product_type2" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <option value="0">Kelompok</option>
                     <option value="1">Individual</option>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Code<span class="required">*</span></label>
               <div class="controls">
                  <select name="product_saving_gl_code" id="product_saving_gl_code" class="medium m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_code as $data): 
                     ?>
                     <option value="<?php echo $data['product_saving_gl_code'];?>"><?php echo $data['description'];?></option>
                   <?php endforeach; ?>
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
        var tbl_id = 'produk_tabungan';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // fungsi untuk check all
      jQuery('#produk_tabungan .group-checkable').live('change',function () {
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

      $("#produk_tabungan .checkboxes").livequery(function(){
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
        $("#rencana").hide();
      });

      $("#jenis_tabungan").change(function()
      {
        var jenis = $("#jenis_tabungan").val();
          if (jenis=='1') 
          {
            $("#rencana").show()
          }
          else
          {            
            $("#rencana").hide();
          }
      });

      $("#pajak","#form_add").change(function(){
        var pajak = $(this).val();
        if(pajak==0){
          $("#persen_pajak","#form_add").attr('readonly',true);
          $("#persen_pajak","#form_add").addClass('readonlyClass');
          $("#persen_pajak","#form_add").val('0');
        }else{
          $("#persen_pajak","#form_add").attr('readonly',false);
          $("#persen_pajak","#form_add").removeClass('readonlyClass');
        }
      })

      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              product_code: {
                  required: true,
        				  minlength: 4,
        				  maxlength: 4
              },
              product_name: {
                  required: true
              },
              nick_name: {
                  required: true
              },
              akad: {
                  required: true
              },
              saldo_minimal: {
                  required: true
              },
              biaya_administrasi: {
                  required: true
              },
              nominal_biaya_administrasi: {
                  required: true
              },
              pajak: {
                  required: true
              },
              persen_pajak: {
                  required: true
              },
              jenis_tabungan: {
                  required: true
              },
              product_type: {
                  required: true
              },
              product_saving_gl_code: {
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
              url: site_url+"product/add_produk_tabungan",
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
        var product_saving_id = $(this).attr('product_saving_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_saving_id:product_saving_id},
          url: site_url+"product/get_tabungan_by_product_id",
          success: function(response)
          {
            $("#product_saving_id").val(response.product_saving_id);
            $("#product_code2").val(response.product_code);
            $("#product_name2").val(response.product_name);
            $("#nick_name2").val(response.nick_name);
            $("#akad2").val(response.akad);
            $("#saldo_minimal2").val(response.saldo_minimal);
            $("#biaya_administrasi2").val(response.biaya_administrasi);
            $("#nominal_biaya_administrasi2").val(response.nominal_biaya_administrasi);
            $("#pajak2").val(response.pajak);
            $("#persen_pajak2").val(response.persen_pajak);
            $("#jenis_tabungan2").val(response.jenis_tabungan);
            $("#rencana_minimal_setoran2").val(response.rencana_minimal_setoran);
            $("#rencana_periode_setoran2").val(response.rencana_periode_setoran);
            $("#rencana_minimal_kontrak2").val(response.rencana_minimal_kontrak);
            $("#product_type2").val(response.product_type);
            $("#product_saving_gl_code, #form_edit").val(response.product_saving_gl_code);
          
              //fungsi untuk menampilkan input RENCANA bila jenis tabungan == "1" pada form EDIT
              if(response.jenis_tabungan=='1'){
                $("#rencana2").show();
              }else{
                $("#rencana2").hide();
              }         

              if(response.pajak==0){
                $("#persen_pajak2","#form_edit").attr('readonly',true);
                $("#persen_pajak2","#form_edit").addClass('readonlyClass');
              }else{
                $("#persen_pajak2","#form_edit").attr('readonly',false);
                $("#persen_pajak2","#form_edit").removeClass('readonlyClass');
              }  
          }
        })

      });


      $("#jenis_tabungan2").change(function()
      {
        var jenis = $("#jenis_tabungan2").val();
          if (jenis=='1') 
          {
            $("#rencana2").show()
          }
          else
          {            
            $("#rencana2").hide();
          }
      });

      $("#pajak2","#form_edit").change(function(){
        var pajak = $(this).val();
        if(pajak==0){
          $("#persen_pajak2","#form_edit").attr('readonly',true);
          $("#persen_pajak2","#form_edit").addClass('readonlyClass');
          $("#persen_pajak2","#form_edit").val('0');
        }else{
          $("#persen_pajak2","#form_edit").attr('readonly',false);
          $("#persen_pajak2","#form_edit").removeClass('readonlyClass');
        }
      })

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
              product_code2: {
                  required: true,
                  minlength: 4,
                  maxlength: 4
              },
              product_name2: {
                  required: true
              },
              nick_name2: {
                  required: true
              },
              akad2: {
                  required: true
              },
              saldo_minimal2: {
                  required: true
              },
              biaya_administrasi2: {
                  required: true
              },
              nominal_biaya_administrasi2: {
                  required: true
              },
              pajak2: {
                  required: true
              },
              persen_pajak2: {
                  required: true
              },
              jenis_tabungan2: {
                  required: true
              },
              product_type2: {
                  required: true
              },
              product_saving_gl_code: {
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

            // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
            $.ajax({
              type: "POST",
              url: site_url+"product/edit_produk_tabungan",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#produk_tabungan_filter input").val('');
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

        var product_saving_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          product_saving_id[$i] = $(this).val();

          $i++;

        });

        if(product_saving_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"product/delete_produk_tabungan",
              dataType: "json",
              data: {product_saving_id:product_saving_id},
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
      $('#produk_tabungan').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"product/datatable_produk_tabungan",
          "aoColumns": [
            {"bSearchable": false}
            ,null
            ,null
            ,null
            ,null
            ,null
            ,null
            ,{ "bSortable": false, "bSearchable": false }
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

      


      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

