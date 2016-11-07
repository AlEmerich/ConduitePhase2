<?php
session_start();

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
		<div class="container-fluid">	      
		    <div class="row" >
			
			<div class="well col-lg-10
				    col-md-10
				    col-xs-10" id="welcome" >
			    
			    <?php
			    if(isset($_SESSION['login']))
			    {
				echo 'Welcome back, '.$_SESSION['login'];
			    }
			    else
			    {
				echo 'Welcome, Visitor';
			    }
			    
			    ?>
			</div>
			
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
