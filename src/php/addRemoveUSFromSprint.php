<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlRelationSprintUS.php');
/******* POST *******/
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $ctrlRel = new CtrlRelationSprintUS();
    $sprint_id = $_GET['sprint_id'];

    $mode = $_POST['USSubmit'];
    
	foreach($_POST as $key => $value)
	{
	    if($value == 'YES')
	    {
		if($mode == "Remove them")
		{
		    $ctrlRel->removeUS($sprint_id,$key);
		}
		else
		{
		    $ctrlRel->addUS($sprint_id,$key);
		}
	    }
	}

}
$project_id = $_GET['project_id'];

header('Location: '.$GLOBAL['SITE_ROOT'].'/php/sprintSingle.php?sprint_id='.$sprint_id.'&project_id='.$project_id);
?>
