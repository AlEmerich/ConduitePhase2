<!doctype html>
<html lang="en">
    
    <head>
	  <?php include 'provideapi.php'; ?>
	  
	  <title>Inscription</title>
      <link rel="stylesheet" type="text/css" href="css/basic.css">
      <meta name="description" content="Outil scrum">
      <meta name="author" content="Groupe4">
      </head>
      
      
      <body>
	  <form>
	      <div class="form-group">
		  <label form="inputLogin">Login</label>
		  <input type="text" class="form-control" id="inputLogin" placeholder="Login" >
	      </div>
	      <div class="form-group">
		  <label for="inputPassword" >Password</label>
		  <input type="password" class="form-control" id="inputPassword" placeholder="Password" >
	      </div>
	      <div class="form-group" >
		  <label for="inputEmail" >Email address</label>
		  <input type="email" class="form-control" id="inputEmail" placeholder="Email" >
	      </div>
	      <button type="submit" class="btn btn-default" >Sign in</button>
	  </form>
      </body>
</html>
