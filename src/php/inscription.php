<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser('dbserver','alaguitard','11235813','alaguitard');
$user;

$mail = $login = $pwd = "";
$mailErr = $loginErr = $pwdErr = "";

$create = true;
$openmodal = false;

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
	$openmodal = true;
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
	<script src="../js/inscription.js"></script>
    </head>
    
    
    <body>
	
	<?php include 'nav.php'; ?>
	
	<form class="well col-lg-6 colo-lg-offset-4 col-md-7 col-md-offset-3
		     col-xs-8 col-xs-offset-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	    
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
	    <input name="action" type="submit"  />
	</form>

	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display:none" <?php global $openmodal; if($openmodal){echo 'id="triggermodal"';} ?>></button>
	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
	    <div class="modal-dialog">
		
		<!-- Modal content-->
		<div class="modal-content">
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">User created</h4>
		    </div>
		    <div class="modal-body">
			<p><?php global $login; echo '<b>Login :</b>'.$login.'<br> ';
			   global $mail; echo '<b>Mot de passe :</b>'.$mail?></p>
		    </div>
		    <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
		
	    </div>
	</div>
    </body>
</html>
