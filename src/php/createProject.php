<?php
session_start();

if(!isset($_SESSION['login']))
{
    header("Location: http://localhost:8000/index.php");
}
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');


$controleur = new CtrlProject();
$ctrlUser = new CtrlUser();
$ctrlParticipates = new CtrlParticipates();

$inputProjectName = $inputLinkRepository = $inputProductOwner = "";
$projectNameErr = $linkRepositoryErr = $productOwnerErr = "";

$create = true;

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if (empty($_POST["inputProjectName"])){
        $projectNameErr = "Project name is required";
        $create = false;
    }
    else{
        $inputProjectName = test_input($_POST["inputProjectName"]);
    }

    if (empty($_POST["inputLinkRepository"])){
        $linkRepositoryErr = "Link to the repository is required";
        $create = false;
    }
    else{
        $inputLinkRepository = test_input($_POST["inputLinkRepository"]);
    }
    if ($create){
	$login = test_input($_SESSION['login']);
	$resUser = $ctrlUser->getID($login)->fetch_assoc();
        $controleur->createProject($inputProjectName, $inputLinkRepository, $resUser['dev_id']);
	$resProject = $controleur->getId($inputProjectName)->fetch_assoc();
	$ctrlParticipates->addToProject($resProject['project_id'],$resUser['dev_id']);
	header('Location: http://localhost:8000/index.php');
    }
}

function test_input($data){
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

	<title>Creation de projet</title>
        <link rel="stylesheet" type="text/css" href="../css/basic.css">
        <meta name="description" content="Outil scrum">
        <meta name="author" content="Groupe4">
    </head>


    <body>

	<div id="wrapper">
	    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" >
		<?php include 'topmenu.php'; ?>
	    </nav>
	    <div id="page-wrapper" >
		<form class="well 
			     col-lg-10 
			     col-md-10 
			     col-xs-10"
		      method="post"
		      action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

		    <legend class="title">Create Project</legend>
		    <div class="form-group">
			<label for="inputProjectName">Nom du projet</label>
			<span class ="error">* <?php global $projectNameErr; echo $projectNameErr; ?></span>
			<input name="inputProjectName" type="text" class="form-control"
			       value="<?php global $inputProjectName; echo $inputProjectName; ?>" />
		    </div>

		    <div class="form-group">
			<label for="inputLinkRepository" >Lien vers le dépôt</label>
			<span class = "error">* <?php global $linkRepositoryErr; echo $projectNameErr; ?></span>
			<input name="inputLinkRepository" type="url" class="form-control"
			       value="<?php global $inputLinkRepository; echo $inputLinkRepository; ?>" />
		    </div>

		    <input name="action" type="submit" value="Create" />
		</form>
	    </div>
	</div>
    </body>
</html>
