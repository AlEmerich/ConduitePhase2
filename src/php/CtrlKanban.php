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
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createKanban.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function createKanban($task_id,$state,$dev)
    {
	$sql = "INSERT INTO Kanban (task_id, state, dev_id) VALUES (".$task_id.",".$state.", '".$dev."');";
	$res = $this->conn->query($sql);
	return $res;
    }

    function getInfo($task_id)
    {
	$sql = "SELECT * FROM Kanban WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function updateKanban($task_id, $state,$dev)
    {
	$sql = "UPDATE Kanban SET state =".$state." WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}

?>
