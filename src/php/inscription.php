<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser();
$user;

$mail = $login = $pwd = "";
$mailErr = $loginErr = $pwdErr = "";

/* Used to create the new user when POST */
$create = true;

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if (empty($_POST["fmail"])) {
        $mailErr = "mail is required";
	$create = false;
    }
    else
    {
	$mail = test_input($_POST["fmail"]);
    }

    if (empty($_POST["flogin"])) {
        $loginErr = "login is required";
	$create = false;
    }
    else
    {
	$login = test_input($_POST["flogin"]);
    }

    if (empty($_POST["fpwd"])) {
        $pwdErr = "password is required";
	$create = false;
    }
    else
    {
	$pwd = test_input($_POST["fpwd"]);
    }
    
    if($controleur->mailExist($mail)->fetch_assoc())
    {
	$mailErr = "Email address is already used.";
	$create = false;
    }
    if($controleur->loginExist($login)->fetch_assoc())
    {
	$loginErr = "login is already used.";
	$create = false;
    }
    
    if($create)
    {
	$controleur->createUser($login,$pwd,$mail);
	$_SESSION['login'] = $login;
	$_SESSION['mdp'] = $pwd;
	$_SESSION['mail'] = $mail;
	$_SESSION['picture'] = $controleur->getPicture($login)->fetch_assoc()['picture'];
	header( 'Location: '.$GLOBAL['SITE_ROOT']'/index.php');
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
	
	<title>Inscription</title>
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
			    
			    <legend class="title">Sign In</legend>

			    <div class="form-group">
				<label for="email">Email address : </label>
				<span class = "error">* <?php global $mailErr; echo $mailErr; ?> </span>
				<input name="fmail" type="email" class="form-control" value="<?php global $mail; echo $mail; ?>"/>
			    </div>
			    
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
