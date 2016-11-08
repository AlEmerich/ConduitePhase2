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
