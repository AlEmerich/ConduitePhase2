<!doctype html>

<html lang="en">

    <head>
        <?php include 'provideapi.php'; ?>

	      <title>Creation de projet</title>
        <link rel="stylesheet" type="text/css" href="css/basic.css">
        <meta name="description" content="Outil scrum">
        <meta name="author" content="Groupe4">
    </head>


    <body>
	      <form>
            <div class="form-group">
                <label form="inputProjectName">Nom du projet</label>
                <input type="text" class="form-control" id="inputProjectName" placeholder="Nom du projet" >
            </div>
            <div class="form-group">
                <label for="inputLinkRepository" >Lien vers le dépôt</label>
                <input type="text" class="form-control" id="inputLinkRepository" placeholder="http://votredepot" >
            </div>
 <div class="form-group">
                <label for="inputProductOwner" >Nom du product owner</label>
                <input type="text" class="form-control" id="inputProductOwner" placeholder="Product owner" >
            </div>
            <button type="submit" class="btn btn-default" >Ajouter Projet</button>
	      </form>
    </body>
</html>
