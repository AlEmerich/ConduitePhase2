<!-- MODAL CHANGE PRODUCT OWNER -->
<div class="modal fade" id="modalPO" tabindex="-1" role="dialog" aria-labelledby="modalPOLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalPOLabel">Choose the new product owner</h4>
	    </div>
	    <form action="http://localhost:8000/php/mail.php?project_id=<?php global $project_id; echo $project_id; ?>" class="list-group" method="post">
		<div class="modal-body">
		    <div class="list-group" >
			<?php
			global $ctrlUser;
			global $ctrlParticipates;
			global $ctrlProject;
			global $project_id;
			$usersIn = $ctrlParticipates->getUserWhichContributes($project_id);
			$po = $ctrlProject->getProductOwner($project_id)->fetch_assoc()['product_owner'];
			$product_o = $ctrlUser->getLogIn($po)->fetch_assoc();
			$line;
			
			while($line = $usersIn->fetch_assoc())
			{
			    if($line['login'] != $product_o['login'])
			    {
				echo '<div class="list-group-item">';
				echo '<div class="radio">';
				echo '<label for="'.$line['login'].'">';
				echo '<input class="pull-right" type="radio" name="optradio" value="'.$line['login'].'">';
				echo $line['login'].'</label>';
				echo '</div></div>';
			    }
			}
			
			?>
			
		    </div>
		</div>
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="mailSubmit" role="button" class="btn btn-primary" value="Change Product Owner"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
