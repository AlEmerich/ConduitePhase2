<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser();
if(isset($_SESSION['login']))
    $us_id = $controleur->getID($_SESSION['login']);
else
    header("Location: ".$GLOBALS['SITE_ROOT']."/index.php");
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

    if (empty($_POST["urlimage"])) {
        $urlErr = "password is required";
	$create = false;
    }
    else
    {
	$url = test_input($_POST["urlimage"]);
    }

    if (empty($_POST["fpwd"])) {
        $pwdErr = "password is required";
	$create = false;
    }
    else
    {
	$pwd = test_input($_POST["fpwd"]);
    }

    if (empty($_POST["fpwd2"])) {
        $pwd2Err = "Confirm password";
	$create = false;
    }
    else
    {
	$pwd2 = test_input($_POST["fpwd2"]);
	if($pwd != $pwd2)
	{
	    $pwd2err = "Password is not equal with the first one";
	    $create = false;
	}
    }
    
    
    if($create)
    {
	$id = $controleur->getID($_SESSION['login'])->fetch_assoc()['dev_id'];
	$controleur->updateUser($id,$login,$pwd,$mail,$url);
	$_SESSION['login'] = $login;
	$_SESSION['mdp'] = $pwd;
	$_SESSION['mail'] = $mail;
	$_SESSION['picture'] = $url;
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
			    
			    <legend class="title">Change user information</legend>

			    <div class="form-group">
				<label for="texte">Login : </label>
				<span class = "error">* <?php global $loginErr; echo $loginErr; ?> </span>
				<input name="flogin" type="text" class="form-control" value="<?php global $login; echo $login; ?>"/>
			    </div>
			    
			    <div class="form-group">
				<label for="email">Email address : </label>
				<span class = "error">* <?php global $mailErr; echo $mailErr; ?> </span>
				<input name="fmail" type="email" class="form-control" value="<?php global $mail; echo $mail; ?>"/>
			    </div>
			    
			    <div class="form-group">
				<label for="pwd"> Password :</label>
				<span class = "error">* <?php global $pwdErr; echo $pwdErr; ?> </span>
				<input name="fpwd" type="password" class="form-control" value="<?php global $pwd; echo $pwd; ?>"/>
			    </div>

			    <div class="form-group">
				<label for="pwd2"> Confirm password :</label>
				<span class = "error">* <?php global $pwd2Err; echo $pwd2Err; ?> </span>
				<input name="fpwd2" type="password" class="form-control" value="<?php global $pwd2; echo $pwd2; ?>"/>
			    </div>

			    <div class="form-group">
				<label for="urlimage">Url:</label>
				<span class = "error">* <?php global $urlErr; echo $urlErr; ?> </span>
				<input name="urlimage" type="text" class="form-control" value="<?php echo $_SESSION['picture']; ?>" />
			    </div>
			    
			    <div class="alert alert-block alert-danger" style="display:none">
				<h4>Error !</h4>
				Some fields are non-consistent.
			    </div>
			    <input name="actionUser" type="submit" value="Confirm" />
			</form>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
