<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/php/SqlControleur.php');
include 'config.php';

class CtrlBacklog extends SqlControleur{
    var $connBacklog;

    function __construct()
    {
	global $servername,$username,$password,$dbname;
        $this->connBacklog = new mysqli($servername, $username, $password, $dbname);
        
        echo $this->executeQueryFile($this->connBacklog,$_SERVER['DOCUMENT_ROOT'].'/sql/createUserStory.sql');
    }

    function __destruct()
    {
        $this->connBacklog->close();
    }

    function checkConnection()
    {
        return $this->connBacklog->connect_error;
    }

    function updateUserStory($us_id,$num_in_pro, $project_id, $description, $effort, $priority){
        $sql =  "UPDATE UserStory SET number_in_project='".$num_in_pro."' project_id ='".$project_id."', description ='".$description."', effort ='".$effort."', priority ='".$priority."' WHERE us_id =".$us_id;
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function updateUserStoryEffortDesc($us_id, $description, $effort){
        $sql =  "UPDATE UserStory SET description ='".$description."', effort ='".$effort."' WHERE us_id =".$us_id;
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function createUserStory($num_in_pro,$project_id, $description, $effort, $priority){
        $sql =  "INSERT INTO UserStory (number_in_project,project_id, description, effort, priority) VALUES ('".$num_in_pro."','".$project_id."','".$description."','".$effort."','".$priority."');";
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function getUserStory($us_id){
        $sql = "SELECT * FROM UserStory WHERE us_id=".$us_id;
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function deleteUserStory($us_id){
        $sql = "DELETE FROM UserStory WHERE us_id=".$us_id;
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function getUserStoryFromProject ($project_id){
        $sql = "SELECT * FROM UserStory WHERE project_id =".$project_id;
        $res = $this->connBacklog->query($sql);
        return $res;
    }

    function getNumberOfUS($project_id)
    {
	$res = $this->getUserStoryFromProject($project_id);
	$num = 0;
	while($res->fetch_assoc())
	    $num++;
	return $num;
    }

    function changePriority($us_id, $new_priority)
    {
        $sql = "UPDATE UserStory SET priority='".$new_priority."' WHERE us_id=".$us_id;
        $res = $this->connBacklog-> query($sql);
        return $res;
    }

    function getUserStoryWithNumberInProject($num_in_project,$project_id)
    {
	$sql = "SELECT * FROM UserStory WHERE project_id=".$project_id." AND number_in_project=".$num_in_project;
	$res = $this->connBacklog->query($sql);
	return $res;
    }
}

?>
