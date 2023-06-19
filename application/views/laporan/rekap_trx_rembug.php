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
        REKAP TRANSAKSI REMBUG <small>Print Rekap Transaksi Rembug By Petugas</small>
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

<!-- BEGIN FORM-->
<div class="portlet-body form">
   <!-- BEGIN FILTER FORM -->
   <form class="form-horizontal">
      <input type="hidden" name="branch" id="branch">
      <input type="hidden" name="branch_code" id="branch_code">
      <input type="hidden" name="branch_id" id="branch_id">
      <table id="filter-form">
         <tr>
            <td width="150">Cabang</td>
            <td>
               <input type="text" id="branch" name="branch" class="m-wrap mfi-textfield" style="background:#EEE;" readonly="readonly"> 
               <a id="browse_branch" class="btn blue" style="margin-top:8px;padding:4px 10px;" data-toggle="modal" href="#dialog_branch">...</a>
            </td>
         </tr>
         <tr>
            <td width="150">Petugas</td>
            <td>
               <select class="chosen m-wrap mfi-textfield" name="petugas" id="petugas">
               <!-- BODY GOES HERE AFTER SELECTED BRANCHS -->
               </select>
            </td>
         </tr>
         <tr>
            <td width="150">Majelis</td>
            <td>
               <select class="chosen m-wrap mfi-textfield" name="majelis" id="majelis">
               <!-- BODY GOES HERE AFTER SELECTED BRANCHS -->
               </select>
            </td>
         </tr>
         <tr>
            <td width="150">Hari Transaksi</td>
            <td>
               <select class="chosen m-wrap mfi-textfield" name="hari_transaksi" id="hari_transaksi">
                <option value="0">Minggu</option>
                <option value="1">Senin</option>
                <option value="2">Selasa</option>
                <option value="3">Rabu</option>
                <option value="4">Kamis</option>
                <option value="5">Jumat</option>
                <option value="6">Sabtu</option>
               </select>
            </td>
         </tr>
         <tr>
            <td width="150">Tanggal Transaksi</td>
            <td>
               <input type="text" id="tanggal" name="tanggal" class="m-wrap mfi-textfield date-picker mask_date" placeholder="DD/MM/YYYY" value="<?php echo date('d/m/Y'); ?>"> 
            </td>
         </tr>
         <tr>
            <td></td>
            <td style="padding-top:10px;">
               <button class="green btn" id="previewpdf">PDF</button>
            </td>
         </tr>
      </table>
   </form>
   <!-- END FILTER FORM -->
</div>

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
        $(this).inputmask("d/m/y", {autoUnmask: true});  //direct mask
      });
   });
</script>

<script type="text/javascript">
$(function(){
/* BEGIN SCRIPT */

   /* BEGIN DIALOG ACTION BRANCH */
  
   $("#browse_branch").click(function(){
      $.ajax({
         type: "POST",
         url: site_url+"cif/get_branch_by_keyword",
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
   });
   
   var search_majelis = function(){
	   var branch_id = $('#branch_id').val();
	   var fa_code = $('#petugas').val();
	   
	   $.ajax({
		   type: 'POST',
		   url: site_url+'laporan/get_rembug_by_fa_branch',
		   dataType: 'html',
		   data: {
			   branch:branch_id
		   },
		   success: function(response){
			   $('#majelis').html(response).trigger('liszt:updated');
		   }
	   });
   }

   $("#keyword","#dialog_branch").keyup(function(e){
      e.preventDefault();
      keyword = $(this).val();
      if(e.which==13)
      {
         $.ajax({
            type: "POST",
            url: site_url+"cif/get_branch_by_keyword",
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

         $.ajax({
          type:"POST",dataType:"json",
          data:{
            branch_code:result_code
          },url:site_url+'laporan/get_peutgas_by_branch_code',
          success:function(response){
            html='<option value="">Silahkan Pilih</option>';
            for (i in response) {
              html+='<option value="'+response[i].fa_code+'">'+response[i].fa_name+'</option>';
            }
            $("#petugas").html(html).trigger('liszt:updated');
          }
         })
      }
	  search_majelis();
   });
   
  $("#result option:selected","#dialog_branch").live('dblclick',function(){
    $("#select","#dialog_branch").trigger('click');
  })

   /* END DIALOG ACTION BRANCH */

   $("#filter").click(function(e){
      e.preventDefault();
      $.ajax({
         type: "POST",
         dataType: "json",
         url: site_url+"laporan/get_gl_rekap_transaksi",
         data: {
            branch_code : $("#branch_code").val(),
            from_date : $("#from_date").val(),
            thru_date : $("#thru_date").val()
         },
         success: function(response){
            html = '';
            for(i = 0 ; i < response['data'].length ; i++)
            {
               html += '<tr> \
                  <td align="center">'+response['data'][i].nomor+'</td> \
                  <td>'+response['data'][i].account+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_awal,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].debit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].credit,2,',','.')+'</td> \
                  <td align="right" style="font-size:14px;">'+number_format(response['data'][i].saldo_akhir,2,',','.')+'</td> \
               </tr>';
            }
            $("#total_debit").html(number_format(response['total_debit'],2,',','.'));
            $("#total_credit").html(number_format(response['total_credit'],2,',','.'));
            $("tbody","table#general_ledger ").html(html);
         }
      })
   });


  $("#previewpdf").click(function(e){
    e.preventDefault();
    var branch_code = $("#branch_code").val();
    var branch = $("#branch").val();
	  var majelis = $("#majelis").val();
    var hari = $("#hari_transaksi").val();
    var fa_code = $("#petugas").val();
    var tanggal = $("#tanggal").val();
    var bValid=true;
    if (branch_code=="") {
      $("#branch_code").addClass('error');
      bValid=false;
    } else{
      $("#branch_code").removeClass('error');
    }
    if (fa_code=="") {
      $("#petugas").addClass('error');
      bValid=false;
    } else{
      $("#petugas").removeClass('error');
    }
    if (hari=="") {
      $("#hari_transaksi").addClass('error');
      bValid=false;
    } else{
      $("#hari_transaksi").removeClass('error');
    }
    if (majelis=="") {
      $("#majelis").addClass('error');
      bValid=false;
    } else{
      $("#majelis").removeClass('error');
    }


    if(bValid==true) {
      window.open(site_url+'laporan_to_pdf/rekap_trx_rembug/'+branch_code+'/'+fa_code+'/'+hari+'/'+tanggal+'/'+branch+'/'+majelis);
    } else {
      alert("Please fill an empty field.")
    }
  })

/* END SCRIPT */
})
</script>