<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$ctrlParticipates = new CtrlParticipates();
$project_id = "";

if (isset($_GET["project_id"]))
    $project_id = htmlspecialchars($_GET["project_id"]);
else
    header("Location: http://localhost:8000/index.php");

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
	
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css">
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<?php include 'topmenu.php'; ?>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
		    <ul class="nav navbar-nav side-nav">
			<li>
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/homeProject.php?project_id='.$project_id.'"';?>
			    ><i class="fa fa-fw fa-desktop"></i> Home Project</a>
			</li>
			<li>
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/backlog.php?project_id='.$project_id.'"';?>
			    ><i class="fa fa-fw fa-table"></i> Backlog</a>
			</li>
			<li>
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/sprint.php?project_id='.$project_id.'"';?>
			    ><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
			</li>
			<li class="active">
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/curve.php?project_id='.$project_id.'"';?>><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
			</li>
		    </ul>
		</div>
	    </nav>
	</div>
	<div id="page-wrapper" >
	</div>
    </body>
</html>
