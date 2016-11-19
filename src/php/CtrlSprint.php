<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlSprint extends SqlControleur
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

    function createSprint($project_id,$num_sprint,$state,$date_start,$date_stop)
    {
	$sql = "INSERT INTO Sprint (project_id, number_sprint, state, date_start, date_stop) VALUES (".$project_id.",".$num_sprint.", '".$state."', '".$date_start."', '".$date_stop."');";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteSprint($sprint_id)
    {
	$sql = "DELETE FROM Sprint WHERE sprint_id=".$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    /**
     * Return all sprint in project.
     **/
    function getSprintFromProject($project_id)
    {
	$sql = "SELECT * FROM Sprint WHERE project_id=".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    /**
     * Return the number of sprint in project
     */
    function getNumberOfSprint($project_id)
    {
	$res = $this->getSprintFromProject($project_id);
	$num = 0;
	while($res->fetch_assoc())
	    $num++;
	return $num;
    }

    /**
     * Return the sprint with the number in the project.
     **/
    function getSprintWithNumberInProject($nb_id,$project_id)
    {
	$sql = "SELECT * FROM Sprint WHERE number_sprint=".$nb_id." AND project_id=".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateSprint($id,$state)
    {
        $sql = "UPDATE Sprint SET state = '".$state."' WHERE sprint_id IS '".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function updateTime($sprint_id,$start,$end)
    {
	$sql = "UPDATE Sprint SET date_start='".$start."', date_stop='".$end."' WHERE sprint_id=".$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function sprintList ($project_id){
        $sql = "SELECT * FROM Sprint WHERE project_id =".$project_id;
        $res = $this->conn->query($sql);
        return $res;
    }
}

?>
