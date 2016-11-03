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
	  <?php include 'php/nav.php'; ?>
	  <div class="container-fluid">	      
	      <div class="row" >
		  <div class="col-lg-2 col-md-2 col-xs-2"></div>
		  <div class="well col-lg-8 col-md-8 col-xs-8" id="welcome" >
		  
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
		  <div class="col-lg-2 col-md-2 col-xs-2"></div>
	      </div>
	  </div>
      </body>
</html>
