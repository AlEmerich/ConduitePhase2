<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

$controleur = new CtrlUser('dbserver','alaguitard','11235813','alaguitard');
$user;


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
	  
	  <?php include 'nav.php'; ?>
	  
	  <form class="well col-lg-6 colo-lg-offset-4 col-md-7 col-md-offset-3
		       col-xs-8 col-xs-offset-2" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	      
	      <legend class="title">Sign In</legend>

	      <div class="form-group">
		  <label for="email">Email address : </label>
		  <input name="fmail" type="email" class="form-control" value=""/>
	      </div>
	      
	      <div class="form-group">
		  <label for="texte">Login : </label>
		  <span class = "error">* </span>
		  <input name="flogin" type="text" class="form-control" value=""/>
              </div>
                                                        
              <div class="form-group">
		  <label for="pwd"> Password :</label>
		  <input name="fpwd" type="password" class="form-control" value=""/>
		  <span class = "error">* </span>
	      </div>
	      <div class="alert alert-block alert-danger" style="display:none">
                  <h4>Error !</h4>
                  Some fields are non-consistent.
              </div>
	      <input name="action" type="submit"  />
	  </form>
      </body>
</html>
