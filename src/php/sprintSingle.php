<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationSprintUS.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlTask.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationUSTask.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlKanban.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$ctrlKanban = new CtrlKanban();
$ctrlParticipates = new CtrlParticipates();
$ctrlSprint = new CtrlSprint();
$ctrlRel = new CtrlRelationSprintUS();
$ctrlBacklog = new CtrlBacklog();
$ctrlTask = new CtrlTask();
$ctrlRelUS = new CtrlRelationUSTask();
$ctrlUser = new CtrlUser();

$whatfile = "sprint";
$whattab = 0;
if(isset($_GET['tab']))
{
    $whattab = $_GET['tab'];
}

$project_id = 0;
$sprint_id = 0;
$sprint_nb = 0;

if (isset($_GET['project_id']) && isset($_GET['sprint_id'])){
    $project_id = htmlspecialchars($_GET['project_id']);
    $sprint_id = htmlspecialchars($_GET['sprint_id']);
    $sprint_nb = $ctrlSprint->getSprintNumberWithID($sprint_id)->fetch_assoc()['number_sprint'];
}
else
    header("Location: ".$GLOBAL['SITE_ROOT']."/index.php");

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

$inputDescription = $inputCost = $inputUS = "";
$descriptionErr = $costErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $create = true;
    if(!empty($_POST['inputDescription']))
	$inputDescription = test_input($_POST['inputDescription']);
    else
    {
	$descriptionErr = "A description is required";
	$create = false;
    }

    if(!empty($_POST['inputCost']))
	$inputCost = test_input($_POST['inputCost']);
    else
    {
	$costErr = "A cost is required";
	$create = false;
    }
    
    if(!empty($_POST['inputUS']))
	$inputUS = test_input($_POST['inputUS']);
    else
	$create = false;
    
    if(!empty($_POST['createTask']))
    {
	if($create)
	{
	    $us_id = $ctrlBacklog->getUserStoryWithNumberInProject($inputUS,$project_id)->fetch_assoc()['us_id'];
	    $num = $ctrlTask->getNumberOfTask($project_id,$sprint_id);
	    $ctrlTask->createTask($project_id,$sprint_id,$inputDescription,$num+1,$inputCost);
	    $task_id = $ctrlTask->getTaskWithNumber($num+1,$project_id,$sprint_id)->fetch_assoc()['task_id'];
	    
	    $ctrlRelUS->addTaskToUS($task_id,$us_id);

	    $ctrlKanban->createKanban($task_id,0);
	}
    }
    elseif(!empty($_POST['modify']))
    {
	$task_nb = test_input($_POST['nbid']);
	$task_id = $ctrlTask->getTaskWithNumber($task_nb,$project_id,$sprint_id)->fetch_assoc()['task_id'];
	$ctrlTask->updateTask($task_id,$inputDescription,$inputCost);

	$us_id = $ctrlBacklog->getUserStoryWithNumberInProject($inputUS,$project_id)->fetch_assoc()['us_id'];
	$ctrlRelUS->updateRelatedUS($task_id,$us_id);
    }
    elseif(!empty($_POST['remove']))
    {
	$task_nb = test_input($_POST['nbid']);
	$task_id = $ctrlTask->getTaskWithNumber($task_nb,$project_id,$sprint_id)->fetch_assoc()['task_id'];
	$ctrlRelUS->removeTaskToUS($task_id);
	$ctrlKanban->deleteKanban($task_id);
	$ctrlTask->deleteTask($project_id,$sprint_id,$task_id);
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
	<title>Home sprint <?php global $sprint_nb; echo $sprint_nb; ?></title>
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">

		<?php include 'topmenu.php'; ?>
		<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
		<?php include 'sidebar.php'; ?>
		<!-- /.navbar-collapse -->
	    </nav>
	    <div id="page-wrapper" >
		<div class="panel panel-primary"> 
		    <div class="panel-heading">
			<div class="row" >
			    <h2 class="text-center">
				Home sprint <?php global $sprint_nb; echo $sprint_nb; ?>
			    </h2>
			</div>
		    </div>
		    <div id="tabsbody" class="panel-body" >
			<div id="tabs" >	
			    <ul  class="nav nav-pills">
				<li <?php global $whattab; if($whattab == 0) echo 'class="active"'; ?>>
				    <a href="#UserStoryTab" data-toggle="tab">User Story</a>
				</li>
				<li <?php global $whattab; if($whattab == 1) echo 'class="active"'; ?>>
				    <a href="#Kanban" data-toggle="tab">Kanban</a>
				</li>
				<li <?php global $whattab; if($whattab == 2) echo 'class="active"'; ?>>
				    <a href="#Tasks" data-toggle="tab">Tasks</a>
				</li>
			    </ul>

			    <div class="tab-content clearfix">
				<div class="tab-pane <?php global $whattab; if($whattab == 0) echo 'active'; ?>" id="UserStoryTab">
				    <?php include 'UserStoryTab.php'; ?>
				</div>
				<div class="tab-pane <?php global $whattab; if($whattab == 1) echo 'active'; ?>" id="Kanban">
				    <?php include 'kanban.php'; ?>
				</div>
				<div class="tab-pane <?php global $whattab; if($whattab == 2) echo 'active'; ?>" id="Tasks">
				    <?php include 'tasks.php'; ?>
				</div>
			    </div>
			</div>
		    </div>
		</div>
	    </div>
	</div>

	<?php include 'modalRemoveUS.php'; ?>

	<?php include 'modalAddUS.php';  ?>

	<?php include 'modalChangeTask.php'; ?>
    </body>
</html>
