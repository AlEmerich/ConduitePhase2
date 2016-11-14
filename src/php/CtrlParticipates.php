<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlParticipates extends SqlControleur
{
    var $conn;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
	$this->conn = new mysqli($servername,$username,$password,$dbname);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/isParticipating.sql');
	
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function addToProject($project_id,$user_id)
    {
	$sql = "INSERT INTO Participates (project_id,dev_id) VALUES ('".$project_id."', '".$user_id."')";
	$res = $this->conn->query($sql);
	return $res;
    }

    function listIn($user_id)
    {
	$sql = "SELECT * FROM ((SELECT * FROM Participates NATURAL JOIN Project) AS t ) WHERE dev_id=".$user_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function listNotIn($user_id)
    {
	$sql = "SELECT * FROM ((SELECT * FROM Participates NATURAL JOIN Project) AS t ) WHERE dev_id <>".$user_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getUserWhichContributes($project_id)
    {
	$sql = "SELECT * FROM ((SELECT * FROM Participates NATURAL JOIN User) AS t) WHERE project_id=".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getUserWhichNotContributes($project_id)
    {
	$sql = "SELECT login FROM User WHERE dev_id NOT IN (SELECT dev_id FROM Participates WHERE project_id =".$project_id.")";
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function quitProject($project_id,$user_id)
    {
	$sql = "DELETE FROM Participates WHERE project_id='".$project_id."'AND dev_id='".$user_id."'";
	$res = $this->conn->query($sql);
	return $res;
    }
    
}

?>
