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
		    <div class="row" >
			<div class="panel-body" >
			    <div class="col-lg-8 col-md-8 col-xs-8 table-responsive">
				<table class="table" >
				    <caption>User Story related to the sprint</caption>
				    <thead>
					<th>#</th>
					<th>Description</th>
				    </thead>
				    <tbody>
					<?php
					global $project_id;
					global $ctrlRel;
					global $sprint_id;
					$us = $ctrlRel->getUSrelated($project_id,$sprint_id);
					$line;
					while($line = $us->fetch_assoc())
					{
					    echo '<tr>';
					    echo '<td>'.$line['number_in_project'].'</td>';
					    echo '<td>'.$line['description'].'</td>';
					    echo '</tr>';
					}
					?>
				    </tbody>
				</table>

				<div class="row" >

				    <?php global $logged; if ($logged) : ?>		
					<a role="button" href="#"
					   class="btn btn-primary 
						  col-lg-3 col-lg-offset-1
						  col-sm-3 col-sm-offset-1
						  col-md-3 col-md-offset-1
						  col-xs-3 col-xs-offset-1"
					   id="addUS" data-toggle="modal"
					   data-target="#modalAddUS">Add US</a>
					
					<a role="button" href="#" 
					   class="btn btn-primary 
						  col-lg-3 col-lg-offset-1
						  col-md-3 col-sm-offset-1
						  col-sm-3 col-md-offset-1
						  col-xs-3 col-xs-offset-1" 
					   id="deleteUS" data-toggle="modal"
					   data-target="#modalRemoveUS" >Remove US</a>
				    <?php endif ?>
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
