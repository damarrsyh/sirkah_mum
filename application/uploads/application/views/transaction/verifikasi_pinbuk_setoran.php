<style type="text/css">
#form input:focus, #form select:focus {
  border: solid 2px #1A8BCC;
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
      <!-- BEGIN PAGE TITLE-->
      <h3 class="form-section">
        Verifikasi <small>Pinbuk Setoran</small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN PROSES PINBUK -->

  <!-- BEGIN FORM-->
<div class="portlet-body form">
    <div class="alert alert-error hide">
       Please Fill All Field Below !
    </div>

        <!-- DIALOG BRANCH -->
        <div id="dialog_branch" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
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
              <button type="button" id="select" class="btn blue">Select</button>
           </div>
        </div>


        <!-- DIALOG CM -->
        <div id="dialog_cm" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3>Cari Rembug Pusat</h3>
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
      <form id="form_process" class="form-horizontal">
        <table>
          <tr>
            <td>Kantor Cabang <span style="color:red">*</span></td>
            <td>
              <input type="text" tabindex="1" name="branch" readonly value="<?php echo $branch_name_cm; ?>" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;"> 
              <?php if($this->session->userdata('flag_all_branch')){ ?>
              <a id="browse_branch" class="btn blue" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
              <?php } ?>
              <!-- <a id="browse_branch" class="btn blue" tabindex="1" style="padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a> -->
            </td>
          </tr>
          <tr class="hidden">
            <td>Rembug Pusat <span style="color:red">*</span></td>
            <td>
              <input type="text" tabindex="2" name="cm" style="padding:4px;margin-top:2px;margin-bottom:2px;box-shadow:0 0 0;">
              <a id="browse_cm" class="btn blue" tabindex="2" style="padding:4px 10px;" data-toggle="modal" href="#dialog_cm">...</a>
            </td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><button class="btn green search" tabindex="5" type="button">Tampilkan</button></td>
          </tr>
        </table>
      </form>

      
      <!-- <hr> -->
      <p>&nbsp;</p>
        <input type="hidden" name="cm_code" id="cm_code">
        <input type="hidden" name="branch_name" value="<?php echo $branch_name_cm; ?>">
        <input type="hidden" name="branch_class" value="<?php echo $branch_class_cm; ?>">
        <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $branch_code_cm; ?>">
        <input type="hidden" name="branch_id" value="<?php echo $branch_id_cm; ?>">
        <input type="hidden" name="created" id="created" value="">
        <input type="hidden" name="wajib" id="wajib" value="">
        <input type="hidden" name="kelompok" id="kelompok" value="">
        <input type="hidden" name="total" id="total" value="">
        <div id="r_v_pinbuk">
        <table class="table table-striped table-bordered table-hover" id="r_verif_pinbuk">
          <thead>
            <tr>
              <th>Tanggal Transaksi</th>
              <th>Wajib</th>
              <th>Kelompok</th>
              <th>Total</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        </div>
        <div id="r_d_pinbuk">
        <table class="table table-striped table-bordered table-hover" id="r_detil_pinbuk">
          <thead>
            <tr>
              <th>No. CIF</th>
              <th>Nama</th>
              <th>Tab. Wajib</th>
              <th>Tab. Kelompok</th>
              <th>Simpanan Pokok</th>
              <th>Simpanan Wajib</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <center>
        	<button class="btn blue proses" tabindex="5" type="button">Proses</button>
            <button class="btn red batal" tabindex="5" type="button">Batal</button>
        </center>
        </div>
  </div>
  <!-- END FORM-->

<!-- END PROSES PINBUK -->


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

