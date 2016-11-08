<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlUser extends SqlControleur
{
    var $conn;

    function __construct($servername, $username, $password, $dbname)
    {
        $this->conn = new mysqli($servername, $username, $password, $dbname);
        
        echo $this->executeQueryFile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/createUserTable.sql');
    }

    function __destruct()
    {
        $this->conn->close();
    }

    function checkConnection()
    {
        return $this->conn->connect_error;
    }

    
    function getPassword($login)
    {
	$sql = "SELECT mdp FROM User WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }

    function getMail($mdp)
    {
	$sql = "SELECT mail FROM User WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function loginExist($login)
    {
	$sql = "SELECT * FROM User WHERE login='".$login."'";
	$result = $this->conn->query($sql);
	return $result;  
    }

    function mailExist($mail)
    {
	$sql = "SELECT * FROM User WHERE mail='".$mail."'";
	$result = $this->conn->query($sql);
	return $result;  
    }

    function updateUser($id, $login, $mdp, $mail)
    {
        $sql = "UPDATE User SET login='".$login."', mdp='".$mdp."', mail='".$mail."' WHERE id=".$id;
        $res=$this->conn->query($sql);
        return $res;
    }

    function createUser($login, $mdp, $mail)
    {
        $sql = "INSERT INTO User (login, mdp, mail) VALUES ('".$login."', '".$mdp."', '".$mail."');";
        $res = $this->conn->query($sql);
        return $res;
    }

    function getUser($id)
    {
        $sql = "SELECT * FROM User WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function getID($login)
    {
        $sql = "SELECT id FROM User WHERE login='".$login."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function deleteUser($id)
    {
        $sql = "DELETE FROM User WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }
}
?>
