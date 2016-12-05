<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlTask extends SqlControleur
{
    var $conn;

    function __construct()
    {
	$this->conn = $this->connect();
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createTask.sql');
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/relationTaskUS.sql');
    }

    function __destruct()
    {
	ConnectSingleton::close();
    }

    function createTask($project_id,$sprint_id,$description,$num_task,$cost)
    {
	$sql = "INSERT INTO Task (project_id,sprint_id,number_task, description, cost, finished) 
                VALUES ('".$project_id."','".$sprint_id."','".$num_task."', '".$description."','".$cost."', 0);";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteTask($project_id,$sprint_id,$task_id)
    {
	$nbtoremove = $this->getTaskNumberWithID($task_id)->fetch_assoc()['number_task'];
	$sql = "DELETE FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);

		// Rework number of task.
	$tmp = $nbtoremove;
	$max = $this->getNumberOfTask($project_id,$sprint_id);
	while($tmp++ <= $max)
	{
	    $this->updateTaskNumber($tmp-1,$tmp,$project_id,$sprint_id);
	}
	return $res;
    }

    function getTaskWithNumber($task_nb,$project_id,$sprint_id)
    {
	$sql = "SELECT * FROM Task WHERE number_task=".$task_nb.' AND project_id='.$project_id.' AND sprint_id='.$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getTaskNumberWithID($task_id)
    {
	$sql = "SELECT number_task FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTask($id,$description,$cost)
    {
        $sql = "UPDATE Task SET description='".$description."',
                cost='".$cost."'
                WHERE task_id='".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    /**
     * Return the number of sprint in project
     */
    function getNumberOfTask($project_id,$sprint_id)
    {
	$res = $this->getTasksFromSprint($project_id,$sprint_id);
	$num = 0;
	while($res->fetch_assoc())
	    $num++;
	return $num;
    }

    /**
     * Return all task in sprint.
     **/
    function getTasksFromSprint($project_id,$sprint_id)
    {
	$sql = "SELECT * FROM Task WHERE sprint_id=".$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTaskNumber($new,$nb,$project_id,$sprint_id)
    {
	$sql = "UPDATE 
                   Task
                SET number_task=".$new." WHERE number_task=".$nb.' AND project_id='.$project_id.' AND sprint_id='.$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getSprintFromTask($task_id)
    {
       	$sql = "SELECT sprint_id FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}

?>
