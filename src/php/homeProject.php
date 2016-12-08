<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

if(!isset($_GET['project_id']) || $_GET['project_id'] == '')
{
    header("Location: ".$GLOBAL['SITE_ROOT']."/index.php");
}

$project_id = htmlspecialchars($_GET['project_id']);
$ctrlProject = new CtrlProject();
$ctrlParticipates = new CtrlParticipates();
$ctrlUser = new CtrlUser();

$whatfile = "homeproject";

/**
 * Get user identity
 **/
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

$current = $ctrlProject->getProject(htmlspecialchars($project_id))->fetch_assoc();
?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include '../provideapi.php'; ?>
	
	<title><?php echo $current['project_name']; ?></title>
	
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		
		<?php include 'topmenu.php'; ?>

		<?php include 'sidebar.php'; ?>
	    </nav>

	    
	    <div id="page-wrapper" >
		<?php if(isset($_GET['dialog']) && ($_GET['dialog'] == 'remove' || $_GET['dialog'] == 'invite' || $_GET['dialog'] == 'changepo' ))
		{
		    $message;
		    if($_GET['dialog'] == 'remove')
		    {
			$message = "Succesfully removed !";
		    }
		    else if($_GET['dialog'] == 'invite')
		    {
			$message = "Succesfully added !";
		    }
		    else if($_GET['dialog'] == 'changepo')
		    {
			$message = "Product owner changed";
		    }
		    
		    echo '<div class="alert alert-success fade in">
                             <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                             <strong>Success!</strong> '.$message.'
                         </div>';
		}
		
		?>
		<div class="panel panel-primary ">
		    <div class="panel-heading">
			<div class="row" >
			    <h2 class="text-center col-lg-10 col-md-10 col-sm-10 col-xs-10 ">
				<?php global $current; echo $current['project_name']; ?>
			    </h2>
			    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 pull-right">
				<form class="form-horizontal" role="form" method="post" action="changeProject.php?project_id=<?php echo $_GET['project_id']; ?>">
				    <?php
				    if(isset($_SESSION['login']))
				    {
					echo '<div class="form-group">
		                                  <div class="pull-right">
                           			  <input id="goToProjectChange" name="submit"
                                                  type="submit" value="Modify informations"
                                                  class="btn btn-primary"></div></div>';
				    }
				    ?>
				</form>
			    </div>
			</div>
		    </div>

		    <div class="panel-body container-fluid">
			<div class="row">
			    <div class="col-lg-offset-1 col-lg-10 
					col-md-offset-1 col-md-10 
					col-sm-offset-1 col-sm-10 
					col-xs-offset-1 col-xs-10">
				<b>Description: </b> <?php echo $current['description']; ?>
			    </div>
			</div>
			<div class="row" >
			    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
			    
			    <div class="col-lg-ofsset-1 col-lg-3 col-md-offset-1 col-md-3 col-sm-ofsset-1 col-lsm-3 col-xs-offset-1 col-xs-3" >
				<div class="panel panel-default">
				    <div class="panel-heading">Product Owner
					<?php global $product_owner; if($product_owner) :  ?>
					    <a class="btn btn-default pull-right"
					       style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
					       href="#" role="button" id="changePO" data-toggle="modal" data-target="#modalPO">
						<i class="fa fa-pencil-square-o" aria-hidden="true">
						</i>
					    </a>
					<?php endif ?>
				    </div>
				    <div class="panel-body" >
					<p> Login:
					    <span class="label label-default">
						<?php
						global $ctrlProject;
						global $project_id;
						$res = $ctrlProject->getProductOwner($project_id);
						$line;
						if($line = $res->fetch_assoc())
						    echo $line['login'];
						?></span>
					</p>
					<p>
					    Mail:
					    <span class="label label-default">
						<?php
						global $ctrlProject;
						global $project_id;
						$res = $ctrlProject->getProductOwner($project_id);
						$line;
						if($line = $res->fetch_assoc())
						    echo $line['mail'];
						?></span>
					</p>
				    </div>
				</div>
			    </div>  
			</div>
			<div class="row">
			  
			    <?php global $logged; if ($logged) : ?>		
				<a role="button" href="#"
				   class="btn btn-primary 
					  col-lg-2 col-lg-offset-1
					  col-sm-3 col-sm-offset-1
					  col-md-2 col-md-offset-1
					  col-xs-3 col-xs-offset-1"
				   id="inviteContributor" data-toggle="modal" data-target="#modalInvite" >Invite contributor</a>
				
				<a role="button" href="#" 
				   class="btn btn-primary 
					  col-lg-2 col-lg-offset-1
					  col-md-2 col-sm-offset-1
					  col-sm-3 col-md-offset-1
					  col-xs-3 col-xs-offset-1" 
				   id="deleteContributor" data-toggle="modal" data-target="#modalRemove" >Remove contributor</a>
			    <?php endif ?>
			</div>
		    </div>

		    <?php include 'modalInvite.php' ?>

		    <?php include 'modalDeleting.php' ?>

		    <?php include 'modalProductOwner.php' ?>
		</div>
	    </div>
	</div>
    </body>
</html>
