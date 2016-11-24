<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$ctrlParticipates = new CtrlParticipates();
$project_id = "";

$whatfile = "curve";

if (isset($_GET["project_id"]))
    $project_id = htmlspecialchars($_GET["project_id"]);
else
    header("Location: http://localhost:8000/index.php");

$logged = false;
if(isset($_SESSION['login']))
{
    $users = $ctrlParticipates->getUserWhichContributes($_GET['project_id']);
    $line;
    while($line = $users->fetch_assoc())
    {
	if($line['login'] == $_SESSION['login'])
	    $logged = true;
    }
}
?>

<!doctype html>
<html lang="en">
    
    <head>
	<?php include '../provideapi.php'; ?>
	
	<title>Curve</title>
	<meta name="description" content="Outil scrum">
	<meta name="author" content="Groupe4">
    </head>
    
    
    <body>
	<div id="wrapper" >
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<?php include 'topmenu.php'; ?>

		<?php include 'sidebar.php'; ?>
	    </nav>
	</div>
	<div id="page-wrapper" >
	</div>
    </body>
</html>
