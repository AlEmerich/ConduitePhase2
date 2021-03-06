<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');

$ctrlSprint = new CtrlSprint();
$ctrlParticipates = new CtrlParticipates();
$ctrlProject = new CtrlProject();

$project_id = 0;
$header = htmlspecialchars($_SERVER["PHP_SELF"]);

$whatfile = "sprint";

if (isset($_GET["project_id"])){
    $project_id = htmlspecialchars($_GET["project_id"]);
    $header = $header."?project_id=".$project_id;
}
else
    header("Location: ".$GLOBALS['SITE_ROOT']."/index.php");

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

$inputStart = $inputStop = $inputDuration = "";
$startErr = $stopErr = $durationErr = "";

$create = true;
if ($_SERVER["REQUEST_METHOD"] == "POST"){

    if(!empty($_POST['durationSubmit']))
    {
	$inputDuration = $_POST['inputDuration'];
	if(is_numeric($inputDuration))
	{
	    if($inputDuration > 0)
		$ctrlProject->changeSprintDuration($project_id,$inputDuration);
	    else
		$durationErr = "is not positive";
	}
	else
	    $durationErr = "is not a numeric value";
    }
    
    if(!empty($_POST['createSprint']))
    {
	if (empty($_POST["inputStart"])){
            $startErr = "Starting date is required";
            $create = false;
	}
	else{
            $inputStart = test_input($_POST["inputStart"]);
	}

	if (empty($_POST["project_id"])){
            $create=false;
	}
	else{
            $project_id = test_input($_POST["project_id"]);
	}
	if($create){
	    $num = $ctrlSprint->getNumberOfSprint($project_id);
	    $duration = $ctrlProject->getSprintDuration($project_id)->fetch_assoc()['sprint_duration'];
	    $inputStop = $ctrlSprint->getDateStop($inputStart,$duration);
	    $inputState = getState($inputStart,$inputStop);
	    
            $ctrlSprint->createSprint($project_id,$num+1, $inputState, $inputStart);
	}
    }
    elseif(!empty($_POST['modify']))
    {
	$modify = true;
	if(!empty($_POST['inputStart']))
	{
	    $inputStart = test_input($_POST['inputStart']);
	}
	else
	{
	    $modify = false;
	}

	$nb_id;
	if(!empty($_POST['nbid']))
	{
	    $nb_id = test_input($_POST['nbid']);
	}
	else
	{
	    $modify = false;
	}

	if($modify)
	{
	    $sprint_id = $ctrlSprint->getSprintWithNumberInProject($nb_id,$project_id)->fetch_assoc()['sprint_id'];
	    $ctrlSprint->updateTime($sprint_id,$inputStart);
	}
    }
    elseif(!empty($_POST['remove']))
    {
	$nb_id;
	if(!empty($_POST['nbid']))
	{
	    $nb_id = test_input($_POST['nbid']);
	}
	$sprint_id = $ctrlSprint->getSprintWithNumberInProject($nb_id,$project_id)->fetch_assoc()['sprint_id'];
	$ctrlSprint->deleteSprint($project_id,$sprint_id);
    }
}

