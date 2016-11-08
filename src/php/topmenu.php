<?php
$user = "Visitor";
if(isset($_SESSION['login']))
{
    $user = $_SESSION['login'];
}
?>

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
	    <span class="sr-only">Toggle navigation</span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
	    <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="http://localhost:8000/index.php">ScrumTool</a>
    </div>

<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
	<li class="dropdown">
	    <a href="http://localhost:8000/index.php" class="dropdown-toggle" data-toggle="dropdown"><i class="fa"></i><?php global $user; echo $user; ?> <b class="caret"></b></a>
	    <ul class="dropdown-menu">
		<?php
		if(isset($_SESSION['login']))
		{
		    echo '<li>
			<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li><a href="http://localhost:8000/php/createProject.php">
                       <i class="fa fa-fw fa-plus-square" aria-hidden="true"></i> New project</a></li>
                    <li class="divider"></li>
                    <li>
			
			<a href="http://localhost:8000/php/deco.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
            <a href="http://localhost:8000/php/deleteUser.php"><i class="fa fa-fw fa-power-off"></i> Delete User</a>
                    </li>';
		}
		else
		{
		    echo '<li>
			<a href="http://localhost:8000/php/connexion.php"><i class="fa fa-fw fa-user"></i> Log In</a>
                    </li>

                    <li class="divider"></li>
                    <li>
			
			<a href="http://localhost:8000/php/inscription.php"><i class="fa fa-fw fa-sign-in" aria-hidden="true"></i> Sign In</a>
                    </li>';
		}
		?>
		
	    </ul>
	</li>
</ul>
