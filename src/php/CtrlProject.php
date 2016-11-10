<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlProject extends SqlControleur
{
    var $conn;

    function __construct($servername, $username, $password, $dbname)
    {
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
        $sql = "UPDATE User SET project_name='".$project_name."', link_repository='".$link_repository."', product_owner='".$product_owner."' WHERE id=".$id;
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
        $sql = "SELECT * FROM Project WHERE id=".$id;
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

    function deleteProject($id)
    {
        $sql = "DELETE FROM Project WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function addProductOwner($id, $productowner_id)
    {
        $sql="UPDATE Project SET product_owner ='".$produtowner_id."' WHERE project_id IS '".$id."'";
        $res = $this->conn->query($sql);
        return $res;
    }
}
?>
