<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlKanban.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');

if(isset($_POST['action']) && isset($_POST['which']))
{
    $ctrlKanban = new CtrlKanban();
    $ctrlUser = new CtrlUser();
    $id = explode("_",$_POST['which']);
    $target = explode("_",$_POST['target'])[2];
    $user_id = $ctrlUser->getID($_SESSION['login'])->fetch_assoc()['dev_id'];
    $dev = $_SESSION['login'];
    if($target == 0)
    {
	$user_id = 'NULL';
	$dev = 'None';
    }
    echo $id[0]."_".$target."_".$dev;
    
    $ctrlKanban->updateKanban($id[0],$target,$user_id);
}
?>
