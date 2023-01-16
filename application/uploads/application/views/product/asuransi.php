<?php 
  $CI = get_instance();
?>
<style type="text/css">
.table th, .table td {
    border-top: 1px solid #fff;
    border-bottom: 1px solid #ddd;
    line-height: 12px;
    padding: 5px;
    text-align: left;
    vertical-align: top;
    font: 12px Tahoma;
}
</style>
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
      Product Setup <small>Asuransi</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Asuransi Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->



<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Asuransi</div>
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
      <table class="table table-striped table-bordered table-hover" id="produk_tabungan">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#produk_tabungan .checkboxes" /></th>
               <th width="25%">Kode Produk</th>
               <th width="40%">Nama Produk</th>
               <th width="40%">Nick Name</th>
               <th>Detail</th>
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
         <div class="caption"><i class="icon-reorder"></i>Tambah Asuransi</div>
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
               Produk Asuransi Berhasil Ditambahkan !
            </div>
            <br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" maxlength="5" name="product_code" id="product_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
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
                  <input type="text" name="nick_name" maxlength="10" id="nick_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe Asuransi<span class="required">*</span></label>
               <div class="controls">
                <select name="insurance_type" id="insurance_type" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Term/PA</option>
                  <option value="1">Kesehatan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe Rate<span class="required">*</span></label>
               <div class="controls">
                <select name="rate_type" id="rate_type" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Tunggal</option>
                  <option value="1">Tabel</option>
                  <option value="2">Plan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rate Tunggal<span class="required">*</span></label>               
                 <div class="controls">
                       <input type="text" name="rate_tunggal" value="0" maxlength="11" id="rate_tunggal" data-required="1" class="medium m-wrap"/>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rate Kode<span class="required">*</span></label>
               <div class="controls">
                <select name="rate_code" id="rate_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                 <!--  <?php foreach($rate_kode as $data):?>
                    <option value="<?php echo $data['rate_code'];?>"><?php echo $data['rate_code'];?></option>
                  <?php endforeach?> -->
                </select></div>
            </div>
            <div class="control-group">
               <label class="control-label">Plan Kode<span class="required">*</span></label>
               <div class="controls">
                <select name="plan_code" id="plan_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                 <!--  <?php foreach($plan_kode as $data):?>
                    <option value="<?php echo $data['plan_code'];?>"><?php echo $data['plan_description'];?></option>
                  <?php endforeach?> -->
                </select></div>
            </div>
            <div class="control-group">
               <label class="control-label">Premium Periode<span class="required">*</span></label>
               <div class="controls">
                <select name="premium_periode" id="premium_periode" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Tahunan</option>
                  <option value="1">Bulanan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pembulatan Usia<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" maxlength="3" name="pembulatan_usia" id="pembulatan_usia" data-required="1" class="small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode GL Asuransi<span class="required">*</span></label>
               <div class="controls">
                <select name="product_insurance_gl_code" id="product_insurance_gl_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <?php foreach($kode as $data):?>
                    <option value="<?php echo $data['product_insurance_gl_code'];?>"><?php echo $data['description'];?></option>
                  <?php endforeach?>
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


<!-- DIALOG DETAIL -->
<div id="dialog_detail" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-250px;">
 <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Detail Asuransi</h3>
 </div>
 <div class="modal-body">
    <div class="row-fluid">
       <div class="span12">
          <label id="gl_detail"></label> 
       </div>
    </div>
 </div>
 <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
 </div>
</div>  
<!-- END DIALOG DETAIL -->


