<?php

session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

/* Used in accueilLogIn and accueilLogOut as a global variable. */
$controleur = new CtrlParticipates();
$ctrlUser = new CtrlUser();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(!empty($_POST['confirmPicture']) && !empty($_POST['urlimage']))
    {
	$ctrlUser->changePicture($_SESSION['login'],$_POST['urlimage']);
	$_SESSION['picture'] = $_POST['urlimage'];
    }
    elseif(!empty($_POST['confirmMail']) && !empty($_POST['mail']))
    {
	$ctrlUser->changeMail($_SESSION['login'],$_POST['mail']);
	$_SESSION['mail'] = $_POST['mail'];
    }
    elseif(!empty($_POST['confirmLogin']) && !empty($_POST['login']))
    {
	$ctrlUser->changeLogin($_SESSION['login'],$_POST['login']);
	$_SESSION['login'] = $_POST['login'];
    }
}

?>

<!doctype html>
<html lang="en">
    
    <head>
	<!-- Include BootStrap and JQuery -->
	<?php include 'provideapi.php'; ?>

	<title>ScrumTool</title>
	<link rel="stylesheet" type="text/css" href="css/basic.css">
	<script type="text/javascript"
		src="<?php echo $GLOBAL['SITE_ROOT']; ?>/js/inscription.js">
	 
	</script>
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
				    <img class="img-circle "
					 src="
					      <?php
					      if(isset($_SESSION['picture']))
					      {
						  if(empty($_SESSION['picture']))
						      echo 'http://www.getsmartcontent.com/content/uploads/2014/08/shutterstock_149293433.jpg';
						  else
						      echo $_SESSION['picture'];
					      }
					      else
					      {
						  echo 'http://www.getsmartcontent.com/content/uploads/2014/08/shutterstock_149293433.jpg';
					      }
					      
					      ?>" alt="" width="150" height="150"></a>
				</div>
			    </div>

			    <!-- Display login -->
			    <div class="row">
				<div class="fa fa-fw col-lg-12 light-grey">
				    <h1><?php if(isset($_SESSION['login']))
					{
					    echo $_SESSION['login'];
					} ?></h1>
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

			    <div class="row" >
				<div class="col-lg-12 col-md-12 col-xs-12">
				    <form class="form-horizontal" role="form" method="post" action="php/changeUser.php">
					<?php
					if(isset($_SESSION['login']))
					{
					    echo '<div class="form-group">
		                                  <div class="col-lg-offset-1
                                                       col-md-offset-1 col-sm-offset-1 
                                                       col-xs-offset-1">
                           			  <input id="goToUserChange" name="submit"
                                                  type="submit" value="Modify informations"
                                                  class="btn btn-primary"></div></div>';
					}
					?>
				    </form>
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
