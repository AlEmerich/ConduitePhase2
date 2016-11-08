<div class="container-fluid">	      
    <div class="row" >
	
	<div class="well col-lg-10
		    col-md-10
		    col-xs-10" id="welcome" >
	    Welcome back, <?php echo $_SESSION['login']; ?>   
	</div>

	<div class="list-group col-lg-10
		    col-md-10
		    col-xs-10">
	    <?php
	    $ctrlProject = new CtrlProject('dbserver', 'alaguitard', '11235813', 'alaguitard');
	    $ctrlUser = new CtrlUser('dbserver', 'alaguitard', '11235813', 'alaguitard');
	    echo '<div class="panel panel-primary">';
	    echo '<div class="panel-heading"> <h3>Existing project</h3> </div>';
	    if($projects = $ctrlProject->listAll(10))
	    {
		$line;
		while($line = $projects->fetch_assoc())
		{
		    
		    echo '<div class="panel panel-default">';
		    echo '<div class="panel-heading">';
		    echo '<a href="http://localhost:8000/php/homeProject.php?project_id='.$line['project_id'].'">';
		    
		    echo '<h4>'.$line['project_name'].'</h4></a></div>';
		    echo '<div class="panel-body"><p> '.$line['description'].'</br>';
		    echo '<b>Url du dépôt:</b> '.$line['link_repository'].'</br>';
		    $po = $ctrlUser->getUser($line['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div>';
	    ?>
	</div>
    </div>
</div>
