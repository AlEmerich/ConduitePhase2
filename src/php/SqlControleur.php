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
	$res = $conn->multi_query($query) ;
	if ($res === false) {
	    $message ="Table non créé: ".$conn->error;
	}
	else
	{
	    do {
		/* Stockage du premier résultat */
		if ($result = $conn->store_result()) {
		    while ($row = $result->fetch_row()) {
		    
		    }
		    $result->free();
		}
		/* Affichage d'une séparation */
		if ($conn->more_results()) {
		    
		}
	    } while ($conn->next_result());
	}
	return $message;
    }
}
?>
