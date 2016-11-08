<?php
session_start();

if(!isset($_SESSION['login']))
{
    header("Location: http://localhost:8000/index.php");
}
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');

$ctrlBacklog = new CtrlBacklog('dbserver','alaguitard','11235813','alaguitard');
$project_id = "";

if (isset($_GET["project_id"]))
    $project_id = $_GET["project_id"];

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
			    <a href="http://localhost:8000/php/homeProject.php"><i class="fa fa-fw fa-desktop"></i> Home Project</a>
			</li>
			<li class="active">
			    <a href="http://localhost:8000/php/backlog.php"><i class="fa fa-fw fa-table"></i> Backlog</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/sprint.php"><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/curve.php"><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
			</li>
		    </ul>
		</div>
		<!-- /.navbar-collapse -->
	    </nav>
	    <div id="page-wrapper" >
		<form class="well 
			     col-lg-10 
			     col-md-10 
			     col-xs-10"
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
	    </div>
	    
    </body>
</html>
