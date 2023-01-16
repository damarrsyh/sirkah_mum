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
      Verifikasi Perpanjangan Tabber<small> Verifikasi Perpanjangan Tabber</small>
    </h3>
    <ul class="breadcrumb">
      <li>
        <i class="icon-home"></i>
        <a href="<?php echo site_url('dashboard'); ?>">Home</a> 
        <i class="icon-angle-right"></i>
      </li>
         <li><a href="#">Rekening Nasabah</a><i class="icon-angle-right"></i></li>
      <li><a href="#">Verifikasi Perpanjangan Tabber</a></li>
    </ul>
      <!-- END PAGE TITLE & BREADCRUMB-->
   </div>
</div>
<!-- END PAGE HEADER-->




<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Verifikasi Perpanjangan Tabber</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>
   <div class="portlet-body">
      <div class="clearfix">
      </div>

     
      <p>
      <table class="table table-striped table-bordered table-hover" id="pelunasan_pembiayaan_table">
         <thead>
            <tr>
               <th width="40%">No. Rekening</th>
               <th width="40%">Nama</th>
               <th>Verifikasi</th>
            </tr>
         </thead>
         <tbody>
            
         </tbody>
      </table>
   </div>
</div>
<!-- END EXAMPLE TABLE PORTLET-->

<!-- BEGIN EDIT USER -->
<div id="edit" class="hide">
   
   <div class="portlet box purple">
      <div class="portlet-title">
         <div class="caption"><i class="icon-reorder"></i>Verifikasi Data Pelunasan Pembiayaan</div>
         <div class="tools">
            <a href="javascript:;" class="collapse"></a>
         </div>
      </div>
      <div class="portlet-body form">
         <!-- BEGIN FORM-->
         <form action="#" id="form_edit" class="form-horizontal">
            <input type="hidden" id="account_saving_no" name="account_saving_no">
            <div class="alert alert-error hide">
               <button class="close" data-dismiss="alert"></button>
               You have some form errors. Please check below.
            </div>
            <div class="alert alert-success hide">
               <button class="close" data-dismiss="alert"></button>
               Verifikasi Pelunasan Pembiayaan Berhasil Di Proses !
            </div>

            <br>
            <div class="control-group">
                       <label class="control-label">Nama Lengkap</label>
                       <div class="controls">
                          <input type="text" name="nama" id="nama" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Majlis</label>
                       <div class="controls">
                          <input type="text" name="majlis" id="majlis" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Nama Panggilan</label>
                       <div class="controls">
                          <input type="text" name="panggilan" id="panggilan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                       
                    <div class="control-group">
                       <label class="control-label">Nama Ibu Kandung</label>
                       <div class="controls">
                          <input type="text" name="ibu_kandung" id="ibu_kandung" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                    
                    <div class="control-group">
                       <label class="control-label">Tempat Lahir</label>
                       <div class="controls">
                          <input type="text" name="tmp_lahir" id="tmp_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                 
                    <div class="control-group">
                       <label class="control-label">Tanggal Lahir</label>
                       <div class="controls">
                          <input type="text" name="tgl_lahir" id="tgl_lahir" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                       </div>
                    </div>                
                    <div class="control-group">
                       <label class="control-label">Produk</label>
                       <div class="controls">
                       <input type="text" class="medium m-wrap" readonly="" id="product" name="product" style="background-color:#eee;" >
                       </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label">Biaya Administrasi</label>
                      <div class="controls">
                        <div class="input-preppend input-append">
                          <div class="add-on">Rp</div>
                          <input type="text" class="mask-money m-wrap small" readonly="" id="biaya_administrasi" name="biaya_administrasi" style="background-color:#eee;" >
                          <div class="add-on">,00</div>
                        </div>
                      </div>
                    </div>
                   
                    <hr> 
                  <div id="tabungan_berencana">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Tabungan Berencana</label>
                    </div>     
                    <div class="control-group">
                       <label class="control-label">Setoran</label>
                       <div class="controls">
                          <div class="input-prepend input-append">
                             <span class="add-on">Rp</span>
                             <input type="text" name="rencana_setoran" style="width:120px; background-color:#eee;" id="rencana_setoran" data-required="1" readonly="" class="m-wrap mask-money" maxlength="10"/>
                             <span class="add-on">,00</span>
                           </div>
                       </div>
                    </div>   
                    <div class="control-group">
                       <label class="control-label">Periode Setoran</label>
                       <div class="controls">
                          <select id="rencana_periode_setoran" name="rencana_periode_setoran" class="m-wrap" data-required="1" style="width:120px;background-color:#f5f5f5;" disabled="disabled">
                              <option value="0" disabled>Bulanan</option>
                              <option value="1" disabled>Mingguan</option>
                              <option value="2" disabled>Harian</option>
                          </select>
                      
                       </div>
                    </div>  
                    <div class="control-group">
                       <label class="control-label">Rencana Awal Setoran</label>
                       <div class="controls">
                          <input type="text" name="rencana_setoran_next" id="rencana_setoran_next" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                          
                       </div>
                    </div> 
                    <div class="control-group">
                       <label class="control-label">Tanggal Pembukaan</label>
                       <div class="controls">
                          <input type="text" name="tanggal_pembukaan" id="tanggal_pembukaan" data-required="1" class="medium m-wrap" readonly="" style="background-color:#eee;"/>
                      </div>
                    </div> 
                    
                  </div>
                  <hr>
                  <!-- START PERPANJANGAN TABBER -->
                  <div id="tabungan_berencana2">   
                    <div class="control-group">
                       <label class="control-label" style="text-decoration:underline">Perpanjang Tabber</label>
                    </div>     
                   
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Awal</label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu" style="width:50px;background-color:#eee;" id="rencana_jangka_waktu" data-required="1" class="m-wrap"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="" />

                       </div>
                    </div>  

                    <div class="control-group">
                       <label class="control-label">Perpanjangan J Waktu</label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu2"  style="width:50px;background-color:#eee;" id="rencana_jangka_waktu2" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="readonly" />

                       </div>
                    </div>
                    <div class="control-group">
                       <label class="control-label">Jangka Waktu Akhir</label>
                       <div class="controls">
                          <input type="text" name="rencana_jangka_waktu_akhir2"  style="width:50px;background-color:#eee;" id="rencana_jangka_waktu_akhir2" data-required="1" class="m-wrap" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')" maxlength="3" readonly="" />

                       </div>
                    </div>  
           <div class="control-group">
                       <label class="control-label">Tanggal Perpanjangan</label>
                       <div class="controls">
                          <input type="text" name="tanggal_perpanjangan" style="width:120px;background-color:#eee;" id="tanggal_perpanjangan" data-required="1" readonly="" class="m-wrap"/>
                       </div>
                    </div> 
            <div class="form-actions">
               <button type="button" id="btn_reject" class="btn red">Reject</button>
               <button type="submit" class="btn purple">Approve</button>
               <button type="button" class="btn" id="cancel">Back</button>
            </div>
         </form>
         <!-- END FORM-->
      </div>
   </div>

