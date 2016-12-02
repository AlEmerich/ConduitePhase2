<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlKanban extends SqlControleur
{
    var $conn;

    function __construct()
    {
	$ctp = func_num_args();
	$args = func_get_args();
	$this->conn = $this->connect($ctp,$args);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createKanban.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function createKanban($task_id,$state)
    {
	$sql = "INSERT INTO Kanban (task_id, state) VALUES (".$task_id.",".$state.");";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteKanban($task_id)
    {
	$sql = "DELETE FROM Kanban WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getInfo($task_id)
    {
	$sql = "SELECT * FROM Kanban WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function updateKanban($task_id, $state,$dev_id)
    {
	$sql = "UPDATE Kanban SET state =".$state.", dev_id='.$dev_id.' WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}

?>
