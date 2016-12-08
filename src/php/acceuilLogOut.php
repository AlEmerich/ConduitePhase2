<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlProject.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/php/CtrlUser.php');
?>

<div class="container-fluid">	      
    <div class="row" >
	
	<div class="well col-lg-12
		    col-md-12
		    col-xs-12" id="welcome" >
	    Welcome, Visitor
	    
	</div>

	<div class="panel-group col-lg-12
		    col-md-12
		    col-xs-12">
	    <?php
	    $ctrlProject = new CtrlProject();
	    $ctrlUser = new CtrlUser();
	    echo '<div class="panel panel-primary">';
	    echo '<div class="panel-heading">
                      <div class="row">
                          <div class="col-lg-4 col-md-4 col-xs-4">
                               <h3>Existing project</h3>
                          </div>
                      <div class="col-lg-offset-6 col-lg-2 col_md-offset-6 col-md-2 col-xs-offset-6col-xs-2">
                          <button type="button" class="btn btn-secondary pull-right" id="buttonToToggleAll">
                              <i class="fa fa-fw fa-toggle-up blackicon" id="toggleiconall"></i>
                          </button>
                      </div>
                  </div></div>';
	    echo '<div class="panel-body" id="toToggleAll">';
	    if($projects = $ctrlProject->listAll(10))
	    {
		$line;
		while($line = $projects->fetch_assoc())
		{
		    
		    echo '<div class="panel panel-default">';
		    echo '<div class="panel-heading">';
		    echo '<a href="'.$GLOBALS['SITE_ROOT'].'/php/homeProject.php?project_id='.$line['project_id'].'">';
		    
		    echo '<h4>'.$line['project_name'].'</h4></a></div>';
		    echo '<div class="panel-body"><p> '.$line['description'].'</br>';
		    echo '<b>Link repository:</b> '.$line['link_repository'].'</br>';
		    $po = $ctrlUser->getUser($line['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div></div>';
	    ?>
	</div>
    </div>
</div>
