<?php
class CtrlUser extends SqlControleur
{
    var $conn;

    function __construct($servername, $username, $password, $dbname)
    {
        if(executeQueryFile('../sql/createUser.sql'))
            {
                $this->conn = new sqli($servername, $username, $password, $dbname);
            }
        else
            {
                echo 'ERROR executing query when creating User table';
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

    function updateUser($id, $login, $mdp, $mail)
    {
        $sql = "UPDATE User SET login='".$login."', mdp='".$mdp."', mail='".$mail."' WHERE id=".$id;
        $res=$this->conn->query($sql);
        return $res;
    }

    function createUser($login, $mdp, $mdp)
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

    function deleteUser($id)
    {
        $sql = "DELETE FROM ".$table." WHERE id=".$id;
        $res = $this->conn->query($sql);
        return $res;
    }
}
?>