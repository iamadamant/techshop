<div class="account bg-dark row" style="width: 200px;padding: 5px;">
	<div class="col-lg-6">
		<img src="img/account.png" >
	</div>
	<div class="col-lg-6">
		<h3 class="text-white">
		<?php 
		session_start();
			echo $_SESSION['user'];
		 ?>
		</h3>
		<a href="index.php?target=exit" class="text-danger">Exit</a>
	</div>
	
	
</div>
 
  