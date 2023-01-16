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
      Transaction <small>Rekening Antar Kantor</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Transaction</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">RAK</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Rekening Antar Kantor</div>
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
      <table class="table table-striped table-bordered table-hover" id="rak_table">
         <thead>
            <tr>
               <th style="width:8px;"><input type="checkbox" class="group-checkable" data-set="#rak_table .checkboxes" /></th>
               <th>Jenis Transaksi</th>
               <th>Tanggal</th>
               <th>Cabang Dari</th>
               <th>Cabang Terima</th>
               <th>Jumlah</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Petugas</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword_fa" id="keyword_fa" placeholder="Search..." class="span12 m-wrap"></p>
            <p><select name="result_fa" id="result_fa" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close_fa" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select_fa" class="btn blue">Select</button>
   </div>
</div>
<div id="dialog_fa_edit" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Petugas</h3>
   </div>
   <div class="modal-body">
      <div class="row-fluid">
         <div class="span12">
            <h4>Masukan Kata Kunci</h4>
            <p><input type="text" name="keyword_fa_edit" id="keyword_fa_edit" placeholder="Search..." class="span12 m-wrap"></p>
            <p><select name="result_fa_edit" id="result_fa_edit" size="7" class="span12 m-wrap"></select></p>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" id="close_fa_edit" data-dismiss="modal" class="btn">Close</button>
      <button type="button" id="select_fa_edit" class="btn blue">Select</button>
   </div>
</div>

<!-- BEGIN ADD  -->
<div id="add" class="hide">
   
   <div class="portlet box green">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Rekening Antar Kantor</div>
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
               New Account Financing has been Created !
            </div>
            </br>
            <div class="control-group">
               <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <select name="trx_rak_type" class="chosen" id="trx_rak_type" style="width:220px;">
                    <option value="" selected="selected">-- Pilih --</option>
                    <option value="1">Droping Dana dari Pusat</option>
                    <option value="2">Setor Dana dari Cabang</option>
                    <option value="3">Biaya Antar Kantor</option>
                  </select>
               </div>
            </div>           
            <div class="control-group">
               <label class="control-label">Tanggal</label>
               <div class="controls">
                  <input type="text" name="voucher_date" id="mask_date" class="date-picker medium m-wrap"/>
               </div>
            </div>                  
            <div class="control-group">
               <label class="control-label">Bank Transfer</label>
               <div class="controls">
                  <select name="bank_kirim" class="chosen" id="bank_kirim" style="width:220px;">
                  </select>
                  <input name="rak_kirim" type="hidden" id="rak_kirim" value="" />
                  <input name="branch_kirim" type="hidden" id="branch_kirim" value="<?php echo $this->session->userdata('branch_code'); ?>" />
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Cabang</label>
               <div class="controls">
                 <select name="branch_terima" id="branch_terima" class="chosen" style="width:220px;">                     
                    <option value="">PILIH</option>
                    <?php foreach($branch as $data): ?>
                      <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>                       
            <div class="control-group">
               <label class="control-label">Bank Tujuan</label>
               <div class="controls">
                  <select name="bank_terima" class="chosen" id="bank_terima" style="width:220px;">
                  </select>
                  <input name="rak_terima" type="hidden" id="rak_terima" value="" />
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Jumlah</label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="12" value="0">
                     <span class="add-on">,00</span>
                   </div>
              </div> 
            </div>                    
            <div class="control-group">
               <label class="control-label">Keterangan</label>
               <div class="controls">
                  <textarea name="keterangan" cols="25" rows="3" class="form-control" id="keterangan"></textarea>
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
         <div class="caption"><i class="icon-reorder"></i>Edit Rekening Antara Kantor</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Edit Account Financing Successful!
            </div>
          </br>      
            <div class="control-group">
               <label class="control-label">Jenis Transaksi<span class="required">*</span></label>
               <div class="controls">
                  <select name="trx_rak_type" class="chosen" id="trx_rak_type2" style="width:220px;">
                    <option value="" selected="selected">-- Pilih --</option>
                    <option value="1">Droping Dana dari Pusat</option>
                    <option value="2">Setor Dana dari Cabang</option>
                    <option value="3">Biaya Antar Kantor</option>
                  </select>
                  <input name="trx_rak_id" type="hidden" id="trx_rak_id" />
               </div>
            </div>           
            <div class="control-group">
               <label class="control-label">Tanggal</label>
               <div class="controls">
                  <input type="text" name="voucher_date" id="mask_date" class="date-picker medium m-wrap"/>
               </div>
            </div>                  
            <div class="control-group">
               <label class="control-label">Bank Transfer</label>
               <div class="controls">
                  <select name="bank_kirim" class="chosen" id="bank_kirim2" style="width:220px;">
                  </select>
                  <input name="rak_kirim" type="hidden" id="rak_kirim" value="" />
                  <input name="branch_kirim" type="hidden" id="branch_kirim" value="" />
               </div>
            </div>            
            <div class="control-group">
               <label class="control-label">Cabang</label>
               <div class="controls">
                 <select name="branch_terima" id="branch_terima2" class="chosen" style="width:220px;">                     
                    <option value="">PILIH</option>
                    <?php foreach($branch as $data): ?>
                      <option value="<?php echo $data['branch_code'];?>"><?php echo $data['branch_name'];?></option>
                    <?php endforeach?>
                  </select>
               </div>
            </div>                       
            <div class="control-group">
               <label class="control-label">Bank Tujuan</label>
               <div class="controls">
                  <select name="bank_terima" class="chosen" id="bank_terima2" style="width:220px;">
                  </select>
                  <input name="rak_terima" type="hidden" id="rak_terima" value="" />
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Keterangan</label>
               <div class="controls">
                  <textarea name="keterangan" cols="25" rows="3" class="form-control" id="keterangan"></textarea>
               </div>
            </div>                    
            <div class="control-group">
               <label class="control-label">Jumlah</label>
               <div class="controls">
                   <div class="input-prepend input-append">
                     <span class="add-on">Rp</span>
                     <input type="text" class="m-wrap mask-money" style="width:120px;" name="amount" id="amount" maxlength="12" value="0">
                     <span class="add-on">,00</span>
                   </div>
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

