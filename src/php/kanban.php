<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <table class="table" >
	<caption>Drag and drop to move tasks</caption>
	<thead>
	    <tr>
		<th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">TO DO</th>
		<th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">ON GOING</th>
		<th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">DONE</th>
	    </tr>
	</thead>
	<tbody>
	    <?php
	    global $project_id;
	    global $sprint_id;
	    global $ctrlTask;
	    global $ctrlRelUS;
	    global $ctrlKanban;

	    $tasks = $ctrlTask->getTasksFromSprint($project_id,$sprint_id);
	    $line;
	    $y = 0;
	    while($line = $tasks->fetch_assoc())
	    {
		$info = $ctrlKanban->getInfo($line['task_id'])->fetch_assoc();
		$array = array('', 'class="danger"', 'class="success"');

		echo '<tr id="limitdrag" '.$array[$info['state']].'>';
		for($i=0;$i<=2;$i++)
		{
		    if($info['state'] == $i)
		    {
			echo '<td class="tdcard">';
			echo '  <div id="td'.$y.''.$i.'"  class="card event" draggable="true">
                                  <div class="card-block">
                                      <h4 class="card-title"><b>Task '.$line['number_task'].'</b></h4>
                                      <p class="card-text">'.$line['description'].'</p>
			        </div>';
			echo '</div></td>';
		    }
		    else
			echo '<td id="td'.$y.''.$i.'" class="tdcard"></td>';
		}
		echo '</tr>';
		$y = $y + 1;
	    }
	    ?>
	</tbody>
    </table>
</div>
