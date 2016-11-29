<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
    <table class="table" >
	<caption>Tasks related to the sprint</caption>
	<thead>
	    <tr>
		<?php global $logged; if($logged) : ?>
		    <th></th>
		<?php endif ?>
		<th>#</th>
		<th>Description</th>
		<th>Costs</th>
		<th>Related US</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    global $project_id;
	    global $sprint_id;
	    global $ctrlTask;
	    global $ctrlRelUS;

	    $tasks = $ctrlTask->getTasksFromSprint($project_id,$sprint_id);
	    $line;
	    while($line = $tasks->fetch_assoc())
	    {
		echo '<tr>';
		if($logged)
		{
		    echo '<td><a class="btn btn-default"
                              style="padding-top:1px;padding-bottom:1px;padding-left:3px;padding-right:3px"
	                      href="#" role="button" id="changeTasks"
                              data-toggle="modal" data-target="#modalTask'.$line['number_task'].'">
			      <i class="fa fa-pencil-square-o" aria-hidden="true">
						          </i>
					              </a></td>';
		}
		echo '<td>'.$line['number_task'].'</td>';
		echo '<td>'.$line['description'].'</td>';
		echo '<td>'.$line['cost'].'</td>';

		$us = $ctrlRelUS->getUSrelated($line['task_id'])->fetch_assoc();
		echo '<td><a href="#" data-toggle="tooltip" data-placement="top" title="'.$us['description'].'">'.$us['number_in_project'].'</a></td>';
		echo '</tr>';
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
		      echo htmlspecialchars($_SERVER["PHP_SELF"]).'?project_id='.$project_id.'&sprint_id='.$sprint_id.'&tab=2'; ?>">
	    <legend class="title">Create Task</legend>
	    
	    <div class="form-group">
		<label for="inputDescription">Task description</label>
		<span class ="error">* <?php global $descriptionErr; echo $descriptionErr; ?></span>
		<textarea name="inputDescription" type="text"
			  class="form-control" value="<?php global $inputDescription; echo $inputDescription; ?>"></textarea>
	    </div>

	    <div class="form-group">
		<label for="inputCost">Cost</label>
		<span class ="error">* <?php global $costErr; echo $costErr; ?></span>
		<input name="inputCost" type="text"
		       class="form-control" value="<?php global $inputCost; echo $inputCost; ?>" />
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
			echo '<option value="'.$us_nb.'">US#'.$us_nb.': '.$line['description'].'</option>';
		    }
		    ?>
		</select>
	    </div>

	    <input name="createTask" type="submit" value="Create" />
	</form>
    <?php endif ?>
</div>
