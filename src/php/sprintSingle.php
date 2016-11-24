<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');

$whatfile = "sprint";

$ctrlParticipates = new CtrlParticipates();
$ctrlSprint = new CtrlSprint();

$project_id = 0;
$sprint_id = 0;
$sprint_nb = 0;

if (isset($_GET["project_id"]) && isset($_GET['sprint_id'])){
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
	
	<title>Home sprint <?php global $sprint_id; echo $sprint_id; ?></title>
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
		</div>
	    </div>
	</div>
    </body>
</html>
