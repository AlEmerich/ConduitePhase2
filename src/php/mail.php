<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

if(!empty($_POST) && !empty($_SESSION))
{
    foreach($_POST as $key => $value)
    {
	if($value == 'YES')
	{
	    $ctrlU = new CtrlUser();
	    $ctrlProject = new CtrlProject();
	    $ctrlParticipates = new CtrlParticipates();
	    
	    $mail = $ctrlU->getMail($value); // Déclaration de l'adresse de destination.
	    //$mail = "guitard-alan@laposte.net";
	    if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
	    {
		$passage_ligne = "\r\n";
	    }
	    else
	    {
		$passage_ligne = "\n";
	    }
	    //=====Déclaration des messages au format texte et au format HTML.
	    $message_txt = "Hello, you are now set as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool";
	    $message_html = "<html><head></head><body><b>Hello</b>, you are now set as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']."</body></html>";
	    //==========

	    //=====Création de la boundary
	    $boundary = "-----=".md5(rand());
	    //==========

	    //=====Définition du sujet.
	    $sujet = "Invitation par ".$_SESSION['login'];
	    //=========

	    //=====Création du header de l'e-mail.
	    $header = "From: \"WeaponsB\"<weaponsb@mail.fr>".$passage_ligne;
	    $header.= "Reply-to: \"WeaponsB\" <weaponsb@mail.fr>".$passage_ligne;
	    $header.= "MIME-Version: 1.0".$passage_ligne;
	    $header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
	    //==========

	    //=====Création du message.
	    $message = $passage_ligne."-".$key."-".$boundary.$passage_ligne;
	    //=====Ajout du message au format texte.
	    $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$passage_ligne;
	    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	    $message.= $passage_ligne.$message_txt.$passage_ligne;
	    //==========
	    $message.= $passage_ligne."--".$boundary.$passage_ligne;
	    //=====Ajout du message au format HTML
	    $message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
	    $message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
	    $message.= $passage_ligne.$message_html.$passage_ligne;
	    //==========
	    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	    $message.= $passage_ligne."--".$boundary."--".$passage_ligne;
	    //==========

	    //=====Envoi de l'e-mail.
	    mail($mail,$sujet,$message,$header);
	    //==========

	    $ctrlParticipates->addToProject($_GET['project_id'],$ctrlU->getID($key)->fetch_assoc()['dev_id']);
	}
    }
}
header('Location: http://localhost:8000/php/homeProject.php?project_id='.$_GET['project_id']);
?>
