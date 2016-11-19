
<!-- MODAL MODIFY URL IMAGE -->
<div class="modal fade" id="modalPicture" tabindex="-1" role="dialog" aria-labelledby="modalPictureLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalPictureTitle">Put an image link:</h4>
	    </div>
	    <form action="http://localhost:8000/index.php"
		  class="list-group" method="post">
		<div class="modal-body">
		    <div class="form-group">
			<label for="urlimage">Url:</label>
			<input name="urlimage" type="text" class="form-control" value="<?php echo $_SESSION['picture']; ?>" />
		    </div>
		</div>
		
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="confirmPicture"
			   role="button" class="btn btn-primary" value="Confirm"></input>
		</div>
	    </form>
	</div>
    </div>
</div>

<!-- MODAL MODIFY MAIL -->
<div class="modal fade" id="modalMail" tabindex="-1" role="dialog" aria-labelledby="modalMailLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalPictureTitle">Put a new mail:</h4>
	    </div>
	    <form action="http://localhost:8000/index.php"
		  class="list-group" method="post">
		<div class="modal-body">
		    <div class="form-group">
			<label for="mail">Mail:</label>
			<input name="mail" type="email" class="form-control" value="<?php echo $_SESSION['mail']; ?>" />
		    </div>
		</div>
		
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="confirmMail"
			   role="button" class="btn btn-primary" value="Confirm"></input>
		</div>
	    </form>
	</div>
    </div>
</div>

<!-- MODAL MODIFY LOGIN -->
<div class="modal fade" id="modalLogin" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel">
    <div class="modal-dialog" role="document">
	<div class="modal-content">
	    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="modalLoginTitle">Put a new login:</h4>
	    </div>
	    <form action="http://localhost:8000/index.php"
		  class="list-group" method="post">
		<div class="modal-body">
		    <div class="form-group">
			<label for="login">Login:</label>
			<input name="login" type="text" class="form-control" value="<?php echo $_SESSION['login']; ?>" />
		    </div>
		</div>
		
		<div class="modal-footer">
		    <a role="button" class="btn btn-default" data-dismiss="modal">Close</a>
		    <input type="submit" name="confirmLogin"
			   role="button" class="btn btn-primary" value="Confirm"></input>
		</div>
	    </form>
	</div>
    </div>
</div>
