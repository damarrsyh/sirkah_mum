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
			Dashboard
		</h3>
		<ul class="breadcrumb">
			<li>
				<i class="icon-home"></i>
				<a href="index.html">Home</a>
				<i class="icon-angle-right"></i>
			</li>
			<li><a href="#">Dashboard</a></li>
		</ul>
		<!-- END PAGE TITLE & BREADCRUMB-->
	</div>
</div>
<!-- END PAGE HEADER-->
<div id="dashboard">
	<!-- PORTFOLIO CABANG -->
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box blue">
					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-sitemap" style="font-size: 19px;"></i> 
							<span style="font-size:18px; color:white;">Total Cabang :</span> 
							<span style="font-size:26px; color:white;"><?php echo count($cabang); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex1"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartBranch"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box blue">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-group" style="font-size: 17px;"></i> 
							<span style="font-size:18px; color:white;">Total Anggota :</span> 
							<span style="font-size:26px; color:white;"><?php echo number_format($anggota['num'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex2"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartMember"></div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box blue">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-home" style="font-size: 18px;"></i> 
							<span style="font-size:18px; color:white;">Total Rembug :</span> 
							<span style="font-size:26px; color:white;"><?php echo number_format($rembug['num'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex3"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartRembug"></div>
						</div>
					</div>

				</div>
			</div>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box blue">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-user" style="font-size: 18px;"></i> 
							<span style="font-size:18px; color:white;">Total Petugas :</span> 
							<span style="font-size:26px; color:white;"><?php echo number_format($petugas['num'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex4"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartFa"></div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<!-- END PORTFOLIO CABANG -->
	<hr style="border: solid #4b8df8 1px;" />
	<!-- BEGIN PORTFOLIO SIMPANAN -->
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box green">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-money" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Total Simpok :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($simwapoksuk['total_simpok'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex5"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSimpok"></div>
						</div>
					</div>

					<!--

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption">Total Simpok : <?php echo number_format($simwapoksuk['total_simpok'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex5"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSimpok"></div>
						</div>
					</div>
					-->

				</div>
			</div>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box green">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-money" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Total Simwa :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($simwapoksuk['total_simwa'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex6"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSimwa"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 15px;">
						<div class="caption">Total Simwa : <?php echo number_format($simwapoksuk['total_simwa'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex6"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSimwa"></div>
						</div>
					</div>
					-->

				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box green"> 

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-money" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Total Sukarela :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($simwapoksuk['total_sukarela'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex7"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSukarela"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 15px;">
						<div class="caption">Total Sukarela : <?php echo number_format($simwapoksuk['total_sukarela'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex7"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartSukarela"></div>
						</div>
					</div> 
					-->

				</div>
			</div>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box green"> 

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-money" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Total DTK :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($dtk['saldo_taber'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex8"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartDtk"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="font-size: 24px;">Total DTK : <?php echo number_format($dtk['saldo_taber'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex8"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartDtk"></div>
						</div>
					</div>
					-->

				</div>
			</div>
		</div>
		<div class="row-fluid">
			<div class="span12 responsive" data-tablet="span12 fix-offset" data-desktop="span12">
				<div class="portlet box green">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-money" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Total Taber :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($taber['saldo_taber'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex9"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartTaber"></div>
						</div>
					</div>

					<!--

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="font-size: 24px;">Total Taber : <?php echo number_format($taber['saldo_taber'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex9"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartTaber"></div>
						</div>
					</div>
					-->

				</div>
			</div>
		</div>
	</div>
	<!-- END PORTFOLIO SIMPANAN -->
	<hr style="border: solid #35aa47 1px;" />
	<!-- BEGIN PORTFOLIO PEMBIAYAAN -->
	<div class="row-fluid">
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box purple">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-book" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Disbursement :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($disbursement['disbursement'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex10"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartDisbursement"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 10px;">
						<div class="caption" style="font-size: 20px;">Total Disbursement : <?php echo number_format($disbursement['disbursement'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex10"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartDisbursement"></div>
						</div>
					</div>
					-->

				</div>
			</div>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box purple"> 

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-book" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Outstanding :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($outstanding['outstanding'], 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex11"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartOutstanding"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 10px;">
						<div class="caption" style="font-size: 20px;">Total Outstanding : <?php echo number_format($outstanding['outstanding'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex11"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartOutstanding"></div>
						</div>
					</div>
					-->

				</div>
			</div>
		</div>
		<input type="hidden" id="tanggal_par" value="<?= $tanggal_par; ?>">
		<div class="row-fluid">
			<?php if ($tanggal_par != NULL) { ?>
				<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
					<div class="portlet box purple">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-book" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;">Portofolio at Risk (PAR) :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format(($par_10up['saldo_pokok'] / $par_all['saldo_pokok']) * 100, 2, ',', '.') . '%'; ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex12"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartPar"></div>
						</div>
					</div>

					<!--
						<div class="portlet-title" style="padding: 10px;">
							<div class="caption" style="font-size: 20px;">Total Par <?= $tanggal_par; ?> : <?php echo number_format(($par_10up['saldo_pokok'] / $par_all['saldo_pokok']) * 100, 2, ',', '.') . '%'; ?> </div>
							<div class="tools">
								<a href="javascript:;" class="expand" id="colex12"></a>
							</div>
						</div>
						<div class="portlet-body" style="display:none;">
							<div class="clearfix" style="overflow:hidden;">
								<div id="chartPar"></div>
							</div>
						</div>
					-->
						
					</div>
				</div>
			<?php } ?>
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box purple">

					<div class="portlet-title" style="padding: 15px;">
						<div class="caption" style="float: right !important;">
							<i class="icon-book" style="font-size: 18px;"></i> 
							<span style="font-size:16px; color:white;"> S H U :</span> 
							<span style="font-size:22px; color:white;"><?php echo number_format($shu, 0, ',', '.'); ?></span> 
						</div>
						<div class="tools" style="float: left !important;">
							<a href="javascript:;" class="expand" id="colex13"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartShu"></div>
						</div>
					</div>

					<!--
					<div class="portlet-title" style="padding: 10px;">
						<div class="caption" style="font-size: 20px;">Total SHU : <?php echo number_format($shu, 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="expand" id="colex13"></a>
						</div>
					</div>
					<div class="portlet-body" style="display:none;">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chartShu"></div>
						</div>
					</div>
	     			-->

				</div>
			</div>
		</div>
	</div>
	<!-- END PORTFOLIO PEMBIAYAAN -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php $this->load->view('_jscore'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
	$(document).ready(function() {
		App.init();

		$('#colex1').click(function() {
			getBranch();
		});

		$('#colex2').click(function() {
			getMember();
		});

		$('#colex3').click(function() {
			getRembug();
		});

		$('#colex4').click(function() {
			getFa();
		});

		$('#colex5').click(function() {
			getSimpok();
		});

		$('#colex6').click(function() {
			getSimwa();
		});

		$('#colex7').click(function() {
			getSukarela();
		});

		$('#colex8').click(function() {
			getDtk();
		});

		$('#colex9').click(function() {
			getTaber();
		});

		$('#colex10').click(function() {
			getDisbursement();
		});

		$('#colex11').click(function() {
			getOutstanding();
		});

		$('#colex12').click(function() {
			getPar();
		});

		$('#colex13').click(function() {
			getShu();
		});
	});

	function getBranch() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartBranch);

		function chartBranch() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_branch',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartBranch'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getFa() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartFa);

		function chartFa() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_fa',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartFa'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getMember() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartMember);

		function chartMember() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_branch',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartMember'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getRembug() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartRembug);

		function chartRembug() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_rembug',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartRembug'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getSimwa() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartSimwa);

		function chartSimwa() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_simwa',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartSimwa'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getSimpok() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartSimpok);

		function chartSimpok() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_simpok',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartSimpok'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getSukarela() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartSukarela);

		function chartSukarela() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_sukarela',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartSukarela'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getDtk() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartDtk);

		function chartDtk() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_dtk',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartDtk'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getTaber() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartTaber);

		function chartTaber() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_taber',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartTaber'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getDisbursement() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartDisbursement);

		function chartDisbursement() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_disbursement',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartDisbursement'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getOutstanding() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartOutstanding);

		function chartOutstanding() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_outstanding',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartOutstanding'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getPar() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartPar);

		function chartPar() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_par',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = k.persen;

					dataTable.addRows([
						[product_name + ' ' + persen + '%', nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartPar'));

				chart.draw(dataTable, options);
			});
		}
	}

	function getShu() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});

		google.charts.setOnLoadCallback(chartShu);

		function chartShu() {
			let jsonData = $.ajax({
				url: site_url + 'dashboard/chart_shu',
				method: 'get',
				dataType: 'json',
				beforeSend: function() {

				}
			}).done(function(res) {
				console.log(res);

				var dataTable = new google.visualization.DataTable();

				dataTable.addColumn('string', 'Cabang');
				dataTable.addColumn('number', 'Jumlah');
				dataTable.addColumn({
					type: 'string',
					role: 'style'
				});

				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];

				let no = 0;

				$.each(res, function(i, k) {
					let product_name = k.product_name;
					let nominal = parseInt(k.nominal);
					let persen = '';

					dataTable.addRows([
						[product_name + persen, nominal, 'color:' + warna[no] + ';opacity:1']
					]);
					no++;
				});

				var options = {
					height: 400,
					legend: {
						position: 'top'
					},
					orientation: 'horizontal'
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chartShu'));

				chart.draw(dataTable, options);
			});
		}
	}
</script>

<!-- END JAVASCRIPT -->