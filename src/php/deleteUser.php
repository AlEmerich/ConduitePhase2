<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
$ctrlUser = new CtrlUser();
$res=$ctrlUser->getID($_SESSION['login'])->fetch_assoc();
$ctrlUser->deleteUser($res['id']);
$_SESSION = array();
session_destroy();
header('Location: http://localhost:8000/index.php');
?>
