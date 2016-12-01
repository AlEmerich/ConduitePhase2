<!-- MODAL ADD US TO SPRINT -->
<div class="modal fade" id="modalAddUS" tabindex="-1" role="dialog" aria-labelledby="modalAddUSLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalAddUS">Choose the User Story to add</h4>
	    </div>
	    <form action="http://localhost:8000/php/addRemoveUSFromSprint.php?sprint_id=<?php global $sprint_id; echo $sprint_id; ?>&project_id=<?php global $project_id; echo $project_id; ?>&tab=0" class="list-group" method="post">
		<div class="modal-body">
		    <div class="list-group" >
			<?php
			global $project_id;
			global $ctrlRel;
			global $ctrlBacklog;
			global $sprint_id;
			$backlog = $ctrlBacklog->getUserStoryFromProject($project_id);
			$line;
			while($line = $backlog->fetch_assoc())
			{
			    if(!$ctrlRel->isRelated($line['us_id'],$project_id,$sprint_id))
			    {
				echo '<div class="list-group-item">';
				echo '<div class="checkbox">';
				echo '<label for="'.$line['us_id'].'">';
				echo '<input type="checkbox" name="'.$line['us_id'].'" value="YES">';
				$us_nb = $ctrlBacklog->getUSNumberWithID($line['us_id'])->fetch_assoc()['number_in_project'];
				echo 'User Story #'.$us_nb.'</label>'; 
				echo '</div></div>';
			    }
			}
			?>
		    </div>
		</div>
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="USSubmit" role="button" class="btn btn-primary" value="Add them"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
