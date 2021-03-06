<?php
global $ctrlBacklog;
global $project_id;

$max = $ctrlBacklog->getNumberOfUS($project_id);
$num = 0;
while($num++ < $max) :
?>
    <!-- MODAL MODIFY USER STORY -->
    <?php
    global $num;
    $us = $ctrlBacklog->getUserStoryWithNumberInProject($num,$project_id)->fetch_assoc();
    global $inputDescription, $inputCommit, $inputEffort, $inputPriority;
    $inputDescription = $us['description'];
    $inputCommit = $us['commit'];
    $inputEffort = $us['effort'];
    $inputPriority = $us['priority'];
    ?>
    <div class="modal fade" id="modalUS<?php global $num; echo $num; ?>" tabindex="-1" role="dialog" aria-labelledby="modalUSLabel">
	<div class="modal-dialog" role="document">
	    <div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h4 class="modal-title" id="modalUSTitle">User Story #<?php global $num; echo $num; ?></h4>
		</div>
		<form action="<?php echo $GLOBALS['SITE_ROOT']; ?>/php/backlog.php?project_id=<?php global $project_id; echo $project_id; ?>"
		      class="list-group" method="post">
		    <div class="modal-body">
			<div class="form-group">
			    <label for="inputDescription">UserStory description</label>
			    <input name="inputDescription" type="text"
				   class="form-control" value="<?php global $inputDescription; echo $inputDescription; ?>" />
			</div>

			<div class="form-group">
			    <label for="inputEffort">Select Effort:</label>
			    <select name="inputEffort" class="form-control" >
				<?php
				global $inputEffort;
				$antelast = $last = 1;
				echo '<option '.($inputEffort == 1 ? 'selected="true"' : '').'>1</option>';
				$fibo =0;
				while($fibo < 100)
				{
				    $fibo = $antelast + $last;
				    echo '<option '.($inputEffort == $fibo ? 'selected="true"' : '').'>'.$fibo.'</option>';
				    $antelast = $last;
				    $last = $fibo;
				}
				?>
			    </select>
			</div>

			<div style="display:none" class="form-group">
			    <label for="nbid" ></label>
			    <input type="text" name="nbid" value="<?php global $num; echo $num; ?>">
			</div>

			<div class="form-group">
			    <label for="inputCommit">Checksum commit</label>
			    <input name="inputCommit" type="text"
				   class="form-control" value="<?php global $inputCommit; echo $inputCommit; ?>" />
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
