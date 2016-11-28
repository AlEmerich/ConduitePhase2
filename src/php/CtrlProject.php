<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlProject extends SqlControleur
{
    var $conn;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
        $this->conn = new mysqli($servername, $username,$password, $dbname);
        echo $this->executeQueryFile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createProjectTable.sql');
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function checkConnection()
    {
        return $this->conn->connect_error;
    }

    function updateProject($id, $project_name, $link_repository, $product_owner)
    {
        $sql = "UPDATE Project SET project_name='".$project_name."', link_repository='".$link_repository."', product_owner='".$product_owner."' WHERE project_id=".$id;
        $res=$this->conn->query($sql);
        return $res;
    }

    function updateProjectWithoutPO($id,$project_name,$link_repository,$description)
    {
	$sql = "UPDATE Project SET project_name='".$project_name."', link_repository='".$link_repository."', description='".$description."' WHERE project_id=".$id;
        $res=$this->conn->query($sql);
        return $res;
    }

    function createProject($name, $link, $owner)
    {
        $sql = "INSERT INTO Project (project_name, link_repository, product_owner) VALUES ('".$name."', '".$link."', ".$owner.");";
        $res = $this->conn->query($sql);
        return $res;
    }

    function getProject($id)
    {
        $sql = "SELECT * FROM Project WHERE project_id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function listAll($howmany)
    {
	$sql = "SELECT * FROM Project LIMIT 0 ,".$howmany;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getId($name)
    {
	$sql = "SELECT project_id FROM Project WHERE project_name='".$name."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function getProductOwner($project_id)
    {
	$sql = "SELECT login, mail FROM ((SELECT * FROM Project WHERE project_id=".$project_id.") AS t) INNER JOIN User On product_owner=dev_id";
	$res = $this->conn->query($sql);
	return $res;
    }

    function getIDProductOwner($project_id)
    {
	$sql = "SELECT * FROM User WHERE dev_id IN (SELECT product_owner FROM Project WHERE project_id=".$project_id.")";
	$res = $this->conn->query($sql);
	return $res;
    }

    function deleteProject($id)
    {
        $sql = "DELETE FROM Project WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function addProductOwner($id, $productowner_id)
    {
        $sql="UPDATE Project SET product_owner ='".$productowner_id."' WHERE project_id='".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function changeSprintDuration($projcet_id,$value)
    {
	$sql = "UPDATE Project SET sprint_duration='".$value."' WHERE project_id='".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }

    function getSprintDuration($project_id)
    {
	$sql = "SELECT sprint_duration FROM Project WHERE project_id=".$project_id;
	$res = $this->conn->query($sql);
	return $res;
    }
}
?>
