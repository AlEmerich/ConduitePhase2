<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlKanban.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlTask.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationSprintUS.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationUSTask.php');

if(isset($_POST['action']) && isset($_POST['which']))
{
    $ctrlKanban = new CtrlKanban();
    $ctrlUser = new CtrlUser();
    $ctrlRelationSprintUS = new CtrlRelationSprintUS();
    $ctrlRelationUSTask =  new CtrlRelationUSTask();
    $ctrlTask = new CtrlTask();
    $id = explode("_",$_POST['which']);
    $target = explode("_",$_POST['target'])[2];
    $user_id = $ctrlUser->getID($_SESSION['login'])->fetch_assoc()['dev_id'];
    $dev = $_SESSION['login'];
    if($target == 0)
    {
	$user_id = 'NULL';
	$dev = 'None';
    }
    echo $id[0]."_".$target."_".$id[2]."_".$dev;

    $ctrlKanban->updateKanban($id[0],$target,$user_id);
  

    $us_done=1;
    $us = $ctrlRelationUSTask->getUSrelated($id[0])->fetch_assoc()['us_id'];
    $tasks = $ctrlRelationUSTask->getTasksRelated($us);
    $task_line;
    while($task_line = $tasks->fetch_assoc())
        {
            $info = $ctrlKanban->getInfo($task_line['task_id'])->fetch_assoc();
            if (($info['state'] != 2) && ($ctrlTask->getSprintFromTask($task_line['task_id']) == id[2]))
                {
                    $us_done = 0;
                }
        }
    $ctrlRelationSprintUS->updateState($us, $id[2], $us_done);
}
?>
