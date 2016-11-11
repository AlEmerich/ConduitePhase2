<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

if(!isset($_SESSION['login']) || !isset($_GET['project_id']))
{
    header("Location: http://localhost:8000/index.php");
}

$project_id = htmlspecialchars($_GET['project_id']);
$ctrlProject = new CtrlProject("dbserver","alaguitard","11235813","alaguitard");
$ctrlParticipates = new CtrlParticipates('dbserver','alaguitard','11235813','alaguitard');
$ctrlUser = new CtrlUser('dbserver','alaguitard','11235813','alaguitard');

$current = $ctrlProject->getProject(htmlspecialchars($project_id))->fetch_assoc();
?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include '../provideapi.php'; ?>
	
	<title>Inscription</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css">
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		
		<?php include 'topmenu.php'; ?>

		<div class="collapse navbar-collapse navbar-ex1-collapse">
		    <ul class="nav navbar-nav side-nav">
			<li class="active">
			    <a href="http://localhost:8000/php/homeProject.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-desktop"></i> Home Project</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/backlog.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-table"></i> Backlog</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/sprint.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/curve.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
			</li>
		    </ul>
		</div>
	    </nav>
	    <div id="page-wrapper" >
		<div class="panel panel-primary ">
		    <div class="panel-heading">
			<div class="row" >
			    <h2 class="text-center">
				<?php global $current; echo $current['project_name']; ?>
			    </h2>
			</div>
		    </div>
		    
		    <div class="panel-body">
			<div class="row" >
			    <div class="col-lg-12 col-md-12 col-xs-12 text-center">
				<b>Link to Github repository:</b> <?php echo '<a href="'.$current['link_repository'].'">'.$current['link_repository'].'</a>'; ?>
			    </div>
			</div>
			<div class="row" >
			    <div class="col-lg-8 col-md-8 col-xs-8 table-responsive">
				<table class="table" >
				    <thead>
					<tr>
					    <th>Login</th>
					    <th>Mail address</th>
					</tr>
				    </thead>
				    <tbody>
					<?php
					global $project_id;
					global $ctrlParticipates;
					$users = $ctrlParticipates->getUserWhichContributes($project_id);
					$line;
					while($line = $users->fetch_assoc())
					{
					    echo '<tr><td>'.$line['login'].'</td><td>'.$line['mail'].'</td></tr>';
					}
					?>
				    </tbody>
				</table>
			    </div>

			    <a role="button" href="#" class="btn btn-primary col-lg-ofsset-1 col-lg-2 col-md-offset-1 col-md-2 col-xs-offset-1 col-xs-2" data-toggle="modal" data-target="#modalInvite" >Invite contributor</a>
			    
			    <a role="button" href="http://localhost/php/removeContributor.php?project_id=<?php global $project_id; echo $project_id; ?>" class="btn btn-primary col-lg-ofsset-1 col-lg-2 col-md-offset-1 col-md-2 col-xs-offset-1 col-xs-2" id="deleteContributor" >Delete contributor</a>
			</div>
		    </div>
		</div>
	    </div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="modalInvite" tabindex="-1" role="dialog" aria-labelledby="modalInviteLabel">
	    <div class="modal-dialog" role="document">
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Choose the new contributor</h4>
		    </div>
		    <form action="http://localhost:8000/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
			<div class="modal-body">
			    <div class="list-group" >
				<?php
				global $ctrlUser;
				global $ctrlParticipates;
				global $project_id;
				$usersNotIn = $ctrlParticipates->getUserWhichNotContributes($project_id);
				$line;
				
				while($line = $usersNotIn->fetch_assoc())
				{
				    echo '<div class="list-group-item">';
				    echo '<label for="'.$line['login'].'">'.$line['login'].'</label>';
				    echo '<input class="pull-right" type="checkbox" name="'.$line['login'].'" value="YES"/>';
				    echo '</div>';
				}
				
				?>
				
			    </div>
			</div>
			<div class="modal-footer">
			    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
			    <input type="submit" name="invitSubmit" role="button" class="btn btn-primary" value="Send invitations"></input>
			</div>
		    </form>
		</div>
	    </div>
	</div>
    </body>
</html>
