<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationSprintUS.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');

$whatfile = "sprint";

$ctrlParticipates = new CtrlParticipates();
$ctrlSprint = new CtrlSprint();
$ctrlRel = new CtrlRelationSprintUS();
$ctrlBacklog = new CtrlBacklog();

$project_id = 0;
$sprint_id = 0;
$sprint_nb = 0;

if (isset($_GET['project_id']) && isset($_GET['sprint_id'])){
    $project_id = htmlspecialchars($_GET['project_id']);
    $sprint_id = htmlspecialchars($_GET['sprint_id']);
    $sprint_nb = $ctrlSprint->getSprintNumberWithID($sprint_id)->fetch_assoc()['number_sprint'];
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
				<li class="active">
				    <a href="#UserStoryTab" data-toggle="tab">User Story</a>
				</li>
				<li><a href="#Kanban" data-toggle="tab">Kanban</a>
				</li>
				<li><a href="#Tasks" data-toggle="tab">Tasks</a>
				</li>
			    </ul>

			    <div class="tab-content clearfix">
				<div class="tab-pane active" id="UserStoryTab">
				    <?php include 'UserStoryTab.php'; ?>
				</div>
				<div class="tab-pane" id="Kanban">
				    <?php include 'kanban.php'; ?>
				</div>
				<div class="tab-pane" id="Tasks">
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
    </body>
</html>
