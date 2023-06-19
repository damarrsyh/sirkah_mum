<?php // content="text/plain; charset=utf-8"
require_once('jpgraph.php');
require_once('jpgraph_bar.php');

$kode_cabang = $_GET['kode_cabang'];

$data1y = array(47, 80, 40, 116);

// Create the graph. These two calls are always required
$graph = new Graph(350, 200, 'auto');
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;
$graph->SetTheme($theme_class);

$graph->yaxis->SetTickPositions(array(0, 30, 60, 90, 120, 150), array(15, 45, 75, 105, 135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('A', 'B', 'C', 'D'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

// Create the bar plots
$b1plot = new BarPlot($data1y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#2596be");

$graph->title->Set($kode_cabang);

// Display the graph
$graph->Stroke();
