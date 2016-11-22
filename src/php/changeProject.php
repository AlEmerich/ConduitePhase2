<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser();
if(isset($_SESSION['login']))
    $us_id = $controleur->getID($_SESSION['login']);
else
    header("Location: http://localhost:8000/index.php");
$user;

$mail = $_SESSION['mail'];
$login = $_SESSION['login'];
$pwd = $controleur->getPassword($login)->fetch_assoc()['mdp'];
$url = $_SESSION['picture'];
$mailErr = $loginErr = $pwdErr = $pwd2Err = $urlErr = "";

/* Used to create the new user when POST */
$create = true;

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['actionUser']))
{
}

function test_input($data) {
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
	
	<title>Change informations</title>
	<link rel="stylesheet" type="text/css" href="../css/basic.css">
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
		
		<?php include 'topmenu.php'; ?>
	    </nav>
	    
	    <div id="page-wrapper">
		<div class="container-fluid" >
		    <div class="row" >
			<form class="well col-lg-10
				     col-md-10 
				     col-sm-10
				     col-xs-10" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    
			    <legend class="title">Change Project information</legend>

			    
			    <input name="actionUser" type="submit" value="Confirm" />
			</form>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
