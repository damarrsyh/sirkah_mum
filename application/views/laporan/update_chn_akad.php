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
        LAPORAN <small></small>
      </h3>
      <!-- END PAGE TITLE-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG BRANCH -->
<div id="dialog_kantor_cabang" class="modal hide fade" tabindex="-1" data-width="500" style="margin-top:-200px;">
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

<!-- DIALOG FA -->
<div id="dialog_fa" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari Kas Petugas</h3>
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Update Pengajuan Akad</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form action="javascript:;" id="export_excel" method="post" enctype="multipart/form-data" >
                 <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               New Deposito has been Created !
            </div>
            <br>
            <table id="filter-form" class="col-md-6">
                   <tr>
                    <td style="padding-bottom:10px;" width="100">Tgl File Upload</td>
                <td style="padding-left: 20px"> 

                      <select name="debitur_upload_no" class="chosen m-wrap" id="debitur_upload_no">
                        <option value="" selected="selected">Pilih</option>

                        <?php foreach($get_chn_akad_upload_0 as $values){?>
                        <option value="<?php echo $values->debitur_upload_no;?>"><?php echo $values->debitur_upload_no;?></option>
                        <?php }?>

                      </select>
                    </td>
                  </tr>

               <tr>
                <td>File Update</td>
                <td style="padding-left: 20px">   
                    <div class="controls">
                        <input type="file" id="userfile" name="userfile"/>
                        <p class="help-block"></p>
                    </div>
                </td>
               </tr>

               <tr>
                  <td>&nbsp;</td>
                <td style="padding-left: 20px"> 
                     <button class="green btn" id="update">Update</button>
                     <!--<button class="green btn" id="previewcsv">CSV</button>-->
                  </td>
               </tr>
               
            </table>

         </form>
            <p><hr></p>
          <!-- END FILTER-->
          <div id="showin">
          <table id="list485"></table>
          <div id="plist485"></div>
          </div>
      </div>
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
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });
</script>


<script type="text/javascript">

  $(document).ready(function (e) {
    $('#userfile').change(function(){  
           $('#export_excel').submit();  
      });  
  $("#export_excel").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
          url: site_url+"laporan/imp_chn_akad_update_excel",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
          cache: false,
      processData:false,
      success: function(data)
        {
        }          
     });
  }));
});

</script>

<script type="text/javascript">
$(function(){

// Begin Show Grid
$('#showin').hide();

$("#debitur_upload_no").change(function(){
  $('#showin').show();
  $('#list485').show();
  $('#plist485').show();
  showin();
  $('#list485').trigger('reloadGrid');
})

var showin = function(){
  //GRID SEMUA DATA ANGGOTA
  jQuery("#list485").jqGrid({
    url: site_url+'laporan/jqgrid_list_chn_akad',
    //data: mydata,

    datatype: 'json',
    height: 'auto',
    autowidth: true,
    postData: {
      debitur_upload_no : function(){return $("#debitur_upload_no").val()},
    },
    rowNum: 30,
    rowList: [50,100,150,200],
    colNames:['No. Rekening','Id Anggota','NIK','Status'],
    colModel:[
      {name:'account_financing_no',index:'account_financing_no'},
      {name:'cif_no',index:'cif_no'},
      {name:'no_ktp',index:'no_ktp'},
      {name:'debitur_status',index:'debitur_status'},
    ],
    shrinkToFit: true,
    pager: "#plist485",
    viewrecords: true,
    sortname: 'account_financing_no',
    sortorder: 'asc' ,
    grouping:false,
    rownumbers: true
  });
}
// END

  $("#update").click(function(){
     debitur_upload_no = $("#debitur_upload_no").val();
     $.ajax({
       type: "POST",
       url: site_url+"laporan/chn_akad_update",
       dataType: "json",
       data: {debitur_upload_no:debitur_upload_no},
       success: function(response){
        if(response.success==true)
        {
          alert('Successfully Update Data');
          window.location.reload(true); 
        }else
        {
          alert('Failed Update Data');
        }
        
       }
      })
  });

  

opsi();

});




</script>
<!-- END JAVASCRIPTS -->
