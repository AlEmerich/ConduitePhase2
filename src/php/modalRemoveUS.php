<!-- MODAL REMOVING US FROM SPRINT -->
<div class="modal fade" id="modalRemoveUS" tabindex="-1" role="dialog" aria-labelledby="modalRemoveUSLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalRemoveUS">Choose the User Story to remove</h4>
	    </div>
	    <form action="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/addRemoveUSFromSprint.php?sprint_id=<?php global $sprint_id; echo $sprint_id; ?>&project_id=<?php global $project_id; echo $project_id; ?>&tab=0" class="list-group" method="post">
		<div class="modal-body">
		    <div class="list-group" >
			<?php
			global $project_id;
			global $ctrlRel;
			global $sprint_id;
			global $ctrlBacklog;
			$us = $ctrlRel->getUSrelated($project_id,$sprint_id);
			$line;
			
			while($line = $us->fetch_assoc())
			{
			    echo '<div class="list-group-item">';
			    echo '<div class="checkbox">';
			    echo '<label for="'.$line['us_id'].'">';
			    echo '<input type="checkbox" name="'.$line['us_id'].'" value="YES">';
			    $us_nb = $ctrlBacklog->getUSNumberWithID($line['us_id'])->fetch_assoc()['number_in_project'];
			    echo '#'.$us_nb.' User Story : '.$line['description'].'</label>'; 
			    echo '</div></div>';
			}
			
			?>
			
		    </div>
		</div>
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="USSubmit" role="button" class="btn btn-primary" value="Remove them"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
