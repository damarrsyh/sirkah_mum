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
        SETUP HARI LIBUR <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="grid">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Setup Hari Libur</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
          <form class="form-horizontal">
            <div class="control-group">
               <div class="controls" style="margin:0;">
                  <select class="small m-wrap" id="year" name="year">
                    <option value="all">Tahun</option>
                    <?php foreach($years as $year): ?>
                    <option><?php echo $year['year'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <a id="showgrid" class="btn blue" href="javascript:;">Search</a>
               </div>
            </div>    
          </form>
          <hr size="1" style="margin:0 0 10px;">
          <div class="clearfix">
             <div class="btn-group">
                <button id="btn_add" class="btn green">
                Add New <i class="icon-plus"></i>
                </button>
                <button id="btn_delete" class="btn red">
                  Delete <i class="icon-remove"></i>
                </button>
             </div>
          </div>
          <hr size="1" style="margin:0 0 10px;">
          <!-- BEGIN FILTER FORM -->
          <table id="list485"></table>
          <div id="plist485"></div>
          <!-- END FILTER-->
      </div>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="form_add" style="display:none;">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Add Hari Libur</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <form class="form-horizontal">
        <div class="form-body">
          <div class="control-group">
             <div class="control-label">Tanggal</div>
             <div class="controls">
                <input type="text" class="medium m-wrap date-picker maskdate" id="tanggal" name="tanggal">
             </div>
          </div>
          <div class="control-group">
             <div class="control-label">Description</div>
             <div class="controls">
                <textarea class="medium m-wrap" id="description" name="description"></textarea>
             </div>
          </div>
        </div>
        <div class="form-actions">
           <button type="submit" class="btn green" id="save">Save</button>
           <button type="button" class="btn" id="btn_add_back">Back</button>
        </div>
      </form>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box purple" id="form_edit" style="display:none;">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Edit Hari Libur</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body form">
      <form class="form-horizontal">
        <div class="form-body">
          <input type="hidden" id="id">
          <div class="control-group">
             <div class="control-label">Tanggal</div>
             <div class="controls">
                <input type="text" class="medium m-wrap date-picker maskdate" id="tanggal" name="tanggal">
             </div>
          </div>
          <div class="control-group">
             <div class="control-label">Description</div>
             <div class="controls">
                <textarea class="medium m-wrap" id="description" name="description"></textarea>
             </div>
          </div>
        </div>
        <div class="form-actions">
           <button type="submit" class="btn green" id="save">Save</button>
           <button type="button" class="btn" id="btn_add_back">Back</button>
        </div>
      </form>
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

$("#showgrid").click(function(e){
	e.preventDefault();
	$("#list485").trigger('reloadGrid')
})

//GRID SEMUA DATA ANGGOTA
jQuery("#list485").jqGrid({
  url: site_url+'sys/jqgrid_setup_hari_libur',
  datatype: 'json',
  height: 250,
  autowidth: true,
  postData: {
      year : function(){return $("#year").val()}
  },
  rowNum: 30,
  rowList: [100,200,500],
  colNames:['ID','Tanggal','Description'],
  colModel:[
    {name:'id',index:'id',key:true,hidden:true},
    {name:'Tanggal',index:'tanggal', width: 80, align:'center'},
    {name:'Description',index:'description', width: 300},
  ],
  shrinkToFit: false,
  pager: "#plist485",
  viewrecords: true,
  sortname: 'tanggal',
  sortorder: 'asc' ,
  grouping:false,
  rownumbers: true
});

function loadHariLibur()
{
  $.ajax({
    type:"POST",dataType:"json",
    url:site_url+'sys/getYearsHariLibur',
    success:function(response) {
      html = '<option value="all">Tahun</option>';
      for ( i in response ) {
        html += '<option>'+response[i].year+'</option>';
      }
      $('#year').html(html);
    }
  })
}

$('#btn_add').click(function(){
  $('#form_add').show();
  $('#grid').hide();
})
$('#btn_add_back').click(function(){
  $('#form_add').hide();
  $('#grid').show();
  $('#tanggal','#form_add').val('');
  $('#description','#form_add').val('');
})
$("#save",'#form_add').click(function(e){
  e.preventDefault();

  var tanggal = $('#tanggal','#form_add');
  var description = $('#description','#form_add');
  var bValid = true;

  if (tanggal.val()=="") {
    bValid=false;
    tanggal.addClass('error');
  } else {
    tanggal.removeClass('error');
  }
  if (description.val()=="") {
    bValid=false;
    description.addClass('error');
  } else {
    description.removeClass('error');
  }

  if (bValid){
    $.ajax({
      type:"POST",dataType:"json",data:{
        tanggal:tanggal.val(),
        description:description.val()
      },
      url:site_url+'sys/add_setup_hari_libur',
      success:function(response){
        if (response.success===true) {
          alert('Save Success!')
          $('#btn_add_back').click();
          $('#list485').trigger('reloadGrid');
          loadHariLibur();
        } else {
          alert('Failed to connect into database, please cek your connection!')
        }
      },
      error: function(){
        alert('Failed to connect into database, please contact your administrator!')
      }
    })
  } else {
    alert('Mohon isi field yg kosong!');
  }
})

$('#btn_edit').click(function(e){
  e.preventDefault();
  selrow = $('#list485').jqGrid('getGridParam','selrow');
  if (selrow) {
    $('#form_edit').show();
    $('#grid').hide();
    $.ajax({
      type:"POST",dataType:"json",data:{id:selrow},
      url:site_url+'sys/get_setup_hari_libur_by_id',
      success:function(response){
        $('#id','#form_edit').val(response.id);
        $('#tanggal','#form_edit').val(response.tanggal);
        $('#description','#form_edit').val(response.description);
      }
    })
  } else {
    alert('Please select a row.');
  }
})
$('#btn_edit_back').click(function(){
  $('#form_edit').hide();
  $('#grid').show();
  $('#tanggal','#form_edit').val('');
  $('#description','#form_edit').val('');
})
$("#save",'#form_edit').click(function(e){
  e.preventDefault();
  var id = $('#id','#form_edit');
  var tanggal = $('#tanggal','#form_edit');
  var description = $('#description','#form_edit');
  var bValid = true;

  if (tanggal.val()=="") {
    bValid=false;
    tanggal.addClass('error');
  } else {
    tanggal.removeClass('error');
  }
  if (description.val()=="") {
    bValid=false;
    description.addClass('error');
  } else {
    description.removeClass('error');
  }

  if (bValid){
    $.ajax({
      type:"POST",dataType:"json",data:{
        id:id.val(),
        tanggal:tanggal.val(),
        description:description.val()
      },
      url:site_url+'sys/edit_setup_hari_libur',
      success:function(response){
        if (response.success===true) {
          alert('Save Success!')
          $('#btn_edit_back').click();
          $('#list485').trigger('reloadGrid');
          loadHariLibur();
        } else {
          alert('Failed to connect into database, please cek your connection!')
        }
      },
      error: function(){
        alert('Failed to connect into database, please contact your administrator!')
      }
    })
  } else {
    alert('Mohon isi field yg kosong!');
  }
})

// delete
$("#btn_delete").click(function(e){
  e.preventDefault();
  selrow = $('#list485').jqGrid('getGridParam','selrow');
  if (selrow) {
    conf = confirm("Apakah anda yakin?");
    if (conf){
      $.ajax({
        type:"POST",dataType:"json",data:{id:selrow},
        url:site_url+'sys/delete_hari_libur',
        success:function(response) {
          if (response.success==true){
            $('#list485').trigger('reloadGrid');
            loadHariLibur();
          } else {
            alert('Failed to connect into database, please cek your connection!')
          }
        },
        error: function(){
          alert('Failed to connect into database, please contact your administrator!')
        }
      })
    }
  } else {
    alert("Please select a row!")
  }
})
});
</script>
<!-- END JAVASCRIPTS -->
