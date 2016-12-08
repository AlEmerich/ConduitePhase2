<!-- MODAL INVITING CONTRIBUTORS -->
<div class="modal fade" id="modalInvite" tabindex="-1" role="dialog" aria-labelledby="modalInviteLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalInvite">Choose the new contributor</h4>
	    </div>
	    <form action="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
		<div class="modal-body">
		    <div class="list-group" >
			<?php
			global $ctrlUser;
			global $ctrlParticipates;
			global $project_id;
			$usersNotIn = $ctrlParticipates->getUserWhichNotContributes($project_id);
			$line;
			
			while($line = $usersNotIn->fetch_assoc())
			{
			    echo '<div class="list-group-item">';
			    echo '<div class="checkbox">';
			    echo '<label for="'.$line['login'].'">';
			    echo '<input class="pull-right" type="checkbox" name="'.$line['login'].'" value="YES"/>';
			    echo $line['login'].'</label>';
			    echo '</div></div>';
			}
			
			?>
			
		    </div>
		</div>
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="mailSubmit" role="button" class="btn btn-primary" value="Send invitations"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
