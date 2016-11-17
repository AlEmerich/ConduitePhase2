<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$ctrlSprint = new CtrlSprint();
$ctrlParticipates = new CtrlParticipates();
$project_id = 0;
$header = htmlspecialchars($_SERVER["PHP_SELF"]);

if (isset($_GET["project_id"])){
    $project_id = htmlspecialchars($_GET["project_id"]);
    $header = $header."?project_id=".$project_id;
}
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

$inputState = $inputStart = $inputStop = "";
$stateErr = $startErr = $stopErr = "";

$create = true;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["inputState"])){
        $stateErr = "State is required";
        $create = false;
    }
    else{
        $inputState = test_input($_POST["inputState"]);        
    }

    if (empty($_POST["inputStart"])){
        $startErr = "Starting date is required";
        $create = false;
    }
    else{
        $inputStart = test_input($_POST["inputStart"]);
    }

    if (empty($_POST["inputStop"])){
        $stopErr = "Stopping date is required";
        $create = false;
    }
    else{
        $inputStop = test_input($_POST["inputStop"]);
    }

    if (empty($_POST["project_id"])){
        $create=false;
    }
    else{
        $project_id = test_input($_POST["project_id"]);
    }
    if($create){
        $ctrlSprint->createSprint($project_id, $inputState, $inputStart, $inputStop);
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
	
	<title>Inscription</title>
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
			<li	class="active">
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
		<div class="panel panel-primary" >
		    <div class="panel-heading">
			<div class="row" >
			    <h2 class="text-center">
				Sprints
			    </h2>
			</div>
		    </div>

		    <div class="panel-body" >
			<div class="row" >
			    <div class="col-lg-12 col-md-12 col-xs-12 table-responsive">
				<table class= "table">
				    <caption>List of Sprints related to this project</caption>
				    <thead>
					<tr>
					    <th>Sprint Number</th>
					    <th>State</th>
					    <th>Starting date</th>
					    <th>Stopping date</th>
              <th>Sprint overview</th>
					</tr>
				    </thead>
				    <tbody>

					<?php
					global $project_id;
					$list = $ctrlSprint->sprintList($project_id);
					$line;
					if($list != FALSE)
					{
					    while ($line = $list->fetch_assoc()){
						      echo '<tr><td>'.$line['sprint_id'].'</td><td>'.$line['state'].'</td><td>'.$line['date_start'].'</td><td>'.$line['date_stop'].'</td>';
                  global $logged;
                  if($logged){
                      echo '<td><a role="button" href="http://localhost:8000/php/sprintSingle.php?sprint_id='.$line['sprint_id'].'&project_id='.$project_id.'" class="btn btn-primary col-lg-ofsset-1 col-lg-2 col-md-offset-1 col-md-3 col-xs-offset-1 col-xs-4" id="gotoSprint">Add Tasks</a></td>';
                  }
                  echo '</tr>';
					    }
					}
					?>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>
		</div>

		<div class="row" >
		    <?php global $logged; if ($logged): ?>
			<form class="well 
				     col-lg-offset-1 col-lg-10 
				     col-md-offset-1 col-md-10 
				     col-xs-offset-1 col-xs-10"
			      method="post"
			      action="<?php global $header;?>">
			    <legend class="title">Create sprint</legend>
			    <div class="form-group">
				<label for="inputState">État du sprint</label>
				<span class ="error">* <?php global $stateErr; echo $stateErr; ?></span>
				<input name="inputState" type="text" class="form-control" value="<?php global $inputState; echo $inputState; ?>" />
			    </div>

			    <div class="form-group">
				<label for="inputStart" >Date de début du sprint</label>
				<span class = "error">* <?php global $startErr; echo $startErr; ?></span>
				<input name="inputStart" type="text" class="form-control" value="<?php global $inputStart; echo $inputStart; ?>" />
			    </div>

			    <div class="form-group">
				<label for="inputStart" >Date de fin du sprint</label>
				<span class = "error">* <?php global $stopErr; echo $stopErr; ?></span>
				<input name="inputStop" type="text" class="form-control" value="<?php global $inputStop; echo $inputStop; ?>" />
			    </div>

			    <input name="project_id" type="text"  style="display:none" value="<?php global $project_id; echo $project_id; ?>">
			    <input name="action" type="submit"/>
			    
			    
			</form>
		    <?php endif ?>
		</div>
	    </div>
	</div>
    </body>
</html>
