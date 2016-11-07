<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');

$controleur = new CtrlProject('dbserver','alaguitard','11235813','alaguitard');
$user;

$inputProjectName = $inputLinkRepository = $inputProductOwner = "";
$projectNameErr = $linkRepositoryErr = $productOwnerErr = "";

$create = true;
$openmodal = false;

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
    if (empty($_POST["inputProductOwner"])){
        $productOwnerErr = "Product Owner is required";
        $create = false;
    }
    else{
        $inputProductOwner = test_input($_POST["inputProductOwner"]);
    }
    if ($create){
        $controleur->createProject($inputProjectName, $inputLinkRepository, $inputProductOwner);
        $openmodal = true;
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
			<input name="inputProjectName" type="text" class="form-control" value="<?php global $inputProjectName; echo $inputProjectName; ?>" />
		    </div>

		    <div class="form-group">
			<label for="inputLinkRepository" >Lien vers le dépôt</label>
			<span class = "error">* <?php global $linkRepositoryErr; echo $projectNameErr; ?></span>
			<input name="inputLinkRepository" type="text" class="form-control" value="<?php global $inputLinkRepository; echo $inputLinkRepository; ?>" />
		    </div>

		    <div class="form-group">
			<label for="inputProductOwner" >Nom du product owner</label>
			<span class="error">* <?php global $productOwnerErr; echo $productOwnerErr; ?></span>
			<input name="inputProductOwner" type="text" class="form-control" value="<?php global $inputProductOwner; echo $inputProductOwner; ?>" />
		    </div>
		    <input name="action" type="submit"/>
		</form>
	    </div>
	</div>
    </body>
</html>