<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit Asuransi</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="product_insurance_id" name="product_insurance_id">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk Asuransi Berhasil Di Edit !
            </div>
          </br>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" maxlength="5" name="product_code" id="product_code" data-required="1" class="medium m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" />
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
                  <input type="text" name="nick_name" maxlength="10" id="nick_name" data-required="1" class="medium m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe Asuransi<span class="required">*</span></label>
               <div class="controls">
                <select name="insurance_type" id="insurance_type" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Term/PA</option>
                  <option value="1">Kesehatan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Tipe Rate<span class="required">*</span></label>
               <div class="controls">
                <select name="rate_type" id="rate_type" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Tunggal</option>
                  <option value="1">Tabel</option>
                  <option value="2">Plan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rate Tunggal<span class="required">*</span></label>               
                 <div class="controls">
                       <input type="text" name="rate_tunggal" value="0" maxlength="11" id="rate_tunggal" data-required="1" class="medium m-wrap"/>
                 </div>
            </div>
            <div class="control-group">
               <label class="control-label">Rate Kode<span class="required">*</span></label>
               <div class="controls">
                <select name="rate_code" id="rate_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                 <!--  <?php foreach($rate_kode as $data):?>
                    <option value="<?php echo $data['rate_code'];?>"><?php echo $data['rate_code'];?></option>
                  <?php endforeach?> -->
                </select></div>
            </div>
            <div class="control-group">
               <label class="control-label">Plan Kode<span class="required">*</span></label>
               <div class="controls">
                <select name="plan_code" id="plan_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                 <!--  <?php foreach($plan_kode as $data):?>
                    <option value="<?php echo $data['plan_code'];?>"><?php echo $data['plan_description'];?></option>
                  <?php endforeach?> -->
                </select></div>
            </div>
            <div class="control-group">
               <label class="control-label">Premium Periode<span class="required">*</span></label>
               <div class="controls">
                <select name="premium_periode" id="premium_periode" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <option value="0">Tahunan</option>
                  <option value="1">Bulanan</option>
                </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Pembulatan Usia<span class="required">*</span></label>
               <div class="controls">
                  <input type="text" maxlength="3" name="pembulatan_usia" id="pembulatan_usia" data-required="1" class="small m-wrap"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Kode GL Asuransi<span class="required">*</span></label>
               <div class="controls">
                <select name="product_insurance_gl_code" id="product_insurance_gl_code" data-required="1" class="medium m-wrap">
                  <option value="">PILIH</option>
                  <?php foreach($kode as $data):?>
                    <option value="<?php echo $data['product_insurance_gl_code'];?>"><?php echo $data['description'];?></option>
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


      form1.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          // ignore: "",
          rules: {
              product_code: {
                  required: true,
        				  minlength: 1,
        				  maxlength: 5
              },
              product_name: {
                  required: true,
                  maxlength: 50
              },
              nick_name: {
                  required: true,
                  maxlength: 10
              },
              insurance_type: {
                  required: true
              },
              rate_type: {
                  required: true
              },
              premium_periode: {
                  required: true
              },
              pembulatan_usia: {
                  required: true
              },
              product_insurance_gl_code: {
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
              url: site_url+"product/add_produk_asuransi",
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
                  App.scrollTo(form1, -200);
                }
              },
              error:function(){
                  success1.hide();
                  error1.show();
                  App.scrollTo(form1, -200);
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


      // event button DETAIL ketika di tekan
      $("a#link-detail").live('click',function(){
        var product_insurance_id = $(this).attr('product_insurance_id');
        
        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_insurance_id:product_insurance_id},
          url: site_url+"product/get_product_insurance_id",
          success: function(response)
          {
            var a = response.product_insurance_id;   
            if(response.rate_code==null)
            {
              rate_code = '-';
            }
            else
            {
              rate_code = response.rate_code;
            }

            if(response.product_insurance_gl_code==null)
            {
              product_insurance_gl_code = '-';
            }
            else
            {
              product_insurance_gl_code = response.product_insurance_gl_code;
            }

            if(response.insurance_type==0)
            {
              insurance_type = 'Term/PA';
            }
            else
            {
              insurance_type = 'Kesehatan';
            }

            if(response.rate_type==0)
            {
              rate_type = 'Tunggal';
            }
            else if(response.rate_type==1)
            {
              rate_type = 'Tabel';
            }
            else
            {
              rate_type = 'Plan';
            }

            if(response.premium_periode==0)
            {
              premium_periode = 'Tahunan';
            }
            else
            {
              premium_periode = 'Bulanan';
            }
            var html = ' \
                        <table class="table"> \
                        <tr>  \
                          <td width="40%">Kode Produk</td> \
                          <td>:</td> \
                          <td>'+response.product_code+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Nama Produk</td> \
                          <td>:</td> \
                          <td>'+response.product_name+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Nick Name</td> \
                          <td>:</td> \
                          <td>'+response.nick_name+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Tipe Asuransi</td> \
                          <td>:</td> \
                          <td>'+insurance_type+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Tipe Rate</td> \
                          <td>:</td> \
                          <td>'+rate_type+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Rate Tunggal</td> \
                          <td>:</td> \
                          <td>'+number_format(response.rate_tunggal,0,',','.')+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Kode Rate</td> \
                          <td>:</td> \
                          <td>'+rate_code+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Premium Periode</td> \
                          <td>:</td> \
                          <td>'+premium_periode+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Pembulatan Usia</td> \
                          <td>:</td> \
                          <td>'+response.pembulatan_usia+'</td> \
                        </tr> \
                        <tr>  \
                          <td width="40%">Kode GL Asuransi</td> \
                          <td>:</td> \
                          <td>'+product_insurance_gl_code+'</td> \
                        </tr> \
                        </table> ';
            $("#gl_detail").html(html);     
          }
        });

      });


       // event button Edit ketika di tekan
      $("a#link-edit").live('click',function(){
        $("#wrapper-table").hide();
        $("#edit").show();
        var product_insurance_id = $(this).attr('product_insurance_id');

        $.ajax({
          type: "POST",
          dataType: "json",
          data: {product_insurance_id:product_insurance_id},
          url: site_url+"product/get_product_insurance_id",
          success: function(response)
          {
            $("#product_insurance_id, #form_edit").val(response.product_insurance_id); 
            $("#product_code, #form_edit").val(response.product_code); 
            $("#product_name, #form_edit").val(response.product_name); 
            $("#nick_name, #form_edit").val(response.nick_name); 
            $("#insurance_type, #form_edit").val(response.insurance_type); 
            $("#rate_type, #form_edit").val(response.rate_type); 
            if (response.rate_type==0) {
                $("#rate_tunggal","#form_edit").attr('disabled',false);
                $("#plan_code","#form_edit").attr('disabled',true);
                $("#rate_code","#form_edit").attr('disabled',true);
            }else if (response.rate_type==1) {
                $("#rate_tunggal","#form_edit").attr('disabled',true);
                $("#plan_code","#form_edit").attr('disabled',true);
                $("#rate_code","#form_edit").attr('disabled',false);
            }else{
                $("#rate_tunggal","#form_edit").attr('disabled',true);
                $("#plan_code","#form_edit").attr('disabled',false);
                $("#rate_code","#form_edit").attr('disabled',true);
            }
            $("#rate_tunggal, #form_edit").val(response.rate_tunggal); 

             $.ajax({
               type: "POST",
               url: site_url+"product/get_rate_type",
               dataType: "json",
               async: false,
               // data: {rate_type:rate_type},
               success: function(response){
                  html = '<option value="">PILIH</option>';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].rate_code+'">'+response[i].rate_code+'</option>';
                  }
                  $("#rate_code","#form_edit").html(html);
               }
              });  

            var rate = response.rate_code;
            $("#form_edit select[name='rate_code']").val(rate); 

             $.ajax({
               type: "POST",
               url: site_url+"product/get_plan_type",
               dataType: "json",
               async: false,
               // data: {rate_type:rate_type},
               success: function(response){
                  html = '<option value="">PILIH</option>';
                  for ( i = 0 ; i < response.length ; i++ )
                  {
                     html += '<option value="'+response[i].plan_code+'">'+response[i].plan_description+'</option>';
                  }
                  $("#plan_code","#form_edit").html(html);
               }
              });   

            var plan = response.plan_code;
            $("#form_edit select[name='plan_code']").val(plan); 
            $("#premium_periode, #form_edit").val(response.premium_periode); 
            $("#pembulatan_usia, #form_edit").val(response.pembulatan_usia); 
            $("#form_edit select[name='product_insurance_gl_code']").val(response.product_insurance_gl_code); 
          }
        });

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
              product_code: {
                  required: true,
                  minlength: 1,
                  maxlength: 5
              },
              product_name: {
                  required: true,
                  maxlength: 50
              },
              nick_name: {
                  required: true,
                  maxlength: 10
              },
              insurance_type: {
                  required: true
              },
              rate_type: {
                  required: true
              },
              premium_periode: {
                  required: true
              },
              pembulatan_usia: {
                  required: true
              },
              product_insurance_gl_code: {
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
              url: site_url+"product/edit_produk_asuransi",
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
                App.scrollTo(form2, -200);
              },
              error:function(){
                  success2.hide();
                  error2.show();
                  App.scrollTo(form2, -200);
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

    $("#rate_type","#form_add").change(function(){
      var rate_type =  $("#rate_type","#form_add").val();
      if(rate_type==0)
      {
        $("#rate_tunggal","#form_add").attr('disabled',false);
        $("#plan_code","#form_add").attr('disabled',true);
        $("#rate_code","#form_add").attr('disabled',true);
      }
      else if(rate_type==1)
      {
        $("#rate_tunggal","#form_add").attr('disabled',true);
        $("#plan_code","#form_add").attr('disabled',true);
        $("#rate_code","#form_add").attr('disabled',false);
         $.ajax({
         type: "POST",
         url: site_url+"product/get_rate_type",
         dataType: "json",
         // data: {rate_type:rate_type},
         success: function(response){
            html = '<option value="">PILIH</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].rate_code+'">'+response[i].rate_code+'</option>';
            }
            $("#rate_code","#form_add").html(html);
         }
        });   
      }
      else
      {
        $("#rate_tunggal","#form_add").attr('disabled',true);
        $("#plan_code","#form_add").attr('disabled',false);
        $("#rate_code","#form_add").attr('disabled',true);
         $.ajax({
         type: "POST",
         url: site_url+"product/get_plan_type",
         dataType: "json",
         // data: {rate_type:rate_type},
         success: function(response){
            html = '<option value="">PILIH</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].plan_code+'">'+response[i].plan_description+'</option>';
            }
            $("#plan_code","#form_add").html(html);
         }
        });   

      }
    });   



    $("#rate_type","#form_edit").change(function(){
      var rate_type =  $("#rate_type","#form_edit").val();
      if(rate_type==0)
      {
        $("#rate_tunggal","#form_edit").attr('disabled',false);
        $("#plan_code","#form_edit").attr('disabled',true);
        $("#rate_code","#form_edit").attr('disabled',true);
      }
      else if(rate_type==1)
      {
        $("#rate_tunggal","#form_edit").attr('disabled',true);
        // $("#rate_tunggal","#form_edit").val(0);
        $("#plan_code","#form_edit").attr('disabled',true);
        $("#rate_code","#form_edit").attr('disabled',false);
         $.ajax({
         type: "POST",
         url: site_url+"product/get_rate_type",
         dataType: "json",
         // data: {rate_type:rate_type},
         success: function(response){
            html = '<option value="">PILIH</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].rate_code+'">'+response[i].rate_code+'</option>';
            }
            $("#rate_code","#form_edit").html(html);
         }
        });   
      }
      else
      {
        $("#rate_tunggal","#form_edit").attr('disabled',true);
        $("#plan_code","#form_edit").attr('disabled',false);
        $("#rate_code","#form_edit").attr('disabled',true);
         $.ajax({
         type: "POST",
         url: site_url+"product/get_plan_type",
         dataType: "json",
         // data: {rate_type:rate_type},
         success: function(response){
            html = '<option value="">PILIH</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].plan_code+'">'+response[i].plan_description+'</option>';
            }
            $("#plan_code","#form_edit").html(html);
         }
        });   

      }
    }); 

      // fungsi untuk delete records
      $("#btn_delete").click(function(){

        var product_insurance_id = [];
        var $i = 0;
        $("input#checkbox:checked").each(function(){

          product_insurance_id[$i] = $(this).val();

          $i++;

        });

        if(product_insurance_id.length==0){
          alert("Please select some row to delete !");
        }else{
          var conf = confirm('Are you sure to delete this rows ?');
          if(conf){
            $.ajax({
              type: "POST",
              url: site_url+"product/delete_produk_asuransi",
              dataType: "json",
              data: {product_insurance_id:product_insurance_id},
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
          "sAjaxSource": site_url+"product/datatable_produk_asuransi",
          "aoColumns": [
            { "bSortable": false, "bSearchable": false }
            ,null
            ,null
            ,{ "bSortable": false, "bSearchable": false }
            ,{ "bSortable": false, "bSearchable": false }
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

