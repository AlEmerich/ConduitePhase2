<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

/* Used in accueilLogIn and accueilLogOut as a global variable. */
$controleur = new CtrlParticipates();

?>

<!doctype html>
<html lang="en">
    
    <head>
	<!-- Include BootStrap and JQuery -->
	<?php include 'provideapi.php'; ?>

	<title>Conduite de projet - Outil Scrum</title>
	<link rel="stylesheet" type="text/css" href="css/basic.css">
	<script type="text/javascript" src="http://localhost:8000/js/inscription.js"></script>
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>

    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
		
		<?php include 'php/topmenu.php'; ?>

		<!-- Right side menu with profile and mail if logged in -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
		    <ul class="nav nabar-nav side-nav" >
			<div class="container-fluid">
			    <div class="row">
				<div class="fa fa-fw col-lg-12">
				    <img class="img-circle " src="http://www.getsmartcontent.com/content/uploads/2014/08/shutterstock_149293433.jpg" alt="" width="150" height="150">
				</div>
			    </div>

			    <!-- Display login -->
			    <div class="row">
				<div class="fa fa-fw col-lg-12 light-grey">
    <h1><?php if(isset($_SESSION['login'])){ echo $_SESSION['login'];} ?></h1>
				</div>
			    </div>

			    <!-- Display Email if logged in -->
			    <div class="row" >
				<div class="col-lg-12 light-grey" >
				    <?php
				    if(isset($_SESSION['login']))
				    {
					echo '<p><b>Email address: </b></br>'.$_SESSION['mail'].'</p>';
				    }
				    else
				    {
					echo '<p>You are not logged in. Please log or sign in if you don\'t have an account</p>';
				    }
				    ?>
				    
				</div>
			    </div>
			</div>
		    </ul>
		</div>
	    </nav>

	    <!-- Display the right page if logged in -->
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
