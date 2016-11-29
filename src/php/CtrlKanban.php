<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlKanban extends SqlControleur
{
    var $conn;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
	$this->conn = new mysqli($servername,$username,$password,$dbname);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createSprint.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function createKanban($sprint_id,$task_sprint,$state,$dev)
    {
	$sql = "INSERT INTO Kanban (sprint_id, task_id, state, dev) VALUES (".$sprint_id.",".$task_id.",".$state.", '".$dev."');";
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateKanban($sprint_id, $task_id, $state,$dev)
    {
	$sql = "UPDATE Kanban SET state =".$state." WHERE sprint_id=".$sprint_id." AND task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}

?>
