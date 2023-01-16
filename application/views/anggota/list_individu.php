<style type="text/css">
#plist485_center input {
    margin: 0;
    padding: 3px;
    width: 10px;
    font-size:13px;
}
select {
    margin: 0;
    padding: 0;
    width: 40px;
    font-size:13px;
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
      List Individu <small>Laporan</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Laporan</a><i class="icon-angle-right"></i></li>  
      <li><a href="#">Individu</a></li> 
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- DIALOG CM -->
<!-- <div class="control-group">
    <div class="control-group">
       <div class="controls">
          CIF No. <span style="color:red">*</span> &nbsp; : &nbsp;
          <input type="text" name="cif_no" id="cif_no" readonly data-required="1" class="medium m-wrap" style="background:#EEE" />
          <input type="hidden" name="nama" id="nama" readonly data-required="1" class="medium m-wrap" style="background:#EEE" />
          <a id="browse_cif" class="btn blue" style="padding:7px 15px;" data-toggle="modal" href="#dialog_cif">...</a>
          <button class="btn blue" id="filter">Filter</button>
          <button class="btn red pull-right" id="print">Print CIF  <i class="icon-print"></i></button>
        </div>
    </div>  
</div>    --> 
<div class="control-group">
    <div class="control-group">
       <div class="controls">
          Tanggal Gabung <span style="color:red">*</span> &nbsp; : &nbsp;
          <input type="text" name="tanggal" id="tanggal" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
          sd
          <input type="text" name="tanggal2" id="tanggal2" tabindex="2" placeholder="dd/mm/yyyy" class="mask_date date-picker" value="<?php echo $current_date; ?>" maxlength="10" style="width:100px;padding:4px;margin-top:5px;margin-bottom:5px;box-shadow:0 0 0;">
          <button class="btn blue" id="filter">Filter</button>
          <button class="btn green pull-right" id="print">Preview XLS  <i class="icon-print"></i></button>
          <button class="btn green pull-right" style="margin-right:2px;" id="print_pdf">Preview PDF  <i class="icon-print"></i></button>
        </div>
    </div>  
</div>    

<!-- DIALOG USER ADD -->
<div id="dialog_cif" class="modal hide fade"  data-width="500" style="margin-top:-200px;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      <h3>Cari User</h3>
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
<table id="list485"></table>
<div id="plist485"></div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/jquery.json-2.2.js" type="text/javascript"></script>        
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->
<script>
  
   jQuery(document).ready(function() {
      App.init(); // initlayout and core plugins
      $("input#mask_date,.mask_date").livequery(function(){
        $(this).inputmask("d/m/y");  //direct mask
      });
   });

   //BEGIN EXPORT TO EXCEL
   $("#print").click(function(){
    var tanggal = $("#tanggal").val().replace(/\//g,'');
    var tanggal2 = $("#tanggal2").val().replace(/\//g,'');
    if(tanggal!="" && tanggal2!=""){
        window.open('<?php echo site_url();?>anggota/export_list_individu/'+tanggal+"/"+tanggal2);
    }else{
      alert("Tahun gabung belum di isi !");
    }
   });

   //BEGIN EXPORT TO PDF
   $("#print_pdf").click(function(){
    var tanggal = $("#tanggal").val().replace(/\//g,'');
    var tanggal2 = $("#tanggal2").val().replace(/\//g,'');
    if(tanggal!="" && tanggal2!=""){
        window.open('<?php echo site_url();?>anggota/export_list_individu_pdf/'+tanggal+"/"+tanggal2);
    }else{
      alert("Tahun gabung belum di isi !");
    }
   });

    // DIALOG SEARCH CIF NO
      // $("#browse_cif").click(function(){
      //   keyword = $("#keyword").val();

      //   if($("#keyword").val()==""){
      //     $.ajax({
      //        type: "POST",
      //        url: site_url+"anggota/search_cif_no",
      //        dataType: "json",
      //        async: false,
      //        data: {keyword:'',keyword:keyword},
      //        success: function(response){
      //           html = '';
      //           for ( i = 0 ; i < response.length ; i++ )
      //           {
      //              html += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
      //           }
      //           $("#result").html(html);
      //        }
      //     })
      //   }
      // });

      // $("#keyword").keyup(function(e){
      //   e.preventDefault();
      //   keyword = $(this).val();
      //   if(e.which==13){
      //     $.ajax({
      //        type: "POST",
      //        url: site_url+"anggota/search_cif_no",
      //        dataType: "json",
      //        async: false,
      //        data: {keyword:keyword},
      //        success: function(response){
      //           html = '';
      //           for ( i = 0 ; i < response.length ; i++ )
      //           {
      //              html += '<option value="'+response[i].cif_no+'">'+response[i].cif_no+' - '+response[i].nama+'</option>';
      //           }
      //           $("#result").html(html);
      //        }
      //     })
      //   }
      // });

      // $("#select").click(function(){
      //   nama    = $("#result").find('option:selected').text();
      //   cif_no  = $("#result").val();

      //   $("#nama").val(nama);
      //   $("#cif_no").val(cif_no);
      //   $(".close").trigger('click');
      // });

      // $("#result option").live('dblclick',function(){
      //   $("#select").trigger('click');
      // });

     /* END DIALOG SEARCH CIF NO */

    $("#filter").click(function(){
          $("#close","#dialog_cif").trigger('click');
          $("#list485").trigger('reloadGrid');
      })


//GRID SEMUA DATA ANGGOTA
jQuery("#list485").jqGrid({
  url: site_url+'/anggota/list_individu_report',
  //data: mydata,
  datatype: 'json',
  height: 'auto',
  postData: {
    tanggal : function(){return $("#tanggal").val().replace(/\//g,'')},
    tanggal2 : function(){return $("#tanggal2").val().replace(/\//g,'')}
  },
  rowNum: 30,
  shrinkToFit: false,
  autowidth: true,
  rowList: [10,20,30],
    colNames:['Cif No','Nama', 'Jenis Kelamin', 'Tanggal Lahir','Usia'],
    colModel:[
      {name:'cif_no',index:'cif_no', width:200},
      {name:'nama',index:'nama', width:200},
      {name:'jenis_kelamin',index:'jenis_kelamin', width:100},
      {name:'tgl_lahir',index:'tgl_lahir', width:130},
      {name:'usia',index:'usia', width:80},     
    ],
    pager: "#plist485",
    viewrecords: true,
    sortname: 'cif_no',
    grouping:false,
    groupingView : {
      groupField : ['cm_name'],
      groupColumnShow : [false],
      groupText : ['<b style="font-size:14px;">{0} - {1} Anggota </b>'],
      groupCollapse : false,
    groupOrder: ['desc']      
    },
    caption: "List Data Individu"
});/*
jQuery("#list485").jqGrid('navGrid','#plist485',
{edit:false,add:false,del:false},
{},
{},
{},
{multipleSearch:true, multipleGroup:true}
);*/
</script>
<!-- END JAVASCRIPTS -->

