<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlRelationUSTask extends SqlControleur
{
    var $conn;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
	$this->conn = new mysqli($servername,$username,$password,$dbname);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/relationTaskUS.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function addTaskToUS($task_id,$us_id)
    {
	$sql = "INSERT INTO RelationTasksUS (task_id,us_id)
                VALUES ('".$task_id."','".$us_id."');";
	$res = $this->conn->query($sql);
	return $res;
    }

    function removeTaskToUS($task_id)
    {
	$sql = "DELETE FROM RelationTasksUS WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateRelatedUS($task_id,$us_id)
    {
	$sql = "UPDATE RelationTasksUS SET us_id=".$us_id."
                WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function getUSrelated($task_id)
    {
	$sql = "SELECT * FROM
                   ((SELECT * FROM UserStory
                     NATURAL JOIN RelationTasksUS) AS t)
                WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getTasksRelated($us_id)
    {
        $sql = "SELECT task_id FROM RelationTasksUS WHERE us_id=".$us_id;
        $res = $this->conn->query($sql);
        return $res;
    }

    
}
?>
