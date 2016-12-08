
    <nav class="navbar navbar-fixed-top" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="http://localhost:8000/index.php">ScrumTool</a>
	</div>

	<?php include 'topmenu.php'; ?>
	<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
	<div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
		<li class="active">
                    <a href="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/homeProject.php"><i class="fa fa-fw fa-desktop"></i> Home Project</a>
		</li>
		<li>
                    <a href="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/backlog.php"><i class="fa fa-fw fa-table"></i> Backlog</a>
		</li>
		<li>
                    <a href="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/sprint.php"><i class="fa fa-fw fa-dashboard"></i> Sprints</a>
		</li>
		<li>
                    <a href="<?php echo $GLOBAL['SITE_ROOT']; ?>/php/curve.php"><i class="fa fa-fw fa-bar-chart-o"></i> Velocity Curve</a>
		</li>
            </ul>
	</div>
	<!-- /.navbar-collapse -->
    </nav>
