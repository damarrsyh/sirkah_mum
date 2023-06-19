<?php
$host = '10.130.229.220';
$dbuser = 'postgres';
$dbpass = 'airmancur2019';
$dbname = 'mum';

$conn = pg_connect('host=' . $host . ' dbname=' . $dbname . ' user=' . $dbuser . ' password=' . $dbpass);

require_once('../assets/plugins/jpgraph/jpgraph.php');
require_once('../assets/plugins/jpgraph/jpgraph_line.php');

$branch_code = $_GET['branch_code'];
$jenistarget = $_GET['jenistarget'];
$tahuntarget = $_GET['tahuntarget'];

$sql = "SELECT  
a.target_item kode, c.display_text||' Target' AS Keterangan,
SUM(a.t1) AS b1, SUM(a.t2) AS b2, SUM(a.t3) AS b3, SUM(a.t4) AS b4, SUM(a.t5) AS b5, SUM(a.t6) AS b6,
SUM(a.t7) AS b7, SUM(a.t8) AS b8, SUM(a.t9) AS b9, SUM(a.t10) AS b10, SUM(a.t11) AS b11, SUM(a.t12) AS b12
FROM mfi_target_cabang AS a
LEFT JOIN mfi_branch AS b ON a.branch_code = b.branch_code
LEFT JOIN mfi_list_code_detail AS c ON a.target_item = c.code_value AND c.code_group = 'targetcabang'
WHERE a.tahun = '" . $tahuntarget . "' AND a.target_item = '" . $jenistarget . "' ";

if ($branch_code != '00000') {
    $sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = '" . $branch_code . "') ";
};

$sql .= "GROUP BY 1,2 UNION ALL ";

$sql .= "SELECT 
a.target_item kode, c.display_text||' Realisasi' AS Keterangan,
SUM(a.c1) AS b1, SUM(a.c2) AS b2, SUM(a.c3) AS b3, SUM(a.c4) AS b4, SUM(a.c5) AS b5, SUM(a.c6) AS b6,
SUM(a.c7) AS b7, SUM(a.c8) AS b8, SUM(a.c9) AS b9, SUM(a.c10) AS b10, SUM(a.c11) AS b11, SUM(a.c12) AS b12
FROM mfi_target_cabang AS a
LEFT JOIN mfi_branch AS b ON a.branch_code = b.branch_code
LEFT JOIN mfi_list_code_detail AS c ON a.target_item = c.code_value AND c.code_group = 'targetcabang'
WHERE a.tahun = '" . $tahuntarget . "' AND a.target_item = '" . $jenistarget . "' ";

if ($branch_code != '00000') {
    $sql .= "AND a.branch_code IN(SELECT branch_code FROM mfi_branch_member WHERE branch_induk = '" . $branch_code . "') ";
};

$sql .= "GROUP BY 1,2 ORDER BY 1,2 DESC";

$query = pg_exec($conn, $sql);
$num = pg_numrows($query);

// Setup the graph
$graph = new Graph(1100, 400);
$graph->SetScale("textlin");

$theme_class = new UniversalTheme;

$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Rekap Target Vs Realisasi');
$graph->SetBox(false);

$graph->img->SetAntiAliasing();

$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false, false);

$bulan = array();

for ($i = 1; $i < 13; $i++) {
    if ($i == 1) {
        $month = 'Jan';
    } else if ($i == 2) {
        $month = 'Feb';
    } else if ($i == 3) {
        $month = 'Mar';
    } else if ($i == 4) {
        $month = 'Apr';
    } else if ($i == 5) {
        $month = 'Mei';
    } else if ($i == 6) {
        $month = 'Jun';
    } else if ($i == 7) {
        $month = 'Jul';
    } else if ($i == 8) {
        $month = 'Agt';
    } else if ($i == 9) {
        $month = 'Sep';
    } else if ($i == 10) {
        $month = 'Okt';
    } else if ($i == 11) {
        $month = 'Nov';
    } else {
        $month = 'Des';
    }

    $bulan[] = $month;
}

$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
$graph->xaxis->SetTickLabels($bulan);
$graph->xgrid->SetColor('#E3E3E3');

$arr = array();
$datay = array();

for ($j = 0; $j < $num; $j++) {
    $myrow = pg_fetch_row($query, $j);

    $datay[$j] = array($myrow[2], $myrow[3], $myrow[4], $myrow[5], $myrow[6], $myrow[7], $myrow[8], $myrow[9], $myrow[10], $myrow[11], $myrow[12], $myrow[13]);

    if ($j == 0) {
        $p1 = new LinePlot($datay[$j]);
        $graph->Add($p1);
        $p1->SetColor('#55bbdd');
        $p1->SetLegend($myrow[1]);
        $p1->mark->SetType(MARK_FILLEDCIRCLE, '', 1.0);
        $p1->mark->SetColor('#55bbdd');
        $p1->mark->SetFillColor('#55bbdd');
        $p1->SetCenter();
    } else {
        $p2 = new LinePlot($datay[$j]);
        $graph->Add($p2);
        $p2->SetColor("#FF0000");
        $p2->SetLegend($myrow[1]);
        $p2->mark->SetType(MARK_UTRIANGLE, '', 1.0);
        $p2->mark->SetColor('#FF0000');
        $p2->mark->SetFillColor('#FF0000');
        $p1->SetCenter();
    }
}

$graph->SetMargin(80, 15, 0, 70);
$graph->legend->SetFrameWeight(1);
$graph->legend->SetColor('#4E4E4E', '#00A78A');
$graph->legend->SetPos(0.5, 0.98, 'center', 'bottom');

// Output line
$gdImgHandler = $graph->Stroke(_IMG_HANDLER);
$fileName = '../assets/img/grafik/grafik_' . $branch_code . '_' . $jenistarget . '_' . $tahuntarget . '.png';
$graph->img->Stream($fileName);
$graph->img->Headers();
$graph->img->Stream();
