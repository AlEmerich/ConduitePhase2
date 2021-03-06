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
	    $ctrlP = new CtrlParticipates();
	    $ctrlU = new CtrlUser();
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

	    echo '<div class="panel-body" id="toToggleIn">';
	    $res = $ctrlU->getID($_SESSION['login'])->fetch_assoc();
	    if($projects = $ctrlP->listIn($res['dev_id']))
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
		    $po = $ctrlU->getUser($line['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div></div>';
	    
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
	    echo '<div class="panel-body" id="toToggleNotIn">';

	    $in = $ctrlP->listIn($res['dev_id']);
	    $notin = $ctrlP->listNotIn($res['dev_id']) ;
	    while($resassoc = $notin->fetch_assoc())
	    {
		$toAdd = true;
		$line;

		while($toAdd && $line = $in->fetch_assoc())
		{
		    if($resassoc['project_id'] == $line['project_id'])
			$toAdd = false;
		}

		$in->data_seek(0);
		if($toAdd)
		{
		    echo '<div class="panel panel-default">';
		    echo '<div class="panel-heading">';
		    echo '<a href="http://localhost:8000/php/homeProject.php?project_id='.$resassoc['project_id'].'">';
		    
		    echo '<h4>'.$resassoc['project_name'].'</h4></a></div>';
		    echo '<div class="panel-body"><p> '.$resassoc['description'].'</br>';
		    echo '<b>Link repository:</b> '.$resassoc['link_repository'].'</br>';
		    $po = $ctrlU->getUser($resassoc['product_owner'])->fetch_assoc();
		    echo '<b>Product owner:</b> '.$po['login'].'</p>';
		    echo '</div></div>';
		}
	    }
	    echo '</div></div>';
	    
	    ?>
	    
	</div>
    </div>
</div>
