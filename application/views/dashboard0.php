
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
                           <?php foreach ($petugas as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
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
                           <?php foreach ($anggota as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
                           <div class="desc">Anggota Aktif</div>
                        </div>
                        <a class="more" href="#">
                        Detail Anggota <i class="m-icon-swapright m-icon-white"></i>
                        </a>                 
                     </div>
                  </div>
                  <?php
                  if($this->session->userdata('cif_type')=="2" || $this->session->userdata('cif_type')=="0")
                  {
                  ?>
                  <div class="span3 responsive" data-tablet="span6 fix-offset" data-desktop="span3">
                     <div class="dashboard-stat purple">
                        <div class="visual">
                           <i class="icon-user"></i>
                        </div>
                        <div class="details">
                           <?php foreach ($rembug as $data):?>
                           <div class="number"><?php echo $data['num'];?></div>
                           <?php endforeach?>
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
                           <div class="caption"><i class="icon-money"></i>Outstanding Pembiayaan</div>
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
                  <div class="span6 responsive" data-tablet="span6 fix-offset" data-desktop="span6">
                     <div class="portlet box blue" id="wrapper-table">
                        <div class="portlet-title">
                           <div class="caption"><i class="icon-group"></i>Jumlah Anggota Percabang</div>
                           <div class="tools">
                              <a href="javascript:;" class="collapse"></a>
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div class="clearfix" style="overflow:hidden;">
                              <div id="chart_div_colum"></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               </div>
               <!-- END DASHBOARD STATS -->
              


<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<?php $this->load->view('_jscore'); ?>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.pulsate.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/scripts/index.js" type="text/javascript"></script>        
<!-- END PAGE LEVEL SCRIPTS -->

<script>
   $(document).ready(function() {    
      App.init(); // initlayout and core plugins
    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});
 
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);
 
    function drawChart() {
 
      // Create our data table out of JSON data loaded from server.
      // var data = new google.visualization.DataTable(
      //                                               {"cols":[{"label":"people","type":"string"},{"label":"total","type":"number"}]
      //                                               ,"rows":[
      //                                                  {"c":[{"v":"Industri"},{"v":510}]}
      //                                                 ,{"c":[{"v":"Jasa"},{"v":1021}]}
      //                                                 ,{"c":[{"v":"Perdagangan"},{"v":1042}]}
      //                                                 ,{"c":[{"v":"Pertanian"},{"v":1063}]}
      //                                               ]}
      //                                               );
      var data = new google.visualization.DataTable(<?php echo $jsonPie; ?>);
      var options = {
           title: '',
          is3D: 'true',
          autowidth: true,
          height: 280,
          // autoheight:true,
          vAxis: {title: 'Jumlah', titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Kelompok', titleTextStyle: {color: 'red'}}
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chartPie = new google.visualization.PieChart(document.getElementById('chart_div'));
      // chartColumn.draw(data, options);
      chartPie.draw(data, options);
    }
 
    google.setOnLoadCallback(drawChart2);
    function drawChart2() {
 
      // Create our data table out of JSON data loaded from server.
      // var data = new google.visualization.DataTable(
      //                                               {"cols":[{"label":"people","type":"string"},{"label":"total","type":"number"}]
      //                                               ,"rows":[
      //                                                  {"c":[{"v":"Industri"},{"v":510}]}
      //                                                 ,{"c":[{"v":"Jasa"},{"v":1021}]}
      //                                                 ,{"c":[{"v":"Perdagangan"},{"v":1042}]}
      //                                                 ,{"c":[{"v":"Pertanian"},{"v":1063}]}
      //                                               ]}
      //                                               );
      var data = new google.visualization.DataTable(<?php echo $jsonColoum; ?>);
      var options = {
           title: '',
          is3D: 'true',
          autowidth: true,
          // width: 580,
          height: 400,
          vAxis: {title: 'Jumlah', titleTextStyle: {color: 'red'}},
          hAxis: {title: 'Cabang', titleTextStyle: {color: 'red'}}
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chartColumn = new google.visualization.ColumnChart(document.getElementById('chart_div_colum'));
      chartColumn.draw(data, options);
      // chartPie.draw(data, options);
    }
   });
</script>

<!-- END JAVASCRIPT -->