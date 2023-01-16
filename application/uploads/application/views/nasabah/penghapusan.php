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
			Penghapusan Pembiayaan<small> Berfungsi untuk melakukan penghapusan pembiayaan secara paksa</small>
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="<?php echo site_url('dashboard'); ?>">Home</a> 
				<i class="icon-angle-right"></i>
			</li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
         <li><a href="#">Pembiayaan</a><i class="icon-angle-right"></i></li> 
			<li><a href="#">Penghapusan</a></li>	
		</ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->

<!-- BEGIN JQGRID -->
<div id="jqgrid">
   
   <div class="portlet box grey">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Penghapusan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <table id="jqgrid_data"></table>
         <div id="jqgrid_pager"></div>
      </div>
   </div>

</div>
<!-- END JQGRID -->

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
  
   $("#mask_date").inputmask("y/m/d", {autoUnmask: true});  //direct mask        
});
</script>

<script type="text/javascript">
$(function(){

var jqgrid_data = $('#jqgrid_data'), jqgrid_pager = $("#jqgrid_pager"), t_jqgrid_data=$('#t_jqgrid_data');

/*BEGIN JQGRID*/
jqgrid_data.jqGrid({
   url: site_url+'rekening_nasabah/jqgrid_data_penghapusan_pembiayaan',
   mtype: "GET",
   datatype: "json",
   colModel: [
       { label: 'account_financing_id', name: 'account_financing_id', key: true, hidden:true }
      ,{ label: 'No. CIF', name: 'cif_no', width:120, hidden:true }
      ,{ label: 'No. Pembiayaan', name: 'account_financing_no', width:130, align:'center' }
      ,{ label: 'Majlis', name: 'cm_name', width:100, }
      ,{ label: 'Nama', name: 'nama', width:150 }
      ,{ label: 'Pokok', name: 'pokok', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Margin', name: 'margin', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Angs. Pokok', name: 'angsuran_pokok', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Angs. Margin', name: 'angsuran_margin', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Angs. Catab', name: 'angsuran_catab', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Sld. Pokok', name: 'saldo_pokok', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Sld. Margin', name: 'saldo_margin', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Sld. Catab', name: 'saldo_catab', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Tgl. Akad', name: 'tanggal_akad', width:90, align:'center',formatter:'date', formatoptions: {srcformat:'Y-m-d',newformat:'d/m/Y'} }
      ,{ label: 'Jangka Waktu', name: 'jangka_waktu', width:90, align:'center' }
      ,{ label: 'Periode', name: 'periode_jangka_waktu', width:90, align:'center', formatter: function(cellvalue) {
         switch(cellvalue) {
            case "0":
            return "Harian";
            break;
            case "1":
            return "Mingguan";
            break;
            case "2":
            return "Bulanan";
            break;
            case "3":
            return "Jatuh Tempo";
            break;
            default:
            return cellvalue;
            break;
         }
      } }
      ,{ label: 'Ctr Angs.', name: 'counter_angsuran', width:90, align:'center' }
      ,{ label: 'Biaya Adm.', name: 'biaya_administrasi', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Biaya Asrns.Jiwa', name: 'biaya_asuransi_jiwa', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
      ,{ label: 'Biaya Asrns.Jmnn', name: 'biaya_asuransi_jaminan', width:90, align:'right',formatter:'currency', formatoptions: {decimalSeparator:',',thousandsSeparator:'.',decimalPlaces:0,defaultValue:'0' } }
   ],
   viewrecords: true,
   autowidth: true,
   height: 500,
   rowNum: 20,
   rownumbers: true,
   shrinkToFit: false,
   toolbar: [true, "top"],
   sortname: "c.cm_code,b.kelompok",
   sortorder: "asc",
   multiselect: false,
   pager: "#jqgrid_pager"
});
t_jqgrid_data.append('<button class="jqGrid_export" id="btn_export" title="Export ALL"></button>');
/*END JQGRID*/

})
</script>
