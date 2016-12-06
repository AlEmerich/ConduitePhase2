<!-- MODAL DELETING CONTRIBUTORS -->
<div class="modal fade" id="modalRemove" tabindex="-1" role="dialog" aria-labelledby="modalRemoveLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <?php
	    $ctrlParticipates = new CtrlParticipates();
	    global $project_id;
	    
	    if($ctrlParticipates->getNumberOfContributor($project_id) == 1) : 
	    ?>
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="modalRemove">CAREFULL</h4>
		</div>
		<form action="http://localhost:8000/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
		    <div class="modal-body">
			You are the last contributor on this project. Removing yourself as a contributor will delete all the project and its components. Are you
			sure you want to delete it ?
		    </div>
		    <div class="modal-footer">
			<a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
			<input type="submit" role="button" class="btn btn-primary" name="mailSubmit" value="Remove project"></input>
		    </div>
		    
		    <?php else: ?>

		    
		    <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="modalRemove">Choose the contributor to remove</h4>
		    </div>
		    <form action="http://localhost:8000/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
			<div class="modal-body">
			    <div class="list-group" >
				<?php
				global $ctrlUser;
				global $ctrlParticipates;
				global $project_id;
				global $ctrlProject;
				$usersIn = $ctrlParticipates->getUserWhichContributes($project_id);
				$po_total = $ctrlProject->getIDProductOwner($project_id)->fetch_assoc()['product_owner'];
$po = $ctrlUser->getLogIn($po_total)->fetch_assoc()['login'];
$line;
				
				while($line = $usersIn->fetch_assoc())
				{
				    if($logged && $line['login'] != $po)
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
			    <input type="submit" role="button" class="btn btn-primary" name="mailSubmit" value="Remove them"></input>
			</div>

	    <?php endif ?>
		    </form>
		
	</div>
    </div>
</div>
