<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlBacklog.php');

$project_id;
if (isset($_GET["project_id"]) && $_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SESSION))
{
    $project_id = htmlspecialchars($_GET["project_id"]);
    $ctrlBl = new CtrlBacklog();
    
    foreach($_POST as $key => $value)
    {
	$ctrlBl->changePriority($key,$value);
    }
}
header('Location: '.$GLOBAL['SITE_ROOT'].'/php/backlog.php?project_id='.$project_id);
?>
