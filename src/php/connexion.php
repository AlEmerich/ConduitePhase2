<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser();
$user;

$login = $pwd = "";
$loginErr = $pwdErr = "";

$connect = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["flogin"])) {
        $loginErr = "login is required";
	$connect = false;
    }
    else
    {
	$login = test_input($_POST["flogin"]);
	$user = $controleur->loginExist($login)->fetch_assoc();
	if(!$user)
	{
	    $loginErr = "login is unknown.";
	    $connect = false;
	}

	if (empty($_POST["fpwd"])) {
            $pwdErr = "password is required";
	    $connect = false;
	}
	else
	{
	    $pwd = test_input($_POST["fpwd"]);
	    $desc;
	    if($desc = $controleur->getPassword($login)->fetch_assoc())
	    {
		if($desc['mdp'] != $pwd)
		{
		    $pwdErr = "Wrong password";
		    $connect = false; 
		}
	    }
	}
    }

    if($connect)
    {
	$_SESSION['login'] = $user['login'];
	$_SESSION['mdp'] = $user['mdp'];
	$_SESSION['mail'] = $user['mail'];
	$_SESSION['picture'] = $user['picture'];
	header( 'Location: '.$GLOBALS['SITE_ROOT'].'/index.php');
    }
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
	
	<title>Connexion</title>
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
				     col-xs-10" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			    
			    <legend class="title">Please put your login and password:</legend>

			    <div class="form-group">
				<label for="texte">Login : </label>
				<span class = "error">* <?php global $loginErr; echo $loginErr; ?> </span>
				<input name="flogin" type="text" class="form-control" value="<?php global $login; echo $login; ?>"/>
			    </div>
			    
			    <div class="form-group">
				<label for="pwd"> Password :</label>
				<span class = "error">* <?php global $pwdErr; echo $pwdErr; ?> </span>
				<input name="fpwd" type="password" class="form-control" value="<?php global $pwd; echo $pwd; ?>"/>
			    </div>
			    <div class="alert alert-block alert-danger" style="display:none">
				<h4>Error !</h4>
				Some fields are non-consistent.
			    </div>
			    <input name="action" type="submit" value="Confirm" />
			</form>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