function test_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function getState($date_start,$date_end)
{
    $t = getdate();
    $today = new DateTime($t['year'].'-'.$t['mon'].'-'.$t['mday']);
    $start = new DateTime($date_start);
    $end = new DateTime($date_end);

    $state = "";
    if($today < $start)
    {
	$state = "Not started";
    }
    else
    {
	if($today <= $end)
	{
	    $state = "On going";
	}
	else
	{
	    $state = "Finished";
	}
    }	
    return $state;
}
?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include '../provideapi.php'; ?>
	
	<title>Sprints</title>
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
			    <span class="col-lg-6 col-md-4col-sm-6 col-xs-8">
				    <?php
				    global $ctrlProject;
				    global $project_id;
				    global $header;
				    global $durationErr;
				    $pro = $ctrlProject->getProject($project_id)->fetch_assoc();
				    global $logged;
				    if(!$logged)
					echo '<b> Sprint duration (days): </b>'.$pro['sprint_duration'];
				    else
					echo '<form class="well form-inline"
				    method="post"
				    action="'.$header.'">

				    <div class="form-group">
                                    <label for="inputDuration" ><b>Sprint duration (days):</b> </label>
				    <input name="inputDuration" type="text" class="form-control" value="'.$pro['sprint_duration'].'" />
				    </div>
				    <span class = "error"> '.$durationErr.'</span>
				    <input name="project_id" type="text"  style="display:none" value="<?php global $project_id; echo $project_id; ?>"/>
				    <input name="durationSubmit" type="submit" value="Change" >
				    </form>';
				    ?>
			    </span>
			</div>
			<div class="row" >
			    <div class="col-lg-12 col-md-12 col-xs-12 table-responsive">
				<table class= "table">
				    <caption>List of Sprints related to this project</caption>
				    <thead>
					<tr>
					    <?php global $logged; if($logged) : ?>
						<th style="width:5%" ></th>
					    <?php endif ?>
					    <th style="width:5%" >Sprint#</th>
					    <th>State</th>
					    <th>Starting date</th>
					    <th>Stopping date</th>
					    <th>Sprint overview</th>
					</tr>
				    </thead>
				    <tbody>

					<?php
					global $project_id;
					global $logged;
					global $ctrlSprint;
					global $ctrlProject;
					$list = $ctrlSprint->sprintList($project_id);
					$line;
					if($list != FALSE)
					{
					    while ($line = $list->fetch_assoc()){
						echo '<tr>';
						if($logged)
						{
						    echo '<td><a class="btn btn-default"
					                 style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
					                 href="#" role="button" id="changeSprint"
                                                         data-toggle="modal" data-target="#modalChangeSprint'.$line['number_sprint'].'">
						          <i class="fa fa-pencil-square-o" aria-hidden="true">
						          </i>
					              </a></td>';
						}
						$duration = $ctrlProject->getSprintDuration($project_id)->fetch_assoc()['sprint_duration'];
						$date_stop = $ctrlSprint->getDateStop($line['date_start'],$duration);
						echo '<td>'.$line['number_sprint'].'</td>';
						echo '<td>'.getState($line['date_start'],$date_stop).'</td>';
						echo '<td>'.$line['date_start'].'</td><td>'.$date_stop.'</td>';
						
						echo '<td><a role="button" href="'.$GLOBALS['SITE_ROOT'].'/php/sprintSingle.php?sprint_id='.$line['sprint_id'].'&project_id='.$project_id.'&tab=0"
                                                          class="btn btn-primary"
                                                          style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
                                                          id="gotoSprint"><i class="fa fa-home"></i></a>';
						echo '<a role="button" href="'.$GLOBALS['SITE_ROOT'].'/php/sprintSingle.php?sprint_id='.$line['sprint_id'].'&project_id='.$project_id.'&tab=1"
                                                          class="btn btn-primary col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1"
                                                          style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
                                                          id="gotoKanban"><i class="fa fa-trello" aria-hidden="true"></i></a>';
						echo '<a role="button" href="'.$GLOBALS['SITE_ROOT'].'/php/sprintSingle.php?sprint_id='.$line['sprint_id'].'&project_id='.$project_id.'&tab=2"
                                                          class="btn btn-primary col-lg-offset-1 col-md-offset-1 col-sm-offset-1 col-xs-offset-1"
                                                          style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
                                                          id="gotoTasks"><i class="fa fa-tasks" aria-hidden="true"></i></a></td>';
						
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
			      action="<?php global $header; echo $header;?>">
			    <legend class="title">Create sprint</legend>

			    <div class="form-group">
				<label for="inputStart" >Starting date</label>
				<span class = "error">* <?php global $startErr; echo $startErr; ?></span>
				<input name="inputStart" type="text" class="datepick form-control" value="<?php global $inputStart; echo $inputStart; ?>" />
			    </div>
			    
			    <input name="project_id" type="text"  style="display:none" value="<?php global $project_id; echo $project_id; ?>"/>
			    <input name="createSprint" type="submit" value="Create" >
			</form>
		    <?php endif ?>
		</div>

		<?php include 'modalChangeSprint.php' ?>
	    </div>
	</div>
    </body>
</html>
