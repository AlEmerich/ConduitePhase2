<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
?>


<div class="container-fluid">	      
    <div class="row" >
	
	<div class="well col-lg-12
		    col-md-12
		    col-xs-12" id="welcome" >
	    Welcome back, <?php echo $_SESSION['login']; ?>   
	</div>

	<div class="list-group col-lg-12
		    col-md-12
		    col-xs-12">
	    <?php
	    $ctrlP = new CtrlParticipates('dbserver', 'alaguitard', '11235813', 'alaguitard');
	    $ctrlU = new CtrlUser('dbserver', 'alaguitard', '11235813', 'alaguitard');
	    echo '<div class="panel panel-primary">';
	    echo '<div class="panel-heading">
                      <div class="row">
                          <div class="col-lg-4 col-md-4 col-xs-4">
                               <h3>Project you are contributing</h3>
                          </div>
                      <div class="col-lg-offset-6 col-lg-2 col_md-offset-6 col-md-2 col-xs-offset-6col-xs-2">
                          <button type="button" class="btn btn-secondary pull-right" id="buttonToToggleIn">
                              <i class="fa fa-fw fa-toggle-up blackicon" id="toggleiconin"></i>
                          </button>
                      </div>
                  </div></div>';
	    
	    $res = $ctrlU->getID($_SESSION['login'])->fetch_assoc();
	    if($projects = $ctrlP->listIn($res['id']))
	    {
		$line;
		while($line = $projects->fetch_assoc())
		{
		    
		    echo '<div class="panel panel-default" id="toToggleIn">';
		    echo '<div class="panel-heading">';
		    echo '<a href="http://localhost:8000/php/homeProject.php?project_id='.$line['project_id'].'">';	    
		    echo '<h4>'.$line['project_name'].'</h4></a></div>';
		    echo '<div class="panel-body"><p> '.$line['description'].'</br>';
		    echo '<b>Url du dépôt:</b> '.$line['link_repository'].'</br>';
		    $po = $ctrlU->getUser($line['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div>';
	    
	    echo '<div class="panel panel-primary">';
	    echo '<div class="panel-heading">
                      <div class="row">
                          <div class="col-lg-4 col-md-4 col-xs-4">
                               <h3>Other project</h3>
                          </div>
                      <div class="col-lg-offset-6 col-lg-2 col_md-offset-6 col-md-2 col-xs-offset-6col-xs-2">
                          <button type="button" class="btn btn-secondary pull-right" id="buttonToToggleNotIn">
                              <i class="fa fa-fw fa-toggle-up blackicon" id="toggleiconnotin"></i>
                          </button>
                      </div>
                  </div></div>';
	    if($projects = $ctrlP->listNotIn($res['id']))
	    {
		$line;
		while($line = $projects->fetch_assoc())
		{
		    
		    echo '<div class="panel panel-default" id="toToggleNotIn">';
		    echo '<div class="panel-heading">';
		    echo '<a href="http://localhost:8000/php/homeProject.php?project_id='.$line['project_id'].'">';
		    
		    echo '<h4>'.$line['project_name'].'</h4></a></div>';
		    echo '<div class="panel-body"><p> '.$line['description'].'</br>';
		    echo '<b>Url du dépôt:</b> '.$line['link_repository'].'</br>';
		    $po = $ctrlU->getUser($line['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div>';
	    
	    ?>
	    
	</div>
    </div>
</div>
