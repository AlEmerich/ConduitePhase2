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

    function addToProject($user_id,$project_id)
    {
	$sql = "INSERT INTO Participates (user_id,project_id) VALUES ('".$user_id."', '".$project_id."')";
	$res = $this->conn->query($sql);
	return $res;
    }

    function listIn($user_id)
    {
	$sql = "SELECT project_id FROM Participates WHERE login='".$user_id."'
               NATURAL JOIN Project;";
	$res = $this->conn->query($sql);
	return $res;
    }

    function listNotIn($user_id)
    {
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
