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
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createTask.sql');
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/relationTaskUS.sql');
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

    function deleteTask($task_id, $sprint_id)
    {
	$nbtoremove = $this->getTaskNumberWithID($task_id)->fetch_assoc()['number_task'];
	$sql = "DELETE FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);

   	// Rework number of tasks.
	   $tmp = $nbtoremove;
	   $max = $this->getNumberOfTask($sprint_id);
	   while($tmp++ <= $max)
	   {
	   $this->updateTaskNumber($tmp-1,$tmp,$sprint_id);
	   }
	   return $res;
	   }*/
    }

    function getTaskNumberWithID($task_id)
    {
	$sql = "SELECT number_task FROM Task WHERE task_id=".$task_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTask($id, $description, $cost, $finished)
    {
        $sql = "UPDATE Task SET description = '".$description."' WHERE task_id IS '".$id."'";
        $sql = "UPDATE Task SET cost = '".$cost."' WHERE task_id IS '".$id."'";
        $sql = "UPDATE Task SET finished = '".$finished."' WHERE task_id IS '".$id."'";
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
     * Return all task in sprint.
     **/
    function getTasksFromSprint($project_id,$sprint_id)
    {
	$sql = "SELECT * FROM
                   ((SELECT task_id FROM
                      ((SELECT * FROM 
                         ((SELECT * FROM UserStory 
                           WHERE project_id=".$project_id.") AS u) 
                      NATURAL JOIN RelationSprintsUS 
                      WHERE sprint_id=".$sprint_id.") AS t)
                   NATURAL JOIN RelationTasksUS) AS w)
                NATURAL JOIN Task";
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateTaskNumber($num,$new_num,$sprint_id)
    {
        $sql = "UPDATE Task SET number_task=".$new_number." WHERE number_sprint=".$num." AND sprint_id=".$sprint_id;
        $res = $this->conn->query($sql);
        return $res;
    }
}

?>
