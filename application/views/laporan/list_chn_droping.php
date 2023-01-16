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
      <div class="caption"><i class="icon-globe"></i>List Pengajuan Droping</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <form action="javascript:;" id="export_excel" method="post">
            <table id="filter-form" class="col-md-6">
                   <tr>
                    <td style="padding-bottom:10px;" width="100">Tgl File Upload</td>
                <td style="padding-left: 20px"> 

                      <select name="debitur_upload_no" class="chosen m-wrap" id="debitur_upload_no">
                        <option value="" selected="selected">Pilih</option>

                        <?php foreach($get_chn_debitur_upload as $values){?>
                        <option value="<?php echo $values->debitur_upload_no;?>"><?php echo $values->debitur_upload_no;?></option>
                        <?php }?>

                      </select>
                    </td>
                  </tr>

               <tr>
                  <td>&nbsp;</td>
                  <td style="padding-left: 20px">
                     <button class="green btn" id="previewxls">Create Droping</button>
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
          url: site_url+"laporan/imp_chn_droping_excel",
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

$("#showgrid").click(function(){
  $('#showin').show();
  $('#list485').show();
  $('#plist485').show();
  showin();
  $('#list485').trigger('reloadGrid');
})

var showin = function(){
  //GRID SEMUA DATA ANGGOTA
  jQuery("#list485").jqGrid({
    url: site_url+'laporan/jqgrid_list_pembiayaan',
    //data: mydata,
    datatype: 'json',
    height: 'auto',
    autowidth: true,
    postData: {
      fa_code : function(){return $("#fa_code").val()},
      branch_code : function(){return $("#branch_code").val()},
      financing_type : function(){return $("#financing_type").val()},
      tanggal : function(){return $("#tanggal").val()},
      tanggal2 : function(){return $("#tanggal2").val()},
      cm_code : function(){return $("#cm_code").val()},
      product_code : function(){return $("#product").val()},
      kreditur : function(){return $("#kreditur").val()},
      peruntukan : function(){return $("#peruntukan").val()},
      sektor : function(){return $("#sektor").val()},
    },
    rowNum: 30,
    rowList: [50,100,150,200],
    colNames:['Tanggal','No. Rekening','Nama','Pembiayaan', 'Sumber Dana', 'Majelis','PYD','Produk','Plafon','Margin','Periode','Jangka Waktu','Biaya Admin','Biaya Asuransi','Plafon Sebelumnya','Keterangan','Pengguna Data','Peruntukan','Sektor','No Hp'],
    colModel:[
      {name:'droping_date',index:'droping_date'},
      {name:'account_financing_no',index:'account_financing_no'},
      {name:'nama',index:'nama'},
      {name:'financing_type',index:'financing_type'},
      {name:'kreditur',index:'kreditur'},
      {name:'cm_code',index:'cm_name'},
      {name:'pembiayaan_ke',index:'pembiayaan_ke'},
      {name:'product_code',index:'product_name'},
      {name:'pokok',index:'pokok',align:'right'},
      {name:'margin',index:'margin',align:'right'},
      {name:'periode_jangka_waktu',index:'periode_jangka_waktu'},
      {name:'jangka_waktu',index:'jangka_waktu'},
      {name:'biaya_administrasi',index:'biaya_administrasi',align:'right'},
      {name:'biaya_asuransi_jiwa',index:'biaya_asuransi_jiwa',align:'right'},
      {name:'pokok_sebelum',index:'pokok_sebelum',align:'right'},
      {name:'keterangan',index:'keterangan'},
      {name:'pengguna_dana',index:'pengguna_dana'},
      {name:'dtp',index:'dtp'},
      {name:'dts',index:'dts'},
      {name:'no_hp',index:'no_hp'},
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


	/* BEGIN DIALOG ACTION BRANCH */
	$("a#browse_branch").click(function(){
	   keyword = $("#keyword","#dialog_kantor_cabang").val();
	   $.ajax({
			 type: "POST",
			 url: site_url+"cif/get_branch_by_keyword",
			 dataType: "json",
			 data: {keyword:keyword},
			 success: function(response){
				html = '';
				// html = '<option value="0000" branch_name="Semua Branch" branch_id="0000">0000 - Semua Branch</option>';
				for ( i = 0 ; i < response.length ; i++ )
				{
				   html += '<option value="'+response[i].branch_code+'" branch_id="'+response[i].branch_id+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				$("#result","#dialog_kantor_cabang").html(html);
			 }
		  })
	});
	
	  $("#keyword","#dialog_kantor_cabang").on('keypress',function(e){
		  if(e.which==13){
			$.ajax({
			  type: "POST",
			  url: site_url+"cif/search_cabang",
			  data: {keyword:$(this).val()},
			  dataType: "json",
			  success: function(response){
				var option = '';
				for(i = 0 ; i < response.length ; i++){
				   option += '<option value="'+response[i].branch_code+'" branch_code="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}
				// console.log(option);
				$("#result").html(option);
			  }
			});
		  }
	  });
	
	$("#select","#dialog_kantor_cabang").click(function(){
	  $(".close","#dialog_kantor_cabang").trigger('click');
	  branch_code = $("#result","#dialog_kantor_cabang").val();
	  branch_name = $("#result option:selected","#dialog_kantor_cabang").attr('branch_name');
	  branch_id = $("#result option:selected","#dialog_kantor_cabang").attr('branch_id');
	  $("#branch_code").val(branch_code);
	  $("#branch_name").val(branch_name);
	  $("#branch_id").val(branch_id);
	});
	
	$("#result option","#dialog_kantor_cabang").live('dblclick',function(){
	  $("#select","#dialog_kantor_cabang").trigger('click');
	});
   /* END DIALOG ACTION BRANCH */

   /* BEGIN DIALOG ACTION REMBUG */
  $("#browse_cm").click(function(){
    cm = $("input[name='cm']").val();
    $("#keyword","#dialog_cm").val()
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword',"#dialog_cm").trigger(e);
    },300)
  });

  $("#keyword","#dialog_cm").keypress(function(e){
    keyword = $(this).val();
    branch_id = $("input[name='branch_id']").val();
	fa_code=$("input[name='fa_code']").val();
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"cif/search_majelis_by_petugas",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_id:branch_id,fa_code:fa_code},
         success: function(response){
            html = '<option value="00000" cm_name="SEMUA MAJELIS">00000 - SEMUA MAJELIS</option>';
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

  $("input[name='cm']").keypress(function(e){
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
   /* END DIALOG ACTION REMBUG */

  // BEGIN DIALOG PETUGAS
  $("#browse_fa").click(function(){

    fa = $("input[name='fa']").val();
    $("#keyword","#dialog_fa").val()
    setTimeout(function(){
      var e = $.Event('keypress');
      e.keyCode = 13; // Character 'A'
      $('#keyword',"#dialog_fa").trigger(e);
    },300)
  })

  $("#keyword","#dialog_fa").keypress(function(e){
    keyword = $(this).val();
    branch_code = $("input[name='branch_code']").val();
    branch_class = $("input[name='branch_class']").val();
    if(e.keyCode==13){
      e.preventDefault();
      $.ajax({
         type: "POST",
         url: site_url+"cif/search_petugas_by_cabang",
         dataType: "json",
         async: false,
         data: {keyword:keyword,branch_code:branch_code},
         success: function(response){
            html = '<option value="00000" fa_name="SEMUA PETUGAS">00000 - SEMUA PETUGAS</option>';
            for ( i = 0 ; i < response.length ; i++ )
            {
              html += '<option value="'+response[i].fa_code+'" fa_name="'+response[i].fa_name+'">'+response[i].fa_code+' | '+response[i].fa_name+'</option>';
            }
            $("#result","#dialog_fa").html(html).focus();
            $("#result option:first-child","#dialog_fa").attr('selected',true);
         }
      })
    }
  });

  $("#select","#dialog_fa").click(function(){
    result_name = $("#result option:selected","#dialog_fa").attr('fa_name');
    account_cash_code = $("#result option:selected","#dialog_fa").attr('account_cash_code');
    result_code = $("#result","#dialog_fa").val();
    if(result!=null)
    {
      $("input[name='fa']").val(result_name);
      $("input[name='fa_name']").val(result_name);
      $("input[name='fa_code']").val(result_code);
      $("input[name='account_cash_code']").val(account_cash_code);
      $("#close","#dialog_fa").trigger('click');
    }
  });

  $("#result option","#dialog_fa").livequery('dblclick',function(){
    $("#select","#dialog_fa").trigger('click');
    window.scrollTo(0,0)
  });

  $("input[name='fa']").keypress(function(e){
    if(e.keyCode==13){
      $(this).blur();
      e.preventDefault();
      $("#browse_fa").trigger('click');
    }
  });

  $("#result","#dialog_fa").keypress(function(e){
    e.preventDefault();
    if(e.keyCode==13){
      $("#select","#dialog_fa").trigger('click');
    }
  });
  // END DIALOG PETUGAS

  $('#financing_type').change(function(){
	  var financing = $(this).val();

	  if(financing == 1){
		  $("#field_majelis").fadeOut();
		  $("#field_petugas").fadeOut();
	  } else {
		  $("#field_majelis").fadeIn();
		  $("#field_petugas").fadeIn();
	  }
  });

      $('#previewxls').click(function(){ 
      var debitur_upload_no = $('#debitur_upload_no').val();

      var site = '<?php echo site_url('laporan_to_excel/create_lap_chn_droping'); ?>'; 
      
      var conf = true;
      
      if(conf == true){
        window.open(site+'/'+debitur_upload_no); 
        
      }
	  });

      $('#previewpdf').click(function(){
		  var branch_code = $('#branch_code').val();
      var kreditur = $('#kreditur').val();
		  var tanggal = $('#tanggal').val();
		  var tanggal = datepicker_replace(tanggal);
		  var tanggal2 = $('#tanggal2').val();
		  var tanggal2 = datepicker_replace(tanggal2);
		  var site = '<?php echo site_url('laporan_to_pdf/export_list_chn_debitur'); ?>';
		  var conf = true;
		  
		  if(tanggal == '' && tanggal2 == ''){
			  alert('Tanggal belum diisi');
			  var conf = false;
		  }
	

		  if(conf == true){
			  window.open(site+'/'+tanggal+'/'+tanggal2+'/'+branch_code+'/'+kreditur);
		  }
      });

      $('#previewcsv').click(function(){
      /*var branch_code = $('#branch_code').val();
      var kreditur = $('#kreditur').val();
      var tanggal = $('#tanggal').val();
      var tanggal = datepicker_replace(tanggal);
      var tanggal2 = $('#tanggal2').val();
      var tanggal2 = datepicker_replace(tanggal2);*/
      var site = '<?php echo site_url('laporan_to_csv/export_lap_chn_droping'); ?>';
      var conf = true;
      
      /*if(tanggal == '' && tanggal2 == ''){
        alert('Tanggal belum diisi');
        var conf = false;
      } */

      if(conf == true){
        window.open(site);
      }
	  });


	  opsi();

      $(".dataTables_filter").parent().hide(); //menghilangkan serch
      
      jQuery('#rekening_tabungan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#rekening_tabungan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown
   
});

</script>
<!-- END JAVASCRIPTS -->
