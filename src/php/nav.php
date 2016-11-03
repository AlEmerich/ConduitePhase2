<nav class="navbar navbar-inverse navbar-default bg-faded">
    <div class="container-fluid">
	<div class="navbar-header">
	    <?php echo '<a class="navbar-brand" href="http://localhost:8000/index.php">SCRUMTool</a>'; ?>
	</div>
	<?php
	echo '<a href="http://localhost:8000/index.php" class="btn btn-primary btn-lg active" role="button">Home</a>';
	?>
	<?php
	if(isset($_SESSION['login']))
	{
	    echo '<a href="http://localhost:8000/php/deco.php" class="btn btn-default btn-lg active" role="button">Log out</a>';
	}
	else
	{
	    echo '<a href="http://localhost:8000/php/connexion.php" class="btn btn-default btn-lg active" role="button">Log In</a>';
	    echo '<a href="http://localhost:8000/php/inscription.php" class="btn btn-default btn-lg active" role="button">Sign In</a>';
	}?>
	
    </div>
</nav>
