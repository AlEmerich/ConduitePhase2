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

    function createSprint($project_id,$state,$date_start,$date_stop)
    {
	$sql = "INSERT INTO Sprint (project_id,state,date_start,date_stop) VALUES ('".$project_id."', '".$state."', '".$date_start."', '".$date_stop."')";
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateSprint($id,$state)
    {
        $sql = "UPDATE Sprint SET state = '".$state."' WHERE sprint_id IS '".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }
}

?>
