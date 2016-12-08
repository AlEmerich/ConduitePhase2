<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: '.$GLOBAL['SITE_ROOT'].'/index.php');
?>
