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
      Product Setup <small>GL Kelompok</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Product</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">GL Kelompok Setup</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EDIT USER -->
<div id="edit">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Edit GL Kelompok</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
          <input type="hidden" id="product_cm_gl_id" name="product_cm_gl_id" value="<?php echo $cm_gl['product_cm_gl_id']; ?>">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Produk Tabungan Berhasil Di Edit !
            </div>
            <div class="control-group">
               <label class="control-label">Kode Produk<span class="required">*</span></label>
               <div class="controls">
                  <input name="product_cm_gl_code" type="text" class="medium m-wrap" id="product_cm_gl_code"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" value="<?php echo $cm_gl['product_cm_gl_code']; ?>" maxlength="5" data-required="1" />
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">Description<span class="required">*</span></label>
               <div class="controls">
                  <input name="description" type="text" class="medium m-wrap" id="description" value="<?php echo $cm_gl['description']; ?>" data-required="1"/>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab Wajib</label>
               <div class="controls">
                  <select name="gl_saldo_tab_wajib" id="gl_saldo_tab_wajib" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab Kelompok</label>
               <div class="controls">
                  <select name="gl_saldo_tab_kelompok" id="gl_saldo_tab_kelompok" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab Sukarela</label>
               <div class="controls">
                  <select name="gl_saldo_tab_sukarela" id="gl_saldo_tab_sukarela" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab Minggon</label>
               <div class="controls">
                  <select name="gl_saldo_tab_minggon" id="gl_saldo_tab_minggon" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab LWK</label>
               <div class="controls">
                  <select name="gl_saldo_tab_lwk" id="gl_saldo_tab_lwk" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label">GL Tab SMK</label>
               <div class="controls">
                  <select name="gl_saldo_tab_smk" id="gl_saldo_tab_smk" class="chosen large m-wrap" data-required="1">
                     <option value="">PILIH</option>
                     <?php
                     foreach ($gl_account as $data): 
                     ?>
                     <option value="<?php echo $data['account_code'];?>"><?php echo $data['account_code'];?> - <?php echo $data['account_name'];?></option>
                   <?php endforeach; ?>
                  </select>
               </div>
            </div>
            <div class="form-actions">
               <button type="submit" class="btn purple">Save</button>
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
	
	$('#gl_saldo_tab_wajib').val('<?php echo $cm_gl['gl_tab_wajib']; ?>').trigger('change').trigger('liszt:updated');
	$('#gl_saldo_tab_kelompok').val('<?php echo $cm_gl['gl_tab_kelompok']; ?>').trigger('change').trigger('liszt:updated');
	$('#gl_saldo_tab_sukarela').val('<?php echo $cm_gl['gl_tab_sukarela']; ?>').trigger('change').trigger('liszt:updated');
	$('#gl_saldo_tab_minggon').val('<?php echo $cm_gl['gl_tab_minggon']; ?>').trigger('change').trigger('liszt:updated');
	$('#gl_saldo_tab_lwk').val('<?php echo $cm_gl['gl_tab_lwk']; ?>').trigger('change').trigger('liszt:updated');
	$('#gl_saldo_tab_smk').val('<?php echo $cm_gl['gl_tab_smk']; ?>').trigger('change').trigger('liszt:updated');

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
              product_financing_gl_code: {
                  required: true,
                  minlength: 4,
                  maxlength: 5
              },
              description: {
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
              url: site_url+"product/edit_produk_gl_kelompok",
              dataType: "json",
              data: form2.serialize(),
              success: function(response){
                if(response.success==true){
                  success2.show();
                  error2.hide();
                  form2.children('div').removeClass('success');
                  $("#produk_tabungan_filter input").val('');
                  alert('Successfully Updated Data');
				  window.location.href = '<?php echo base_url('product/gl_kelompok'); ?>';
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

      jQuery('#kantor_cabang_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#kantor_cabang_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

});
</script>
<!-- END JAVASCRIPTS -->

