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
        Pinbuk Setoran Anggota <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_branch" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<div id="dialog" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
    <h3>Proses Setoran Pokok</h3>
  </div>
  <div class="modal-body">
    <form class="form-horizontal">
      <div class="form-body">
        <div class="control-group">
          <label class="control-label">Tanggal Proses</label>
          <div class="controls">
            <input type="text" class="maskdate date-picker small m-wrap" placeholder="dd/mm/yyyy" id="tanggal" name="tanggal">
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="modal-footer">
    <button type="button" id="close" data-dismiss="modal" class="btn">Close</button>
    <button type="button" class="btn blue" id="save">Process</button>
  </div>
</div>

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="grid">
  <div class="portlet-title">
    <div class="caption"><i class="icon-globe"></i>Pinbuk Setoran Anggota</div>
    <div class="tools">
       <a href="javascript:;" class="collapse"></a>
    </div>
  </div>

  <div class="portlet-body form">
     <form action="javascript:;">
        <input type="hidden" name="branch" id="branch" value="<?php echo $this->session->userdata('branch_name') ?>">
        <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
        <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
        <table id="filter-form">
           <tr>
              <td style="padding-bottom:10px;" width="100">Cabang</td>
              <td>
                 <input type="text" name="branch" class="m-wrap mfi-textfield" readonly="" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>"> 
                 <?php if($this->session->userdata('flag_all_branch')){ ?>
                 <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
                 <?php } ?>
              </td>
           </tr>
           <tr>
              <td></td>
              <td>
                 <button class="green btn" id="showgrid">Show Grid</button>
                 <a class="btn green" data-toggle="modal" href="#dialog">Proses</a>
              </td>
           </tr>
        </table>
     </form>
     <p>&nbsp;</p>
    <!-- BEGIN FILTER FORM -->
    <table id="list485"></table>
    <div id="plist485"></div>
    <!-- END FILTER-->
  </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<?php $this->load->view('_jscore'); ?>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/jquery.form.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $(".maskdate").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>


<script type="text/javascript">
$(function(){

/* BEGIN SCRIPT */

$("#browse_branch").click(function(){
  $.ajax({
	 type: "POST",
	 url: site_url+"cif/search_cabang",
	 dataType: "json",
	 data: {keyword:$("#keyword","#dialog_branch").val()},
	 success: function(response){
		html = '';
		for ( i = 0 ; i < response.length ; i++ )
		{
		   html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
		}
		$("#result","#dialog_branch").html(html);
	 }
  })
})

$("#keyword","#dialog_branch").keyup(function(e){
  e.preventDefault();
  keyword = $(this).val();
  if(e.which==13)
  {
	 $.ajax({
		type: "POST",
		url: site_url+"cif/search_cabang",
		dataType: "json",
		data: {keyword:keyword},
		success: function(response){
		   html = '';
		   for ( i = 0 ; i < response.length ; i++ )
		   {
			  html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
		   }
		   $("#result","#dialog_branch").html(html);
		}
	 })
  }
});

$("#select","#dialog_branch").click(function(){
  branch_id = $("#result option:selected","#dialog_branch").attr('branch_id');
  result_name = $("#result option:selected","#dialog_branch").attr('branch_name');
  result_code = $("#result","#dialog_branch").val();
  if(result!=null)
  {
	  $("input[name='branch']").val(result_name);
	  $("input[name='branch_code']").val(result_code);
	  $("input[name='branch_id']").val(branch_id);
	  $("#close","#dialog_branch").trigger('click');
  }
});

$("#result option:selected","#dialog_branch").live('dblclick',function(){
$("#select","#dialog_branch").trigger('click');
});

$('button#showgrid').click(function(e){
	e.preventDefault();
	$("#list485").trigger('reloadGrid')
});
//GRID SEMUA DATA ANGGOTA
jQuery("#list485").jqGrid({
  url: site_url+'cif/jqgrid_setoran_pokok',
  datatype: 'json',
  height: 250,
  autowidth: true,
  postData: {
	  branch_code : function(){return $("#branch_code").val()}
  },
  rowNum: 100,
  rowList: [100,200,500,1000,5000,10000,100000],
  colModel:[
	{name:'id',index:'id',key:true,hidden:true},
	{name:'CIF No.',index:'cif_no', width: 120, align:'center'},
	{name:'Nama',index:'nama', width: 150},
	{name:'Tab. Wajib',index:'tabungan_wajib', width: 100, align:'right', formatter:function(cellvalue){
	  return number_format(cellvalue);
	}},
	{name:'Tab. Kelompok',index:'tabungan_kelompok', width: 100, align:'right', formatter:function(cellvalue){
	  return number_format(cellvalue);
	}},
	{name:'Simpanan Pokok',index:'simpanan_pokok', width: 100, align:'right', formatter:function(cellvalue){
	  return number_format(cellvalue);
	}},
	{name:'Simpanan Wajib',index:'smk', width: 100, align:'right', formatter:function(cellvalue){
	  return number_format(cellvalue);
	}},
  ],
  shrinkToFit: false,
  pager: "#plist485",
  viewrecords: true,
  sortname: 'cif_no',
  sortorder: 'asc' ,
  grouping:false,
  rownumbers: true
});

$("#save").click(function(e){
  
  e.preventDefault();
  
  var branch_code = $('#branch_code');
  var tanggal = $('#tanggal');

  if (tanggal.val()=="") {
    alert('Harap isi Tanggal Proses.')
  } else {
    App.ConfirmAlert("Proses Pinbuk Setoran Anggota pada Tanggal ini. Apakah anda yakin ?",function(){

      $('#dialog').modal('hide');
      $.ajax({
        type:"POST",
		dataType:"json",
		data:{
          tanggal: App.ToDateDefault(tanggal.val()),
		  branch: branch_code.val()
        },
		//url:site_url+'cif/do_setoran_pokok',
		url:site_url+'cif/debet_setoran_pokok',
        success:function(response){
          if (response.success==true) {
            var content = 'Proses Pinbuk Setoran Anggota Selesai.';
            var callback = function(){
              $("#list485").trigger('reloadGrid');
            }
            App.SuccessAlert(content,callback);
          } else {
            App.WarningAlert(response.message);
          }
        },
        error:function(){
          alert('Failed to connect into databases, please contact your administrator.')
        }
      })

    })
  }

})

});
</script>
<!-- END JAVASCRIPTS -->
