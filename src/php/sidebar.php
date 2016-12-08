<?php
function getdropdownsprint($project_id)
{
    global $ctrlS;
    $htmlstring = '<ul id="ulsprints" class="dropdown-menu">';
    $sprints = $ctrlS->getSprintFromProject($project_id);
    $sprint;
    while($sprint = $sprints->fetch_assoc())
    {
	$htmlstring = $htmlstring.'<li ><a href="'.$GLOBAL['SITE_ROOT'].'"/php/sprintSingle.php?project_id='.$project_id.'&sprint_id='.$sprint['sprint_id'].'">Sprint '.$sprint['number_sprint'].'</a></li>';
    }
    $htmlstring = $htmlstring.'</ul>';
    return $htmlstring;
}

function setActiveOrNot($li)
{
    global $whatfile;
    if($li == $whatfile)
	return ' class="active" ';
    else
	return '';
}
?>

<div class="collapse navbar-collapse navbar-ex1-collapse">
    <ul class="nav navbar-nav side-nav">
	<li <?php echo setActiveOrNot("homeproject"); ?> >
	    <a href="<?php echo $GLOBAL['SITE_ROOT'];?>/php/homeProject.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-desktop"></i> Home Project</a>
	</li>
	
	<li <?php echo setActiveOrNot("backlog"); ?>>
	    <a href="<?php echo $GLOBAL['SITE_ROOT'];?>/php/backlog.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-table"></i> Backlog</a>
	</li>
	
	<li id="lisprint" <?php echo setActiveOrNot("sprint"); ?>>
	    <a href="<?php echo $GLOBAL['SITE_ROOT'];?>/php/sprint.php?project_id=<?php global $project_id; echo $project_id; ?>" role="button">
		<button id="sprintsmenu" type="button" class="btn"><i class="fa fa-fw fa-dashboard"></i> Sprints
		</button>
	    </a>
	    <button id="ddl" type="button" class=" btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<span class="caret"></span>
		<span class="sr-only">Toggle Dropdown</span>
	    </button>
	    <?php echo getdropdownsprint($_GET['project_id']); ?>
	</li>
	
	<li <?php echo setActiveOrNot("curve"); ?>> 
	    <a href="<?php echo $GLOBAL['SITE_ROOT'];?>/php/curve.php?project_id=<?php global $project_id; echo $project_id; ?>"><i class="fa fa-fw fa-area-chart"></i> Velocity Curve</a>
	</li>
    </ul>
</div>
