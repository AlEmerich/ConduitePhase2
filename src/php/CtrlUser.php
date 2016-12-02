<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');

class CtrlUser extends SqlControleur
{
    var $conn;

    function __construct()
    {
	$ctp = func_num_args();
	$args = func_get_args();
	$this->conn = $this->connect($ctp,$args);
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

    function getMail($login)
    {
	$sql = "SELECT mail FROM User WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }

    function loginExist($login)
    {
	$sql = "SELECT * FROM User WHERE login='".$login."'";
	$result = $this->conn->query($sql);
	echo $this->conn->error;
	return $result;  
    }

    function mailExist($mail)
    {
	$sql = "SELECT * FROM User WHERE mail='".$mail."'";
	$result = $this->conn->query($sql);
	return $result;  
    }

    function updateUser($id, $login, $mdp, $mail,$url)
    {
        $sql = "UPDATE User SET login='".$login."', mdp='".$mdp."', mail='".$mail."', picture='".$url."' WHERE dev_id=".$id;
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
        $sql = "SELECT * FROM User WHERE dev_id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }

    function getID($login)
    {
        $sql = "SELECT dev_id FROM User WHERE login='".$login."'";
        $res = $this->conn->query($sql);
        return $res;
    }

    function getPicture($login)
    {
	$sql = "SELECT picture FROM User WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function changeLogin($login,$new_login)
    {
	$sql = "UPDATE User SET login='".$new_login."' WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }

    function changeMail($login,$new_mail)
    {
	$sql = "UPDATE User SET mail='".$new_mail."' WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }

    function changePicture($login,$new_picture)
    {
	$sql = "UPDATE User SET picture='".$new_picture."' WHERE login='".$login."'";
	$res = $this->conn->query($sql);
	return $res;
    }
    
    function deleteUser($id)
    {
        $sql = "DELETE FROM User WHERE dev_id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }
}
?>
