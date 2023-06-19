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
	<!-- BEGIN DASHBOARD STATS -->
	<div class="row-fluid">
		<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
			<div class="dashboard-stat blue">
				<div class="visual">
					<i class="icon-user"></i>
				</div>
				<div class="details">
					<div class="number"><?php echo $petugas['num']; ?></div>
					<div class="desc">
						Petugas
					</div>
				</div>
				<a class="more" href="#">
					Detail Petugas <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
			<div class="dashboard-stat green">
				<div class="visual">
					<i class="icon-user"></i>
				</div>
				<div class="details">
					<div class="number"><?php echo $anggota['num']; ?></div>
					<div class="desc">Anggota Aktif</div>
				</div>
				<a class="more" href="#">
					Detail Anggota <i class="m-icon-swapright m-icon-white"></i>
				</a>
			</div>
		</div>
		<?php
		if ($this->session->userdata('cif_type') == "2" || $this->session->userdata('cif_type') == "0") {
		?>
			<div class="span3 responsive" data-tablet="span6 fix-offset" data-desktop="span3">
				<div class="dashboard-stat purple">
					<div class="visual">
						<i class="icon-user"></i>
					</div>
					<div class="details">
						<div class="number"><?php echo $rembug['num']; ?></div>
						<div class="desc">Rembug Pusat</div>
					</div>
					<a class="more" href="#">
						Detail Rembug <i class="m-icon-swapright m-icon-white"></i>
					</a>
				</div>
			</div>
		<?php } ?>
		<div class="row-fluid">
			<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
				<div class="portlet box green">
					<div class="portlet-title">
						<div class="caption"><i class="icon-money"></i>Outstanding Pembiayaan : <?php echo number_format($outstanding['outstanding'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>
					<div class="portlet-body">
						<div class="clearfix" style="overflow:hidden;">
							<div id="chart_div"></div>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" id="tanggal_par" value="<?= $tanggal_par; ?>">
			<?php
			if ($tanggal_par != NULL) {
				///$PAR==$par_10up/$par_all * 100;
			?>
				<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
					<div class="portlet box blue" id="wrapper-table">
						<div class="portlet-title">
							<div class="caption"><i class="icon-group"></i>PAR <?= $tanggal_par; ?> :
								<?php echo number_format(($par_10up['saldo_pokok'] / $par_all['saldo_pokok']) * 100, 2, ',', '.'); ?> %
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="clearfix" style="overflow:hidden;">
								<div id="vpar"></div>
							</div>

							<div class="clearfix" style="overflow:hidden;">
								<div>
									PAR : <?php echo number_format(($par_10up['saldo_pokok'] / $par_all['saldo_pokok']) * 100, 2, ',', '.'); ?> %
								</div>
								<div>
									Outstanding Total : <?php echo number_format(($par_all['saldo_pokok']), 0, ',', '.'); ?>
								</div>
								<div>
									Outstanding PAR : <?php echo number_format(($par_10up['saldo_pokok']), 0, ',', '.'); ?>
								</div>
								<div>
									CPP PAR : <?php echo number_format(($par_10up['cpp']), 0, ',', '.'); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
			<div class="row-fluid">
				<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-group"></i> DROPING > Target vs Realisasi </div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="clearfix" style="overflow:hidden;">
								<div id="vdropvs"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption"><i class="icon-group"></i> OUTSTANDING > Target vs Realisasi </div>
							<div class="tools">
								<a href="javascript:;" class="collapse"></a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="clearfix" style="overflow:hidden;">
								<div id="voutsvs"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--
			<div class="col-sm-12 ">
				<div class="portlet box blue" id="wrapper-table">
					<div class="portlet-title">
						<div class="caption"><i class="icon-group"></i>Disbursement Bulan Berjalan : <?php echo number_format($disbursement['disbursement'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>
					<div class="portlet-body">
						<div id="vdrop"></div>
					</div>
				</div>
			</div>

			
			<div class="col-sm-12 ">
				<div class="portlet box blue" id="wrapper-table">
					<div class="portlet-title">
						<div class="caption"><i class="icon-group"></i>Outstanding Tabungan Berencana : <?php echo number_format($outstanding_taber['outstanding_taber'], 0, ',', '.'); ?> </div>
						<div class="tools">
							<a href="javascript:;" class="collapse"></a>
						</div>
					</div>
					<div class="portlet-body">
						<div id="vtab"></div>
					</div>
				</div>
			</div> 
			-->

		</div>
	</div>
</div>
<!-- END DASHBOARD STATS -->



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
		App.init(); // initlayout and core plugins
		// Load the Visualization API and the piechart package.
		google.load('visualization', '1', {
			'packages': ['corechart']
		});

		// Set a callback to run when the Google Visualization API is loaded.
		google.setOnLoadCallback(drawChart);

		function drawChart() {
			var data = new google.visualization.DataTable(<?php echo $jsonPie; ?>);
			var options = {
				title: '',
				is3D: 'true',
				autowidth: true,
				height: 280,
				// autoheight:true,
				vAxis: {
					title: 'Jumlah',
					titleTextStyle: {
						color: 'red'
					}
				},
				hAxis: {
					title: 'Kelompok',
					titleTextStyle: {
						color: 'red'
					}
				}
			};
			var chartPie = new google.visualization.PieChart(document.getElementById('chart_div'));

			chartPie.draw(data, options);
		}

		let tanggal_par = $('#tanggal_par').val();


		if (tanggal_par.length != 0) {
			getPar();
		}
		///getTab();
		//getDrop(); 
		getDropvs();
		getoutsvs();
	});

	function getPar() {
		google.charts.load('current', {
			'packages': ['corechart']
		});
		google.charts.setOnLoadCallback(drawChartPar);

		function drawChartPar() {
			let jsonData = $.ajax({
					url: '<?= site_url(); ?>dashboard/get_par',
					method: 'get',
					dataType: 'json',
					beforeSend: function() {

					}
				})
				.done(function(res) {
					console.log(res);
					let no = 0;
					let tables = new Array();

					var data = new google.visualization.DataTable();

					data.addColumn('string', 'PAR');
					data.addColumn('number', 'Outstanding');

					$.each(res, function(i, k) {
						let label = k.label;
						let value = parseInt(k.value);

						data.addRows([
							[label, value]
						]);
					});

					console.log(data);

					var options = {
						title: 'Laporan Rekap PAR',
						animation: {
							duration: 3000,
							easing: 'out',
							startup: true
						},
						chartArea: {
							left: 0,
							top: 0,
							right: 0,
							bottom: 0
						},
						is3D: true,
						pieSliceText: 'percentage',
						pieStartAngle: 80,
						sliceVisibilityThreshold: .00001,
						enableInteractivity: true,
						fontSize: 10,
						fontName: 'Verdana',
						reverseCategories: false,
						tooltip: {
							showColorCode: true,
							isHtml: false,
							ignoreBounds: false,
							trigger: 'hover'
						},
						legend: {
							position: 'left'
						},
						slices: {
							0: {
								offset: 0.1
							},
							1: {
								offset: 0.2
							},
							2: {
								offset: 0.3
							},
							3: {
								offset: 0.4
							},
							4: {
								offset: 0.5
							},
							5: {
								offset: 0.6
							},
						}
					};

					var chart = new google.visualization.PieChart(document.getElementById('vpar'));

					chart.draw(data, options);
				});
		}
	}

	function getTab() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChartTab);

		function drawChartTab() {
			let jsonData = $.ajax({
					url: '<?= site_url(); ?>dashboard/get_tab',
					method: 'get',
					dataType: 'json',
					beforeSend: function() {

					}
				})
				.done(function(res) {
					console.log(res);

					var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string', 'Produk');
					dataTable.addColumn('number', 'Nominal');
					dataTable.addColumn({
						type: 'string',
						role: 'style'
					});

					let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];
					let no = 0;
					$.each(res, function(i, k) {
						let product_code = k.product_code;
						let product_name = k.product_name;
						let nominal_formated = k.nominal_formated;
						let persen = k.persen;
						let nominal = parseInt(k.nominal);

						dataTable.addRows([
							[product_name + '(' + nominal_formated + ') ' + persen + '%', nominal, 'color:' + warna[no] + ';opacity:1']
						]);
						no++;
					});

					var options = {
						// title: "Rekap Saldo Tabungan",
						height: 400,
						fontSize: 12,
						bar: {
							groupWidth: "40%"
						},
						legend: {
							position: "none"
						},
						orientation: 'vertical',
						chartArea: {
							left: 250,
							top: 10,
							right: 0,
							bottom: 100
						},
					};

					var chart = new google.visualization.ColumnChart(document.getElementById('vtab'));
					chart.draw(dataTable, options);
				});
		}
	}

	function getDrop() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChartDrop);

		function drawChartDrop() {
			let jsonData = $.ajax({
					url: '<?= site_url(); ?>dashboard/get_drop',
					method: 'get',
					dataType: 'json',
					beforeSend: function() {

					}
				})
				.done(function(res) {
					console.log(res);

					var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string', 'Produk');
					dataTable.addColumn('number', 'Nominal');
					dataTable.addColumn({
						type: 'string',
						role: 'style'
					});

					let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];
					let no = 0;
					$.each(res, function(i, k) {
						let product_code = k.product_code;
						let product_name = k.product_name;
						let nominal_formated = k.nominal_formated;
						let persen = k.persen;
						let nominal = parseInt(k.nominal);

						dataTable.addRows([
							[product_name + '(' + nominal_formated + ') ' + persen + '%', nominal, 'color:' + warna[no] + ';opacity:1']
						]);
						no++;
					});

					var options = {
						// title: "Rekap Droping",
						height: 400,
						fontSize: 12,
						bar: {
							groupWidth: "40%"
						},
						legend: {
							position: "none"
						},
						orientation: 'vertical',
						chartArea: {
							left: 250,
							top: 10,
							right: 0,
							bottom: 100
						},
					};

					var chart = new google.visualization.ColumnChart(document.getElementById('vdrop'));
					chart.draw(dataTable, options);
				});
		}
	}

	function getDropvs() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChartDropvs);

		function drawChartDropvs() {
			let jsonData = $.ajax({
					url: '<?= site_url(); ?>dashboard/get_drop_vs',
					method: 'get',
					dataType: 'json',
					beforeSend: function() {

					}
				})
				.done(function(res) {
					console.log(res);

					var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string', 'Produk');
					dataTable.addColumn('number', 'Nominal');
					dataTable.addColumn({
						type: 'string',
						role: 'style'
					});

					let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];
					let no = 0;
					$.each(res, function(i, k) {
						let product_code = k.product_code;
						let product_name = k.product_name;
						let nominal_formated = k.nominal_formated;
						let persen = k.persen;
						let nominal = parseInt(k.nominal);

						dataTable.addRows([
							[product_name + '(' + nominal_formated + ') ', nominal, 'color:' + warna[no] + ';opacity:1']
						]);
						no++;
					});

					var options = {
						// title: "Rekap Droping",
						height: 400,
						fontSize: 12,
						bar: {
							groupWidth: "40%"
						},
						legend: {
							position: "none"
						},
						orientation: 'horizontal',
						chartArea: {
							left: 100,
							top: 10,
							right: 0,
							bottom: 50
						},
					};

					var chart = new google.visualization.ColumnChart(document.getElementById('vdropvs'));
					chart.draw(dataTable, options);
				});
		}
	}

	function getoutsvs() {
		google.charts.load('current', {
			'packages': ['corechart', 'bar']
		});
		google.charts.setOnLoadCallback(drawChartoutsvs);

		function drawChartoutsvs() {
			let jsonData = $.ajax({
					url: '<?= site_url(); ?>dashboard/get_outs_vs',
					method: 'get',
					dataType: 'json',
					beforeSend: function() {

					}
				})
				.done(function(res) {
					console.log(res);

					var dataTable = new google.visualization.DataTable();
					dataTable.addColumn('string', 'Produk');
					dataTable.addColumn('number', 'Nominal');
					dataTable.addColumn({
						type: 'string',
						role: 'style'
					});

					let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];
					let no = 0;
					$.each(res, function(i, k) {
						let product_code = k.product_code;
						let product_name = k.product_name;
						let nominal_formated = k.nominal_formated;
						let persen = k.persen;
						let nominal = parseInt(k.nominal);

						dataTable.addRows([
							[product_name + '(' + nominal_formated + ') ', nominal, 'color:' + warna[no] + ';opacity:1']
						]);
						no++;
					});

					var options = {
						// title: "Rekap Droping",
						height: 400,
						fontSize: 12,
						bar: {
							groupWidth: "50%"
						},
						legend: {
							position: "none"
						},
						orientation: 'horizontal',
						chartArea: {
							left: 100,
							top: 10,
							right: 0,
							bottom: 50
						},
					};

					var chart = new google.visualization.ColumnChart(document.getElementById('voutsvs'));
					chart.draw(dataTable, options);
				});
		}
	}


	//	function getAngs() 
	//	{
	//		google.charts.load('current', {'packages':['corechart', 'bar']});
	//		google.charts.setOnLoadCallback(drawChartAngs);
	//
	//		function drawChartAngs() {
	//			let jsonData = $.ajax({
	//				url: '<?= site_url(); ?>dashboard/get_angs',
	//				method: 'get',
	//				dataType: 'json',
	//				beforeSend: function(){
	//
	//				}
	//			})
	//			.done(function(res){
	//				console.log(res);
	//
	//				var dataTable = new google.visualization.DataTable();
	//				dataTable.addColumn('string', 'Produk');
	//				dataTable.addColumn('number', 'Nominal');
	//				dataTable.addColumn({type: 'string', role: 'style'});
	//
	//				let warna = ['#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE', '#578ebe', '#1bbc9b', '#e08283', '#e87e04', '#8775a7', '#2f353b', '#4B77BE'];
	//				let no = 0;
	//				$.each(res, function(i, k){
	//					let product_code     = k.product_code;
	//					let product_name     = k.product_name;
	//					let nominal_formated = k.nominal_formated;
	//					let persen           = k.persen;
	//					let nominal          = parseInt(k.nominal);
	//
	//					dataTable.addRows([[product_name+'('+nominal_formated+') '+persen+'%', nominal, 'color:'+warna[no]+';opacity:1' ]]);
	//					no++;
	//				});
	//
	//				var options = {
	//					// title: "Rekap Angs",
	//					height: 400,
	//					fontSize: 12,
	//					bar: {groupWidth: "40%"},
	//					legend: { position: "none" },
	//					orientation: 'vertical',
	//					chartArea: {
	//						left:250,
	//						top: 10,
	//						right: 0,
	//						bottom: 100
	//					},
	//				};
	//
	//				var chart = new google.visualization.ColumnChart(document.getElementById('vangs'));
	//				chart.draw(dataTable, options);
	//			});
	//		}
	//	}
	//
</script>

<!-- END JAVASCRIPT -->