<script type="text/javascript">
$(function(){
	
	$('#r_d_pinbuk').hide();

	var dTreload = function()
  {
	var tbl_id = 'r_verif_pinbuk';
	$("select[name='"+tbl_id+"_length']").trigger('change');
	$(".paging_bootstrap li:first a").trigger('click');
	$("#"+tbl_id+"_filter input").val('').trigger('keyup');
  }
  
  $('.search').click(function(){
	  dTreload();
  });
  
  $('.batal').click(function(){
	  $('#r_d_pinbuk').fadeOut();
	  $('#r_v_pinbuk').fadeIn();
  });
  
  $('.proses').click(function(){
	  var wajib = $('#wajib').val();
	  var kelompok = $('#kelompok').val();
	  var total = $('#total').val();
	  var created = $('#created').val();
	  var branch = $('#branch_code').val();
	  
	  $.ajax({
		  type: 'POST',
		  url: site_url+'transaction/proses_pembukuan_setoran_pokok',
		  dataType: 'json',
		  data: {
			  pwajib: wajib,
			  pkelompok: kelompok,
			  ptotal: total,
			  pcreated: created,
			  pbranch: branch
		  },
		  async: false,
		  success: function(response){
			  var sukses = response.sukses;
			  var pesan = response.message;
			  
			  if(sukses == true){
				  alert(pesan);
				  $('#r_d_pinbuk').fadeOut();
				  $('#r_v_pinbuk').fadeIn();
				  dTreload();
			  } else {
				  alert(pesan)
			  }
		  },
		  error: function(){
			  alert('Gagal! Periksa kembali koneksi internet Anda');
		  }
	  });
  });
  
  $('a#verif_kelompok').live('click',function(){
	  $('#r_v_pinbuk').fadeOut();
	  $('#r_d_pinbuk').fadeIn();
	  $('#created').val($('a#verif_kelompok').attr('created'));
	  $('#wajib').val($('a#verif_kelompok').attr('wajib'));
	  $('#kelompok').val($('a#verif_kelompok').attr('kelompok'));
	  $('#total').val($('a#verif_kelompok').attr('total'));
	  
	  $('#r_detil_pinbuk').dataTable({
		  "bDestroy":true,
		  "bProcessing": true,
		  "bServerSide": true,
		  "sAjaxSource": site_url+"transaction/datatable_r_detil_pinbuk",
		  "fnServerParams": function ( aoData ) {
			  aoData.push( { "name": "branch", "value": $("#branch_code").val() } );
			  //aoData.push( { "name": "cm", "value": $("#cm_code").val() } );
		  },
		  "aoColumns": [
			null,
			null,
			null,
			null,
			null,
			null
		  ],
		  "aLengthMenu": [
			  [15, 30, 45, -1],
			  [15, 30, 45, "All"] // change per page values here
		  ],
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
  });

  $('#r_verif_pinbuk').dataTable({
	  "bDestroy":true,
	  "bProcessing": true,
	  "bServerSide": true,
	  "sAjaxSource": site_url+"transaction/datatable_r_verif_pinbuk",
	  "fnServerParams": function ( aoData ) {
		  aoData.push( { "name": "branch", "value": $("#branch_code").val() } );
		  //aoData.push( { "name": "cm", "value": $("#cm_code").val() } );
	  },
	  "aoColumns": [
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

  $("#browse_branch").click(function(){
    if($("#keyword","#dialog_branch").val()==""){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         data: {keyword:''},
         async: false,
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_class="'+response[i].branch_class+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  })

  $("#keyword","#dialog_branch").keyup(function(e){
    e.preventDefault();
    keyword = $(this).val();
    if(e.which==13){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword},
         success: function(response){
            html = '';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].branch_code+'" branch_class="'+response[i].branch_class+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
            }
            $("#result","#dialog_branch").html(html);
         }
      })
    }
  });

  $("#select","#dialog_branch").click(function(){
    branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
    result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
    branch_class = $("#result option:selected","#dialog_branch").attr('branch_class');
    result_code = $("#result","#dialog_branch").val();
    if(result!=null)
    {
      $("input[name='branch']").val(result_name);
      $("input[name='branch_name']").val(result_name);
      $("input[name='branch_code']").val(result_code);
      $("input[name='branch_id']").val(branch_id);
      $("input[name='branch_class']").val(branch_class);
      $("#close","#dialog_branch").trigger('click');
    }
  });

  $("#result option","#dialog_branch").livequery('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
    window.scrollTo(0,0)
  });

  $("#browse_cm").click(function(){
    cm = $("input[name='cm']","#form_process").val();
    $("#keyword","#dialog_cm").val(cm)
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword',"#dialog_cm").trigger(e);
    },300)
  });

  $("#keyword","#dialog_cm").keypress(function(e){
    keyword = $(this).val();
    branch_id = $("input[name='branch_id']").val();
    branch_code=$("input[name='branch_code']").val();
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_rembug_by_keyword",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_id:branch_id,branch_code:branch_code},
         success: function(response){
            html = '<option value="0000" cm_name="Semua Rembug">Semua Rembug</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
               html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
            }
            $("#result","#dialog_cm").html(html).focus();
            $("#result option:first-child","#dialog_cm").attr('selected',true);
         }
      });
    }
  });

  $("#select","#dialog_cm").click(function(){
    result_name = $("#result option:selected","#dialog_cm").attr('cm_name');
    result_code = $("#result","#dialog_cm").val();
    if(result!=null)
    {
      $("input[name='cm']").val(result_name);
      $("input[name='cm_code']").val(result_code);
      $("#close","#dialog_cm").trigger('click');
    }
  });

  $("#result option","#dialog_cm").livequery('dblclick',function(){
    $("#select","#dialog_cm").trigger('click');
    window.scrollTo(0,0)
  });

  $("input[name='cm']","#form_process").keypress(function(e){
    if(e.keyCode==13){
      $(this).blur();
      e.preventDefault();
      $("#browse_cm").trigger('click');
    }
  });

  $("#result","#dialog_cm").keypress(function(e){
    e.preventDefault();
    if(e.keyCode==13){
      $("#select","#dialog_cm").trigger('click');
    }
  });

  /* end cari rembug */

});
</script>

<?php $this->load->view('_jsfoot'); ?>