<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');

$ctrlProject = new CtrlProject();
$ctrlBacklog = new CtrlBacklog();
$ctrlParticipates = new CtrlParticipates();

$project_id = "";

$whatfile = "backlog";

if (isset($_GET["project_id"]))
    $project_id = htmlspecialchars($_GET["project_id"]);
else
    header("Location: http://localhost:8000/index.php");

$logged = false;
$product_owner = false;
if(isset($_SESSION['login']))
{
    $users = $ctrlParticipates->getUserWhichContributes($_GET['project_id']);
    $line;
    while($line = $users->fetch_assoc())
    {
	if($line['login'] == $_SESSION['login'])
	    $logged = true;
    }

    $po = $ctrlProject->getProductOwner($project_id);
    if($line = $po->fetch_assoc())
	if($line['login'] == $_SESSION['login'])
	    $product_owner = true; 
}

$inputDescription = $inputCommit = $inputEffort = $inputPriority = "";
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

    if(!empty($_POST["createUS"]))
    {
	if($product_owner)
	{
	    if (empty($_POST["inputPriority"])){
		$priorityErr = "Priority value is required";
		$create = false;
	    }
	    else{
		$inputPriority = test_input($_POST["inputPriority"]);
	    }
	}
	else
	{
	    $inputPriority = 1;
	}
	
	if (empty($_POST["project_id"])){
            $create=false;
	}
	else{
            $project_id = test_input($_POST["project_id"]);
	}
	if($create){
	    $num_in_pro = $ctrlBacklog->getNumberOfUS($project_id);
            $ctrlBacklog->createUserStory($num_in_pro+1,$project_id,
					  $inputDescription, $inputEffort,
					  $inputPriority);
	}
    }
    elseif(!empty($_POST['modify']))
    {
	$modify = true;
	if(!empty($_POST['inputDescription']))
	{
	    $inputDescription = test_input($_POST['inputDescription']);
	}
	else
	{
	    $modify = false;
	}
	if(!empty($_POST['inputEffort']))
	{
	    $inputEffort = test_input($_POST['inputEffort']);
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
	if(!empty($_POST['inputCommit']))
	{
	    $inputCommit = test_input($_POST['inputCommit']);
	}

	if($modify)
	{
	    $us_id = $ctrlBacklog->getUserStoryWithNumberInProject($nb_id,$project_id)->fetch_assoc()['us_id'];
	    $ctrlBacklog->updateCommit($us_id,$inputCommit);
	    $ctrlBacklog->updateUserStoryEffortDesc($us_id,$inputDescription,$inputEffort);
	}
    }
    elseif(!empty($_POST['remove']))
    {
	$nb_id;
	if(!empty($_POST['nbid']))
	{
	    $nb_id = test_input($_POST['nbid']);
	}
	$us_id = $ctrlBacklog->getUserStoryWithNumberInProject($nb_id,$project_id)->fetch_assoc()['us_id'];
	$ctrlBacklog->deleteUserStory($project_id,$us_id);
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
	
	<title>Backlog</title>
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
				Backlog
			    </h2>
			</div>
		    </div>

		    <div class="panel-body" >
			<div class="row" >
			    <form action="http://localhost:8000/php/changeprio.php?project_id=<?php global $project_id; echo $project_id; ?>" method="post" >
				<div class="col-lg-12 col-md-12 col-xs-12 table-responsive">
				    <table class= "table">
					<caption>List of UserStories related to this project</caption>
					<thead>
					    <tr>
						<?php global $logged; if($logged) : ?>
						    <th style="width:5%"></th>
						<?php endif ?>
						<th style="width:5%">US#</th>
						<th>Description</th>
						<th style="width:5%">Effort</th>
						<th style="width:5%">Priority</th>
						<th style="width:30%">Tracability</th>
					    </tr>
					</thead>
					<tbody>
					    <?php
					    global $product_owner;
					    global $project_id;
					    global $ctrlBacklog;
					    global $logged;
					    
					    $userStoryList = $ctrlBacklog->getUserStoryFromProject($project_id);
					    $line;
					    while ($line = $userStoryList->fetch_assoc()){
						echo '<tr>';
						if($logged)
						{
						    echo '<td><a class="btn btn-default"
					                 style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
					                 href="#" role="button" id="changeUS"
                                                         data-toggle="modal" data-target="#modalUS'.$line['number_in_project'].'">
						          <i class="fa fa-pencil-square-o" aria-hidden="true">
						          </i>
					              </a></td>';
						}
						echo '<td>'.$line['number_in_project'].'</td>';
						echo '<td>'.$line['description'].'</td><td>'.$line['effort'].'</td>';
						$num = 1;
						if($product_owner)
						{
						    $max = $ctrlBacklog->getNumberOfUS($project_id);
						    echo '<td><select name="'.$line['us_id'].'" class="usprio form-control">';
						    while($num <= $max)
						    {	
							echo '<option value='.$num;
							if($num == $line['priority'])
							    echo ' selected';
							echo'>'.($num++).'</option>';	
						    }
						    echo '</select></td>';
						}
						else
						{
						    echo '<td>'.$line['priority'].'</td>';
						}
						echo '<td>'.$line['commit'].'</td>';
						echo '</tr>';
					    }
					    ?>
					</tbody>
				    </table>
				</div>
				<div class="row" >
				    
				    <?php global $product_owner; if ($product_owner) : ?>		
					<input type="submit" name="priosubmit" role="button"
					       id="prioButton"
					       disabled="disabled"
					       class="btn btn-primary col-lg-ofsset-9 col-lg-2 
						      col-md-offset-9 col-md-2 col-xs-offset-9 col-xs-2"
					       value="Confirm Priority">
				    <?php endif ?>
				    
				</div>
			    </form>
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
			      action="<?php global $project_id; 
				      echo htmlspecialchars($_SERVER["PHP_SELF"]).'?project_id='.$project_id;?>">
			    <legend class="title">Create UserStory</legend>
			    <div class="form-group">
				<label for="inputDescription">UserStory description</label>
				<span class ="error">* <?php global $descriptionErr; echo $descriptionErr; ?></span>
				<input name="inputDescription" type="text"
				       class="form-control" value="<?php global $inputDescription; echo $inputDescription; ?>" />
			    </div>

			    <div class="form-group">
				<label for="inputEffort">Select Effort:</label>
				<select name="inputEffort" class="form-control" >
				    <?php
				    $antelast = $last = 1;
				    echo '<option>1</option>';
				    $fibo = 0;
				    while($fibo < 100)
				    {
					$fibo = $antelast + $last;
					echo '<option>'.$fibo.'</option>';
					$antelast = $last;
					$last = $fibo;
				    }
				    ?>
				</select>
			    </div>
			    
			    <?php global $product_owner; if($product_owner) : ?>
				<div class="form-group">
				    <label for="inputEffort" >Priority</label>
				    <span class = "error">* <?php global $priorityErr; echo $priorityErr; ?></span>
				    <input name="inputPriority" type="text" class="form-control" value="<?php global $inputPriority; echo $inputPriority; ?>" />
				</div>
			    <?php endif ?>

			    <input name="project_id" type="text"  style="display:none" value="<?php global $project_id; echo $project_id; ?>"/>
			    <input name="createUS" type="submit" value="Create"/>
			</form>
		    <?php endif ?>
		</div>
		
		<?php include 'modalChangeUs.php' ?>
	    </div>
	</div>
    </body>
</html>
