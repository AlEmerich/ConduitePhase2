<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$ctrlParticipates = new CtrlParticipates();

$project_id = 0;
$sprint_id = 0;

if (isset($_GET["project_id"]) && isset($_GET['sprint_id'])){
    $project_id = htmlspecialchars($_GET['project_id']);
    $sprint_id = htmlspecialchars($_GET['sprint_id']);
}
else
    header("Location: http://localhost:8000/index.php");

$logged = false;
if(isset($_SESSION['login']))
{
    $users = $ctrlParticipates->getUserWhichContributes($project_id);
    $line;
     while($line = $users->fetch_assoc())
    {
        if($line['login'] == $_SESSION['login'])
            $logged = true;
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include '../provideapi.php'; ?>
	
	<title>Home sprint <?php global $sprint_id; echo $sprint_id; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css">
	<link href="../css/plugins/morris.css" rel="stylesheet">
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

		<?php include 'topmenu.php'; ?>
		<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
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
			<li class="active">
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/sprint.php?project_id='.$project_id.'"';?>
			    ><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
			</li>
			<li>
			    <a href=
			       <?php global $project_id;
			       echo '"http://localhost:8000/php/curve.php?project_id='.$project_id.'"';?>><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
			</li>
		    </ul>
		</div>
		<!-- /.navbar-collapse -->
	    </nav>
	    <div id="page-wrapper" >
		<div class="panel panel-primary"> 
		    <div class="panel-heading">
			<div class="row" >
			    <h2 class="text-center">
				Home sprint <?php global $sprint_id; echo $sprint_id; ?>
			    </h2>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
