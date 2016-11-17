<!-- MODAL DELETING CONTRIBUTORS -->
<div class="modal fade" id="modalPriority" tabindex="-1" role="dialog" aria-labelledby="modalPriorityLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalPriority">Choose the contributor to remove</h4>
	    </div>
	    <form action="http://localhost:8000/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
		<div class="modal-body">
		    <div class="list-group" >
			<?php
            global $ctrlBacklog;
			global $project_id;
			$usersIn = $ctrlParticipates->getUserWhichContributes($project_id);
			$line;
			
			while($line = $usersIn->fetch_assoc())
			{
			    if($line['login'] != $_SESSION['login'])
			    {
				echo '<div class="list-group-item">';
				echo '<div class="checkbox">';
				echo '<label for="'.$line['login'].'">';
				echo '<input type="checkbox" name="'.$line['login'].'" value="YES">';
				echo $line['login'].'</label>'; 
				echo '</div></div>';
			    }
			}
			
			?>
			
		    </div>
		</div>
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="mailSubmit" role="button" class="btn btn-primary" value="Priority them"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
