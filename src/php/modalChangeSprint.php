<?php
global $ctrlSprint;
global $project_id;

$max = $ctrlSprint->getNumberOfSprint($project_id);
$num = 0;
while($num++ < $max) :
?>
    <!-- MODAL MODIFY SPRINT -->
    <div class="modal fade" id="modalChangeSprint<?php global $num; echo $num; ?>" tabindex="-1" role="dialog" aria-labelledby="modalSprintLabel">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="modalSprintTitle">Sprint #<?php global $num; echo $num; ?></h4>
		</div>
		<form action="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/sprint.php?project_id=<?php global $project_id; echo $project_id; ?>"
		      class="list-group" method="post">
		    <div class="modal-body">
			<div class="form-group">
			    <label for="inputStart">Starting date:</label>
			    <input name="inputStart" type="text" class="datepick form-control" value="<?php global $inputStart; echo $inputStart; ?>" />
			</div>

			<div style="display:none" class="form-group">
			    <label for="nbid" ></label>
			    <input type="text" name="nbid" value="<?php global $num; echo $num; ?>">
			</div>
		    </div>

   
		    <div class="modal-footer">
			<a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
			<input type="submit" name="remove"
			       role="button" class="btn btn-warning" value="Remove"></input>
			<input type="submit" name="modify"
			       role="button" class="btn btn-primary" value="Modify"></input>
		    </div>
		</form>
	    </div>
	</div>
    </div>
<?php endwhile ?>
