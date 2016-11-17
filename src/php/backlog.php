<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$ctrlBacklog = new CtrlBacklog();
$ctrlParticipates = new CtrlParticipates();
$project_id = "";

if (isset($_GET["project_id"]))
    $project_id = htmlspecialchars($_GET["project_id"]);
/*else
  header("Location: http://localhost:8000/index.php");*/

$logged = false;
if(isset($_SESSION['login']))
{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $users = $ctrlParticipates->getUserWhichContributes(test_input($_POST["project_id"]));
    }else{
        $users = $ctrlParticipates->getUserWhichContributes($_GET['project_id']);
    }
    $line;
    while($line = $users->fetch_assoc())
    {
	if($line['login'] == $_SESSION['login'])
	    $logged = true;
    }
}

$inputDescription = $inputEffort = $inputPriority = "";
$descriptionErr = $effortErr = $priorityErr = "";

$create = true;
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["inputDescription"])){
        $descriptionErr = "UserStory description is required";
        $create = false;
    }
    else{
        $inputDescription = test_input($_POST["inputDescription"]);
    }

    if (empty($_POST["inputEffort"])){
        $effortErr = "Effort value is required";
        $create = false;
    }
    else{
        $inputEffort = test_input($_POST["inputEffort"]);
    }

    if (empty($_POST["inputPriority"])){
        $priorityErr = "Priority value is required";
        $create = false;
    }
    else{
        $inputPriority = test_input($_POST["inputPriority"]);
    }

    if (empty($_POST["project_id"])){
        $create=false;
    }
    else{
        $project_id = test_input($_POST["project_id"]);
    }
    if($create){
        $ctrlBacklog->createUserStory($project_id, $inputDescription, $inputEffort, $inputPriority);
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
			<li class="active">
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
				Backlog
			    </h2>
			</div>
		    </div>

		    <div class="panel-body" >
			<div class="row" >
			    <div class="col-lg-12 col-md-12 col-xs-12 table-responsive">
				<table class= "table">
				    <caption>List of UserStories related to this project</caption>
				    <thead>
					<tr>
					    <th>US number</th>
					    <th>Description</th>
					    <th>Effort</th>
					    <th>Priority</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					global $project_id;
					$userStoryList = $ctrlBacklog->getUserStoryFromProject($project_id);
					$line;
					while ($line = $userStoryList->fetch_assoc()){
					    echo '<tr><td>'.$line['us_id'].'</td><td>'.$line['description'].'</td><td>'.$line['effort'].'</td><td>'.$line['priority'].'</td></tr>';
					}
					?>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>	    
		</div>

		<div class="row">
		    <?php global $logged; if ($logged): ?>
			<form class="well 
				     col-lg-offset-1 col-lg-10 
				     col-md-offset-1 col-md-10 
				     col-xs-offset-1 col-xs-10"
			      method="post"
			      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    <legend class="title">Create UserStory</legend>
			    <div class="form-group">
				<label for="inputDescription">Description de la UserStory</label>
				<span class ="error">* <?php global $descriptionErr; echo $descriptionErr; ?></span>
				<input name="inputDescription" type="text" class="form-control" value="<?php global $inputDescription; echo $inputDescription; ?>" />
			    </div>

			    <div class="form-group">
				<label for="inputEffort" >Effort</label>
				<span class = "error">* <?php global $effortErr; echo $effortErr; ?></span>
				<input name="inputEffort" type="text" class="form-control" value="<?php global $inputEffort; echo $inputEffort; ?>" />
			    </div>

			    <div class="form-group">
				<label for="inputEffort" >Priority</label>
				<span class = "error">* <?php global $priorityErr; echo $priorityErr; ?></span>
				<input name="inputPriority" type="text" class="form-control" value="<?php global $inputPriority; echo $inputPriority; ?>" />
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
