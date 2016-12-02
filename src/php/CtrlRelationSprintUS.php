<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlRelationSprintUS extends SqlControleur
{
    var $conn;

    function __construct()
    {
	$ctp = func_num_args();
	$args = func_get_args();
	$this->conn = $this->connect($ctp,$args);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/relationsSprintsUS.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    function isRelated($us_id,$project_id,$sprint_id)
    {
	$res = $this->getUSrelated($project_id,$sprint_id);
	$line;
	while($line = $res->fetch_assoc())
	{
	    if($line['us_id'] == $us_id)
	    {
		return true;
	    }
	}
	return false;
    }

    function addUS($sprint_id,$us_id)
    {
	$sql = "INSERT INTO RelationSprintsUS (sprint_id,us_id,finished) VALUES ('".$sprint_id."', '".$us_id."', 0);";
	$res = $this->conn->query($sql);
	return $res;
    }

    function removeUS($sprint_id,$us_id)
    {
	$sql = "DELETE FROM RelationSprintsUS WHERE sprint_id=".$sprint_id." AND us_id=".$us_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getUSrelated($project_id,$sprint_id)
    {
	$sql = "SELECT * FROM 
                   ((SELECT * FROM UserStory WHERE project_id=".$project_id.") AS t) 
                NATURAL JOIN RelationSprintsUS WHERE sprint_id=".$sprint_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function updateState($us_id, $sprint_id, $newstate)
    {
        $sql = "UPDATE RelationSprintsUS SET finished=".$newstate." WHERE sprint_id=".$sprint_id." AND us_id=".$us_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}

?>
