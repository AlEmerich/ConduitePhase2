<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlTask extends SqlControleur
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

    function createTask($us_id,$description,$cost)
    {
	$sql = "INSERT INTO Task (us_id, description, cost, finished) VALUES (".$us_id.",".$description."', '".$cost."', 0);";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteTask($project_id,$task_id)
    {
	$nbtoremove = $this->getTaskNumberWithID($task_id)->fetch_assoc()['number_task'];
	$sql = "DELETE FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);

/*	// Rework number of sprint.
	$tmp = $nbtoremove;
	$max = $this->getNumberOfTask($project_id);
	while($tmp++ <= $max)
	{
	    $this->updateTaskNumber($tmp-1,$tmp,$project_id);
	}
	return $res;
    }*/

    /**
     * Return all sprint in project.
     **/
    function getTaskFromSprint($sprint_id)
    {
	$sql = "SELECT * FROM task_id IN (SELECT task_id IN RelationTaskUS WHERE us_id IN (SELECT us_id IN RelationSprintUS WHERE sprint_id=".$sprint_id.')) ORDER BY number_task';
	$res = $this->conn->query($sql);
	return $res;
    }

    function getTaskNumberWithID($task_id)
    {
	$sql = "SELECT number_task FROM Task  WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    /**
     * Return the number of sprint in project
     */
    function getNumberOfTask($sprint_id)
    {
	$res = $this->getTaskFromSprint($sprint_id);
	$num = 0;
	while($res->fetch_assoc())
	    $num++;
	return $num;
    }

    /**
     * Return the sprint with the number in the project.
     **/
    function getTaskWithNumberInProject($nb_id,$us_id)
    {
	$sql = "SELECT * FROM Task WHERE number_task=".$nb_id." AND task_id IN (SELECT task_id IN RelationTaskUS WHERE us_id=".$us_id.")";
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTasknumber($new_number_sprint,$num,$us_id)
    {
	$sql = "UPDATE Task SET number_task=".$new_number_sprint." WHERE number_task=".$num." AND task_id IN (SELECT task_id IN RelationTaskUS WHERE us_id=".$project_id.")";
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTask($id,$finished)
    {
        $sql = "UPDATE Task SET finished = '".$finished."' WHERE task_id IS '".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }
    
    function taskList ($sprint_id){
        $sql = "SELECT * FROM Task WHERE task_id IN (SELECT task_id WHERE us_id IN (SELECT us_id WHERE project_id=".$project_id"))";
        $res = $this->conn->query($sql);
        return $res;
    }
}

?>