</div>
<!-- END EDIT REMBUG -->





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

<!-- JAVASCRIPT LAINNYA (DEVELOP) -->
<script type="text/javascript">
$('#t_cash').hide();
$('#t_pinbuk').hide();

      // fungsi untuk reload data table
      // di dalam fungsi ini ada variable tbl_id
      // gantilah value dari tbl_id ini sesuai dengan element nya
      var dTreload = function()
      {
        var tbl_id = 'pelunasan_pembiayaan_table';
        $("select[name='"+tbl_id+"_length']").trigger('change');
        $(".paging_bootstrap li:first a").trigger('click');
        $("#"+tbl_id+"_filter input").val('').trigger('keyup');
      }

      // BEGIN FORM EDIT USER VALIDATION
      var form2 = $('#form_edit');
      var error2 = $('.alert-error', form2);
      var success2 = $('.alert-success', form2);

      $('a#link-edit').live('click',function(){
		  $('#wrapper-table').hide();
		  $('#edit').show();

		  var account_saving_no = $(this).attr('account_saving_no');

		  $.ajax({
			  type: 'POST',
			  dataType: 'json',
			  data: {rekening:account_saving_no},
			  url: site_url+'rekening_nasabah/search_rekening_tabungan',
			  success: function(response){
				  var account_no = response.account_saving_no;
				  var nama = response.nama;
				  var majelis = response.majelis;
				  var ibu_kandung = response.ibu_kandung;
				  var tmp_lahir = response.tmp_lahir;
				  var tgl_lahir = response.tgl_lahir;
				  var product_name = response.product_name;
				  var biaya_administrasi = response.biaya_administrasi;
				  var rencana_setoran = response.rencana_setoran;
				  var rencana_periode_setoran = response.rencana_periode_setoran;
				  var rencana_setoran_next = response.rencana_setoran_next;
				  var tanggal_buka = response.tanggal_buka;
				  var rencana_jangka_waktu = response.rencana_jangka_waktu;
				  var counter_angsruan = response.counter_angsruan;
				  var rencana_jangka_waktu_akhir = response.rencana_jangka_waktu_akhir;
				  var tanggal_perpanjangan = response.tanggal_perpanjangan;
				  var rencana_jangka_waktu2 = response.rencana_jangka_waktu2;

				  $('#account_saving_no').val(account_no);
				  $("#nama").val(response.nama);
				  $('#majlis').val(majelis);
				  $('#panggilan').val(nama);
				  $('#ibu_kandung').val(ibu_kandung);
				  $('#tmp_lahir').val(tmp_lahir);
				  $('#tgl_lahir').val(tgl_lahir);
				  $('#product').val(response.product_name);
				  $('#biaya_administrasi').val(biaya_administrasi);
				  $('#rencana_setoran').val(rencana_setoran);
				  $('#rencana_periode_setoran').val(rencana_periode_setoran);
				  $('#rencana_setoran_next').val(rencana_setoran_next);
				  $('#tanggal_pembukaan').val(tanggal_buka);
				  $('#rencana_jangka_waktu').val(rencana_jangka_waktu);
				  $('#counter_angsruan').val(counter_angsruan);
				  $('#rencana_jangka_waktu_akhir2').val(rencana_jangka_waktu_akhir);
				  $('#rencana_jangka_waktu2').val(rencana_jangka_waktu2);
				  $('#tanggal_perpanjangan').val(tanggal_perpanjangan);
			  }
		  });
	  });

      form2.validate({
          errorElement: 'span', //default input error message container
          errorClass: 'help-inline', // default input error message class
          focusInvalid: false, // do not focus the last invalid input
          ignore: "",
          rules: {
              potongan_margin: {
                  required: true
              }
          },
         submitHandler: function (form){
			 $.ajax({
				 type: 'POST',
				 url: site_url+'transaction/verif_perpanjang_tabber',
				 async: true,
				 dataType: 'json',
				 data: form2.serialize(),
				 success: function(response){
					 if(response.success == true){
						 alert(response.message);
						 $('div.control-group').removeClass('success');
						 $('span.help-inline').removeClass('ok');
						 $('#cancel',form_edit).trigger('click')
						 dTreload();
					 }else{
						 alert(response.message);
						 success2.hide();
						 error2.show();
					 }

					 App.scrollTo(error2, -200);
				 },
				 error:function(){
					 success2.hide();
					 error2.show();
					 App.scrollTo(error2, -200);
				 }
        });
      }
      });

      // event untuk kembali ke tampilan data table (EDIT FORM)
      $("#cancel","#form_edit").click(function(){
        success2.hide();
        error2.hide();
        $("#edit").hide();
        $("#wrapper-table").show();
        dTreload();
      });

    $("#btn_reject").click(function(){
		var account_financing_lunas_id = $("#account_financing_lunas_id").val();
		var no_pembiayaan = $("#no_pembiayaan").val();

		var conf = confirm('Are you sure to Reject ?');

		if(conf){
			$.ajax({
				url: site_url+"transaction/reject_data_perpanjangan_tabber",
				type: "POST",
				dataType: "json",
				data: form2.serialize(),
				success: function(response){
					if(response.success==true){
						alert("Reject!");
						$("#cancel","#form_edit").trigger('click');
					} else {
						alert("Reject Failed!");
					}
				},
				error: function(){
					alert("Failed to Connect into Database, Please Check ur Connection or Try Again Latter")
				}
			})
		}
	});


      $('#pelunasan_pembiayaan_table').dataTable({
          "bProcessing": true,
          "bServerSide": true,
          "sAjaxSource": site_url+"transaction/datatable_perpanjangan",
          "aoColumns": [
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
      
      // $("#select").click(function(){
      //    result = $("#result").val();
      //    if(result != null)
      //    {
      //       $("#add_cm_code").val(result);
      //       $("#edit_cm_code").val(result);
      //       $("#cm_code").val(result);
      //       $("#rembug_pusat").val($("#result option:selected").attr('cm_name'));
      //       $("span.rembug").text('"'+$("#result option:selected").attr('cm_name')+'"');
      //       $("#close","#dialog_rembug").trigger('click');

      //       // begin first table
      //       $('#pelunasan_pembiayaan_table').dataTable({
      //          "bDestroy":true,
      //          "bProcessing": true,
      //          "bServerSide": true,
      //          "sAjaxSource": site_url+"rekening_nasabah/datatable_verifikasi_pelunasan_pembiayaan",
      //          "fnServerParams": function ( aoData ) {
      //               aoData.push( { "name": "cm_code", "value": $("#cm_code").val() } );
      //           },
      //          "aoColumns": [
      //             null,
      //             null,
      //             null,
      //             null,
      //             null,
      //             { "bSortable": false }
      //          ],
      //           "aLengthMenu": [
      //               [15, 30, 45, -1],
      //               [15, 30, 45, "All"] // change per page values here
      //           ],
      //           // set the initial value
      //           "iDisplayLength": 15,
      //          "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
      //          "sPaginationType": "bootstrap",
      //          "oLanguage": {
      //              "sLengthMenu": "_MENU_ records per page",
      //              "oPaginate": {
      //                  "sPrevious": "Prev",
      //                  "sNext": "Next"
      //              }
      //          },
      //          "sZeroRecords" : "Data Pada Rembug ini Kosong",
      //          "aoColumnDefs": [{
      //                  'bSortable': false,
      //                  'aTargets': [0]
      //              }
      //          ]
      //       });
      //       // $(".dataTables_length,.dataTables_filter").parent().hide();


      //    }
      //    else
      //    {
      //       alert("Please select row first !");
      //    }

      // });

      // $("#result option:selected").live('dblclick',function(){
      //   $("#select").trigger('click');
      // });

      // $("#result option").live('dblclick',function(){
      //    $("#select").trigger('click');
      // });
   
      // $("select[name='branch']","#dialog_rembug").change(function(){
      //    keyword = $("#keyword","#dialog_rembug").val();
      //    var branch = $("select[name='branch']","#dialog_rembug").val();
      //    $.ajax({
      //       type: "POST",
      //       url: site_url+"cif/get_rembug_by_keyword",
      //       dataType: "json",
      //       data: {keyword:keyword,branch_id:branch},
      //       success: function(response){
      //          html = '';
      //          for ( i = 0 ; i < response.length ; i++ )
      //          {
      //             html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
      //          }
      //          $("#result").html(html);
      //       }
      //    })
      // })

      // $("#keyword","#dialog_rembug").keypress(function(e){
      //    keyword = $(this).val();
      //    if(e.which==13){
      //       var branch = $("select[name='branch']","#dialog_rembug").val();
      //       $.ajax({
      //          type: "POST",
      //          url: site_url+"cif/get_rembug_by_keyword",
      //          dataType: "json",
      //          data: {keyword:keyword,branch_id:branch},
      //          success: function(response){
      //             html = '';
      //             for ( i = 0 ; i < response.length ; i++ )
      //             {
      //                html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
      //             }
      //             $("#result").html(html);
      //          }
      //       })
      //    }
      // });

      // $("#browse_rembug").click(function(){
      //    keyword = $("#keyword","#dialog_rembug").val();
      //    branch = $("select[name='branch']","#dialog_rembug").val();
      //    $.ajax({
      //          type: "POST",
      //          url: site_url+"cif/get_rembug_by_keyword",
      //          dataType: "json",
      //          data: {keyword:keyword,branch_id:branch},
      //          success: function(response){
      //             html = '';
      //             for ( i = 0 ; i < response.length ; i++ )
      //             {
      //                html += '<option value="'+response[i].cm_code+'" cm_name="'+response[i].cm_name+'">'+response[i].cm_code+' - '+response[i].cm_name+'</option>';
      //             }
      //             $("#result").html(html);
      //          }
      //       })
      // });


      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_filter input').addClass("m-wrap medium"); // modify table search input
      jQuery('#pelunasan_pembiayaan_table_wrapper .dataTables_length select').addClass("m-wrap small"); // modify table per page dropdown
      //jQuery('#sample_1_wrapper .dataTables_length select').select2(); // initialzie select2 dropdown

</script>

<!-- END JAVASCRIPTS -->
