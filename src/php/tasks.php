<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlTask.php');
$ctrlTask = new CtrlTask();

?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
    <table class="table" >
	<caption>Tasks related to the sprint</caption>
	<thead>
	    <th>#</th>
	    <th>Description</th>
	    <th>Costs</th>
	</thead>
	<tbody>
	    <?php
	    global $project_id;
	    global $sprint_id;
	    global $ctrlTask;

	    $tasks = $ctrlTask->getTasksFromSprint($project_id,$sprint_id);
	    $line;
	    while($line = $tasks->fetch_assoc())
	    {
		echo '<td>'.$line['number_task'].'</td>';
		echo '<td>'.$line['description'].'</td>';
		echo '<td>'.$line['cost'].'</td>';
	    }
	    ?>
	</tbody>
    </table>

    <?php global $logged; if ($logged) : ?>		
	<form class="well 
		     col-lg-offset-1 col-lg-10 
		     col-md-offset-1 col-md-10 
		     col-xs-offset-1 col-xs-10"
	      method="post"
	      action="<?php global $project_id; 
		      echo htmlspecialchars($_SERVER["PHP_SELF"]).'?project_id='.$project_id.'&sprint_id='.$sprint_id; ?>">
	    <legend class="title">Create Task</legend>
	    
	    <div class="form-group">
		<label for="inputDescription">Task description</label>
		<span class ="error">* <?php global $descriptionErr; echo $descriptionErr; ?></span>
		<textarea name="inputDescription" type="text"
			  class="form-control" value="<?php global $inputDescription; echo $inputDescription; ?>"></textarea>
	    </div>

	    <div class="form-group">
		<label for="inputEffort">Effort</label>
		<span class ="error">* <?php global $effortErr; echo $descriptionErr; ?></span>
		<input name="inputEffort" type="text"
		       class="form-control" value="<?php global $inputEffort; echo $inputEffort; ?>" />
	    </div>

	    <div class="form-group" >
		<label for="inputUS" >Related #US</label>
		
		<select name="inputUS" type="number"
class="form-control" value"<?php global $inputRelated; echo $inputRelated; ?>">
		    <?php
		    global $project_id;
		    global $sprint_id;
		    global $ctrlBacklog;
		    global $ctrlRel;
		    $us = $ctrlRel->getUSrelated($project_id,$sprint_id);
		    $line;

		    while($line = $us->fetch_assoc())
		    {
			$us_nb = $ctrlBacklog->getUSNumberWithID($line['us_id'])->fetch_assoc()['number_in_project'];
			echo '<option>US#'.$us_nb.': '.$line['description'].'</option>';
		    }
		    ?>
		</select>
	    </div>
	</form>
    <?php endif ?>
</div>
