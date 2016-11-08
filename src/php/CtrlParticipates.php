<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlParticipates extends SqlControleur
{
    var $conn;

    function __construct($servername,$username,$password,$dbname)
    {
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

    function listAll()
    {
	$sql = "SELECT project_id FROM Participates NATURAL JOIN Project;";
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function quitProject($user_id,$project_id)
    {
	$sql = "DELETE FROM Participates WHERE user_id='".$user_id."' AND project_id='".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }
    
}

?>
