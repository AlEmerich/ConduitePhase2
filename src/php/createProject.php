<?php

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
        $inputProductOwner = test_input($_POST["inputPorductOwner"]);
    }
    if ($create){
        $controleur->createProject($inputProjectName, $inputLinkRepository, $inputPruductOwner);
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
        <?php include 'provideapi.php'; ?>

	      <title>Creation de projet</title>
        <link rel="stylesheet" type="text/css" href="../css/basic.css">
        <meta name="description" content="Outil scrum">
        <meta name="author" content="Groupe4">
    </head>


    <body>

        <?php include 'nav.php'; ?>
	      <form class="well col-lg-6 colo-lg-offset-4 col-md-7 col-md-offset-3 col-xs-8 col-xs-offset-2"
              method="post"
              action="<?php echo htmlspecialchars($_SERVER["PHP_self"]);?>">

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
    </body>
</html>
