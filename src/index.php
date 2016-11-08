<?php 
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$controleur = new CtrlParticipates('dbserver','alaguitard','11235813','alaguitard');

?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include 'provideapi.php'; ?>

	<title>Conduite de projet - Outil Scrum</title>
	<link rel="stylesheet" type="text/css" href="css/basic.css">
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>

    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
		<?php include 'php/topmenu.php'; ?>
		<div class="collapse navbar-collapse navbar-ex1-collapse">
		    <ul class="nav nabar-nav side-nav" >
			<div class="container-fluid">
			    <div class="row">
				<div class="fa fa-fw col-lg-12">
				    <img class="img-circle " src="http://webneel.com/wallpaper/sites/default/files/images/01-2014/15-flower-wallpaper.preview.jpg" alt="" width="150" height="150">
				</div>
			    </div>

			    <div class="row">
				<div class="fa fa-fw col-lg-12 light-grey">
				    <h1><?php echo $_SESSION['login']; ?></h1>
				</div>
			    </div>

			    <div class="row" >
				<div class="col-lg-12 light-grey" >
				    <p><b>Email address: </b></br><?php echo $_SESSION['mail']; ?></p>
				</div>
			    </div>
			</div>
		    </ul>
		</div>
	    </nav>
	    
	    <div id="page-wrapper" >
		<?php
		if(isset($_SESSION['login']))
		{
		    include 'php/acceuilLogIn.php';
		}
		else
		{
		    include 'php/acceuilLogOut.php';
		}
		
		?>
	    </div>
	</div>
    </body>
</html>
