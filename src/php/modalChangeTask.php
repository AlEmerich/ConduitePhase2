<?php
global $ctrlTask;
global $project_id;
global $sprint_id;

$max = $ctrlTask->getNumberOfTask($project_id,$sprint_id);
$num = 0;
while($num++ < $max) :
?>
    <!-- MODAL MODIFY TASK -->
    <div class="modal fade" id="modalTask<?php global $num; echo $num; ?>" tabindex="-1" role="dialog" aria-labelledby="modalTaskLabel">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="modalTaskTitle">Task #<?php global $num; echo $num; ?></h4>
		</div>
		<form action="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/sprintSingle.php?project_id=<?php global $project_id; echo $project_id; ?>&sprint_id=<?php global $sprint_id; echo $sprint_id; ?>&tab=2"
		      class="list-group" method="post">
		    <div class="modal-body">
			<div class="form-group">
			    <label for="inputDescription">Task description</label>
			    <textarea name="inputDescription" type="text"
				   class="form-control" value="
                                   <?php 
				   global $num; global $ctrlTask; global $project_id; global $sprint_id;
				   echo test_input($ctrlTask->getTaskWithNumber($num,$project_id,$sprint_id)->fetch_assoc()['description']); ?>">
			    </textarea>
			</div>

			<div class="form-group">
			    <label for="inputCost">Select cost:</label>
			    <input name="inputCost" type="text"
				   class="form-control" value="
                                   <?php 
				   global $num; global $ctrlTask; global $project_id; global $sprint_id;
				   echo test_input($ctrlTask->getTaskWithNumber($num,$project_id,$sprint_id)->fetch_assoc()['cost']); ?>" />
			</div>

			<div style="display:none" class="form-group">
			    <label for="nbid" ></label>
			    <input type="text" name="nbid" value="<?php global $num; echo $num; ?>">
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

			<div class="modal-footer">
			    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
			    <input type="submit" name="remove"
				   role="button" class="btn btn-warning" value="Remove"></input>
			    <input type="submit" name="modify"
				   role="button" class="btn btn-primary" value="Modify"></input>
			</div>
		    </div>
		</form>
	    </div>
	</div>
    </div>
<?php endwhile ?>
