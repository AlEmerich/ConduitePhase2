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

    function getDateStop($date_start,$duration)
    {
	$date_stop = new DateTime($date_start);
	$date_stop->add(new DateInterval('P'.$duration.'D'));
	return $date_stop->format('Y-m-d');
    }

    function createSprint($project_id,$num_sprint,$state,$date_start)
    {
	$sql = "INSERT INTO Sprint (project_id, number_sprint, date_start) VALUES (".$project_id.",".$num_sprint.",'".$date_start."');";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteSprint($project_id,$sprint_id)
    {
	$nbtoremove = $this->getSprintNumberWithID($sprint_id)->fetch_assoc()['number_sprint'];
	$sql = "DELETE FROM Sprint WHERE sprint_id=".$sprint_id;
	$res = $this->conn->query($sql);

	// Rework number of sprint.
	$tmp = $nbtoremove;
	$max = $this->getNumberOfSprint($project_id);
	while($tmp++ <= $max)
	{
	    $this->updateSprintNumber($tmp-1,$tmp,$project_id);
	}
	return $res;
    }

    /**
     * Return all sprint in project.
     **/
    function getSprintFromProject($project_id)
    {
	$sql = "SELECT * FROM Sprint WHERE project_id=".$project_id.' ORDER BY number_sprint';
	$res = $this->conn->query($sql);
	return $res;
    }

    function getSprintNumberWithID($sprint_id)
    {
	$sql = "SELECT number_sprint FROM Sprint WHERE sprint_id=".$sprint_id;
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

    function updateSprintNumber($new_number_sprint,$num,$project_id)
    {
	$sql = "UPDATE Sprint SET number_sprint=".$new_number_sprint." WHERE number_sprint=".$num." AND project_id=".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateSprint($id,$state)
    {
        $sql = "UPDATE Sprint SET state = '".$state."' WHERE sprint_id IS '".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function updateTime($sprint_id,$start)
    {
	$sql = "UPDATE Sprint SET date_start='".$start."' WHERE sprint_id=".$sprint_id;
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
