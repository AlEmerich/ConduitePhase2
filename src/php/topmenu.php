<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlSprint.php');
/* Menu name */
$user = "Visitor";
$ctrlS = new CtrlSprint();

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
    <a class="navbar-brand" href="<?php echo $GLOBALS['SITE_ROOT']; ?>/index.php">ScrumTool</a>
</div>

<!-- Top Menu Items -->
<ul class="nav navbar-right top-nav">
    <li class="dropdown">
	<li class="dropdown">
	    <a href=<?php echo $GLOBALS['SITE_ROOT']; ?>"/index.php" class="dropdown-toggle" data-toggle="dropdown"><i class="fa"></i><?php global $user; echo $user; ?> <b class="caret"></b></a>
	    <ul class="dropdown-menu">
		<?php if (isset($_SESSION['login'])) : ?>
		    <li>
			<a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/index.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                    </li>
                    <li><a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/createProject.php">
			<i class="fa fa-fw fa-plus-square" aria-hidden="true"></i> New project</a></li>
                    <li class="divider"></li>
                    <li>
			
			<a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/deco.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
			<a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/deleteUser.php"><i class="fa fa-fw fa-sign-out"></i> Sign out</a>
                    </li>
		<?php else: ?>
		    <li>
			<a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/connexion.php"><i class="fa fa-fw fa-user"></i> Log In</a>
                    </li>

                    <li class="divider"></li>
                    <li>
			
			<a href="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/inscription.php"><i class="fa fa-fw fa-sign-in" aria-hidden="true"></i> Sign In</a>
                    </li>
		<?php endif ?>
		
	    </ul>
	</li>
</ul>
