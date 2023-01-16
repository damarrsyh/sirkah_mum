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
        DISTRIBUSI
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

<!-- BEGIN EXAMPLE TABLE PORTLET-->
<div class="portlet box blue" id="wrapper-table">
   <div class="portlet-title">
      <div class="caption"><i class="icon-globe"></i>Distribusi SHU</div>
      <div class="tools">
         <a href="javascript:;" class="collapse"></a>
      </div>
   </div>

   <div class="portlet-body">
      <div class="clearfix">
         <!-- BEGIN FILTER FORM -->
         <?php echo $this->session->flashdata('notification'); ?>
        <form action="javascript:;" method="post" id="form_shu">
          <table id="filter-form">
              <tr width="400">
                <td>Total Pendapatan Tahun <?php echo date('Y') - 1; ?></td>
                <td><input name="total_margin" type="text" class="m-wrap medium" id="total_margin" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <tr>
                <td>Total Modal Tahun <?php echo date('Y') - 1; ?></td>
                <td><input name="total_modal" type="text" class="m-wrap medium" id="total_modal" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
             <tr>
             	<td>SHU Tahun <?php echo date('Y') - 1; ?></td>
                <td><input name="shu_tahun" type="text" class="m-wrap medium" id="shu_tahun" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <tr>
                <td>SHU dibagi untuk Anggota (30% x SHU)</td>
                <td><input name="shu_anggota" type="text" class="m-wrap medium" id="shu_anggota" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <?php
			  if(isset($cek['shu_anggota_real'])){
				  $readonly = ' readonly="readonly"';
				  $picker = ' date-picker';
			  } else {
				  $readonly = '';
				  $picker = '';
			  }
			  ?>
              <tr>
                <td>SHU dibagi untuk Anggota Real</td>
                <td><input name="shu_anggota_real" type="text" class="m-wrap medium mask-money" id="shu_anggota_real" style="text-align:right;"<?php echo $readonly; ?> /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                 <td>Porsi SHU dibagi berdasarkan Transaksi (70%)</td>
                 <td><input name="shu_transaksi" type="text" class="m-wrap medium" id="shu_transaksi" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <tr>
                <td>Porsi SHU dibagi berdasarkan Modal (30%)</td>
                <td><input name="shu_modal" type="text" class="m-wrap medium" id="shu_modal" readonly="readonly" style="background:#eee; text-align:right;" /></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Tanggal Transaksi</td>
                <td><input name="tanggal" type="text" class="m-wrap medium<?php echo $picker; ?>" id="tanggal"<?php echo $readonly; ?> /></td>
              </tr>
             <tr>
           	   <td>Distribusi Untuk Cabang</td>
                <td><input name="branch_name" type="text" class="m-wrap medium" id="branch_name" readonly="readonly" style="background:#eee;" value="<?php echo $this->session->userdata('branch_name'); ?>">
                <input type="hidden" name="branch_code" id="branch_code" value="<?php echo $this->session->userdata('branch_code') ?>">
                <input type="hidden" name="branch_id" id="branch_id" value="<?php echo $this->session->userdata('branch_id') ?>">
                <?php if($this->session->userdata('flag_all_branch')){ ?>
                <a id="browse_branch" class="btn blue" data-toggle="modal" href="#dialog_branch">...</a>
                <?php } ?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input name="distribusi" type="button" class="green btn" id="distribusi" value="Distribusi" style="width:83%;" /></td>
              </tr>
           </table>
         </form>
          <!-- END FILTER-->
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
<script type="text/javascript">
$(document).ready(function(){
	App.init();
	$('input#mask_date,.mask_date').livequery(function(){
		$(this).inputmask('d/m/y');
	});

	var tahun = '<?php echo date('Y'); ?>';
	var cabang = $('#branch_code').val();
	var form_shu = $('#form_shu');
	var calculate_shu = function(cabang){
		$.ajax({
			type: 'POST',
			url: site_url+'sys/calculate_distribusi_shu',
			dataType: 'json',
			data: {
				branch_code:cabang,
				tahun:tahun
			},
			success: function(response){
				var shu_tahun = response.shu_tahun;
				var shu_anggota = response.shu_anggota;
				var shu_transaksi = response.shu_transaksi;
				var shu_modal = response.shu_modal;
				var total_margin = response.total_margin;
				var total_modal = response.total_modal;
				var tanggal_transaksi = response.tanggal_transaksi;
				var shu_anggota_real = response.shu_anggota_real;
	
				$('#shu_tahun').val(shu_tahun);
				$('#shu_anggota').val(shu_anggota);
				$('#shu_anggota_real').val(shu_anggota_real);
				$('#shu_transaksi').val(shu_transaksi);
				$('#shu_modal').val(shu_modal);
				$('#total_margin').val(total_margin);
				$('#total_modal').val(total_modal);
				$('#tanggal_transaksi').val(tanggal_transaksi);
			},
			error: function(){
				$.alert({
					title: 'Astagfirullah',
					icon: 'icon-warning-sign',
					backgroundDismiss: false,
					content: 'Koneksi Terputus',
					confirmButtonClass: 'btn yellow',
					animation:'zoom'
				});
			}
		});
	}

	calculate_shu(cabang);

	$('#shu_anggota_real').keyup(function(){
		var sar = $(this).val();
		var st = $('#shu_transaksi');
		var sm = $('#shu_modal');

		sar = convert_numeric(sar);

		var shu_transaksi = (sar * 70) / 100;
		var shu_modal = (sar * 30) / 100;

		shu_transaksi = number_format(shu_transaksi,0,',','.');
		shu_modal = number_format(shu_modal,0,',','.');

		st.val(shu_transaksi);
		sm.val(shu_modal);
	});

	$('#browse_branch').click(function(){
		$.ajax({
			type: 'POST',
			url: site_url+'cif/search_cabang_shu',
			dataType: 'json',
			data: {keyword:$('#keyword','#dialog_branch').val()},
			success: function(response){
				var html = '';
				for(i = 0; i < response.length; i++){
					html += '<option value="'+response[i].branch_code+'"branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
				}

				$('#result','#dialog_branch').html(html);
			}
		});
	});

	$('#keyword','#dialog_branch').keyup(function(e){
		e.preventDefault();
		var keyword = $(this).val();

		if(e.which == '13'){
			$.ajax({
				type: 'POST',
				url: site_url+'cif/search_cabang_shu',
				dataType: 'json',
				data: {keyword:keyword},
				success: function(response){
					var html = '';
					for(i = 0; i < response.length; i++){
						html += '<option value="'+response[i].branch_code+'" branch_name="'+response[i].branch_name+'">'+response[i].branch_code+' - '+response[i].branch_name+'</option>';
					}

					$('#result','#dialog_branch').html(html);
				}
			});
		}
	});

	$('#select','#dialog_branch').click(function(){
		var branch_id = $('#result option:selected','#dialog_branch').attr('branch_id');
		var result_name = $('#result option:selected','#dialog_branch').attr('branch_name');
		var result_code = $('#result','#dialog_branch').val();

		if(result != null){
			$('#branch_name').val(result_name);
			$('#branch_code').val(result_code);
			$('#branch_id').val(branch_id);
			$('#close','#dialog_branch').trigger('click');
		}
	});

	$('#result option:selected','#dialog_branch').live('dblclick',function(){
		$('#select','#dialog_branch').trigger('click');
	});

	$('#distribusi').click(function(){
		var branch_code = $('#branch_code').val();
		var total_margin = $('#total_margin').val();
		var shu_transaksi = $('#shu_transaksi').val();
		var total_modal = $('#total_modal').val();
		var shu_modal = $('#shu_modal').val();
		var tanggal = $('#tanggal').val();
		var tanggal = datepicker_replace(tanggal);
		var conf = true;

		if(tanggal == ''){
			$.alert({
				title: 'Astagfirullah',
				icon: 'icon-warning-sign',
				backgroundDismiss: false,
				content: 'Tanggal belum diisi',
				confirmButtonClass: 'btn yellow',
				animation:'zoom'
			});
			var conf = false;
		}

		if(conf == true){
			$.ajax({
				type: 'POST',
				url: site_url+'sys/proses_distribusi_shu',
				dataType: 'json',
				data: form_shu.serialize(),
				success: function(response){
					var hasil = response.hasil;
					var pesan = response.pesan;
	
					if(hasil == true){
						$.alert({
							title: 'Alhamdulillah',
							icon: 'icon-check',
							backgroundDismiss: false,
							content: pesan,
							confirmButtonClass: 'btn green',
							confirm: function(){
								window.location = site_url+'sys/distribusi_shu';
							}
						});
					} else {
						$.alert({
							title: 'Astagfirullah',
							icon: 'icon-warning-sign',
							backgroundDismiss: false,
							content: pesan,
							confirmButtonClass: 'btn yellow',
							animation:'zoom'
						});
					}
				},
				error: function(){
					$.alert({
						title: 'Astagfirullah',
						icon: 'icon-warning-sign',
						backgroundDismiss: false,
						content: 'Koneksi Terputus',
						confirmButtonClass: 'btn yellow',
						animation:'zoom'
					});
				}
			});
		}
	});
});
</script>
<!-- END JAVASCRIPTS -->
