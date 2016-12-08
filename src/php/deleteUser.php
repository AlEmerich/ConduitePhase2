<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
$ctrlUser = new CtrlUser();
$res=$ctrlUser->getID($_SESSION['login'])->fetch_assoc();
$ctrlUser->deleteUser($res['dev_id']);
$_SESSION = array();
session_destroy();
header('Location: '.$GLOBALS['SITE_ROOT'].'/index.php');
?>
