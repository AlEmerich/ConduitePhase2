<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlParticipates.php');

$dialog;
if(!empty($_POST) && !empty($_SESSION) && !empty($_POST['mailSubmit']))
{
    /*********************************************************/
    /**************   INVITING CONTRIBUTORS  *****************/
    /*********************************************************/
    $mode = $_POST['mailSubmit'];
    if($mode == 'Send invitations')
    {
	foreach($_POST as $key => $value)
	{
	    if($value == 'YES')
	    {
		$ctrlU = new CtrlUser();
		$ctrlProject = new CtrlProject();
		$ctrlParticipates = new CtrlParticipates();
		
		$mail = $ctrlU->getMail($key)->fetch_assoc()['mail']; // Déclaration de l'adresse de destination.
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
		$message_txt = "Hello, you are now set as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool.\n Have a great work !";
		$message_html = "<html><head></head><body><b>Hello</b>, you are now set as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool. <br> Have a great work !</body></html>";
		//==========

		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========

		//=====Définition du sujet.
		$sujet = "Invitation from ".$_SESSION['login'];
		//=========

		//=====Création du header de l'e-mail.
		$header = "From: \"ScrumTool\"<weaponsb@mail.fr>".$passage_ligne;
		$header.= "Reply-to: \"ScrumTool\" <weaponsb@mail.fr>".$passage_ligne;
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
		//mail($mail,$sujet,$message,$header);
		//==========
		
		$ctrlParticipates->addToProject($_GET['project_id'],$ctrlU->getID($key)->fetch_assoc()['dev_id']);
		$dialog = 'invite';
	    }
	}
    }

    /*********************************************************/
    /******************* REMOVE CONTRIBUTOR ******************/
    /*********************************************************/
    else if($mode == 'Remove them')
    {
	
	foreach($_POST as $key => $value)
	{
	    if($value == 'YES')
	    {
		$ctrlU = new CtrlUser();
		$ctrlProject = new CtrlProject();
		$ctrlParticipates = new CtrlParticipates();
		
		$mail = $ctrlU->getMail($key)->fetch_assoc()['mail']; // Déclaration de l'adresse de destination.
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
		$message_txt = "Hello, You have been removed as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool.\n We hope we will see you again !";
		$message_html = "<html><head></head><body><b>Hello</b>, You have been removed as a contributor on the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool.<br> We hope we will see you again !</body></html>";
		//==========
		
		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========
		
		//=====Définition du sujet.
		$sujet = "Removed from ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name'];
		//=========
		
		//=====Création du header de l'e-mail.
		$header = "From: \"ScrumTool\"<weaponsb@mail.fr>".$passage_ligne;
		$header.= "Reply-to: \"ScrumTool\" <weaponsb@mail.fr>".$passage_ligne;
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
		//mail($mail,$sujet,$message,$header);
		//==========
		$ids = $ctrlU->getID($key)->fetch_assoc();
		$idtoremove = $ids['dev_id'];
		$p_id = $ctrlParticipates->getID($_GET['project_id'], $idtoremove)->fetch_assoc();
		$res  = $ctrlParticipates->quitProject($p_id['p_id']);
		$dialog ='remove';
	    }
	}
	
	
    }
    /*********************************************************/
    /**************** CHANGE PRODUCT OWNER *******************/
    /*********************************************************/
    else if($mode == 'Change Product Owner')
    {
	foreach($_POST as $key => $value)
	{
	    echo $value;
	    $ctrlU = new CtrlUser();
	    $ctrlProject = new CtrlProject();
	    
	    $mail = $ctrlU->getMail($value)->fetch_assoc()['mail']; // Déclaration de l'adresse de destination.
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
	    $message_txt = "Hello, you are now set as the product owner of the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool.\n Have a great work !";
	    $message_html = "<html><head></head><body><b>Hello</b>, you are now set as the product owner of the project ".$ctrlProject->getProject($_GET['project_id'])->fetch_assoc()['project_name']." in ScrumTool. <br> Have a great work !</body></html>";
	    //==========

	    //=====Création de la boundary
	    $boundary = "-----=".md5(rand());
	    //==========

	    //=====Définition du sujet.
	    $sujet = "Made Product Owner from ".$_SESSION['login'];
	    //=========

	    //=====Création du header de l'e-mail.
	    $header = "From: \"ScrumTool\"<weaponsb@mail.fr>".$passage_ligne;
	    $header.= "Reply-to: \"ScrumTool\" <weaponsb@mail.fr>".$passage_ligne;
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
	    //mail($mail,$sujet,$message,$header);
	    //==========

	    $ctrlProject->addProductOwner($_GET['project_id'],$ctrlU->getID($value)->fetch_assoc()['dev_id']);
	    $dialog = 'changepo';
	}
    }

    /*********************************************************/
    /**************** CHANGE PRODUCT OWNER *******************/
    /*********************************************************/
    else if($mode == 'Remove project')
    {
	$ctrlProject = new CtrlProject();
	$ctrlProject->deleteProject($_GET['project_id']);
	header('Location: http://localhost:8000/php/index.php');
	$dialog = '';
    }
}

header('Location: http://localhost:8000/php/homeProject.php?project_id='.$_GET['project_id'].'&dialog='.$dialog);
?>
