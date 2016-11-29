<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlRelationUSTask extends SqlControleur
{
    var $conn;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
	$this->conn = new mysqli($servername,$username,$password,$dbname);
	echo $this->executequeryfile($this->conn,$_SERVER['DOCUMENT_ROOT'].'/sql/relationTaskUS.sql');
    }

    function __destruct()
    {
	$this->conn->close();
    }

    
}
?>