$(function(){

  var form1 = $('#form_add');
  var error1 = $('.alert-error', form1);
  var success1 = $('.alert-success', form1);

  var form2 = $('#form_edit');
  var error2 = $('.alert-error', form2);
  var success2 = $('.alert-success', form2);
  
  var dTreload = function()
  {
    var tbl_id = 'rak_table';
    $("select[name='"+tbl_id+"_length']").trigger('change');
    $(".paging_bootstrap li:first a").trigger('click');
    $("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }

  // fungsi untuk check all
  jQuery('#rak_table .group-checkable').live('change',function () {
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

  $("#rak_table .checkboxes").livequery(function(){
    $(this).uniform();
  });
  
  // begin first table
  $('#rak_table').dataTable({
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": site_url+"transaction/datatable_rak_setup",
      "aoColumns": [
        null,
        null,
        null,
        null,
		null,
		null,
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

  jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
  jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown

  // fungsi untuk delete records
  $("#btn_delete").click(function(){
    var trx_rak_id = [];
    var $i = 0;
    $("input#checkbox:checked").each(function(){
      trx_rak_id[$i] = $(this).val();
      $i++;
    });
    if(trx_rak_id.length==0){
      alert("Please select some row to delete !");
    }else{
		var conf = confirm('Are you sure to delete this rows ?');
		if(conf){
		  $.ajax({
			type: "POST",
			url: site_url+"transaction/delete_trx_rak",
			dataType: "json",
			data: {trx_rak_id:trx_rak_id},
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

  /*
  | Event : kembali ke tampilan data table (EDIT FORM)
  */
  $("#cancel","#form_edit").click(function(){
    $("#edit").hide();
    $("#wrapper-table").show();
    dTreload();
    success2.hide();
    error2.hide();
  });

  $("#btn_add").click(function(){
    $("#wrapper-table").hide();
    $("#add").show();
    form1.trigger('reset');
	$('select.chosen','#form_add').val('').trigger('liszt:updated');
	  $.ajax({
		  type: 'POST',
		  url: site_url+'transaction/get_rak',
		  data: {branch_code:$('#branch_kirim','#form_add').val()},
		  dataType: 'html',
		  success: function(response){
			  $('#bank_kirim','#form_add').html(response).trigger('liszt:updated');
		  }
	  });
  });
  
  $('#bank_kirim','#form_add').change(function(){
	  $.ajax({
		  type: 'POST',
		  url: site_url+'transaction/get_rak_akun',
		  data: {branch_code:$('#branch_kirim','#form_add').val(),bank_kirim:$('#bank_kirim option:selected','#form_add').val()},
		  dataType: 'json',
		  success: function(response){
			  $('#rak_kirim','#form_add').val(response.rak_account_code);
		  }
	  });
  });
  
  $('#branch_terima','#form_add').change(function(){
	  $.ajax({
		  type: 'POST',
		  url: site_url+'transaction/get_rak',
		  data: {branch_code:$('#branch_terima option:selected','#form_add').val()},
		  dataType: 'html',
		  success: function(response){
			  $('#bank_terima','#form_add').html(response).trigger('liszt:updated');
		  }
	  });
  })

  $('#bank_terima','#form_add').change(function(){
	  $.ajax({
		  type: 'POST',
		  url: site_url+'transaction/get_rak_akun',
		  data: {branch_code:$('#branch_terima','#form_add').val(),bank_kirim:$('#bank_terima option:selected','#form_add').val()},
		  dataType: 'json',
		  success: function(response){
			  $('#rak_terima','#form_add').val(response.rak_account_code);
		  }
	  });
  });

  form1.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
	  trx_rak_type: {
		  required: true
	  },
	  mask_date: {
		  required: true
	  },
	  bank_transfer: {
		  required: true
	  },
	  branch_terima: {
		  required: true
	  },
	  bank_tujuan: {
		  required: true
	  },
	  amount: {
		  required: true
	  }
    },
    invalidHandler: function (event, validator) { //display error alert on form submit              
        success1.hide();
        error1.show();
        App.scrollTo(error1, -200);
    },
    highlight: function (element) { // hightlight error inputs
      $(element).closest('.help-inline').removeClass('ok'); // display OK icon
      $(element).closest('.control-group').removeClass('success').addClass('error'); // set error class to the control group
    },
    unhighlight: function (element) { // revert the change dony by hightlight
        $(element).closest('.control-group').removeClass('error'); // set error class to the control group
    },
    success: function (label) { },
    submitHandler: function (form) {
		$.ajax({
		  type: "POST",
		  url: site_url+"transaction/add_rak",
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
			  alert(response.message);
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
    }
  });

  $("#cancel","#form_add").click(function(){
    success1.hide();
    error1.hide();
    $("#add").hide();
    $("#wrapper-table").show();
    dTreload();
  });

  form2.validate({
    errorElement: 'span', //default input error message container
    errorClass: 'help-inline', // default input error message class
    focusInvalid: false, // do not focus the last invalid input
    errorPlacement: function(a,b){},
    // ignore: "",
    rules: {
	  trx_rak_id: {
		  required: true
	  },
	  trx_rak_type: {
		  required: true
	  },
	  mask_date: {
		  required: true
	  },
	  bank_transfer: {
		  required: true
	  },
	  branch_terima: {
		  required: true
	  },
	  bank_tujuan: {
		  required: true
	  },
	  amount: {
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
    success: function (label) { },
    submitHandler: function (form) {
      // PROSES KE FUNCTION DI CONTROLLER, APABILA VALIDASI BERHASIL
      $.ajax({
        type: "POST",
        url: site_url+"transaction/edit_rak",
        dataType: "json",
        data: form2.serialize(),
        success: function(response){
          if(response.success==true){
            success2.show();
            error2.hide();
            form2.children('div').removeClass('success');
            $("#rak_table_filter input").val('');
            dTreload();
            $("#cancel",form_edit).trigger('click')
            alert('Successfully Updated Data');
          }else{
            alert(response.message);
			success2.hide();
            error2.show();
          }
          App.scrollTo(form2, -200);
        },
        error:function(){
            success2.hide();
            error2.show();
            App.scrollTo(error2, -200);
        }
      });
    }
  });
  
  /*
  | Event : Edit Link pada Table Grid
  */
  $("a#link-edit").live('click',function(){
	$("#wrapper-table").hide();
	$("#edit").show();
    var trx_rak_id = $(this).attr('trx_rak_id');


    $.ajax({
      type: "POST",
      url: site_url+"transaction/get_rak_by_trx_rak_id",
      dataType: "json",
      async:false,
      data: {trx_rak_id:trx_rak_id},
      success: function(response){
		  $('#trx_rak_id','#form_edit').val(response.trx_rak_id);
		  $('#trx_rak_type2','#form_edit').val(response.trx_rak_type).trigger('liszt:updated');
		  $('#mask_date','#form_edit').val(response.voucher_date);
		  $('#rak_kirim','#form_edit').val(response.rak_kirim);
		  $('#bank_kirim','#form_edit').val(response.bank_kirim);
		  $('#branch_kirim','#form_edit').val(response.branch_kirim);
		  $('#branch_terima2','#form_edit').val(response.branch_terima).trigger('liszt:updated');
		  $('#rak_terima','#form_edit').val(response.rak_terima);
		  $('#bank_terima','#form_edit').val(response.bank_terima);
		  $('#amount','#form_edit').val(response.amount);

		  $.ajax({
			  type: 'POST',
			  url: site_url+'transaction/get_rak_edit',
			  data: {branch_code:response.branch_kirim,bank_sumber:response.bank_kirim},
			  dataType: 'html',
			  success: function(response){
				  $('#bank_kirim2','#form_edit').html(response).trigger('liszt:updated');
			  }
		  });

		  $.ajax({
			  type: 'POST',
			  url: site_url+'transaction/get_rak_edit',
			  data: {branch_code:response.branch_terima,bank_sumber:response.bank_terima},
			  dataType: 'html',
			  success: function(response){
				  $('#bank_terima2','#form_edit').html(response).trigger('liszt:updated');
			  }
		  });
      }
    });
  });

});
</script>
<!-- END JAVASCRIPTS -->

