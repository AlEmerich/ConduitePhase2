<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationSprintUS.php');

$ctrlSprint = new CtrlSprint();
$ctrlRelSprintUs = new CtrlRelationSprintUS();
$ctrlBacklog = new CtrlBacklog();
$ctrlParticipates = new CtrlParticipates();
$project_id = "";

$whatfile = "curve";

if (isset($_GET["project_id"]))
    $project_id = htmlspecialchars($_GET["project_id"]);
else
    header("Location: ".$GLOBAL['SITE_ROOT']."/index.php");

$logged = false;
if(isset($_SESSION['login']))
{
    $users = $ctrlParticipates->getUserWhichContributes($_GET['project_id']);
    $line;
    while($line = $users->fetch_assoc())
    {
	if($line['login'] == $_SESSION['login'])
	    $logged = true;
    }
}
?>

<!doctype html>
<html lang="en">
    
    <head>

	<?php include '../provideapi.php'; ?>

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">
	 google.charts.load('current', {'packages':['corechart']});
	 google.charts.setOnLoadCallback(drawChart);

	 function drawChart(){
             var data = google.visualization.arrayToDataTable([
		 ['sprint', 'theory', 'reality'],
		 <?php global $ctrlBacklog;
		 global $project_id;
		 global $ctrlRelSprintUs;
		 global $ctrlSprint;
		 $realTotalTime = 0;
		 $fullBacklog = $ctrlBacklog->getUserStoryFromProject($project_id);
		 $us;
		 $us_array=array();
		 while ($us = $fullBacklog->fetch_assoc()){
                     $realTotalTime = $realTotalTime + $us['effort'];
		 }
		 $theoTotalTime = $realTotalTime;
		 echo "['0', ".$theoTotalTime.", ".$realTotalTime." ],";
		 $sprintList = $ctrlSprint->getSprintFromProject($project_id);
		 $sprintLine;
		 $firstLine = true;
		 while($sprintLine = $sprintList->fetch_assoc()){
                     $usList = $ctrlRelSprintUs->getUSrelated($project_id, $sprintLine['sprint_id']);
                     $usLine;
                     while($usLine = $usList->fetch_assoc()){
			 $usFull = $ctrlBacklog->getUserStory($usLine['us_id'])->fetch_assoc();
			 $usTime = $usFull['effort'];
			 if($usLine['finished']!=0){
                             $realTotalTime = $realTotalTime - $usTime;
			 }
			 if(in_array($usLine['us_id'], $us_array) == false)
                         {
                             $theoTotalTime = $theoTotalTime - $usTime;
                             array_push($us_array, $usLine['us_id']);
                         }
                     }
                     if(!($firstLine)){
			 echo ",";
                     }
                     $firstLine=false;
                     echo "['".$sprintLine['number_sprint']."', ".$theoTotalTime.", ".$realTotalTime."]";
		 }
		 ?>
             ]);

             var options ={
		 title: 'Velocity curve of the project',
		 legend: {position:'bottom'}
             };

             var chart = new google.visualization.LineChart(document.getElementById('velocity_curve'));

             chart.draw(data, options);
	 }
	</script>
	<title>Curve</title>
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<?php include 'topmenu.php'; ?>

		<?php include 'sidebar.php'; ?>
	    </nav>
	    <div id="page-wrapper" >
		<div class="panel panel-primary">
		    <div class="panel-heading" >
			<div class="row" >
			    <h2 class="text-center">
				Burndown charts
			    </h2>
			</div>
		    </div>
		    <div class="panel-body" >
			<div class="row" >
			    <div id="velocity_curve"></div>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
