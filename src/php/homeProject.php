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
			    <a href="http://localhost:8000/php/homeProject.php"><i class="fa fa-fw fa-desktop"></i> Home Project</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/backlog.php"><i class="fa fa-fw fa-table"></i> Backlog</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/sprint.php"><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
			</li>
			<li>
			    <a href="http://localhost:8000/php/curve.php"><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
			</li>
		    </ul>
		</div>
	    </nav>
	    <div id="page-wrapper" >
	    </div>
	</div>
    </body>
</html>
