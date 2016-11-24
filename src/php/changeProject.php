<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');

$controleur = new CtrlProject();
$project_info;
if(isset($_GET['project_id']))
{
    $project_info = $controleur->getProject($_GET['project_id'])->fetch_assoc();
}
else
    header("Location: http://localhost:8000/index.php");

$descErr = $linkErr = $nameErr = "";
$desc = $project_info['description'];
$link = $project_info['link_repository'];
$name = $project_info['project_name'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['actionProject']))
{
    $update = true;
    if(empty($_POST['namePro']))
    {
	$nameErr = "A project name is required";
	$update = false;
    }
    else
	$name = $_POST['namePro'];

    if(empty($_POST['description']))
    {
	$descErr = "A description is required";
	$update = false;
    }
    else
	$desc = $_POST['description'];

    if(empty($_POST['link']))
    {
	$linkErr = "A link repository is required";
	$update = false;
    }
    else
	$link = $_POST['link'];

    if($update)
    {
	$controleur->updateProjectWithoutPO($project_info['project_id'],$name,$link,$desc);
	header("Location: http://localhost:8000/php/homeProject.php?project_id=".$project_info['project_id']);
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
				     col-xs-10" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]).'?project_id='.$_GET['project_id'];?>">
			    
			    <legend class="title">Change Project information</legend>
			    <div class="form-group" >
				<label for="NamePro">Url:</label>
				<span class = "error">* <?php global $nameErr; echo $nameErr; ?> </span>
				<input name="namePro" type="text" class="form-control" value="<?php echo $name; ?>" />
			    </div>

			    <div class="form-group" >
				<label for="description">Description:</label>
				<span class = "error">* <?php global $descErr; echo $descErr; ?> </span>
				<textarea name="description" type="text" class="form-control" value="<?php echo $desc; ?>" ></textarea>
			    </div>
			    
			    <div class="form-group" >
				<label for="link">Link repository:</label>
				<span class = "error">* <?php global $linkErr; echo $linkErr; ?> </span>
				<input name="link" type="text" class="form-control" value="<?php echo $link; ?>" />
			    </div>

			    <input name="actionProject" type="submit" value="Confirm" />
			</form>
		    </div>
		</div>
	    </div>
	</div>
    </body>
</html>
