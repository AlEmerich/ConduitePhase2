<?php
class SqlControleur
{

    function executeQueryFile($conn,$filesql) {
        $query = file_get_contents($filesql);
	$message = "";
        
	/* Vérification de la connexion */
	if ($conn->connect_errno) {
	    $message = 'Échec de la connexion : '.$conn->connect_error.'\n';
	    exit();
	}
	/* "Create table" */
	if ($conn->query($query) === TRUE) {
	    $message = 'Table créée avec succès.\n';
	}
	
        return $message;
    }
}
?>
