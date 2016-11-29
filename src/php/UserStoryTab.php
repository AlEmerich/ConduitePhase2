<div class="col-lg-12 col-md-12 col-xs-12 table-responsive">
    <table class="table" >
	<caption>User Story related to the sprint</caption>
	<thead>
	    <th>#</th>
	    <th>Description</th>
	</thead>
	<tbody>
	    <?php
	    global $project_id;
	    global $ctrlRel;
	    global $sprint_id;
	    $us = $ctrlRel->getUSrelated($project_id,$sprint_id);
	    $line;
	    while($line = $us->fetch_assoc())
	    {
		echo '<tr>';
		echo '<td>'.$line['number_in_project'].'</td>';
		echo '<td>'.$line['description'].'</td>';
		echo '</tr>';
	    }
	    ?>
	</tbody>
    </table>


    <?php global $logged; if ($logged) : ?>		
	<a role="button" href="#"
	   class="btn btn-primary 
		  col-lg-3 col-lg-offset-1
		  col-sm-3 col-sm-offset-1
		  col-md-3 col-md-offset-1
		  col-xs-3 col-xs-offset-1"
	   id="addUS" data-toggle="modal"
	   data-target="#modalAddUS">Add US</a>
	
	<a role="button" href="#" 
	   class="btn btn-primary 
		  col-lg-3 col-lg-offset-1
		  col-md-3 col-sm-offset-1
		  col-sm-3 col-md-offset-1
		  col-xs-3 col-xs-offset-1" 
	   id="deleteUS" data-toggle="modal"
	   data-target="#modalRemoveUS" >Remove US</a>
    <?php endif ?>

</div>
