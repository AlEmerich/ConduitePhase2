<?php
class CtrlProject extends SqlControleur
{
    var $conn;

    function __construct($servername, $username, $password, $dbname)
    {
        if(executeQueryFile('../sql/createProjectTable.sql'))
            {
                $this->conn = new sqli($servername, $username, $password, $dbname);
            }
        else
            {
                echo 'ERROR executing query when creating Project table';
            }
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
        $sql = "INSERT INTO Project (project_name, link_repository, product_owner) VALUES ('".$name."', '".$link."', '".$owner."');";
        $res = $this->conn->query($sql);
        return $res;
    }

    function getProject($id)
    {
        $sql = "SELECT * FROM Project WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function deleteProject($id)
    {
        $sql = "DELETE FROM Project WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }
}
?>